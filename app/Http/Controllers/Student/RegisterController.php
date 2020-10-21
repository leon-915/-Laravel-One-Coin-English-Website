<?php

namespace App\Http\Controllers\Student;

use App\Helpers\AppHelper;
use App\Libraries\Ical\iCalEasyReader;
use App\Models\StudentPackages;
use App\Models\TeacherIcal;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\HolidaySettings;
use Illuminate\Support\Facades\Auth;
use App\User;
use Illuminate\Support\Facades\DB;
use App\Models\TeacherLocations;
use App\Models\TeacherSchedule;
use Asana\Client;
use App\Models\StudentDetail;
use Illuminate\Support\Facades\Redirect;
use LaravelCaptcha\BotDetectCaptcha;
use App\Models\StudentLessonsBooking;
use App\Models\Services;
use App\Models\TeacherScheduleException;
use App\Models\TeacherDetail;
use App\Models\StudentLessons;
use App\Models\ServiceLocations;
use App\Models\TeacherServices;
use App\Models\Locations;
use App\Models\Settings;
use App\Http\Requests\Student\Reservation\StoreRequest;
use App\Jobs\SendEmailJob;
use App\Helpers\ZohoHelper;
use App\Helpers\MailerliteHelper;
use DateInterval;
use DateTime;
use DatePeriod;
use Carbon\Carbon;
use Newsletter;
use App\Models\RatingTypes;
use App\Models\TeacherRatings;


use Stripe\Stripe;
use Stripe\Customer;
use App\Models\StudentTeachers;

class RegisterController extends Controller
{
    public function index() {
        if((Auth::user()) && (Auth::user()->user_type == 'student')){
            return redirect(route('students.reservation.index'));
        }
        return view('students.register.index');
    }

