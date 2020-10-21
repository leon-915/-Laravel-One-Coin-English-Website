<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\AppHelper;
use App\Models\Orders;
use App\Models\Packages;
use App\Models\Services;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\ServicePackages;
use App\Models\StudentDetail;
use App\Models\StudentLessons;
use App\Models\StudentPackages;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;

class OrdersController extends Controller
{
    public function index()
    {
        return view('admin.orders.index');
    }

    public function edit($id)
    {
        $orders = Orders::find($id);

        $user_email = User::select(
                        DB::raw("CONCAT(users.firstname, ' ', users.lastname) AS username"),
                        'email', 'id'
                    )
                    ->where('id', $orders->user_id)
                    ->first();

        if (!empty($orders))
        {
            if ($orders->transaction_type == 'service')
            {
                $product = Services::select('title', 'id')
                    ->where('id', $orders->transaction_type_id)
                    ->value('title');
            }
            else if ($orders->transaction_type == 'multi_service')
            {
                $serviceIds = explode(',', $orders->transaction_type_id);
                $serviceArray = [];
                foreach ($serviceIds as $service) {
                    $service = Services::where('id', $service)->first();
                    $serviceArray[] = $service->title . ' x ' . $service->available_lessons;
                }
                $product = implode(',', $serviceArray);
            }
            else
            {
                $product = Packages::select('title')->where('id', $orders->transaction_type_id)->value('title');
            }
        }
        return view('admin.orders.edit', compact('orders', 'user_email', 'product'));
    }

    public function update(Request $request, $id)
    {
        $input = $request->all();

        $orders = Orders::find($id);

        $orders['payment_status'] = $input['payment_status'];

        //if(($input['payment_status'] == 'failed') || ($input['payment_status'] == 'pending')){

            if ($orders->transaction_type == 'service')
            {
                $product = StudentLessons::where('user_id', $orders->user_id)->where('service_id',$orders->transaction_type_id)->first();

                if(!empty($product)){
                    if(($input['payment_status'] == 'failed') || ($input['payment_status'] == 'pending')){
                        $product->status = 0;
                    }else if($input['payment_status'] == 'succeeded'){
                        $product->status = 1;
                    }
                    $product->save();
                }
            }
            else if ($orders->transaction_type == 'multi_service')
            {
                /*$serviceIds = explode(',', $orders->transaction_type_id);
                $serviceArray = [];
                foreach ($serviceIds as $service) {
					
                    $studentLesson = StudentLessons::where('user_id', $orders->user_id)->where('service_id',$orders->transaction_type_id)->first();

                    if(!empty($studentLesson)){
                        if(($input['payment_status'] == 'failed') || ($input['payment_status'] == 'pending')){
                            $studentLesson->status = 0;
                        }else if($input['payment_status'] == 'succeeded'){
                            $studentLesson->status = 1;
                        }
                        $studentLesson->save();
                    }
                }*/
				//need to update here with student_lesson_id instead of service_id from transaction table
				$student_lesson_ids = explode(',', $orders->student_lesson_id);
                
                foreach ($student_lesson_ids as $student_lesson_id) {
					$studentLesson = StudentLessons::where('user_id', $orders->user_id)->where('id',$student_lesson_id)->first();

                    if(!empty($studentLesson)){
                        if(($input['payment_status'] == 'failed') || ($input['payment_status'] == 'pending')){
                            $studentLesson->status = 0;
                        }else if($input['payment_status'] == 'succeeded'){
                            $studentLesson->status = 1;
                        }
                        $studentLesson->save();
                    }
                }
            }
            else
            {
                $studentPackage = StudentPackages::where('user_id',$orders->user_id)->where('package_id', $orders->transaction_type_id)->first();
                if(!empty($studentPackage)){
                    if(($input['payment_status'] == 'failed') || ($input['payment_status'] == 'pending')){
                        $studentPackage->status = 0;
                    }else if($input['payment_status'] == 'succeeded'){
                        $studentPackage->status = 1;
                    }
                    $studentPackage->save();
                }
            }

       // }

        $orders->save();

        return redirect()->route('admin.orders')->with('message', 'Orders Updated Successfully');
    }

