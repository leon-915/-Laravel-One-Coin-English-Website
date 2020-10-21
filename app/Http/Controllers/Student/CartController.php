<?php

namespace App\Http\Controllers\Student;

use App\Helpers\AppHelper;
use App\Helpers\ZohoHelper;
use App\Models\Cart;
use App\Models\Coupons;
use App\Models\Services;
use App\Models\Settings;
use App\Models\StudentDetail;
use App\Models\StudentLessons;
use App\Models\StudentPackages;
use App\Models\StudentTransactions;
use App\Models\StudentOnbreakPlans;
use App\Models\ServiceCategories;
use App\Models\Categories;
use App\Jobs\SendEmailJob;
use Carbon\Carbon;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use PayPal\Api\PaymentExecution;
use PayPal\Auth\OAuthTokenCredential;
use PayPal\Rest\ApiContext;
use Stripe\Charge;
use Stripe\Customer;
use Stripe\Stripe;
use PayPal\Api\Amount;
use PayPal\Api\Payer;
use PayPal\Api\Payment;
use PayPal\Api\RedirectUrls;
use PayPal\Api\Transaction;
use PayPal\Api\Agreement;
use PayPal\Api\AgreementStateDescriptor;

class CartController extends Controller
{
    public function index()
    {
        $user_id = Auth::id();
        $cartDetail = Cart::with('service')
            ->where('user_id', $user_id)
            ->get();
        $discount = 0;

        $currentDate = Carbon::now();

        $packageCount = StudentPackages::where('user_id', Auth::id())
            ->where('start_date', '<=', $currentDate)
            ->where('end_date', '>=', $currentDate)
            ->count();

        $one_page_fee = 0;


        // $one_page_fee = Settings::getSettings('onepage_certified_fee');
        // if (!$one_page_fee) {
        //     $one_page_fee = 0;
        // }
        // if ($packageCount > 0) {
        //     $one_page_fee = 0;
        // }

        $default_payment_getway = Settings::getSettings('default_payment_getway');
        if ($default_payment_getway) {
            $default_payment_getway = explode(',', $default_payment_getway);
        }

        return view('students.cart.index', compact('cartDetail', 'discount', 'one_page_fee', 'default_payment_getway'));
    }

    public function addToCart($id)
    {
        // $user = Auth::user();

        // $replyToken = $user->line_token;
        // $replyToken = 'a57be51789e44e64a428205cab58a244';
        // $messages = [];
        // $messages ['replyToken'] = $replyToken;
        // $messages ['messages'] [0] = AppHelper::getFormatTextMessage("test");
        //     $messages ['messages'] [1] = AppHelper::getFormatTextMessage($replyToken);

        // $encodeJson = json_encode($messages);
        // $message = AppHelper::sentMessage($encodeJson);
        // dd($message);
        $user_id = Auth::id();
        $input['user_id'] = $user_id;
        $input['service_id'] = $id;
        Cart::create($input);

        return redirect()->route('students.cart.index')->with(['message' => 'Added service to cart successfully']);
    }

    public function deleteFromCart($id)
    {
        $user_id = Auth::user()->id;
        Cart::find($id)->delete();

        $cartDetail = Cart::where('user_id', $user_id)->get()->toArray();

        if (!empty($cartDetail)) {
            return redirect()->route('students.cart.index')->with(['message' => 'Service removed from cart successfully.']);
        } else {
            return redirect()->route('pricing.index')->with(['message' => 'Service removed from cart successfully.']);
        }
    }

    public function validateCoupon(Request $request)
    {
        $coupon = $request->get('coupon');
        $user_id = Auth::id();
        $currentDate = Carbon::now()->format('Y-m-d');
        $couponData = Coupons::where('coupon_code', $coupon)
            ->where('to_date', '>=', $currentDate)
            ->where('from_date', '<=', $currentDate)
            ->where('status', 1)
            ->first();

        $usedByUser = StudentTransactions::where(['coupon_code' => $coupon, 'user_id' => $user_id])
            ->count();

        $totalUsed = StudentTransactions::where(['coupon_code' => $coupon])->count();

        if (!empty($couponData)) {
            if ($couponData->usage_limit_per_coupon != 0) {
                if ($couponData->usage_limit_per_coupon <= $totalUsed) {
                    return response()->json(['type' => 'fail', 'message' => 'coupon usage limit exceeded.']);
                }
            }

            if ($couponData->usage_limit_per_user != 0) {
                if ($couponData->usage_limit_per_user <= $usedByUser) {
                    return response()->json(['type' => 'fail', 'message' => 'coupon usage limit exceeded for you.']);
                }
            }
        }


        if (empty($couponData)) {
            return response()->json(['type' => 'fail', 'message' => 'Coupon Code is not valid.!']);
        } else {
            $discount = $couponData->discount;
            return response()->json(['type' => 'success', 'discount_type' => $couponData->discount_type, 'discount' => $discount]);
        }
    }

