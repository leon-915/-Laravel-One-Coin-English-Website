<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\AppHelper;
use App\Http\Requests\Admin\Bookings\AddRequest;
use App\Http\Requests\Admin\Bookings\EditRequest;
use App\Models\ServiceLocations;
use App\Models\Services;
use App\Models\StudentLessons;
use App\Models\StudentLessonsBooking;
use App\Models\Locations;
use App\Models\TeacherSchedule;
use App\Models\TeacherServices;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Jobs\SendEmailJob;
use App\Libraries\Ical\iCalEasyReader;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;
use App\Models\StudentDetail;
use App\Models\ServicePackages;
use App\Models\ServiceCategories;
use App\Models\StudentShareRecord;
use Illuminate\Support\Facades\Mail;
use App\Models\StudentPackages;
use App\Models\HolidaySettings;
use App\Models\TeacherScheduleException;
use App\Models\Settings;
use App\Models\TeacherDetail;
use App\Models\StudentTransactions;
use App\Models\TeacherIcal;
use DateInterval;
use DateTime;
use DatePeriod;
use Carbon\Carbon;

class BookingsController extends Controller
{
    public function index()
    {
        return view('admin.bookings.index');
    }

    public function getBooking(Request $request) {
        $booking = DB::table('student_lessons_bookings')
            ->leftJoin('services', 'student_lessons_bookings.service_id', 'services.id')
            ->leftJoin('location', 'student_lessons_bookings.location_id', 'location.id')
            ->Join('users', 'student_lessons_bookings.user_id', 'users.id')
            ->Join('users as teacher', 'student_lessons_bookings.teacher_id', 'teacher.id')
            ->select('student_lessons_bookings.*', DB::raw("CONCAT(users.firstname, ' ', users.lastname) AS username"), 'location.title as location', 'services.title as services', DB::raw("CONCAT(teacher.firstname, ' ', teacher.lastname) AS teachername"));

        return DataTables::of($booking)
            ->filter(function ($query) use ($request) {
                if (!empty($request->get('from')) && !empty($request->get('to'))) {
                    $from = date('Y-m-d', strtotime($request->get('from')));
                    $to = date('Y-m-d', strtotime($request->get('to')));

                    $query->whereRaw("date(student_lessons_bookings.lession_date) between '" . $from . "' and'" . $to . "'");
                }else if(!empty($request->get('from'))){
                    $from = date('Y-m-d', strtotime($request->get('from')));
                    $query->where( 'student_lessons_bookings.lession_date','>=', $from)->get();
                }else if(!empty($request->get('to'))){
                    $to = date('Y-m-d', strtotime($request->get('to')));
                    $query->where( 'student_lessons_bookings.lession_date','<=', $to)->get();
                }
				
				if(!empty($request->get('user_name'))){
                    $user_name = $request->get('user_name');
                    $query->whereRaw("LOWER(users.firstname) like '%" . strtolower($request->get('user_name')) . "%'");
                }
            })
            ->addIndexColumn()
            ->addColumn('action', function ($booking) {

                // Hide Action Buttons
                if ($booking->status == 'cancel') {
                    $editButton = '';
                    return $editButton;
                }
                if ($booking->status == 'expired') {
                    $editButton = '';
                    return $editButton;
                }

                $editButton = '';
                $editButton .= '<a href="' . route('admin.bookings.edit', $booking->id) . '" class="btn btn-outline-info btn-rounded btn-icon edit-row" title="Edit"
                    data-toggle="tooltip" title="Edit" data-original-title="Edit"><i class="mdi mdi-pencil-box" aria-hidden="true"></i></a>';
                /*$editButton .= '<a id="' . $booking->id . '" class="btn btn-outline-danger btn-rounded btn-icon remove-row deleteBooking" data-toggle="tooltip" title="cancel" data-original-title="Delete"><i class="mdi mdi-close-box" aria-hidden="true"></i></a>';*/
                return $editButton;

            })
            ->editColumn('status', function ($booking) {
                if ($booking->status == 'booked') {
                    return '<span class="badge badge-gradient-success badge-pill">Booked</span>';
                } elseif ($booking->status == 'completed') {
                    return '<span class="badge badge-gradient-primary badge-pill">Completed</span>';
                } elseif ($booking->status == 'csd') {
                    return '<span class="badge badge-gradient-primary badge-pill">CSD</span>';
                } elseif ($booking->status == 'teacher_not_show') {
                    return '<span class="badge badge-gradient-primary badge-pill">Tnoshow</span>';
                } elseif ($booking->status == 'student_not_show') {
                    return '<span class="badge badge-gradient-primary badge-pill">Snoshow</span>';
                } elseif ($booking->status == 'cancel') {
                    $temp = 'Cancelled';
                    /*if((!empty($booking->lession_date)) && (!empty($booking->cancelled_at))){
                        $lesson_at = date('Y-m-d',strtotime($booking->lession_date));
                        $cancel_at = date('Y-m-d',strtotime($booking->cancelled_at));

                        if($lesson_at == $cancel_at){
                            $temp = 'CSD';
                        }
                    }
                    if(($booking->is_student_present == 1)){
                        $temp = 'Snoshow';
                    }else if(($booking->is_teacher_present == 1)){
                        $temp = 'Tnoshow';
                    }*/
                    return '<span class="badge badge-gradient-danger badge-pill">'.$temp.'</span>';
                } elseif($booking->status == 'expired'){
                    return '<span class="badge badge-gradient-secondary badge-pill">Expired</span>';
                } elseif($booking->status == 'deleted'){
                    return '<span class="badge badge-gradient-danger badge-pill">Deleted</span>';
                }
            })
            ->editColumn('lesson_duration', function ($booking) {
                return ($booking->lesson_duration) ? $booking->lesson_duration . '  Minute' : '';
            })
            ->editColumn('service_id', function ($booking) {
                return (!empty($booking->service_id)) ? $booking->services : '';
            })
            ->editColumn('teacher_id', function ($booking) {
                return (!empty($booking->teacher_id)) ? $booking->teachername : '';
            })
            ->editColumn('location_id', function ($booking) {
                return (!empty($booking->location_id)) ? $booking->location : '';
            })
            ->editColumn('user_id', function ($booking) {
                return (!empty($booking->user_id)) ? $booking->username : '';
            })

            ->editColumn('additional_info_teacher', function ($booking) {
                return (!empty($booking->additional_info_teacher)) ? $booking->additional_info_teacher : '--';
            })
            ->editColumn('location_detail', function ($booking) {
                return (!empty($booking->location_detail)) ? $booking->location_detail : '--';
            })
            ->editColumn('student_skype_id', function ($booking) {
                return (!empty($booking->student_skype_id)) ? $booking->student_skype_id : '--';
            })
            ->editColumn('lession_type', function ($booking) {
                if (!empty($booking->lession_type)){
                return '<span class="badge badge-gradient-info badge-pill">'.ucfirst($booking->lession_type).'</span>';
                }
                return '--';
             })

            ->rawColumns(['action', 'status','lession_type'])
            ->make(true);
    }

