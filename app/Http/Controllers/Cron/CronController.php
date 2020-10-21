<?php

namespace App\Http\Controllers\Cron;

use App\Helpers\AppHelper;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use App\Models\TeacherDetail;
use App\Jobs\SendEmailJob;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use File;
use App\Models\StudentPackages;
use App\Models\StudentTransactions;
use App\Models\StudentLessons;
use App\Models\StudentLessonsBooking;
use App\Models\Settings;
use App\Models\Services;
use App\Models\Locations;
use App\Models\StudentOnbreakPlans;
use App\Models\TempLineUsers;
use App\Models\HolidaySettings;

class CronController extends Controller
{

    public function index(Request $request) {
        return;
    }
	
	public function subscription_expiration() {

		$package_expire_reminder_days = Settings::getSettings('package_expire_reminder_days');
        $expiry_date = date('Y-m-d', strtotime('+'.$package_expire_reminder_days.' days'));
		
		$packages = StudentPackages::whereRaw("end_date = '".$expiry_date."'::date")
                                    ->where('status', 'active')
                                    ->with('package')
                                    ->get();
									
		if(!empty($packages)  && $packages->toArray()) {
			foreach ($packages as $package) {
				$student_id = $package->user_id;
				$end_date = date('Y/m/d', strtotime($package->end_date));
				$student = User::where('id', $student_id)->first();
				$student_email = env('BCC_EMAIL');//$student->email;
				echo $student_name = $student->firstname .' '.$student->lastname;
				$shareTemplate = "emails.subscription-expiration";
				$shareSubject = 'Subscription renewal reminder at '.env('APP_NAME');
				$shdata = [
					'student_name' => $student_name,
					'end_date' => $end_date,
					'package_expire_reminder_days' => $package_expire_reminder_days,
				];
				
				Mail::send($shareTemplate, ['data' => $shdata], function ($m) use ($student_email, $shareSubject) {
					$m->from(env('MAIL_FROM_ADDRESS'), env('MAIL_FROM_NAME'));
					$m->to($student_email)->subject($shareSubject);
					//$m->bcc(env('BCC_EMAIL'), env('BCC_EMAIL_NAME'));
				});				
			}
		}
    }
		
	public function package_expiration() {

		$package_expire_reminder_days = 18;//Settings::getSettings('package_expire_reminder_days');
        $expiry_date = date('Y-m-d', strtotime('+'.$package_expire_reminder_days.' days'));
		
		$packages = StudentLessons::where('status',1)
                            ->whereRaw("student_lessons.expire_date = '".$expiry_date."'")
                            ->whereRaw('student_lessons.expire_date IS NOT NULL')
                            ->with('service')->get();
							
		if(!empty($packages)  && $packages->toArray()) {
			foreach ($packages as $package) {
				$student_id = $package->user_id;
				$end_date = date('Y/m/d', strtotime($package->expire_date));
				$student = User::where('id', $student_id)->first();
				$student_email = env('BCC_EMAIL');//$student->email;
				$student_name = $student->firstname .' '.$student->lastname;
				$shareTemplate = "emails.package-expiration";
				$shareSubject = 'あと７日で現レッスンコースの期限となります。';
				$shdata = [
					'student_name' => $student_name,
					'end_date' => $end_date,
				];
				
				Mail::send($shareTemplate, ['data' => $shdata], function ($m) use ($student_email, $shareSubject) {
					$m->from(env('MAIL_FROM_ADDRESS'), env('MAIL_FROM_NAME'));
					$m->to($student_email)->subject($shareSubject);
					//$m->bcc(env('BCC_EMAIL'), env('BCC_EMAIL_NAME'));
				});				
			}
		}
    }	
		
