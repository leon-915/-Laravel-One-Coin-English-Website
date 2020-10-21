<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\AppHelper;
use App\Helpers\ZohoHelper;
use App\Models\Packages;
use App\Models\ServicePackages;
use App\Models\StudentDetail;
use App\Models\StudentLessons;
use App\Models\StudentPackages;
use App\Models\Settings;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Services;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;
use App\Models\StudentTransactions;

use PayPal\Api\Agreement;
use PayPal\Api\AgreementStateDescriptor;
use PayPal\Auth\OAuthTokenCredential;
use PayPal\Rest\ApiContext;

class StudentPackagesController extends Controller
{
    public function index() {
        return view('admin.student-packages.index');
    }

    public function getPackage(Request $request) {
        $student_packages = DB::table('student_packages')
        ->leftJoin('users', 'student_packages.user_id', 'users.id')
        ->leftJoin('packages', 'student_packages.package_id', 'packages.id')
        ->select('student_packages.*', 'packages.title as package','users.email as email',
            DB::raw("CONCAT(users.firstname, ' ', users.lastname) AS student"))
			->orderBy('start_date', 'desc');

        return DataTables::of($student_packages)
            ->filter(function ($query) use ($request) {
                if (!empty($request->get('student'))) {
                    $query->whereRaw("LOWER(CONCAT(users.firstname,' ',users.lastname)) like '%" . strtolower($request->get('student')) . "%'");
                }

                if (!empty($request->get('package'))) {
                    $query->whereRaw("LOWER(packages.title) like '%" . strtolower($request->get('package')) . "%'");
                }
            })

            ->addIndexColumn()
            ->addColumn('action',function ($packages){
                $editButton = '';

                $editButton .= '<a href="' . route('admin.student-packages.edit', $packages->id) . '" class="btn btn-outline-info btn-rounded btn-icon edit-row" title="Edit"
                    data-toggle="tooltip" title="Edit" data-original-title="Edit"><i class="mdi mdi-pencil-box" aria-hidden="true"></i></a>';

                //                $editButton .= '<a id="' . $packages->id . '" class="btn btn-outline-danger btn-rounded btn-icon remove-row deleteStudentPackage"
                //                    data-toggle="tooltip" title="Delete" data-original-title="Delete"><i class="mdi mdi-delete" aria-hidden="true"></i></a>';

                return $editButton;
            })
            ->editColumn('user_id',function ($student_packages){
                return ($student_packages->user_id ) ? $student_packages->student  : '';

            }) ->editColumn('package_id',function ($student_packages){
                return ($student_packages->package_id ) ? $student_packages->package  : '';

            })
            ->editColumn('status',function ($student_packages){
				if(strtotime($student_packages->end_date) <= time()) {
					return '<span class="badge badge-gradient-success badge-pill">Expired</span>';
				}else {
					if($student_packages->status == 'active') {
						return '<span class="badge badge-gradient-success badge-pill"><a class="badge badge-gradient-success badge-pill" href="'.route('admin.student-packages.suspend', $student_packages->id).'">Suspend</a></span>';
					} else {
						return '<span class="badge badge-gradient-danger badge-pill"><a class="badge badge-gradient-danger badge-pill" href="'.route('admin.student-packages.reactivate', $student_packages->id).'">Re-activate</a></span>';
					}
				}
            })
            ->editColumn('price',function ($student_packages){
                return ($student_packages->price) ? '¥ '. $student_packages->price : '¥ '.'0';
            })
            ->editColumn('start_date',function ($student_packages){
                return ($student_packages->start_date ) ? date('d-m-Y', strtotime($student_packages->start_date)) : '';
            })
            ->editColumn('end_date',function ($student_packages){
                return ($student_packages->end_date ) ? date('d-m-Y', strtotime($student_packages->end_date)) : '';
            })
            ->rawColumns(['action','status'])
            ->make(true);
    }

    public function create() {
        $packages = Packages::select('id','title')
                            ->where('status', 1)
                            ->pluck('title', 'id')
                            ->toArray();

        return view('admin.student-packages.create',compact('packages'));
    }