    public function getOrders(Request $request) {

        $orders = DB::table('student_transactions')
                ->leftjoin('users','users.id','student_transactions.user_id')
                ->select('student_transactions.*',
                    DB::raw("CONCAT(users.firstname, ' ', users.lastname) AS username"));

        return DataTables::of($orders)
            ->filter(function ($query) use ($request) {
                if (!empty($request->get('student'))) {
                    $query->whereRaw("LOWER(CONCAT(users.firstname,' ',users.lastname)) like '%" . strtolower($request->get('student')) . "%'");
                }

                if (!empty($request->get('status'))) {
                    $query->where("student_transactions.payment_status" , $request->get('status'));
                }

            })
            ->addIndexColumn()
            ->addColumn('action', function ($orders) {
                $editButton = '';

                $editButton .= '<a href="' . route('admin.orders.details', $orders->id) . '" class="btn btn-outline-info btn-rounded btn-icon edit-row"
                    data-toggle="tooltip" title="Order-Details" data-original-title="order-details"><i class="mdi mdi-eye" aria-hidden="true"></i></a>';

                $editButton .= '<a href="' . route('admin.orders.edit', $orders->id) . '" class="btn btn-outline-info btn-rounded btn-icon edit-row" title="Edit"
                    data-toggle="tooltip" title="Edit" data-original-title="Edit"><i class="mdi mdi-pencil-box" aria-hidden="true"></i></a>';


                if($orders->payment_status == 'failed' || $orders->payment_status == 'pending'){
                    $editButton .= '<a href="' . route('admin.orders.reorder', $orders->id) . '" class="btn btn-outline-info btn-rounded btn-icon edit-row reorderTransaction"
                        data-toggle="tooltip" title="Reorder" data-original-title="Re order"><i class="mdi mdi-redo" aria-hidden="true"></i></a>';
                }

                return $editButton;
            })
            ->editColumn('user_id', function ($orders) {
                return (!empty($orders->user_id)) ? $orders->username : '';
            })
            ->editColumn('payment_ip', function ($orders) {
                return (!empty($orders->payment_ip )) ? $orders->payment_ip  : '';
            })
            ->editColumn('transaction_type_id', function ($orders) {
                if ($orders->transaction_type == 'service') {
                    $product = Services::select('title')->where('id', $orders->transaction_type_id)->value('title');
                } else if ($orders->transaction_type == 'multi_service') {
                    $serviceIds = explode(',', $orders->transaction_type_id);
                    $serviceArray = [];
                    foreach ($serviceIds as $service) {
                        $service = Services::where('id', $service)->first();
                        $serviceArray[] = $service->title . ' x ' . $service->available_lessons;
                    }
                    $product = implode(',', $serviceArray);

                } else {
                    $product = Packages::select('title')->where('id', $orders->transaction_type_id)->value('title');
                }
                return $product;
            })

            ->editColumn('payment_status', function ($orders) {
                if ($orders->payment_status == 'succeeded'){
                    return '<span class="badge badge-gradient-success badge-pill">Success</span>';
                }else if($orders->payment_status == 'failed') {
                    return '<span class="badge badge-gradient-danger badge-pill">Failed</span>';
                }else if($orders->payment_status == 'pending') {
                    return '<span class="badge badge-gradient-warning badge-pill">Pending</span>';
                }else{
                    return '<span class="badge badge-gradient-warning badge-pill">Pending</span>';
                }
            })

            ->editColumn('created_at', function ($orders) {
                $date = Carbon::parse($orders->created_at)->format('d-M-Y');
                return $date;
            })

            ->editColumn('amount', function ($orders) {
                return ($orders->amount) ? '¥ '.$orders->amount: '';
            })

            ->rawColumns(['action', 'payment_status'])
            ->make(true);
    }