    public function store(Request $request) {
        $request->validate([
            'firstname' => 'required',
            'lastname' => 'required',
            //'contact_no' => 'required',
            'email' => 'required|unique:users',
            //'password' => 'required',
            //'confirm_password' => 'required|same:password',
            'captcha_code' => 'required|valid_captcha',
        ]);

        //-- Referral Code --//
        $refferal_code = $request->referral_code;
        if (!empty($refferal_code)) {
            $referred_by = User::select('id')
                ->where('referral_code', $refferal_code)
                ->value('id');
            if (empty($referred_by)) {
                return Redirect::back()->withErrors(['Invalid Referral Code']);
            } else {
                $referralUser = User::find($referred_by);

                if ($referralUser['user_type'] == 'student') {
                    $package = StudentPackages::where('user_id', $referralUser['id'])
                        ->whereRaw("start_date <= '" . date('Y-m-d') . "'::date")
                        ->whereRaw("end_date >= '" . date('Y-m-d') . "'::date")
                        ->where('status', 'active')
                        ->first();

                    if (!empty($package)) {
                        $referralDetail = StudentDetail::where('user_id', $referred_by)->first();
                        $creditBalance = $referralDetail->reward_balance;
                        $referralDetail->reward_balance = ceil($creditBalance + 500);
                        $referralDetail->save();
                    } else {
                        $services = StudentLessons::where('user_id', $referralUser['id'])
                                        ->where('status', 1)
                                        ->where(function($query){
                                            $query->where('expire_date', '>=', date('Y-m-d'))
                                                    ->orwhereRaw('expire_date IS NULL');
                                        })
                                        ->orderBy('id','DESC')
                                        ->first();
                        if(!empty($services)){
                            $free_lessons = $services->free_lessons;
                            $services->free_lessons = $free_lessons + 1;
                            $services->save();
                        }
                    }
                }
            }
        }
        //-- End Referral Code --//

		
		$firstname = !empty($request->firstname) ? $request->firstname : '';
		$lastname = !empty($request->lastname) ? $request->lastname : '';
		
		$firstname_ja = !empty($request->firstname_ja) ? $request->firstname_ja : '';
		$lastname_ja = !empty($request->lastname_ja) ? $request->lastname_ja : '';
		
		$student_name = $firstname . " " . $lastname;
		$email = !empty($request->email) ? $request->email : '';
		$phone = !empty($request->contact_no) ? $request->contact_no : '';
		$password1 = str_random(10);
		$password = bcrypt($password1);
		
        $user = array(
            'firstname' => $firstname,
            'lastname' => $lastname,
            'firstname_ja' => $firstname_ja,
            'lastname_ja' => $lastname_ja,
            'email' => $email,
            'password' => $password,
            'contact_no' => !empty($request->contact_no) ? $request->contact_no : '',
            'referral_code' => uniqid(),
            'user_type' => 'student',
            'status' => 1,
        );

        if($refferal_code){
            $user['referred_by'] = $referred_by;
        }

        $authUser = User::create($user);

        $studentDetail = StudentDetail::create(['user_id' => $authUser->id]);
		$student = User::find($authUser->id);
		$student->password = $password1;
		if(env('IS_EMAIL_ENABLED') == 1){
			$email_template = "emails.student-registration";
			$subject = "Welcome to ".env('APP_NAME');
			$data = ['user' => $student];

			dispatch(new SendEmailJob($email_template, $data, $subject, 'user'));
		}

		if(env('IS_ASANA_ENABLED') == 1) {
			try {
				$asanaToken = env('ASANA_TOKEN');
				$workspaceId = env('ASANA_WORKSPACE_ID');
				$client = Client::accessToken($asanaToken);
				$project = $client->projects->createInWorkspace(
					$workspaceId,
					array(
						'name' => $student_name
					)
				);

				
				$student->asana_project_id = !empty($project->gid) ? $project->gid : '';
				$student->save();

				$assignee = 'ryan.ahamer@accent-admin.com';
				$due_date = date('Y-m-d');
				$notes = "Email : ".$email.", Contact : ".$request->contact_no;
				if(!empty($firstname_ja) && !empty($lastname_ja)) {
					$notes .= ", Name In Ja: $firstname_ja $lastname_ja,";
				}
				
				// create task 1
				$task = $client->tasks->createInWorkspace(
					$workspaceId,
					array(
						'name'          => $firstname . " " . $lastname . ' New '.env('APP_NAME').' Registration.',
						'notes'         => $notes,
						"assignee" => $assignee, // Right now we autoassign the task to the owner of the API key.					
						"due_on" => $due_date
					)
				);

				$client->tasks->addProject(
					$task->gid,
					array(
						'project' => $project->gid
					)
				);

				$gcon = AppHelper::createGoogleContact($user);

				
						  
				
		
			} catch (\Throwable $th) {

			}
			
			//mailchimp list id = New Registration Accent Website
			//Newsletter::subscribe($email, ['FNAME'=>$firstname, 'LNAME'=>$lastname], 'subscribers');
		}
		
		$company_name = $firstname.' '.$lastname;
		if(env('IS_ZOHO_ENABLED') == 1) {
			
			if($firstname_ja != '' && $lastname_ja != '') {
				$student_name = $lastname_ja .' '.$firstname_ja;
				$firstname = $firstname_ja;
				$lastname = $lastname_ja;
			}
			$jsondata = '{"contact_name": '.$student_name.',"company_name": '.$company_name.', "contact_persons": [{"email":'.$email.',"first_name":'.$firstname.',"last_name":'.$lastname.', "phone":'.$phone.'}]}';
			$output = ZohoHelper::createInvoiceCustomer($jsondata);
			if($output['code'] == 0) {
				$zoho_user_id = $output['contact']['contact_id'];
				$student = User::find($authUser->id);
				$student->zoho_user_id = $zoho_user_id;
				$student->save();
				$contact_person_id = $output['contact']['contact_persons'][0]['contact_person_id'];
				$jsondata = '{"contact_persons": [{"contact_person_id": '.$contact_person_id.'}]}';
				$enable_output = ZohoHelper::enableportal($jsondata, $zoho_user_id);
			}
		}
		
		MailerliteHelper::createSubscriber_student($email, $company_name, $phone);

        Auth::guard()->login($authUser);
        return redirect(route('students.languagepartners.index'));
    }

