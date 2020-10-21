<?php
namespace App\Helpers;

use Carbon\Carbon;
use App\Store;
use App\Models\Settings;
use App\User;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Http\Controllers\CmsController;

class MailerliteHelper
{	
	public static function createSubscriber_student($email = '', $name = '', $phone = '', $company = '')
    {
		$group_id = config('services.mailerlite.student_group_id');
        return $response = self::call_curl($group_id, $email, $name, $phone, $company);        
    }
	
	public static function createSubscriber_teacher($email = '', $name = '', $phone = '', $company = '')
    {
		$group_id = config('services.mailerlite.teacher_group_id');
        return $response = self::call_curl($group_id, $email, $name, $phone, $company);        
    }
	
	public static function call_curl($group_id = '', $email = '', $name = '', $phone = '', $company = '') {
		if($email != '' && $name != '' && (env('IS_MAILERLITE_ENABLED') == 1)) {
			if($group_id != '') {
				$url = "https://api.mailerlite.com/api/v2/groups/$group_id/subscribers";
			} else {
				$url = "https://api.mailerlite.com/api/v2/subscribers";
			}
			//echo $phone;
			$curl = curl_init();
			curl_setopt_array($curl, array(
			  CURLOPT_URL => $url,
			  CURLOPT_RETURNTRANSFER => true,
			  CURLOPT_ENCODING => "",
			  CURLOPT_MAXREDIRS => 10,
			  CURLOPT_TIMEOUT => 30,
			  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			  CURLOPT_CUSTOMREQUEST => "POST",
			  CURLOPT_POSTFIELDS => '{"email": "'.$email.'", "name": "'.$name.'", "fields": {"company": "'.$company.'", "phone": "'.$phone.'"}}',
			  CURLOPT_HTTPHEADER => array(
				"content-type: application/json",
				"x-mailerlite-apikey: ".config('services.mailerlite.api_key').""
			  ),
			));

			$response = curl_exec($curl);
			$err = curl_error($curl);

			curl_close($curl);

			if ($err) {
			  echo "cURL Error #:" . $err;
			} else {
				$response = json_decode($response, true);
				//echo '<pre>';print_r($response);
				//return $response->id;
			}
		}
	}
}
?>
