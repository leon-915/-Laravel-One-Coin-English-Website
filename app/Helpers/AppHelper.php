<?php
namespace App\Helpers;

use App\AddUserAddress;
//use App\Libraries\GoogleCustom\GoogleContacts;
use App\LoyaltyStatus;
use Aws\Credentials\CredentialProvider;
use Aws\Sns\SnsClient;
use Carbon\Carbon;
use App\Store;
use App\Models\Settings;
use App\Models\Services;
use App\Models\StudentLessons;
use App\Models\StudentTransactions;
use App\Models\TeacherRatings;
use App\Device;
use App\Jobs\StatusNotification;
use App\Libraries\GoogleCustom\GoogleContacts;
use App\User;
use Illuminate\Support\Facades\Storage;
use DNS1D;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Http\Controllers\CmsController;
use PayPal\Api\Agreement;
use PayPal\Api\ChargeModel;
use PayPal\Api\Currency;
use PayPal\Api\MerchantPreferences;
use PayPal\Api\Patch;
use PayPal\Api\PatchRequest;
use PayPal\Api\Payer;
use PayPal\Api\PaymentDefinition;
use PayPal\Api\Payout;
use PayPal\Api\PayoutItem;
use PayPal\Api\PayoutSenderBatchHeader;
use PayPal\Api\Plan;
use PayPal\Api\ShippingAddress;
use PayPal\Auth\OAuthTokenCredential;
use PayPal\Common\PayPalModel;
use PayPal\Rest\ApiContext;
use App\Helpers\ZohoHelper;
use DB;
use App;

class AppHelper
{
    public static function freshBook($postData) {
        $domain = 'https://accentinc.freshbooks.com/api/2.1/xml-in';
        $token = '83ba50e0486bd00e43e3ca442586d79f';

        $ch = curl_init();    // initialize curl handle
        curl_setopt($ch, CURLOPT_URL, $domain); // set url to post to
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); // return into a variable
        curl_setopt($ch, CURLOPT_TIMEOUT, 40); // times out after 40s
        curl_setopt($ch, CURLOPT_POSTFIELDS, $postData); // add POST fields
        curl_setopt($ch, CURLOPT_USERPWD, $token . ':X');
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

        $response = curl_exec($ch);
        $err = curl_error($ch);

        curl_close($ch);