    public function create() {
        $services = Services::pluck('title', 'id')->toArray();

        return view('admin.bookings.create', compact('services'));
    }

    public function store(AddRequest $request){
		$kids_category_id = env('KIDS_CATEGORY_ID');
		$aspire_category_id = env('ASPIRE_CATEGORY_ID');
		
        $input = $request->all();
		$service_id = $input['service_id'];
		$location_id = $input['location_id'];
		
        $service = Services::find($input['service_id']);
        $location = Locations::find($input['location_id']);
        $service_category = ServiceCategories::where('service_id',$service_id)->where('is_deleted',0)->pluck('category_id')->first();
        
        $student        = User::where('id', $input['user_id'])->first();
        $studentDetails = $student->details()->first();
        $teacher        = User::where('id', $input['teacher_id'])->first();
        $teacherDetails = $teacher->details()->first();

        $teacher_amt = 0;
        $admin_comm = 0;
        $availableLessons = 0;
        $freeLessons = 0;
		
		$lesson_date = $input['lession_date'];
		$lession_time = $input['time'];
		
		if(empty($service)){
            return response()->json(['type' => 'failure', 'message'=>'Lesson not Available']);
        }
		
        $package = StudentPackages::where('user_id', $input['user_id'])
                                    ->whereRaw("start_date <= '".$lesson_date."'::date")
                                    ->whereRaw("end_date >= '".$lesson_date."'::date")
                                    ->where('status', 'active')
                                    ->with('package')
                                    ->first();

		// don't check these fee for now from admin
       
		if($service->is_reg_fee_required == 1 && $student->is_registerfee_paid == 0){
			return response()->json(['type' => 'failure', 'message' => "Sorry,  Student hasn't paid registration fee."]);
		}
				

		if($service->is_onepage_fee_required == 1){
			if(!empty($student->onepage_start_date)){
				if(!empty($student->onepage_end_date)){
					//if(strtotime($student->onepage_start_date) > time() && time() > strtotime($student->onepage_end_date)){
					 if(time() > strtotime($student->onepage_start_date) && time() > strtotime($student->onepage_end_date)){	
						return response()->json(['type' => 'failure', 'message' => "Sorry, Student hasn't paid onepage fee or Onepage fee subscription is expired."]);
					}
				} else {
					return response()->json(['type' => 'failure', 'message' => "Sorry, Student hasn't paid onepage fee or Onepage fee subscription is expired."]);
				}
			} else {
				return response()->json(['type' => 'failure', 'message' => "Sorry, Student hasn't paid onepage fee or Onepage fee subscription is expired."]);
			}
		}

        
		/*$global_price = $teacherDetails->global_lesson_price;
        //$total_amt = $teacherDetails->global_lesson_price;
        $total_amt = 0;
        if(strtolower($location->location_type) == 'skype'){
            $total_amt =  round((($global_price * $teacherDetails->virtual_lesson_percentage) / 100),2);
            //$teacher_amt = $global_price - $admin_comm;
        } elseif(strtolower($location->location_type) == 'station' || strtolower($location->location_type) == 'cafe'){
            $total_amt =  round((($global_price * $teacherDetails->cafe_lesson_percentage) / 100),2);
            //$teacher_amt = $global_price - $admin_comm;
        } elseif(strtolower($location->location_type) == 'classroom'){
            $total_amt =  round((($global_price * $teacherDetails->classroom_lesson_percentage) / 100),2);
            //$teacher_amt = $global_price - $admin_comm;
        }

        if(!$total_amt){
            $total_amt = $teacherDetails->global_lesson_price;
        }*/
		
		$service_price = 0;
		if($teacherDetails->is_ambassador == 0) {
			if($teacherDetails->per_hour_salary > 0) {
				$per_hour_salary = $teacherDetails->per_hour_salary;	
				$service_price_per_minute = $per_hour_salary / 60;			
				$service_price = round($service->length * $service_price_per_minute);				
			} else {
				$service_cost = $service->price;		
				$available_lessons = $service->available_lessons;
				$service_price = round($service_cost / $available_lessons);
			}
		} else {
			$global_price = $teacherDetails->global_lesson_price;
			$total_amt = 0;
			/*if(strtolower($location->location_type) == 'skype'){
				$total_amt =  round((($global_price * $teacherDetails->virtual_lesson_percentage) / 100),2);
			} elseif(strtolower($location->location_type) == 'station' || strtolower($location->location_type) == 'cafe'){
				$total_amt =  round((($global_price * $teacherDetails->cafe_lesson_percentage) / 100),2);
			} elseif(strtolower($location->location_type) == 'classroom'){
				$total_amt =  round((($global_price * $teacherDetails->classroom_lesson_percentage) / 100),2);
			}*/
			
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
        $servicePackage = ServicePackages::where('service_id',$input['service_id'])->where('is_deleted',0)->first();
		
		if(!empty($servicePackage) && $servicePackage->toArray()){
            $isPackageService = true;
        }
		
        /*$student_lesson = StudentLessons::where('user_id',$input['user_id'])
                                        ->where('service_id',$input['service_id'])
                                        ->where('status',1)
                                        ->first();
        if(empty($student_lesson)){
            //return redirect(route('admin.bookings.index'))->with('error', 'You have to buy this service.');
            return response()->json(['type' => 'failure', 'message' => 'You have to buy this service.']);
        }*/

        

        if($service->is_system_service == 1 && $isPackageService){ // point system service	

            if(!$package){
				return response()->json(['type' => 'failure', 'message' => "Sorry,  Either you have not purchased or course has been expired."]);
			}
			
			$StudentTransactions = StudentTransactions::where('id',$package['transaction_id'])->first();
			if(!empty($StudentTransactions) && $StudentTransactions->payment_status != 'succeeded') {
				return response()->json(['type' => 'failure', 'message' => "Sorry,  Either you have not purchased the package or payment has not been made."]);
			}
			
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

			if ((float) $service_price > ((float) $studentDetails->credit_balance + (float) $studentDetails->reward_balance)) {
				return response()->json(['type' => 'failure', 'message' => "You do not have sufficiant credit or reward balance."]);
			} else if ((float) $service_price <= ((float) $studentDetails->credit_balance)) {
				$studentDetails->credit_balance = ceil($studentDetails->credit_balance - $service_price);				
			} else if ((float) $service_price <= ((float) $studentDetails->reward_balance)) {
				$studentDetails->reward_balance = ceil($studentDetails->reward_balance - $service_price);
			} else if ((float) $service_price <= ((float) $studentDetails->credit_balance + (float) $studentDetails->reward_balance)) {
				$remaining_service_price = $service_price - $studentDetails->credit_balance;
				$studentDetails->credit_balance = 0;
				$studentDetails->reward_balance = $studentDetails->reward_balance - $remaining_service_price;				
			}
			$studentDetails->reward_balance = ceil($studentDetails->reward_balance + $reward);
			$student_lessons_id = $package->id;
        } else { // regular lesson
			$studentLession = StudentLessons::where('user_id', $input['user_id'])
                            ->where('service_id', $service_id)
							->whereRaw("start_date <= '".$lesson_date."'::date")
                            ->whereRaw("expire_date >= '".$lesson_date."'::date")
                            ->where('status',1)
                            ->where('available_bookings','>=', 1)
                            ->first();
							
			$StudentTransactions = StudentTransactions::where('id',$studentLession['transaction_id'])->first();
			if(!empty($StudentTransactions) && $StudentTransactions->payment_status != 'succeeded') {
				return response()->json(['type' => 'failure', 'message' => "Sorry,  Either you have not purchased the course or payment has not been made."]);
			}				


            if (!empty($studentLession) && !empty($studentLession->toArray())) {
                $studentLessions = $studentLession->toArray();

				$available_bookings = $studentLession->available_bookings;
				if($studentLessions['available_bookings'] >= 1) {
					$studentLession->available_bookings = $studentLession->available_bookings - 1;
				} else {
					return response()->json(['type' => 'failure', 'message' => 'No more lessons available.']);
				}
				
				if (empty($studentLession->start_date) || ($service->available_lessons == $available_bookings)) {
					
					if($studentLession->connected_order > 0 && $studentLession->connected_order_date_updated == 0) {
						$studentLession->start_date = $input['lession_date'];
						$days = !empty($service->no_of_days) ? $service->no_of_days : 30;					
						$extended_days = $studentLession->days_extend > 0 ? $studentLession->days_extend : 0;
						$days = $days + $extended_days;
						$new_expired_date = date('Y-m-d', strtotime($input['lession_date']. ' + '.$days.' days'));
						$studentLession->expire_date = $new_expired_date;
						$studentLession->connected_order_date_updated = 1;
						
						// update order date of connected order						
						$connected_order_id = $studentLession->connected_order;
						$connected_order = StudentLessons::where('id', $connected_order_id)->first();
						$connected_order->start_date = $input['lession_date'];
						$connected_order->expire_date = $new_expired_date;
						$connected_order->connected_order_date_updated = 1;
						$connected_order->save();	
						
					} else {
						if($studentLession->connected_order_date_updated == 0) {
							$studentLession->start_date = $input['lession_date'];
							$days = !empty($service->no_of_days) ? $service->no_of_days : 30;					
							$extended_days = $studentLession->days_extend > 0 ? $studentLession->days_extend : 0;
							$days = $days + $extended_days;
							$new_expired_date = date('Y-m-d', strtotime($input['lession_date']. ' + '.$days.' days'));
							$studentLession->expire_date = $new_expired_date;
						}
					}
					
                }
				//echo '<pre>';print_r($studentLession);
				//exit;
				$student_lessons_id = $studentLession->id;
				$studentLession->save();
                
            } else {
                return response()->json(['type' => 'failure', 'message' => 'Sorry,  Either course has not been purchased or course has been expired or no more lessons available.']);
            }
        }

        if(!empty($servicePackage) && $servicePackage->toArray()){
            $studentPackage = StudentPackages::where('user_id', $studentDetails->user_id)
                                                ->where('package_id',$servicePackage->package_id)
                                                ->where('status', 'created')
                                                ->first();
            if (!empty($studentPackage)) {
                if ($studentPackage->start_date == null) {
                    $studentPackage->start_date =  date('Y-m-d', strtotime($input['lession_date']));
                    $studentPackage->end_date = date('Y-m-d', strtotime('+1 month', strtotime($studentPackage->start_date)));
                    $studentPackage->status = 'active';
                    $studentPackage->save();
                }
            }
        }

        $studentDetails->save();
		
        $sduration = 0;
        if($service->length_type == 'hour'){
            $sduration = $service->length * 60;
        } else {
            $sduration = $service->length;
        }

        $booking = new StudentLessonsBooking();
        $booking->service_id = $input['service_id'];
        $booking->teacher_id = $input['teacher_id'];
        $booking->location_id = $input['location_id'];
        $booking->user_id = $input['user_id'];
        $booking->lession_date = $input['lession_date'];
        $booking->lession_time = $input['time'];
        $booking->additional_info_teacher = $input['additional_info_teacher'];
        $booking->student_skype_id = $input['student_skype_id'];
        $booking->location_detail = $input['location_detail'];
        $booking->status = 'booked';
        $booking->lesson_duration = $sduration;
        $booking->student_lessons_id = $student_lessons_id;
        $booking->lession_type = 'regular';
        $booking->added_by_admin = 1;

		$admin_commision = Settings::getSettings('admin_commision');
		$student_referred_admin_commision = Settings::getSettings('student_referred_admin_commision');
		
        if($input['teacher_id'] == $student->referred_by){
			$percent = 100 - $student_referred_admin_commision;
		} else {			
			$percent = 100 - $admin_commision;
		}
		
		$teacher_earning = round($service_price * ($percent / 100));
		$lession['teacher_earnings'] = $teacher_earning;
        $lession['admin_earnings'] = $service_price - $teacher_earning;
		
        $booking->teacher_earnings = $teacher_earning;
        $booking->admin_earnings = $service_price - $teacher_earning;
        $booking->total_earnings = $service_price;

        $booking->save();

        // Send mail to teacher and student
		if(env('IS_EMAIL_ENABLED') == 1){
			$template = "emails.lessionBooking";
			$subject = "New Appointment from ".$student->firstname.' '.$student->lastname;

			$tdata = [
				'user' => $teacher,
				'student' => $student,
				'teacher' => $teacher,
				'date' => $input['lession_date'],
				'time' => $input['time'],
				'lesson' =>  $service->title,
				'location' => $location->title,
				'site_url' => url('/'),
				'title' => 'New Appointment',
			];
			dispatch(new SendEmailJob($template, $tdata, $subject, 'user'));

			$stemplate = "emails.student-lessionBooking";
			$subject = date('m', strtotime($input['lession_date'])) . '月' . date('d', strtotime($input['lession_date'])) . ', '.date('Y', strtotime($input['lession_date'])). $input['time'] .' ご予約をおとりいたしました';
			$sdata = [
				'user' => $student,
				'student' => $student,
				'teacher' => $teacher,
				'date' => $input['lession_date'],
				'time' => $input['time'],
				'lesson' =>  $service->title,
				'location' => $location->title,
				'booking_id' => $booking->id,
				'site_url' => url('/'),
				'title' => 'Appointment Confirmation',
			];
			dispatch(new SendEmailJob($stemplate, $sdata, $subject, 'user'));
		}
        
		/* Send Push to Student */
		if(env('IS_LINE_ENABLED') == 1){
			if(!empty($student->line_token)){
				AppHelper::sendLineNotification($student->line_token, $teacher->firstname .' '.$teacher->lastname, $service->title, $location->title, $request->lession_date .' '.$request->time, 'student', 'new');
			}

			/* Send Push to Teaacher */
			if(!empty($teacher->line_token)){
				AppHelper::sendLineNotification($teacher->line_token, $student->firstname .' '.$student->lastname, $service->title, $location->title, $request->lession_date .' '.$request->time, 'teacher', 'new');
			}
			
			/* Send Push to own */
			AppHelper::sendLineNotification('Uaeb57c050913b806dbb0751ee1348130', $student->firstname .' '.$student->lastname, $service->title, $location->title, $request->lession_date .' '.$request->time, 'teacher', 'new');
		}

        return response()->json(['type' => 'success', 'message' => 'Lesson booked successfully']);
    }

    public function edit($id, Request $request) {
        $input = $request->all();
        $ref = !empty($input['ref']) ? $input['ref'] : '';
        $booking = StudentLessonsBooking::find($id);

        $services = Services::where('id', $booking->service_id)->pluck('title', 'id')->toArray();
        $service = Services::where('id', $booking->service_id)->first();
        $studentLesson = StudentLessons::where('service_id', $booking->service_id)->where('user_id', $booking->user_id)->where('id', $booking->student_lessons_id)->where('status', 1)->first();

        $teacher = User::select('id', DB::raw("CONCAT(users.firstname, ' ', users.lastname) AS name"))
            ->where('id', $booking->teacher_id)
            ->pluck('name', 'id')->toArray();

        $location = Locations::select('id', 'title')
            ->where('id', $booking->location_id)
            ->pluck('title', 'id')->toArray();

        $student_name = User::select(DB::raw("CONCAT(users.firstname, ' ', users.lastname) AS name"))
            ->where('user_type', 'student')
            ->where('id', $booking->user_id)
            ->value('name');

        $minDate = date('Y-m-d');
        if (!empty($studentLesson)) {
           // if(time() < strtotime($studentLesson->start_date)){
                $minDate = date('Y-m-d', strtotime($studentLesson->start_date));
            //}
            if($studentLesson->expire_date){
                $maxDate = date('Y-m-d', strtotime($studentLesson->expire_date));
            } else {
                $maxDate = date('Y-m-d', strtotime('+30 days'));
            }
        } else {
            $maxDate = date('Y-m-d', strtotime('+30 days'));
        }



        return view('admin.bookings.edit', compact('maxDate', 'minDate', 'booking', 'services', 'student_name', 'teacher', 'location','ref'));
    }

    public function update(EditRequest $request, $id){
        $input = $request->all();
        $booking = StudentLessonsBooking::find($id);
        $location = Locations::find($input['location_id']);
        $student = User::find($booking['user_id']);
        $teacher = User::find($booking['teacher_id']);
        $lesson = StudentLessons::where('user_id', $booking['user_id'])
                                        ->where('service_id', $booking['service_id'])
                                        ->where('id', $booking['student_lessons_id'])
                                        ->where('status', 1)
                                        ->first();

        $bdata = [
            'service_id' => $input['service_id'],
            'teacher_id' => $input['teacher_id'],
            'location_id' => $input['location_id'],
            'user_id' => $input['user_id'],
            'lession_date' => $input['lession_date'],
            'lession_time' => $input['time'],
            'student_skype_id' => $input['student_skype_id'],
            'additional_info_teacher' => $input['additional_info_teacher'],
            'location_detail' => $input['location_detail'],
            'status' => $input['status'],
            //'lession_type' => 'regular',
        ];

        $threeStatus = ['booked', 'completed', 'cancel'];

        if(in_array($input['status'], $threeStatus)){
            //$bdata['status'] = $input['status'];
        }

        $studentService = Services::find($booking['service_id']);

        $sduration = 0;
        if($studentService->length_type == 'hour'){
            $sduration = $studentService->length * 60;
        } else {
            $sduration = $studentService->length;
        }

        $bdata['lesson_duration'] = $sduration;

        if((($input['status'] == 'teacher_not_show')) || ($input['status'] == 'cancel') || ($input['status'] == 'deleted')){

            $bdata['status'] = 'cancel';
            $bdata['cancelled_at'] = date('Y-m-d H:i:s');
			$bdata['lession_date'] = $booking['lession_date'];
			$bdata['lession_time'] = $booking['lession_time'];
		
            if($input['status'] == 'teacher_not_show'){
                $bdata['is_teacher_present'] = 1;
            } else {
                $bdata['is_teacher_present'] = 0;
            }


            $studentDetail = StudentDetail::where('user_id', $booking['user_id'])->first();

            $service = ServicePackages::where('service_id', $booking['service_id'])
                                        ->where('is_deleted', 0)
                                        ->first();

            $serviceDetail = Services::find($booking['service_id']);

            if($booking['lession_type'] == 'trial'){
                $lesson->available_bookings = 1;
				$lesson->save();
               // $message = "Trail Lesson Canceled.";
            } else if(!empty($service) && $serviceDetail->is_system_service == 1) {
				if(($input['status'] == 'teacher_not_show') || ($input['status'] == 'cancel')) {
				   //get studentpackage
					/*$StudentPackages = StudentPackages::where('id', $booking['student_lessons_id'])->first();
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
					
					$StudentPackages->save();*/
					
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
			    }
            } else if(!empty($lesson)) {
				if(($input['status'] == 'teacher_not_show') || ($input['status'] == 'cancel')) {
					$lesson->available_bookings = $lesson['available_bookings'] + 1;
					$lesson->is_expired = 0;			
					$lesson->save();
				}
            }
        }

		if($input['status'] == 'booked') {
			
			$bdata['lession_date'] = $input['lession_date'];
			$bdata['lession_time'] = $input['time'];
			if(env('IS_EMAIL_ENABLED') == 1) {
				// Send mail to teacher and student
				/*$template = "emails.lessionBooking";
				$subject = "Lesson Rescheduled";

				$tdata = [
					'user' => $teacher,
					'student' => $student,
					'teacher' => $teacher,
					'date' => $input['lession_date'],
					'time' => $input['time'],
					'lesson' => $studentService->title,
					'location' => $location->title
				];
				dispatch(new SendEmailJob($template, $tdata, $subject, 'user'));*/
				$template = "emails.lessionBooking";
				$subject = 'Appointment changed for '.$student->firstname.' '.$student->lastname;

				$tdata = [
					'user' => $teacher,
					'student' => $student,
					'teacher' => $teacher,
					'date' => $input['lession_date'],
					'time' => $input['time'],
					'lesson' => $studentService->title,
					'location' => $location->title,
					'site_url' => url('/'),
					'title' => 'Appointment Change',
				];
				dispatch(new SendEmailJob($template, $tdata, $subject, 'user'));
				

				/*$sdata = [
					'user' => $student,
					'student' => $student,
					'teacher' => $teacher,
					'date' => $input['lession_date'],
					'time' => $input['time'],
					'lesson' => $studentService->title,
					'location' => $location->title
				];
				dispatch(new SendEmailJob($template, $sdata, $subject, 'user'));*/
				$stemplate = "emails.student-lessionBooking";
				$subject = "予約が変更されました";
				$sdata = [
					'user' => $student,
					'student' => $student,
					'teacher' => $teacher,
					'date' => $input['lession_date'],
					'time' => $input['time'],
					'lesson' => $studentService->title,
					'location' => $location->title,
					'booking_id' => $id,
					'site_url' => url('/'),
					'title' => 'Appointment Change',
				];
				dispatch(new SendEmailJob($stemplate, $sdata, $subject, 'user'));
			}
		}

		/* Send Push to Student */
		if(env('IS_LINE_ENABLED') == 1 && ($input['status'] == 'cancel' || $input['status'] == 'csd' || $input['status'] == 'booked')){
			if($input['status'] == 'cancel' || $input['status'] == 'csd') {
				$line_status = 'cancellled';
			} else {
				$line_status = 'rescheduled';
			}
			if(!empty($student->line_token)){
				
				AppHelper::sendLineNotification($student->line_token, $teacher->firstname .' '.$teacher->lastname, $studentService->title, $location->title, $input['lession_date'] .' '.$input['time'], 'student', $line_status);
			}

			/* Send Push to Teaacher */
			if(!empty($teacher->line_token)){
				AppHelper::sendLineNotification($teacher->line_token, $student->firstname .' '.$student->lastname, $studentService->title, $location->title, $input['lession_date'] .' '.$input['time'], 'teacher', $line_status);
			}
			
			/* Send Push to own */
			AppHelper::sendLineNotification('Uaeb57c050913b806dbb0751ee1348130', $student->firstname .' '.$student->lastname, $studentService->title, $location->title, $input['lession_date'] .' '.$input['time'], 'teacher', $line_status);
		}

        if($input['status'] == 'free_lesson'){
            $bdata['status'] = 'completed';
            $bdata['is_free_lesson'] = 1;
            //$lesson->available_bookings = $lesson['available_bookings'] + 1;
        }
		
		if($input['status'] == 'deleted'){
            $bdata['status'] = 'deleted';
			file_put_contents(public_path('deleted_status.txt'), date('Y-m-d H:i:s').PHP_EOL . 'Appointment Id: '. $id.', Old Status: '.$booking['status'] . PHP_EOL, FILE_APPEND);
        }
		
		if(($input['status'] == 'teacher_not_show') || ($input['status'] == 'student_not_show')){
			$bdata['status'] = $input['status'];
		}

		//echo '<pre>';print_r($bdata);exit;
        $booking->update($bdata);
		
		$booking = StudentLessonsBooking::find($id);			
		if(env('IS_EMAIL_ENABLED') == 1 && ($input['status'] == 'cancel' || $input['status'] == 'csd')){
			if(!empty($student['email'])){

				$template = "emails.student-cancel-lesson";
				$subject = "予約がキャンセルされました";
				$data = [
					'user' => $student, 
					'receiver' => $student, 
					'booking' => $booking,										
					'site_url' => url('/'),
				];
				dispatch(new SendEmailJob($template, $data, $subject,'cancel_mail'));			  
			}

			if(!empty($teacher['email'])){
				$template = "emails.teacher-cancel-lesson";
				$subject = 'Appointment cancellation for '.$student->firstname.' '.$student->lastname;
				$data = [
					'user' => $teacher, 
					'receiver' => $teacher,
					'student' => $student, 
					'booking' => $booking,					
					'site_url' => url('/'),
				];
				dispatch(new SendEmailJob($template, $data, $subject,'cancel_mail'));
			}			

			//Send mail(to share record emails)				
			$shareRecords = StudentShareRecord::where('user_id', $booking['user_id'])
												->where('share_type', 'lessons')
												->pluck('email');

			if(!empty($shareRecords) && $shareRecords->toArray()){
				$shareTemplate = "emails.lession-cancel";
				$shareSubject = "Lesson cancelled for ".$student->firstname .' '. $student->lastname;
				$shdata = [
					'student' => $student,
					'teacher' => $teacher,
					'date' => $input['lession_date'],
					'time' => $input['time'],
					'lesson' =>  $studentService->title,
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
		}
			
        if(!empty($input['ref']) && $input['ref']=='calender'){
            return redirect()->route('admin.calender.index')->with('message', 'Booking Updated Successfully');
        } else {
            return redirect()->route('admin.bookings.index')->with('message', 'Booking Updated Successfully');
        }
    }

    public function destroy(Request $request, $id)
    {
        $booking = StudentLessonsBooking::findOrFail($id);

        if (!empty($booking)) {
            $booking->status = 'cancel';
            $booking->save();

            $lesson = StudentLessons::where('user_id', $booking['user_id'])
                                        ->where('service_id', $booking['service_id'])
                                        ->where('status', 1)
                                        ->first();
            $studentDetail = StudentDetail::where('user_id', $booking['user_id'])->first();

            $serviceDetail = Services::find($booking['service_id']);

            $teacher = User::find($booking['teacher_id']);
            $student = User::find($booking['user_id']);
            $service = ServicePackages::where('service_id', $booking['service_id'])->where('is_deleted', 0)->first();
            $studentService = Services::find($booking['service_id']);
            $location = Locations::find($booking['location_id']);


            if(!empty($lesson) && $booking['lession_type'] == 'trial'){
                $lesson->available_bookings = 1;
               // $message = "Trail Lesson Canceled.";
            }else if(!empty($service)){
                $lesson->available_bookings = $lesson['available_bookings'] + 1;
                $studentDetail->credit_balance = $studentDetail['credit_balance'] + $booking['total_earnings'];
                if(!empty($serviceDetail->receive_credit_on_booking)){
                    $studentDetail->reward_balance = $studentDetail['reward_balance'] - $serviceDetail->receive_credit_on_booking;
            }
                //$message = "Lesson Canceled.";
            }else if(empty($service)){
                $lesson->available_bookings = $lesson['available_bookings'] + 1;
                //$message = "Lesson Canceled.";
            }

            $lesson->save();
            $studentDetail->save();

            if(!empty($student['email'])){

                $template = "admin.emails.student-cancel-lesson";
                $subject = "Lesson Cancelled";

                $data = ['user' => $student,
                        'student' => $student,
                        'booking' => $booking,
                        'teacher' => $teacher,
                        'date' => $booking['lession_date'],
                        'time' => $booking['lession_time'],
                        'lesson' => $studentService->title,
                        'location' => $location->title
                    ];

                dispatch(new SendEmailJob($template, $data, $subject,'cancel_mail'));
            }


            if(!empty($teacher['email'])){
                $template = "admin.emails.teacher-cancel-lesson";
                $subject = "Lesson Cancelled";
                $data = [
                    'user' => $teacher,
                    'student' => $student,
                    'teacher' => $teacher,
                    'date' => $booking['lession_date'],
                    'time' => $booking['lession_time'],
                    'lesson' => $studentService->title,
                    'location' => $location->title
                ];
                dispatch(new SendEmailJob($template, $data, $subject, 'user'));

            }

            //Send mail(to share record emails)

            $shareRecords = StudentShareRecord::where('user_id', $booking['user_id'])
                                                ->where('share_type', 'lessons')
                                                ->pluck('email');

            if(!empty($shareRecords) && $shareRecords->toArray()){
                $shareTemplate = "emails.lession-cancel";
                $shareSubject = "Lesson cancelled for ".$student->firstname .' '. $student->lastname;
                $shdata = [
                    'student' => $student,
                    'teacher' => $teacher,
                    'date' => $booking['lession_date'],
                    'time' => $booking['time'],
                    'lesson' =>  $studentService->title,
                    'location' => $location->title
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

            /* Send Push to Student */
            if(!empty($student->line_token)){
                $messages = [];
                $messages['to'] = $student->line_token;
                $msg = "Your booking is cancelled.\n";
                $msg .= "Lesson : ". $studentService->title ."\n";
                $msg .= "Location : ". $location->title ."\n";
                $msg .= "Teacher Name : ". $teacher['firstname'] .' '.$teacher['lastname'] ."\n";
                $msg .= "Booking Date : " . $booking['lession_date'] .' '.$booking['time']."\n";
                $messages['messages'][] = AppHelper::getFormatTextMessage($msg);
                $encodeJson = json_encode($messages);
                AppHelper::sentMessage($encodeJson);
            }

            /* Send Push to Teaacher */
            if(!empty($teacher->line_token)){
                $tmessages = [];
                $tmessages['to'] = $teacher->line_token;
                $tmsg = "Your booking is cancelled.\n";
                $tmsg .= "Lesson :". $studentService->title ."\n";
                $tmsg .= "Location : ". $location->title ."\n";
                $tmsg .= "Student Name :". $student['firstname'] .' '.$student['firstname'] ."\n";
                $tmsg .= "Booking Date : " . $booking['lession_date'] .' '.$booking['time']."\n";
                $tmessages['messages'][] = AppHelper::getFormatTextMessage($tmsg);
                $tencodeJson = json_encode($tmessages);
                AppHelper::sentMessage($tencodeJson);
            }

            $request->session()->flash('message', 'Booking Cancel Successfully');
            return response()->json(['success' => 'success']);
        } else {
            $request->session()->flash('message', 'Booking not found.');
            return response()->json(['success' => 'success']);
        }
    }

    public function getServices(Request $request)
    {
        $student_id = $request->get('student_id', 0);

        $package = StudentPackages::where('user_id', $student_id)
                                    //->whereRaw("start_date <= '".date('Y-m-d')."'::date")
                                    //->whereRaw("end_date >= '".date('Y-m-d')."'::date")
                                    ->where('status', 'active')
                                    ->with('package')
                                    ->first();

        $services = [];
        if (!empty($package)) {
            //$pservices = [];
            // if((time() - strtotime($package->end_date)) < 0){
            //     $pservices = ServicePackages::select('services.id as id', 'services.title as title')
            //                 ->where('package_id', $package['package_id'])
            //                 ->where('is_deleted', 0)
            //                 ->leftjoin('services', 'services.id', 'services_packages.service_id')
            //                 ->pluck('title', 'id');
            // }
			$pservices = Services::select('services.id', 'services.title')
                            ->join('services_packages', 'services.id', 'services_packages.service_id')
                            ->join('student_packages', 'student_packages.package_id', 'services_packages.package_id')
                             ->where(function($query){
                                 $query->whereRaw("student_packages.end_date >= '".date('Y-m-d')."'::date");
                                  // ->orwhereRaw('student_packages.end_date IS NULL');
                             })
                            ->where('student_packages.user_id', $student_id)
                            ->where('student_packages.status','active')
                            ->pluck('title', 'id');			
							
            $services = StudentLessons::select('services.id', 'services.title')
                            ->where('user_id', $student_id)
                            ->where('services.status', 1)
							->whereNotIn('student_lessons.service_id',[env('ONEPAGE_SERVICE_ID'), env('REGISTRATION_SERVICE_ID')])
                            ->leftjoin('services', 'services.id', 'student_lessons.service_id')
                            ->where(function($query){
                                $query->where('student_lessons.expire_date', '>=', date('Y-m-d'))
                                        ->orwhereRaw('student_lessons.expire_date IS NULL');
                            })
                            //->where('student_package_id',$package->id)
							->where('student_lessons.status',1)
                            ->whereRaw('student_package_id IS NULL')
                            ->pluck('title', 'id');

            if (!empty($pservices)) {
                $pservices = $pservices->toArray();
            }

            if (!empty($services)) {
                $services = $services->toArray();
            }

            //if ($pservices && $services) {
                $services = array_unique($services+$pservices);
            //}
			
			//echo '<pre>';print_r($services);exit;
        } else {
            $services = StudentLessons::select('student_lessons.service_id', 'services.title')
                ->join('services', 'services.id', 'student_lessons.service_id')
                ->where('student_lessons.user_id', $student_id)
                ->where('student_lessons.status', 1)
				->whereNotIn('student_lessons.service_id',[env('ONEPAGE_SERVICE_ID'), env('REGISTRATION_SERVICE_ID')])
                ->where(function($query){
                    $query->where('student_lessons.expire_date', '>=', date('Y-m-d'))
                            ->orwhereRaw('student_lessons.expire_date IS NULL');
                })
                ->whereRaw('student_package_id IS NULL')
                ->pluck('title', 'service_id');

            if ($services) {
                $services = $services->toArray();
            }
        }

        return response()->json(['type' => 'success', 'services' => $services]);

    }

    public function changeService(Request $request) {

        $service_id = $request->service_id;
        $user_id = $request->user_id;
        /*$locations  = ServiceLocations::where('service_id', $request->service_id)
            ->leftjoin('location', 'services_locations.location_id', '=', 'location.id')
            ->get();*/
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

        $service = StudentLessons::where('service_id', $request->service_id)		
							//->whereRaw("start_date <= '".date('Y-m-d')."'::date")
                            ->whereRaw("expire_date >= '".date('Y-m-d')."'::date")
							->where('user_id', $user_id)
        ->where('status', 1)
        ->where('is_expired', 0)
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
        $upToMonth = Settings::getSettings('book_upto_month');
        $maxDate = date('Y-m-d', strtotime("+".$upToMonth." months"));
        if (!empty($service)) {
            //if(time() < strtotime($service->start_date)){
                $minDate = date('Y-m-d', strtotime($service->start_date));
            //}
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

    public function getTeachers(Request $request){

        $service_id = $request->service_id;
        $location_id = $request->location_id;

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

        return response()->json(['teachers' => $teachers]);
       /* $service_id = $request->get('service_id', 0);
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
        return response()->json(['type' => 'success', 'locations' => $locations, 'teachers' => $teachers]);*/
    }

    public function getStudent(Request $request){
        $name = $request->get('term');

        $students = User::select('users.id As id','users.email As email',
                DB::raw("CONCAT(users.firstname, ' ', users.lastname) AS name"))
            ->whereRaw("LOWER(CONCAT(users.firstname, ' ', users.lastname)) like LOWER('%" . $name . "%')")
            ->where('users.user_type', '=', 'student')->get()->toArray();

        $studentData = [];
        foreach ($students as $key => $st) {
            $studentData[] = [
                'label' => $st['name'] .' ('. $st['email'].')',
                'value' => $st['name'] .' ('. $st['email'].')',
                'id' => $st['id'],
            ];
        }
        return response()->json($studentData);
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
        // $exception_days = TeacherScheduleException::where(['user_id' => $id, $day => 1])
        //     ->whereRaw("from_date <= '".date('Y-m-d',strtotime($date))."'::date")
        //     ->whereRaw("to_date >= '".date('Y-m-d',strtotime($date)) ."'::date")
        //     ->get()->toArray();

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


        $endTime = '23:59';//$setting['end_time'];
        $startTime = '05:00';//$setting['start_time'];

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
        //$not_availble_days = TeacherSchedule::where(['user_id' => $id, $day => 0])->get()->toArray();

        $booked_days = StudentLessonsBooking::where('lession_date', $date)
            ->where(function ($q) use ($id) {
                $q->where('user_id', Auth::id())->orWhere('teacher_id', $id);
            })->where('status', 'booked')->get()->toArray();

        $booked_days_array = [];
        /*foreach ($booked_days as $day) {
            $booked_days_array[] = [
                'start' => date('H:i', strtotime($day['lession_time'])),
                'end' => date('H:i', strtotime('+'.$day['lesson_duration'].'Minutes', strtotime($day['lession_time'])))
            ];
        }

        $idData = $this->getIcalData($id,$date);
        $booked_days_array = array_merge($booked_days_array, $exception_time_array, $idData);*/
//echo '<pre>';print_r($availble_days);exit;
        $todayAvailableTime = [];
        foreach ($availble_days as $day) {
            $todayAvailableTime[] = $day['from_time'];
        }

        $todayNotAvailableTime = [];
        /*foreach ($not_availble_days as $day) {
            $todayNotAvailableTime[] = date('H', strtotime($day['from_time']));
        }*/

        sort($todayAvailableTime);
        sort($todayNotAvailableTime);

        $from_time = '06:00';//current($todayAvailableTime);
        if (end($todayAvailableTime) != '23:00:00') {
            $to_time = date('H:i:s', strtotime('+1 hour', strtotime(end($todayAvailableTime))));
        } else {
            $to_time = '23:59:59';
        }
		$to_time = '23:00';
        $padding = 0;

        $seviceLength = 5;
        /*if($service->length_type == 'hour'){
            $seviceLength = $service->length * 60;
        } else {
            $seviceLength = $service->length;
        }*/

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

        $html = '';
        while (strtotime($from_time_format) < strtotime($to_time_format)) {
            if ((!empty($endTime)) && (!empty($startTime))) {
                $bookingStTime = 0;
                if(!empty($teacher->book_before_time)){
                    //$bookingStTime = $teacher->book_before_time;
                } else {
                    //$bookingStTime = Settings::getSettings('book_before_time');
                }

                if(strtotime($date) == strtotime(date('Y-m-d'))){
                    //$start_time_format = date('H:i');
                    $hour = date('H');

                    if(($hour + $bookingStTime) < 24){
                        $start_time_format = date('H:i', strtotime('+'.$bookingStTime.' Hours'));
                    } else {
                        break;
                    }
                    //$start_time_format = date('H:i', strtotime('+'.$teacher->book_before_time.' Hours'));
                } else {
                    $strtResDateTime = strtotime(date('Y-m-d H:i', strtotime('+'.$bookingStTime.' Hours')));
                    $strtResDate = strtotime(date('Y-m-d', strtotime('+'.$bookingStTime.' Hours')));
//echo $to_time_format;exit;
                    if($strtResDate <= strtotime($date)){
                        if($strtResDateTime >= strtotime($date.' '.date('H:i'))){
                            $start_time_format = date('H:i', strtotime('+'.$bookingStTime.' Hours'));
                        } else {
                            $start_time_format = date('H:i', strtotime($startTime));
                        }
                    } else {
                       $start_time_format = date('H:i', strtotime($startTime));
                    }
                }
				$start_time_format = date('H:i', strtotime($startTime));

                //$start_time_format = date('H:i', strtotime($startTime));
                $end_time_format = date('H:i', strtotime($endTime));
                if ((strtotime($from_time_format) >= strtotime($start_time_format)) &&
                    (strtotime($from_time_format) < strtotime($end_time_format))) {
                    if (!empty($booked_days_array)) {
                        $isSlotAvailable = true;
                        foreach($booked_days_array as $bookedSlot){
                            if( (strtotime($bookedSlot['start']) <= strtotime($from_time_format)) && ( strtotime($from_time_format) < strtotime($bookedSlot['end']))){
                                $isSlotAvailable = false;
                                break;
                            }
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

            $from_time_format = date('H:i', strtotime('+' . $fasd . ' minutes', strtotime($from_time_format)));
        }

        $start = '<label for="exampleInputEmail1" class="grey">Time<span class="astric">*</span></label>';
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

            $getData = file_get_contents($url);
            $ical = new iCalEasyReader();
            $lines = $ical->load($getData);
            $events = $lines['VEVENT'];

            foreach ($events as $event) {
                //$startDate = $event['DTSTART']['value'];
                $startDate = $event['DTSTART'];
                $startDate = date('Y-m-d\TH:i:s', strtotime($startDate));
                //$endDate = $event['DTEND']['value'];
                $endDate = $event['DTEND'];
                $endDate = date('Y-m-d\TH:i:s', strtotime($endDate));
                $startDateT = strtotime(date('Y-m-d', strtotime($startDate)));
                $endDateT = strtotime(date('Y-m-d', strtotime($endDate)));

                if($startDateT == $today && $endDateT == $today){
                    $booked_days_array[] = [
                        'start' => date('H:i', strtotime($startDate)),
                        'end' => date('H:i', strtotime($endDate))
                    ];
                }
            }
        }

        //dd($booked_days_array);
        return $booked_days_array;
    }
}