	public function book_next_appointment() {

		$package_expire_reminder_days = Settings::getSettings('package_expire_reminder_days');
        $expiry_date = date('Y-m-d');
		
		$student_lessons = StudentLessons::where('status',1)
                            ->whereRaw("student_lessons.expire_date >= '".$expiry_date."'")
                            ->whereRaw('student_lessons.expire_date IS NOT NULL')
                            ->with('service')->get();
							
		if(!empty($student_lessons)  && $student_lessons->toArray()) {
			foreach ($student_lessons as $student_lesson) {
				$order_id = $student_lesson->id;
				$service_id = $student_lesson->service_id;
				$student_id = $student_lesson->user_id;
				$expiry_date = date('Y/m/d', strtotime($student_lesson->expire_date));
				$student = User::where('id', $student_id)->first();
				$student_email = env('BCC_EMAIL');//$student->email;
				$student_name = $student->firstname .' '.$student->lastname;
				$last_booked = $this->getLastBookedAppointmentDate($service_id, $order_id);		
				if($last_booked)
				{
					$datediff = time() - strtotime($last_booked);
					$days_diff =  floor($datediff/(60*60*24));
					
					// for 7 days recurring
					$a = $days_diff-7;
					$b = $a%7;
					$reoccur = false;
					if($days_diff>7 && $b==0)
					{
						$reoccur = true;
					}			
					
					$lesson_remaining = $student_lesson->available_bookings;
					$lesson_taught = $student_lesson->total_bookings - $lesson_remaining;
					if((($days_diff == 7) || ($reoccur==true)) && $lesson_remaining>0)//after 7 days email will be sent on each 4th day until appointment is booked.
					{
						$shareTemplate = "emails.book-next-appointment";
						$shareSubject = '次回のレッスンはいかがですか。お待ちしております。';
						$shdata = [
							'student_name' => $student_name,
							'last_booked' => $last_booked,
							'days_diff' => $days_diff,
							'expiry_date' => $expiry_date,
							'lesson_remaining' => $lesson_remaining,
						];
						
						Mail::send($shareTemplate, ['data' => $shdata], function ($m) use ($student_email, $shareSubject) {
							$m->from(env('MAIL_FROM_ADDRESS'), env('MAIL_FROM_NAME'));
							$m->to($student_email)->subject($shareSubject);
							//$m->bcc(env('BCC_EMAIL'), env('BCC_EMAIL_NAME'));
						});	
					}
				}							
			}
		}
    }
	
	function getLastBookedAppointmentDate($service_id = 0, $order_id = 0) {
		if($service_id != "" && $order_id != "") {
			$lesson_record = DB::table('student_lessons_bookings')
					->where('service_id', $service_id)
					->where('student_lessons_id', $order_id)
					->orderBy('lession_date', 'desc')
					->first();
			if(!empty($lesson_record->lession_date)){
				return $lesson_record->lession_date;
			} else {
				return false;
			}
		}
		
	}
	
	public function book_first_subscription_appointment() {

		$package_expire_reminder_days = Settings::getSettings('package_expire_reminder_days');
        $expiry_date = date('Y-m-d');
		
		//$query = 'select a.id from student_packages a left outer join student_lessons_bookings b on a.id = b.student_lessons_id where a.status ="active" and b.student_lessons_id is NULL';

		$orders = DB::table('student_packages')
						->select('student_packages.id', 'student_packages.user_id', 'packages.title')
						->join('student_lessons_bookings', 'student_packages.id', '=', 'student_lessons_bookings.student_lessons_id', 'left outer')
						->join('packages', 'student_packages.package_id', '=', 'packages.id')						
						->where('student_packages.status', "active")
						->where('student_lessons_bookings.student_lessons_id', null)
						->get();
		
		if(!empty($orders)  && $orders->toArray()) {
			foreach ($orders as $order) {				
				$student_id = $order->user_id;
				$student = User::where('id', $student_id)->first();
				$student_email = env('BCC_EMAIL');//$student->email;
				$title = $order->title;
				$student_name = $student->firstname .' '.$student->lastname;
				
				$shareTemplate = "emails.book-first-appointment";
				$shareSubject = '次回のレッスンはいかがですか。お待ちしております。';
				$shdata = [
					'student_name' => $student_name,
					'packages_name' => $title,
					'site_url' => url('/'),
				];
				
				Mail::send($shareTemplate, ['data' => $shdata], function ($m) use ($student_email, $shareSubject) {
					$m->from(env('MAIL_FROM_ADDRESS'), env('MAIL_FROM_NAME'));
					$m->to($student_email)->subject($shareSubject);
					//$m->bcc(env('BCC_EMAIL'), env('BCC_EMAIL_NAME'));
				});
			}
		}
    }
	