	public function getLocations(Request $request) {
        $service_id = $request->get('service_id', 0);
        $teacher_id = $request->get('teacher_id', 0);
        $teachers = [];
        $locations = [];

        if ($service_id) {
            if (!$teacher_id) {
                $teachers = TeacherServices::select(
                    'users.id AS id',
                    DB::raw("CONCAT(users.firstname, ' ', users.lastname) AS teacher_name")
                )
                    ->join('users', 'users.id', '=', 'teacher_services.teacher_id')
                    ->join('teacher_detail', function ($join) {
                        $join->on('teacher_detail.user_id', '=', 'teacher_services.teacher_id')
                            ->where('teacher_detail.is_available_in_trial', 1)
                            ->where('teacher_detail.temporarily_unavailable', 0);
                    })
                    ->where('teacher_services.service_id', $service_id)
                    ->where('teacher_services.is_deleted', 0)
                    ->pluck('teacher_name', 'id');

                $locations = ServiceLocations::select(
                    'location.id AS id',
                    'location.title AS location_name'
                )
                    ->join('location', 'services_locations.location_id', '=', 'location.id')
                    ->where('services_locations.service_id', $service_id)
                    ->where('services_locations.is_deleted', 0)
                    ->pluck('location_name', 'id');
            } else {
                $locations = Locations::select(
                    'location.id AS id',
                    'location.title AS location_name'
                )
                    ->join('teacher_locations', function ($join) use ($teacher_id) {
                        $join->on('teacher_locations.location_id', '=', 'location.id')
                            ->where('teacher_locations.user_id', $teacher_id)
                            ->where('teacher_locations.is_deleted', 0);

                    })
                    ->join('services_locations', function ($sjoin) use ($service_id) {
                        $sjoin->on('services_locations.location_id', '=', 'location.id')
                            ->where('services_locations.service_id', $service_id)
                            ->where('services_locations.is_deleted', 0);
                    })
                    ->pluck('location_name', 'id');
            }
        }

        $service = StudentLessons::where('service_id', $request->service_id)
            ->where('user_id', Auth::id())->first();

        

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
        $upToMonth = Settings::getSettings('book_upto_month');
        $maxDate = date('Y-m-d', strtotime("+".$upToMonth." months"));
        if (!empty($service)) {
            if(time() < strtotime($service->start_date)){
                $minDate = date('Y-m-d', strtotime($service->start_date));
            }
            if($service->expire_date){
                $maxDateT = strtotime($maxDate);
                $expDateT = strtotime($service->expire_date);
                if($maxDateT < $expDateT){
                    $maxDate = date('Y-m-d', strtotime("+".$upToMonth." months"));
                } else {
                    $maxDate = date('Y-m-d', strtotime($service->expire_date));
                }
            }
        }
        return response()->json([
            'type' => 'success',
            'locations' => $locations,
            'teachers' => $teachers,
            'maxDate' => $maxDate,
            'holidays' => $dates,
            'minDate' => $minDate
        ]);
    }

