<?php

namespace App\Http\Controllers\Student;

use App\Helpers\AppHelper;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Student\Reservation\StoreRequest;
use Auth;
use App\User;
use App\Models\Packages;
use Illuminate\Support\Facades\DB;
use Stripe\Customer;
use Stripe\Stripe;
use Stripe\Charge;
use App\Models\StudentPackages;
use App\Models\StudentTransactions;
use App\Models\Services;
use App\Models\ServicePackages;
use App\Models\ServiceLocations;
use App\Models\TeacherServices;
use App\Models\ServiceCategories;
use App\Models\StudentLessonsBooking;
use App\Models\StudentDetail;
use App\Models\StudentLessons;
use App\Models\TeacherRatings;
use App\Models\Settings;
use App\Models\StudentShareRecord;
use Asana\Client;
use App\Jobs\SendEmailJob;
use Throwable;
use App\Models\HolidaySettings;
use App\Models\Locations;
use DateInterval;
use DateTime;
use DatePeriod;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;


class ReservationController extends Controller
{
    public function index(){
        $user = Auth::user();

        $user_id = Auth::user()->id;
		$student = User::where('id', $user_id)->first();
        $studentDetails = $student->details()->first();

        $individualServices = [];

        $package = StudentPackages::where('user_id', $user->id)
                                    //->whereRaw("start_date <= '".date('Y-m-d')."'::date")
                                    ->whereRaw("end_date >= '".date('Y-m-d')."'::date")
                                    ->where('status', 'active')
                                    ->with('package')
                                    ->first();


        $packages = StudentPackages::where('user_id', $user->id)
                                    ->whereRaw("start_date <= '".date('Y-m-d')."'::date")
                                    ->whereRaw("end_date >= '".date('Y-m-d')."'::date")
                                    ->where('status', 'active')
                                    ->with('package')
                                    ->get();

        $totalPointsPackages = 0;

        if($packages && $packages->toArray()){
            foreach ($packages as $pac) {
                $totalPointsPackages = $totalPointsPackages + $pac->package->reward_point;
            }
        }

        $holidays = HolidaySettings::find(1);

        if(!empty($holidays)){
            $holidays = $holidays->toArray();
        }

        $today = date('Y-m-d');
        $today=date('Y-m-d', strtotime($today));

        $dateBegin = null;
        $dateEnd   = null;

        $message_en = null;
        $message_ja = null;
        if((!empty($holidays['start_date'])) && ($holidays['end_date'])){
            $from = $holidays['start_date'];
            $to = $holidays['end_date'];

            $dateBegin = date('Y-m-d', strtotime($holidays['holiday_message_display_start_date']));
            $dateEnd = date('Y-m-d', strtotime($holidays['end_date']));

            $message_en = $holidays['message_en'];
            $message_ja = $holidays['message_ja'];
        }
        $services = [];
        if (!empty($package)) { // point sysem services
            $pservices = [];
            /*$pservices = StudentLessons::select('services.id', 'services.title')
                            ->leftjoin('services', 'services.id', 'student_lessons.service_id')
                            // ->where(function($query){
                            //     $query->whereRaw("student_lessons.expire_date >= '".date('Y-m-d')."'::date")
                            //         ->orwhereRaw('student_lessons.expire_date IS NULL');
                            // })
                            ->where('student_lessons.user_id', $user->id)
                            ->where('student_lessons.status',1)
                            ->where('student_lessons.student_package_id',$package->package_id)
                            ->pluck('title', 'id');*/
			$pservices = Services::select('services.id', 'services.title')
                            ->join('services_packages', 'services.id', 'services_packages.service_id')
                            ->join('student_packages', 'student_packages.package_id', 'services_packages.package_id')
                             ->where(function($query){
                                 $query->whereRaw("student_packages.end_date >= '".date('Y-m-d')."'::date");
                            //         ->orwhereRaw('student_lessons.expire_date IS NULL');
                             })
                            ->where('student_packages.user_id', $user->id)
                            ->where('student_packages.status','active')
                            ->pluck('title', 'id');				


            $services = StudentLessons::select('services.id', 'services.title')
                            ->join('services', 'services.id', 'student_lessons.service_id')
                            ->where('student_lessons.user_id', $user->id)
							->whereNotIn('student_lessons.service_id',[env('ONEPAGE_SERVICE_ID'), env('REGISTRATION_SERVICE_ID')])
                            ->where(function($query){
                                $query->where('student_lessons.expire_date', '>=', date('Y-m-d'))
                                        ->orwhereRaw('student_lessons.expire_date IS NULL');
                            })
                            ->where('student_lessons.status',1)
                            ->whereRaw('student_package_id IS NULL')
                            ->pluck('title', 'id');

            if (!empty($pservices)) {
                $pservices = $pservices->toArray();
            }

            if (!empty($services)) {
                $services = $services->toArray();
            }

            $services = array_unique($services+$pservices);
        } else { // regular courses
            $individualServices = StudentLessons::where('user_id', $user->id)
                ->where(function($query){
                    $query->where('expire_date', '>=', date('Y-m-d'))->orwhereRaw('expire_date IS NULL');
                })
                ->where('status',1)
                ->whereRaw('student_package_id IS NULL')
				->whereNotIn('student_lessons.service_id',[env('ONEPAGE_SERVICE_ID'), env('REGISTRATION_SERVICE_ID')])
                ->with('service')
                ->get();

            $services = StudentLessons::select('student_lessons.service_id', 'services.title')
                ->join('services', 'services.id', 'student_lessons.service_id')
                ->where('student_lessons.user_id', $user->id)
                ->where(function($query){
                    $query->where('student_lessons.expire_date', '>=', date('Y-m-d'))
                            ->orwhereRaw('student_lessons.expire_date IS NULL');
                })
                ->where('student_lessons.status',1)
                ->whereRaw('student_package_id IS NULL')
				->whereNotIn('student_lessons.service_id',[env('ONEPAGE_SERVICE_ID'), env('REGISTRATION_SERVICE_ID')])
                ->pluck('title', 'service_id');

            if ($services) {
                $services = $services->toArray();
            }
        }
		
		// check if any service require Onepage fee then show notification
		$display_onepage_expiry = false;
		$onepage_rdays = 0;
		if(!empty($services)){
			$service_ids = array_keys($services);
			$onepage_end_date = $user->onepage_end_date;
			
			if(!empty($onepage_end_date)){
				$diff = strtotime($onepage_end_date) - strtotime(date('Y-m-d'));
				$onepage_rdays = floor($diff / (60 * 60 * 24));
				$onepage_rdays = $onepage_rdays < 1 ? 0 : $onepage_rdays;
			}
			$all_services = Services::where('status', 1)->whereIn('id', $service_ids)->get();
			//echo '<pre>';print_r($all_services);exit;
			foreach($all_services as $all_service) {
				if($all_service->is_onepage_fee_required == 1 && $onepage_rdays < 30) {
					$display_onepage_expiry = true;
					break;
				}
			}
		}

        return view('students.reservation.index', compact('user', 'packages', 'services','student',
        'studentDetails','package','totalPointsPackages','today', 'dateBegin','dateEnd','message_en','message_ja','individualServices', 'display_onepage_expiry', 'onepage_rdays'));
    }