	public function book_first_package_appointment() {

		$package_expire_reminder_days = Settings::getSettings('package_expire_reminder_days');
        $expiry_date = date('Y-m-d');
		
		//$query = 'select a.id from student_packages a left outer join student_lessons_bookings b on a.id = b.student_lessons_id where a.status ="active" and b.student_lessons_id is NULL';

		$orders = DB::table('student_lessons')
						->select('student_lessons.id', 'student_lessons.user_id', 'services.title')
						->join('student_lessons_bookings', 'student_lessons.id', '=', 'student_lessons_bookings.student_lessons_id', 'left outer')
						->join('services', 'student_lessons.service_id', '=', 'services.id')						
						->where('student_lessons.status', 1)
						->where('student_lessons_bookings.student_lessons_id', null)
						->get();
		
		if(!empty($orders)  && $orders->toArray()) {
			foreach ($orders as $order) {				
				$student_id = $order->user_id;
				$student = User::where('id', $student_id)->first();
				$student_email = env('BCC_EMAIL');//$student->email;
				$title = $order->title;
				$student_name = $student->firstname .' '.$student->lastname;
				
				$shareTemplate = "emails.book-first-appointment";
				$shareSubject = '次回のレッスンはいかがですか。お待ちしております。';
				$shdata = [
					'student_name' => $student_name,
					'packages_name' => $title,
					'site_url' => url('/'),
				];
				
				Mail::send($shareTemplate, ['data' => $shdata], function ($m) use ($student_email, $shareSubject) {
					$m->from(env('MAIL_FROM_ADDRESS'), env('MAIL_FROM_NAME'));
					$m->to($student_email)->subject($shareSubject);
					//$m->bcc(env('BCC_EMAIL'), env('BCC_EMAIL_NAME'));
				});
			}
		}
    }
	
	public function onbreak_expiration() {

		$package_expire_reminder_days = Settings::getSettings('package_expire_reminder_days');
        $end_date = date('Y-m-d', strtotime('+'.$package_expire_reminder_days.' days'));

		$onbreak_plans = StudentOnbreakPlans::where('status','active')
                            ->where('end_date', $end_date)
							->get();
		
		if(!empty($onbreak_plans)  && $onbreak_plans->toArray()) {
			foreach ($onbreak_plans as $onbreak_plan) {				
				$student_id = $onbreak_plan->user_id;
				$student = User::where('id', $student_id)->first();
				$student_email = env('BCC_EMAIL');//$student->email;				
				$student_name = $student->firstname .' '.$student->lastname;
				$end_date = $onbreak_plan->end_date;
				
				$shareTemplate = "emails.onbreak-expiration";
				$shareSubject = 'OnBreak Plan expiring soon on';
				$shdata = [
					'student_name' => $student_name,
					'package_expire_reminder_days' => $package_expire_reminder_days,
					'site_url' => url('/'),
				];
				
				Mail::send($shareTemplate, ['data' => $shdata], function ($m) use ($student_email, $shareSubject) {
					$m->from(env('MAIL_FROM_ADDRESS'), env('MAIL_FROM_NAME'));
					$m->to($student_email)->subject($shareSubject);
					//$m->bcc(env('BCC_EMAIL'), env('BCC_EMAIL_NAME'));
				});
			}
		}
    }
	