    public function setDatePicker(Request $request) {
        $input = $request->all();
        $date = $request->date;
        $day = strtolower(date('l', strtotime($date)));
        $id = $request->teacher_id;
        if (!$id) {
            return '';
        }
        $service_id = $request->service_id;
        $exception_time_array = [];
        $exception_days = TeacherScheduleException::where(['user_id' => $id, $day => 1])
            ->where(function($q) use($date){
                $q->whereRaw("from_date <= '".date('Y-m-d',strtotime($date))."'::date");
                $q->orwhereRaw("from_date IS NULL");
            })
            ->where(function($q) use($date){
                $q->whereRaw("to_date >= '".date('Y-m-d',strtotime($date)) ."'::date");
                $q->orwhereRaw("to_date IS NULL");
            })
            ->get()->toArray();

        $setting = Settings::select('start_time', 'end_time','book_before_time')->first()->toArray();

        $endTime = $setting['end_time'];
        $startTime = $setting['start_time'];

        $service = Services::find($service_id);

        $teacher = TeacherDetail::where('user_id', $id)->first();

        $exception_time_array = [];
        foreach ($exception_days as $eday) {
            $exception_time_array[] = [
                'start' => date('H:i', strtotime($eday['from_time'])),
                'end' => date('H:i', strtotime($eday['to_time']))
            ];
        }

        $availble_days = TeacherSchedule::where(['user_id' => $id, $day => 1])->get()->toArray();
        $not_availble_days = TeacherSchedule::where(['user_id' => $id, $day => 0])->get()->toArray();

        $booked_days = StudentLessonsBooking::where('lession_date', $date)
            ->where(function ($q) use ($id) {
                $q->where('user_id', Auth::id())->orWhere('teacher_id', $id);
            })->where('status', 'booked')->get()->toArray();


        $booked_days_array = [];
        foreach ($booked_days as $bday) {
            $booked_days_array[] = [
                'start' => date('H:i', strtotime($bday['lession_time'])),
                'end' => date('H:i', strtotime('+'.$bday['lesson_duration'].' Minutes', strtotime($bday['lession_time'])))
            ];
        }

        $idData = $this->getIcalData($id, $date);

		
		//echo '<pre>';print_r($idData);
			
        $booked_days_array = array_merge($booked_days_array, $exception_time_array, $idData);

        $todayAvailableTime = [];
        foreach ($availble_days as $day) {
            $todayAvailableTime[] = $day['from_time'];
        }
	
        $todayNotAvailableTime = [];
        foreach ($not_availble_days as $day) {
            $todayNotAvailableTime[] = date('H', strtotime($day['from_time']));
        }

        sort($todayAvailableTime);
        sort($todayNotAvailableTime);

        $from_time = current($todayAvailableTime);
        if (end($todayAvailableTime) != '23:00:00') {
            $to_time = date('H:i:s', strtotime('+1 hour', strtotime(end($todayAvailableTime))));
        } else {
            $to_time = '23:59:59';
        }

        $padding = !empty($service->padding_minutes) ? $service->padding_minutes : 0;

        $seviceLength = env('OCE_SESSION_DURATION');
        if($service->length_type == 'hour'){
            $seviceLength = $service->length * 60;
        } else {
            $seviceLength = $service->length;
        }

        $fasd = !empty($service->flexible_appointment_start_time) ? $service->flexible_appointment_start_time : $seviceLength;

        if ($service->padding_type == 1) {
            $from_time_format = date('H:i', strtotime('+' . $padding . ' minutes', strtotime($from_time)));
            $to_time_format = date('H:i', strtotime('-' . $fasd . ' minutes', strtotime($to_time)));
        } elseif ($service->padding_type == 2) {
            $from_time_format = date('H:i', strtotime($from_time));
            $to_time_format = date('H:i', strtotime('-' . ($padding + $fasd) . ' minutes', strtotime($to_time)));
        } elseif ($service->padding_type == 3) {
            $from_time_format = date('H:i', strtotime('+' . $padding . ' minutes', strtotime($from_time)));
            $to_time_format = date('H:i', strtotime('-' . ($padding + $fasd) . ' minutes', strtotime($to_time)));
        }

        if ($service->padding_type == 1) {
            $fasd = $fasd + $padding;
        } elseif ($service->padding_type == 2) {
            $fasd = $fasd + $padding;
        } elseif ($service->padding_type == 3) {
            $fasd = $fasd + $padding + $padding;
        }


		//exit;
		
        $html = '';
        while (strtotime($from_time_format) < strtotime($to_time_format)) {
			//echo '<pre>';print_r($from_time_format);
            if ((!empty($endTime)) && (!empty($startTime))) {
                $bookingStTime = 0;
                if(!empty($teacher->book_before_time)){
                    $bookingStTime = $teacher->book_before_time;
                } else {
                    $bookingStTime = Settings::getSettings('book_before_time');
                }

                if(strtotime($date) == strtotime(date('Y-m-d'))){
                    $hour = date('H');

                    if(($hour + $bookingStTime) < 24){
                        $start_time_format = date('H:i', strtotime('+'.$bookingStTime.' Hours'));
                    } else {
                        break;
                    }
                } else {
                    $strtResDateTime = strtotime(date('Y-m-d H:i', strtotime('+'.$bookingStTime.' Hours')));
                    $strtResDate = strtotime(date('Y-m-d', strtotime('+'.$bookingStTime.' Hours')));

                    if($strtResDate <= strtotime($date)){
                        if($strtResDateTime >= strtotime($date.' '.date('H:i'))){
                            $start_time_format = date('H:i', strtotime('+'.$bookingStTime.' Hours'));
                        } else {
                            $start_time_format = date('H:i', strtotime($startTime));
                        }
                    } else {
                       break;
                    }
                }
                $end_time_format = date('H:i', strtotime($endTime));
                if ((strtotime($from_time_format) >= strtotime($start_time_format)) &&
                    (strtotime($from_time_format) < strtotime($end_time_format))) {
                    if (!empty($booked_days_array)) {
                        $isSlotAvailable = true;
						$dd = 0;
                        foreach($booked_days_array as $bookedSlot){
							//if( (strtotime($bookedSlot['start']) <= strtotime($from_time_format)) && ( strtotime($from_time_format) < strtotime($bookedSlot['end']))){
								
                            if( (strtotime($bookedSlot['start']) <= (strtotime($from_time_format) + ($seviceLength * 60))) && ( strtotime($from_time_format) < strtotime($bookedSlot['end']))){
                                $isSlotAvailable = false;
                                break;
                            }
							
							/*if(strtotime($from_time_format) > strtotime($bookedSlot['end'])){
								$from_time_format = $bookedSlot['end'];
								//exit;
								$isSlotAvailable = true;
								unset($booked_days_array[$dd]);
							}*/
							$dd++;
                        }

                        if($isSlotAvailable){
                            if (!in_array(date('H', strtotime($from_time_format)), $todayNotAvailableTime)) {
                                $html .= '<label class="checkcontainer"><input type="radio" name="time" value="' . date('H:i', strtotime($from_time_format)) . '">' . date('H:i', strtotime($from_time_format)) . '<span class="radiobtn"></span></label>';
                            }
                        }

                    } else {
						
                        if (!empty($todayNotAvailableTime)) {
                            if (!in_array(date('H', strtotime($from_time_format)), $todayNotAvailableTime)) {
                                $html .= '<label class="checkcontainer"><input type="radio" name="time" value="' . date('H:i', strtotime($from_time_format)) . '">' . date('H:i', strtotime($from_time_format)) . '<span class="radiobtn"></span></label>';
                            }
                        } else {
                            $html .= '<label class="checkcontainer"><input type="radio" name="time" value="' . date('H:i', strtotime($from_time_format)) . '">' . date('H:i', strtotime($from_time_format)) . '<span class="radiobtn"></span></label>';
                        }
                    }
                }
            }

            // if ($service->padding_type == 1) {
            //     $fasd = $fasd + $padding;
            // } elseif ($service->padding_type == 2) {
            //     $fasd = $fasd + $padding;
            // } elseif ($service->padding_type == 3) {
            //     $fasd = $fasd + $padding + $padding;
            // }

            $from_time_format = date('H:i', strtotime('+' . $fasd . ' minutes', strtotime($from_time_format)));
        }

        $start = '<label for="exampleInputEmail1" class="grey">'. trans("labels.time").'<span class="astric">*</span></label>';
        $noTime = 'No timeslot available on this date.';

        if (!empty($html)) {
            $html = $start . $html;
        } else {
            $html = $start . $noTime;
        }

        return $html;
    }