    public function store(StoreRequest $request) {
        $input = $request->all();
        $user    = Auth::user();
        $student = StudentDetail::where('user_id', $user->id)->first();

        $location = Locations::find($request->location);
        $teacher = User::find($request->teacher);
        $teacherDetails = $teacher->details()->first();
		$service_id = $request->service;

        $teacher_amt = 0;
        $admin_comm = 0;
        $availableLessons = 0;
        $freeLessons = 0;
		$kids_category_id = env('KIDS_CATEGORY_ID');
		$aspire_category_id = env('ASPIRE_CATEGORY_ID');

        $service = Services::find($service_id);
		$service_category = ServiceCategories::where('service_id',$service_id)->where('is_deleted',0)->pluck('category_id')->first();
        
		
		if(empty($service)){
            return response()->json(['type' => 'failure', 'message' => 'Lesson not Available']);
        }
		
        $package = StudentPackages::where('user_id', $user->id)
                                    /*->whereRaw("start_date <= '".date('Y-m-d')."'::date")
                                    ->whereRaw("end_date >= '".date('Y-m-d')."'::date")*/
                                    ->whereRaw("start_date <= '".$request->reserve_date."'::date")
                                    ->whereRaw("end_date >= '".$request->reserve_date."'::date")
									->where('status', 'active')
                                    ->with('package')
                                    ->first();

        //if(!$package){
            if($service->is_reg_fee_required == 1){
                if(Auth::user()->is_registerfee_paid == 0){
                    return response()->json(['type' => 'failure', 'message' => "Sorry,  You haven't paid registration fee."]);
                }
            }
        ///}		

        if($service->is_onepage_fee_required == 1){
            if(!empty(Auth::user()->onepage_start_date)){
                if(!empty(Auth::user()->onepage_end_date)){
                    if(time() > strtotime(Auth::user()->onepage_start_date) && time() > strtotime(Auth::user()->onepage_end_date)){
                        return response()->json(['type' => 'failure', 'message' => "Sorry, You haven't paid onepage fee or Onepage fee subscription is expired."]);
                    }
                } else {
                    return response()->json(['type' => 'failure', 'message' => "Sorry, You haven't paid onepage fee or Onepage fee subscription is expired."]);
                }
            } else {
                return response()->json(['type' => 'failure', 'message' => "Sorry, You haven't paid onepage fee or Onepage fee subscription is expired."]);
            }
        }

        if(Carbon::parse($request->reserve_date)->isToday()){

            $beforeTimeAdmin = Settings::getSettings('book_before_time');
            $less =  ($teacherDetails->book_before_time != 0) ? $teacherDetails->book_before_time :
                                    $beforeTimeAdmin;
            
            $date = new DateTime($request->reserve_date);
            $time = new DateTime($request->time);
            $date->setTime($time->format('H'), $time->format('i'), $time->format('s'));
            $combine = $date->format('Y-m-d H:i:s');

            $to = Carbon::createFromFormat('Y-m-d H:i:s',$combine);
            $from = Carbon::createFromFormat('Y-m-d H:i:s', Carbon::now());
            $diff_in_min = $to->diffInMinutes($from);

            $now = date('Y-m-d H:i:s');

            if (($diff_in_min <= ($less * 60)) || ($to < $now)) {
                return response()->json(['type' => 'failure', 'message' => 'You are late. Please select other time.']);
            }
        }

		$service_price = 0;
		if($teacherDetails->is_ambassador == 0) {
			if($teacherDetails->per_hour_salary > 0) {
				$per_hour_salary = $teacherDetails->per_hour_salary;	
				$service_price_per_minute = $per_hour_salary / 60;			
				$service_price = round($service->length * $service_price_per_minute);				
			} else {
				$service_cost = $service->price;	
				$available_lessons = $service->available_lessons;
				$available_lessons = $available_lessons == 0 ? 1: $available_lessons;
				$service_price = round($service_cost / $available_lessons);
				
			}				
			
		} else {
			$global_price = $teacherDetails->global_lesson_price;
			$total_amt = 0;
			
			if($service_category == $aspire_category_id) {
				$total_amt = $teacherDetails->aspire_lesson_price;
			} else if($service_category == $kids_category_id) {
				$total_amt = $teacherDetails->kids_lesson_price;
			} else {
				$total_amt = $global_price;
			}

			if(!$total_amt){
				$total_amt = $teacherDetails->global_lesson_price;
			}
			$service_price = $service->price;
			$service_price_per_minute = $total_amt / 60;			
			$service_price = round($service->length * $service_price_per_minute);
			
		}
		
		
        $isPackageService = false;

        $servicePackage = ServicePackages::where('service_id',$request->service)->where('is_deleted',0)->first();        

        if(!empty($servicePackage) && $servicePackage->toArray()){
            $isPackageService = true;
        }

        if($service->is_system_service == 1 && $isPackageService){ // point system service
			if(!$package){
				return response()->json(['type' => 'failure', 'message' => "Sorry,  Either you have not purchased or package has been expired."]);
			}
			
			$StudentTransactions = StudentTransactions::where('id',$package['transaction_id'])->first();
			if(!empty($StudentTransactions) && $StudentTransactions->payment_status != 'succeeded') {
				return response()->json(['type' => 'failure', 'message' => "Sorry,  Either you have not purchased the package or payment has not been made."]);
			}
			$student_lessons_id = $package->id;
            $reward = 0;
			
			if($service->price > 0) {
				$service_price = $service->price;	
			}

            if($service->receive_credit_on_booking_type == 2){
                $reward += ($service_price) * ($service->receive_credit_on_booking) / 100;
            } else {
				$service->receive_credit_on_booking = $service->receive_credit_on_booking ? $service->receive_credit_on_booking : 1;
				$reward += $service->receive_credit_on_booking;
			}
			
			if ((float) $service_price > ((float) $student->credit_balance + (float) $student->reward_balance)) {
				return response()->json(['type' => 'failure', 'message' => "You do not have sufficiant credit or reward balance"]);
			} else if ((float) $service_price <= ((float) $student->credit_balance)) {
				$student->credit_balance = ceil($student->credit_balance - $service_price);				
			} else if ((float) $service_price <= ((float) $student->reward_balance)) {
				$student->reward_balance = ceil($student->reward_balance - $service_price);
			} else if ((float) $service_price <= ((float) $student->credit_balance + (float) $student->reward_balance)) {
				$remaining_service_price = $service_price - $student->credit_balance;
				$student->credit_balance = 0;
				$student->reward_balance = $student->reward_balance - $remaining_service_price;				
			}
			if(ceil($student->reward_balance + $reward) < 3000) {
				$student->reward_balance = ceil($student->reward_balance + $reward);
			}
			// update subscription start and recurring date if it is first appointment of first subscription.
			// check if it is first subscription
			//update expiry date as per the new order start date.
			
        } else { // regular lesson
			$studentLession = StudentLessons::where('user_id', Auth::id())
                            ->where('service_id', $request->service)
							->whereRaw("start_date <= '".$request->reserve_date."'::date")
                            ->whereRaw("expire_date >= '".$request->reserve_date."'::date")
                            ->where('status',1)
                            ->where('available_bookings','>=', 1)
                            ->first();
			
			$StudentTransactions = StudentTransactions::where('id',$studentLession['transaction_id'])->first();
			if(!empty($StudentTransactions) && $StudentTransactions->payment_status != 'succeeded') {
				return response()->json(['type' => 'failure', 'message' => "Sorry,  Either you have not purchased the course or payment has not been made."]);
			}			

			if(empty($studentLession)){
				return response()->json(['type' => 'failure', 'message' => 'You have to buy this service.']);
			}
            if (!empty($studentLession) && !empty($studentLession->toArray())) {
                $studentLessions = $studentLession->toArray();
                
				$available_bookings = $studentLession->available_bookings;
				if($studentLessions['available_bookings'] >= 1) {
					if($studentLession->available_bookings == 1) {
						$studentLession->is_expired = 1;
					}
					$studentLession->available_bookings = $studentLession->available_bookings - 1;
				} else {
					return response()->json(['type' => 'failure', 'message' => 'No more lessons available.']);
				}
				
				//if it is first lesson then set order start date to first booked lesson date.
                if (empty($studentLession->start_date) || ($service->available_lessons == $available_bookings)) {
					if($studentLession->connected_order > 0 && $studentLession->connected_order_date_updated == 0) {
						$studentLession->start_date = $request->reserve_date;
						$days = !empty($service->no_of_days) ? $service->no_of_days : 30;					
						$extended_days = $studentLession->days_extend > 0 ? $studentLession->days_extend : 0;
						$days = $days + $extended_days;
						$new_expired_date = date('Y-m-d', strtotime($request->reserve_date. ' + '.$days.' days'));
						$studentLession->expire_date = $new_expired_date;
						$studentLession->connected_order_date_updated = 1;
						
						// update order date of connected order						
						$connected_order_id = $studentLession->connected_order;
						$connected_order = StudentLessons::where('id', $connected_order_id)->first();
						$connected_order->start_date = $request->reserve_date;
						$connected_order->expire_date = $new_expired_date;
						$connected_order->connected_order_date_updated = 1;
						$connected_order->save();	
						
					} else {
						if($studentLession->connected_order_date_updated == 0) {
							$studentLession->start_date = $request->reserve_date;
							$days = !empty($service->no_of_days) ? $service->no_of_days : 30;					
							$extended_days = $studentLession->days_extend > 0 ? $studentLession->days_extend : 0;
							$days = $days + $extended_days;
							$new_expired_date = date('Y-m-d', strtotime($request->reserve_date. ' + '.$days.' days'));
							$studentLession->expire_date = $new_expired_date;
						}
					}
                }
				$student_lessons_id = $studentLession->id;
				$studentLession->save();
				
            } else {
                return response()->json(['type' => 'failure', 'message' => 'No more lessons available.']);
                //return redirect(route('students.reservation.index'))->with('error', 'No more lessons available');
            }
        }

        if(!empty($servicePackage) && $servicePackage->toArray()){
            $studentPackage = StudentPackages::where('user_id', $student->user_id)
                                                ->where('package_id',$servicePackage->package_id)
                                                ->where('status', 'created')
                                                ->first();
            if (!empty($studentPackage)) {
                if ($studentPackage->start_date == null) {
                    $studentPackage->start_date =  date('Y-m-d', strtotime($request->reserve_date));
                    $studentPackage->end_date = date('Y-m-d', strtotime('+1 month', strtotime($studentPackage->start_date)));
                    $studentPackage->status = 'active';
                    $studentPackage->save();
                }
            }
        }

        $student->save();

        $sduration = 0;
        if($service->length_type == 'hour'){
            $sduration = $service->length * 60;
        } else {
            $sduration = $service->length;
        }

        $lession = array(
            'user_id'                   => auth()->id(),
            'teacher_id'                => $request->teacher,
            'service_id'                => $request->service,
            'location_id'               => $request->location,
            'lession_date'              => $request->reserve_date,
            'lession_time'              => $request->time,
			'onepage_title'				=> date('ymd', strtotime($request->reserve_date)),
            'location_detail'           => !empty($input['location_details']) ? $input['location_details'] : '',
            'lession_type'              => 'regular',
            'status'                    => 'booked',
            'additional_info_teacher'   => $request->additional_info,
            'lesson_duration'           => $sduration,
            //'student_skype_id'           => !empty($input['skype_id']) ? $input['skype_id'] : '' ,
            'booking_ip'                => $request->getClientIp(),
            'student_lessons_id'        => $student_lessons_id
        );


		$admin_commision = Settings::getSettings('admin_commision');
		$student_referred_admin_commision = Settings::getSettings('student_referred_admin_commision');

        if($request->teacher == $user->referred_by){
			$percent = 100 - $student_referred_admin_commision;
			
            /*$lession['teacher_earnings'] = round($service_price * ($percent / 100));
            $lession['admin_earnings'] = $service_price * 10 / 100;*/
        } else {
			$percent = 100 - $admin_commision;
            /*$lession['teacher_earnings'] = $service_price * 80 / 100;
            $lession['admin_earnings'] = $service_price * 20 / 100;*/
        }
		$teacher_earning = round($service_price * ($percent / 100));
		$lession['teacher_earnings'] = $teacher_earning;
        $lession['admin_earnings'] = $service_price - $teacher_earning;
			
        $lession['total_earnings'] = $service_price;

        $booking = StudentLessonsBooking::create($lession);

        $user->skype_name =  !empty($input['skype_id']) ? $input['skype_id'] : '' ;
        $user->save();

		if(env('IS_ASANA_ENABLED') == 1 && 1==2){
			if(!empty($user->asana_project_id)){
				$asanaToken = env('ASANA_TOKEN');
				$workspaceId = env('ASANA_WORKSPACE_ID');
				$client = Client::accessToken($asanaToken);
				$task = $client->tasks->createInWorkspace(
					$workspaceId,
					array(
						'name' => $user->firstname . " " . $user->lastname . "booked ". $service->title ." on " . $request->reserve_date . " at " . $request->time,
						'notes'    => "Lesson Type:".$service->title.",\n".
											"Teacher : ".$teacher->firstname. ' ' .$teacher->lastname.",\n".
											"Location : ".$location->title.' - '.$location->title_jp.",\n".
											"Booked For : ".$request->reserve_date. ':' . $request->time
					)
				);

				$client->tasks->addProject(
					$task->gid,
					array(
						'project' => !empty($user->asana_project_id) ? $user->asana_project_id : ''
					)
				);
			}
		}
		
        //Send mail(to share record emails)
        if(env('IS_EMAIL_ENABLED') == 1){
			$shareRecords = StudentShareRecord::where('user_id', $user->id)
												->where('share_type', 'lessons')
												->pluck('email');

			if(!empty($shareRecords) && $shareRecords->toArray()){
				$shareTemplate = "emails.lessionBooking";
				$shareSubject = "Lesson successfully booked for ".$user->firstname .' '. $user->lastname;
				$shdata = [
					'student' => $user,
					'teacher' => $teacher,
					'date' => $request->reserve_date,
					'time' => $request->time,
					'lesson' =>  $service->title,
					'location' => $location->title
				];

				foreach ($shareRecords as $shareEmail) {
					Mail::send($shareTemplate, ['data' => $shdata], function ($m) use ($shareEmail, $shareSubject) {
						$m->from(env('MAIL_FROM_ADDRESS'), env('MAIL_FROM_NAME'));
						$m->to($shareEmail)->subject($shareSubject);
						$m->bcc(env('BCC_EMAIL'), env('BCC_EMAIL_NAME'));
					});
				}
			}

			// Send mail to teacher and student
			$template = "emails.lessionBooking";
			$subject = "New Appointment from ".$user['firstname'].' '.$user['lastname'];

			$tdata = [
				'user' => $teacher,
				'student' => $user,
				'teacher' => $teacher,
				'date' => $request->reserve_date,
				'time' => $request->time,
				'lesson' => $service->title,
				'location' => $location->title,
				'site_url' => url('/'),
				'title' => 'New Appointment',
			];
			dispatch(new SendEmailJob($template, $tdata, $subject, 'user'));

			$stemplate = "emails.student-lessionBooking";
			$subject = "New Appointment from ".$user['firstname'].' '.$user['lastname'];
			$subject = date('m', strtotime($request->reserve_date)) . '月' . date('d', strtotime($request->reserve_date)) . ', '.date('Y', strtotime($request->reserve_date)). $request->time .' ご予約をおとりいたしました';
			$sdata = [
				'user' => Auth::user(),
				'student' => $user,
				'teacher' => $teacher,
				'date' => $request->reserve_date,
				'time' => $request->time,
				'lesson' => $service->title,
				'location' => $location->title,
				'booking_id' => $booking->id,
				'site_url' => url('/'),
				'title' => 'Appointment Confirmation',
			];
			dispatch(new SendEmailJob($stemplate, $sdata, $subject, 'user'));
		}

        /* Send Push to Student */
		if(env('IS_LINE_ENABLED') == 1){
			if(!empty($user->line_token)){
				AppHelper::sendLineNotification($user->line_token, $teacher->firstname .' '.$teacher->lastname, $service->title, $location->title, $request->reserve_date .' '.$request->time, 'student', 'new');
			}

			/* Send Push to Teaacher */
			if(!empty($teacher->line_token)){
				AppHelper::sendLineNotification($teacher->line_token, $user->firstname .' '.$user->lastname, $service->title, $location->title, $request->reserve_date .' '.$request->time, 'teacher', 'new');
			}
			
			/* Send Push to own */
			AppHelper::sendLineNotification('Uaeb57c050913b806dbb0751ee1348130', $user->firstname .' '.$user->lastname, $service->title, $location->title, $request->reserve_date .' '.$request->time, 'teacher', 'new');
		}

		//return redirect(route('students.reservation.index'))->with('message', 'Lesson booked successfully.');
        return response()->json(['type' => 'success', 'message' => 'Lesson booked successfully']);
    }

