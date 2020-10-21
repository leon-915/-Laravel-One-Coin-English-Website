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

use zcrmsdk\oauth\ZohoOAuth;
use zcrmsdk\crm\setup\org\ZCRMOrganization;
use zcrmsdk\crm\setup\restclient\ZCRMRestClient;
use zcrmsdk\crm\setup\users\ZCRMProfile;
use zcrmsdk\crm\setup\users\ZCRMRole;
use zcrmsdk\crm\setup\users\ZCRMUser;
use zcrmsdk\crm\crud\ZCRMOrgTax;
use zcrmsdk\crm\exception\ZCRMException;

class ZohoHelper
{	
	public static function createInvoiceItem($jsondata = '')
    {
		$api_name = 'items';
        return $response = self::call_curl($jsondata, $api_name);
        
    }
	
	public static function createInvoiceCustomer($jsondata = '')
    {
		$api_name = 'contacts';
        return $response = self::call_curl($jsondata, $api_name);
        
    }
	
	public static function createInvoice($jsondata = '')
    {
		$api_name = 'invoices';
        return $response = self::call_curl($jsondata, $api_name);
        
    }
	
	public static function updateInvoice($jsondata = '')
    {
		$api_name = 'customerpayments';
        return $response = self::call_curl($jsondata, $api_name);
        
    }
	
	public static function emailInvoice($jsondata = '', $invoice_id = '')
    {
		$api_name = 'invoices/'.$invoice_id.'/email';
        return $response = self::call_curl($jsondata, $api_name);
        
    }
	
	public static function enableportal($jsondata = '', $user_id = '')
    {
		$api_name = 'contacts/'.$user_id.'/portal/enable';
        return $response = self::call_curl($jsondata, $api_name);
        
    }
	
	public static function call_curl($jsondata = '', $api_name = '') {
		$ch = curl_init();
		$access_token = self::get_refresh_token();
		
		$data = array('JSONString'=>$jsondata);
		curl_setopt_array($ch, array(
		  CURLOPT_URL => "https://invoice.zoho.com/api/v3/$api_name",
		  CURLOPT_RETURNTRANSFER => true,
		  CURLOPT_ENCODING => "",
		  CURLOPT_MAXREDIRS => 10,
		  CURLOPT_TIMEOUT => 0,
		  CURLOPT_FOLLOWLOCATION => true,
		  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		  CURLOPT_CUSTOMREQUEST => "POST",
		  CURLOPT_POSTFIELDS => http_build_query($data),
		  CURLOPT_HTTPHEADER => array(
			"Content-Type: application/x-www-form-urlencoded",
			"Authorization: Zoho-oauthtoken $access_token",
			"X-com-zoho-invoice-organizationid: ".config('services.zcrm.zoho_org_id'),
		  ),
		));

		$result = curl_exec($ch);
		$result = json_decode($result, true);
		if (curl_errno($ch)) {
			echo 'Error:' . curl_error($ch);
		} 
		curl_close($ch);
		return $result;
	}	
	
	public static function get_refresh_token() {
		if(!is_dir(storage_path('zohoOauth'))) {
			mkdir(storage_path('zohoOauth'));
		}
		$file_exists = true;
		if(!is_file(storage_path('zohoOauth/zcrm_oauthtokens.txt'))) {
			$file_exists = false;
			$access_token = self::create_refresh_token();	
		} else {	
			$data = json_decode(file_get_contents(storage_path('zohoOauth/zcrm_oauthtokens.txt')), true);		
			if(time() - $data['created_at'] >= 3600) {
				$access_token = self::create_refresh_token();			
			} else {
				$access_token = $data['access_token'];
			}
		}
		return $access_token;
	}
	