	function update_rolledover_lessons() {
		// get previous day orders
		$previous_day_date = date('Y-m-d', strtotime('-1 day'));
		$StudentLessons = StudentLessons::where('status',1)
                            ->whereRaw("student_lessons.start_date = '".$previous_day_date."'")
							->whereNotIn('service_id', [env('ONEPAGE_SERVICE_ID'), env('REGISTRATION_SERVICE_ID')])
							->orderBy('id','DESC')
                            ->get();
		//loop through each order and prepare array of ddls
		if(!empty($StudentLessons)) {
			$regular_course_rollover_precentage = Settings::getSettings('regular_course_rollover_precentage');
			//echo '<pre>';print_r($StudentLessons);
			foreach($StudentLessons as $order) {
				$recent_order_id = $order->id;
				$service_id = $order->service_id;
				$neworder_available_lessons = $order->available_bookings;
				$new_order_id = $order->id;
				$user_id = $order->user_id;
				$student  = User::where('id', $user_id)->first();
				
				$service = Services::find($service_id);
				$total_lessons = $service->available_lessons;
				
				$recent_order_date = $order->start_date;
				// get last to last order of user
				$lastOrder = StudentLessons::where('status',1)
                            ->where("user_id", $user_id)
                            ->where("service_id", $service_id)
							->whereNotIn('service_id', [env('ONEPAGE_SERVICE_ID'), env('REGISTRATION_SERVICE_ID')])
							->whereRaw("expire_date <= '".$previous_day_date."'")
							->orderBy('id','DESC')
                            ->first();
				if(!empty($lastOrder)) {	
				
					$lastOrder_id = $lastOrder->id;						
					$lastOrder_available_bookings = $lastOrder->available_bookings;	
					$lastOrder_expiry_date = $lastOrder->expire_date;	
					$diff = strtotime($recent_order_date) - strtotime($lastOrder_expiry_date);
					
					// if there are lessons available and expiry date has passed. and difference is less than 5 days				
					if($lastOrder_available_bookings >= 1 && ($diff<=432000)) { // 432000 = 5days
						$twentyPercoforderAmt = round((($total_lessons * $regular_course_rollover_precentage) / 100));
						// check what is less, available lessons or lessons based on admin rolled over percentage. Whatever is less give that as rolled over lessons
						if ($twentyPercoforderAmt < $lastOrder_available_bookings) {
							$lastOrder_available_bookings = $twentyPercoforderAmt;
						}
											
						$StudentLessons_to_update = StudentLessons::find($recent_order_id);
						$StudentLessons_to_update->available_bookings = $neworder_available_lessons + $lastOrder_available_bookings;
						$StudentLessons_to_update->rolled_over_lessons = $lastOrder_available_bookings;
						//$StudentLessons_to_update->save();
						
						// send email to admin
						if(env('IS_EMAIL_ENABLED') == 1){
							$template = "emails.rolledOverLessons";
							$subject = "Lesson rollover detail";

							$tdata = [
								'student_name' => $student->firstname.' '.$student->firstname,
								'student_email' => $student->email,
								'no_of_rolledover_lessons' => $lastOrder_available_bookings,
								'previous_order_no' => $lastOrder_id,
								'new_order_no' => $new_order_id,
								'service_id' => $service_id,
								'site_title' => env('APP_NAME')
							];
							//echo '<pre>';print_r($tdata);
							$to = env('BCC_EMAIL');
							Mail::send($template, ['data' => $tdata], function ($m) use ($to, $subject) {
								$m->from(env('MAIL_FROM_ADDRESS'), env('MAIL_FROM_NAME'));
								$m->to($to)->subject($subject);	
							});				
						}
					}	
				}					
			}
		}		
	}
	
	function update_line_token() {
		$tempLineUsers = TempLineUsers::where('status',0)
							->orderBy('id','DESC')
                            ->get();
		//loop through each record
		if(!empty($tempLineUsers)) {
			foreach($tempLineUsers as $tempLineUser) {
				//$tempLineUser_id = $tempLineUser->id;	
				$user = User::where('line_reply_token', $tempLineUser->replyToken)->first();
				if(!empty($user)) {
					$user_name = $user->firstname.' '.$user->lastname;	
					$user_id =$user->id;	
					
					$user->line_token = $tempLineUser->user_id;
					$user->save();
					
					$tempLineUser->status = 1;
					$tempLineUser->save();
					// send email to admin
					if(env('IS_EMAIL_ENABLED') == 1){
						$template = "emails.lineTokenScanned";
						$subject = "User scanned line QR code.";

						$tdata = [
							'user_name' => $user_name,
							'site_title' => env('APP_NAME')
						];
						
						$to = env('BCC_EMAIL');
						Mail::send($template, ['data' => $tdata], function ($m) use ($to, $subject) {
							$m->from(env('MAIL_FROM_ADDRESS'), env('MAIL_FROM_NAME'));
							$m->to($to)->subject($subject);	
						});				
					}
				}
			}			
		}
	}	
	
