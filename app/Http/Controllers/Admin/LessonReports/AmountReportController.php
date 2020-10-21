<?php

namespace App\Http\Controllers\Admin\LessonReports;

use App\Models\StudentLessons;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\StudentLessonsBooking;
use App\Models\StudentTransactions;
use App\Models\Settings;
use App\Models\Services;
use Illuminate\Support\Facades\DB;

class AmountReportController extends Controller
{
    public function index(Request $request) {
        $input  = $request->all();
        $option = !empty($input['opt']) ? $input['opt'] : 'amt_spent_by_students';

        switch ($option) {
            case 'amt_spent_by_students':
                return $this->totalAmountSpentByStudent($input);
                break;

            case 'amt_spent_per_student':
                return $this->totalAmountSpentPerStudent($input);
                break;

            case 'amt_gen_by_teachers':
                return $this->totalAmountGenByTeachers($input);
                break;

            case 'amt_gen_per_teacher':
                return $this->totalAmountGenPerTeacher($input);
                break;

            case 'top_10_teacher_amt_gen':
                return $this->top10Teachers($input);
                break;

            case 'least_10_teacher_amt_gen':
                return $this->last10Teachers($input);
                break;

            case 'total_hours_taught_by_teachers':
                return $this->totalHoursTaughtByTeachers($input);
                break;

            case 'total_hours_taught_per_teacher':
                return $this->totalHoursTaughtPerTeachers($input);
                break;

            default:
                return $this->totalAmountSpentByStudent($input);
                break;
        }
    }

