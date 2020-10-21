<?php

namespace App\Http\Controllers;

use App\Helpers\AppHelper;
use App\Helpers\ZohoHelper;
use App\Jobs\SendEmailJob;
use App\Models\AdminUser;
use App\Models\ContactUs;
use Illuminate\Http\Request;
use App\Models\Packages;
use App\Models\ServicePackages;
use App\Models\Services;
use App\Models\StudentDetail;
use App\Models\Settings;
use App\Models\StudentLessons;
use App\Models\StudentPackages;
use App\Models\StudentTransactions;
use App\Models\TempLineUsers;
use App\User;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redirect;

class HookController extends Controller
{
    public function __construct() {
        //$this->middleware('auth');
    }

    public function SuccessWebHook(Request $request) {
        $data = file_get_contents('php://input');
        //PaypalWebhook::create(['response' => $data]);
        file_put_contents(public_path('paypal-log.txt'), date('Y-m-d H:i:s').PHP_EOL . $data . PHP_EOL, FILE_APPEND);

        $data = json_decode($data,true);

        if($data['event_type'] == 'PAYMENT.SALE.COMPLETED'){
            if(!empty($data['resource'])){
                $billing_agreement_id = !empty($data['resource']['billing_agreement_id']) ? $data['resource']['billing_agreement_id'] : '';
                $stTr = StudentTransactions::where('billing_agreement_id',$billing_agreement_id)->orderBy('id', 'desc')->first();
                $studentLastPackage_end_date = strtotime(date('Y-m-d'));
				if($stTr && ($stTr->payment_status == 'succeeded') && ($stTr->transaction_type == 'package')) {
					$student_package_id = $stTr->student_package_id;
					$studentLastPackage = StudentPackages::where('user_id',$stTr->user_id)->where('id', $student_package_id)->orderBy('id', 'desc')->first();			
					$studentLastPackage_end_date = date('Y-m-d', strtotime($studentLastPackage->end_date));
				}
				
				if($stTr && (($stTr->payment_status == 'pending' && ($stTr->transaction_type == 'package_billing')) || (strtotime($studentLastPackage_end_date) < time()))) {
				//if($stTr && $stTr->payment_status == 'pending'){
                    $user           = User::find($stTr->user_id);
                    $studentDetail  = $user->details()->first();

                    $studentPackage = StudentPackages::where('user_id',$stTr->user_id)->orderBy('id', 'desc')->first();

                    $package_services = ServicePackages::where('package_id',$stTr->transaction_type_id)
                                    ->leftjoin('services','services.id','=','services_packages.service_id')
                                    ->get();

                    $package_id = $stTr->transaction_type_id;

                    $package = Packages::find($stTr->transaction_type_id);

                    $studentTransaction = [
                        "user_id" => $user->id,
                        "provider" => 'paypal',
                        "amount" => $stTr->amount,
                        "transaction_type" => "package",
                        "transaction_type_id" => $stTr->transaction_type_id,
                        "payment_status" => 'succeeded',
                        "discount" => 0,
                        "subtotal" => $stTr->subtotal,
                        "one_page_fee" => 0,
                        "tax" => $stTr->tax,
                        "billing_agreement_id" => $billing_agreement_id,
                        "student_package_id" => $stTr->transaction_type_id,
                        'payment_ip' => $stTr->payment_ip
                    ];

                    $studentTransaction = StudentTransactions::create($studentTransaction);
					$new_transaction_id = $studentTransaction->id;

                    $onepagefee = Services::select('price')->where('service_type', 'onepage')->value('price');
                    $registerfee = Services::select('price')->where('service_type', 'registration')->value('price');

                    if(strtotime($user->onepage_start_date) < time() && time() < strtotime($user->onepage_end_date)){
                        $onepagefee = 0;
                    } else {
                        $user->onepage_start_date   = date('Y-m-d');
                        $user->onepage_end_date     = date('Y-m-d',strtotime('+1 Year'));
                    }

                    $user->is_registerfee_paid = 1;
                    $user->is_active = 1;
                    $user->save();

					$subscription_fee = $stTr->transaction_type_id == 35 ? 0 : env('SUBSCRIPTION_FEE');
					if($stTr->transaction_type_id == 42) {
						$subscription_fee = 496;	
					}
					$newOrderAmt = $package->price - $subscription_fee;
					if($stTr->transaction_type_id == 35) {
							$frequency = 'day';
						} else {
							$frequency = 'month';
						}
					$studentDetail = StudentDetail::where('user_id',$user->id)->first();
					$remainingAmt = $studentDetail->credit_balance;
					$credit_balance = $rollderOverCredits = 0;	
					
                    if(!empty($studentPackage)){
                        
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
						
							//$credit_balance = $package->price - ($package->registration_fee + $onepagefee);
							$credit_balance = $newOrderAmt;
						}                       						
                    } else { // if subscription expiry date is more than 5 days then no rollover
						$credit_balance = $newOrderAmt;
					}
					
					$studentDetail->current_package_id = $stTr->transaction_type_id;
					$studentDetail->package_end_date = date('Y-m-d 23:59:59', strtotime(' +1 '.$frequency.''));
					$studentDetail->credit_balance = ceil($credit_balance);
					$studentDetail->save() ;

					$studentPackage = [
						"user_id"       => $user->id,
						"package_id"    => $stTr->transaction_type_id,
						"start_date"    => date('Y-m-d'),
						"end_date"      => date('Y-m-d  23:59:59', strtotime(' +1 '.$frequency.'')),
						"price"         => floatval($package->price),
						"payment_type"  => 'paypal',
						"transaction_id"  => $new_transaction_id,
						"total_credits"  => ceil($credit_balance),
						"rolledover_credits"  => ceil($rollderOverCredits),
						"status"        => 'active',
					];
					
					//echo '<pre>';print_r($studentPackage);
					$student_package = StudentPackages::create($studentPackage);
					$student_package_id = $student_package->id;
					
					$newTransaction = StudentTransactions::where('id', $new_transaction_id)->first();
					$newTransaction->student_package_id = $student_package_id;
					
					
					// create and send invoice
					if(env('IS_ZOHO_ENABLED') == 1) {
						$invoice_id = 0;
						if(!empty($user) && $user->zoho_user_id > 0) {
							$zoho_user_id = $user->zoho_user_id;
							$email = $user->email;
						}
						
						if(!empty($package) && $package->zoho_item_id > 0) {
							$zoho_item_id = $package->zoho_item_id;
						}
						
						if($zoho_user_id != '' && $zoho_item_id != '') {
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
								//exit;
							$output = ZohoHelper::createInvoice($jsondata);
							if($output['code'] == 0) {
								 $invoice_id = $output['invoice']['invoice_id'];
								 $newTransaction->zoho_invoice_id = $invoice_id;
							}				
							
							$jsondata = '{
								"customer_id": "'.$zoho_user_id.'",
								"payment_mode": "cash",
								"amount": "'.$stTr->amount.'",
								"date": "'.$date.'",
								"description": "Payment has been added.",
								"invoices": [
									{
										"invoice_id": "'.$invoice_id.'",
										"amount_applied": "'.$stTr->amount.'"
									}
								]
							}';
							$output = ZohoHelper::updateInvoice($jsondata);
							
								
							$msg = '';						
							$jsondata = '{"send_from_org_email_id": true,"to_mail_ids": ["'.$email.'"]}';
							$output = ZohoHelper::emailInvoice($jsondata, $invoice_id);
							if($output['code'] == 0) {
								//$msg = '<br>And invoice also has been Send.';
							}					
						}
					}
					$newTransaction->save();
                //}
				}
            }
        }
    }
	
	function line_webhook() {
		
		
		$data = file_get_contents('php://input');
		/*$fp = fopen(public_path('line.txt'), 'a+');
		fwrite($fp, $data."\r\n");
		fclose($fp);*/
		file_put_contents(public_path('line-log.txt'), date('Y-m-d H:i:s').PHP_EOL . $data . PHP_EOL, FILE_APPEND);
		//die('ok');
		$line_access_token = env('LINE_ACCES_TOKEN');
		//$data = '{"events":[{"type":"follow","replyToken":"e8c4167d6a294801bf4962847fe8a31b","source":{"userId":"Uaeb57c050913b806dbb0751ee1348130","type":"user"},"timestamp":1575982760394}],"destination":"Uedaa8eda8a21f03ad2e70541adfa1df8"}';
		$var = json_decode($data);
		
		if($var->events[0]->type == 'follow'){
			$replyToken = $var->events[0]->replyToken;
			$line_userId = $var->events[0]->source->userId;
			//echo '<pre>';print_r($replyToken);exit;
			//$query = 'select id from '.$wpdb->prefix.'tmp_line_users where user_id='.$line_userId.'';
			$lineUsers = TempLineUsers::where('user_id',$line_userId)
							->orderBy('id','DESC')
                            ->first();
			if(empty($lineUsers)) {
				/*$insert = 'insert into '.$wpdb->prefix.'tmp_line_users set ';
				$insert .= 'user_id = "'.$line_userId.'", ';
				$insert .= 'replyToken = "'.$replyToken.'"';
				$wpdb->query($insert);	*/
			
				$data = array(
							'user_id' => $line_userId,
							'replyToken' => $replyToken,						
							'status' => 0,						
						);
						
				$authUser = TempLineUsers::create($data);
					
				// Welcome messages
				$fields = array(
					'replyToken' => $replyToken,
					'messages' => array(array('type'=>'text', 'text'=>'Welcome to Accent. Please copy and paste the token in the message below, to your Accent profile.'))
				);
				$url = "https://api.line.me/v2/bot/message/reply";

				$fields = json_encode($fields);
				
				$ch = curl_init();
				curl_setopt($ch, CURLOPT_URL, $url);
				curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
				curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
				curl_setopt($ch, CURLOPT_POST, 1);

				$headers = array();
				$headers[] = "Content-Type: application/json";
				$headers[] = "Authorization: Bearer {$line_access_token}";
				curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

				$result = curl_exec($ch);
				if (curl_errno($ch)) {
					echo 'Error:' . curl_error($ch);
				}
				curl_close ($ch);
				
				// Send ReplyToken in separate message
				$fields = array(
					'to' => $line_userId,
					'messages' => array(array('type'=>'text', 'text'=>$replyToken))
				);
				$url = "https://api.line.me/v2/bot/message/push";

				$fields = json_encode($fields);
				
				$ch = curl_init();
				curl_setopt($ch, CURLOPT_URL, $url);
				curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
				curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
				curl_setopt($ch, CURLOPT_POST, 1);

				$headers = array();
				$headers[] = "Content-Type: application/json";
				$headers[] = "Authorization: Bearer {$line_access_token}";
				curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

				$result = curl_exec($ch);
				if (curl_errno($ch)) {
					echo 'Error:' . curl_error($ch);
				}
				curl_close ($ch);
			}
		}
	}
	
	function zoho_invoice_webhook() {	
		$data = file_get_contents('php://input');
		if(!is_dir(storage_path('zohoOauth'))) {
			mkdir(storage_path('zohoOauth'));
		}
		file_put_contents(storage_path('zohoOauth/update_invoice.php'), date('Y-m-d H:i:s').PHP_EOL . $data . PHP_EOL, FILE_APPEND);
		parse_str($data, $get_array);
		//echo '<pre>';print_r($get_array);
		if($get_array['inv_status'] == 'Paid') {
			$invoice_id = $get_array['invoice_id'];
			$amt = $get_array['amt'];
			$studentTransaction = StudentTransactions::where('zoho_invoice_id',$invoice_id)->first();	
			if($studentTransaction && $studentTransaction->payment_status == 'pending'){				
				$student_lesson_id = $studentTransaction->student_lesson_id;
				$student_package_id = $studentTransaction->student_package_id;				
				$studentTransaction->payment_status = 'succeeded';
				$studentTransaction->save();
				
				if(!empty($student_lesson_id) && $student_lesson_id > 0) {
					$studentLesson = StudentLessons::where('id', $student_lesson_id)->first();	
					$studentLesson->status = 1;
					$studentLesson->save();
				} else if(!empty($student_package_id) && $student_package_id > 0) {
					$studentPackage = StudentPackages::where('id', $student_package_id)->first();	
					$studentPackage->status = 'active';
					$studentPackage->save();					
				}
			}				
		}
	}
}