    public function OrdersDetails($id) {
        $orders = Orders::find($id);
        $user_email = User::select( DB::raw("CONCAT(users.firstname, ' ', users.lastname) AS username"),'email', 'id')
            ->where('id', $orders->user_id)
            ->first();

        if (!empty($orders)) {
            if ($orders->transaction_type == 'service')
            {
                $product = Services::select('title', 'id')
                            ->where('id', $orders->transaction_type_id)
                            ->value('title');
            }
            else if ($orders->transaction_type == 'multi_service')
            {
                $serviceIds = explode(',', $orders->transaction_type_id);
                $serviceArray = [];
                foreach ($serviceIds as $service) {
                    $service = Services::where('id', $service)->first();
                    $serviceArray[] = $service->title . ' x ' . $service->available_lessons;
                }
                $product = implode(',', $serviceArray);
            }
            else {
                $product = Packages::select('title')->where('id', $orders->transaction_type_id)->value('title');
            }
        }
        return view('admin.orders.show', compact('orders', 'user_email', 'product'));
    }

    public function Reorder($id) {
        $orders = Orders::find($id);
        $user = User::select( DB::raw("CONCAT(users.firstname, ' ', users.lastname) AS username"),'email', 'id')
            ->where('id', $orders->user_id)
            ->first();

        if (!empty($orders)) {
            if ($orders->transaction_type == 'service') {
                $product = Services::select('title', 'id')
                            ->where('id', $orders->transaction_type_id)
                            ->value('title');
            } else if ($orders->transaction_type == 'multi_service') {
                $services = $orders->transaction_type_id;
                $services = explode(',', $services);

                if (!empty($user->line_token)) {
                    $messages = [];
                    $messages['to'] = $user->line_token;
                    $msg = "You have successfully purchased services\n";
                }

                foreach ($services as $service) {
                    $service = Services::where('id', $service)->first();

                    $amount = $service->price;

                    if($service->service_type == 'onepage') {
                        $user->onepage_start_date = date('Y-m-d');
                        $user->onepage_end_date = date('Y-m-d',strtotime('+1 Year'));
                        $user->save();
                    } elseif ($service->service_type == 'registration') {
                        $user->is_registerfee_paid = 1;
                        $user->save();
                    } else {
                        $isExist = StudentLessons::where('user_id', $user->id)->where('service_id',$service->id)->first();
                        if($isExist){
                            $isExist->available_bookings = $service->available_lessons;
                            $isExist->expire_date = date('Y-m-d', strtotime(date('Y-m-d'). '+30 days'));
                            $isExist->price = ($service->price);
                            $isExist->status = 1;
                            $isExist->save();
                        } else {
                            $studentLession =  new StudentLessons();
                            $studentLession->user_id = $user->id;
                            $studentLession->service_id = $service->id;
                            $studentLession->available_bookings = $service->available_lessons;
                            $studentLession->price = $service->price;
                            $studentLession->status = 1;
                            $studentLession->save();
                        }
                    }
                    if (!empty($user->line_token)) {
                        $msg .= "Service : " . $service->title . "\n";
                        $msg .= "Price : " . $service->price . "\n";
                    }
                }

                if (!empty($user->line_token)) {
                    $messages['messages'][] = AppHelper::getFormatTextMessage($msg);
                    $encodeJson = json_encode($messages);
                    AppHelper::sentMessage($encodeJson);
                }
            } else {
                $studentPackage = StudentPackages::where('user_id',$user->id)->first();

                $package_services = ServicePackages::where('package_id',$orders->transaction_type_id)
                                ->leftjoin('services','services.id','=','services_packages.service_id')
                                ->get();

                $package_id = $orders->transaction_type_id;

                $package = Packages::find($orders->transaction_type_id);

                if($orders->transaction_type_id){
                    foreach($package_services as $p){
                        $isExist = null;
                        $isExist = StudentLessons::where('user_id', $user->id)->where('service_id',$p->service_id)->first();
                        if($isExist){
                            $isExist->available_bookings = 0;
                            $isExist->expire_date = date('Y-m-d', strtotime(date('Y-m-d'). '+30 days'));
                            $isExist->price = 0;
                            $isExist->save();
                        } else {
                            $studentLession =  new StudentLessons();
                            $studentLession->user_id = $user->id;
                            $studentLession->service_id = $p->service_id;
                            $studentLession->available_bookings = 0;
                            $studentLession->start_date  = date('Y-m-d', time());
                            $studentLession->expire_date = date('Y-m-d', strtotime(date('Y-m-d'). '+30 days'));
                            $studentLession->price = 0;
                            $studentLession->save();
                        }
                    }

                    $onepagefee = Services::select('price')->where('service_type', 'onepage')->value('price');
                    $registerfee = Services::select('price')->where('service_type', 'registration')->value('price');

                    if(strtotime($user->onepage_start_date) < time() && time() < strtotime($user->onepage_end_date)){
                        $onepagefee = 0;
                    } else {
                        $user->onepage_start_date = date('Y-m-d');
                        $user->onepage_end_date = date('Y-m-d',strtotime('+1 Year'));
                        $user->save();
                    }

                    if(!empty($studentPackage)){
                        $studentDetail = StudentDetail::where('user_id',$user->id)->first();

                        $credit_balance = 0;
                        if((time() - strtotime($studentPackage->end_date)) > 0){
                            if(((time() - strtotime($studentPackage->end_date)) <= 5*86400)) {
                                $oldBalance = 0;
                                if(!empty($package->roleover_condition)){
                                    $oldBalance = $studentDetail->credit_balance * $package->roleover_condition / 100 ;
                                }

                                $credit_balance = $oldBalance + $package->price - ($onepagefee);
                            } else {
                                $credit_balance = $package->price - ($package->registration_fee + $onepagefee);
                            }
                        } else {
                            $credit_balance = $studentDetail->credit_balance + $package->price - ($onepagefee);
                        }

                        $studentDetail->current_package_id = $orders->transaction_type_id;
                        $studentDetail->package_end_date = date('Y-m-d', strtotime(' +1 month'));
                        $studentDetail->credit_balance = ceil($credit_balance);
                        $studentDetail->save() ;

                        $studentPackage->package_id = $orders->transaction_type_id;
                        $studentPackage->start_date =  date('Y-m-d');
                        $studentPackage->end_date =  date('Y-m-d', strtotime(' +1 month'));
                        $studentPackage->price = floatval($package->price);
                        $studentPackage->save();
                    } else {
                        $studentPackage = [
                            "user_id"       => $user->id,
                            "package_id"    => $package_id,
                            "start_date"    => date('Y-m-d'),
                            "end_date"      => date('Y-m-d', strtotime(' +1 month')),
                            "price"         => floatval($package->price),
                            "status"        => 'active'
                        ];

                        $credit_balance = $package->price - $onepagefee;

                        $studentDetail = StudentDetail::where('user_id',$user->id)->first();
                        $studentDetail->current_package_id = $package_id;
                        $studentDetail->package_end_date = date('Y-m-d', strtotime(' +1 month'));
                        $studentDetail->credit_balance = ceil($credit_balance);
                        $studentDetail->save() ;

                        StudentPackages::create($studentPackage);
                    }
                } else {
                    return redirect()->route('admin.orders')->with('error', 'No Subscription Fount in Transaction.');
                }
            }

            $orders->payment_status = 'succeeded';
            $orders->save();
        }
        return redirect()->route('admin.orders')->with('message', 'Order Placed Successfully');
    }
}