	function update_lesson_extension() {
		$holidays = HolidaySettings::find(1);

        if(!empty($holidays)){
            $holidays = $holidays->toArray();
        }
		
		$html = '<table cellpadding="1" cellspacing="1" border="1">
<tr><th>User id</th><th>User Name</th><th>Order id</th><th>Service</th><th>Order Date</th><th>Lesson expiry date</th><th>New expiry date</th></tr>';

        if((!empty($holidays['start_date'])) && ($holidays['end_date'])){
            $holiday_start_date = $holidays['start_date'];
            $holiday_end_date = $holidays['end_date'];
			echo $diff = $this->getDaysBetweenDates(strtotime($holiday_start_date), strtotime($holiday_end_date));
			
			// get all order of previous year which are ending within or after holiday
			$StudentLessons = StudentLessons::where('status',1)
							->whereNotIn('service_id', [env('ONEPAGE_SERVICE_ID'), env('REGISTRATION_SERVICE_ID'), 193, 194, 201, 202, 197, 199, 196, 198, 200])
							->whereRaw("start_date <= '".$holiday_end_date."'")
							->whereRaw("expire_date >= '".$holiday_start_date."'")
							->orderBy('id','DESC')
                            ->get();
			if(!empty($StudentLessons)) {
				//echo '<pre>';print_r($StudentLessons);exit;
				foreach ($StudentLessons as $studentLesson) {
					$order_id = $studentLesson->id;
					$start_date = $studentLesson->start_date;
					$lesson_expiry_date = $studentLesson->expire_date;
					$user_id = $studentLesson->user_id;
					$service_id = $studentLesson->service_id;
					$service = Services::where('id', $service_id)->first();
					$new_expiry_date = '';
					if((strtotime($lesson_expiry_date) >= strtotime($holiday_start_date) && strtotime($lesson_expiry_date) <= strtotime($holiday_end_date)) || 
					   (strtotime($start_date) >= strtotime($holiday_start_date) && strtotime($start_date) <= strtotime($holiday_end_date)) || 
					   (strtotime($start_date) <= strtotime($holiday_start_date) && strtotime($lesson_expiry_date) >= strtotime($holiday_end_date))){
						$new_expiry_date = date('Y-m-d', strtotime('+'.$diff.' days', strtotime($lesson_expiry_date)));
				    }
					/*$studentLesson->expire_date = $new_expiry_date;
					$studentLesson->days_extend = $diff;
					$studentLesson->save();*/
					
					
					$student = User::where('id', $user_id)->first();
					
					$user_name = $student->firstname.' '.$student->lastname;
					$html .='<tr><td>'.$user_id.'</td><td>'.$user_name.'</td><td>'.$order_id.'</td><td>'.$service->title.'</td><td>'.$start_date.'</td><td>'.$lesson_expiry_date.'</td><td>'.$new_expiry_date.'</td></tr>';
					//break;
				}
			}
		}
		echo $html .='</table>';
	}
	
	function getDaysBetweenDates($date1, $date2) {
		$datediff = $date2 - $date1;
		return floor($datediff/(60*60*24));
	}
	
