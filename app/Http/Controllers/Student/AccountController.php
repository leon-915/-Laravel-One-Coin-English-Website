<?php

namespace App\Http\Controllers\Student;

use App\Models\Services;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;
use App\Models\Packages;
use Stripe\Customer;
use Stripe\Stripe;
use Stripe\Charge;
use App\Models\StudentPackages;
use App\Models\StudentTransactions;
use App\Models\ServicePackages;
use App\Models\Settings;
use App\Models\StudentLessons;
use App\Models\StudentDetail;
use App\User;
use Carbon\Carbon;

use PayPal\Api\PaymentExecution;
use PayPal\Auth\OAuthTokenCredential;
use PayPal\Rest\ApiContext;
use PayPal\Api\Amount;
use PayPal\Api\CreditCard;
use PayPal\Api\Payer;
use PayPal\Api\Payment;
use PayPal\Api\RedirectUrls;
use PayPal\Api\Transaction;


class AccountController extends Controller
{
    public function index(Request $request){
        $user_id = Auth::user()->id;
        $student = User::where('id', $user_id)->first();
        $studentDetails = $student->details()->first();

        $user = Auth::user();
        $packages =  Packages::where('status',1)->orderBy('id','ASC')->get();

        $ref = $request->get('ref', 'classroom');
        $studentPackage = StudentPackages::where('user_id',Auth::id())->first();

        $onbreak = Services::where('service_type', 'onbreak')->first();

        return view('students.account.index', compact('user', 'packages','ref','studentPackage','onbreak'));
    }

    public function classRoomHtml(Request $request){

        $user_id = Auth::user()->id;
        $student = User::where('id', $user_id)->first();
        $studentDetails = $student->details()->first();

        $user = Auth::user();
        $studentServices = [];
        // $studentServices = StudentLessons::where('user_id', $user->id)
        //                                     ->where(function($query){
        //                                         $query->where('student_lessons.expire_date', '>=', date('Y-m-d'))
        //                                                 ->orwhereRaw('student_lessons.expire_date IS NULL');
        //                                     })
        //                                     ->pluck('service_id');

        $studentPackage = StudentPackages::where('user_id',Auth::id())
                                    ->whereRaw("start_date <= '".date('Y-m-d')."'::date")
                                    ->whereRaw("end_date >= '".date('Y-m-d')."'::date")
                                    ->where('status', 'active')->first();

        $packageServices = ServicePackages::distinct()->where('is_deleted', 0)->get(['service_id']);
        $pServices = [];

        foreach ($packageServices as $key => $value) {
            $pServices[] = $value['service_id'];
        }

        //$studentServices = $studentServices->toArray();

        $servicesArr = array_unique (array_merge ($pServices, $studentServices));

        $services = Services::where('is_system_service', 2)->whereRaw('price > 0')->whereNotIn('id', $servicesArr)->get();
        // $services = Services::all();
        $html = view('students.account.index.service',compact('user','services','student','studentDetails'))->render();
        return response()->json(['type' => 'success', 'html' => $html]);
    }