        if ($err) {
            return json_encode(['message' => 'fail', 'error' => $err]);
        } else {
            $data = simplexml_load_string($response);
            return json_encode(['message' => 'success', 'data' => $data]);
        }
    }

    public static function paypalApiContex() {
        $apiContext = new ApiContext(new OAuthTokenCredential(env('PAYPAL_CLIENT_ID'), env('PAYPAL_CLIENT_SECRET')));
		$apiContext->setConfig(
			  array(
				'mode' => env('PAYPAL_PAYMENT_MODE'),
			  )
		);
		return $apiContext;
    }

	public static function sendLineNotification($line_userId = '', $user_name = '', $service_name = '', $location = '', $datetime = '', $user_role = '', $status = 'new') {
		if ($line_userId != '' && $user_name != '' && $service_name != '' && $location != '' && $datetime != '') {

			if ($user_role == 'teacher') {
				if ($status == 'reminder') {

					$message = 'This is general reminder for the appointment you have with: ' . $user_name . ' at  ' . $location . ' for ' . $service_name.' at '. $datetime;
					
				} else if ($status == 'cancellled') {

					$message = 'The following appointment has been cancelled: ' . $service_name . ' with you on ' . $datetime . ' at this location ' . $location . ' with ' . $user_name . '';
				} else if ($status == 'rescheduled') {

					$message = 'The following appointment has been rescheduled: ' . $service_name . ' with you on ' . $datetime . ' at this location ' . $location . ' with ' . $user_name . '';
				} else {

					$message = 'The following appointment has been booked: ' . $service_name . ' with you on ' . $datetime . ' at this location ' . $location . ' with ' . $user_name . '';
				}
				self::send_line_notification($line_userId, $message);
			}
			if ($user_role == 'student') {

				if ($status == 'reminder') {

					$message = 'This is general reminder for the appointment you have with: ' . $user_name . ' at  ' . $location . ' for ' . $service_name. ' at ' . $datetime;
					
				} else if ($status == 'cancellled') {

					$message = 'The following appointment has been cancelled: ' . $service_name . ' with ' . $user_name . ' on ' . $datetime . ' at this location ' . $location;
				} else if ($status == 'rescheduled') {

					$message = 'The following appointment has been rescheduled: ' . $service_name . ' with ' . $user_name . ' on ' . $datetime . ' at this location ' . $location;
				} else {

					$message = 'The following appointment has been booked: ' . $service_name . ' with ' . $user_name . ' on ' . $datetime . ' at this location ' . $location;
				}
				self::send_line_notification($line_userId, $message);
			}
			//New Reservation on Accent with '.$name.' at '.$location.', on '.$datetime.' for '.$service.'

			
		}
	}
	
	public static function send_line_notification($line_id = "", $text_message = "") {

		$fields = array(
			'to' => $line_id,
			'messages' => array(array('type' => 'text', 'text' => $text_message))
		);
		$url = "https://api.line.me/v2/bot/message/push";
		$fields = json_encode($fields);
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
		curl_setopt($ch, CURLOPT_POST, 1);
		$line_access_token = env('LINE_ACCES_TOKEN');
		$headers = array();
		$headers[] = "Content-Type: application/json";
		$headers[] = "Authorization: Bearer {$line_access_token}";
		curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
		$result = curl_exec($ch);
		curl_close($ch);
		
		//echo '<pre>';print_r($result);exit;
	}

    public static function sentMessage($encodeJson) {
        $datas ['url'] = "https://api.line.me/v2/bot/message/push";
        $datas ['token'] = "qstE8wVpxTCHUOKM2CiK/HeH5v61mfYCxAtC18lE1noTFErMq1yvO3R8p0237RLokeVq9lBiizJi8XPnsf2tGelw5vXSrW83U5vbeP+hc6A7jaU7/e4nWqC11sDNIjLFBe9/bOtKyvOkJcuaSTn3NwdB04t89/1O/w1cDnyilFU=";

        $datasReturn = [];
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => $datas ['url'],
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => $encodeJson,
            CURLOPT_HTTPHEADER => array(
                "authorization: Bearer " . $datas ['token'],
                "cache-control: no-cache",
                "content-type: application/json;charset=UTF-8",
            ),
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);
        curl_close($curl);
        if ($err) {
            $datasReturn ['result'] = 'E';
            $datasReturn ['message'] = $err;
        } else {
            if ($response == "{}") {
                $datasReturn ['result'] = 'S';
                $datasReturn ['message'] = 'Success';
            } else {
                $datasReturn ['result'] = 'E';
                $datasReturn ['message'] = $response;
            }
        }
        return $datasReturn;
    }

    public static function getFormatTextMessage($text) {
        $datas = [];
        $datas ['type'] = 'text';
        $datas ['text'] = $text;
        return $datas;
    }

    public static function payout($amount, $user_id = null, $student_name='', $lesson_date_time='') {

        //$amount = self::convertToUSD($amount);

        //$receiverEmail = 'sb-pc7nf46363@business.example.com';
        if ($user_id) {
            $user = User::where('id', $user_id)->first();
            $userDetails = $user->details()->first();
            $receiverEmail = $user->paypal_email;
            /*if (!$receiverEmail) {
                $receiverEmail = 'sb-pc7nf46363@business.example.com';
            }*/
        }

		if($receiverEmail != '') {
			$sender_batch_id = uniqid();
			$payouts = new Payout();
			$senderBatchHeader = new PayoutSenderBatchHeader();
			$senderBatchHeader->setSenderBatchId($sender_batch_id)
				->setEmailSubject("You have a Payout against lesson taught to $student_name on $lesson_date_time. batch_id:$sender_batch_id");
			$senderItem = new PayoutItem();
			$senderItem->setRecipientType('Email')
				->setNote("Payment against lesson taught to $student_name on $lesson_date_time. batch_id:$sender_batch_id")
				->setReceiver($receiverEmail)
				//->setSenderItemId("2014031400023")
				->setAmount(new Currency('{
							"value":"' . $amount . '",
							"currency":"JPY"
						}'));
			$payouts->setSenderBatchHeader($senderBatchHeader)->addItem($senderItem);
			
			try {
				$credential = new OAuthTokenCredential(env('PAYPAL_CLIENT_ID'), env('PAYPAL_CLIENT_SECRET'));
				$apiContext = new ApiContext($credential);
				$apiContext->setConfig(
					  array(
						'mode' => env('PAYPAL_PAYMENT_MODE'),
					  )
				);
				$output = $payouts->create(null, $apiContext);
				
				return $output;
			} catch (\PayPal\Exception\PayPalConnectionException $ex) {
				return 'Fail';
			}
		}
    }

    public static function convertToUSD($amount) {
        $jpyRate = Settings::getSettings('yen_rate');
        $jpyRate = ($jpyRate) ? $jpyRate : 1;
        $totalUsd = number_format((float)$amount / $jpyRate, 2, '.', '');
        return $totalUsd;
    }

    public static function uploadfileToFolder($folder_id, $content, $mimeType, $filename) {
        $client = new \Google_Client();
        $client->setApplicationName('Google Drive API PHP Quickstart');
        $client->setScopes([
            \Google_Service_Drive::DRIVE,
            \Google_Service_Drive::DRIVE_APPDATA,
            \Google_Service_Drive::DRIVE_FILE,
            \Google_Service_Drive::DRIVE_METADATA,
            \Google_Service_Drive::DRIVE_METADATA_READONLY,
            \Google_Service_Drive::DRIVE_PHOTOS_READONLY,
            \Google_Service_Drive::DRIVE_READONLY,
        ]);
        $client->setAuthConfig(public_path('lokalingo.json'));
        $dr_service = new \Google_Service_Drive($client);
        $fileMetadata = new \Google_Service_Drive_DriveFile(array(
                'name' => $filename,
                'parents' => array($folder_id)
            )
        );

        $file = $dr_service->files->create($fileMetadata, array(
                'data' => $content,
                'mimeType' => $mimeType,
                'uploadType' => 'multipart',
                'fields' => 'id'
            )
        );
        return $file->getId();
    }

    public static function getFolderData($id) {
        $client = new \Google_Client();
        $client->setApplicationName('Google Drive API PHP Quickstart');
        $client->setScopes([
            \Google_Service_Drive::DRIVE,
            \Google_Service_Drive::DRIVE_APPDATA,
            \Google_Service_Drive::DRIVE_FILE,
            \Google_Service_Drive::DRIVE_METADATA,
            \Google_Service_Drive::DRIVE_METADATA_READONLY,
            \Google_Service_Drive::DRIVE_PHOTOS_READONLY,
            \Google_Service_Drive::DRIVE_READONLY,
        ]);
        $client->setAuthConfig(public_path('lokalingo.json'));
        $dr_service = new \Google_Service_Drive($client);
        $dr_results = $dr_service->files->listFiles(array(
                'pageSize' => 100,
                'q' => "'" . $id . "' in parents",
                'orderBy' => 'createdTime'
            )
        );

        return $dr_results->getFiles();
    }

    public static function getFolders($id) {
        $client = new \Google_Client();
        $client->setApplicationName('Google Drive API PHP Quickstart');
        $client->setScopes([
            \Google_Service_Drive::DRIVE,
            \Google_Service_Drive::DRIVE_APPDATA,
            \Google_Service_Drive::DRIVE_FILE,
            \Google_Service_Drive::DRIVE_METADATA,
            \Google_Service_Drive::DRIVE_METADATA_READONLY,
            \Google_Service_Drive::DRIVE_PHOTOS_READONLY,
            \Google_Service_Drive::DRIVE_READONLY,
        ]);
        $client->setAuthConfig(public_path('lokalingo.json'));
        $dr_service = new \Google_Service_Drive($client);
       
		$dr_results = $dr_service->files->listFiles(array(
                'pageSize' => 1000,
                'q' => "'" . $id . "' in parents",
                'orderBy' => 'createdTime'
            )
        );

        return $dr_results;
    }

    public static function createFolderInFolder($id, $name) {
		//echo \Google_Service_Drive::DRIVE;exit;
        $client = new \Google_Client();
        $client->setApplicationName('Google Drive API PHP Quickstart');
        $client->setScopes([
            \Google_Service_Drive::DRIVE,
            \Google_Service_Drive::DRIVE_APPDATA,
            \Google_Service_Drive::DRIVE_FILE,
            \Google_Service_Drive::DRIVE_METADATA,
            \Google_Service_Drive::DRIVE_METADATA_READONLY,
            \Google_Service_Drive::DRIVE_PHOTOS_READONLY,
            \Google_Service_Drive::DRIVE_READONLY,
        ]);
        $client->setAuthConfig(public_path('accent.json'));
        $dr_service = new \Google_Service_Drive($client);
//die('sdfsd');
        $fileMetadata = new \Google_Service_Drive_DriveFile(array(
            'name' => $name,
            'mimeType' => 'application/vnd.google-apps.folder',
            'parents' => array($id)
        ));


        $file = $dr_service->files->create($fileMetadata, array(
                'fields' => 'id',
                //'mimeType' => 'application/vnd.google-apps.folder'
            )
        );
		//echo '<pre>';print_r($file);exit;
        $fileId = $file->getId();

        /*$value = env('GDRIVE_EMAIL');
        $type = "user";
        $role = "owner";
        $newPermission = new \Google_Service_Drive_Permission([
            'value' => $value,
            'emailAddress' => $value,
            'type' => $type,
            'role' => $role
        ]);*/

        $writePermission = new \Google_Service_Drive_Permission();
        $type = "anyone";
        $role = "writer";
        $writePermission->setType($type);
        $writePermission->setRole($role);


        // $dr_service->permissions->create($fileId, $newPermission, array('fields' => 'id', 'transferOwnership' => 'true'));
        $dr_service->permissions->create($fileId, $writePermission, array('fields' => 'id'));


        return $fileId;
    }

    public static function createPlan($planData) {
        $customData = [
            'id' => $planData['id']
        ];

        $plan = new Plan();
        $plan->setName($planData['name'])
                ->setDescription(json_encode($customData))
                ->setType('FIXED');

        $paymentDefinition = new PaymentDefinition();
        $paymentDefinition->setName('Regular Payments')
                            ->setType('REGULAR')
                            ->setFrequency('MONTH')
                            ->setFrequencyInterval('1')
                            ->setCycles('60')
                            ->setAmount(new Currency(array(
                                'value'    => ceil($planData['amount']),
                                'currency' => 'JPY',
                            )));

        $taxPer = Settings::getSettings('tax');

        $tax= ($planData['amount'] * $taxPer / 100);

        // Set charge models
        $chargeModel = new ChargeModel();
        $chargeModel->setType('TAX')->setAmount(new Currency(array(
            'value'    => ceil($tax),
            'currency' => 'JPY',
        )));

        $paymentDefinition->setChargeModels(array(
            $chargeModel,
        ));

        // Set merchant preferences
        $merchantPreferences = new MerchantPreferences();
        $merchantPreferences->setReturnUrl(route('students.package.subscription.success').'?plan_id='.$planData['id'])
            ->setCancelUrl(route('students.package.subscription.cancel').'?plan_id='.$planData['id'])
            //->setNotifyUrl(route('students.package.subscription.notify').'?plan_id='.$planData['id'])
            ->setAutoBillAmount('yes')
            ->setInitialFailAmountAction('CONTINUE')
            ->setMaxFailAttempts('3');
			//->setSetupFee(new Currency(array('value' => ceil($planData['amount']), 'currency' => 'JPY')));

        $plan->setPaymentDefinitions(array(
            $paymentDefinition,
        ));

        $plan->setMerchantPreferences($merchantPreferences);

        try {
            $createdPlan = $plan->create(AppHelper::paypalApiContex());
            try {
                $patch = new Patch();
                $value = new PayPalModel('{"state":"ACTIVE"}');
                $patch->setOp('replace')->setPath('/')->setValue($value);

                $patchRequest = new PatchRequest();
                $patchRequest->addPatch($patch);

                $createdPlan->update($patchRequest, AppHelper::paypalApiContex());

                $patchedPlan = Plan::get($createdPlan->getId(), AppHelper::paypalApiContex());

                return $patchedPlan;
                // echo '<pre>';
                // print_r(get_class_methods($patchedPlan));
                // print_r($patchedPlan->toArray());
                // print_r($patchedPlan->toJSON());
                // echo '</pre>';
                // die;

                //AppHelper::subcription($patchedPlan);

            } catch (PayPal\Exception\PayPalConnectionException $ex) {
                echo $ex->getCode();
                echo $ex->getData();
                die($ex);
            } catch (Exception $ex) {
                die($ex);
            }
        } catch (PayPal\Exception\PayPalConnectionException $ex) {
            echo $ex->getCode();
            echo $ex->getData();
            die($ex);
        } catch (Exception $ex) {
            die($ex);
        }
    }

    public static function paypalSubcription($planData) {
        $startDate = date('c', time());
        $agreement = new Agreement();
        $agreement->setName($planData['title'])
            ->setDescription('PHP Tutorial Plan Subscription Billing Agreement')
            ->setStartDate($startDate);

        // Set plan id
        $plan = new Plan();
        $plan->setId($planData['paypal_plan_id']);
        $agreement->setPlan($plan);

        // Add payer type
        $payer = new Payer();
        $payer->setPaymentMethod('paypal');
        $agreement->setPayer($payer);

        // Adding shipping details
        $shippingAddress = new ShippingAddress();
        $shippingAddress->setLine1('111 First Street')
                            ->setCity('Saratoga')
                            ->setState('CA')
                            ->setPostalCode('95070')
                            ->setCountryCode('US');
        $agreement->setShippingAddress($shippingAddress);

        try {
            // Create agreement
            $agreement = $agreement->create(AppHelper::paypalApiContex());

            // Extract approval URL to redirect user
            $approvalUrl = $agreement->getApprovalLink();

            header("Location: " . $approvalUrl);
            exit();
        } catch (PayPal\Exception\PayPalConnectionException $ex) {
            echo $ex->getCode();
            echo $ex->getData();
            die($ex);
        } catch (Exception $ex) {
            die($ex);
        }
    }

    public static function createGoogleContact($data){
		if(env('IS_GOOGLE_CONTACT_ENABLED') == 1 && (strtolower($firstname) != 'panacea')) {
			$googleSubjectAccount = 'loka@lokalingo.com';
			//$googleSubjectAccount = 'priyank.patel@trootechproducts.com';
			//$googleSubjectAccount = 'trootechdevelopers@gmail.com';
			//$SubjectAccount = 'trootechdevelopers@gmail.com';
			$defaultGroup = "http://www.google.com/m8/feeds/groups/$googleSubjectAccount/base/6";
			$conf = [
				'google_auth_file' => 'lokalingo.json',
				'gcontacts_account' => $googleSubjectAccount,
				'gcontacts_base_url' => 'https://www.google.com/m8/feeds/contacts/default/full',
				'gcontacts_scopes' => [
					'https://www.googleapis.com/auth/contacts',
					'https://www.google.com/m8/feeds',
				],
			];
			$gcontacts = new GoogleContacts($conf);

			if (empty($data['fullName'])) {
				$data['fullName'] = $data['firstname'] . ' ' . $data['lastname'];
			}

			$street = empty($data['street']) ? '' : $data['street'] . ', ';
			$neighborhood = empty($data['neighborhood']) ? '' : $data['neighborhood'] . ', ';
			$city = empty($data['city']) ? '' : $data['city'] . ', ';
			$postcode = empty($data['postcode']) ? '' : $data['postcode'] . ' ';
			$region = empty($data['region']) ? '' : $data['region'] . ', ';
			$country = empty($data['country']) ? '' : $data['country'] . ', ';
			$data['formattedAddress'] = $street . $neighborhood . $city . $postcode . $region . $country;

			$data['group'] = $defaultGroup;
			$data['emailHome'] = !empty($data['email']) ? $data['email'] : '';
			$data['phoneNumberMobile'] = !empty($data['contact_no']) ? $data['contact_no'] : '';
			$data['namePrefix'] = !empty($data['namePrefix']) ? $data['namePrefix'] : '';
			$data['givenName'] = !empty($data['givenName']) ? $data['givenName'] : '';
			$data['additionalName'] = !empty($data['additionalName']) ? $data['additionalName'] : '';
			$data['familyName'] = !empty($data['familyName']) ? $data['familyName'] : '';
			$data['nameSuffix'] = !empty($data['nameSuffix']) ? $data['nameSuffix'] : '';
			$data['content'] = !empty($data['content']) ? $data['content'] : '';
			$data['phoneNumberHome'] = !empty($data['phoneNumberHome']) ? $data['phoneNumberHome'] : '';
			$data['phoneNumberWork'] = !empty($data['phoneNumberWork']) ? $data['phoneNumberWork'] : '';
			$data['birthday'] = !empty($data['birthday']) ? $data['birthday'] : '';
			$data['emailWork'] = !empty($data['emailWork']) ? $data['emailWork'] : '';
			$data['street'] = !empty($data['street']) ? $data['street'] : '';
			$data['neighborhood'] = !empty($data['neighborhood']) ? $data['neighborhood'] : '';
			$data['city'] = !empty($data['city']) ? $data['city'] : '';
			$data['postcode'] = !empty($data['postcode']) ? $data['postcode'] : '';
			$data['region'] = !empty($data['region']) ? $data['region'] : '';
			$data['country'] = !empty($data['country']) ? $data['country'] : '';
			$data['pobox'] = !empty($data['pobox']) ? $data['pobox'] : '';
			$data['preferredProduct'] = !empty($data['preferredProduct']) ? $data['preferredProduct'] : '';
			$data['mostConvenientTimeToCall'] = !empty($data['mostConvenientTimeToCall']) ? $data['mostConvenientTimeToCall'] : '';
			// Escape the values to XML safe
			foreach ($data as $param => $value) {
				$data[$param] = htmlspecialchars($value, ENT_XML1, 'UTF-8');
			}
			$error = '';
			$success = '';

			return  $gcontacts->create($data);
		}
    }

    public static function getCountryCode($name=null) {
        $countries = array (
            'AF' => 'Afghanistan',
            'AX' => 'Aland Islands',
            'AL' => 'Albania',
            'DZ' => 'Algeria',
            'AS' => 'American Samoa',
            'AD' => 'Andorra',
            'AO' => 'Angola',
            'AI' => 'Anguilla',
            'AQ' => 'Antarctica',
            'AG' => 'Antigua And Barbuda',
            'AR' => 'Argentina',
            'AM' => 'Armenia',
            'AW' => 'Aruba',
            'AU' => 'Australia',
            'AT' => 'Austria',
            'AZ' => 'Azerbaijan',
            'BS' => 'Bahamas',
            'BH' => 'Bahrain',
            'BD' => 'Bangladesh',
            'BB' => 'Barbados',
            'BY' => 'Belarus',
            'BE' => 'Belgium',
            'BZ' => 'Belize',
            'BJ' => 'Benin',
            'BM' => 'Bermuda',
            'BT' => 'Bhutan',
            'BO' => 'Bolivia',
            'BA' => 'Bosnia And Herzegovina',
            'BW' => 'Botswana',
            'BV' => 'Bouvet Island',
            'BR' => 'Brazil',
            'IO' => 'British Indian Ocean Territory',
            'BN' => 'Brunei Darussalam',
            'BG' => 'Bulgaria',
            'BF' => 'Burkina Faso',
            'BI' => 'Burundi',
            'KH' => 'Cambodia',
            'CM' => 'Cameroon',
            'CA' => 'Canada',
            'CV' => 'Cape Verde',
            'KY' => 'Cayman Islands',
            'CF' => 'Central African Republic',
            'TD' => 'Chad',
            'CL' => 'Chile',
            'CN' => 'China',
            'CX' => 'Christmas Island',
            'CC' => 'Cocos (Keeling) Islands',
            'CO' => 'Colombia',
            'KM' => 'Comoros',
            'CG' => 'Congo',
            'CD' => 'Congo, Democratic Republic',
            'CK' => 'Cook Islands',
            'CR' => 'Costa Rica',
            'CI' => 'Cote D\'Ivoire',
            'HR' => 'Croatia',
            'CU' => 'Cuba',
            'CY' => 'Cyprus',
            'CZ' => 'Czech Republic',
            'DK' => 'Denmark',
            'DJ' => 'Djibouti',
            'DM' => 'Dominica',
            'DO' => 'Dominican Republic',
            'EC' => 'Ecuador',
            'EG' => 'Egypt',
            'SV' => 'El Salvador',
            'GQ' => 'Equatorial Guinea',
            'ER' => 'Eritrea',
            'EE' => 'Estonia',
            'ET' => 'Ethiopia',
            'FK' => 'Falkland Islands (Malvinas)',
            'FO' => 'Faroe Islands',
            'FJ' => 'Fiji',
            'FI' => 'Finland',
            'FR' => 'France',
            'GF' => 'French Guiana',
            'PF' => 'French Polynesia',
            'TF' => 'French Southern Territories',
            'GA' => 'Gabon',
            'GM' => 'Gambia',
            'GE' => 'Georgia',
            'DE' => 'Germany',
            'GH' => 'Ghana',
            'GI' => 'Gibraltar',
            'GR' => 'Greece',
            'GL' => 'Greenland',
            'GD' => 'Grenada',
            'GP' => 'Guadeloupe',
            'GU' => 'Guam',
            'GT' => 'Guatemala',
            'GG' => 'Guernsey',
            'GN' => 'Guinea',
            'GW' => 'Guinea-Bissau',
            'GY' => 'Guyana',
            'HT' => 'Haiti',
            'HM' => 'Heard Island & Mcdonald Islands',
            'VA' => 'Holy See (Vatican City State)',
            'HN' => 'Honduras',
            'HK' => 'Hong Kong',
            'HU' => 'Hungary',
            'IS' => 'Iceland',
            'IN' => 'India',
            'ID' => 'Indonesia',
            'IR' => 'Iran, Islamic Republic Of',
            'IQ' => 'Iraq',
            'IE' => 'Ireland',
            'IM' => 'Isle Of Man',
            'IL' => 'Israel',
            'IT' => 'Italy',
            'JM' => 'Jamaica',
            'JP' => 'Japan',
            'JE' => 'Jersey',
            'JO' => 'Jordan',
            'KZ' => 'Kazakhstan',
            'KE' => 'Kenya',
            'KI' => 'Kiribati',
            'KR' => 'Korea',
            'KW' => 'Kuwait',
            'KG' => 'Kyrgyzstan',
            'LA' => 'Lao People\'s Democratic Republic',
            'LV' => 'Latvia',
            'LB' => 'Lebanon',
            'LS' => 'Lesotho',
            'LR' => 'Liberia',
            'LY' => 'Libyan Arab Jamahiriya',
            'LI' => 'Liechtenstein',
            'LT' => 'Lithuania',
            'LU' => 'Luxembourg',
            'MO' => 'Macao',
            'MK' => 'Macedonia',
            'MG' => 'Madagascar',
            'MW' => 'Malawi',
            'MY' => 'Malaysia',
            'MV' => 'Maldives',
            'ML' => 'Mali',
            'MT' => 'Malta',
            'MH' => 'Marshall Islands',
            'MQ' => 'Martinique',
            'MR' => 'Mauritania',
            'MU' => 'Mauritius',
            'YT' => 'Mayotte',
            'MX' => 'Mexico',
            'FM' => 'Micronesia, Federated States Of',
            'MD' => 'Moldova',
            'MC' => 'Monaco',
            'MN' => 'Mongolia',
            'ME' => 'Montenegro',
            'MS' => 'Montserrat',
            'MA' => 'Morocco',
            'MZ' => 'Mozambique',
            'MM' => 'Myanmar',
            'NA' => 'Namibia',
            'NR' => 'Nauru',
            'NP' => 'Nepal',
            'NL' => 'Netherlands',
            'AN' => 'Netherlands Antilles',
            'NC' => 'New Caledonia',
            'NZ' => 'New Zealand',
            'NI' => 'Nicaragua',
            'NE' => 'Niger',
            'NG' => 'Nigeria',
            'NU' => 'Niue',
            'NF' => 'Norfolk Island',
            'MP' => 'Northern Mariana Islands',
            'NO' => 'Norway',
            'OM' => 'Oman',
            'PK' => 'Pakistan',
            'PW' => 'Palau',
            'PS' => 'Palestinian Territory, Occupied',
            'PA' => 'Panama',
            'PG' => 'Papua New Guinea',
            'PY' => 'Paraguay',
            'PE' => 'Peru',
            'PH' => 'Philippines',
            'PN' => 'Pitcairn',
            'PL' => 'Poland',
            'PT' => 'Portugal',
            'PR' => 'Puerto Rico',
            'QA' => 'Qatar',
            'RE' => 'Reunion',
            'RO' => 'Romania',
            'RU' => 'Russian Federation',
            'RW' => 'Rwanda',
            'BL' => 'Saint Barthelemy',
            'SH' => 'Saint Helena',
            'KN' => 'Saint Kitts And Nevis',
            'LC' => 'Saint Lucia',
            'MF' => 'Saint Martin',
            'PM' => 'Saint Pierre And Miquelon',
            'VC' => 'Saint Vincent And Grenadines',
            'WS' => 'Samoa',
            'SM' => 'San Marino',
            'ST' => 'Sao Tome And Principe',
            'SA' => 'Saudi Arabia',
            'SN' => 'Senegal',
            'RS' => 'Serbia',
            'SC' => 'Seychelles',
            'SL' => 'Sierra Leone',
            'SG' => 'Singapore',
            'SK' => 'Slovakia',
            'SI' => 'Slovenia',
            'SB' => 'Solomon Islands',
            'SO' => 'Somalia',
            'ZA' => 'South Africa',
            'GS' => 'South Georgia And Sandwich Isl.',
            'ES' => 'Spain',
            'LK' => 'Sri Lanka',
            'SD' => 'Sudan',
            'SR' => 'Suriname',
            'SJ' => 'Svalbard And Jan Mayen',
            'SZ' => 'Swaziland',
            'SE' => 'Sweden',
            'CH' => 'Switzerland',
            'SY' => 'Syrian Arab Republic',
            'TW' => 'Taiwan',
            'TJ' => 'Tajikistan',
            'TZ' => 'Tanzania',
            'TH' => 'Thailand',
            'TL' => 'Timor-Leste',
            'TG' => 'Togo',
            'TK' => 'Tokelau',
            'TO' => 'Tonga',
            'TT' => 'Trinidad And Tobago',
            'TN' => 'Tunisia',
            'TR' => 'Turkey',
            'TM' => 'Turkmenistan',
            'TC' => 'Turks And Caicos Islands',
            'TV' => 'Tuvalu',
            'UG' => 'Uganda',
            'UA' => 'Ukraine',
            'AE' => 'United Arab Emirates',
            'GB' => 'United Kingdom',
            'US' => 'United States',
            'UM' => 'United States Outlying Islands',
            'UY' => 'Uruguay',
            'UZ' => 'Uzbekistan',
            'VU' => 'Vanuatu',
            'VE' => 'Venezuela',
            'VN' => 'Viet Nam',
            'VG' => 'Virgin Islands, British',
            'VI' => 'Virgin Islands, U.S.',
            'WF' => 'Wallis And Futuna',
            'EH' => 'Western Sahara',
            'YE' => 'Yemen',
            'ZM' => 'Zambia',
            'ZW' => 'Zimbabwe',
        );

        if($name){
            return strtolower(array_search($name, $countries));
        } else {
            return;
        }
    }

    public static function freshbookAuth($oathcode=null) {

        //$authCode = app('App\Http\Controllers\CmsController')->freshbookToken();
        $curl = curl_init();

        $postArray = [ 'grant_type' => 'authorization_code', 
                        'client_secret'=> '89d56144a247802c968db3779e4000486c6e8555d5fd400ae4642530f936f240',
                        'client_id' =>'4f8f345b703720a5ebdb42cd0184c023c1ef39e6b50b093534871eba258fb0c3',
                        'code' => $oathcode,
                        'redirect_uri' => 'https://trootechproducts.com:8007/freshbook/token'
                    ];

        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://api.freshbooks.com/auth/oauth/token",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => json_encode($postArray),
            CURLOPT_HTTPHEADER => array(
                "api-version: alpha",
                "cache-control: no-cache",
                "content-type: application/json",
                "postman-token: 471a0741-8466-2e3f-0006-8b9c3794ef9d"
            ),
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {
            echo "cURL Error #:" . $err;
        } else {
            echo $response;
        }
    }
	
	public static function get_published_teachers () {
		$teachers = User::select('users.*', 'teacher_detail.onepage_certified', 'teacher_detail.in_training', 'teacher_detail.teacher_verified', 'teacher_detail.audio_attachment', 'teacher_detail.message_en', 'teacher_detail.message_jp', 'teacher_detail.hobby', 'teacher_detail.teaching_category', 'teacher_detail.teaching_certificate', 'teacher_detail.global_lesson_price', 'teacher_detail.virtual_lesson_percentage', 'teacher_detail.cafe_lesson_percentage', 'teacher_detail.classroom_lesson_percentage', 'teacher_detail.book_before_time', 'teacher_detail.cancel_before_time', 'teacher_detail.country_code', 'nationality','audio_attachment')
                            ->join('teacher_detail', 'users.id', 'teacher_detail.user_id')
							->where('users.user_type', 'teacher')
							->where('teacher_detail.publish_profile', 1)
							->orderBy('id', 'asc')
							->get();
		//select a.*, b.onepage_certified, b.in_training, b.teacher_verified, b.audio_attachment from users a  inner join teacher_detail b on a.id = b.user_id where user_type = 'teacher' order by id desc;
		
		return $teachers;
	}
	
	public static function getTeacherTotalRatings($teacher_id = '') {
		$totalRatings = TeacherRatings::select(DB::raw('avg(ratings)'))
									->where('teacher_id', $teacher_id)
									->where('status', 1)
									->value('avg');
		return !empty($totalRatings) ? number_format($totalRatings,1) : 0;
	}
	
	public static function getTeacherRatingsCount($teacher_id = '') {
		
		$countStudentsRated = 0;
		$countStudentsRated =TeacherRatings::distinct('lesson_booking_id')
		->where('teacher_id', $teacher_id)
							 ->where('status', 1)
							 ->count('lesson_booking_id');
		return $countStudentsRated;					 
	}
	
	public static function format_date_FjY($date = '') {
		if(App::isLocale('jp')) {
			return  date('Y', strtotime($date)) . '年' . date('m', strtotime($date)) . '月' . date('d', strtotime($date)) . '日';
		} else {
			return  date('F j, Y', strtotime($date));
		}
	}
	
	public static function calculateTravelTime($source = '', $destination = '') {
		if($source != '' && $destination != '') {
			$source = urlencode($source);
			$destination = urlencode($destination);
			$key = config('services.google.google_api_key');
			$url = 'https://maps.googleapis.com/maps/api/distancematrix/json?origins='.$source.'&destinations='.$destination.'&key='.$key.'';
			//$url .= '&mode=transit&transit_mode=train';
			$data = file_get_contents($url);
			$data = json_decode($data, true);
			if($data['status'] == 'OK' && $data['rows'][0]['elements'][0]['status'] == 'OK') {
				//echo '<pre>';print_r($data['rows']);echo '</pre>';		
				echo $data['rows'][0]['elements'][0]['duration']['value'];
			}
		}
	}
	
	public static function check_keyword_in_string ($keywords_array = [], $string = ''){
		if(!empty($keywords_array) && $string != '') {
			foreach ($keywords_array as $substr) {
				if(strpos($string, $substr) !== false){
					$substr = preg_quote($substr, '/');
					$string = preg_replace('/\b'.$substr.'\b/u', '<b style="font-weight:bold;color:#002E58;">'.$substr.'</b>', $string);
				}	
			}
		}
		$string = str_replace('\\', '', $string);
		return $string;
	}
	
	public static function createOrder($user_id='', $service_id='') {
		
		$service = Services::where('id',$service_id)->first();
		
		$amt = $service->price;
		$studentLesson['user_id'] = $user_id;        
        $studentLesson['status'] = 1;
        $studentLesson['service_id'] = $service_id;
        $studentLesson['available_bookings'] = 1;
        $studentLesson['price'] = $amt;
        $studentLesson['start_date'] = date('Y-m-d');
        $studentLesson['expire_date'] = date('Y-m-d');
        $student_lesson = StudentLessons::create($studentLesson);
		$student_lesson_id = $student_lesson->id;	
		
		$tax = Settings::getSettings('tax');
		$taxAmt = ($amt * $tax)/100;
		$amount = $amt + ($taxAmt);
		
		$studentTransaction = [
                "user_id" => $user_id,
                "provider" => 'Card',
                "amount" => $amount,
                "transaction_type" => "multi_service",
                "transaction_type_id" => $service_id,
                "payment_status" => 'succeeded',
				"student_lesson_id" => $student_lesson_id,
                "discount" => 0,
                "subtotal" => $amt,
                "one_page_fee" => 0,
                "tax" => $taxAmt
            ];

        $savedTransaction = StudentTransactions::create($studentTransaction);
		$transaction_id = $savedTransaction->id;
		if(!empty($student_lesson_id)){
			$StudentLessons = StudentLessons::find($student_lesson_id);
			$StudentLessons->transaction_id = $transaction_id;
			$StudentLessons->save();
		}
		
		$msg = '';
		if(env('IS_ZOHO_ENABLED') == 1) {
			$invoice_id = 0;
			$student =  User::find($user_id);
			if(!empty($student) && $student->zoho_user_id > 0) {
				$zoho_user_id = $student->zoho_user_id;
				$email = $student->email;			
				
				if(!empty($service) && $service->zoho_item_id > 0) {
					$zoho_item_id = $service->zoho_item_id;			
			
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
					
					if($invoice_id > 0) { // create and send invoice						
						$jsondata = '{
							"customer_id": "'.$zoho_user_id.'",
							"payment_mode": "cash",
							"amount": "'.$amount.'",
							"date": "'.$date.'",
							"description": "Payment has been added.",
							"invoices": [
								{
									"invoice_id": "'.$invoice_id.'",
									"amount_applied": "'.$amount.'"
								}
							]
						}';
						$output = ZohoHelper::updateInvoice($jsondata);		
						
						$jsondata = '{"send_from_org_email_id": true,"to_mail_ids": ["'.$email.'"]}';
						$output = ZohoHelper::emailInvoice($jsondata, $invoice_id);						
					}
				}
			}			
		}
		return $student_lesson_id;
	}
}
?>
