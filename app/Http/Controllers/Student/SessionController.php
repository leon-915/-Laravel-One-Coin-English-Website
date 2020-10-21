<?php

namespace App\Http\Controllers\Student;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;
use App\Helpers\AppHelper;
use App\Models\Settings;
use App\Models\Services;
use App\Models\StudentLessons;
use App\Models\StudentDetail;
use App\Models\StudentTeachers;
use App\Models\StudentLessonsBooking;
use App\Models\TeacherDetail;
use App\Models\TeacherIcal;
use App\Models\TeacherSchedule;
use App\Models\TeacherScheduleException;
use App\Models\StudentTeacherFavorite;
use App\User;
use Carbon\Carbon;
use App\Models\RatingTypes;
use App\Models\TeacherRatings;


use Stripe\Stripe;
use Stripe\PaymentIntent;
use Stripe\PaymentMethod;

class SessionController extends Controller
{
    public function index(Request $request){
        $user = Auth::user();
		$user_id = Auth::user()->id;
        $student = User::where('id', $user_id)->first();
        $studentDetails = $student->details()->first();
        $teacher_id = StudentTeacherFavorite::where('student_id', $user_id)->where('is_favorite', 1)->pluck('teacher_id')->first();
		$time_after_10_min = date('H:i:s', strtotime('+10 min'));
		$currenttime = date('H:i:s', strtotime('-10 min'));
		$booking = StudentLessonsBooking::where('user_id', $user_id)
										//->where('teacher_id', $teacher_id)
										->where('lession_date', date('Y-m-d'))
										->whereRaw("lession_time <= '$time_after_10_min'")
										->whereRaw("lession_time >= '$currenttime'")
										->where('status', 'booked')
										->orderBy('lession_time', 'DESC')
										->first();
		if(isset($booking->id) && $booking->id > 0) {
			$role = 'premium';
			$booking_id = $booking->id;
		} else {
			$role = 'basic';
			$booking_id = 0;
		}
		
		$booking_to_rate = StudentLessonsBooking::select('id', 'teacher_id', 'is_rated')->where('status', 'booked')                                            
                                            ->where('user_id', $user_id)
                                            ->where('is_rated', 'no')
                                            ->orderByRaw('completed_at DESC NULLS LAST')
                                            ->first();
		//echo '<pre>';print_r($booking);exit;
		$teacherid_to_rate = '';
		$ratingTypes = [];
		$teacherRatings = [];
		$bookingid_to_rate = '';
		if($booking_to_rate) {
			$teacherid_to_rate = $booking_to_rate->teacher_id;
			$bookingid_to_rate = $booking_to_rate->id;
			$ratingTypes = TeacherRatings::where('lesson_booking_id',$booking_to_rate->id)
											->with('rating')
											->get();

		}
		
        return view('students.session.index', compact('user', 'studentDetails', 'teacher_id', 'role', 'booking', 'booking_id', 'teacherid_to_rate', 'ratingTypes', 'bookingid_to_rate', 'teacherRatings'));
    }
	
    public function getbookings(Request $request){
        
		$student_id = $request->student_id;
		
		$bookings = StudentLessonsBooking::where('user_id', $student_id);
        $page_number = 0;
        if (isset($_POST["page"])) {
            $page_number = filter_var($_POST["page"], FILTER_SANITIZE_NUMBER_INT, FILTER_FLAG_STRIP_HIGH);
        }
        $item_per_page = isset($_REQUEST['limit']) ? $_REQUEST['limit'] : 15;
        //get current starting point of records
        $position = (($page_number - 1) * $item_per_page);
        $html = '';
		$teacher_array = [];
		if ($student_id != '') {
            $allBookings = StudentLessonsBooking::where('user_id', $student_id)
                ->orderBy('lession_date', 'DESC')
                ->orderBy('lession_time', 'DESC')
                ->offset($position)
                ->limit($item_per_page)
                ->get();
				
            if (!empty($allBookings) && count($allBookings) > 0) {
                $teachers = User::where('user_type', 'teacher')->where('status', 1)->where('is_active', 1)->get();
				if(!empty($teachers)) {
					foreach($teachers as $teacher) {
						$teacher_array[$teacher->id] = $teacher->firstname.' '.$teacher->lastname;
					}
				}
				
				$i = ($page_number * $item_per_page) - $item_per_page + 1;
                foreach ($allBookings as $booking) {
				
					if(isset($teacher_array[$booking->teacher_id])) {
						$teacher_name = $teacher_array[$booking->teacher_id];
					} else {
						$teacher_name = 'Teacher_'.$booking->teacher_id.'';
					}
					if ($booking['status'] == 'completed') {
						$lesson_status = 'Completed';
					} else if ($booking['status'] == 'csd') {
						$lesson_status = 'CSD';
					} else if ($booking['status'] == 'teacher_not_show') {
						$lesson_status = 'Tnoshow';
					} else if ($booking['status'] == 'student_not_show') {
						$lesson_status = 'Snoshow';
					} else if ($booking['status'] == 'cancel') {
						$lesson_status = 'Cancelled';
					} else {
						$lesson_status = 'Scheduled';
					}
					
                    $html .=  '<div>';
                    $html .=  '<div>'.$i.'</div><div>'.$booking->lession_date.' '.substr($booking->lession_time, 0, 5).'</div><div>'.$teacher_name.'</div><div>'.$lesson_status.'</div>';
                    $html .=  '</div>';                    
                    $i++;   					
                }				
            }
        }		
        echo $html;
        exit();        
    }
	
