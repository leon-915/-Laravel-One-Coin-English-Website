<?php

namespace App\Http\Controllers\Student;

use App\Models\Services;
use App\Models\Locations;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;
use App\Models\Packages;
use Stripe\Customer;
use Stripe\Stripe;
use Stripe\Charge;
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
use App\Models\HolidaySettings;
use Illuminate\Support\Facades\Mail;


class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $ref = $request->get('ref', 'management');
        return view('students.dashboard.index', compact('ref'));
    }

    public function currentCourse(Request $request) {
        $user_id = Auth::user()->id;
        $student = User::where('id', $user_id)->first();
        $studentDetails = $student->details()->first();

        $package = StudentPackages::where('user_id', $user_id)
                                    ->whereRaw("start_date <= '".date('Y-m-d')."'::date")
                                    ->whereRaw("end_date >= '".date('Y-m-d')."'::date")
                                    ->where('status', 'active')
                                    ->with('package')
									->orderBy('id','ASC')
                                    ->first();

        $packageServices = array();
        $studentPackageLessons = [];
        $studentPackageLessonsBookings = [];
        $spCompleted = $tnoshowcnt = 0;
        if(!empty($package)){
            /*$packageServices = StudentLessons::where('user_id', $user_id)
                                ->with('service')
                                ->where('status',1)
                                ->where('student_package_id', $package->package_id)
                                ->pluck('service_id')->toArray();*/
			$packageServices = Services::where('status',1)
                                ->where('is_system_service', 1)
                                ->pluck('id')->toArray();					

            if(!empty($packageServices)){
                $studentPackageLessonsBookings = StudentLessonsBooking::where('user_id', $user_id)
                                                        ->whereIN('service_id', $packageServices)
                                                        ->where('student_lessons_id', $package->id)
														->whereRaw("lession_date >= '".$package->start_date."'::date")
														->whereRaw("lession_date <= '".$package->end_date."'::date")
                                                        ->with('teacher')
                                                        ->with('location')
                                                        ->with('teacherDetail')
                                                        ->with('service')
                                                        ->orderBy('lession_date','DESC')
                                                        ->orderBy('lession_time','DESC')
                                                        ->paginate(20)
                                                        ->withPath('current-package/get-booking');

                $spCompleted = StudentLessonsBooking::where('user_id', $user_id)
                                            ->whereIN('service_id', $packageServices)
                                            ->where('student_lessons_id', $package->id)
                                            ->where('status', 'completed')
                                            ->count();
				$tnoshowcnt = StudentLessonsBooking::where('user_id', $user_id)
                                            ->where('student_lessons_id', $package->id)
                                            ->where('status', 'teacher_not_show')
                                            ->count();							

            }
        }


        $student_lessons = StudentLessons::where('user_id', $user_id)
                            ->where(function($query){
                                $query->where('expire_date', '>=', date('Y-m-d'))
                                        ->orwhereRaw('expire_date IS NULL');
                            })->with('service')
                            ->where('status',1)
                            ->whereNotIn('service_id', [env('ONEPAGE_SERVICE_ID'), env('REGISTRATION_SERVICE_ID'), env('CAFE25_SERVICE_ID'), env('CAFE50_SERVICE_ID'), env('VIRTUAL25_SERVICE_ID'), env('VIRTUAL50_SERVICE_ID'), env('CLASSROOM25_BASIC_SERVICE_ID'), env('CLASSROOM25_COMPLETE_SERVICE_ID'), env('CLASSROOM50_BASIC_SERVICE_ID'), env('CLASSROOM50_COMPLETE_SERVICE_ID'), env('CLASSROOM50_PRO_SERVICE_ID')])
                            ->whereRaw('student_package_id IS NULL')
                            ->orderBy('id','DESC')->get();

/*echo '<pre>';print_r($student_lessons);exit;*/
                            $completed = null;
        if(!empty($student_lessons) && $student_lessons->toArray()){
            foreach ($student_lessons as $key => $value) {
                $student_lessons[$key]['bookings'] = StudentLessonsBooking::where('user_id', $user_id)
                                                ->where('service_id', $value['service_id'])
                                                ->where('student_lessons_id', $value['id'])
                                                ->whereNotIn('status', ['deleted'])
                                                ->with('teacher')
                                                ->with('location')
                                                ->with('teacherDetail')
                                                ->with('service')
                                                ->orderBy('lession_date','DESC')
                                                ->orderBy('lession_time','DESC')
                                                ->paginate(20)
                                                ->withPath('current-course/get-booking');

                $service_ids[$key] = $value['service_id'];

                $completed[$key] = StudentLessonsBooking::where('user_id', $user_id)
                                       ->where('service_id', $value['service_id'])
                                       ->where('student_lessons_id', $value['id'])
                                       ->where('status', 'completed')
                                       ->count();
            }
        }

//echo '<pre>';print_r($student_lessons);exit;
        $html = view('students.dashboard.index.current-course',compact('student_lessons', 'package','completed','packageServices','studentPackageLessonsBookings', 'spCompleted', 'tnoshowcnt', 'studentDetails'))->render();
        return response()->json(['type' => 'success', 'html' => $html]);
    }

    public function currentCourseBookings(Request $request) {
        $input = $request->all();
		
        $user_id = Auth::user()->id;
        $student = User::where('id', $user_id)->first();

        $lesson = StudentLessons::where('user_id', $user_id)
                                        ->where('id', $input['lesson_id'])
                                        ->where('status',1)
                                        ->with('service')->first()
                                        ->toArray();

        $lesson['bookings'] = StudentLessonsBooking::where('user_id', $user_id)
                                                ->where('service_id', $input['service_id'])
                                                ->with('teacher')
                                                ->with('location')
                                                ->with('teacherDetail')
                                                ->with('service')
                                                ->orderBy('lession_date','DESC')
                                                ->orderBy('lession_time','DESC')
                                                ->paginate(20)
                                                ->withPath('current-course/get-booking');

        $lesson['service'] = Services::where('id', $input['service_id'])->first();

        $html = view('students.dashboard.index.current-course.lessons.bookings',compact('lesson'))->render();
        return response()->json(['type' => 'success', 'html' => $html]);
    }

    public function currentPackageBookings(Request $request) {
        $user_id = Auth::user()->id;
        $student = User::where('id', $user_id)->first();
        $studentDetails = $student->details()->first();

        $input = $request->all();

        $package = StudentPackages::where('user_id', $user_id)
                                    ->whereRaw("start_date <= '".date('Y-m-d')."'::date")
                                    ->whereRaw("end_date >= '".date('Y-m-d')."'::date")
                                    ->where('status', 'active')
                                    ->with('package')
                                    ->first();

        /*$packageServices = StudentLessons::where('user_id', $user_id)
                            ->with('service')
                            ->where('status',1)
                            ->where('student_package_id', $package->package_id)
                            ->pluck('service_id')->toArray();*/
		$packageServices = Services::where('status',1)
                                ->where('is_system_service', 1)
                                ->pluck('id')->toArray();						

        if(!empty($packageServices)){
            $studentPackageLessonsBookings = StudentLessonsBooking::where('user_id', $user_id)
                                                    ->whereIN('service_id', $packageServices)
														->whereRaw("lession_date >= '".$package->start_date."'::date")
														->whereRaw("lession_date <= '".$package->end_date."'::date")
                                                    ->with('teacher')
                                                    ->with('location')
                                                    ->with('teacherDetail')
                                                    ->with('service')
                                                    ->orderBy('lession_date','DESC')
                                                    ->orderBy('lession_time','DESC')
                                                    ->paginate(20)
                                                    ->withPath('current-package/get-booking');
        }

        $html = view('students.dashboard.index.current-course.packages.bookings',compact('package','studentPackageLessonsBookings'))->render();
        return response()->json(['type' => 'success', 'html' => $html]);
    }

    public function currentCourseDetail(Request $request, $id) {
        $booking = StudentLessonsBooking::find($id);
        $locations  = ServiceLocations::where('service_id', $booking['service_id'])
            ->leftjoin('location', 'services_locations.location_id', '=', 'location.id')
            ->get();
        $teachers  = TeacherServices::where('service_id', $booking['service_id'])
            ->leftjoin('users', 'teacher_services.teacher_id', '=', 'users.id')
            ->where('users.status',1)
            ->where('teacher_services.is_deleted',0)
            ->get();
        $service = StudentLessons::where('service_id', $booking['service_id'])
            ->where('user_id', Auth::id())
			->where('status',1)
			->where('id',$booking['student_lessons_id'])
			->first();
        if (!empty($service)) {
            $maxDate = date('Y-m-d', strtotime($service->expire_date));
        } else {
            $maxDate = '';
        }

        return view('students.dashboard.index.course-edit', compact('teachers','locations','maxDate','booking'));
    }

    public function changeLocation(Request $request, $id) {

        $booking = StudentLessonsBooking::where('service_id', $id)->get();
        $location_id = $request->location_id;
        $teachers  = User::where('service_id', $id)->where('location_id', $location_id)
            ->leftjoin('teacher_services', 'teacher_services.teacher_id', '=', 'users.id')
            ->leftjoin('teacher_locations', 'teacher_locations.user_id', '=', 'users.id')
            ->get();

        return response()->json($teachers);
    }

    public function changeTeacher(Request $request) {

        $service = StudentLessons::where('service_id', $request->service_id)
		->where('user_id', Auth::id())
		->where('id', $request->booking_id)
		->where('status',1)
		->first();

        $holidays = HolidaySettings::find(1);
        if(!$holidays){
            $holidays = HolidaySettings::create();
        }
        $dates = [];
        if(!empty($holidays)){
            $from = $holidays['start_date'];
            $to = $holidays['end_date'];

            if($from && $to){
                $interval = new DateInterval('P1D');
                $realEnd = new DateTime($to);
                $realEnd->add($interval);

                $period = new DatePeriod(new DateTime($from), $interval, $realEnd);

                foreach($period as $date) {
                    $dates[] = $date->format('Y-m-d');
                }
            }
        }

        $minDate = date('Y-m-d');
        if (!empty($service)) {
            if(time() < strtotime($service->start_date)){
                $minDate = date('Y-m-d', strtotime($service->start_date));
            }
            if($service->expire_date){
                $maxDate = date('Y-m-d', strtotime($service->expire_date));
            } else {
                $maxDate = date('Y-m-d', strtotime('+30 days'));
            }
        } else {
            $maxDate = date('Y-m-d', strtotime('+30 days'));
        }

        return response()->json(['maxDate' => $maxDate,'holidays' => $dates,'minDate' => $minDate]);
    }

    public function updateService(Request $request, $id) {
        $user_id = Auth::user()->id;
        $student = User::find($user_id);

        $request->validate([
            'teacher' => 'required',
            'location' => 'required',
            'reserve_date' => 'required',
            'time' => 'required'
        ]);

        $teacher  = User::where('id', $request->teacher)->first();
        $teacherDetails = $teacher->details()->first();

        if(Carbon::parse($request->reserve_date)->isToday()){

            $beforeTimeAdmin = Settings::getSettings('book_before_time');
            $less = ($teacherDetails->book_before_time != 0) ? $teacherDetails->book_before_time :
                                $beforeTimeAdmin;
            //$less = ($beforeTimeTeacher <= $beforeTimeAdmin) ? $beforeTimeTeacher : $beforeTimeAdmin;

            $date = new DateTime($request->reserve_date);
            $time = new DateTime($request->time);
            $date->setTime($time->format('H'), $time->format('i'), $time->format('s'));
            $combine = $date->format('Y-m-d H:i:s');

            $to = Carbon::createFromFormat('Y-m-d H:i:s',$combine);
            $from = Carbon::createFromFormat('Y-m-d H:i:s', Carbon::now());
            $diff_in_min = $to->diffInMinutes($from);

            if($diff_in_min <= ($less*60)){
                return redirect(route('students.reservation.index'))->with('error', 'You are late. Please select other time.');
            }

        }

        $input = $request->all();

        $booking = StudentLessonsBooking::find($id);/*where('user_id', $user_id)
                                            ->where('service_id', $request->service)
                                            ->first();*/


        $booking->teacher_id = $request->teacher;
        $booking->location_id = $request->location;
        $booking->lession_date = $request->reserve_date;
        $booking->lession_time = $request->time;
        $booking->status = 'booked';

        $booking->save();

        $service = Services::find($booking->service_id);
        $location = Locations::find($booking->location_id);

		if(env('IS_EMAIL_ENABLED') == 1){
			// Send mail to teacher and student
			$template = "emails.lessionBooking";
			$subject = 'Appointment changed for '.$student->firstname.' '.$student->lastname;

			$tdata = [
				'user' => $teacher,
				'student' => $student,
				'teacher' => $teacher,
				'date' => $request->reserve_date,
				'time' => $request->time,
				'lesson' => $service->title,
				'location' => $location->title,
				'site_url' => url('/'),
				'title' => 'Appointment Change',
			];
			dispatch(new SendEmailJob($template, $tdata, $subject, 'user'));

			$stemplate = "emails.student-lessionBooking";
			$subject = "予約が変更されました";
			$sdata = [
				'user' => Auth::user(),
				'student' => $student,
				'teacher' => $teacher,
				'date' => $request->reserve_date,
				'time' => $request->time,
				'lesson' => $service->title,
				'location' => $location->title,
				'booking_id' => $booking->id,
				'site_url' => url('/'),
				'title' => 'Appointment Change',
			];
			dispatch(new SendEmailJob($stemplate, $sdata, $subject, 'user'));
		}

		if(env('IS_LINE_ENABLED') == 1){
			 /* Send Push to Student */
			if(!empty($student->line_token)){
				$student->line_token.'--'.$teacher->firstname .' '.$teacher->lastname.'--'.$service->title.'--'.$location->title.'--'.$request->reserve_date .' '.$request->time.'--student--rescheduled';
				/*$messages = [];
				$messages['to'] = $student->line_token;
				$msg = "Booking Rescheduled\n";
				$msg .= "Lesson : ". $service->title ."\n";
				$msg .= "Location : ". $location->title ."\n";
				$msg .= "Teacher Name : ". $teacher['firstname'] .' '.$teacher['teacher']['lastname'] ."\n";
				$msg .= "Booking Date : " . $request->reserve_date .' '.$request->time."\n";
				$messages['messages'][] = AppHelper::getFormatTextMessage($msg);
				$encodeJson = json_encode($messages);
				AppHelper::sentMessage($encodeJson);*/
				AppHelper::sendLineNotification($student->line_token, $teacher->firstname .' '.$teacher->lastname, $service->title, $location->title, $request->reserve_date .' '.$request->time, 'student', 'rescheduled');
			}

			/* Send Push to Teaacher */
			if(!empty($teacher->line_token)){
				$teacher->line_token.'--'.$student->firstname .' '.$student->lastname.'--'.$service->title.'--'.$location->title.'--'.$request->reserve_date .' '.$request->time.'--teacher--rescheduled';
				/*$tmessages = [];
				$tmessages['to'] = $teacher->line_token;
				$tmsg = "Booking Rescheduled.\n";
				$tmsg .= "Lesson :". $service->title ."\n";
				$tmsg .= "Location : ". $location->title ."\n";
				$tmsg .= "Student Name :". $student->firstname .' '.$student->lastname ."\n";
				$tmsg .= "Booking Date : " .  $request->reserve_date .' '.$request->time."\n";
				$tmessages['messages'][] = AppHelper::getFormatTextMessage($tmsg);
				$tencodeJson = json_encode($tmessages);
				AppHelper::sentMessage($tencodeJson);*/
				AppHelper::sendLineNotification($teacher->line_token, $student->firstname .' '.$student->lastname, $service->title, $location->title, $request->reserve_date .' '.$request->time, 'teacher', 'rescheduled');
			}
			
			/* Send Push to own */
			AppHelper::sendLineNotification('Uaeb57c050913b806dbb0751ee1348130', $student->firstname .' '.$student->lastname, $service->title, $location->title, $request->reserve_date .' '.$request->time, 'teacher', 'rescheduled');
		}

        //Send mail(to share record emails)

        $shareRecords = StudentShareRecord::where('user_id', $user_id)
                                            ->where('share_type', 'lessons')
                                            ->pluck('email');

        if(!empty($shareRecords) && $shareRecords->toArray()){
            $shareTemplate = "emails.lession-wrap";
            $shareSubject = "Lesson successfully rescheduled for ".$student->firstname .' '. $student->lastname;
            $shdata = [
                'student' => $student,
                'teacher' => $teacher,
                'date' => $request->reserve_date,
                'time' => $request->time,
                'lesson' =>  $service->title,
                'location' =>  $location->title,
                //'booking' => $booking
            ];

            foreach ($shareRecords as $shareEmail) {
                Mail::send($shareTemplate, ['data' => $shdata], function ($m) use ($shareEmail, $shareSubject) {
                    $m->from(env('MAIL_FROM_ADDRESS'), env('MAIL_FROM_NAME'));
                    $m->to($shareEmail)->subject($shareSubject);					
					$m->bcc(env('BCC_EMAIL'), env('BCC_EMAIL_NAME'));
                });
            }
        }

        //$request->session()->flash('message', 'Booking Rescheduled Succcessfully.');

        return redirect()->route('students.dashboard.index')->with('message', 'Booking Rescheduled Succcessfully.');

    }

    public function cacelBooking(Request $request, $id) {

        $user_id = Auth::user()->id;
        $user    = Auth::user();
        $booking = StudentLessonsBooking::find($id);

        $booking->status = "cancel";
        $booking->save();
        $bookingDetail = StudentLessonsBooking::where('id', $id)
                        /*->with('teacher')
                        ->with('student')
                        ->with('location')
                        ->with('service')*/
                        ->first();

		
        $bookingDetail->status = 'cancel';
        $bookingDetail->cancelled_at = date('Y-m-d H:i:s');
        $bookingDetail->save();

        $lesson = StudentLessons::where('user_id', $user_id)
                                        ->where('service_id', $booking['service_id'])
                                        ->where('id', $booking['student_lessons_id'])
                                        ->where('status',1)
                                        ->first();
										
        $service = ServicePackages::where('service_id', $booking['service_id'])->where('is_deleted',0)->first();
        $serviceDetail = Services::find($booking['service_id']);
        $locationDetail = Locations::find($booking['location_id']);
        $studentDetail = StudentDetail::where('user_id', $booking['user_id'])->first();
        $message = '';

        if($booking['lession_type'] == 'trial'){
            $lesson->available_bookings = 1;
			$lesson->save();
           // $message = "Trail Lesson Canceled.";
        }else if($serviceDetail->is_system_service == 1){ // point system service
			//get studentpackage
			$StudentPackages = StudentPackages::where('id', $booking['student_lessons_id'])->first();
			$old_consumed_credits = $StudentPackages->consumed_credits;
			$old_consumed_rewards = $StudentPackages->consumed_rewards;
			
			$new_consumed_rewards = $old_consumed_rewards - $booking['total_earnings'];
			if($new_consumed_rewards == 0) {
				$StudentPackages->consumed_rewards = 0;
			} else if($new_consumed_rewards < 0 && $old_consumed_rewards > 0) {
				$new_consumed_rewards = $booking['total_earnings'] - $new_consumed_rewards;
				$StudentPackages->consumed_rewards = 0;
				$StudentPackages->consumed_credits = $old_consumed_credits - $new_consumed_rewards;
			} else {
				$StudentPackages->consumed_credits = $old_consumed_credits - $booking['total_earnings'];
			}			
			
			$StudentPackages->save();
			
			$studentDetail->credit_balance = $studentDetail->credit_balance + $booking['total_earnings'];
			$reward = 0;
			if($serviceDetail->receive_credit_on_booking_type == 2){
                $reward = ($serviceDetail->price) * ($serviceDetail->receive_credit_on_booking) / 100;
            } else {
				$receive_credit_on_booking = $serviceDetail->receive_credit_on_booking ? $serviceDetail->receive_credit_on_booking : 1;
				$reward = $receive_credit_on_booking;
			}
			
            $studentDetail->reward_balance = $studentDetail->reward_balance - $reward;
			$studentDetail->save();   
		} else if(!empty($lesson)){
            $lesson->available_bookings = $lesson->available_bookings + 1;
			$lesson->is_expired = 0;			
			$lesson->save();
            //$message = "Lesson Canceled.";
        }
		       

        $teacher = User::find($booking['teacher_id']);
		if(env('IS_EMAIL_ENABLED') == 1){
			if(!empty($user->email)){
				$template = "emails.student-cancel-lesson";
				$subject = "予約がキャンセルされました";
				$data = [
					'user' => Auth::user(), 
					'receiver' => $user, 
					'booking' => $bookingDetail,										
					'site_url' => url('/'),
				];
				dispatch(new SendEmailJob($template, $data, $subject,'cancel_mail'));
			}

			if(!empty($bookingDetail['teacher']['email'])){
				$template = "emails.teacher-cancel-lesson";
				$subject = 'Appointment cancellation for '.$user->firstname.' '.$user->lastname;
				$data = [
					'user' => $teacher, 
					'receiver' => $bookingDetail['teacher'],
					'student' => $user, 
					'booking' => $bookingDetail,					
					'site_url' => url('/'),
				];
				dispatch(new SendEmailJob($template, $data, $subject,'cancel_mail'));
			}

			//Send mail(to share record emails)

			$shareRecords = StudentShareRecord::where('user_id', $user_id)
												->where('share_type', 'lessons')
												->pluck('email');

			if(!empty($shareRecords) && $shareRecords->toArray()){
				$shareTemplate = "emails.lession-cancel";
				$shareSubject = "Lesson cancelled for ".$user->firstname .' '. $user->lastname;
				$shdata = [
					'student' => $user,
					'teacher' => $teacher,
					'date' => $booking['lession_date'],
					'time' => $booking['lession_time'],
					'lesson' =>  $serviceDetail->title,
					'location' =>  $locationDetail->title,
					//'booking' => $booking
				];

				foreach ($shareRecords as $shareEmail) {
					Mail::send($shareTemplate, ['data' => $shdata], function ($m) use ($shareEmail, $shareSubject) {
						$m->from(env('MAIL_FROM_ADDRESS'), env('MAIL_FROM_NAME'));
						$m->to($shareEmail)->subject($shareSubject);
						$m->bcc(env('BCC_EMAIL'), env('BCC_EMAIL_NAME'));
					});
				}
			}
		}

		if(env('IS_LINE_ENABLED') == 1){
			
			/* Send Push to Student */
			if(!empty($user->line_token)){
				/*$messages = [];
				$messages['to'] = $user->line_token;
				$msg = "You have Cancelled Booking\n";
				$msg .= "Lesson : ". $serviceDetail->title ."\n";
				$msg .= "Location : ". $bookingDetail['location']['title'] ."\n";
				$msg .= "Teacher Name : ". $bookingDetail['teacher']['firstname'] .' '.$bookingDetail['teacher']['lastname'] ."\n";
				$msg .= "Booking Date : " . $booking['lession_date'] .' '.$booking['lession_time']."\n";
				$messages['messages'][] = AppHelper::getFormatTextMessage($msg);
				$encodeJson = json_encode($messages);
				AppHelper::sentMessage($encodeJson);*/
				AppHelper::sendLineNotification($user->line_token, $teacher->firstname .' '.$teacher->lastname, $serviceDetail->title, $locationDetail->title, $booking['lession_date'] .' '.$booking['lession_time'], 'student', 'cancellled');
			}

			/* Send Push to Teaacher */
			if(!empty($teacher->line_token)){
				/*$tmessages = [];
				$tmessages['to'] = $teacher->line_token;
				$tmsg = "Your booking is cancelled.\n";
				$tmsg .= "Lesson :". $serviceDetail->title ."\n";
				$tmsg .= "Location : ". $bookingDetail['location']['title'] ."\n";
				$tmsg .= "Student Name :". $bookingDetail['student']['firstname'] .' '.$bookingDetail['student']['lastname'] ."\n";
				$tmsg .= "Booking Date : " . $booking['lession_date'] .' '.$booking['lession_time']."\n";
				$tmessages['messages'][] = AppHelper::getFormatTextMessage($tmsg);
				$tencodeJson = json_encode($tmessages);
				AppHelper::sentMessage($tencodeJson);*/
				AppHelper::sendLineNotification($teacher->line_token, $user->firstname .' '.$user->lastname, $serviceDetail->title, $locationDetail->title, $booking['lession_date'] .' '.$booking['lession_time'], 'teacher', 'cancellled');
			}
			
			/* Send Push to own */
			AppHelper::sendLineNotification('Uaeb57c050913b806dbb0751ee1348130', $user->firstname .' '.$user->lastname, $serviceDetail->title, $locationDetail->title, $booking['lession_date'] .' '.$booking['lession_time'], 'teacher', 'cancellled');
		}


        $request->session()->flash('message', 'Booking Cancelled.');
        return response()->json([
            'type' => 'success',
            'msg' => 'Booking Cancelled.'
        ]);

        //$ref = $request->get('ref', 'management');
        //return view('students.dashboard.index', compact('ref'));
    }

    public function previousCourse(Request $request) {
        $user_id = Auth::id();
        $student_lessons = StudentLessons::where('user_id', $user_id)
                            ->where('status',1)
                            ->where(function($query){
                                $query->where('student_lessons.expire_date', '<=', date('Y-m-d'))
                                ->whereRaw('student_lessons.expire_date IS NOT NULL');
                            })->with('service')->get();
       /* echo "<pre>";
        print_r($student_lessons);
        echo "</pre>";
        die;*/

        $html = view('students.dashboard.index.previous-course')->render();
        return response()->json(['type' => 'success', 'html' => $html]);
    }

    public function getPreviousCourseData(Request $request) {
        $user_id = Auth::id();
        $student_lessons = StudentLessons::select(
                            'services.title as title',
                            'student_lessons.service_id as service_id',
                            'student_lessons.expire_date as expiry_date',
                            'student_lessons.id as id')
                            ->leftJoin('services', 'student_lessons.service_id', 'services.id')
                            ->where(function($query){
                                $query->where('student_lessons.expire_date', '<=', date('Y-m-d'))
                                ->whereRaw('student_lessons.expire_date IS NOT NULL');
                            })
                            ->where('user_id', $user_id)
							->orderBy('start_date', 'desc');

        return DataTables::of($student_lessons)
            ->editColumn('action', function ($student_lessons) {
                return '<a href="' . route('student.dashboard.get.previous.detail', $student_lessons['id']) . '">'. __('labels.view').'</a>';
            })		
            ->editColumn('reorder', function ($student_lessons) {
				if(strtotime($student_lessons->expiry_date.' 23:59:59') < time()) {
					return '<a href="' . url('student/add-cart/' . $student_lessons->service_id) . '">'. __('labels.reorder').'</a>';
				} else {
                    return '';
                }
            })
			->rawColumns(['action', 'reorder'])
            ->make(true);
			
        $html = view('students.dashboard.index.previous-course' ,compact('student_lessons'))->render();
        return response()->json(['type' => 'success', 'html' => $html]);
    }

    public function previousCourseDetail(Request $request, $id) {
        $user_id = Auth::id();
        $student_lessons = StudentLessons::where('id', $id)
                            /*->where(function($query){
                                $query->where('expire_date', '<', date('Y-m-d'))->orwhereRaw('expire_date IS NULL');
                            })*/->with('service')->first();
        $completed = null;

        if(!empty($student_lessons) && $student_lessons->toArray()){

            $student_lessons['bookings'] = StudentLessonsBooking::where('user_id', $user_id)
                                            ->where('service_id', $student_lessons['service_id'])
                                            ->with('teacher')
                                            ->with('location')
                                            ->with('service')
                                            ->get()->toArray();

          //  $service_ids = $student_lessons['service_id'];

            $completed = StudentLessonsBooking::where('user_id', $user_id)
                               ->where('service_id', $student_lessons['service_id'])
                               ->where('status', 'completed')
                               ->count();

        }

        $emails = StudentShareRecord::where(['user_id' => $user_id, 'share_type' => 'lessons'])->get();

        return view('students.dashboard.index.previous-course-detail', compact('student_lessons','completed','emails'));
    }

    public function getPreviousCourseDetail(Request $request) {

        $user_id = Auth::id();
        $id = $request->lesson_id;

        $student_lessons = StudentLessons::where('id', $id)
                            /*->where(function($query){
                                $query->where('expire_date', '<', date('Y-m-d'))->orwhereRaw('expire_date IS NULL');
                            })*/->with('service')->first();
        $completed = null;

        if(!empty($student_lessons) && $student_lessons->toArray()){

            $lessons = StudentLessonsBooking::select(
                            'services.title as service',
                            'location.title as location',
                            'student_lessons_bookings.lession_date as date',
                            'student_lessons_bookings.lession_time as time',
                            'student_lessons_bookings.lesson_duration as duration',
                            'student_lessons_bookings.status as status',
                            DB::raw("CONCAT(users.firstname, ' ', users.lastname) AS teacher"))
                        ->where('user_id', $user_id)
                        ->where('service_id', $student_lessons['service_id'])
                        ->where('student_lessons_bookings.student_lessons_id', $id)
                        ->leftJoin('services', 'student_lessons_bookings.service_id', 'services.id')
                        ->leftJoin('location', 'student_lessons_bookings.location_id', 'location.id')
                        ->leftJoin('users', 'student_lessons_bookings.teacher_id', 'users.id')
						->orderBy('lession_date', 'DESC');


            return DataTables::of($lessons)->addIndexColumn()->make(true);
        }

        return view('students.dashboard.index.previous-course-detail', compact('student_lessons','completed'));
    }

    public function getOrder(Request $request) {
        $html = view('students.dashboard.index.orders')->render();
        return response()->json(['type' => 'success', 'html' => $html]);
    }

    public function getOrderData(Request $request) {

        $user_id = Auth::id();

        $orders = StudentTransactions::where('user_id', $user_id)
							->orderBy('created_at', 'desc');
                            //->where('payment_status','succeeded');

        return DataTables::of($orders)
            ->addIndexColumn()
            ->editColumn('product', function ($orders) {
                if ($orders->transaction_type == 'service') {
                    $product = Services::select('title')->where('id', $orders->transaction_type_id)->value('title');
                } else if ($orders->transaction_type == 'multi_service') {
                    $serviceIds = explode(',', $orders->transaction_type_id);
                    $serviceArray = [];
                    foreach ($serviceIds as $service) {
                        $service = Services::where('id', $service)->first();
                        $serviceArray[] = $service->title;
                    }
                    $product = implode(',', $serviceArray);

                } else {
                    $product = Packages::select('title')->where('id', $orders->transaction_type_id)->value('title');
                }
                return $product;
            })
            ->editColumn('amount', function ($orders) {
                return '¥'. number_format($orders->amount,2);
            })
            ->editColumn('package_status', function ($orders) {
                return ($orders->payment_status == 'succeeded' ? __('labels.completed') : __('labels.pending'));
            })
            // ->editColumn('package_status', function ($orders) {
            //     return 'Completed';
            // })
            ->editColumn('created_at', function ($orders) {
				return AppHelper::format_date_FjY($orders->created_at);
                //return Carbon::parse($orders->created_at)->format('M d,Y');
            })
            ->editColumn('action', function ($orders) {
                return '<a href="' . url('student/order-detail/' . $orders->id) . '">'.__('labels.view').'</a>';
            })
            ->make(true);
    }

    public function payment(Request $request) {

        $token_id = $request->token_id;
        $package_id = $request->package_id;
        $user = Auth::user();
        $package = Packages::find($package_id);

        Stripe::setApiKey('sk_test_WKLoGh2EE8fRYsIoXOxhpkgN');


        if ($user->stripe_customer_id != '') {
            $customer = Customer::retrieve($user->stripe_customer_id);
        } else {
            $customer = Customer::create([
                'email' => $user->email,
                //'source' => $token_id,
                'source' => 'tok_visa',
            ]);
        }


        $charge = Charge::create([
            'customer' => $customer->id,
            'description' => $package->title,
            'amount' => floatval($package->price) * 100,
            'currency' => 'usd',
        ]);

        $studentPackage = [
            "user_id" => $user->id,
            "package_id" => $package_id,
            "start_date" => null,
            "end_date" => null,
            "price" => floatval($package->price),
            "status" => 'created'
        ];
        $studentTransaction = [
            "user_id" => $user->id,
            "provider" => 'stripe',
            "transaction_id" => $charge->balance_transaction,
            "stripe_customer_id" => $charge->customer,
            "amount" => floatval($package->price),
            "stripe_payment_method_id" => $charge->payment_method
        ];
        StudentPackages::create($studentPackage);
        StudentTransactions::create($studentTransaction);
        $user->update(['stripe_token' => $token_id, 'stripe_customer_id' => $customer->id]);

        return response()->json($charge);
    }

    public function orderDetail($id) {
        $order = StudentTransactions::with('user')->find($id);
        if ($order->transaction_type == 'service') {
            $product = Services::select('title')->whereIn('id', $order->transaction_type_id)->value('title');
        } else if ($order->transaction_type == 'multi_service') {
            $serviceIds = explode(',', $order->transaction_type_id);
            $serviceArray = [];
            foreach ($serviceIds as $service) {
                $service = Services::where('id', $service)->first();
                $serviceArray[] = $service->title . ' x ' . $service->available_lessons;
            }
            $product = implode(',', $serviceArray);

        } else {
            $product = Packages::select('title')->where('id', $order->transaction_type_id)->value('title');
        }

        return view('students.dashboard.order-detail', compact('order', 'product'));
    }
}