    private function totalAmountSpentByStudent($input = array()){
        $filter = !empty($input['filter']) ? $input['filter'] : '';
        $option = !empty($input['opt']) ? $input['opt'] : 'amt_spent_by_students';
        $sort   = !empty($input['sort']) ? $input['sort'] : '';
        $from_date = !empty($input['from_date']) ? $input['from_date'] : '';
        $to_date   = !empty($input['to_date']) ? $input['to_date'] : '';
        $last_date = date('Y-m-d', strtotime('-6 days'));
        $today = date('Y-m-d', strtotime(today()));

        if(!empty($from_date) && !empty($to_date)){
            $filter = '';
            $bdays = $this->dateDiff($from_date, $to_date);

            if($bdays >= 0 && $bdays < 31){
                /*$amounts=StudentTransactions:: select(
                    DB::raw("to_char(created_at, 'DD Mon') as date"),
                    DB::raw("sum(NULLIF(amount,0)) as total")
                )
                ->whereRaw("created_at >= '".$from_date."'::date")
                ->whereRaw("created_at < '".date('Y-m-d',strtotime('+1 day', strtotime($to_date))) ."'::date")
                ->groupBy('date')->pluck('total','date')->toArray();

                $lastMonth = $this->daterange($from_date,$to_date);
                $amtData = [];
                foreach ($lastMonth as $day) {
                    $amtData['lables'][] = $day;
                    $amtData['data'][] = !empty($amounts[$day]) ? (int)$amounts[$day] : 0;
                }*/
				
				$bookingsData=StudentLessonsBooking:: select(
                    DB::raw("to_char(lession_date, 'DD Mon') as date"),
                    DB::raw("service_id"),
                )
                ->whereRaw("lession_date >= '".$from_date."'::date")
                ->whereRaw("lession_date < '".date('Y-m-d',strtotime('+1 day', strtotime($to_date))) ."'::date")
				->whereIn('status',["completed", "student_not_show", "csd"])
				->whereNotIn('service_id', [env('ONEPAGE_SERVICE_ID'), env('REGISTRATION_SERVICE_ID')])
				->get()
				->toArray();
				$amounts = '';
				$tax = Settings::getSettings('tax');
				$amtData = $serviceArray = $array = [];
				if(!empty($bookingsData)) {
					foreach ($bookingsData as $booking) {
						$date = $booking['date'];
						$service_id = $booking['service_id'];
						if(!in_array($service_id, $serviceArray)) {
							$product = Services::where('id', $service_id)->first();
							$is_point_ststem_service = $product->is_system_service;
							$lessons = $product->available_lessons;
							$amount = $product->price + (($product->price*$tax / 100));
							$serviceArray[$service_id] = array('is_point_ststem_service' => $is_point_ststem_service, 'amount' => $amount, 'lessons' => $lessons);
						}
						
						
						
						if($serviceArray[$service_id]['is_point_ststem_service'] == 1) {
								$amount = $serviceArray[$service_id]['amount'];
						} else {
							$lessons = $lessons > 0 ? $lessons : 1;
							$amount = $serviceArray[$service_id]['amount'] / $lessons;
						}
						if(isset($array[$date])) {
							$array[$date] = $array[$date] + $amount;
						} else {
							$array[$date] = $amount;
						}
						/*$amtData['lables'][] = $date;
						$amtData['data'][] = $amount > 0 ? (int)$amount : 0;*/
					}
				}
				//echo '<pre>';print_r($array);exit;
				$stDate = date('Y-m')."-01";
                $lastMonth = $this->daterange($from_date,$to_date);
                $amtData = [];
                foreach ($lastMonth as $day) {
                    $amtData['lables'][] = $day;
                    $amtData['data'][] = !empty($array[$day]) ? (int)$array[$day] : 0;
                }

				
            } else {
                /*$amounts = StudentTransactions:: select(
                            DB::raw("to_char(created_at,'Mon') as mon"),
                            DB::raw("extract(year from created_at) as yyyy"),
                            DB::raw("CONCAT(to_char(created_at,'Mon') ,' ',extract(year from created_at)) as mdate"),
                            DB::raw("sum(NULLIF(amount,0)) as total")
                        )
                        ->whereRaw("created_at >= '".$from_date."'::date")
                        ->whereRaw("created_at < '".date('Y-m-d',strtotime('+1 day', strtotime($to_date))) ."'::date")
                        ->groupBy(DB::raw('1,2'))->pluck('total','mdate')->toArray();


                $lastYear = $this->monthRange($from_date,$to_date);
                $amtData = [];
                foreach ($lastYear as $day) {
                    $amtData['lables'][] = $day;
                    $amtData['data'][] = !empty($amounts[$day]) ? (int)$amounts[$day] : 0;
                }*/
				
				$bookingsData=StudentLessonsBooking:: select(
                    DB::raw("to_char(lession_date, 'Mon') as mon"),
					DB::raw("extract(year from lession_date) as yyyy"),
					DB::raw("CONCAT(to_char(lession_date,'Mon') ,' ',extract(year from lession_date)) as mdate"),
                    DB::raw("service_id"),
                )
                ->whereRaw("lession_date >= '".$from_date."'::date")
                ->whereRaw("lession_date < '".date('Y-m-d',strtotime('+1 day', strtotime($to_date))) ."'::date")
				->whereIn('status',["completed", "student_not_show", "csd"])
				->whereNotIn('service_id', [env('ONEPAGE_SERVICE_ID'), env('REGISTRATION_SERVICE_ID')])
				->get()
				->toArray();
				$amounts = '';
				$tax = Settings::getSettings('tax');
				$amtData = $serviceArray = $array = [];
				if(!empty($bookingsData)) {
					foreach ($bookingsData as $booking) {
						$date = $booking['date'];
						$service_id = $booking['service_id'];
						if(!in_array($service_id, $serviceArray)) {
							$product = Services::where('id', $service_id)->first();
							$is_point_ststem_service = $product->is_system_service;
							$lessons = $product->available_lessons;
							$amount = $product->price + (($product->price*$tax / 100));
							$serviceArray[$service_id] = array('is_point_ststem_service' => $is_point_ststem_service, 'amount' => $amount, 'lessons' => $lessons);
						}
						
						
						
						if($serviceArray[$service_id]['is_point_ststem_service'] == 1) {
								$amount = $serviceArray[$service_id]['amount'];
						} else {
							$lessons = $lessons > 0 ? $lessons : 1;
							$amount = $serviceArray[$service_id]['amount'] / $lessons;
						}
						if(isset($array[$date])) {
							$array[$date] = $array[$date] + $amount;
						} else {
							$array[$date] = $amount;
						}
						/*$amtData['lables'][] = $date;
						$amtData['data'][] = $amount > 0 ? (int)$amount : 0;*/
					}
				}
				//echo '<pre>';print_r($array);exit;
				$stDate = date('Y-m')."-01";
                $lastYear = $this->monthRange($from_date,$to_date);
                $amtData = [];
                foreach ($lastYear as $day) {
                    $amtData['lables'][] = $day;
                    $amtData['data'][] = !empty($array[$day]) ? (int)$array[$day] : 0;
                }
            }
        } else {
            if (!empty($filter) && $filter == 'm') {
                $date = date('Y-m', strtotime(today()));

                /*$amounts=StudentTransactions:: select(
                    DB::raw("to_char(created_at, 'DD Mon') as date"),
                    DB::raw("sum(NULLIF(amount,0)) as total")
                )
                ->whereRaw("to_char(created_at, 'YYYY-MM') like '" . $date . "'")
                ->groupBy('date')->pluck('total','date')->toArray();

                $stDate = date('Y-m')."-01";
                $lastMonth = $this->daterange($stDate,$today);
                $amtData = [];

                foreach ($lastMonth as $day) {
                    $amtData['lables'][] = $day;
                    $amtData['data'][] = !empty($amounts[$day]) ? (int)$amounts[$day] : 0;
                }*/
				
				$bookingsData=StudentLessonsBooking:: select(
                    DB::raw("to_char(lession_date, 'DD Mon') as date"),
                    DB::raw("service_id"),
                )
                ->whereRaw("to_char(lession_date, 'YYYY-MM') like '" . $date . "'")
				->whereIn('status',["completed", "student_not_show", "csd"])
				->whereNotIn('service_id', [env('ONEPAGE_SERVICE_ID'), env('REGISTRATION_SERVICE_ID')])
				->get()
				->toArray();
				$amounts = '';
				$tax = Settings::getSettings('tax');
				$amtData = $serviceArray = $array = [];
				if(!empty($bookingsData)) {
					foreach ($bookingsData as $booking) {
						$date = $booking['date'];
						$service_id = $booking['service_id'];
						if(!in_array($service_id, $serviceArray)) {
							$product = Services::where('id', $service_id)->first();
							$is_point_ststem_service = $product->is_system_service;
							$lessons = $product->available_lessons;
							$amount = $product->price + (($product->price*$tax / 100));
							$serviceArray[$service_id] = array('is_point_ststem_service' => $is_point_ststem_service, 'amount' => $amount, 'lessons' => $lessons);
						}
						
						
						
						if($serviceArray[$service_id]['is_point_ststem_service'] == 1) {
								$amount = $serviceArray[$service_id]['amount'];
						} else {
							$lessons = $lessons > 0 ? $lessons : 1;
							$amount = $serviceArray[$service_id]['amount'] / $lessons;
						}
						if(isset($array[$date])) {
							$array[$date] = $array[$date] + $amount;
						} else {
							$array[$date] = $amount;
						}
						/*$amtData['lables'][] = $date;
						$amtData['data'][] = $amount > 0 ? (int)$amount : 0;*/
					}
				}
				//echo '<pre>';print_r($array);exit;
				$stDate = date('Y-m')."-01";
				$lastDateOfThisMonth =strtotime('last day of this month') ;
				$last_day = date('Y-m-d', $lastDateOfThisMonth);
                $lastMonth = $this->daterange($stDate,$last_day);
                $amtData = [];
                foreach ($lastMonth as $day) {
                    $amtData['lables'][] = $day;
                    $amtData['data'][] = !empty($array[$day]) ? (int)$array[$day] : 0;
                }

            } elseif (!empty($filter) && $filter == 'd') {

                /*$date = date('Y-m-d', strtotime(today()));

                $amounts = StudentTransactions::select(
                                    DB::raw("to_char(created_at, 'DD Mon YYYY') as date"),
                                    DB::raw("sum(NULLIF(amount,0)) as total")
                                )
                                ->whereRaw("to_char(created_at, 'YYYY-MM-DD') like '" . $date . "'")
                                ->groupBy('date')->get()->toArray();

                $amtData = [];
                $amtData['lables'][] = date('d M Y');
                $amtData['data'][] = !empty($amounts[0]['total']) ? (int)$amounts[0]['total'] : 0;*/
				$today = date('Y-m-d', strtotime(today()));
				$bookingsData=StudentLessonsBooking:: select(
                    DB::raw("to_char(lession_date, 'DD Mon YYYY') as date"),
                    DB::raw("service_id"),
                )
                ->whereRaw("to_char(lession_date, 'YYYY-MM-DD') like '" . $today . "'")
				->whereIn('status',["completed", "student_not_show", "csd"])
				->whereNotIn('service_id', [env('ONEPAGE_SERVICE_ID'), env('REGISTRATION_SERVICE_ID')])
				->get()
				->toArray();
				$amounts = '';
				$tax = Settings::getSettings('tax');
				$amtData = $serviceArray = $array = [];
				if(!empty($bookingsData)) {
					foreach ($bookingsData as $booking) {
						$date = $booking['date'];
						$service_id = $booking['service_id'];
						if(!in_array($service_id, $serviceArray)) {
							$product = Services::where('id', $service_id)->first();
							$is_point_ststem_service = $product->is_system_service;
							$lessons = $product->available_lessons;
							$amount = $product->price + (($product->price*$tax / 100));
							$serviceArray[$service_id] = array('is_point_ststem_service' => $is_point_ststem_service, 'amount' => $amount, 'lessons' => $lessons);
						}
						
						
						
						if($serviceArray[$service_id]['is_point_ststem_service'] == 1) {
								$amount = $serviceArray[$service_id]['amount'];
						} else {
							$lessons = $lessons > 0 ? $lessons : 1;
							$amount = $serviceArray[$service_id]['amount'] / $lessons;
						}
						if(isset($array[$date])) {
							$array[$date] = $array[$date] + $amount;
						} else {
							$array[$date] = $amount;
						}
						/*$amtData['lables'][] = $date;
						$amtData['data'][] = $amount > 0 ? (int)$amount : 0;*/
					}
				}
				//echo '<pre>';print_r($array);exit;
				
                    $amtData['lables'][] = $today;
                    $amtData['data'][] = !empty($array[$today]) ? (int)$array[$today] : 0;
               


            } elseif (!empty($filter) && $filter == 'y') {
                /*$amounts = StudentTransactions:: select(
                            DB::raw("to_char(created_at,'Mon') as mon"),
                            DB::raw("extract(year from created_at) as yyyy"),
                            DB::raw("CONCAT(to_char(created_at,'Mon') ,' ',extract(year from created_at)) as mdate"),
                            DB::raw("sum(NULLIF(amount,0)) as total")
                        )
                        ->whereRaw("date_part('year', created_at) = date_part('year', CURRENT_DATE)")
                        ->groupBy(DB::raw('1,2'))->pluck('total','mdate')->toArray();

                $stDate = date('Y')."-01-01";
                $lastYear = $this->monthRange($stDate);

                $amtData = [];
                foreach ($lastYear as $day) {
                    $amtData['lables'][] = $day;
                    $amtData['data'][] = !empty($amounts[$day]) ? (int)$amounts[$day] : 0;
                }*/
				
				$bookingsData=StudentLessonsBooking:: select(
                    DB::raw("to_char(lession_date, 'Mon') as mon"),
                    DB::raw("service_id"),
					DB::raw("extract(year from lession_date) as yyyy"),
                    DB::raw("CONCAT(to_char(lession_date,'Mon') ,' ',extract(year from lession_date)) as mdate"),
                )
                ->whereRaw("date_part('year', lession_date) = date_part('year', CURRENT_DATE)")
				->whereIn('status',["completed", "student_not_show", "csd"])
				->whereNotIn('service_id', [env('ONEPAGE_SERVICE_ID'), env('REGISTRATION_SERVICE_ID')])				
				->get()
				->toArray();
				//echo '<pre>';print_r($bookingsData);exit;
				$amounts = '';
				$tax = Settings::getSettings('tax');
				$amtData = $serviceArray = $array = [];
				if(!empty($bookingsData)) {
					foreach ($bookingsData as $booking) {
						$date = $booking['mdate'];
						$service_id = $booking['service_id'];
						if(!in_array($service_id, $serviceArray)) {
							$product = Services::where('id', $service_id)->first();
							$is_point_ststem_service = $product->is_system_service;
							$lessons = $product->available_lessons > 0 ? $product->available_lessons : 1;
							$amount = $product->price + (($product->price*$tax / 100));
							$serviceArray[$service_id] = array('is_point_ststem_service' => $is_point_ststem_service, 'amount' => $amount, 'lessons' => $lessons);
						}
						
						
						
						if($serviceArray[$service_id]['is_point_ststem_service'] == 1) {
								$amount = $serviceArray[$service_id]['amount'];
						} else {
							$lessons = $lessons > 0 ? $lessons : 1;
							$amount = $serviceArray[$service_id]['amount'] / $lessons;
						}
						if(isset($array[$date])) {
							$array[$date] = $array[$date] + $amount;
						} else {
							$array[$date] = $amount;
						}
						/*$amtData['lables'][] = $date;
						$amtData['data'][] = $amount > 0 ? (int)$amount : 0;*/
					}
				}
				
				$stDate = date('Y')."-01-01";
                $lastYear = $this->monthRange($stDate);
                $amtData = [];
                foreach ($lastYear as $day) {
                    $amtData['lables'][] = $day;
                    $amtData['data'][] = !empty($array[$day]) ? (int)$array[$day] : 0;
                }

            } else {
                /*$amounts=StudentTransactions:: select(
                                            DB::raw("to_char(created_at, 'DD Mon') as date"),
                                            DB::raw("sum(NULLIF(amount,0)) as total")
                                        )
                                        ->whereRaw("to_char(created_at, 'YYYY-MM-DD') between '" . $last_date . "' and'" . $today . "'")
                                        ->groupBy('date')->pluck('total','date')->toArray();
				$lastWeek = $this->daterange($last_date,$today);
                $amtData = [];
                foreach ($lastWeek as $day) {
                    $amtData['lables'][] = $day;
                    $amtData['data'][] = !empty($amounts[$day]) ? (int)$amounts[$day] : 0;
                }*/
				
				$bookingsData=StudentLessonsBooking:: select(
                    DB::raw("to_char(lession_date, 'DD Mon') as date"),
                    DB::raw("service_id"),
                )
                ->whereRaw("to_char(lession_date, 'YYYY-MM-DD') between '" . $last_date . "' and'" . $today . "'")
				->whereIn('status',["completed", "student_not_show", "csd"])
				->whereNotIn('service_id', [env('ONEPAGE_SERVICE_ID'), env('REGISTRATION_SERVICE_ID')])
				->get()
				->toArray();
				$amounts = '';
				$tax = Settings::getSettings('tax');
				$amtData = $serviceArray = $array = [];
				if(!empty($bookingsData)) {
					foreach ($bookingsData as $booking) {
						$date = $booking['date'];
						$service_id = $booking['service_id'];
						if(!in_array($service_id, $serviceArray)) {
							$product = Services::where('id', $service_id)->first();
							$is_point_ststem_service = $product->is_system_service;
							$lessons = $product->available_lessons;
							$amount = $product->price + (($product->price*$tax / 100));
							$serviceArray[$service_id] = array('is_point_ststem_service' => $is_point_ststem_service, 'amount' => $amount, 'lessons' => $lessons);
						}
						
						
						
						if($serviceArray[$service_id]['is_point_ststem_service'] == 1) {
								$amount = $serviceArray[$service_id]['amount'];
						} else {
							$lessons = $lessons > 0 ? $lessons : 1;
							$amount = $serviceArray[$service_id]['amount'] / $lessons;
						}
						if(isset($array[$date])) {
							$array[$date] = $array[$date] + $amount;
						} else {
							$array[$date] = $amount;
						}
						/*$amtData['lables'][] = $date;
						$amtData['data'][] = $amount > 0 ? (int)$amount : 0;*/
					}
				}
				
				$lastWeek = $this->daterange($last_date,$today);
                $amtData = [];
                foreach ($lastWeek as $day) {
                    $amtData['lables'][] = $day;
                    $amtData['data'][] = !empty($array[$day]) ? (int)$array[$day] : 0;
                }
				
				//echo '<pre>';print_r($amtData);exit;

                
            }
        }

        return view('admin.reports.amount.index', compact('amounts','filter','option','amtData','from_date','to_date','sort'));
    }