	function teacheravailability(Request $request) {
		$teacher_id = $request->teacher_id;
		$teacher = User::where('id', $teacher_id)->first();
		$date = date('Y-m-d');
		$service_id = env('OCE_SERVICE_ID');
		$flag = false;
		$time = '';
		$availabilities = $this->checkAvailability($date, $teacher_id, $service_id);
		if(!empty($availabilities)) {
			$time_after_20_min = strtotime('+5 min');
			$time_after_5_min = strtotime('+0 min');
			foreach($availabilities as $availability) {
				/*echo strtotime($availability).' >= '.$time_after_5_min.' && '.strtotime($availability).' <= '.$time_after_20_min;
				echo "\n";
				echo $availability.' >= '.date('H:i', $time_after_5_min).' && '.$availability.' <= '.date('H:i',$time_after_20_min);
				echo "\n";*/
				if(strtotime($availability) >= $time_after_5_min && strtotime($availability) <= $time_after_20_min) {
					$flag = true;
					$time = $availability;
					break;
				}
			}
		}
		if($flag == true) {
			$user = Auth::user();
			$user_id = Auth::user()->id;
			$student = User::where('id', $user_id)->first();
			$studentDetails = $student->details()->first();
			if($studentDetails->credit_balance >= env('OCE_SESSION_PRICE')){
				$balance = env('OCE_SESSION_PRICE');
			} else {
				$balance = 0;
			}
			return response()->json(['type' => 'success', 'is_available' => $flag, 'time' => $time, 'balance' => $balance]);
		} else {
			return response()->json(['type' => 'failure', 'is_available' => $flag]);
		}
	}	