	function update_active_students() {
		$user_ids = [];
		$activeStudents = User::where('is_active', 1)->where('status', 1)->where('user_type', 'student')->orderBy('id', 'desc')->pluck('id')->toArray();
		
		
		
		$studentLessons = StudentLessons::where('status',1)
							->whereNotIn('service_id', [env('ONEPAGE_SERVICE_ID'), env('REGISTRATION_SERVICE_ID'), 193, 194, 201, 202, 197, 199, 196, 198, 200])
							->whereRaw("expire_date > '".date('Y-m-d')."'")
							->orderBy('user_id','DESC')
                            ->get();
		if(!empty($studentLessons)) {
			foreach ($studentLessons as $studentLesson) {
				if(!in_array($studentLesson->user_id, $user_ids)) {
					$user_ids[] = $studentLesson->user_id;
				}
			}
		}
		
		$studentPackages = StudentPackages::whereRaw("end_date > '".date('Y-m-d 23:59:59')."'")
							->orderBy('user_id','DESC')
                            ->get();
		if(!empty($studentPackages)) {
			foreach ($studentPackages as $studentPackage) {
				if(!in_array($studentPackage->user_id, $user_ids)) {
					$user_ids[] = $studentPackage->user_id;
				}
			}
		}
		
		//echo '<pre>';print_r($activeStudents);		
		//echo '<pre>';print_r($user_ids);	
		$inactive_students = array_diff($activeStudents, $user_ids);	
		if(!empty($inactive_students)) {
			//echo '<pre>';print_r($inactive_students);	
			$update = User::whereIn('id', $inactive_students)->update(['is_active' => 0]);
		}
	}
	
	function creategdrive() {
		// send data on google doc for Amany
		$date = date('Y-m-d');
		$users = User::whereNull('drive_folder_id')
					->where('user_type', 'student')
					->whereRaw("to_char(created_at, 'YYYY-MM-DD') = '" . $date . "'")
					->orderBy('id', 'ASC')
					->get();
		if(!empty($users)) {
			foreach($users as $user) {
				$fname = $user->firstname;
				$lname = $user->lastname;
				//echo $fname.' '.$lname;
				$email = $user->email;
				if($fname != '' && $lname != '' && $email != '') {
					$url = 'https://script.google.com/macros/s/AKfycbyCMA9SMh5ZowFcltLr2c4kkPQNZgIeGNPG8jxiLEho7mOsuHpq/exec?fname='.$fname.'&lname='.$lname.'&email='.$email;
					$curl=curl_init();
					curl_setopt($curl, CURLOPT_URL, $url);
					curl_setopt($curl, CURLOPT_RETURNTRANSFER,1);		
					curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
					$res = curl_exec($curl);
					curl_close($curl);	
					$res = json_decode($res);		
					if(!$res->isError)
					{
						//echo '<pre>';print_r($res);		
					}
				}
			}
		}			
	}
	
	function updategdrive() {
		$drivefolders = AppHelper::getFolders('0B5qI3k-TXY_FZTk1MzY0MGEtMDY2Yi00ZGNhLTllZTgtOGJlNDc3OGZjM2Q3');
		$student = [];
		if(isset($drivefolders->files)) {
			$folders = $drivefolders->files;
			foreach($folders as $folder) {
				$student[$folder->name] = $folder->id;
			}
		}
		
		$all_users = User::whereNull('drive_folder_id')->where('user_type', 'student')->orderBy('id', 'ASC')->get();
		foreach($all_users as $user) {
			$user_id = $user->id;
			$name = $user->firstname.' '.$user->lastname;
			if(isset($student[$name]) && $user->firstname != '') {
				echo $name.'----';
				echo $drive_folder_id = $student[$name];
				echo '<br>';
				$user->drive_folder_id = $drive_folder_id;
				$user->save();
				//exit;
			}
		}
	}