    private function totalAmountSpentPerStudent($input = array()){
        $filter = !empty($input['filter']) ? $input['filter'] : '';
        $option = !empty($input['opt']) ? $input['opt'] : '';
        $sort   = !empty($input['sort']) ? $input['sort'] : '';
        $last_date = date('Y-m-d', strtotime('-6 days'));
        $today = date('Y-m-d', strtotime(today()));
        $user_id = !empty($input['user_id']) ? $input['user_id'] : '';

        $from_date = !empty($input['from_date']) ? $input['from_date'] : '';
        $to_date   = !empty($input['to_date']) ? $input['to_date'] : '';

        $users = User::select('users.id', 'users.firstname', 'users.lastname')
					->where('user_type','student')
					->join('student_lessons', 'users.id', 'student_lessons.user_id')
					->whereRaw("student_lessons.expire_date >= '".date('Y-m-d')."'")
					->whereNotIn('student_lessons.service_id', [env('ONEPAGE_SERVICE_ID'), env('REGISTRATION_SERVICE_ID')])
					->where('users.status',1)
					->orderBy('firstname')
					->get()
					->toArray();
        if(!$user_id){
            $user_id = current($users)['id'];
        }

        if(!empty($from_date) && !empty($to_date)){
            $filter = '';
            $bdays = $this->dateDiff($from_date, $to_date);

            if($bdays >= 0 && $bdays < 31){
                /*$amounts=StudentTransactions:: select(
                    DB::raw("to_char(created_at, 'DD Mon') as date"),
                    DB::raw("sum(NULLIF(amount,0)) as total")
                )
                ->whereRaw("created_at >= '".$from_date."'::date")
                ->whereRaw("created_at < '".date('Y-m-d',strtotime('+1 day', strtotime($to_date))) ."'::date")
                ->where('user_id', $user_id)
                ->groupBy('date')->pluck('total','date')->toArray();

                $lastMonth = $this->daterange($from_date,$to_date);
                $amtData = [];
                foreach ($lastMonth as $day) {
                    $amtData['lables'][] = 	$day;
                    $amtData['data'][] = !empty($amounts[$day]) ? (int)$amounts[$day] : 0;
                }*/
				$bookingsData=StudentLessonsBooking:: select(
                    DB::raw("to_char(lession_date, 'DD Mon') as date"),
                    DB::raw("service_id"),
                )
                ->whereRaw("lession_date >= '".$from_date."'::date")
                ->whereRaw("lession_date < '".date('Y-m-d',strtotime('+1 day', strtotime($to_date))) ."'::date")
                ->where('user_id', $user_id)
				->whereIn('status',["completed", "student_not_show", "csd"])
				->whereNotIn('service_id', [env('ONEPAGE_SERVICE_ID'), env('REGISTRATION_SERVICE_ID')])
				->get()
				->toArray();
				
				$amounts = '';
				$tax = Settings::getSettings('tax');
				$amtData = $serviceArray = $array = [];
				if(!empty($bookingsData)) {
					foreach ($bookingsData as $booking) {
						$date = $booking['date'];
						$service_id = $booking['service_id'];
						if(!in_array($service_id, $serviceArray)) {
							$product = Services::where('id', $service_id)->first();
							$is_point_ststem_service = $product->is_system_service;
							$lessons = $product->available_lessons;
							$amount = $product->price + (($product->price*$tax / 100));
							$serviceArray[$service_id] = array('is_point_ststem_service' => $is_point_ststem_service, 'amount' => $amount, 'lessons' => $lessons);
						}
						
						
						
						if($serviceArray[$service_id]['is_point_ststem_service'] == 1) {
								$amount = $serviceArray[$service_id]['amount'];
						} else {
							$lessons = $lessons > 0 ? $lessons : 1;
							$amount = $serviceArray[$service_id]['amount'] / $lessons;
						}
						if(isset($array[$date])) {
							$array[$date] = $array[$date] + $amount;
						} else {
							$array[$date] = $amount;
						}
						/*$amtData['lables'][] = $date;
						$amtData['data'][] = $amount > 0 ? (int)$amount : 0;*/
					}
				}
				
				 $lastMonth = $this->daterange($from_date,$to_date);
                $amtData = [];
                foreach ($lastMonth as $day) {
                    $amtData['lables'][] = $day;
                    $amtData['data'][] = !empty($array[$day]) ? (int)$array[$day] : 0;
                }
            } else {
                /*$amounts = StudentTransactions:: select(
                            DB::raw("to_char(created_at,'Mon') as mon"),
                            DB::raw("extract(year from created_at) as yyyy"),
                            DB::raw("CONCAT(to_char(created_at,'Mon') ,' ',extract(year from created_at)) as mdate"),
                            DB::raw("sum(NULLIF(amount,0)) as total")
                        )
                        ->whereRaw("created_at >= '".$from_date."'::date")
                        ->whereRaw("created_at < '".date('Y-m-d',strtotime('+1 day', strtotime($to_date))) ."'::date")
                        ->where('user_id', $user_id)
                        ->groupBy(DB::raw('1,2'))->pluck('total','mdate')->toArray();

                $lastYear = $this->monthRange($from_date,$to_date);
                $amtData = [];
                foreach ($lastYear as $day) {
                    $amtData['lables'][] = $day;
                    $amtData['data'][] = !empty($amounts[$day]) ? (int)$amounts[$day] : 0;
                }*/
				
				$bookingsData=StudentLessonsBooking:: select(
                    DB::raw("to_char(lession_date, 'Mon') as mon"),
					DB::raw("extract(year from lession_date) as yyyy"),
					DB::raw("CONCAT(to_char(lession_date,'Mon') ,' ',extract(year from lession_date)) as mdate"),
                    DB::raw("service_id"),
                )
                ->whereRaw("lession_date >= '".$from_date."'::date")
                ->whereRaw("lession_date < '".date('Y-m-d',strtotime('+1 day', strtotime($to_date))) ."'::date")
				->where('user_id', $user_id)
				->whereIn('status',["completed", "student_not_show", "csd"])
				->whereNotIn('service_id', [env('ONEPAGE_SERVICE_ID'), env('REGISTRATION_SERVICE_ID')])
				->get()
				->toArray();
				$amounts = '';
				$tax = Settings::getSettings('tax');
				$amtData = $serviceArray = $array = [];
				if(!empty($bookingsData)) {
					foreach ($bookingsData as $booking) {
						$date = $booking['date'];
						$service_id = $booking['service_id'];
						if(!in_array($service_id, $serviceArray)) {
							$product = Services::where('id', $service_id)->first();
							$is_point_ststem_service = $product->is_system_service;
							$lessons = $product->available_lessons;
							$amount = $product->price + (($product->price*$tax / 100));
							$serviceArray[$service_id] = array('is_point_ststem_service' => $is_point_ststem_service, 'amount' => $amount, 'lessons' => $lessons);
						}
						
						
						
						if($serviceArray[$service_id]['is_point_ststem_service'] == 1) {
								$amount = $serviceArray[$service_id]['amount'];
						} else {
							$lessons = $lessons > 0 ? $lessons : 1;
							$amount = $serviceArray[$service_id]['amount'] / $lessons;
						}
						if(isset($array[$date])) {
							$array[$date] = $array[$date] + $amount;
						} else {
							$array[$date] = $amount;
						}
						/*$amtData['lables'][] = $date;
						$amtData['data'][] = $amount > 0 ? (int)$amount : 0;*/
					}
				}
				//echo '<pre>';print_r($array);exit;
				$stDate = date('Y-m')."-01";
                $lastYear = $this->monthRange($from_date,$to_date);
                $amtData = [];
                foreach ($lastYear as $day) {
                    $amtData['lables'][] = $day;
                    $amtData['data'][] = !empty($array[$day]) ? (int)$array[$day] : 0;
                }
            }
        } else {
            if (!empty($filter) && $filter == 'm') {
                $date = date('Y-m', strtotime(today()));

                /*$amounts=StudentTransactions:: select(
                    DB::raw("to_char(created_at, 'DD Mon') as date"),
                    DB::raw("sum(NULLIF(amount,0)) as total")
                )
                ->whereRaw("to_char(created_at, 'YYYY-MM') like '" . $date . "'")
                ->where('user_id', $user_id)
                ->groupBy('date')->pluck('total','date')->toArray();

                $stDate = date('Y-m')."-01";
                $lastMonth = $this->daterange($stDate,$today);
                $amtData = [];
                foreach ($lastMonth as $day) {
                    $amtData['lables'][] = $day;
                    $amtData['data'][] = !empty($amounts[$day]) ? (int)$amounts[$day] : 0;
                }*/
				
				$bookingsData=StudentLessonsBooking:: select(
                    DB::raw("to_char(lession_date, 'DD Mon') as date"),
                    DB::raw("service_id"),
                )
                ->whereRaw("to_char(lession_date, 'YYYY-MM') like '" . $date . "'")
                ->where('user_id', $user_id)
				->whereIn('status',["completed", "student_not_show", "csd"])
				->whereNotIn('service_id', [env('ONEPAGE_SERVICE_ID'), env('REGISTRATION_SERVICE_ID')])
				->get()
				->toArray();
				$amounts = '';
				$tax = Settings::getSettings('tax');
				$amtData = $serviceArray = $array = [];
				if(!empty($bookingsData)) {
					foreach ($bookingsData as $booking) {
						$date = $booking['date'];
						$service_id = $booking['service_id'];
						if(!in_array($service_id, $serviceArray)) {
							$product = Services::where('id', $service_id)->first();
							$is_point_ststem_service = $product->is_system_service;
							$lessons = $product->available_lessons;
							$amount = $product->price + (($product->price*$tax / 100));
							$serviceArray[$service_id] = array('is_point_ststem_service' => $is_point_ststem_service, 'amount' => $amount, 'lessons' => $lessons);
						}
						
						
						
						if($serviceArray[$service_id]['is_point_ststem_service'] == 1) {
								$amount = $serviceArray[$service_id]['amount'];
						} else {
							$lessons = $lessons > 0 ? $lessons : 1;
							$amount = $serviceArray[$service_id]['amount'] / $lessons;
						}
						if(isset($array[$date])) {
							$array[$date] = $array[$date] + $amount;
						} else {
							$array[$date] = $amount;
						}
						/*$amtData['lables'][] = $date;
						$amtData['data'][] = $amount > 0 ? (int)$amount : 0;*/
					}
				}
				//echo '<pre>';print_r($array);exit;
				$stDate = date('Y-m')."-01";
				
				$lastDateOfThisMonth =strtotime('last day of this month') ;
				$last_day = date('Y-m-d', $lastDateOfThisMonth);
				
                $lastMonth = $this->daterange($stDate,$last_day);
                $amtData = [];
                foreach ($lastMonth as $day) {
                    $amtData['lables'][] = $day;
                    $amtData['data'][] = !empty($array[$day]) ? (int)$array[$day] : 0;
                }

            } elseif (!empty($filter) && $filter == 'd') {

                /*$date = date('Y-m-d', strtotime(today()));

                $amounts = StudentTransactions::select(
                                    DB::raw("to_char(created_at, 'DD Mon YYYY') as date"),
                                    DB::raw("sum(NULLIF(amount,0)) as total")
                                )
                                ->whereRaw("to_char(created_at, 'YYYY-MM-DD') like '" . $date . "'")
                                ->where('user_id', $user_id)
                                ->groupBy('date')->get()->toArray();

                $amtData = [];
                $amtData['lables'][] = date('d M Y');
                $amtData['data'][] = !empty($amounts[0]['total']) ? (int)$amounts[0]['total'] : 0;*/
				
				$today = date('Y-m-d', strtotime(today()));
				$bookingsData=StudentLessonsBooking:: select(
                    DB::raw("to_char(lession_date, 'DD Mon YYYY') as date"),
                    DB::raw("service_id"),
                )
                ->whereRaw("to_char(lession_date, 'YYYY-MM-DD') like '" . $today . "'")
                ->where('user_id', $user_id)
				->whereIn('status',["completed", "student_not_show", "csd"])
				->whereNotIn('service_id', [env('ONEPAGE_SERVICE_ID'), env('REGISTRATION_SERVICE_ID')])
				->get()
				->toArray();
				$amounts = '';
				$tax = Settings::getSettings('tax');
				$amtData = $serviceArray = $array = [];
				if(!empty($bookingsData)) {
					foreach ($bookingsData as $booking) {
						$date = $booking['date'];
						$service_id = $booking['service_id'];
						if(!in_array($service_id, $serviceArray)) {
							$product = Services::where('id', $service_id)->first();
							$is_point_ststem_service = $product->is_system_service;
							$lessons = $product->available_lessons;
							$amount = $product->price + (($product->price*$tax / 100));
							$serviceArray[$service_id] = array('is_point_ststem_service' => $is_point_ststem_service, 'amount' => $amount, 'lessons' => $lessons);
						}
						
						
						
						if($serviceArray[$service_id]['is_point_ststem_service'] == 1) {
								$amount = $serviceArray[$service_id]['amount'];
						} else {
							$lessons = $lessons > 0 ? $lessons : 1;
							$amount = $serviceArray[$service_id]['amount'] / $lessons;
						}
						if(isset($array[$date])) {
							$array[$date] = $array[$date] + $amount;
						} else {
							$array[$date] = $amount;
						}
					}
				}
				//echo '<pre>';print_r($array);exit;
				
                    $amtData['lables'][] = $today;
                    $amtData['data'][] = !empty($array[$today]) ? (int)$array[$today] : 0;


            } elseif (!empty($filter) && $filter == 'y') {
                /*$amounts = StudentTransactions:: select(
                            DB::raw("to_char(created_at,'Mon') as mon"),
                            DB::raw("extract(year from created_at) as yyyy"),
                            DB::raw("CONCAT(to_char(created_at,'Mon') ,' ',extract(year from created_at)) as mdate"),
                            DB::raw("sum(NULLIF(amount,0)) as total")
                        )
                        ->whereRaw("date_part('year', created_at) = date_part('year', CURRENT_DATE)")
                        ->where('user_id', $user_id)
                        ->groupBy(DB::raw('1,2'))->pluck('total','mdate')->toArray();

                $stDate = date('Y')."-01-01";
                $lastYear = $this->monthRange($stDate);

                $amtData = [];
                foreach ($lastYear as $day) {
                    $amtData['lables'][] = $day;
                    $amtData['data'][] = !empty($amounts[$day]) ? (int)$amounts[$day] : 0;
                }*/
				
				$bookingsData=StudentLessonsBooking:: select(
                    DB::raw("to_char(lession_date, 'Mon') as mon"),
                    DB::raw("service_id"),
					DB::raw("extract(year from lession_date) as yyyy"),
                    DB::raw("CONCAT(to_char(lession_date,'Mon') ,' ',extract(year from lession_date)) as mdate"),
                )
                ->whereRaw("date_part('year', lession_date) = date_part('year', CURRENT_DATE)")
                ->where('user_id', $user_id)
				->whereIn('status',["completed", "student_not_show", "csd"])
				->whereNotIn('service_id', [env('ONEPAGE_SERVICE_ID'), env('REGISTRATION_SERVICE_ID')])				
				->get()
				->toArray();
				//echo '<pre>';print_r($bookingsData);exit;
				$amounts = '';
				$tax = Settings::getSettings('tax');
				$amtData = $serviceArray = $array = [];
				if(!empty($bookingsData)) {
					foreach ($bookingsData as $booking) {
						$date = $booking['mdate'];
						$service_id = $booking['service_id'];
						if(!in_array($service_id, $serviceArray)) {
							$product = Services::where('id', $service_id)->first();
							$is_point_ststem_service = $product->is_system_service;
							$lessons = $product->available_lessons > 0 ? $product->available_lessons : 1;
							$amount = $product->price + (($product->price*$tax / 100));
							$serviceArray[$service_id] = array('is_point_ststem_service' => $is_point_ststem_service, 'amount' => $amount, 'lessons' => $lessons);
						}
						
						
						
						if($serviceArray[$service_id]['is_point_ststem_service'] == 1) {
								$amount = $serviceArray[$service_id]['amount'];
						} else {
							$lessons = $lessons > 0 ? $lessons : 1;
							$amount = $serviceArray[$service_id]['amount'] / $lessons;
						}
						if(isset($array[$date])) {
							$array[$date] = $array[$date] + $amount;
						} else {
							$array[$date] = $amount;
						}
						/*$amtData['lables'][] = $date;
						$amtData['data'][] = $amount > 0 ? (int)$amount : 0;*/
					}
				}
				
				$stDate = date('Y')."-01-01";
                $lastYear = $this->monthRange($stDate);
                $amtData = [];
                foreach ($lastYear as $day) {
                    $amtData['lables'][] = $day;
                    $amtData['data'][] = !empty($array[$day]) ? (int)$array[$day] : 0;
                }

            } else {
                /*$amounts=StudentTransactions:: select(
                                            DB::raw("to_char(created_at, 'DD Mon') as date"),
                                            DB::raw("sum(NULLIF(amount,0)) as total")
                                        )
                                        ->whereRaw("to_char(created_at, 'YYYY-MM-DD') between '" . $last_date . "' and'" . $today . "'")
                                        ->where('user_id', $user_id)
                                        ->groupBy('date')->pluck('total','date')->toArray();

                $lastWeek = $this->daterange($last_date,$today);
                $amtData = [];
                foreach ($lastWeek as $day) {
                    $amtData['lables'][] = $day;
                    $amtData['data'][] = !empty($amounts[$day]) ? (int)$amounts[$day] : 0;
                }*/
				
				$bookingsData=StudentLessonsBooking:: select(
                    DB::raw("to_char(lession_date, 'DD Mon') as date"),
                    DB::raw("service_id"),
                )
                ->whereRaw("to_char(lession_date, 'YYYY-MM-DD') between '" . $last_date . "' and'" . $today . "'")
				->where('user_id', $user_id)
				->whereIn('status',["completed", "student_not_show", "csd"])
				->whereNotIn('service_id', [env('ONEPAGE_SERVICE_ID'), env('REGISTRATION_SERVICE_ID')])
				->get()
				->toArray();
				$amounts = '';
				$tax = Settings::getSettings('tax');
				$amtData = $serviceArray = $array = [];
				if(!empty($bookingsData)) {
					foreach ($bookingsData as $booking) {
						$date = $booking['date'];
						$service_id = $booking['service_id'];
						if(!in_array($service_id, $serviceArray)) {
							$product = Services::where('id', $service_id)->first();
							$is_point_ststem_service = $product->is_system_service;
							$lessons = $product->available_lessons;
							$amount = $product->price + (($product->price*$tax / 100));
							$serviceArray[$service_id] = array('is_point_ststem_service' => $is_point_ststem_service, 'amount' => $amount, 'lessons' => $lessons);
						}
						
						
						
						if($serviceArray[$service_id]['is_point_ststem_service'] == 1) {
								$amount = $serviceArray[$service_id]['amount'];
						} else {
							$lessons = $lessons > 0 ? $lessons : 1;
							$amount = $serviceArray[$service_id]['amount'] / $lessons;
						}
						if(isset($array[$date])) {
							$array[$date] = $array[$date] + $amount;
						} else {
							$array[$date] = $amount;
						}
						/*$amtData['lables'][] = $date;
						$amtData['data'][] = $amount > 0 ? (int)$amount : 0;*/
					}
				}
				
				$lastWeek = $this->daterange($last_date,$today);
                $amtData = [];
                foreach ($lastWeek as $day) {
                    $amtData['lables'][] = $day;
                    $amtData['data'][] = !empty($array[$day]) ? (int)$array[$day] : 0;
                }
            }
        }

        if(!$amtData){
            $amtData['lables'] = [];
            $amtData['data'] = [];
        }

        return view('admin.reports.amount.index', compact('amounts','filter','option','user_id','sort','amtData','users','from_date','to_date'));
    }

