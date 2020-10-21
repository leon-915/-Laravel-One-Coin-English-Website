<?php

namespace App\Http\Controllers\Student;

use App\Helpers\AppHelper;
use App\Models\Services;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;
use App\Models\Packages;
use App\Models\PaypalWebhook;
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
use PayPal\Api\Agreement;
use PayPal\Api\AgreementStateDescriptor;
use PayPal\Api\PaymentExecution;
use PayPal\Auth\OAuthTokenCredential;
use PayPal\Rest\ApiContext;
use PayPal\Api\Amount;
use PayPal\Api\CreditCard;
use PayPal\Api\Payer;
use PayPal\Api\Payment;
use PayPal\Api\Plan;
use PayPal\Api\RedirectUrls;
use PayPal\Api\ShippingAddress;
use PayPal\Api\Transaction;
use PayPal\Api\WebhookEventType;

use function GuzzleHttp\json_decode;

class SubscriptionController extends Controller {

    public function paypalPayment(Request $request) {
        $input = $request->all();

        //$datetime = Carbon::now("UTC");
        $datetime = Carbon::now();
        $startDate = $datetime->addMinutes(10)->format('c');
        //$startDate = date('c', time() + 3600);

        $netAmount = $request->get('netAmount');
        $subtotal = $request->get('subtotal');
        $tax = $request->get('tax') ? $request->get('tax') : 0;

        $user = Auth::user();

        $package = Packages::find($request->get('package_id'));
		$time = time() + 600;
		$startDate = date('Y-m-d\TH:i:s\Z', $time);

        $studentTransaction = [
            "user_id" => $user->id,
            "provider" => 'paypal',
            "amount" => $netAmount,
            "transaction_type" => "package_billing",
            "transaction_type_id" => $input['package_id'],
            "payment_status" => 'pending',
            "discount" => 0,
            "subtotal" => $subtotal,
            "one_page_fee" => 0,
            "tax" => $tax,
            'payment_ip' => $request->getClientIp()
        ];

        $studentTransaction = StudentTransactions::create($studentTransaction);

        $agreement = new Agreement();
        $agreement->setName($package['title'])
            ->setDescription($package['description'])
            ->setStartDate($startDate);

        $plan = new Plan();
        $plan->setId($package['paypal_plan_id']);
        $agreement->setPlan($plan);

        $payer = new Payer();
        $payer->setPaymentMethod('paypal');
        $agreement->setPayer($payer);

        try {
            $agreementD = $agreement->create(AppHelper::paypalApiContex());
            $approvalUrl = $agreementD->getApprovalLink();

            return response()->json(['status' => 'success', 'redirectUrl' => $approvalUrl]);

        } catch (\PayPal\Exception\PayPalConnectionException $ex) {
            // echo '<pre>';
            // echo $ex->getCode();
            // echo $ex->getData();
            // die($ex);
            // echo '</pre>';
            // die;
            return response()->json(['status' => 'fail','code' => $ex->getCode(),'message'=>$ex->getData()]);
        }
    }

    public function paypalSuccess(Request $request) {
        $user = Auth::user();
        $token = $_GET['token'];
        $plan_id = $request->get('plan_id');

        $credential = new OAuthTokenCredential(env('PAYPAL_CLIENT_ID'), env('PAYPAL_CLIENT_SECRET'));
        $apiContext = new ApiContext($credential);
		$apiContext->setConfig(
			  array(
				'mode' => env('PAYPAL_PAYMENT_MODE'),
			  )
		);
        $studentTransaction = StudentTransactions::where('user_id', $user->id)
                                                            ->where('transaction_type','package_billing')
                                                            ->where('transaction_type_id',$plan_id)
                                                            ->orderBy('id','DESC')->first()
                                                            ;

        $agreement = new Agreement();

        try {
            $result = $agreement->execute($token, $apiContext);

            $user->billing_agreement_id = $result->getId();
            $user->billing_agreement_response = $result->toJSON();
            $user->save();

            $studentTransaction->billing_agreement_id = $result->getId();
            $studentTransaction->save();
            return redirect()->route('students.dashboard.index')->with(['message' => 'Your billing cycle will start soon.']);
        } catch (\PayPal\Exception\PayPalConnectionException $ex) {
            return response()->json(['status' => 'fail','code' => $ex->getCode(),'message'=>$ex->getData()]);
        }
    }

    public function paypalFail(Request $request) {
        $token = $_GET['token'];
        //return redirect()->route('students.account.index');
		return redirect()->route('pricing.index');
    }
	
	

    public function suspendSubscription() {
        $user = Auth::user();
        
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
			echo '<pre>';print_r($agreement);
		} catch (\PayPal\Exception\PayPalConnectionException $ex) {
			return response()->json(['status' => 'fail','code' => $ex->getCode(),'message'=>$ex->getData()]);
		}
    }
	
    public function reactivateSubscription() {
        $user = Auth::user();
        
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
			echo '<pre>';print_r($agreement);
		} catch (\PayPal\Exception\PayPalConnectionException $ex) {
			return response()->json(['status' => 'fail','code' => $ex->getCode(),'message'=>$ex->getData()]);
		}
    }
}