    private function getIcalData($id,$date){
        $getIcalData = TeacherIcal::where('teacher_id', $id)->get();
		
        $today = strtotime(date('Y-m-d', strtotime($date)));
        $booked_days_array = [];
        foreach ($getIcalData as $ical) {
            $url = $ical->ical_link;
            try {
                $getData = @file_get_contents($url);
                $ical = new iCalEasyReader();
                $lines = $ical->load($getData);
                $events = $lines['VEVENT'];

                foreach ($events as $event) {
					//echo '<pre>';print_r($event['DTSTART']['value']);exit;	
                   // $startDate = $event['DTSTART']['value'];
                    $startDate = $event['DTSTART'];
					
					
                    $startDate = date('Y-m-d\TH:i:s', strtotime($startDate));
                    //$endDate = $event['DTEND']['value'];
                    $endDate = $event['DTEND'];
                    $endDate = date('Y-m-d\TH:i:s', strtotime($endDate));
                    $startDateT = strtotime(date('Y-m-d', strtotime($startDate)));
                    $endDateT = strtotime(date('Y-m-d', strtotime($endDate)));

                    if($startDateT <= $today && $endDateT >= $today){
						if(strtotime($endDate) >= strtotime(date('Y-m-d 23:59:59', strtotime($date)))) {
							$end = '23:59';
						} else {
							$end = date('H:i', strtotime($endDate));
						}
                        $booked_days_array[] = [
                            'start' => date('H:i', strtotime($startDate)),
                            'end' => $end
                        ];
                    }
                }
            } catch (\Throwable $th) {
                //throw $th;
            }
        }
        return $booked_days_array;
    }
	