    private function totalAmountGenByTeachers($input = array()){
        $filter = !empty($input['filter']) ? $input['filter'] : '';
        $option = !empty($input['opt']) ? $input['opt'] : '';
        $sort   = !empty($input['sort']) ? $input['sort'] : '';
        $last_date = date('Y-m-d', strtotime('-6 days'));
        $today = date('Y-m-d', strtotime(today()));

        $from_date = !empty($input['from_date']) ? $input['from_date'] : '';
        $to_date   = !empty($input['to_date']) ? $input['to_date'] : '';

        if(!empty($from_date) && !empty($to_date)){
            $filter = '';
            $bdays = $this->dateDiff($from_date, $to_date);

            if($bdays >= 0 && $bdays < 31){
                $amounts=StudentLessonsBooking:: select(
                    DB::raw("to_char(lession_date, 'DD Mon') as date"),
                    DB::raw("sum(NULLIF(teacher_earnings,0)) as total")
                )
			
				->whereIn('status',["completed", "student_not_show", "csd"])
                ->whereRaw("lession_date >= '".$from_date."'::date")
                ->whereRaw("lession_date < '".date('Y-m-d',strtotime('+1 day', strtotime($to_date))) ."'::date")
                ->groupBy('date')->pluck('total','date')->toArray();

                $lastMonth = $this->daterange($from_date,$to_date);
                $amtData = [];
                foreach ($lastMonth as $day) {
                    $amtData['lables'][] = $day;
                    $amtData['data'][] = !empty($amounts[$day]) ? (int)$amounts[$day] : 0;
                }
            } else {
                $amounts = StudentLessonsBooking:: select(
                    DB::raw("to_char(lession_date,'Mon') as mon"),
                    DB::raw("extract(year from lession_date) as yyyy"),
                    DB::raw("CONCAT(to_char(lession_date,'Mon') ,' ',extract(year from lession_date)) as mdate"),
                    DB::raw("sum(NULLIF(teacher_earnings,0)) as total")
                )
                ->whereRaw("lession_date >= '".$from_date."'::date")
				->whereIn('status',["completed", "student_not_show", "csd"])
                ->whereRaw("lession_date < '".date('Y-m-d',strtotime('+1 day', strtotime($to_date))) ."'::date")
                ->groupBy(DB::raw('1,2'))->pluck('total','mdate')->toArray();

                $lastYear = $this->monthRange($from_date,$to_date);
                $amtData = [];
                foreach ($lastYear as $day) {
                    $amtData['lables'][] = $day;
                    $amtData['data'][] = !empty($amounts[$day]) ? (int)$amounts[$day] : 0;
                }
            }
        } else {
            if (!empty($filter) && $filter == 'm') {
                $date = date('Y-m', strtotime(today()));

                $amounts=StudentLessonsBooking:: select(
                    DB::raw("to_char(lession_date, 'DD Mon') as date"),
                    DB::raw("sum(NULLIF(teacher_earnings,0)) as total")
                )
                ->whereRaw("to_char(lession_date, 'YYYY-MM') like '" . $date . "'")
				->whereIn('status',["completed", "student_not_show", "csd"])
                ->groupBy('date')->pluck('total','date')->toArray();

                $stDate = date('Y-m')."-01";
				
				$lastDateOfThisMonth =strtotime('last day of this month') ;
				$last_day = date('Y-m-d', $lastDateOfThisMonth);
				
                $lastMonth = $this->daterange($stDate,$last_day);
                $amtData = [];
                foreach ($lastMonth as $day) {
                    $amtData['lables'][] = $day;
                    $amtData['data'][] = !empty($amounts[$day]) ? (int)$amounts[$day] : 0;
                }

            } elseif (!empty($filter) && $filter == 'd') {

                $date = date('Y-m-d', strtotime(today()));

                $amounts = StudentLessonsBooking::select(
                                    DB::raw("to_char(lession_date, 'DD Mon YYYY') as date"),
                                    DB::raw("sum(NULLIF(teacher_earnings,0)) as total")
                                )
                                ->whereRaw("to_char(lession_date, 'YYYY-MM-DD') like '" . $date . "'")
								->whereIn('status',["completed", "student_not_show", "csd"])
                                ->groupBy('date')->get()->toArray();

                $amtData = [];
                $amtData['lables'][] = date('d M Y');
                $amtData['data'][] = !empty($amounts[0]['total']) ? (int)$amounts[0]['total'] : 0;


            } elseif (!empty($filter) && $filter == 'y') {
                $amounts = StudentLessonsBooking:: select(
                            DB::raw("to_char(lession_date,'Mon') as mon"),
                            DB::raw("extract(year from lession_date) as yyyy"),
                            DB::raw("CONCAT(to_char(lession_date,'Mon') ,' ',extract(year from lession_date)) as mdate"),
                            DB::raw("sum(NULLIF(teacher_earnings,0)) as total")
                        )
                        ->whereRaw("date_part('year', lession_date) = date_part('year', CURRENT_DATE)")
						->whereIn('status',["completed", "student_not_show", "csd"])
                        ->groupBy(DB::raw('1,2'))->pluck('total','mdate')->toArray();

                $stDate = date('Y')."-01-01";
                $lastYear = $this->monthRange($stDate);

                $amtData = [];
                foreach ($lastYear as $day) {
                    $amtData['lables'][] = $day;
                    $amtData['data'][] = !empty($amounts[$day]) ? (int)$amounts[$day] : 0;
                }

            } else {
                $amounts=StudentLessonsBooking:: select(
                                            DB::raw("to_char(lession_date, 'DD Mon') as date"),
                                            DB::raw("sum(NULLIF(teacher_earnings,0)) as total")
                                        )
                                        ->whereRaw("lession_date >= '".$last_date."'::date")
                                        ->whereRaw("lession_date < '".date('Y-m-d',strtotime('+1 day', strtotime($today))) ."'::date")
										->whereIn('status',["completed", "student_not_show", "csd"])
                                        // ->whereRaw("to_char(lession_date, 'YYYY-MM-DD') between '" . $last_date . "' and'" . $today . "'")
                                        ->groupBy('date')->pluck('total','date')->toArray();

                $lastWeek = $this->daterange($last_date,$today);
                $amtData = [];
                foreach ($lastWeek as $day) {
                    $amtData['lables'][] = $day;
                    $amtData['data'][] = !empty($amounts[$day]) ? (int)$amounts[$day] : 0;
                }
            }
        }

        return view('admin.reports.amount.index', compact('amounts','filter','option','sort','amtData','from_date','to_date'));
    }

