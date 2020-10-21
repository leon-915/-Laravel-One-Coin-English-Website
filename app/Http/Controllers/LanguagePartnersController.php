<?php

namespace App\Http\Controllers;

use App\Models\Services;
use App\Models\Locations;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;
use App\Models\Packages;
use App\Models\StudentPackages;
use App\Models\StudentTransactions;
use App\Models\StudentLessons;
use App\Models\StudentLessonsBooking;
use App\Models\ServiceLocations;
use App\Models\TeacherServices;
use App\Models\ServicePackages;
use App\Models\StudentDetail;
use App\Models\Settings;
use App\User;
use Yajra\DataTables\DataTables;
use DB;
use DateTime;
use DateInterval;
use DatePeriod;
use App\Jobs\SendEmailJob;
use App\Helpers\AppHelper;
use App\Models\StudentShareRecord;
use App\Models\StudentTeacherFavorite;
use App\Models\AvailableTeachers;
use App\Models\HolidaySettings;
use Illuminate\Support\Facades\Mail;

use Stripe\Stripe;
use Stripe\PaymentIntent;
use Stripe\PaymentMethod;

class LanguagePartnersController extends Controller
{
    public function index()
    {
        return view('languagepartners.lplandingpage');
    }
	
	function getAvailableTeachers() {
		$fav_teachers = [];
		if(!Auth::guest()){
			$user_id = Auth::user()->id;
			if($user_id) {
				$favorite = StudentTeacherFavorite::where([ 'student_id' => $user_id])->where('is_favorite', 1)->get();
				if(!empty($favorite)) {
					foreach($favorite as $fav) {
						$fav_teachers[] = $fav->teacher_id;
					}
				}
			}
		}			


		$time_before_30_min = date('Y-m-d H:i:s', strtotime('-30 minute'));
		$availableTeachers = AvailableTeachers::whereRaw("updated_at > '$time_before_30_min'")->pluck('user_id');
		
		//echo '<pre>';print_r($availableTeachers);exit;
		$teachers = User::select('users.*', 'teacher_detail.nationality', 'teacher_detail.message_en', 'teacher_detail.audio_attachment', 'teacher_detail.country_code', 'teacher_detail.japanese_resident', 'teacher_detail.own_realstate_in_japan', 'teacher_detail.occupation', 'teacher_detail.conversation_topic', 'teacher_detail.english_language_specialization', 'teacher_detail.teaching_english_in', 'teacher_detail.is_available')
		->where('user_type', 'teacher')->whereRaw("firstname != ''")
		->leftjoin('teacher_detail', 'users.id', '=', 'teacher_detail.user_id')
		->where('is_available', 1)
		->whereIn('users.id', $availableTeachers)
		->where(function ($query) {
			$today = date('Y-m-d');
			$currenttime = time();
			$starttime = $currenttime - (11*60);
			$endtime = $currenttime + (11*60);
			$busyTeachersArray = [];
			$busy_teachers = StudentLessonsBooking::select('teacher_id', 'lession_date', 'lession_time')->where('lession_date', $today)->where('status', 'booked')->get();
			if(!empty($busy_teachers) && count($busy_teachers) > 0) {
				foreach($busy_teachers as $busy_teacher) {
					//echo strtotime($busy_teacher->lession_time).' >= '.$starttime.' && '.strtotime($busy_teacher->lession_time) .'<= '.$endtime;
					if(strtotime($busy_teacher->lession_time) >= $starttime && (strtotime($busy_teacher->lession_time) <= $endtime)){
						$busyTeachersArray[] = $busy_teacher->teacher_id;
					}
				}
			}
			if (count($busyTeachersArray) > 0) {
				$query->whereNotIn('users.id', $busyTeachersArray);
			}
		})
		->get();
		Stripe::setApiKey(config('services.stripe.test_secret_key'));
		$user = Auth::user();

		$html = view('languagepartners.teacherslist', compact('teachers', 'fav_teachers'))->render();		
        return response()->json(['type' => 'success', 'html' => $html]);
	}
	
	function listing() {
		Stripe::setApiKey(config('services.stripe.test_secret_key'));
		
		$amt = env('OCE_SESSION_PRICE');
		$tax = Settings::getSettings('tax');
		$amount = $amt + ($amt * $tax / 100);
		
		$intent = PaymentIntent::create([
			'amount' => $amount,
			'currency' => 'jpy',
			'payment_method_types' => ['card'],
			'setup_future_usage' => 'off_session',
		]);
		$client_secret = $intent->client_secret;
		
		$user_email = '';
		$user_firstname = '';
		if(!Auth::guest()){
			$user = Auth::user();
			$user_email = $user->email;
			$user_firstname = $user->firstname;
		}
        return view('languagepartners.index', compact('client_secret', 'user_email', 'user_firstname'));
	}
	
	function getOnlineTeachers() {
		$html = view('languagepartners.onlineTeacherslist')->render();		
        return response()->json(['type' => 'success', 'html' => $html]);
	}
	
	function currentservertime(Request $request) {
		$booking_id = $request->booking_id;	
		$booking = StudentLessonsBooking::where('id', $booking_id)->orderBy('id', 'DESC')->first();	
		//echo '<pre>';print_r($booking);exit;
		if(!empty($booking) && $booking->session_started == 0) {		
			$ctime = date('H:i:s');
			$booking->lession_time = $ctime;		
			$booking->session_started = 1;
			$booking->save();
			$lession_date_time = strtotime('+10 minute');
			$currenttime = date('d F Y H:i:s', $lession_date_time).' GMT+09:00';
		} else {
			$lession_date_time = strtotime($booking->lession_date.' '.$booking->lession_time) + (10 * 60);
			$currenttime = date('d F Y H:i:s', $lession_date_time).' GMT+09:00';
		}
		
        return response()->json(['type' => 'success', 'date_str' => $currenttime]);
	}
}