    public function payment(Request $request){
        $token_id = $request->token_id;
        $package_id = $request->package_id;
        $user = Auth::user();
        $package = Packages::find($package_id);

        Stripe::setApiKey('sk_test_WKLoGh2EE8fRYsIoXOxhpkgN');

        if ($user->stripe_customer_id != '') {
            $customer = Customer::retrieve($user->stripe_customer_id);
        } else {
            $customer =  Customer::create([
                'email' => $user->email,
                // 'source' => $token_id,
                'source' => 'tok_visa',
            ]);
        }

        $charge = Charge::create([
            'customer' => $customer->id,
            'description' => $package->title,
            'amount' => floatval($package->price) * 100,
            'currency' => 'jpy',
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

    public function changeService(Request $request) {
        $service_id = $request->service_id;

        $locations = ServiceLocations::select(
                    'location.id AS id',
                    'location.title AS location_name'
                )
                ->join('location', 'services_locations.location_id', '=', 'location.id')
                ->where('services_locations.service_id', $service_id)
                ->where('services_locations.is_deleted', 0)
                ->pluck('location_name', 'id');

        $teachers = TeacherServices::select(
                        'users.id AS id',
                        DB::raw("CONCAT(users.firstname, ' ', users.lastname) AS teacher_name")
                    )
                    ->join('users', 'users.id', '=', 'teacher_services.teacher_id')
                    ->join('teacher_detail', function ($join) {
                        $join->on('teacher_detail.user_id', '=', 'teacher_services.teacher_id')
                            ->where('teacher_detail.is_available_in_trial', 1);
                        })
                    ->where('teacher_services.service_id', $service_id)
                    ->where('teacher_services.is_deleted', 0)
                    ->pluck('teacher_name', 'id');

        $service = StudentLessons::where('service_id', $request->service_id)->where('user_id', Auth::id())->where('status',1)->orderBy('id','DESC')->first();

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
        return response()->json(['locations' => $locations, 'teachers' => $teachers, 'maxDate' => $maxDate,
                                'holidays' => $dates,'minDate' => $minDate]);
    }

    public function changeLocation(Request $request) {
        $service_id = $request->service_id;
        $location_id = $request->location_id;

        $location = Locations::find($location_id);
        $locationType = '';
        if(!empty($location)){
            $locationType = $location->location_type;
        }

        $teachers = User::select(
                        'users.id AS id',
                        DB::raw("CONCAT(users.firstname, ' ', users.lastname) AS teacher_name")
                    )
                    ->join('teacher_detail', function ($join) {
                        $join->on('teacher_detail.user_id', '=', 'users.id')
                            //->where('teacher_detail.is_available_in_trial', 1)
                            ->where('teacher_detail.temporarily_unavailable', 0);
                    })
                    ->join('teacher_locations', function ($join) use ($location_id) {
                        $join->on('teacher_locations.user_id', '=', 'users.id')
                            ->where('teacher_locations.location_id', $location_id)
                            ->where('teacher_locations.is_deleted', 0);

                    })
                    ->join('teacher_services', function ($join) use ($service_id) {
                        $join->on('teacher_services.teacher_id', '=', 'users.id')
                            ->where('teacher_services.service_id', $service_id)
                            ->where('teacher_services.is_deleted', 0);
                    })
                    ->where('user_type','teacher')
                    ->where('status', 1)
                    ->pluck('teacher_name', 'id');

        return response()->json(['teachers' => $teachers, 'locationType' => $locationType]);
    }

    public function teacherProfile(Request $request) {
        $user_id = Auth::user()->id;
        $teacher_id = $request->get('teacher_id');
        if(!empty($teacher_id)){
            $teacher = User::where('id', $teacher_id)->first();
            $teacherDetails = $teacher->details()->first();
            $teacherLessonTime = StudentLessonsBooking::select(
                                        DB::raw("sum(lesson_duration) as total_time"))
                                        ->where([
                                            'teacher_id'=> $teacher_id,
                                            'status' => 'completed'
                                        ])
                                        ->pluck('total_time');

            $teacherTime = !empty($teacherLessonTime[0]) ? ($teacherLessonTime[0] / 60) : 0 ;
            $teacherHours = number_format($teacherTime,2);
            $ratings = TeacherRatings::select(DB::raw('avg(ratings)'))
                                    ->where('teacher_id', $teacher_id)
                                    ->where('status', 1)
                                    ->value('avg');

            $countStudentsRated = 0;

            $countStudentsRated =TeacherRatings::distinct('student_id')
                                 ->where('teacher_id', $teacher_id)
                                 ->where('status', 1)
                                 ->count('student_id');

            $html = view('students.reservation.index.teacher_profile',compact('teacher','teacherDetails','ratings','teacherHours','countStudentsRated'))->render();

            return response()->json(['type' => 'success', 'html' => $html]);
        } else {
            return response()->json(['type' => 'success', 'html' => '']);
        }
    }
}