    private function totalAmountGenPerTeacher($input = array()){
        $filter = !empty($input['filter']) ? $input['filter'] : '';
        $option = !empty($input['opt']) ? $input['opt'] : '';
        $sort   = !empty($input['sort']) ? $input['sort'] : '';
        $last_date = date('Y-m-d', strtotime('-6 days'));
        $today = date('Y-m-d', strtotime(today()));
        $user_id = !empty($input['user_id']) ? $input['user_id'] : '';

        $users = User::where('user_type','teacher')->where('status',1)->get()->toArray();

        if(!$user_id){
            $user_id = current($users)['id'];
        }

        $from_date = !empty($input['from_date']) ? $input['from_date'] : '';
        $to_date   = !empty($input['to_date']) ? $input['to_date'] : '';

        if(!empty($from_date) && !empty($to_date)){
            $filter = '';
            $bdays = $this->dateDiff($from_date, $to_date);

            if($bdays >= 0 && $bdays < 31){
                $amounts=StudentLessonsBooking:: select(
                    DB::raw("to_char(lession_date, 'DD Mon') as date"),
                    DB::raw("sum(NULLIF(teacher_earnings,0)) as total")
                )
                ->whereRaw("lession_date >= '".$from_date."'::date")
                ->whereRaw("lession_date < '".date('Y-m-d',strtotime('+1 day', strtotime($to_date))) ."'::date")
                ->where('teacher_id', $user_id)
				->whereIn('status',["completed", "student_not_show", "csd"])
                ->groupBy('date')->pluck('total','date')->toArray();

                $lastMonth = $this->daterange($from_date,$to_date);
                $amtData = [];
                foreach ($lastMonth as $day) {
                    $amtData['lables'][] = $day;
                    $amtData['data'][] = !empty($amounts[$day]) ? (int)$amounts[$day] : 0;
                }
            } else {
                $amounts = StudentLessonsBooking:: select(
                    DB::raw("to_char(lession_date,'Mon') as mon"),
                    DB::raw("extract(year from lession_date) as yyyy"),
                    DB::raw("CONCAT(to_char(lession_date,'Mon') ,' ',extract(year from lession_date)) as mdate"),
                    DB::raw("sum(NULLIF(teacher_earnings,0)) as total")
                )
                ->whereRaw("lession_date >= '".$from_date."'::date")
                ->whereRaw("lession_date < '".date('Y-m-d',strtotime('+1 day', strtotime($to_date))) ."'::date")
                ->where('teacher_id', $user_id)
				->whereIn('status',["completed", "student_not_show", "csd"])
                ->groupBy(DB::raw('1,2'))->pluck('total','mdate')->toArray();

                $lastYear = $this->monthRange($from_date,$to_date);
                $amtData = [];
                foreach ($lastYear as $day) {
                    $amtData['lables'][] = $day;
                    $amtData['data'][] = !empty($amounts[$day]) ? (int)$amounts[$day] : 0;
                }
            }
        } else {
            if (!empty($filter) && $filter == 'm') {
                $date = date('Y-m', strtotime(today()));

                $amounts=StudentLessonsBooking:: select(
                    DB::raw("to_char(lession_date, 'DD Mon') as date"),
                    DB::raw("sum(NULLIF(teacher_earnings,0)) as total")
                )
                ->whereRaw("to_char(lession_date, 'YYYY-MM') like '" . $date . "'")
                ->where('teacher_id', $user_id)
				->whereIn('status',["completed", "student_not_show", "csd"])
                ->groupBy('date')->pluck('total','date')->toArray();

                $stDate = date('Y-m')."-01";
				
				$lastDateOfThisMonth =strtotime('last day of this month') ;
				$last_day = date('Y-m-d', $lastDateOfThisMonth);
				
                $lastMonth = $this->daterange($stDate,$last_day);
                $amtData = [];
                foreach ($lastMonth as $day) {
                    $amtData['lables'][] = $day;
                    $amtData['data'][] = !empty($amounts[$day]) ? (int)$amounts[$day] : 0;
                }

            } elseif (!empty($filter) && $filter == 'd') {

                $date = date('Y-m-d', strtotime(today()));

                $amounts = StudentLessonsBooking::select(
                                    DB::raw("to_char(lession_date, 'DD Mon YYYY') as date"),
                                    DB::raw("sum(NULLIF(teacher_earnings,0)) as total")
                                )
                                ->whereRaw("to_char(lession_date, 'YYYY-MM-DD') like '" . $date . "'")
                                ->where('teacher_id', $user_id)
								->whereIn('status',["completed", "student_not_show", "csd"])
                                ->groupBy('date')->get()->toArray();

                $amtData = [];
                $amtData['lables'][] = date('d M Y');
                $amtData['data'][] = !empty($amounts[0]['total']) ? (int)$amounts[0]['total'] : 0;


            } elseif (!empty($filter) && $filter == 'y') {
                $amounts = StudentLessonsBooking:: select(
                            DB::raw("to_char(lession_date,'Mon') as mon"),
                            DB::raw("extract(year from lession_date) as yyyy"),
                            DB::raw("CONCAT(to_char(lession_date,'Mon') ,' ',extract(year from lession_date)) as mdate"),
                            DB::raw("sum(NULLIF(teacher_earnings,0)) as total")
                        )
                        ->whereRaw("date_part('year', lession_date) = date_part('year', CURRENT_DATE)")
                        ->where('teacher_id', $user_id)
						->whereIn('status',["completed", "student_not_show", "csd"])
                        ->groupBy(DB::raw('1,2'))->pluck('total','mdate')->toArray();

                $stDate = date('Y')."-01-01";
                $lastYear = $this->monthRange($stDate);

                $amtData = [];
                foreach ($lastYear as $day) {
                    $amtData['lables'][] = $day;
                    $amtData['data'][] = !empty($amounts[$day]) ? (int)$amounts[$day] : 0;
                }

            } else {
                $amounts=StudentLessonsBooking:: select(
                                            DB::raw("to_char(lession_date, 'DD Mon') as date"),
                                            DB::raw("sum(NULLIF(teacher_earnings,0)) as total")
                                        )
                                        ->whereRaw("to_char(lession_date, 'YYYY-MM-DD') between '" . $last_date . "' and'" . $today . "'")
                                        ->where('teacher_id', $user_id)
										->whereIn('status',["completed", "student_not_show", "csd"])
                                        ->groupBy('date')->pluck('total','date')->toArray();

                $lastWeek = $this->daterange($last_date,$today);
                $amtData = [];
                foreach ($lastWeek as $day) {
                    $amtData['lables'][] = $day;
                    $amtData['data'][] = !empty($amounts[$day]) ? (int)$amounts[$day] : 0;
                }
            }
        }

        return view('admin.reports.amount.index', compact('amounts','filter','option','users','user_id','sort','amtData','from_date','to_date'));
    }