    public function store(Request $request) {
        $input = $request->all();

        $package = Packages::where('id',$input['package_id'])->first();

        $package_services = ServicePackages::where('package_id',$input['package_id'])
            ->leftjoin('services','services.id','=','services_packages.service_id')
            ->get();

        $package_id = $input['package_id'];
		//echo '<pre>'; print_r($input); exit;
        $user = User::find($input['user_id']);

        $studentDetail = StudentDetail::where('user_id',$input['user_id'])->first();

        $onepagefee = Services::select('price')->where('service_type', 'onepage')->value('price');
        $registerfee = Services::select('price')->where('service_type', 'registration')->value('price');

        /*if(strtotime($user->onepage_start_date) < time() && time() < strtotime($user->onepage_end_date)){
            $onepagefee = 0;
        } else {
            $user->onepage_start_date   = date('Y-m-d');
            $user->onepage_end_date     = date('Y-m-d',strtotime('+1 Year'));
        }*/

        //$user->is_registerfee_paid  = 1;
        //$user->save();

        $studentPackage = StudentPackages::where('user_id',$input['user_id'])->orderBy('id', 'desc')->first();
		$credit_balance = $rollderOverCredits = 0;
		$subscription_fee = env('SUBSCRIPTION_FEE');
		if($package_id == 42) {
			$subscription_fee = 496;	
		}
		$newOrderAmt = $package->price - $subscription_fee;
		$remainingAmt = $studentDetail->credit_balance;
		
			
        if(!empty($studentPackage)){			
			
			if((time() - strtotime($studentPackage->end_date)) >= 0){ //if subscription has expired
				$enddate_with_grace_period = (strtotime($studentPackage->end_date) +  5*86400);
				if(time() <= $enddate_with_grace_period) { // if subscription expiry date is within last 5 days
					$twentyPercoforderAmt = 0;
					if($package->roleover_condition){
						$twentyPercoforderAmt = $newOrderAmt * $package->roleover_condition / 100 ;
					}
					
					if ($remainingAmt <= $twentyPercoforderAmt) {
						$rollderOverCredits = $remainingAmt;
					} else {
						$rollderOverCredits = $twentyPercoforderAmt;
					}

					$credit_balance = $rollderOverCredits + $newOrderAmt;
				} else { // if subscription expiry date is more than 5 days then no rollover
					$credit_balance = $newOrderAmt;
				}
			} else {
				$credit_balance = $newOrderAmt;
			}
        } else {
			$credit_balance = $newOrderAmt;
		}
		
		$studentDetail->current_package_id = $input['package_id'];
		$studentDetail->package_end_date = date('Y-m-d 23:59:59', strtotime(' +1 month'));
		$studentDetail->credit_balance = ceil($credit_balance);
		$studentDetail->save() ;
		
		$studentPackageData = [
			"user_id" => $input['user_id'],
			"package_id" => $input['package_id'],
			"start_date" =>  !empty($input['start_date']) ? $input['start_date'] : date('Y-m-d', time()),
			"end_date" => !empty($input['expire_date']) ? $input['expire_date'] . ' 23:59:59' : date('Y-m-d 23:59:59', strtotime(' +1 month')),
			"price" => floatval($package->price),
			"status" => $input['status'],
			"total_credits" => ceil($credit_balance),
			"rolledover_credits" => ceil($rollderOverCredits),
			'payment_type' => 'cash'
		];

		
		$studentPackage = StudentPackages::create($studentPackageData);
        $studentPackage_id = $studentPackage->id;
		
        $tax = Settings::getSettings('tax');
        $taxAmt = $package->price * $tax / 100;
        $packagePrice = $package->price + ($package->price * $tax / 100);

        $studentTransaction = [
            "user_id" => $input['user_id'],
            "provider" => 'cash',
            "amount" => $packagePrice,
            "transaction_type" => "package",
            "transaction_type_id" => $package->id,
            "payment_status" => $input['payment_status'],
            "discount" => 0,
            "student_package_id" => $studentPackage_id,
            "subtotal" => $package->price,
            "one_page_fee" => 0,
            "tax" => $taxAmt
        ];

        $savedTransaction = StudentTransactions::create($studentTransaction);
        $new_transaction_id = $savedTransaction->id;
		
		$StudentPackages = StudentPackages::where('id', $studentPackage_id)->first();
		$StudentPackages->transaction_id = $new_transaction_id;
		$StudentPackages->save();
		$msg = '';
		if(env('IS_ZOHO_ENABLED') == 1) {
			if(isset($input['invoice_action'])) {
				$invoice_id = 0;
				//$user = User::find($student_lessons->user_id);
				if(!empty($user) && $user->zoho_user_id > 0) {
					$zoho_user_id = $user->zoho_user_id;
					$email = $user->email;
				} else {
					return redirect()->route('admin.student-packages.index')->with('message', 'Customer does not exist on Zoho.');
				}
				
				if(!empty($package) && $package->zoho_item_id > 0) {
					$zoho_item_id = $package->zoho_item_id;
				} else {
					return redirect()->route('admin.student-packages.index')->with('message', 'Item does not exist on Zoho.');
				}
				
				$date = date('Y-m-d');
				$invoice_number = ZohoHelper::get_invoice_no();
				$jsondata = '{"customer_id": '.$zoho_user_id.',"date": '.$date.', "invoice_number":'.$invoice_number.', 
					"line_items": [
								{
									"item_id": '.$zoho_item_id.',
									"name": "'.$package->title.'",
									"rate": "'.$package->price.'",
									"quantity": 1,
									"tax_id": '.config('services.zcrm.zoho_tax_id').',
									"tax_name": "Tax",
									"tax_type": "tax",
									"tax_percentage": '.$tax.',
									"item_total": "'.$package->price.'"
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
					 $newTransaction = StudentTransactions::where('id', $new_transaction_id)->first();
					 $newTransaction->zoho_invoice_id = $invoice_id;
					 $newTransaction->save();
				}
					
				
				if($input['invoice_action'] == 1 && $invoice_id > 0) { // create and send invoice					
				
					if($input['payment_status'] == 'succeeded') { // change invoice status to paid
						$jsondata = '{
							"customer_id": "'.$zoho_user_id.'",
							"payment_mode": "cash",
							"amount": "'.$packagePrice.'",
							"date": "'.$date.'",
							"description": "Payment has been added.",
							"invoices": [
								{
									"invoice_id": "'.$invoice_id.'",
									"amount_applied": "'.$packagePrice.'"
								}
							]
						}';
						$output = ZohoHelper::updateInvoice($jsondata);
					}
					
					$jsondata = '{"send_from_org_email_id": false,"to_mail_ids": ["'.$email.'"]}';
					$output = ZohoHelper::emailInvoice($jsondata, $invoice_id);
					if($output['code'] == 0) {
						$msg = '<br>And invoice has also been Send.';
					}
				}
			}
		}

        return redirect()->route('admin.student-packages.index')->with('message', 'Student Package inserted Successfully.'.$msg);
    }