	function appointmentReminder() {
		$booking_reminder_hrs = Settings::getSettings('booking_reminder');
		$booking_reminder_hrs2 = $booking_reminder_hrs + 1;
		
		$start = date('Y-m-d H:i:00', strtotime('+'.$booking_reminder_hrs.' hour')); //'2019-12-14 15:00:00';
		$end = date('Y-m-d H:i:00', strtotime('+'.$booking_reminder_hrs2.' hour')); //'2019-12-14 16:00:00';
		$studentLessonsBooking = StudentLessonsBooking::where('status','booked')
                            ->whereRaw("(CONCAT(lession_date,' ',lession_time)) >= '$start' and 
(CONCAT(lession_date,' ',lession_time)) < '$end'")
                            ->get();
		//echo '<pre>';print_r($studentLessonsBooking);
		$userdetail = $servicedetail = $locationdetail = [];
		if(!empty($studentLessonsBooking)) {
			
			$services = Services::where('status', 1)->orderBy('id','DESC')->get();
			if(!empty($services)) {
				foreach($services as $service) {
					$servicedetail[$service->id] = $service->title;
				}
			}
			
			$locations = Locations::where('status', 1)->get();
			if(!empty($locations)) {
				foreach($locations as $location) {
					$locationdetail[$location->id] = $location->title;
				}
			}
			
			//echo '<pre>';print_r($servicedetail);
			foreach($studentLessonsBooking as $booking) {
				$user_id = $booking->user_id;
				$student = User::where('id', $user_id)->first();
				$student_name = $student->firstname.' '.$student->lastname;
				$student_email = $student->email;
				$student_line_token = $student->line_token;
				
				$lesson_date = $booking->lession_date;
				$lesson_time = substr($booking->lession_time, 0, 5);
				
				$teacher_id = $booking->teacher_id;
				$teacher = User::where('id', $teacher_id)->first();
				$teacher_name = $teacher->firstname.' '.$teacher->lastname;
				$teacher_email = $teacher->email;
				$teacher_line_token = $teacher->line_token;
				
				$service_id = $booking->service_id;
				$service_name = $servicedetail[$service_id];
				
				$location_id = $booking->location_id;
				$location_name = $locationdetail[$location_id];
				
				if(env('IS_EMAIL_ENABLED') == 1 && ($teacher_id == 368 || $teacher_id == 364)){
					if(!empty($student_email)) {
						$template = "emails.lessonreminder";
						$subject = "あと１時間でレッスンが始まります";

						$tdata = [
							'student_name' => $student_name,
							'teacher_name' => $teacher_name,
							'lesson_date' => $lesson_date,
							'lesson_time' => $lesson_time,
							'service_name' => $service_name,
							'site_url' => url('/'),
						];
						$to = env('BCC_EMAIL');
						//echo '<pre>';print_r($tdata);
						/*Mail::send($template, ['data' => $tdata], function ($m) use ($student_email, $subject) {
							$m->from(env('MAIL_FROM_ADDRESS'), env('MAIL_FROM_NAME'));
							$m->to($student_email)->subject($subject);	
							$m->bcc(env('BCC_EMAIL'), env('BCC_EMAIL_NAME'));
						});*/

						/*$sdata = [
							'user' => $student,
							'student_name' => $student_name,
							'teacher_name' => $teacher_name,
							'lesson_date' => $lesson_date,
							'lesson_time' => $lesson_time,
							'service_name' => $service_name,
							'site_url' => url('/'),
						];*/
						
						//echo '<pre>';print_r($tdata);
						Mail::send($template, ['data' => $tdata], function ($m) use ($teacher_email, $subject) {
							$m->from(env('MAIL_FROM_ADDRESS'), env('MAIL_FROM_NAME'));
							$m->to($teacher_email)->subject($subject);	
							$m->bcc(env('BCC_EMAIL'), env('BCC_EMAIL_NAME'));
						});
					}
				}
				
				/* Send Push to Student */
				if(env('IS_LINE_ENABLED') == 1 && ($teacher_id == 368 || $teacher_id == 364)){
					/*if(!empty($student_line_token)){
						AppHelper::sendLineNotification($student_line_token, $teacher_name, $service_name, $location_name, $lesson_date .' '.$lesson_time, 'student', 'reminder');
					}*/

					/* Send Push to Teaacher */
					if(!empty($teacher_line_token)){
						AppHelper::sendLineNotification($teacher_line_token, $student_name, $service_name, $location_name, $lesson_date .' '.$lesson_time, 'teacher', 'reminder');
					}
					
					/* Send Push to own */
					AppHelper::sendLineNotification('Uaeb57c050913b806dbb0751ee1348130', $teacher_name, $service_name, $location_name, $lesson_date .' '.$lesson_time, 'student', 'reminder');
				}
			}
		}
	}
}