	public static function create_refresh_token () {
		$curl = curl_init();
		curl_setopt_array($curl, array(
		CURLOPT_URL => "https://accounts.zoho.com/oauth/v2/token",
		CURLOPT_RETURNTRANSFER => true,
		CURLOPT_ENCODING => "",
		CURLOPT_MAXREDIRS => 10,
		CURLOPT_TIMEOUT => 0,
		CURLOPT_FOLLOWLOCATION => true,
		CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		CURLOPT_CUSTOMREQUEST => "POST",
		CURLOPT_POSTFIELDS => array('grant_type' => 'refresh_token','client_id' => config('services.zcrm.zoho_client_id'),'client_secret' => config('services.zcrm.zoho_client_secret'),'redirect_uri' => config('services.zcrm.zoho_redirect_uri'),'refresh_token' => config('services.zcrm.zoho_refresh_token')),	));

		$response = curl_exec($curl);
		
		curl_close($curl);
		$response = json_decode($response, true);
		$newdata = json_encode(array('access_token'=>$response['access_token'], 'created_at'=>time()));
		file_put_contents(storage_path('zohoOauth/zcrm_oauthtokens.txt'), $newdata);
		return $access_token = $response['access_token'];
	}
	
	public static function get_invoice_no() {
		if(!is_dir(storage_path('zohoOauth'))) {
			mkdir(storage_path('zohoOauth'));
		}
		
		if(!is_file(storage_path('zohoOauth/invoice_no.php'))) {
			$invoice_no = 'INV-'.date('ymd').'01';
			file_put_contents(storage_path('zohoOauth/invoice_no.php'), $invoice_no);
		} else {	
			$invoice_no = file_get_contents(storage_path('zohoOauth/invoice_no.php'));		
			$str = substr($invoice_no, 4, 6);
			$yr =  substr($str, 0, 2);
			$month =  substr($str, 2, 2);
			$date =  substr($str, 4, 2);
			if($date == date('d')) {
				$str = substr($invoice_no, 10);
				$str = $str+1;
				if($str < 10) {
					$str = '0'.$str;
				}
				$invoice_no = 'INV-'.date('ymd').$str;
				file_put_contents(storage_path('zohoOauth/invoice_no.php'), $invoice_no);
			} else {
				$invoice_no = 'INV-'.date('ymd').'01';
				file_put_contents(storage_path('zohoOauth/invoice_no.php'), $invoice_no);
			}						
		}		
		return $invoice_no;
	}	
	
	public static function get_fb_access_token() {
		if(!is_dir(storage_path('zohoOauth'))) {
			mkdir(storage_path('zohoOauth'));
		}
		$file_exists = true;
		if(!is_file(storage_path('zohoOauth/fb_access_token.txt'))) {
			$file_exists = false;
			$access_token = self::create_fb_access_token();	
		} else {	
			$data = json_decode(file_get_contents(storage_path('zohoOauth/fb_access_token.txt')), true);		
			if(time() - $data['created_at'] >= 4320000) {
				$access_token = self::create_fb_access_token();			
			} else {
				$access_token = $data['access_token'];
			}
		}
		return $access_token;
	}
	
	public static function create_fb_access_token () {
		$curl = curl_init();
		$app_id = config('services.facebook.app_id');
		$app_secret = config('services.facebook.app_secret');
		$pgToken = config('services.facebook.access_token');
		
		$url = 'https://graph.facebook.com/oauth/access_token?grant_type=fb_exchange_token&client_id='.$app_id.'&client_secret='.$app_secret.'&fb_exchange_token='.$pgToken.'';
		curl_setopt_array($curl, array(
		CURLOPT_URL => $url,
		CURLOPT_RETURNTRANSFER => true,
		CURLOPT_ENCODING => "",
		CURLOPT_MAXREDIRS => 10,
		CURLOPT_TIMEOUT => 0,
		CURLOPT_FOLLOWLOCATION => true,
		CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,));
		$response = curl_exec($curl);
		
		curl_close($curl);
		$response = json_decode($response, true);
		$newdata = json_encode(array('access_token'=>$response['access_token'], 'created_at'=>time()));
		file_put_contents(storage_path('zohoOauth/fb_access_token.txt'), $newdata);
		return $access_token = $response['access_token'];
	}
}
?>