    public function checkAvailability($date = '', $teacher_id = '', $service_id = '') {
       
        $day = strtolower(date('l', strtotime($date)));
        $id = $teacher_id;
        if (!$id) {
            return '';
        }
		
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

        $endTime = '23:55';//$setting['end_time'];
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
		
        $html = [];
        while (strtotime($from_time_format) < strtotime($to_time_format)) {
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
						
                            if( (strtotime($bookedSlot['start']) <= (strtotime($from_time_format) + ($seviceLength * 60))) && ( strtotime($from_time_format) < strtotime($bookedSlot['end']))){
                                $isSlotAvailable = false;
                                break;
                            }
							
						
							$dd++;
                        }

                        if($isSlotAvailable){
                            if (!in_array(date('H', strtotime($from_time_format)), $todayNotAvailableTime)) {
                                $html[] =  date('H:i', strtotime($from_time_format));
                            }
                        }

                    } else {
						
                        if (!empty($todayNotAvailableTime)) {
                            if (!in_array(date('H', strtotime($from_time_format)), $todayNotAvailableTime)) {
                                $html[] = date('H:i', strtotime($from_time_format));
                            }
                        } else {
                            $html[] = date('H:i', strtotime($from_time_format));
                        }
                    }
                }
            }

            $from_time_format = date('H:i', strtotime('+' . $fasd . ' minutes', strtotime($from_time_format)));
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
                    $startDate = $event['DTSTART'];				
					
                    $startDate = date('Y-m-d\TH:i:s', strtotime($startDate));
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
	
	public function favorite(Request $request) {
        $student_id = Auth::user()->id;
        $input = $request->all();

        if(!empty($input['teacher_id'])) {
			$teacher_id = $input['teacher_id'];
			StudentTeacherFavorite::updateOrCreate([
                            'student_id' => $student_id,
                            'teacher_id' =>  $teacher_id,
                        ] , [
                            'is_favorite' => 1
                        ]);
			
			// add teacher to student's contact list		
			$chatdata = array('UID' => $student_id, 'friendsUID' => $teacher_id);			
			self::call_curl($chatdata, 'addFriends');
			
			// add student to teacher's contact list		
			$chatdata = array('UID' => $teacher_id, 'friendsUID' => $student_id);			
			self::call_curl($chatdata, 'addFriends');
			
			return response()->json(['type' => 'success', 'message' => 'You have made teacher favorite.']);			
		} else {
			return response()->json(['type' => 'failure', 'message' => 'There was an error. Please try again.']);
		}        
    }
	
	
	public function unfavorite(Request $request) {
        $student_id = Auth::user()->id;
        $input = $request->all();
        if(!empty($input['teacher_id'])) {
			$teacher_id = $input['teacher_id'];
			StudentTeacherFavorite::updateOrCreate([
                            'student_id' => $student_id,
                            'teacher_id' =>  $teacher_id,
                        ] , [
                            'is_favorite' => 0
                        ]);
			// Remove teacher from student's contact list
			$chatdata = array('UID' => $student_id, 'friendsUID' => $teacher_id);			
			self::call_curl($chatdata, 'deleteFriends');
			
			// Remove student from teacher's contact list
			$chatdata = array('UID' => $teacher_id, 'friendsUID' => $student_id);			
			self::call_curl($chatdata, 'deleteFriends');
			return response()->json(['type' => 'success', 'message' => 'You have made teacher unfavorite.']);		
		} else {
			return response()->json(['type' => 'failure', 'message' => 'There was an error. Please try again.']);
		} 
        
    }
	
	public static function call_curl($data = '', $api_name = '') {		
		$headers = array();
		$headers[] = 'Api-Key: 53942x44fe22ca174264e39ef0da5e7ec10f17';
		
		$ch = curl_init();		
		curl_setopt_array($ch, array(
				CURLOPT_URL => "https://api.cometondemand.net/api/v2/$api_name",
				CURLOPT_RETURNTRANSFER => true,
				CURLOPT_ENCODING => "",
				CURLOPT_MAXREDIRS => 10,
				CURLOPT_TIMEOUT => 0,
				CURLOPT_FOLLOWLOCATION => true,
				CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
				CURLOPT_CUSTOMREQUEST => "POST",
				CURLOPT_POSTFIELDS => http_build_query($data),
				CURLOPT_HTTPHEADER => $headers,
			)
		);

		$result = curl_exec($ch);
		$result = json_decode($result, true);
		//echo '<pre>';print_r($result);
		if (curl_errno($ch)) {
			echo 'Error:' . curl_error($ch);
		} 
		curl_close($ch);
		return $result;
	}
	
	function updatelessonstatus(Request $request) {
		
		$student_id = $request->student_id;
		$booking_id = $request->booking_id;
		$booking = StudentLessonsBooking::where('user_id', $student_id)->where('id', $booking_id)->first();
		if(!empty($booking) && $booking->id == $booking_id) {
			$booking->status = 'completed';
			$booking->save();	
			
			$studentDetail = StudentDetail::where('user_id', $student_id)->first();
			$studentDetail->credit_balance = ceil($studentDetail->credit_balance - env('OCE_SESSION_PRICE'));
			$studentDetail->save();
			
			return response()->json(['type' => 'success']);			
		} else {
			return response()->json(['type' => 'failure']);
		}		
	}
	
	function extendlesson(Request $request) {
		
		$student_id = $request->student_id;
		$booking_id = $request->booking_id;
		$booking = StudentLessonsBooking::where('user_id', $student_id)->where('id', $booking_id)->first();
		$response = $this->directCharge();
		//echo $booking->id.' == '.$booking_id;
		if($response == 'succeeded' && !empty($booking) && $booking->id == $booking_id) {
			$booking->status = 'completed';
			$booking->save();	
			$clientIp = $request->getClientIp();
			$time = date('H:i:s', strtotime('+ 10second'));
			
			$student_lesson_id = AppHelper::createOrder(auth()->id(), env('OCE_SERVICE_ID'));
			
			$lession = array(
				'user_id'                   => auth()->id(),
				'teacher_id'                => $booking->teacher_id,
				'service_id'                => env('OCE_SERVICE_ID'),
				'location_id'               => env('OCE_LOCATION_ID'),
				'lession_date'              => date('Y-m-d'),
				'lession_time'              => $time != '' ? $time : date('H:i:s'),
				'onepage_title'				=> date('ymd'),
				'location_detail'           => '',
				'lession_type'              => 'regular',
				'session_started'           => 1,
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
						
			$lession_date_time = strtotime(date('Y-m-d').' '.$time) + ($booking->lesson_duration * 60);
			$lession_date_time_str = date('d F Y H:i:s', $lession_date_time).' GMT+09:00';
			
			$ratingTypes = RatingTypes::all();
			if (!empty($ratingTypes) && $ratingTypes->toArray()) {
				foreach ($ratingTypes as $rating) {
					TeacherRatings::updateOrCreate([
						'student_id' => $student_id,
						'teacher_id' => $booking->teacher_id,
						'rating_id' => $rating->id,
						'lesson_booking_id' => $booking->id
					]);
				}
			}
			
			return response()->json(['type' => 'success', 'new_date_str' => $lession_date_time_str, 'message' => 'Your session has been extended by '.env('OCE_SESSION_DURATION').' minutes.']);
		} else {
			return response()->json(['type' => 'failure', 'message' => 'There was an error in extending your session.']);
		}		
	}	
	
	function directCharge() {
		$user = Auth::user();
		$stripe_customer_id = $user->stripe_customer_id;
		Stripe::setApiKey(config('services.stripe.test_secret_key'));
		$payment_method_id = $this->getPaymentMethod($stripe_customer_id);
		$amt = env('OCE_SESSION_PRICE');
		$tax = Settings::getSettings('tax');
		$amount = $amt + ($amt * $tax / 100);
		try {
		  $payment = PaymentIntent::create([
			'amount' => $amount,
			'currency' => 'jpy',
			'customer' => $stripe_customer_id,
			'payment_method' => $payment_method_id,
			'off_session' => true,
			'confirm' => true,
		  ]);
		  //echo '<pre>';print_r($payment);
		  $status = $payment->status;
		} catch (\Stripe\Exception\CardException $e) {
			$status = 'fail';
		  // Error code will be authentication_required if authentication is needed
		  //echo 'Error code is:' . $e->getError()->code;
		  //$payment_intent_id = $e->getError()->payment_intent->id;
		  //$payment_intent = PaymentIntent::retrieve($payment_intent_id);
		}
		return $status;
		//echo '<pre>';print_r($payment_intent);
	}
	
	function getPaymentMethod($customer_id = '') {
		$paymentmethods = PaymentMethod::all([
		  'customer' => $customer_id,
		  'type' => 'card',
		]);
		
		return $id = $paymentmethods->data[0]->id;
	}

    public function storeOceRating(Request $request) {
        $student_id = Auth::user()->id;
        $input = $request->all();

        $teacher_id = !empty($input['teacherid_to_rate']) ? $input['teacherid_to_rate'] : '';
        $booking_id = !empty($input['bookingid_to_rate']) ? $input['bookingid_to_rate'] : '';
        $comments = !empty($input['comments']) ? $input['comments'] : '';

        $booking = StudentLessonsBooking::where('id', $booking_id)->first();
        $booking->is_rated = 'yes';
        $booking->save();

        if(!empty($input['rating'])){
            $rewardPoints = Settings::getSettings('teacher_credits_rate');
            if(!empty($rewardPoints)){
                $student = StudentDetail::where('user_id',$student_id)->first();
                $student->reward_balance = $student->reward_balance + $rewardPoints;
                $student->save();
            }        

			foreach($input['rating'] as $rating_id => $star) {
				 TeacherRatings::updateOrCreate([
										'student_id'    => $student_id,
										'teacher_id'    => $teacher_id,
										'rating_id'     => $rating_id,
										'lesson_booking_id' => $booking_id,
									] , [
										'status' => 1,
										'ratings' => $star,
										'comments' => $comments,
										
									]);
			}
		}
        return response()->json(['type' => 'success', 'message' => 'Rating submitted Successfully.']);
    }
}