    public function edit($id) {
        $student_packages = StudentPackages::find($id);

        $student_name = User::select(DB::raw("CONCAT(users.firstname, ' ', users.lastname) AS name"))
                                ->where('user_type', 'student')
                                ->where('id', $student_packages->user_id)
                                ->value('name');

        $packages = Packages::select('id','title')
                            ->pluck('title', 'id')
                            ->toArray();

        /*$transaction = StudentTransactions::where('user_id',$student_packages->user_id)
                            ->where('transaction_type',"package")
                            ->where('transaction_type_id',$student_packages->package_id)
                            ->first();*/
		$transaction = StudentTransactions::find($student_packages->transaction_id);					

        $payment_status = '';
        if(!empty($transaction)){
            $payment_status = $transaction['payment_status'];
        }

        return view('admin.student-packages.edit',compact('student_packages','packages','student_name',
            'payment_status'));
    }

    public function update(Request $request, $id) {
        $input = $request->all();

        $student_packages = StudentPackages::find($id);

        if(!empty($student_packages)){
            $student_packages['start_date'] = $input['start_date'];
            $student_packages['end_date'] = $input['expire_date']. ' 23:59:59';
            //$student_packages['status'] = (!empty($input['payment_status']) && $input['payment_status']=='succeeded') ? 'active' : 'inactive';
            $student_packages['status'] = $input['status'];
            $student_packages->save();
        }

        /*$transaction = StudentTransactions::where('user_id',$student_packages->user_id)
                            ->where('transaction_type',"package")
                            ->where('transaction_type_id',$student_packages->package_id)
                            ->first();*/
		$transaction = StudentTransactions::find($student_packages->transaction_id);
	
        if(!empty($transaction)){
            $transaction->payment_status = $input['payment_status'];
            $transaction->save();
        }
		
		$user = User::find($student_packages->user_id);
		if($input['payment_status'] == 'succeeded' && $input['status'] = 1) {
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
					return redirect()->route('admin.student-packages.index')->with('message', 'Customer does not exist on Zoho.');
				}
				
				$package = Packages::find($student_packages->package_id);
				if(!empty($package) && $package->zoho_item_id > 0) {
					$zoho_item_id = $package->zoho_item_id;
				} else {
					return redirect()->route('admin.student-packages.index')->with('message', 'Item does not exist on Zoho.');
				}
				$tax = $bookingStTime = Settings::getSettings('tax');
				
				$date = date('Y-m-d');
				$invoice_number = ZohoHelper::get_invoice_no();
				$jsondata = '{"customer_id": '.$zoho_user_id.',"date": '.$date.', "invoice_number":'.$invoice_number.', 
					"line_items": [
								{
									"item_id": '.$zoho_item_id.',
									"name": "'.$package->title.'",
									"rate": "'.$package->price.'",
									"quantity": 1,
									"tax_id": '.config('services.zcrm.zoho_tax_id').',
									"tax_name": "Tax",
									"tax_type": "tax",
									"tax_percentage": '.$tax.',
									"item_total": "'.$package->price.'"
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
				
				$output = ZohoHelper::createInvoice($jsondata);
				//echo '<pre>';print_r($output);exit;
				
				if($output['code'] == 0) {
					 $zohodata['zoho_invoice_id'] = $invoice_id = $output['invoice']['invoice_id'];
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
					
					$jsondata = '{"send_from_org_email_id": false,"to_mail_ids": ["'.$email.'"]}';
					$output = ZohoHelper::emailInvoice($jsondata, $invoice_id);
					if($output['code'] == 0) {
						$msg = '<br>And invoice also has been Send.';
					}
				}
			}
		}

        return redirect()->route('admin.student-packages.index')->with('message', 'Student Package Updated Successfully.'.$msg);
    }