    private function totalHoursTaughtByTeachers($input = array()){
        $filter = !empty($input['filter']) ? $input['filter'] : '';
        $option = !empty($input['opt']) ? $input['opt'] : '';
        $sort   = !empty($input['sort']) ? $input['sort'] : '';
        $last_date = date('Y-m-d', strtotime('-6 days'));
        $today = date('Y-m-d', strtotime(today()));

        $from_date = !empty($input['from_date']) ? $input['from_date'] : '';
        $to_date   = !empty($input['to_date']) ? $input['to_date'] : '';

        if(!empty($from_date) && !empty($to_date)){
            $filter = '';
            $bdays = $this->dateDiff($from_date, $to_date);

            if($bdays >= 0 && $bdays < 31){
                $amounts = StudentLessonsBooking:: select(
                    DB::raw("to_char(lession_date, 'DD Mon') as date"),
                    DB::raw("sum(NULLIF(lesson_duration,0)) as total")
                )
                ->whereRaw("lession_date >= '".$from_date."'::date")
                ->whereRaw("lession_date < '".date('Y-m-d',strtotime('+1 day', strtotime($to_date))) ."'::date")
                //->where('status','completed')
				->whereIn('status',["completed", "student_not_show", "csd"])
                ->groupBy('date')->pluck('total','date')->toArray();

                $lastMonth = $this->daterange($from_date,$to_date);
                $amtData = [];
                foreach ($lastMonth as $day) {
                    $amtData['lables'][] = $day;
                    $amtData['data'][] = !empty($amounts[$day]) ? (int)$amounts[$day] : 0;
                }
            } else {
                $amounts = StudentLessonsBooking:: select(
                    DB::raw("to_char(lession_date,'Mon') as mon"),
                    DB::raw("extract(year from lession_date) as yyyy"),
                    DB::raw("CONCAT(to_char(lession_date,'Mon') ,' ',extract(year from lession_datelession_date)) as mdate"),
                    DB::raw("sum(NULLIF(lesson_duration,0)) as total")
                )
                ->whereRaw("lession_date >= '".$from_date."'::date")
                ->whereRaw("lession_date < '".date('Y-m-d',strtotime('+1 day', strtotime($to_date))) ."'::date")
                //->where('status','completed')
				->whereIn('status',["completed", "student_not_show", "csd"])
                ->groupBy(DB::raw('1,2'))->pluck('total','mdate')->toArray();

                $lastYear = $this->monthRange($from_date,$to_date);
                $amtData = [];
                foreach ($lastYear as $day) {
                    $amtData['lables'][] = $day;
                    $amtData['data'][] = !empty($amounts[$day]) ? (int)$amounts[$day] : 0;
                }
            }
        } else {
            if (!empty($filter) && $filter == 'm') {
                $date = date('Y-m', strtotime(today()));
                $amounts = StudentLessonsBooking:: select(
                            DB::raw("to_char(lession_date, 'DD Mon') as date"),
                            DB::raw("sum(NULLIF(lesson_duration,0)) as total")
                        )
                        ->whereRaw("to_char(lession_date, 'YYYY-MM') like '" . $date . "'")
                        //->where('status','completed')
						->whereIn('status',["completed", "student_not_show", "csd"])
                        ->groupBy('date')->pluck('total','date')->toArray();

                $stDate = date('Y-m')."-01";
				
				$lastDateOfThisMonth =strtotime('last day of this month') ;
				$last_day = date('Y-m-d', $lastDateOfThisMonth);
				
                $lastMonth = $this->daterange($stDate,$last_day);
                $amtData = [];
                foreach ($lastMonth as $day) {
                    $amtData['lables'][] = $day;
                    $amtData['data'][] = !empty($amounts[$day]) ? number_format(($amounts[$day]/60), 2) : 0;
                }
            } elseif (!empty($filter) && $filter == 'd') {
                $date = date('Y-m-d', strtotime(today()));
                $amounts = StudentLessonsBooking::select(
                            DB::raw("to_char(lession_date, 'DD Mon YYYY') as date"),
                            DB::raw("sum(NULLIF(lesson_duration,0)) as total")
                        )
                        ->whereRaw("to_char(lession_date, 'YYYY-MM-DD') like '" . $date . "'")
                        //->where('status','completed')
						->whereIn('status',["completed", "student_not_show", "csd"])
                        ->groupBy('date')->get()->toArray();

                $amtData = [];
                $amtData['lables'][] = date('d M Y');
                $amtData['data'][] = !empty($amounts[0]['total']) ? number_format(($amounts[0]['total']/60), 2) : 0;
            } elseif (!empty($filter) && $filter == 'y') {
                $amounts = StudentLessonsBooking:: select(
                            DB::raw("to_char(lession_date,'Mon') as mon"),
                            DB::raw("extract(year from lession_date) as yyyy"),
                            DB::raw("CONCAT(to_char(lession_date,'Mon') ,' ',extract(year from lession_date)) as mdate"),
                            DB::raw("sum(NULLIF(lesson_duration,0)) as total")
                        )
                        ->whereRaw("date_part('year', lession_date) = date_part('year', CURRENT_DATE)")
                        //->where('status','completed')
						->whereIn('status',["completed", "student_not_show", "csd"])
                        ->groupBy(DB::raw('1,2'))->pluck('total','mdate')->toArray();

                $stDate = date('Y')."-01-01";
                $lastYear = $this->monthRange($stDate);

                $amtData = [];
                foreach ($lastYear as $day) {
                    $amtData['lables'][] = $day;
                    $amtData['data'][] = !empty($amounts[$day]) ? number_format(($amounts[$day]/60), 2) : 0;
                }
            } else {
                $amounts=StudentLessonsBooking:: select(
                            DB::raw("to_char(lession_date, 'DD Mon') as date"),
                            DB::raw("sum(NULLIF(lesson_duration,0)) as total")
                        )
                        ->whereRaw("to_char(lession_date, 'YYYY-MM-DD') between '" . $last_date . "' and'" . $today . "'")
                        //->where('status','completed')
						->whereIn('status',["completed", "student_not_show", "csd"])
                        ->groupBy('date')->pluck('total','date')->toArray();

                $lastWeek = $this->daterange($last_date,$today);
                $amtData = [];
                foreach ($lastWeek as $day) {
                    $amtData['lables'][] = $day;
                    $amtData['data'][] = !empty($amounts[$day]) ? number_format(($amounts[$day]/60), 2) : 0;
                }
            }
        }

        return view('admin.reports.amount.index', compact('amounts','filter','option','sort','amtData','from_date','to_date'));
    }