	//Not in use
    public function paymentStripe(Request $request)
    {
        $coupon = $request->get('valid_coupon');
        $discount = $request->get('discount');
        $netAmount = $request->get('netAmount');
        $subtotal = $request->get('subtotal');
        $one_page_fee = $request->get('one_page_fee');
        $tax = $request->get('tax');

        $user = Auth::user();
        Stripe::setApiKey('sk_test_WKLoGh2EE8fRYsIoXOxhpkgN');
        if ($user->stripe_customer_id != '') {
            $customer = Customer::retrieve($user->stripe_customer_id);
        } else {
            $customer = Customer::create([
                'email' => $user->email,
                //'source' => $token_id,
                'source' => 'tok_visa', // change on production mode
            ]);

            $user->update(['stripe_token' => $request->token_id, 'stripe_customer_id' => $customer->id]);
        }

        $charge = Charge::create([
            'customer' => $customer->id,
            'description' => 'Test',
            'amount' => $netAmount,
            'currency' => 'jpy',
        ]);

        $cart = Cart::where('user_id', Auth::id())->get()->toArray();
        $services = array_column($cart, 'service_id');

        $studentLesson = [];
        $serviceTotal = 0;
        foreach ($services as $service) {
            $service = Services::where('id', $service)->first();
            $amount = $service->price;
            $serviceTotal += $amount;

            $studentLesson['user_id'] = Auth::id();
            $studentLesson['service_id'] = $service->id;
            $studentLesson['available_bookings'] = $service->available_lessons;
            $studentLesson['price'] = ($service->price);
            //$studentLesson['start_date'] = Carbon::now()->format('Y-m-d');

            StudentLessons::create($studentLesson);
        }


        $services = implode(',', $services);

        if ($charge['status'] == 'succeeded') {

            Cart::where('user_id', Auth::id())->delete();

            $studentTransaction = [
                "user_id" => $user->id,
                "provider" => 'stripe',
                "transaction_id" => $charge->balance_transaction,
                "stripe_customer_id" => $charge->customer,
                "amount" => $netAmount,
                "stripe_payment_method_id" => $charge->payment_method,
                "transaction_type" => "multi_service",
                "transaction_type_id" => $services,
                "payment_status" => $charge['status'],
                "response" => json_encode($charge),
                "discount" => $discount,
                "coupon_code" => $coupon,
                "subtotal" => $subtotal,
                "one_page_fee" => $one_page_fee,
                "tax" => $tax
            ];

            StudentTransactions::create($studentTransaction);

            if (!empty($user->line_token)) {
                $messages = [];
                $messages['to'] = $user->line_token;
                $msg = "You have successfully purchased services\n";
                $services = explode(',', $services);

                foreach ($services as $service) {

                    $service = Services::where('id', $service)->first();

                    $msg .= "Service : " . $service->title . "\n";
                    $msg .= "Price : ¥" . $service->price . "\n";
                }

                $messages['messages'][] = AppHelper::getFormatTextMessage($msg);
                $encodeJson = json_encode($messages);
                AppHelper::sentMessage($encodeJson);
            }


            // $studentPoints = StudentDetail::where('user_id', Auth::id())->first();
            // $studentPoints->credit_balance = $serviceTotal;
            // $studentPoints->save();

            return response()->json(['status' => 'success']);

        } else {
            return response()->json(['status' => 'fail']);
        }
    }