    public function payment(Request $request){

        $token_id = $request->token_id;
        $package_id = $request->package_id;
        $user = Auth::user();
        $package = Packages::find($package_id);

        $studentPackage = StudentPackages::where('user_id',Auth::id())->where('status','expired')->first();

        $package_services = ServicePackages::where('package_id',$package_id)
                                ->leftjoin('services','services.id','=','services_packages.service_id')
                                ->get();
        $tax = Settings::getSettings('tax');

        Stripe::setApiKey('sk_test_WKLoGh2EE8fRYsIoXOxhpkgN');
        if ($user->stripe_customer_id != '') {
            $customer = Customer::retrieve($user->stripe_customer_id);
        } else {
            $customer =  Customer::create([
                'email' => $user->email,
                //'source' => $token_id,
                'source' => 'tok_visa', // change on production mode
            ]);
        }

        $packagePrice = $package->price + ($package->price * $tax / 100);

        $charge = Charge::create([
            'customer' => $customer->id,
            'description' => $package->title,
            'amount' => $packagePrice * 100,
            'currency' => 'jpy',
        ]);

        if($charge['status'] == 'succeeded'){
            foreach($package_services as $p){
                $isExist = null;
                $isExist = StudentLessons::where('user_id', $user->id)->where('service_id',$p->service_id)->first();
                if($isExist){
                    $isExist->available_bookings = $p->available_lessons;
                    $isExist->expire_date = date('Y-m-d', strtotime(date('Y-m-d'). '+30 days'));
                    $isExist->price = $p->price;
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

            if(!empty($studentPackage)){
                $studentTransaction = [
                    "user_id" => $user->id,
                    "provider" => 'stripe',
                    "transaction_id" => $charge->balance_transaction,
                    "stripe_customer_id" => $charge->customer,
                    "amount" => $packagePrice,
                    "stripe_payment_method_id" => $charge->payment_method,
                    "transaction_type" => "package",
                    "transaction_type_id" => $package_id,
                    "payment_status" => $charge['status'],
                    "response" => json_encode($charge),
                    "discount" => 0,
                    "subtotal" => floatval($package->price),
                    "one_page_fee" => 0,
                    "tax" => ($package->price * $tax / 100)
                ];

                StudentTransactions::create($studentTransaction);
                $studentDetail = StudentDetail::where('user_id',$user->id)->first();

                $credit_balance = 0;
                if((time() - strtotime($studentPackage->end_date)) > 0){
                    if(((time() - strtotime($studentPackage->end_date)) <= 5*86400)) {
                        $oldBalance = 0;
                        if($package->roleover_condition){
                            $oldBalance = $studentDetail->credit_balance * $package->roleover_condition / 100 ;
                        }

                        $credit_balance = $oldBalance + $package->price - ( $package->registration_fee + $package->onepage_fee);
                    } else {
                        $credit_balance = $package->price - ( $package->registration_fee + $package->onepage_fee);
                    }
                } else {
                    $credit_balance = $studentDetail->credit_balance + $package->price - ( $package->registration_fee + $package->onepage_fee);
                }

                $studentDetail->current_package_id = $package_id;
                $studentDetail->package_end_date = date('Y-m-d', strtotime(' +1 month'));
                $studentDetail->credit_balance = ceil($credit_balance);
                $studentDetail->save() ;

                $studentPackage->package_id = $package_id;
                $studentPackage->start_date =  date('Y-m-d');
                $studentPackage->end_date =  date('Y-m-d', strtotime(' +1 month'));
                $studentPackage->price = floatval($package->price);
                $studentPackage->save();
            } else {
                $studentPackage = [
                    "user_id" => $user->id,
                    "package_id" => $package_id,
                    "start_date" => date('Y-m-d'),
                    "end_date" => date('Y-m-d', strtotime(' +1 month')),
                    "price" => floatval($package->price),
                    "status" => 'active'
                ];

                $studentTransaction = [
                    "user_id" => $user->id,
                    "provider" => 'stripe',
                    "transaction_id" => $charge->balance_transaction,
                    "stripe_customer_id" => $charge->customer,
                    "amount" => $packagePrice,
                    "stripe_payment_method_id" => $charge->payment_method,
                    "transaction_type" => "package",
                    "transaction_type_id" => $package_id,
                    "payment_status" => $charge['status'],
                    "response" => json_encode($charge),
                    "discount" => 0,
                    "subtotal" => floatval($package->price),
                    "one_page_fee" => 0,
                    "tax" => ($package->price * $tax / 100)
                ];

                $credit_balance = $package->price - ( $package->registration_fee + $package->onepage_fee);

                $studentDetail = StudentDetail::where('user_id',$user->id)->first();
                $studentDetail->current_package_id = $package_id;
                $studentDetail->package_end_date = date('Y-m-d', strtotime(' +1 month'));
                $studentDetail->credit_balance = ceil($credit_balance);
                $studentDetail->save() ;

                StudentPackages::create($studentPackage);
                StudentTransactions::create($studentTransaction);
            }

            $user->update(['stripe_token' => $token_id, 'stripe_customer_id' => $customer->id]);
        } else {
            $studentTransaction = [
                "user_id" => $user->id,
                "provider" => 'stripe',
                "transaction_id" => $charge->balance_transaction,
                "stripe_customer_id" => $charge->customer,
                "amount" => $packagePrice,
                "stripe_payment_method_id" => $charge->payment_method,
                "transaction_type" => "package",
                "transaction_type_id" => $package_id,
                "payment_status" => $charge['status'],
                "response" => json_encode($charge),
                "discount" => 0,
                "subtotal" => floatval($package->price),
                "one_page_fee" => 0,
                "tax" => ($package->price * $tax / 100)
            ];
            StudentTransactions::create($studentTransaction);

        }
        return response()->json($charge);
    }

    public function onBreak() {
        $user_id = Auth::user()->id;
		$student = User::where('id', $user_id)->first();
        $studentDetails = $student->details()->first();
        $onbreak = Services::where('service_type', 'onbreak')->first();

        return view('students.account.on-break', compact('user_id', 'student','studentDetails','onbreak'));
    }

    public function onBreakPayment(Request $request){

        $token_id = $request->token_id;
        $user = Auth::user();

        $studentPackage = StudentPackages::where('user_id',Auth::id())->first();

        if(!empty($studentPackage) && $studentPackage->toArray()){
            $onbreakPrice = 150;
            $tax = Settings::getSettings('tax');
            $taxamt = $onbreakPrice * $tax /100;

            $amt = $onbreakPrice+$taxamt;

            Stripe::setApiKey('sk_test_WKLoGh2EE8fRYsIoXOxhpkgN');
            if ($user->stripe_customer_id != '') {
                $customer = Customer::retrieve($user->stripe_customer_id);
            } else {
                $customer =  Customer::create([
                    'email' => $user->email,
                    //'source' => $token_id,
                    'source' => 'tok_visa', // change on production mode
                ]);
            }

            $charge = Charge::create([
                'customer' => $customer->id,
                'description' => '¥'.$onbreakPrice . ' + ' .$tax. '% included.',
                'amount' => $amt * 100,
                'currency' => 'jpy',
            ]);

            $studentPackage = StudentPackages::where('user_id',Auth::id())->first();

            $nstart = new Carbon($studentPackage->start_date);
            $nend = new Carbon($studentPackage->end_date);

            $studentPackage->start_date = $nstart->addDays(30);
            $studentPackage->end_date = $nend->addDays(30);;
            $studentPackage->status = 'onhold';
            $studentPackage->save();

            $studentTransaction = [
                "user_id" => $user->id,
                "provider" => 'stripe',
                "transaction_id" => $charge->balance_transaction,
                "stripe_customer_id" => $charge->customer,
                "amount" => $amt,
                "stripe_payment_method_id" => $charge->payment_method,
                "transaction_type" => "onbreak",
                "payment_status" => $charge['status'],
                "response" => json_encode($charge),
                "discount" => 0,
                "subtotal" => $onbreakPrice,
                "one_page_fee" => 0,
                "tax" => $taxamt
            ];

            StudentTransactions::create($studentTransaction);

            return response()->json(['type' => 'success', 'charge' => $charge]);
        } else {
            return response()->json(['type' => 'failure', 'message' => "You don't have any active subscriptions"]);
        }
    }

    public function paypalPayment(Request $request) {
        $input = $request->all();

        $user = Auth::user();
        $payer = new Payer();
        $payer->setPaymentMethod("paypal");

        $netAmount = $request->get('netAmount');
        $subtotal = $request->get('subtotal');

        $tax = $request->get('tax') ? $request->get('tax') : 0;

        $amount = new Amount();
        $amount->setTotal($netAmount);
        $amount->setCurrency('JPY');

        $transaction = new Transaction();
        $transaction->setAmount($amount);

        $studentTransaction = [
            "user_id" => $user->id,
            "provider" => 'paypal',
            "amount" => $netAmount,
            "transaction_type" => "package",
            "transaction_type_id" => $input['package_id'],
            "payment_status" => 'pending',
            "discount" => 0,
            "subtotal" => $subtotal,
            "one_page_fee" => 0,
            "tax" => $tax,
            'payment_ip' => $request->getClientIp()
        ];

        $studentTransaction = StudentTransactions::create($studentTransaction);

        $redirectUrls = new RedirectUrls();
        $returnUrl = url('student/package/paypal-success/?trans_id=' . $studentTransaction->id);
        $cancelUrl = url('student/package/paypal-fail/?trans_id=' . $studentTransaction->id);

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
            return response()->json(['status' => 'fail']);
        }
    }

    public function paypalSuccess(Request $request) {
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

        try {
            $result = $payment->execute($execution, $apiContext);
            try {
                $payment = Payment::get($paymentId, $apiContext);

                $studentTransaction->transaction_id = $paymentId;
                $studentTransaction->response = $payment;
                $studentTransaction->payment_status = 'succeeded';
                $studentTransaction->save();

                $studentPackage = StudentPackages::where('user_id',Auth::id())->first();

                $package_services = ServicePackages::where('package_id',$studentTransaction->transaction_type_id)
                                ->leftjoin('services','services.id','=','services_packages.service_id')
                                ->get();

                $package_id = $studentTransaction->transaction_type_id;

                $package = Packages::find($studentTransaction->transaction_type_id);

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

                if(strtotime(Auth::user()->onepage_start_date) < time() && time() < strtotime(Auth::user()->onepage_end_date)){
                    $onepagefee = 0;
                } else {
                    $user->onepage_start_date   = date('Y-m-d');
                    $user->onepage_end_date     = date('Y-m-d',strtotime('+1 Year'));
                }

                $user->is_registerfee_paid  = 1;
                $user->save();
				
				$subscription_fee = env('SUBSCRIPTION_FEE');
                if(!empty($studentPackage)){
                    $studentDetail = StudentDetail::where('user_id',$user->id)->first();

                    $credit_balance = 0;
                    if((time() - strtotime($studentPackage->end_date)) > 0){
                        if(((time() - strtotime($studentPackage->end_date)) <= 5*86400)) {
                            $oldBalance = 0;
                            if($package->roleover_condition){
                                $oldBalance = $studentDetail->credit_balance * $package->roleover_condition / 100 ;
                            }

                            //$credit_balance = $oldBalance + $package->price - ($onepagefee);
							$credit_balance = $oldBalance + $package->price - ($subscription_fee);
                        } else {
                            //$credit_balance = $package->price - ($package->registration_fee + $onepagefee);							
							$credit_balance = $package->price - ($subscription_fee);
                        }
                    } else {
                        //$credit_balance = $studentDetail->credit_balance + $package->price - ($onepagefee);						
						$credit_balance = $package->price - ($subscription_fee);
                    }

                    $studentDetail->current_package_id = $studentTransaction->transaction_type_id;
                    $studentDetail->package_end_date = date('Y-m-d', strtotime(' +1 month'));
                    $studentDetail->credit_balance = ceil($credit_balance);
                    $studentDetail->save() ;

                    $studentPackage->package_id = $studentTransaction->transaction_type_id;
                    $studentPackage->start_date =  date('Y-m-d');
                    $studentPackage->end_date =  date('Y-m-d', strtotime(' +1 month'));
                    $studentPackage->price = floatval($package->price);
                    $studentPackage->save();
                } else {
                    $studentPackage = [
                        "user_id" => $user->id,
                        "package_id" => $package_id,
                        "start_date" => date('Y-m-d'),
                        "end_date" => date('Y-m-d', strtotime(' +1 month')),
                        "price" => floatval($package->price),
                        "status" => 'active'
                    ];

                    $credit_balance = $package->price - $subscription_fee;

                    $studentDetail = StudentDetail::where('user_id',$user->id)->first();
                    $studentDetail->current_package_id = $package_id;
                    $studentDetail->package_end_date = date('Y-m-d', strtotime(' +1 month'));
                    $studentDetail->credit_balance = ceil($credit_balance);
                    $studentDetail->save() ;

                    StudentPackages::create($studentPackage);
                }
            } catch (\PayPal\Exception\PayPalConnectionException $ex) {
            }
        } catch (\PayPal\Exception\PayPalConnectionException $ex) {
        }
        return redirect()->route('students.dashboard.index')->with(['message' => 'Payment Done Successfully']);
    }

    public function paypalFail(Request $request) {
        $token = $_GET['token'];
        $trans_id = $_GET['trans_id'];

        $studentTransaction = StudentTransactions::find($trans_id);
        $studentTransaction->transaction_id = $token;
        $studentTransaction->payment_status = 'failed';
        $studentTransaction->save();

        return redirect()->route('students.cart.index');
    }
}