	function createCustomer(Request $request) {
		$user = Auth::user();
		$student_id = $user->id;
		Stripe::setApiKey(config('services.stripe.test_secret_key'));
		$payment_method = $request->get('payment_method');
		$email = $request->get('email');
		$name = $request->get('name');
		$teacher_id = $request->get('teacher_id');
		$time = $request->get('time');
		$customer = Customer::create([
		  'payment_method' => $payment_method,
		  'email' => $email,
		  'name' => $name,
		]);
		//echo '<pre>';print_r($customer->id);
		$user->stripe_customer_id = $customer->id;
		$user->save();		
		
		$clientIp = $request->getClientIp();
		// book oce appointment
		$appointment = $this->OceAppointment($student_id, $teacher_id, $clientIp, $time);
		if($appointment > 0) {
			
			$studentDetail = StudentDetail::where('user_id', $student_id)->first();
			$studentDetail->credit_balance = ceil($studentDetail->credit_balance + env('OCE_SESSION_PRICE'));
			$studentDetail->save();
			
			//add or update teacher in friend list
			$this->add_update_friend($student_id, $teacher_id);
			return response()->json(['type' => 'success', 'message' => 'Payment done. Appointment has been booked successfully.']);		
		} else {
			return response()->json(['type' => 'failure', 'message' => 'Your appointment could not be booked. Please try again.']);		
		}
	}
	
