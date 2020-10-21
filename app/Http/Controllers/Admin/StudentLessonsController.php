<?php

namespace App\Http\Controllers\Admin;

use App\Models\OnePageLevels;
use App\Helpers\AppHelper;
use App\Helpers\ZohoHelper;
use App\Models\OnePageLevelsPoints;
use App\Models\Services;
use App\Models\StudentLessons;
use App\Models\Settings;
use App\Models\StudentTransactions;
use App\Models\StudentDetail;
use App\Models\StudentPackages;
use App\Jobs\SendEmailJob;
use App\User;
use Asana\Resources\Users;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\ServicePackages;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;

class StudentLessonsController extends Controller
{
    public function index(){

        return view('admin.student-lessons.index');
    }

    public function getStudentLessons(Request $request){

        $student_lessons = DB::table('student_lessons')
            ->leftJoin('users', 'student_lessons.user_id', 'users.id')
            ->leftJoin('services', 'student_lessons.service_id', 'services.id')
            ->leftJoin('one_page_levels', 'users.student_level_id', 'one_page_levels.id')
            ->select('student_lessons.*', 'services.title as service','one_page_levels.name as level_name',
                'users.email as email',DB::raw("CONCAT(users.firstname, ' ', users.lastname) AS username"));

        return DataTables::of($student_lessons)
            ->filter(function ($query) use ($request) {
                if (!empty($request->get('student'))) {
                    $query->whereRaw("LOWER(CONCAT(users.firstname,' ',users.lastname)) like '%" . strtolower($request->get('student')) . "%'");
                }

                if (!empty($request->get('service'))) {
                    $query->whereRaw("LOWER(services.title) like '%" . strtolower($request->get('service')) . "%'");
                }
            })
            ->addIndexColumn()
            ->addColumn('case', function ($users) {
                return '<input type="checkbox" name="select" value="'.$users->id.'" onclick="checked_chkbx('.$users->id.')"  class="case" id="chk_'. $users->id .'">';
            })
            ->addColumn('action', function ($student_lessons) {
                $editButton = '';

                $editButton .= '<a href="' . route('admin.student.lessons.edit', $student_lessons->id) . '" class="btn btn-outline-info btn-rounded btn-icon edit-row" title="Edit"
                    data-toggle="tooltip" title="Edit" data-original-title="Edit"><i class="mdi mdi-pencil-box" aria-hidden="true"></i></a>';

                $editButton .= '<a id="' . $student_lessons->id . '" class="btn btn-outline-danger btn-rounded btn-icon remove-row deleteStudentLesson"
                    data-toggle="tooltip" title="Delete" data-original-title="Delete"><i class="mdi mdi-delete" aria-hidden="true"></i></a>';

                return $editButton;
            })
            ->editColumn('user_id', function ($student_lessons) {
                return (!empty($student_lessons->user_id)) ? $student_lessons->username : '--';
            })
            ->editColumn('service_id', function ($student_lessons) {
                return (!empty($student_lessons->service_id)) ? $student_lessons->service : '--';
            })
            ->editColumn('student_level_id', function ($student_lessons) {
                return (!empty($student_lessons->student_level_id)) ? $student_lessons->level_name : '--';
            })
            ->editColumn('available_bookings', function ($student_lessons) {
                return (!empty($student_lessons->available_bookings)) ? $student_lessons->available_bookings : ' 0 ';
            })
            ->editColumn('price', function ($student_lessons) {
                return (!empty($student_lessons->price)) ? $student_lessons->price : '0';
            })
            ->editColumn('start_date', function ($student_lessons) {
                return (!empty($student_lessons->start_date)) ? $student_lessons->start_date : '--';
            })
            ->editColumn('expire_date', function ($student_lessons) {
                return (!empty($student_lessons->expire_date)) ? $student_lessons->expire_date : '--';
            })->editColumn('status', function ($student_lessons) {
                if ($student_lessons->status == '1') {
                    return '<span class="badge badge-gradient-success badge-pill">Active</span>';
                } else if ($student_lessons->status == '0') {
                    return '<span class="badge badge-gradient-danger badge-pill">Inactive</span>';
                }
            })
            ->rawColumns(['case','action','status'])
            ->make(true);
    }