    private function totalHoursTaughtPerTeachers($input = array()){
        $filter = !empty($input['filter']) ? $input['filter'] : '';
        $option = !empty($input['opt']) ? $input['opt'] : '';
        $sort   = !empty($input['sort']) ? $input['sort'] : '';
        $last_date = date('Y-m-d', strtotime('-6 days'));
        $today = date('Y-m-d', strtotime(today()));
        $user_id = !empty($input['user_id']) ? $input['user_id'] : '';
        $users = User::where('user_type','teacher')->where('status',1)->get()->toArray();

        if(!$user_id){
            $user_id = current($users)['id'];
        }

        $from_date = !empty($input['from_date']) ? $input['from_date'] : '';
        $to_date   = !empty($input['to_date']) ? $input['to_date'] : '';

        if(!empty($from_date) && !empty($to_date)){
            $filter = '';
            $bdays = $this->dateDiff($from_date, $to_date);

            if($bdays >= 0 && $bdays < 31){
                $amounts = StudentLessonsBooking:: select(
                    DB::raw("to_char(lession_date, 'DD Mon') as date"),
                    DB::raw("sum(NULLIF(lesson_duration,0)) as total")
                )
                ->whereRaw("lession_date >= '".$from_date."'::date")
                ->whereRaw("lession_date < '".date('Y-m-d',strtotime('+1 day', strtotime($to_date))) ."'::date")
                //->where('status','completed')
				->whereIn('status',["completed", "student_not_show", "csd"])
                ->where('teacher_id',$user_id)
                ->groupBy('date')->pluck('total','date')->toArray();

                $lastMonth = $this->daterange($from_date,$to_date);
                $amtData = [];
                foreach ($lastMonth as $day) {
                    $amtData['lables'][] = $day;
                    $amtData['data'][] = !empty($amounts[$day]) ? (int)$amounts[$day] : 0;
                }
            } else {
                $amounts = StudentLessonsBooking:: select(
                    DB::raw("to_char(lession_date,'Mon') as mon"),
                    DB::raw("extract(year from lession_date) as yyyy"),
                    DB::raw("CONCAT(to_char(lession_date,'Mon') ,' ',extract(year from lession_date)) as mdate"),
                    DB::raw("sum(NULLIF(lesson_duration,0)) as total")
                )
                ->whereRaw("lession_date >= '".$from_date."'::date")
                ->whereRaw("lession_date < '".date('Y-m-d',strtotime('+1 day', strtotime($to_date))) ."'::date")
                //->where('status','completed')
				->whereIn('status',["completed", "student_not_show", "csd"])
                ->where('teacher_id',$user_id)
                ->groupBy(DB::raw('1,2'))->pluck('total','mdate')->toArray();

                $lastYear = $this->monthRange($from_date,$to_date);
                $amtData = [];
                foreach ($lastYear as $day) {
                    $amtData['lables'][] = $day;
                    $amtData['data'][] = !empty($amounts[$day]) ? (int)$amounts[$day] : 0;
                }
            }
        } else {
            if (!empty($filter) && $filter == 'm') {
                $date = date('Y-m', strtotime(today()));
                $amounts = StudentLessonsBooking:: select(
                            DB::raw("to_char(lession_date, 'DD Mon') as date"),
                            DB::raw("sum(NULLIF(lesson_duration,0)) as total")
                        )
                        ->whereRaw("to_char(lession_date, 'YYYY-MM') like '" . $date . "'")
                        //->where('status','completed')
						->whereIn('status',["completed", "student_not_show", "csd"])
                        ->where('teacher_id',$user_id)
                        ->groupBy('date')->pluck('total','date')->toArray();

                $stDate = date('Y-m')."-01";
				
				$lastDateOfThisMonth =strtotime('last day of this month') ;
				$last_day = date('Y-m-d', $lastDateOfThisMonth);
				
                $lastMonth = $this->daterange($stDate,$last_day);
                $amtData = [];
                foreach ($lastMonth as $day) {
                    $amtData['lables'][] = $day;
                    $amtData['data'][] = !empty($amounts[$day]) ? number_format(($amounts[$day]/60), 2) : 0;
                }
            } elseif (!empty($filter) && $filter == 'd') {
                $date = date('Y-m-d', strtotime(today()));
                $amounts = StudentLessonsBooking::select(
                            DB::raw("to_char(lession_date, 'DD Mon YYYY') as date"),
                            DB::raw("sum(NULLIF(lesson_duration,0)) as total")
                        )
                        ->whereRaw("to_char(lession_date, 'YYYY-MM-DD') like '" . $date . "'")
                        //->where('status','completed')
						->whereIn('status',["completed", "student_not_show", "csd"])
                        ->where('teacher_id',$user_id)
                        ->groupBy('date')->get()->toArray();

                $amtData = [];
                $amtData['lables'][] = date('d M Y');
                $amtData['data'][] = !empty($amounts[0]['total']) ? number_format(($amounts[0]['total']/60), 2) : 0;
            } elseif (!empty($filter) && $filter == 'y') {
                $amounts = StudentLessonsBooking:: select(
                            DB::raw("to_char(lession_date,'Mon') as mon"),
                            DB::raw("extract(year from lession_date) as yyyy"),
                            DB::raw("CONCAT(to_char(lession_date,'Mon') ,' ',extract(year from lession_date)) as mdate"),
                            DB::raw("sum(NULLIF(lesson_duration,0)) as total")
                        )
                        ->whereRaw("date_part('year', lession_date) = date_part('year', CURRENT_DATE)")
                        //->where('status','completed')
						->whereIn('status',["completed", "student_not_show", "csd"])
                        ->where('teacher_id',$user_id)
                        ->groupBy(DB::raw('1,2'))->pluck('total','mdate')->toArray();

                $stDate = date('Y')."-01-01";
                $lastYear = $this->monthRange($stDate);

                $amtData = [];
                foreach ($lastYear as $day) {
                    $amtData['lables'][] = $day;
                    $amtData['data'][] = !empty($amounts[$day]) ? number_format(($amounts[$day]/60), 2) : 0;
                }
            } else {
                $amounts=StudentLessonsBooking:: select(
                            DB::raw("to_char(lession_date, 'DD Mon') as date"),
                            DB::raw("sum(NULLIF(lesson_duration,0)) as total")
                        )
                        ->whereRaw("to_char(lession_date, 'YYYY-MM-DD') between '" . $last_date . "' and'" . $today . "'")
                        //->where('status','completed')
						->whereIn('status',["completed", "student_not_show", "csd"])
                        ->where('teacher_id',$user_id)
                        ->groupBy('date')->pluck('total','date')->toArray();

                $lastWeek = $this->daterange($last_date,$today);
                $amtData = [];
                foreach ($lastWeek as $day) {
                    $amtData['lables'][] = $day;
                    $amtData['data'][] = !empty($amounts[$day]) ? number_format(($amounts[$day]/60), 2) : 0;
                }
            }
        }

        return view('admin.reports.amount.index', compact('amounts','filter','option','users','user_id','sort','amtData','from_date','to_date'));
    }