	function OceAppointment($student_id = '', $teacher_id = '', $clientIp = '', $time = '') {

		$student_lesson_id = AppHelper::createOrder($student_id, env('OCE_SERVICE_ID'));
		
		$time = date('H:i:s', strtotime('+ 10second'));
		$lession = array(
            'user_id'                   => auth()->id(),
            'teacher_id'                => $teacher_id,
            'service_id'                => env('OCE_SERVICE_ID'),
            'location_id'               => env('OCE_LOCATION_ID'),
            'lession_date'              => date('Y-m-d'),
            'lession_time'              => $time != '' ? $time : date('H:i:s'),
			'onepage_title'				=> date('ymd'),
            'location_detail'           => '',
            'lession_type'              => 'regular',
            'status'                    => 'booked',
            'additional_info_teacher'   => '',
            'lesson_duration'           => env('OCE_SESSION_DURATION'),
			'total_earnings'          	=> 500,
			'teacher_earnings'          => 350,
			'admin_earnings'          	=> 150,
            'booking_ip'                => $clientIp,
            'student_lessons_id'        => $student_lesson_id
        );
		
		$booking = StudentLessonsBooking::create($lession);
		if(env('IS_LINE_ENABLED') == 1){
			$user = Auth::user();
			$teacher = User::find($teacher_id);
			$teacherDetails = $teacher->details()->first();
			if(!empty($user->line_token)){
				AppHelper::sendLineNotification($user->line_token, $teacher->firstname .' '.$teacher->lastname, '10 Minute Session', 'Remote', date('Y-m-d') .' '.$time, 'student', 'new');
			}

			/* Send Push to Teaacher */
			if(!empty($teacher->line_token)){
				AppHelper::sendLineNotification('U0dc12b8c2f056d1c9822fd9756a7d869', $user->firstname .' '.$user->lastname, '10 Minute Session', 'Remote', date('Y-m-d') .' '.$time, 'teacher', 'new');
			}
			
			/* Send Push to own */
			AppHelper::sendLineNotification('Uaeb57c050913b806dbb0751ee1348130', $user->firstname .' '.$user->lastname, '10 Minute Session', 'Remote', date('Y-m-d') .' '.$time, 'teacher', 'new');
		}
		
		$ratingTypes = RatingTypes::all();
		if (!empty($ratingTypes) && $ratingTypes->toArray()) {
			foreach ($ratingTypes as $rating) {
				TeacherRatings::updateOrCreate([
					'student_id' => $student_id,
					'teacher_id' => $teacher_id,
					'rating_id' => $rating->id,
					'lesson_booking_id' => $booking->id
				]);
			}
		}
		
		return $booking->id;
	}
	
	function add_update_friend($student_id = '', $teacher_id = '') {
		StudentTeachers::where('student_id', $student_id)->update(['is_friend' => 0]);
		
		$data = array('is_friend' => 1);
		StudentTeachers::updateOrCreate(
			['student_id' => $student_id, 'teacher_id' => $teacher_id],
			$data
		);
	}
	
	function bookSession(Request $request) {
		$user = Auth::user();
		$student_id = $user->id;
		$teacher_id = $request->get('teacher_id');
		$time = $request->get('time');
		
		$clientIp = $request->getClientIp();
		// book oce appointment
		$appointment = $this->OceAppointment($student_id, $teacher_id, $clientIp, $time);
		if($appointment > 0) {
			
			/*$studentDetail = StudentDetail::where('user_id', $student_id)->first();
			$studentDetail->credit_balance = ceil($studentDetail->credit_balance - env('OCE_SESSION_PRICE'));
			$studentDetail->save();*/
			
			//add or update teacher in friend list
			//$this->add_update_friend($student_id, $teacher_id);
			$ratingTypes = RatingTypes::all();
			if (!empty($ratingTypes) && $ratingTypes->toArray()) {
				foreach ($ratingTypes as $rating) {
					TeacherRatings::updateOrCreate([
						'student_id' => $student_id,
						'teacher_id' => $teacher_id,
						'rating_id' => $rating->id,
						'lesson_booking_id' => $appointment,
					]);
				}
			}
			
			return response()->json(['type' => 'success', 'message' => 'Appointment has been booked successfully.']);		
		} else {
			return response()->json(['type' => 'failure', 'message' => 'Your appointment could not be booked. Please try again.']);		
		}
		
	}
}