    public function paypalPayment(Request $request)
    {
        $user = Auth::user();
        $payer = new Payer();
        $payer->setPaymentMethod("paypal");

        $coupon = $request->get('valid_coupon');
        $discount = $request->get('discount');
        $netAmount = $request->get('netAmount');
		$tax = $request->get('tax') ? $request->get('tax') : 0;
		if(empty($coupon)) {
			$netAmount = $netAmount + $tax;
		}
		
        $subtotal = $request->get('subtotal');
        $one_page_fee = $request->get('one_page_fee') ? $request->get('one_page_fee') : 0;
        

		$currentDate = Carbon::now()->format('Y-m-d');
		$couponData = Coupons::where('coupon_code', $coupon)
			->where('to_date', '>=', $currentDate)
			->where('from_date', '<=', $currentDate)
			->where('status', 1)
			->first();
		$discount_type = 1;	
		if(!empty($couponData)) {	
			$discount_type = $couponData->discount_type;
		}
			
        $amount = new Amount();
        $amount->setTotal($netAmount);
        $amount->setCurrency('JPY');

        $transaction = new Transaction();
        $transaction->setAmount($amount);

        $cart = Cart::where('user_id', Auth::id())->get()->toArray();
        $services = array_column($cart, 'service_id');
		if(!empty($services)) {
			$services = implode(',', $services);

			$studentTransaction = [
				"user_id" => $user->id,
				"provider" => 'paypal',
				"amount" => $netAmount,
				"transaction_type" => "multi_service",
				"transaction_type_id" => $services,
				"payment_status" => 'pending',
				"discount" => $discount,
				"coupon_code" => $coupon,
				"discount_type" => $discount_type,
				"subtotal" => $subtotal,
				"one_page_fee" => $one_page_fee,
				"tax" => $tax,
				'payment_ip' => $request->getClientIp()
			];

			$studentTransaction = StudentTransactions::create($studentTransaction);

			$redirectUrls = new RedirectUrls();
			$returnUrl = url('student/paypal-success/?trans_id=' . $studentTransaction->id);
			$cancelUrl = url('student/paypal-fail/?trans_id=' . $studentTransaction->id);

			$redirectUrls->setReturnUrl($returnUrl)
				->setCancelUrl($cancelUrl);

			$payment = new Payment();
			$payment->setIntent('sale')
				->setPayer($payer)
				->setTransactions(array($transaction))
				->setRedirectUrls($redirectUrls);

			try {
				$credential = new OAuthTokenCredential(env('PAYPAL_CLIENT_ID'), env('PAYPAL_CLIENT_SECRET'));

				$apiContext = new ApiContext($credential);
				$apiContext->setConfig(
					  array(
						'mode' => env('PAYPAL_PAYMENT_MODE'),
					  )
				);
				
				$payment->create($apiContext);

				$approvalUrl = $payment->getApprovalLink();

				return response()->json(['status' => 'success', 'redirectUrl' => $approvalUrl]);

			} catch (\PayPal\Exception\PayPalConnectionException $ex) {
				echo '<pre>';
				echo $ex->getCode();
				echo $ex->getData();
				die($ex);
				echo '</pre>';
				die;
				return response()->json(['status' => 'fail']);
			}
		} else {
			return response()->json(['status' => 'servicemissing']);
		}
    }