    public function destroy(Request $request,$id) {
        $student_packages = StudentPackages::findOrFail($id);

        if (!empty($student_packages)) {

            $student_packages->delete();

            $request->session()->flash('message', 'Student Package Deleted Successfully');
            return response()->json(['success' => 'success']);
        }
        else {
            $request->session()->flash('message', 'Student Package not found.');
            return response()->json(['success' => 'success']);
        }
    }
	
	public function suspendSubscription($id) {
		$student_packages = StudentPackages::find($id);	
		$user_id = $student_packages->user_id;
		$user =  User::find($user_id);		
        if($user->billing_agreement_id != '') {
			if(!empty($student_packages)){
				$student_packages['status'] = 'inactive';
				$student_packages->save();
			}
			
			$credential = new OAuthTokenCredential(env('PAYPAL_CLIENT_ID'), env('PAYPAL_CLIENT_SECRET'));
			$apiContext = new ApiContext($credential);
			$apiContext->setConfig(
				  array(
					'mode' => env('PAYPAL_PAYMENT_MODE'),
				  )
			);
			//$billing_agreement_response = $user->billing_agreement_response;
																
			//Create an Agreement State Descriptor, explaining the reason to suspend.
			$agreementStateDescriptor = new AgreementStateDescriptor();
			$agreementStateDescriptor->setNote("Suspending the agreement");
			/** @var Agreement $createdAgreement */
		
			$createdAgreementId = $user->billing_agreement_id; // Replace this with your fetched agreement object

			try {
				$createdAgreement = Agreement::get($createdAgreementId, $apiContext);
				// echo '<pre>';print_r($createdAgreement);exit;
				$createdAgreement->suspend($agreementStateDescriptor, $apiContext);			
				$agreement = Agreement::get($createdAgreement->getId(), $apiContext);
				return redirect()->route('admin.student-packages.index')
							 ->with('message', 'Student Package Suspended Successfully');
				//echo '<pre>';print_r($agreement);
			} catch (\PayPal\Exception\PayPalConnectionException $ex) {
				return redirect()->route('admin.student-packages.index')
							 ->with('message', $ex->getData());
				//return response()->json(['status' => 'fail','code' => $ex->getCode(),'message'=>$ex->getData()]);
			}
		} else {
			return redirect()->route('admin.student-packages.index')
							 ->with('message', 'Billing agreement id not found.');
		}	
    }
	
    public function reactivateSubscription($id) {
        $student_packages = StudentPackages::find($id);	
		$user_id = $student_packages->user_id;
		$user =  User::find($user_id);		
        if($user->billing_agreement_id != '') {
			if(!empty($student_packages)){
				$student_packages['status'] = 'active';
				$student_packages->save();
			}
			
			$credential = new OAuthTokenCredential(env('PAYPAL_CLIENT_ID'), env('PAYPAL_CLIENT_SECRET'));
			$apiContext = new ApiContext($credential);
			$apiContext->setConfig(
				  array(
					'mode' => env('PAYPAL_PAYMENT_MODE'),
				  )
			);
			//Create an Agreement State Descriptor, explaining the reason to suspend.
			$agreementStateDescriptor = new AgreementStateDescriptor();
			$agreementStateDescriptor->setNote("Reactivating the agreement");
			/** @var Agreement $createdAgreement */
		
		
			$createdAgreementId = $user->billing_agreement_id; // Replace this with your fetched agreement object

			try {
				$createdAgreement = Agreement::get($createdAgreementId, $apiContext);
				$createdAgreement->reActivate($agreementStateDescriptor, $apiContext);			
				$agreement = Agreement::get($createdAgreement->getId(), $apiContext);
				return redirect()->route('admin.student-packages.index')
							 ->with('message', 'Student Package Reactivated Successfully');
				//echo '<pre>';print_r($agreement);
			} catch (\PayPal\Exception\PayPalConnectionException $ex) {
				return redirect()->route('admin.student-packages.index')
							 ->with('message', $ex->getData());
				//return response()->json(['status' => 'fail','code' => $ex->getCode(),'message'=>$ex->getData()]);
			}
		} else {
			return redirect()->route('admin.student-packages.index')
							 ->with('message', 'Billing agreement id not found.');
		}
    }
}