    public function create()
    {
        $services = Services::select('id','title')->pluck('title', 'id')
        //->where('service_type IS NULL')
        ->toArray();
        //->whereRaw('student_lessons.student_package_id IS NULL')
        return view('admin.student-lessons.create',compact('services'));
    }

    public function store(Request $request){
        $input = $request->all();

        $service = Services::where('id',$input['service_id'])
                                ->first();
        $temp = '';
        $startDate = !empty($input['start_date']) ? $input['start_date'] : date('Y-m-d', time());
        if(!empty($service->no_of_days) && ($service->no_of_days != 0)){

            $temp = date('Y-m-d', strtotime(date('Y-m-d'). '+'.$service->no_of_days.' days'));
        }else{
            $temp = date('Y-m-d', strtotime(date('Y-m-d'). '+30 days'));
        }
        $endDate = !empty($input['expire_date']) ? $input['expire_date'] : $temp;

        $studentLesson = $courseArray = [];
        $studentLesson['user_id'] = $input['user_id'];
        //$studentLesson['status'] = $input['status'];
		$input['status'] = $input['payment_status'] == 'succeeded' ? 1 : 0;
        $studentLesson['status'] = $input['payment_status'] == 'succeeded' ? 1 : 0;
        $studentLesson['service_id'] = $service->id;
        $studentLesson['available_bookings'] = $service->available_lessons;
        $studentLesson['price'] = ($service->price);
        $studentLesson['start_date'] = $startDate;
        $studentLesson['expire_date'] = $endDate;

        $student_lesson = StudentLessons::create($studentLesson);
		$student_lesson_id = $student_lesson->id;	
		$serviceTotal = $service->price;
		$courseArray[] = array('title' => $service->title, 'price' => $service->price);
		
		$student =  User::find($input['user_id']);
		
		if ($service->service_type == 'onepage') {
			$student->onepage_start_date = date('Y-m-d');
			$student->onepage_end_date = date('Y-m-d', strtotime('+1 Year'));
			$student->save();
		} else if ($service->service_type == 'registration') {
			$student->is_registerfee_paid = 1;
			$student->save();
		}
        $sprice = $service->price;
        $netAmount = $service->price;
        $tax = 0;
        $temp = 0;
        $tax = $bookingStTime = Settings::getSettings('tax');
        if(!empty($tax)){
            $temp = ($netAmount * $tax)/100;
            $netAmount = $temp + $netAmount;
        }

        $studentTransaction = [
                "user_id" => $input['user_id'],
                "provider" => 'cash',
                //"transaction_id" => $charge->balance_transaction,
                //"stripe_customer_id" => $charge->customer,
                "amount" => $netAmount,
                //"stripe_payment_method_id" => $charge->payment_method,
                "transaction_type" => "multi_service",
                "transaction_type_id" => $service->id,
                "payment_status" => $input['payment_status'],
				"student_lesson_id" => $student_lesson_id,
                //"response" => json_encode($charge),
                "discount" => 0,
                //"coupon_code" => $coupon,
                "subtotal" => $sprice,
                "one_page_fee" => 0,
                "tax" => $temp
            ];

        $savedTransaction = StudentTransactions::create($studentTransaction);       
		$transaction_id = $savedTransaction->id;
		if(!empty($student_lesson_id)){
			$StudentLessons = StudentLessons::find($student_lesson_id);
			$StudentLessons->transaction_id = $transaction_id;
			$StudentLessons->save();
		}
		
		if($input['payment_status'] == 'succeeded') {
			$student->is_active = 1;
			$student->save();
		}
		
		//send email to student and admin.
		if(env('IS_EMAIL_ENABLED') == 1 && strtolower($student->firstname) != 'panacea'){
			$template = "emails.coursePurchased";
			$subject = 'Your '.env('APP_NAME').' order from '.date('m').'月 '.date('d').', '.date('Y').' is complete.';
			
			$user = User::where('id', 363)->first();
			$tdata = [
				'user' => $user,
				'customer_email' => $student->email,
				'courses' => $courseArray,
				'orderTotal' => $serviceTotal,
				'taxAmt' => $temp,
				'order_number' => $transaction_id,
				'payment_method' => 'Cash',
				'status' => $input['status'],
				'site_name' => env('APP_NAME'),
			];
			dispatch(new SendEmailJob($template, $tdata, $subject, 'user'));
		}
		$msg = '';
		if(env('IS_ZOHO_ENABLED') == 1) {
			if(isset($input['invoice_action'])) {
				$invoice_id = 0;
				//$user = User::find($student_lessons->user_id);
				if(!empty($student) && $student->zoho_user_id > 0) {
					$zoho_user_id = $student->zoho_user_id;
					$email = $student->email;
				} else {
					return redirect()->route('admin.student.lessons.index')->with('message', 'Customer does not exist on Zoho.');
				}
				
				if(!empty($service) && $service->zoho_item_id > 0) {
					$zoho_item_id = $service->zoho_item_id;
				} else {
					return redirect()->route('admin.student.lessons.index')->with('message', 'Item does not exist on Zoho.');
				}
				
				$date = date('Y-m-d');
				$invoice_number = ZohoHelper::get_invoice_no();
				$jsondata = '{"customer_id": '.$zoho_user_id.',"date": '.$date.', "invoice_number":'.$invoice_number.', 
					"line_items": [
								{
									"item_id": '.$zoho_item_id.',
									"name": "'.$service->title.'",
									"rate": "'.$service->price.'",
									"quantity": 1,
									"tax_id": '.config('services.zcrm.zoho_tax_id').',
									"tax_name": "Tax",
									"tax_type": "tax",
									"tax_percentage": '.$tax.',
									"item_total": "'.$service->price.'"
								}
							],
					"status":"paid",			
					"payment_options": {
						"payment_gateways": [{
							"configured": true,
							"additional_field1": "standard",
							"gateway_name": "stripe"
							}]
						}	
					}';
					//exit;
				$output = ZohoHelper::createInvoice($jsondata);
				
				if($output['code'] == 0) {
					 $invoice_id = $output['invoice']['invoice_id'];
					 $newTransaction = StudentTransactions::where('id', $transaction_id)->first();
					 $newTransaction->zoho_invoice_id = $invoice_id;
					 $newTransaction->save();
				}				
				
				
				if($input['invoice_action'] == 1 && $invoice_id > 0) { // create and send invoice
				
					if($input['payment_status'] == 'succeeded') {
						$jsondata = '{
							"customer_id": "'.$zoho_user_id.'",
							"payment_mode": "cash",
							"amount": "'.$netAmount.'",
							"date": "'.$date.'",
							"description": "Payment has been added.",
							"invoices": [
								{
									"invoice_id": "'.$invoice_id.'",
									"amount_applied": "'.$netAmount.'"
								}
							]
						}';
						$output = ZohoHelper::updateInvoice($jsondata);
					}
					
					$jsondata = '{"send_from_org_email_id": true,"to_mail_ids": ["'.$email.'"]}';
					$output = ZohoHelper::emailInvoice($jsondata, $invoice_id);
					if($output['code'] == 0) {
						$msg = '<br>And invoice has also been Send.';
					}
				}
			}
		}
	
        return redirect()->route('admin.student.lessons.index')->with('message', 'Student Lesson Created Successfully.'.$msg);
    }

    public function edit(Request $request,$id){
        $ref = $request->ref;
        $user_id = $request->user_id;

        $student_lessons = StudentLessons::find($id);
		$user = User::where('id', $student_lessons->user_id)
            ->first();
			
			
        $student_name = User::select(DB::raw("CONCAT(users.firstname, ' ', users.lastname) AS name"))
            ->where('user_type', 'student')
            ->where('id', $student_lessons->user_id)
            ->value('name');

        $service_name = Services::select('title')
            ->where('id', $student_lessons->service_id)
            ->value('title');
        $service = Services::find($student_lessons->service_id);

        $level_name = OnePageLevels::select('name')
            ->where('id', $user['student_level_id'])
            ->value('name');

        /*$transaction = StudentTransactions::where('user_id',$student_lessons->user_id)
                            ->where('transaction_type',"multi_service")
                            ->where('transaction_type_id',$service->id)
                            ->first();*/
		$transaction = StudentTransactions::where('user_id',$student_lessons->user_id)
                            ->where('id',$student_lessons->transaction_id)
                            ->first();					

        $payment_status = '';
        if(!empty($transaction)){
            $payment_status = $transaction['payment_status'];
        }

        return view('admin.student-lessons.edit', compact('student_lessons', 'user', 'student_name', 'service_name','level_name','payment_status','ref','user_id'));
    }

    public function update(Request $request, $id){
        $input = $request->all();

        $student_lessons = StudentLessons::find($id);
        $expire_date = $student_lessons->expire_date;

        $expire_date = Carbon::parse($expire_date);
        $new_expire_date = $input['expire_date'];
		$free_lessons_2 = 0;
		$rolled_over_lessons2 = 0;
		
        //$lengthOfAd = $expire_date->diffInDays($new_expire_date);
		$expire_date = strtotime($input['expire_date']) + ($input['days_extended2'] * 86400);
		$input['expire_date'] = date('Y-m-d', $expire_date);
        //$input['days_extend'] = $input['days_extend'] < 0 ? 0 : $input['days_extend'];
		if($input['free_lessons_2'] > 0) {
			$input['free_lessons'] = $input['free_lessons_2'];
			$free_lessons_2 = $input['free_lessons_2'];
		}
		$input['free_lessons_2'] = 0;
		
		if($input['rolled_over_lessons2'] > 0) {
			$input['rolled_over_lessons'] = $input['rolled_over_lessons2'];
			$rolled_over_lessons2 = $input['rolled_over_lessons2'];
		}
		$input['rolled_over_lessons2'] = 0;
		$input['available_bookings'] = $student_lessons['available_bookings'] + $free_lessons_2 + $rolled_over_lessons2;
		
		if($input['days_extended2'] > 0) {
			$input['days_extend'] = $input['days_extended2'];
		}
		
		$input['days_extended2'] = 0;
		$student_lessons['status'] = $input['payment_status'] == 'succeeded' ? 1 : 0;
		
        $student_lessons->update($input);
		if($input['connected_order'] > 0){
			$connected_order_id = $input['connected_order'];
			$connected_order = StudentLessons::where('id', $connected_order_id)->first();
			$connected_order->connected_order = $id;
			$connected_order->save();	
		}
        $service = Services::find($student_lessons->service_id);

        /*$transaction = StudentTransactions::where('user_id',$student_lessons->user_id)
                            ->where('transaction_type',"multi_service")
                            ->where('transaction_type_id',$service->id)
                            ->first();*/
		$transaction = StudentTransactions::find($student_lessons->transaction_id);					

        if(!empty($transaction)){
            $transaction->payment_status = $input['payment_status'];
            $transaction->save();
        }
		
		$user = User::find($student_lessons->user_id);
		if($input['payment_status'] == 'succeeded') {
			$user->is_active = 1;
			$user->save();
		}
		
		$msg = '';
		if(env('IS_ZOHO_ENABLED') == 1) {
			if(isset($input['invoice_action'])) {
				$invoice_id = 0;
				
				if(!empty($user) && $user->zoho_user_id > 0) {
					$zoho_user_id = $user->zoho_user_id;
					$email = $user->email;
				} else {
					return redirect()->route('admin.student.lessons.index')->with('message', 'Customer does not exist on Zoho.');
				}
				
				if(!empty($service) && $service->zoho_item_id > 0) {
					$zoho_item_id = $service->zoho_item_id;
				} else {
					return redirect()->route('admin.student.lessons.index')->with('message', 'Item does not exist on Zoho.');
				}
				$tax = $bookingStTime = Settings::getSettings('tax');
				
				$date = date('Y-m-d');
				$invoice_number = ZohoHelper::get_invoice_no();
				$jsondata = '{"customer_id": '.$zoho_user_id.',"date": '.$date.', "invoice_number":'.$invoice_number.', 
					"line_items": [
								{
									"item_id": '.$zoho_item_id.',
									"name": "'.$service->title.'",
									"rate": "'.$service->price.'",
									"quantity": 1,
									"tax_id": '.config('services.zcrm.zoho_tax_id').',
									"tax_name": "Tax",
									"tax_type": "tax",
									"tax_percentage": '.$tax.',
									"item_total": "'.$service->price.'"
								}
							],
					"status":"paid",		
					"payment_options": {
						"payment_gateways": [{
							"configured": true,
							"additional_field1": "standard",
							"gateway_name": "stripe"
							}]
						}		
					}';
					//exit;
				$output = ZohoHelper::createInvoice($jsondata);
				if($output['code'] == 0) {
					 $invoice_id = $output['invoice']['invoice_id'];					 
					 $newTransaction = StudentTransactions::where('id', $transaction->id)->first();
					 $newTransaction->zoho_invoice_id = $invoice_id;
					 $newTransaction->save();
				}
					
				
				if($input['invoice_action'] == 1 && $invoice_id > 0) { // create and send invoice					
				
					if($input['payment_status'] == 'succeeded') { // change invoice status to paid
						$jsondata = '{
							"customer_id": "'.$zoho_user_id.'",
							"payment_mode": "cash",
							"amount": "'.$transaction->amount.'",
							"date": "'.$date.'",
							"description": "Payment has been added.",
							"invoices": [
								{
									"invoice_id": "'.$invoice_id.'",
									"amount_applied": "'.$transaction->amount.'"
								}
							]
						}';
						$output = ZohoHelper::updateInvoice($jsondata);
					}
					
					$jsondata = '{"send_from_org_email_id": true,"to_mail_ids": ["'.$email.'"]}';
					$output = ZohoHelper::emailInvoice($jsondata, $invoice_id);
					if($output['code'] == 0) {
						$msg = '<br>And invoice also has been Send.';
					}
				}
			}
		}

        return redirect()->route('admin.student.lessons.index')->with('message', 'Student Lesson Updated Successfully.'.$msg);
    }

    public function destroy(Request $request, $id) {
        if($id == 'all'){
            $student_lessons = StudentLessons::whereIn('id',$request->id)->get()->pluck('id')->toArray();
            foreach ($student_lessons as $lesson){
                $student_lesson = StudentLessons::findOrFail($lesson);
                if (!empty($student_lesson)) {
                    $student_lesson->delete();
                }
            }
            if (!empty($student_lessons)) {
                return response()->json([
                    'success' => 'success',
                    'message' => 'Student Lesson Deleted Successfully.'
                ]);
            } else {
                return response()->json(['success' => 'success']);
            }

        } else {

            $student_lessons = StudentLessons::findOrFail($id);

            if (!empty($student_lessons)) {

                $student_lessons->delete();

                $request->session()->flash('message', 'Student Lesson Deleted Successfully');
                return response()->json(['success' => 'success']);
            } else {
                $request->session()->flash('message', 'Student Lesson not found.');
                return response()->json(['success' => 'success']);
            }
        }

    }

    public function getServices(Request $request) {
        $student_id = $request->get('student_id', 0);

        $oldServices = StudentLessons::select('student_lessons.service_id', 'services.title')
            ->join('services', 'services.id', 'student_lessons.service_id')
            //->where('student_lessons.user_id', $student_id)
            ->where('student_lessons.status', 1)
            ->where(function($query){
                $query->where('student_lessons.expire_date', '>=', date('Y-m-d'))
                        ->orwhereRaw('student_lessons.expire_date IS NULL');
            })
            ->whereRaw('student_package_id IS NULL')
            ->pluck('service_id');

        if ($oldServices) {
            $oldServices = $oldServices->toArray();
        }

        $packageServices = ServicePackages::distinct()->where('is_deleted', 0)->get(['service_id']);

        $pServices = [];

        foreach ($packageServices as $key => $value) {
            $pServices[] = $value['service_id'];
        }

        $oldServices = array_unique (array_merge ($pServices, $oldServices));

        /*$services = Services::whereNotIn('id', $oldServices)
                                ->whereRaw('service_type IS NULL')
                                ->pluck('title', 'id')->toArray();*/
		$services = Services::whereRaw('service_type IS NULL and is_system_service = 2')
								->where('service_type', '=', 'onepage', 'or')
								->where('service_type', '=', 'registration', 'or')
								//->orwhereRaw('is_system_service = 2 or service_type = "onepage" or service_type = "registration"')
								//->orwhereRaw('is_system_service', array('onepage', 'registration'), 'or')
                                ->pluck('title', 'id')->toArray();						

        return response()->json(['type' => 'success', 'services' => $services]);
    }
}