    public function paypalSuccess(Request $request) {
        $user_id = Auth::user()->id;
        $student = User::where('id', $user_id)->first();
		$zoho_user_id = $student->zoho_user_id;
		$email = $student->email;
		
        $studentDetails = $student->details()->first();

        $user = Auth::user();
        $credential = new OAuthTokenCredential(env('PAYPAL_CLIENT_ID'), env('PAYPAL_CLIENT_SECRET'));
        $apiContext = new ApiContext($credential);
		$apiContext->setConfig(
			  array(
				'mode' => env('PAYPAL_PAYMENT_MODE'),
			  )
		);
        $paymentId = $_GET['paymentId'];
        $trans_id = $_GET['trans_id'];

        $studentTransaction = StudentTransactions::find($trans_id);

        $payment = Payment::get($paymentId, $apiContext);

        $execution = new PaymentExecution();
        $execution->setPayerId($_GET['PayerID']);

        $transaction = new Transaction();
        $amount = new Amount();

        $amount->setCurrency('JPY');
        $amount->setTotal($studentTransaction->amount);

        $transaction->setAmount($amount);
        $execution->addTransaction($transaction);

        $services = $studentTransaction->transaction_type_id;
        $services = explode(',', $services);

        $lines = $invoiceItemArray = [];
		$zohoTaxId = config('services.zcrm.zoho_tax_id');

		$courseArray = [];
		$serviceTotal = $totalTax = 0;
        try {
            $result = $payment->execute($execution, $apiContext);
            try {
                $payment = Payment::get($paymentId, $apiContext);
                Cart::where('user_id', Auth::id())->delete();
                $studentTransaction->transaction_id = $paymentId;
                $studentTransaction->response = $payment;
                $studentTransaction->payment_status = 'succeeded';

                $studentLessonids = [];
                
                $tax = Settings::getSettings('tax');

				// check if coupon is valid
				$currentDate = Carbon::now()->format('Y-m-d');
				$coupon = $studentTransaction->coupon;				
				$discount = $studentTransaction->discount;
				$discount_type = $studentTransaction->discount_type;
					
				
                if (!empty($user->line_token)) {
                    $messages = [];
                    $messages['to'] = $user->line_token;
                    $msg = "You have successfully purchased services\n";
                }

                foreach ($services as $index => $service) {
					$studentLesson = [];
                    $service = Services::where('id', $service)->first();
					$amount = $service->price;
					//$amount = $service->price;
					$amt = $amount;					
					
					if(!empty($coupon)) {
						if($discount_type == 1 && $amount >= $discount) {
							$amt = $amount - $discount;
						} else {
							$amt = $amount - (($amount * $discount) / 100);
						}
					}
					
                    $serviceTotal += $amt;
					$courseArray[] = array('title' => $service->title, 'price' => $amt);
                    

                    if ($service->service_type == 'onepage') {
                        $user->onepage_start_date = date('Y-m-d');
                        $user->onepage_end_date = date('Y-m-d', strtotime('+1 Year'));
                        $user->save();
						
                    } elseif ($service->service_type == 'registration') {
                        $user->is_registerfee_paid = 1;
                        $user->save();
						
                    } elseif ($service->service_type == 'credit') {
                        $creditBalance = $studentDetails->credit_balance;
                        $studentDetails->credit_balance = $creditBalance + $amount;
                        $studentDetails->save();
                    } elseif ($service->service_type == 'onbreak') {
                        $studentPackage = StudentPackages::where('user_id',Auth::id())->first();
                        if(!empty($studentPackage) && $studentPackage->toArray()){
                            $onbreakPrice = $service->price;
                            $taxamt = $onbreakPrice * $tax /100;

                            $amt = $onbreakPrice+$taxamt;

                            $nstart = new Carbon($studentPackage->start_date);
                            $nend   = new Carbon($studentPackage->end_date);

                            //$studentPackage->start_date = $nstart->addDays(30);
                            $studentPackage->end_date   = $nend->addDays(30);;
                            $studentPackage->status     = 'onhold';
                            $studentPackage->save();
                        }
						
						// record on break plan entry
						$studentOnbreakPlans = [
							"user_id" => $user->id,
							"package_id" => $studentPackage->id,
							"amount" => $service->price,
							"start_date" => date('Y-m-d', time()),
							"end_date" => date('Y-m-d', strtotime(date('Y-m-d'). '+30 days')),
							"status" => 'active',
						];
						
						$studentOnbreakPlans = StudentOnbreakPlans::create($studentOnbreakPlans); 
						$this->suspendSubscription($user); // suspend subscription
						
                    } else {
                        $stLessons = StudentLessons::where('service_id', $service->id)->where('user_id',Auth::id())->first();

                        if(1==2 && $stLessons){ // no need to update existing. always create a new entry
                            $availableBooking = $stLessons->available_bookings;
                            $stLessons->available_bookings = $availableBooking + $service->available_lessons;
                            if($stLessons->expire_date){
                                $expire_date      = new Carbon($stLessons->expire_date);
                                $stLessons->expire_date = $expire_date->addDays($service->no_of_days);
                            }
                            $stLessons->save();
                        } else {
                            $studentLesson['user_id'] = Auth::id();
                            $studentLesson['service_id'] = $service->id;
                            $studentLesson['available_bookings'] = $service->available_lessons;
                            $studentLesson['price'] = $amt + (($amt * $tax) / 100);
                            //$studentLesson['start_date'] = Carbon::now()->format('Y-m-d');
							$studentLesson['start_date']  = date('Y-m-d', time());
							$expire_date = new Carbon(date('Y-m-d', time()));
                            $studentLesson['expire_date'] = $expire_date->addDays($service->no_of_days);
							$studentLesson['transaction_id'] = $trans_id;
							// calculate rolled over lessons if any
							//echo '<pre>';print_r($studentLesson);exit;
                            $studentLessonid = StudentLessons::create($studentLesson);
							$studentLessonids[] = $studentLessonid->id;
							
							$zoho_item_id = $service->zoho_item_id;
							$serviceTitle = $amt;
							$price = $amt;
							
							if($zoho_user_id != '' && $zoho_item_id != '') {
								$invoiceItemArray[] = array("item_id"=>"$zoho_item_id", "name" => "$serviceTitle", "rate" => "$price", "quantity" => "1", "tax_id" => "$zohoTaxId", "tax_name" => "Standard", "tax_type" => "tax", "tax_percentage" => "$tax", "item_total" => "$price");
							}
                        }
                    }

                    if (!empty($user->line_token)) {
                        $msg .= "Service : " . $service->title . "\n";
                        $msg .= "Price : " . $amt . "\n";
                    }

                    
					$totalTax = $totalTax + (($amt * $tax) / 100);
                    $description = !empty($service->description) ? $service->description : $amt;

                   

                    $lines[$index] = [
                                'type' => 0,
                                'name' => $service->title,
                                'description' => $description,
                                'qty' => 1,
                                'taxName1' => 'TAX',
                                'taxAmount1' => $tax,
                                'unit_cost' => [
									'amount' => $amt,
									'code' => 'JPY'
                                ]
                            ];

                   
                }

                if (!empty($user->line_token)) {
                    $messages['messages'][] = AppHelper::getFormatTextMessage($msg);
                    $encodeJson = json_encode($messages);
                    AppHelper::sentMessage($encodeJson);
                }
            } catch (\PayPal\Exception\PayPalConnectionException $ex) {
            }
        } catch (\PayPal\Exception\PayPalConnectionException $ex) {}

		if(!empty($studentLessonids)) {
			$studentLessonids = implode(',', $studentLessonids);
			$studentTransaction->student_lesson_id = $studentLessonids;
		}
	
		$student->is_active = 1;
		$student->save();
		
		//send email to student and admin.
		if(env('IS_EMAIL_ENABLED') == 1){
			$template = "emails.coursePurchased";
			$subject = 'Your '.env('APP_NAME').' order from '.date('m').'月 '.date('d').', '.date('Y').' is complete.';
			
			$user2 = User::where('id', 363)->first();
			$tdata = [
				'user' => $user2,
				'customer_email' => $student->email,
				'courses' => $courseArray,
				'orderTotal' => $serviceTotal,
				'taxAmt' => $totalTax,
				'order_number' => $trans_id,
				'payment_method' => 'PayPal',
				'status' => 1,
				'site_name' => env('APP_NAME'),
			];
			dispatch(new SendEmailJob($template, $tdata, $subject, 'user'));
		}
		
		// create and send invoice
		if(env('IS_ZOHO_ENABLED') == 1 && !empty($invoiceItemArray)) {
			$invoice_id = 0;
			
			if($zoho_user_id > 0) {
				
				$date = date('Y-m-d');
				$invoice_number = ZohoHelper::get_invoice_no();
				$jsondata = '{"customer_id": '.$zoho_user_id.',"date": '.$date.', "invoice_number":'.$invoice_number.', 
					"line_items": '.json_encode($invoiceItemArray).',
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
				
				if($output['code'] == 0) {
					 $invoice_id = $output['invoice']['invoice_id'];
					 $studentTransaction->zoho_invoice_id = $invoice_id;
				}
				$totalAmt = $serviceTotal + $totalTax;
				$jsondata = '{
								"customer_id": "'.$zoho_user_id.'",
								"payment_mode": "cash",
								"amount": "'.$totalAmt.'",
								"date": "'.$date.'",
								"description": "Payment has been added.",
								"invoices": [
									{
										"invoice_id": "'.$invoice_id.'",
										"amount_applied": "'.$totalAmt.'"
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
		$studentTransaction->save(); 

        return redirect()->route('students.dashboard.index')->with(['message' => 'Payment Done Successfully']);
    }

    public function paypalFail(Request $request)
    {
        $token = $_GET['token'];
        $trans_id = $_GET['trans_id'];

        $studentTransaction = StudentTransactions::find($trans_id);
        $studentTransaction->transaction_id = $token;
        $studentTransaction->payment_status = 'failed';
        $studentTransaction->save();

        return redirect()->route('students.cart.index');
    }

    public function bankPayment(Request $request)
    {
		
		$user = Auth::user();
        $user_id = Auth::user()->id;
        $coupon = $request->get('valid_coupon');		
        $discount = $request->get('discount');		
		$tax = $request->get('tax') ? $request->get('tax') : 0;	
		$netAmount = $request->get('netAmount');
		if(empty($coupon)) {
			$netAmount = $netAmount + $tax;
		}		
        
		$amountBeforeTax = $netAmount - $tax;
        $subtotal = $request->get('subtotal');
		$discount_type = 1;
        $one_page_fee = $request->get('one_page_fee') ? $request->get('one_page_fee') : 0;
       

        $cart = Cart::where('user_id', Auth::id())->get()->toArray();
        $servicesArray = array_column($cart, 'service_id');
        $services = implode(',', $servicesArray);
		if(empty($services)) {
			return response()->json(['status' => 'servicemissing']);
		}
		// check if coupon is valid
		$currentDate = Carbon::now()->format('Y-m-d');
		$couponData = Coupons::where('coupon_code', $coupon)
			->where('to_date', '>=', $currentDate)
			->where('from_date', '<=', $currentDate)
			->where('status', 1)
			->first();
		
		$is_coupon_allowed = false;
		if(!empty($couponData)) {
	
			$usedByUser = StudentTransactions::where(['coupon_code' => $coupon, 'user_id' => $user_id])
				->count();

			$totalUsed = StudentTransactions::where(['coupon_code' => $coupon])->count();
			
			
			if (!empty($couponData)) {
				if ($couponData->usage_limit_per_coupon != 0) {
					if ($couponData->usage_limit_per_coupon <= $totalUsed) {
						$is_coupon_allowed = false;
					} else {
						$is_coupon_allowed = true;
					}
				}

				if ($is_coupon_allowed == true && $couponData->usage_limit_per_user != 0) {
					if ($couponData->usage_limit_per_user <= $usedByUser) {
						$is_coupon_allowed = false;
					} else {
						$is_coupon_allowed = true;
					}
				}
			}

			if ($is_coupon_allowed == true) {
				$discount = $couponData->discount;
				$discount_type = $couponData->discount_type;
			}
		}
		
        $studentTransaction = [
            "user_id" => $user_id,
            "provider" => 'direct_bank_transfer',
            "amount" => $netAmount,
            "transaction_type" => "multi_service",
            "transaction_type_id" => $services,
            "payment_status" => 'pending',
            "discount" => $discount,
            "discount_type" => $discount_type,
            "coupon_code" => $coupon,
            "subtotal" => $subtotal,
            "one_page_fee" => $one_page_fee,
            "tax" => $tax,
            'payment_ip' => $request->getClientIp()
        ];

        $studentTransaction = StudentTransactions::create($studentTransaction);
		$trans_id = $studentTransaction->id;
        
        $student = User::where('id', $user_id)->first();
		$zoho_user_id = $student->zoho_user_id;
		$email = $student->email;
		$zohoTaxId = config('services.zcrm.zoho_tax_id');
		
        $studentDetails = $student->details()->first();      
		$tax = Settings::getSettings('tax');

        $serviceTotal = $totalTax = 0;
		$msg = '';
		$student_lesson_ids = $invoiceItemArray = [];
			
		foreach ($servicesArray as $index => $service) {
			$service = Services::where('id', $service)->first();

			$amount = $service->price;	
			if($is_coupon_allowed == true) {
				if($discount_type == 1 && $amount >= $discount) {
					$amt = $amount - $discount;
				} else {
					$amt = $amount - (($amount * $discount) / 100);
				}
			} else {
				$amt = $amount;
			}
			$serviceTotal += $amt;
			$courseArray[] = array('title' => $service->title, 'price' => $amt);
			$totalTax = $totalTax + (($amt * $tax) / 100);
			
			/*if ($service->service_type == 'onepage') {
				$user->onepage_start_date = date('Y-m-d');
				$user->onepage_end_date = date('Y-m-d', strtotime('+1 Year'));
				$user->save();
				
			} elseif ($service->service_type == 'registration') {
				$user->is_registerfee_paid = 1;
				$user->save();
				
			} elseif ($service->service_type == 'credit') {
				$creditBalance = $studentDetails->credit_balance;
				$studentDetails->credit_balance = $creditBalance + $amount;
				$studentDetails->save();
			} else*/ if ($service->service_type == 'onbreak') {
				$studentPackage = StudentPackages::where('user_id',Auth::id())->first();
				if(!empty($studentPackage) && $studentPackage->toArray()){
					$onbreakPrice = $service->price;
					
					$taxamt = $onbreakPrice * $tax /100;

					$amt = $onbreakPrice+$taxamt;

					$nstart = new Carbon($studentPackage->start_date);
					$nend   = new Carbon($studentPackage->end_date);

					//$studentPackage->start_date = $nstart->addDays(30);
					$studentPackage->end_date   = $nend->addDays(30);;
					$studentPackage->status     = 'onhold';
					$studentPackage->save();
				}
				
				// record on break plan entry
				$studentOnbreakPlans = [
					"user_id" => $user_id,
					"package_id" => $studentPackage->id,
					"amount" => $service->price,
					"start_date" => date('Y-m-d', time()),
					"end_date" => date('Y-m-d', strtotime(date('Y-m-d'). '+30 days')),
					"status" => 'pending',
				];
				
				$studentOnbreakPlans = StudentOnbreakPlans::create($studentOnbreakPlans); 
				$this->suspendSubscription($user); // suspend subscription
				
			} else {
				$stLessons = StudentLessons::where('service_id', $service->id)->where('user_id', $user_id)->first();                        
				$studentLesson['user_id'] = $user_id;
				$studentLesson['service_id'] = $service->id;
				$studentLesson['available_bookings'] = $service->available_lessons;
				$studentLesson['price'] = $amt + (($amt * $tax) / 100);
				$studentLesson['start_date']  = date('Y-m-d', time());
				$studentLesson['status']  = 0;
				$studentLesson['is_expired']  = 0;
				$studentLesson['transaction_id']  = $trans_id;
				$expire_date = new Carbon(date('Y-m-d', time()));
				$studentLesson['expire_date'] = $expire_date->addDays($service->no_of_days);
				$student_lesson = StudentLessons::create($studentLesson);  
				$student_lesson_ids[] = $student_lesson->id;

				$zoho_item_id = $service->zoho_item_id;
				$serviceTitle = $service->title;
				$price = $amt;
				
				if($zoho_user_id != '' && $zoho_item_id != '') {
					$invoiceItemArray[] = array("item_id"=>"$zoho_item_id", "name" => "$serviceTitle", "rate" => "$price", "quantity" => "1", "tax_id" => "$zohoTaxId", "tax_name" => "Standard", "tax_type" => "tax", "tax_percentage" => "$tax", "item_total" => "$amt");
				}		
			}

			/*if (!empty($user->line_token)) {
				$msg .= "Service : " . $service->title . "\n";
				$msg .= "Price : " . $netAmount . "\n";
			}*/

			
		}
		
		if(!empty($student_lesson_ids)){
			$student_lesson_ids = implode(',', $student_lesson_ids);
			$studentransaction = StudentTransactions::find($trans_id);
			$studentTransaction->student_lesson_id = $student_lesson_ids;
			$studentTransaction->save();
		}
		
		Cart::where('user_id', $user_id)->delete();
		
		if (!empty($user->line_token)) {
			$messages['messages'][] = AppHelper::getFormatTextMessage($msg);
			$encodeJson = json_encode($messages);
			AppHelper::sentMessage($encodeJson);
		}
        
		//send email to student and admin.
		if(env('IS_EMAIL_ENABLED') == 1){
			$template = "emails.coursePurchased";
			$subject = 'Your '.env('APP_NAME').' order from '.date('m').'月 '.date('d').', '.date('Y').' is complete.';
			
			$user = User::where('id', 363)->first();
			$tdata = [
				'user' => $user,
				'customer_email' => $student->email,
				'courses' => $courseArray,
				'orderTotal' => $serviceTotal,
				'taxAmt' => $totalTax,
				'order_number' => $trans_id,
				'payment_method' => 'Bank Transfer',
				'status' => 0,
				'site_name' => env('APP_NAME'),
			];
			dispatch(new SendEmailJob($template, $tdata, $subject, 'user'));
		}
		
		// create and send invoice
		if(env('IS_ZOHO_ENABLED') == 1 && !empty($invoiceItemArray)) {
			$invoice_id = 0;
			
			if($zoho_user_id > 0) {
				
				$date = date('Y-m-d');
				$invoice_number = ZohoHelper::get_invoice_no();
				$jsondata = '{"customer_id": '.$zoho_user_id.',"date": '.$date.', "invoice_number":'.$invoice_number.', 
					"line_items": '.json_encode($invoiceItemArray).',
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
				
				if($output['code'] == 0) {
					$invoice_id = $output['invoice']['invoice_id'];
					$studenttransaction = StudentTransactions::find($trans_id);
					$studenttransaction->zoho_invoice_id = $invoice_id;
					$studenttransaction->save();
				}
				
				$msg = '';						
				$jsondata = '{"send_from_org_email_id": true,"to_mail_ids": ["'.$email.'"]}';
				$output = ZohoHelper::emailInvoice($jsondata, $invoice_id);
				if($output['code'] == 0) {
					//$msg = '<br>And invoice also has been Send.';
				}					
			}
		}
		
		$redirectUrl = url('student/order-detail/' . $trans_id);
		return response()->json(['status' => 'success', 'redirectUrl' => $redirectUrl]);
    }
	
	
	
	public function suspendSubscription($user = '') {
        if(!empty($user)) {
			$credential = new OAuthTokenCredential(env('PAYPAL_CLIENT_ID'), env('PAYPAL_CLIENT_SECRET'));
			$apiContext = new ApiContext($credential);
			$apiContext->setConfig(
				  array(
					'mode' => env('PAYPAL_PAYMENT_MODE'),
				  )
			);													
			//Create an Agreement State Descriptor, explaining the reason to suspend.
			$agreementStateDescriptor = new AgreementStateDescriptor();
			$agreementStateDescriptor->setNote("Suspending the agreement");
			/** @var Agreement $createdAgreement */
			$createdAgreementId = $user->billing_agreement_id; 

			try {
				$createdAgreement = Agreement::get($createdAgreementId, $apiContext);
				$createdAgreement->suspend($agreementStateDescriptor, $apiContext);			
				$agreement = Agreement::get($createdAgreement->getId(), $apiContext);
				return $agreement->state;
			} catch (\PayPal\Exception\PayPalConnectionException $ex) {
				return response()->json(['status' => 'fail','code' => $ex->getCode(),'message'=>$ex->getData()]);
			}
		}
    }
	
	public function aspireCoachingPricing() {
		$category_id = 1;
		$products  = Services::select('services.*')
			->where('services.status', 1)
            ->leftjoin('services_categories', 'services_categories.service_id', '=', 'services.id')
            ->join('categories', 'categories.id', '=', 'services_categories.category_id')
			->where('categories.id', $category_id)
			->where('categories.status', 1)
            ->get();
		//echo '<pre>';print_r($products);exit;	
		//select * from services a left join services_categories b on a.id = b.service_id inner join categories c on b.category_id = c.id where c.id = 1 and a.status=1 and c.status=1
		return view('students.product.index', compact('products', 'category_id'));
	}
	
	public function casualConversationPricing() {
		$category_id = 2;
		$products  = Services::select('services.*')
			->where('services.status', 1)
            ->leftjoin('services_categories', 'services_categories.service_id', '=', 'services.id')
            ->join('categories', 'categories.id', '=', 'services_categories.category_id')
			->where('categories.id', $category_id)
			->where('categories.status', 1)
            ->get();
		return view('students.product.index', compact('products', 'category_id'));
	}
	
	public function accentKidsPricing() {
		$category_id = 3;
		$products  = Services::select('services.*')
			->where('services.status', 1)
            ->leftjoin('services_categories', 'services_categories.service_id', '=', 'services.id')
            ->join('categories', 'categories.id', '=', 'services_categories.category_id')
			->where('categories.id', $category_id)
			->where('categories.status', 1)
            ->get();
		return view('students.product.index', compact('products', 'category_id'));
	}
}