    private function top10Teachers($input = array()){
        $filter = !empty($input['filter']) ? $input['filter'] : '';
        $option = !empty($input['opt']) ? $input['opt'] : '';
        $sort   = !empty($input['sort']) ? $input['sort'] : '';
        $last_date = date('Y-m-d', strtotime('-6 days'));
        $today = date('Y-m-d', strtotime(today()));

        $from_date = !empty($input['from_date']) ? $input['from_date'] : '';
        $to_date   = !empty($input['to_date']) ? $input['to_date'] : '';

        if(!empty($from_date) && !empty($to_date)){
            $filter = '';
            $bdays = $this->dateDiff($from_date, $to_date);

            $amounts=StudentLessonsBooking:: select(
                'teacher_id',
                DB::raw("sum(NULLIF(teacher_earnings,0)) as total")
            )
            ->whereRaw("lession_date >= '".$from_date."'::date")
            ->whereRaw("lession_date < '".date('Y-m-d',strtotime('+1 day', strtotime($to_date))) ."'::date")
			->whereIn('status',["completed", "student_not_show", "csd"])			
            ->with('teacher')
            ->orderByRaw('total DESC NULLS LAST')
            ->groupBy('teacher_id')->limit(10)->get()->toArray();
        } else {
            if (!empty($filter) && $filter == 'm') {
                $date = date('Y-m', strtotime(today()));

                $amounts=StudentLessonsBooking:: select(
                    'teacher_id',
                    DB::raw("sum(NULLIF(teacher_earnings,0)) as total")
                )
                ->whereRaw("to_char(lession_date, 'YYYY-MM') like '" . $date . "'")
				->whereIn('status',["completed", "student_not_show", "csd"])
                ->with('teacher')
                ->orderByRaw('total DESC NULLS LAST')
                ->groupBy('teacher_id')->limit(10)->get()->toArray();

            } elseif (!empty($filter) && $filter == 'd') {

                $date = date('Y-m-d', strtotime(today()));

                $amounts = StudentLessonsBooking::select(
                                    'teacher_id',
                                    DB::raw("sum(NULLIF(teacher_earnings,0)) as total")
                                )
                                ->whereRaw("to_char(lession_date, 'YYYY-MM-DD') like '" . $date . "'")
								->whereIn('status',["completed", "student_not_show", "csd"])
                                ->with('teacher')
                                ->orderByRaw('total DESC NULLS LAST')
                                ->groupBy('teacher_id')->limit(10)->get()->toArray();

            } elseif (!empty($filter) && $filter == 'y') {
                $amounts = StudentLessonsBooking:: select(
                            'teacher_id',
                            DB::raw("sum(NULLIF(teacher_earnings,0)) as total")
                        )
                        ->whereRaw("date_part('year', lession_date) = date_part('year', CURRENT_DATE)")
						->whereIn('status',["completed", "student_not_show", "csd"])
                        ->with('teacher')
                        ->orderByRaw('total DESC NULLS LAST')
                        ->groupBy('teacher_id')->limit(10)->get()->toArray();
            } else {
                $amounts=StudentLessonsBooking:: select(
                                            'teacher_id',
                                            DB::raw("sum(NULLIF(teacher_earnings,0)) as total")
                                        )
                                        ->whereRaw("to_char(lession_date, 'YYYY-MM-DD') between '" . $last_date . "' and'" . $today . "'")
										->whereIn('status',["completed", "student_not_show", "csd"])
                                        ->with('teacher')
                                        ->groupBy('teacher_id')
                                        ->orderByRaw('total DESC NULLS LAST')
                                        ->limit(10)->get()->toArray();
            }
        }

        $amtData = [];
        foreach ($amounts as $amt) {
            $amtData['lables'][] = $amt['teacher']['firstname'].' '.$amt['teacher']['lastname'];
            $amtData['data'][] = $amt['total'];
        }

        if(!$amtData){
            $amtData['lables'] = [];
            $amtData['data'] = [];
        }

        return view('admin.reports.amount.index', compact('amounts','filter','option','sort','amtData','from_date','to_date'));
    }

    private function last10Teachers($input = array()){
        $filter = !empty($input['filter']) ? $input['filter'] : '';
        $option = !empty($input['opt']) ? $input['opt'] : '';
        $sort   = !empty($input['sort']) ? $input['sort'] : '';
        $last_date = date('Y-m-d', strtotime('-6 days'));
        $today = date('Y-m-d', strtotime(today()));

        $from_date = !empty($input['from_date']) ? $input['from_date'] : '';
        $to_date   = !empty($input['to_date']) ? $input['to_date'] : '';


        if(!empty($from_date) && !empty($to_date)){
            $filter = '';
            $bdays = $this->dateDiff($from_date, $to_date);

            $amounts=StudentLessonsBooking:: select(
                'teacher_id',
                DB::raw("sum(NULLIF(teacher_earnings,0)) as total")
            )
            ->whereRaw("lession_date >= '".$from_date."'::date")
            ->whereRaw("lession_date < '".date('Y-m-d',strtotime('+1 day', strtotime($to_date))) ."'::date")
            ->with('teacher')
            ->orderByRaw('total ASC NULLS FIRST')
            ->groupBy('teacher_id')->limit(10)->get()->toArray();
        } else {
            if (!empty($filter) && $filter == 'm') {
                $date = date('Y-m', strtotime(today()));

                $amounts=StudentLessonsBooking:: select(
                    'teacher_id',
                    DB::raw("sum(NULLIF(teacher_earnings,0)) as total")
                )
                ->whereRaw("to_char(lession_date, 'YYYY-MM') like '" . $date . "'")
                ->with('teacher')
                ->orderByRaw('total ASC NULLS FIRST')
                ->groupBy('teacher_id')->limit(10)->get()->toArray();

            } elseif (!empty($filter) && $filter == 'd') {

                $date = date('Y-m-d', strtotime(today()));

                $amounts = StudentLessonsBooking::select(
                                    'teacher_id',
                                    DB::raw("sum(NULLIF(teacher_earnings,0)) as total")
                                )
                                ->whereRaw("to_char(lession_date, 'YYYY-MM-DD') like '" . $date . "'")
                                ->with('teacher')
                                ->orderByRaw('total ASC NULLS FIRST')
                                ->groupBy('teacher_id')->limit(10)->get()->toArray();

            } elseif (!empty($filter) && $filter == 'y') {
                $amounts = StudentLessonsBooking:: select(
                            'teacher_id',
                            DB::raw("sum(NULLIF(teacher_earnings,0)) as total")
                        )
                        ->whereRaw("date_part('year', lession_date) = date_part('year', CURRENT_DATE)")
                        ->with('teacher')
                        ->orderByRaw('total ASC NULLS FIRST')
                        ->groupBy('teacher_id')->limit(10)->get()->toArray();
            } else {
                $amounts=StudentLessonsBooking:: select(
                                            'teacher_id',
                                            DB::raw("sum(NULLIF(teacher_earnings,0)) as total")
                                        )
                                        ->whereRaw("to_char(lession_date, 'YYYY-MM-DD') between '" . $last_date . "' and'" . $today . "'")
                                        ->with('teacher')
                                        ->groupBy('teacher_id')
                                        ->orderByRaw('total ASC NULLS FIRST')
                                        ->limit(10)->get()->toArray();
            }
        }

        $amtData = [];
        foreach ($amounts as $amt) {
            $amtData['lables'][] = $amt['teacher']['firstname'].' '.$amt['teacher']['lastname'];
            $amtData['data'][] = $amt['total'];
        }

        if(!$amtData){
            $amtData['lables'] = [];
            $amtData['data'] = [];
        }

        return view('admin.reports.amount.index', compact('amounts','filter','option','sort','amtData','from_date','to_date'));
    }

    private function dateRange( $first, $last=null, $step = '+1 day', $format = 'd M' ) {

        $dates = array();
        $current = strtotime( $first );
        if($last){
            $last = strtotime( $last );
        } else {
            $last = time();
        }

        while( $current <= $last ) {

            $dates[] = date( $format, $current );
            $current = strtotime( $step, $current );
        }
        return $dates;
    }

    private function monthRange( $first, $last=null, $step = '+1 month', $format = 'M Y' ) {
        $dates = array();
        $current = strtotime( $first );

        if($last){
            $last = strtotime( $last );
        } else {
            $last = time();
        }

        while( $current <= $last ) {
            $dates[] = date( $format, $current );
            $current = strtotime( $step, $current );
        }

        return $dates;
    }

    private function dateDiff($date1, $date2) {
	    $date1_ts = strtotime($date1);
	    $date2_ts = strtotime($date2);
	    $diff = $date2_ts - $date1_ts;
	    return round($diff / 86400);
	}
}
