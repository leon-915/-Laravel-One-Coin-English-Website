<?php

namespace App\Http\Controllers\Admin\LessonReports;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\ReportSettings;
use App\Models\StudentLessons;
use App\Models\StudentLessonsBooking;
use App\Models\StudentPackages;
use App\Models\StudentTransactions;
use App\Models\Settings;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request) {
        $input  = $request->all();
        $filter = !empty($input['filter']) ? $input['filter'] : '';
        $option = !empty($input['opt']) ? $input['opt'] : '';
        $sort   = !empty($input['sort']) ? $input['sort'] : '';
        $last_date = date('Y-m-d', strtotime('-6 days'));
        $today = date('Y-m-d', strtotime(today()));

        $from_date = !empty($input['from_date']) ? $input['from_date'] : '';
        $to_date   = !empty($input['to_date']) ? $input['to_date'] : '';

        $newCourseData  = $this->newCourses($input);
        $remaingData    = $this->remaingBalance($input);
        $expireData     = $this->courseExpires($input);
        $revenueData    = $this->courseRevenue($input);

        return view('admin.reports.dashboard.index',compact('filter','option','sort','newCourseData','remaingData','expireData','revenueData','from_date','to_date'));
    }

    private function newCourses($input = array()){
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
                
				$services = StudentLessons:: select(
                    DB::raw("to_char(start_date, 'DD Mon') as date"),
                    DB::raw("sum(NULLIF(price,0)) as total")
                )
                ->whereRaw("start_date >= '".$from_date."'::date")
                ->whereRaw("start_date < '".date('Y-m-d',strtotime('+1 day', strtotime($to_date))) ."'::date")
                ->where('status',1)
                ->groupBy('date')->pluck('total','date')->toArray();

                $packages = StudentPackages:: select(
                    DB::raw("to_char(start_date, 'DD Mon') as date"),
                    DB::raw("sum(NULLIF(price,0)) as total")
                )
                ->whereRaw("start_date >= '".$from_date."'::date")
                ->whereRaw("start_date < '".date('Y-m-d',strtotime('+1 day', strtotime($to_date))) ."'::date")
                ->where('status','active')
                ->groupBy('date')->pluck('total','date')->toArray();


                $lastMonth = $this->daterange($from_date,$to_date);
                $amtData = [];
                foreach ($lastMonth as $day) {
                    $amtData['lables'][] = $day;
                    $amtData['sdata'][] = !empty($services[$day]) ? $services[$day] : 0;
                    $amtData['pdata'][] = !empty($packages[$day]) ? $packages[$day] : 0;
                }
            } else {
				
				$services = StudentLessons:: select(
                    DB::raw("to_char(start_date,'Mon') as mon"),
                    DB::raw("extract(year from start_date) as yyyy"),
                    DB::raw("CONCAT(to_char(start_date,'Mon') ,' ',extract(year from start_date)) as mdate"),
                    DB::raw("sum(NULLIF(price,0)) as total")
                )
                ->whereRaw("start_date >= '".$from_date."'::date")
                ->whereRaw("start_date < '".date('Y-m-d',strtotime('+1 day', strtotime($to_date))) ."'::date")
                ->where('status',1)
                ->groupBy(DB::raw('1,2'))->pluck('total','mdate')->toArray();
				
				$packages = StudentPackages:: select(
                            DB::raw("to_char(start_date,'Mon') as mon"),
                            DB::raw("extract(year from start_date) as yyyy"),
                            DB::raw("CONCAT(to_char(start_date,'Mon') ,' ',extract(year from start_date)) as mdate"),
                            DB::raw("sum(NULLIF(price,0)) as total")
                        )
                        ->whereRaw("start_date >= '".$from_date."'::date")
                        ->whereRaw("start_date < '".date('Y-m-d',strtotime('+1 day', strtotime($to_date))) ."'::date")
                        ->where('status','active')
                        ->groupBy(DB::raw('1,2'))->pluck('total','mdate')->toArray();		

                $lastYear = $this->monthRange($from_date,$to_date);

                $amtData = [];
                foreach ($lastYear as $day) {
                    $amtData['lables'][] = $day;
                    $amtData['sdata'][] = !empty($services[$day]) ? $services[$day] : 0;
                    $amtData['pdata'][] = !empty($packages[$day]) ? $packages[$day] : 0;
                }
            }
        } else {
            if (!empty($filter) && $filter == 'm') {
                $date = date('Y-m', strtotime(today()));
				
				$services = StudentLessons:: select(
                    DB::raw("to_char(start_date, 'DD Mon') as date"),
                    DB::raw("sum(NULLIF(price,0)) as total")
                )
                ->whereRaw("to_char(start_date, 'YYYY-MM') like '" . $date . "'")
                ->where('status',1)
                ->groupBy('date')->pluck('total','date')->toArray();

				$packages = StudentPackages:: select(
                    DB::raw("to_char(start_date, 'DD Mon') as date"),
                    DB::raw("sum(NULLIF(price,0)) as total")
                )
                ->whereRaw("to_char(start_date, 'YYYY-MM') like '" . $date . "'")
                ->where('status','active')
                ->groupBy('date')->pluck('total','date')->toArray();


                $stDate = date('Y-m')."-01";
                $lastMonth = $this->daterange($stDate,$today);
                $amtData = [];
                foreach ($lastMonth as $day) {
                    $amtData['lables'][] = $day;
                    $amtData['sdata'][] = !empty($services[$day]) ? $services[$day] : 0;
                    $amtData['pdata'][] = !empty($packages[$day]) ? $packages[$day] : 0;
                }

            } elseif (!empty($filter) && $filter == 'd') {

                $date = date('Y-m-d', strtotime(today()));
				
				$services = StudentLessons::select(
                                    DB::raw("to_char(start_date, 'DD Mon YYYY') as date"),
                                    DB::raw("sum(NULLIF(price,0)) as total")
                                )
                                ->whereRaw("to_char(start_date, 'YYYY-MM-DD') like '" . $date . "'")
                                ->where('status',1)
                                ->groupBy('date')->get()->toArray();				

				$packages = StudentPackages::select(
                                    DB::raw("to_char(start_date, 'DD Mon YYYY') as date"),
                                    DB::raw("sum(NULLIF(price,0)) as total")
                                )
                                ->whereRaw("to_char(start_date, 'YYYY-MM-DD') like '" . $date . "'")
                                ->where('status','active')
                                ->groupBy('date')->get()->toArray();				


                $amtData = [];
                $amtData['lables'][] = date('d M Y');
                $amtData['sdata'][] = !empty($services[0]['total']) ? $services[0]['total']: 0;
                $amtData['pdata'][] = !empty($packages[0]['total']) ? $packages[0]['total']: 0;


            } elseif (!empty($filter) && $filter == 'y') {
				$services = StudentLessons:: select(
                            DB::raw("to_char(start_date,'Mon') as mon"),
                            DB::raw("extract(year from start_date) as yyyy"),
                            DB::raw("CONCAT(to_char(start_date,'Mon') ,' ',extract(year from start_date)) as mdate"),
                            DB::raw("sum(NULLIF(price,0)) as total")
                        )
                        ->whereRaw("date_part('year', start_date) = date_part('year', CURRENT_DATE)")
                        ->where('status',1)
                        ->groupBy(DB::raw('1,2'))->pluck('total','mdate')->toArray();		

                $packages = StudentPackages:: select(
                            DB::raw("to_char(start_date,'Mon') as mon"),
                            DB::raw("extract(year from start_date) as yyyy"),
                            DB::raw("CONCAT(to_char(start_date,'Mon') ,' ',extract(year from start_date)) as mdate"),
                            DB::raw("sum(NULLIF(price,0)) as total")
                        )
                        ->whereRaw("date_part('year', start_date) = date_part('year', CURRENT_DATE)")
                        ->where('status','active')
                        ->groupBy(DB::raw('1,2'))->pluck('total','mdate')->toArray();

                $stDate = date('Y')."-01-01";
                $lastYear = $this->monthRange($stDate);

                $amtData = [];
                foreach ($lastYear as $day) {
                    $amtData['lables'][] = $day;
                    $amtData['sdata'][] = !empty($services[$day]) ? $services[$day] : 0;
                    $amtData['pdata'][] = !empty($packages[$day]) ? $packages[$day] : 0;
                }

            } else {
				$services=StudentLessons:: select(
                                            DB::raw("to_char(start_date, 'DD Mon') as date"),
                                            DB::raw("sum(NULLIF(price,0)) as total")
                                        )
                                        ->whereRaw("to_char(start_date, 'YYYY-MM-DD') between '" . $last_date . "' and'" . $today . "'")
                                        ->where('status',1)
                                        ->groupBy('date')->pluck('total','date')->toArray();
										
				$packages=StudentPackages:: select(
                                            DB::raw("to_char(start_date, 'DD Mon') as date"),
                                            DB::raw("sum(NULLIF(price,0)) as total")
                                        )
                                        ->whereRaw("to_char(start_date, 'YYYY-MM-DD') between '" . $last_date . "' and'" . $today . "'")
                                        ->where('status','active')
                                        ->groupBy('date')->pluck('total','date')->toArray();						

                $lastWeek = $this->daterange($last_date,$today);
                $amtData = [];
                foreach ($lastWeek as $day) {
                    $amtData['lables'][] = $day;
                    $amtData['sdata'][] = !empty($services[$day]) ? $services[$day] : 0;
                    $amtData['pdata'][] = !empty($packages[$day]) ? $packages[$day] : 0;
                }
            }
        }

        return $amtData;
    }

    private function remaingBalance($input = array()){
        $filter = !empty($input['filter']) ? $input['filter'] : '';
        $option = !empty($input['opt']) ? $input['opt'] : '';
        $sort   = !empty($input['sort']) ? $input['sort'] : '';
        $last_date = date('Y-m-d', strtotime('-6 days'));
        $today = date('Y-m-d', strtotime(today()));

        $from_date = !empty($input['from_date']) ? $input['from_date'] : '';
        $to_date   = !empty($input['to_date']) ? $input['to_date'] : '';
		$tax = Settings::getSettings('tax');
		
        if(!empty($from_date) && !empty($to_date)){
            $filter = '';
            $bdays = $this->dateDiff($from_date, $to_date);

            if($bdays >= 0 && $bdays < 31){
                $services = StudentPackages:: select(
                    DB::raw("to_char(student_packages.end_date, 'DD Mon') as date"),
                    DB::raw("sum(NULLIF(student_details.credit_balance,0)) as total")
                )
                ->whereRaw("student_packages.end_date >= '".$from_date."'::date")
                ->whereRaw("student_packages.end_date < '".date('Y-m-d',strtotime('+1 day', strtotime($to_date))) ."'::date")
                ->join('users','users.id','student_packages.user_id')
                ->join('student_details','users.id','student_details.user_id')
                ->groupBy('date')->pluck('total','date')->toArray();
				
				// regular course
				$StudentLessons=StudentLessons:: select(
                                            DB::raw("student_lessons.price"),
                                            DB::raw("services.available_lessons"),
                                            DB::raw("to_char(student_lessons.expire_date, 'DD Mon') as date"),
                                            DB::raw("student_lessons.available_bookings")
                                        )
                                        ->whereRaw("student_lessons.expire_date >= '".$from_date."'::date")
										->whereRaw("student_lessons.expire_date < '".date('Y-m-d',strtotime('+1 day', strtotime($to_date))) ."'::date")
										->whereRaw('student_lessons.available_bookings > 0')
                                        ->leftjoin('services','student_lessons.service_id','services.id')
                                        ->get();
				
				$StudentLessonsAmount = $dateArray = [];						
				if(!empty($StudentLessons)) {
					foreach($StudentLessons as $StudentLesson) {
						$price = $StudentLesson->price;
						$price = $price + (($price * $tax / 100));
						$date = $StudentLesson->date;
						$id = $StudentLesson->id;
						$available_bookings = $StudentLesson->available_bookings;
						$total_lessons = $StudentLesson->available_lessons > 0 ? $StudentLesson->available_lessons : 1;
						$per_lesson_price = $price  / $total_lessons;
						$amount = $available_bookings * $per_lesson_price;
						if(in_array($date, $dateArray)){
							$StudentLessonsAmount[$date] = $StudentLessonsAmount[$date] + $amount;
						} else {
							$StudentLessonsAmount[$date] = $amount;
							$dateArray[] = $date;
						}						
					}
				}
				

                $lastMonth = $this->daterange($from_date,$to_date);
                $amtData = [];
				$total = 0;
                foreach ($lastMonth as $day) {
                    $amtData['lables'][] = $day;
					$total = !empty($services[$day]) ? (int)$services[$day] : 0;
					if(isset($StudentLessonsAmount[$day])) {
						$total = $total + $StudentLessonsAmount[$day];
					}
                    $amtData['data'][] = round(number_format($total, 2, '.', ''));
                }
            } else {
                $services = StudentPackages:: select(
                    DB::raw("to_char(student_packages.end_date,'Mon') as mon"),
                    DB::raw("extract(year from student_packages.end_date) as yyyy"),
                    DB::raw("CONCAT(to_char(student_packages.end_date,'Mon') ,' ',extract(year from student_packages.end_date)) as mdate"),
                    DB::raw("sum(NULLIF(student_details.credit_balance,0)) as total")
                )
                ->whereRaw("student_packages.end_date >= '".$from_date."'::date")
                ->whereRaw("student_packages.end_date < '".date('Y-m-d',strtotime('+1 day', strtotime($to_date))) ."'::date")
                ->join('users','users.id','student_packages.user_id')
                ->join('student_details','users.id','student_details.user_id')
                ->groupBy(DB::raw('1,2'))->pluck('total','mdate')->toArray();
				
				// regular course
				$StudentLessons=StudentLessons:: select(
                                            DB::raw("student_lessons.price"),
                                            DB::raw("services.available_lessons"),
                                            DB::raw("to_char(student_lessons.expire_date,'Mon') as mon"),
											DB::raw("extract(year from student_lessons.expire_date) as yyyy"),
											DB::raw("CONCAT(to_char(student_lessons.expire_date,'Mon') ,' ',extract(year from student_lessons.expire_date)) as mdate"),
                                            DB::raw("student_lessons.available_bookings")
                                        )
                                        ->whereRaw("student_lessons.expire_date >= '".$from_date."'::date")
										->whereRaw("student_lessons.expire_date < '".date('Y-m-d',strtotime('+1 day', strtotime($to_date))) ."'::date")
										->whereRaw('student_lessons.available_bookings > 0')
                                        ->leftjoin('services','student_lessons.service_id','services.id')
                                        ->get();
				
				$StudentLessonsAmount = $dateArray = [];						
				if(!empty($StudentLessons)) {
					foreach($StudentLessons as $StudentLesson) {
						$price = $StudentLesson->price;
						$price = $price + (($price * $tax / 100));
						$date = $StudentLesson->mdate;
						$id = $StudentLesson->id;
						$available_bookings = $StudentLesson->available_bookings;
						$total_lessons = $StudentLesson->available_lessons > 0 ? $StudentLesson->available_lessons : 1;
						$per_lesson_price = $price  / $total_lessons;
						$amount = $available_bookings * $per_lesson_price;
						if(in_array($date, $dateArray)){
							$StudentLessonsAmount[$date] = $StudentLessonsAmount[$date] + $amount;
						} else {
							$StudentLessonsAmount[$date] = $amount;
							$dateArray[] = $date;
						}						
					}
				}


                $lastYear = $this->monthRange($from_date,$to_date);

                $amtData = [];
				$total = 0;
                foreach ($lastYear as $day) {
                    $amtData['lables'][] = $day;
					$total = !empty($services[$day]) ? (int)$services[$day] : 0;
					if(isset($StudentLessonsAmount[$day])) {
						$total = $total + $StudentLessonsAmount[$day];
					}
                    $amtData['data'][] = round(number_format($total, 2, '.', ''));
                }
            }
        } else {
            if (!empty($filter) && $filter == 'm') {
                $date = date('Y-m', strtotime(today()));

                $services = StudentPackages:: select(
                    DB::raw("to_char(student_packages.end_date, 'DD Mon') as date"),
                    DB::raw("sum(NULLIF(student_details.credit_balance,0)) as total")
                )
                ->whereRaw("to_char(student_packages.end_date, 'YYYY-MM') like '" . $date . "'")
                ->join('users','users.id','student_packages.user_id')
                ->join('student_details','users.id','student_details.user_id')
                ->groupBy('date')->pluck('total','date')->toArray();
				
				// regular course
				$StudentLessons=StudentLessons:: select(
                                            DB::raw("student_lessons.price"),
                                            DB::raw("services.available_lessons"),
                                            DB::raw("to_char(student_lessons.expire_date, 'DD Mon') as date"),
                                            DB::raw("student_lessons.available_bookings")
                                        )
                                        ->whereRaw("to_char(student_lessons.expire_date, 'YYYY-MM') like '" . $date . "'")
										->whereRaw('student_lessons.available_bookings > 0')
                                        ->leftjoin('services','student_lessons.service_id','services.id')
                                        ->get();
				
				$StudentLessonsAmount = $dateArray = [];						
				if(!empty($StudentLessons)) {
					foreach($StudentLessons as $StudentLesson) {
						$price = $StudentLesson->price;
						$price = $price + (($price * $tax / 100));
						$date = $StudentLesson->date;
						$id = $StudentLesson->id;
						$available_bookings = $StudentLesson->available_bookings;
						$total_lessons = $StudentLesson->available_lessons > 0 ? $StudentLesson->available_lessons : 1;
						$per_lesson_price = $price  / $total_lessons;
						$amount = $available_bookings * $per_lesson_price;
						if(in_array($date, $dateArray)){
							$StudentLessonsAmount[$date] = $StudentLessonsAmount[$date] + $amount;
						} else {
							$StudentLessonsAmount[$date] = $amount;
							$dateArray[] = $date;
						}						
					}
				}

                $stDate = date('Y-m')."-01";
                $lastMonth = $this->daterange($stDate,$today);
                $amtData = [];
				$total = 0;
                foreach ($lastMonth as $day) {
                    $amtData['lables'][] = $day;
					$total = !empty($services[$day]) ? (int)$services[$day] : 0;
					if(isset($StudentLessonsAmount[$day])) {
						$total = $total + $StudentLessonsAmount[$day];
					}
                    $amtData['data'][] = round(number_format($total, 2, '.', ''));
                }

            } elseif (!empty($filter) && $filter == 'd') {

                $date = date('Y-m-d', strtotime(today()));

                $services = StudentPackages::select(
                                    DB::raw("to_char(student_packages.end_date, 'DD Mon YYYY') as date"),
                                    DB::raw("sum(NULLIF(student_details.credit_balance,0)) as total")
                                )
                                ->whereRaw("to_char(student_packages.end_date, 'YYYY-MM-DD') like '" . $date . "'")
                                ->join('users','users.id','student_packages.user_id')
                                ->join('student_details','users.id','student_details.user_id')
                                ->groupBy('date')->get()->toArray();
								
				// regular course
				$StudentLessons=StudentLessons:: select(
                                            DB::raw("student_lessons.price"),
                                            DB::raw("services.available_lessons"),
                                            DB::raw("to_char(student_lessons.expire_date, 'DD Mon YYYY') as date"),
                                            DB::raw("student_lessons.available_bookings")
                                        )
                                        ->whereRaw("to_char(student_lessons.expire_date, 'YYYY-MM-DD') like '" . $date . "'")
										->whereRaw('student_lessons.available_bookings > 0')
                                        ->leftjoin('services','student_lessons.service_id','services.id')
                                        ->get();
				
				$StudentLessonsAmount = $dateArray = [];						
				if(!empty($StudentLessons)) {
					foreach($StudentLessons as $StudentLesson) {
						$price = $StudentLesson->price;
						$price = $price + (($price * $tax / 100));
						$date = $StudentLesson->date;
						$id = $StudentLesson->id;
						$available_bookings = $StudentLesson->available_bookings;
						$total_lessons = $StudentLesson->available_lessons > 0 ? $StudentLesson->available_lessons : 1;
						$per_lesson_price = $price  / $total_lessons;
						$amount = $available_bookings * $per_lesson_price;
						if(in_array($date, $dateArray)){
							$StudentLessonsAmount[$date] = $StudentLessonsAmount[$date] + $amount;
						} else {
							$StudentLessonsAmount[$date] = $amount;
							$dateArray[] = $date;
						}						
					}
				}				

                $amtData = [];
				$total = 0;
                $amtData['lables'][] = date('d M Y');
				$total = !empty($services[0]['total']) ? (int)$services[0]['total'] : 0;
				if(isset($StudentLessonsAmount[$date])) {
					$total = $total + $StudentLessonsAmount[$date];
				}				
                $amtData['data'][] = round(number_format($total, 2, '.', ''));


            } elseif (!empty($filter) && $filter == 'y') {
                $services = StudentPackages:: select(
                            DB::raw("to_char(student_packages.end_date,'Mon') as mon"),
                            DB::raw("extract(year from student_packages.end_date) as yyyy"),
                            DB::raw("CONCAT(to_char(student_packages.end_date,'Mon') ,' ',extract(year from student_packages.end_date)) as mdate"),
                            DB::raw("sum(NULLIF(student_details.credit_balance,0)) as total")
                        )
                        ->whereRaw("date_part('year', student_packages.end_date) = date_part('year', CURRENT_DATE)")
                        ->join('users','users.id','student_packages.user_id')
                        ->join('student_details','users.id','student_details.user_id')
                        ->groupBy(DB::raw('1,2'))->pluck('total','mdate')->toArray();
						
				// regular course
				$StudentLessons=StudentLessons:: select(
                                            DB::raw("student_lessons.price"),
                                            DB::raw("services.available_lessons"),
                                            DB::raw("CONCAT(to_char(student_lessons.expire_date,'Mon') ,' ',extract(year from student_lessons.expire_date)) as mdate"),
                                            DB::raw("student_lessons.available_bookings")
                                        )
                                        ->whereRaw("date_part('year', student_lessons.expire_date) = date_part('year', CURRENT_DATE)")
										->whereRaw('student_lessons.available_bookings > 0')
                                        ->leftjoin('services','student_lessons.service_id','services.id')
                                        ->get();
				
				$StudentLessonsAmount = $dateArray = [];						
				if(!empty($StudentLessons)) {
					foreach($StudentLessons as $StudentLesson) {
						$price = $StudentLesson->price;
						$price = $price + (($price * $tax / 100));
						$date = $StudentLesson->mdate;
						$id = $StudentLesson->id;
						$available_bookings = $StudentLesson->available_bookings;
						$total_lessons = $StudentLesson->available_lessons > 0 ? $StudentLesson->available_lessons : 1;
						$per_lesson_price = $price  / $total_lessons;
						$amount = $available_bookings * $per_lesson_price;
						if(in_array($date, $dateArray)){
							$StudentLessonsAmount[$date] = $StudentLessonsAmount[$date] + $amount;
						} else {
							$StudentLessonsAmount[$date] = $amount;
							$dateArray[] = $date;
						}						
					}
				}
				


                $stDate = date('Y')."-01-01";
                $lastYear = $this->monthRange($stDate);

                $amtData = [];
				$total = 0;
                foreach ($lastYear as $day) {
                    $amtData['lables'][] = $day;
					$total = !empty($services[$day]) ? (int)$services[$day] : 0;
					if(isset($StudentLessonsAmount[$day])) {
						$total = $total + $StudentLessonsAmount[$day];
					}
                    $amtData['data'][] = round(number_format($total, 2, '.', ''));
                }

            } else {
				//point system service
                $services=StudentPackages:: select(
                                            DB::raw("to_char(student_packages.end_date, 'DD Mon') as date"),
                                            DB::raw("sum(NULLIF(student_details.credit_balance,0)) as total")
                                        )
                                        ->whereRaw("to_char(student_packages.end_date, 'YYYY-MM-DD') between '" . $last_date . "' and '" . $today . "'")
                                        ->leftjoin('users','student_packages.user_id','users.id')
                                        ->leftjoin('student_details','users.id','student_details.user_id')
                                        ->groupBy('date')->pluck('total','date')->toArray();
										
				// regular course
				$StudentLessons=StudentLessons:: select(
                                            DB::raw("student_lessons.price"),
                                            DB::raw("services.available_lessons"),
                                            DB::raw("to_char(student_lessons.expire_date, 'DD Mon') as date"),
                                            DB::raw("student_lessons.available_bookings")
                                        )
                                        ->whereRaw("to_char(student_lessons.expire_date, 'YYYY-MM-DD') between '" . $last_date . "' and '" . $today . "'")
										->whereRaw('student_lessons.available_bookings > 0')
                                        ->leftjoin('services','student_lessons.service_id','services.id')
                                        ->get();
				
				$StudentLessonsAmount = $dateArray = [];						
				if(!empty($StudentLessons)) {
					foreach($StudentLessons as $StudentLesson) {
						$price = $StudentLesson->price;
						$price = $price + (($price * $tax / 100));
						$date = $StudentLesson->date;
						$id = $StudentLesson->id;
						$available_bookings = $StudentLesson->available_bookings;
						$total_lessons = $StudentLesson->available_lessons > 0 ? $StudentLesson->available_lessons : 1;
						$per_lesson_price = $price  / $total_lessons;
						$amount = $available_bookings * $per_lesson_price;
						if(in_array($date, $dateArray)){
							$StudentLessonsAmount[$date] = $StudentLessonsAmount[$date] + $amount;
						} else {
							$StudentLessonsAmount[$date] = $amount;
							$dateArray[] = $date;
						}						
					}
				}						


                $lastWeek = $this->daterange($last_date,$today);
                $amtData = [];
				$total = 0;
                foreach ($lastWeek as $day) {
                    $amtData['lables'][] = $day;
					$total = !empty($services[$day]) ? (int)$services[$day] : 0;
					if(isset($StudentLessonsAmount[$day])) {
						$total = $total + $StudentLessonsAmount[$day];
					}
                    $amtData['data'][] = round(number_format($total, 2, '.', ''));
                }
            }
        }
//echo '<pre>';print_r($amtData);echo '</pre>';
        return $amtData;
    }

   private function courseExpires($input = array()){
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
                $services = StudentLessons:: select(
                    DB::raw("to_char(expire_date, 'DD Mon') as date"),
                    DB::raw("count(*) as total")
                )
                ->whereRaw("expire_date >= '".$from_date."'::date")
                ->whereRaw("expire_date < '".date('Y-m-d',strtotime('+1 day', strtotime($to_date))) ."'::date")
                ->groupBy('date')->pluck('total','date')->toArray();
				
				// subscriptions
				$subscriptions=StudentPackages:: select(
                    DB::raw("to_char(end_date, 'DD Mon') as date"),
                    DB::raw("count(*) as total")
                )
                ->whereRaw("end_date >= '".$from_date."'::date")
                ->whereRaw("end_date < '".date('Y-m-d',strtotime('+1 day', strtotime($to_date))) ."'::date")
                ->groupBy('date')->pluck('total','date')->toArray();
				
                $lastMonth = $this->daterange($from_date,$to_date);
                $amtData = [];
                foreach ($lastMonth as $day) {
                    $amtData['lables'][] = $day;
					$cnt = !empty($services[$day]) ? (int)$services[$day] : 0;
					if(isset($subscriptions[$day])) {
						$cnt = $cnt + $subscriptions[$day];
					}
                    $amtData['data'][] = $cnt;
                }
            } else {
                $services = StudentLessons:: select(
                    DB::raw("to_char(expire_date,'Mon') as mon"),
                    DB::raw("extract(year from expire_date) as yyyy"),
                    DB::raw("CONCAT(to_char(expire_date,'Mon') ,' ',extract(year from expire_date)) as mdate"),
                    DB::raw("count(*) as total")
                )
                ->whereRaw("expire_date >= '".$from_date."'::date")
                ->whereRaw("expire_date < '".date('Y-m-d',strtotime('+1 day', strtotime($to_date))) ."'::date")
                ->groupBy(DB::raw('1,2'))->pluck('total','mdate')->toArray();
				
				// subscriptions
				$subscriptions=StudentPackages:: select(
                    DB::raw("to_char(end_date,'Mon') as mon"),
                    DB::raw("extract(year from end_date) as yyyy"),
                    DB::raw("CONCAT(to_char(end_date,'Mon') ,' ',extract(year from end_date)) as mdate"),
                    DB::raw("count(*) as total")
                )
                ->whereRaw("end_date >= '".$from_date."'::date")
                ->whereRaw("end_date < '".date('Y-m-d',strtotime('+1 day', strtotime($to_date))) ."'::date")
                ->groupBy(DB::raw('1,2'))->pluck('total','mdate')->toArray();
				
				
                $lastYear = $this->monthRange($from_date,$to_date);

                $amtData = [];
                foreach ($lastYear as $day) {
                    $amtData['lables'][] = $day;
					$cnt = !empty($services[$day]) ? (int)$services[$day] : 0;
					if(isset($subscriptions[$day])) {
						$cnt = $cnt + $subscriptions[$day];
					}
                    $amtData['data'][] = $cnt;
                }
            }
        } else {
            if (!empty($filter) && $filter == 'm') {
                $date = date('Y-m', strtotime(today()));

                $services = StudentLessons:: select(
                        DB::raw("to_char(expire_date, 'DD Mon') as date"),
                        DB::raw("count(*) as total")
                    )
                    ->whereRaw("to_char(expire_date, 'YYYY-MM') like '" . $date . "'")
                    ->groupBy('date')->pluck('total','date')->toArray();
					
				// subscriptions
				$subscriptions=StudentPackages:: select(
                        DB::raw("to_char(end_date, 'DD Mon') as date"),
                        DB::raw("count(*) as total")
                    )
                    ->whereRaw("to_char(end_date, 'YYYY-MM') like '" . $date . "'")
                    ->groupBy('date')->pluck('total','date')->toArray();
								

                $stDate = date('Y-m')."-01";
                $lastMonth = $this->daterange($stDate,$today);
                $amtData = [];
				
                foreach ($lastMonth as $day) {
                    $amtData['lables'][] = $day;
					$cnt = !empty($services[$day]) ? (int)$services[$day] : 0;
					if(isset($subscriptions[$day])) {
						$cnt = $cnt + $subscriptions[$day];
					}
                    $amtData['data'][] = $cnt;
                }

            } elseif (!empty($filter) && $filter == 'd') {

                $date = date('Y-m-d', strtotime(today()));

                $services = StudentLessons::select(
                                    DB::raw("to_char(expire_date, 'DD Mon YYYY') as date"),
                                    DB::raw("count(*) as total")
                                )
                                ->whereRaw("to_char(expire_date, 'YYYY-MM-DD') like '" . $date . "'")
                                ->groupBy('date')->get()->toArray();
								
				// subscriptions
				$subscriptions=StudentPackages:: select(
                                    DB::raw("to_char(end_date, 'DD Mon YYYY') as date"),
                                    DB::raw("count(*) as total")
                                )
                                ->whereRaw("to_char(end_date, 'YYYY-MM-DD') like '" . $date . "'")
                                ->groupBy('date')->get()->toArray();
						

                $amtData = [];
                $amtData['lables'][] = date('d M Y');
				$cnt = !empty($services[0]['total']) ? (int)$services[0]['total'] : 0;
				if(isset($subscriptions[0]) && $subscriptions[0]['total']) {
					$cnt = $cnt + $subscriptions[0]['total'];
				}
                $amtData['data'][] = $cnt;
				
            } elseif (!empty($filter) && $filter == 'y') {
                $services = StudentLessons:: select(
                            DB::raw("to_char(expire_date,'Mon') as mon"),
                            DB::raw("extract(year from expire_date) as yyyy"),
                            DB::raw("CONCAT(to_char(expire_date,'Mon') ,' ',extract(year from expire_date)) as mdate"),
                            DB::raw("count(*) as total")
                        )
                        ->whereRaw("date_part('year', expire_date) = date_part('year', CURRENT_DATE)")
                        ->groupBy(DB::raw('1,2'))->pluck('total','mdate')->toArray();
						
				// subscriptions
				$subscriptions=StudentPackages:: select(
                            DB::raw("to_char(end_date,'Mon') as mon"),
                            DB::raw("extract(year from end_date) as yyyy"),
                            DB::raw("CONCAT(to_char(end_date,'Mon') ,' ',extract(year from end_date)) as mdate"),
                            DB::raw("count(*) as total")
                        )
                        ->whereRaw("date_part('year', end_date) = date_part('year', CURRENT_DATE)")
                        ->groupBy(DB::raw('1,2'))->pluck('total','mdate')->toArray();	


                $stDate = date('Y')."-01-01";
                $lastYear = $this->monthRange($stDate);

                $amtData = [];
                foreach ($lastYear as $day) {
                    $amtData['lables'][] = $day;
					$cnt = !empty($services[$day]) ? (int)$services[$day] : 0;
					if(isset($subscriptions[$day])) {
						$cnt = $cnt + $subscriptions[$day];
					}
					
                    $amtData['data'][] = $cnt;
                }
            } else {
				// regular course
                $services=StudentLessons:: select(
                                            DB::raw("to_char(expire_date, 'DD Mon') as date"),
                                            DB::raw("count(*) as total")
                                        )
                                        ->whereRaw("to_char(expire_date, 'YYYY-MM-DD') between '" . $last_date . "' and '" . $today . "'")
                                        ->groupBy('date')->pluck('total','date')->toArray();
										
				// subscriptions
				$subscriptions=StudentPackages:: select(
                                            DB::raw("to_char(end_date, 'DD Mon') as date"),
                                            DB::raw("count(*) as total")
                                        )
                                        ->whereRaw("to_char(end_date, 'YYYY-MM-DD') between '" . $last_date . "' and '" . $today . "'")
                                        ->groupBy('date')->pluck('total','date')->toArray();
//echo '<pre>';print_r($subscriptions);exit;
                $lastWeek = $this->daterange($last_date,$today);
                $amtData = [];
				$cnt = 0;
                foreach ($lastWeek as $day) {
                    $amtData['lables'][] = $day;
					$cnt = !empty($services[$day]) ? (int)$services[$day] : 0;
					if(isset($subscriptions[$day])) {
						$cnt = $cnt + $subscriptions[$day];
					}
                    $amtData['data'][] = $cnt;

                }
            }
        }
//echo '<pre>';print_r($amtData);exit;
        return $amtData;
    }

    private function courseRevenue($input = array()){
        $filter = !empty($input['filter']) ? $input['filter'] : '';
        $option = !empty($input['opt']) ? $input['opt'] : '';
        $sort   = !empty($input['sort']) ? $input['sort'] : '';
        $last_date = date('Y-m-d', strtotime('-6 days'));
        $today = date('Y-m-d', strtotime(today()));

        $from_date = !empty($input['from_date']) ? $input['from_date'] : '';
        $to_date   = !empty($input['to_date']) ? $input['to_date'] : '';

        $settings = ReportSettings::find(1);

        if(!empty($from_date) && !empty($to_date)){
            $filter = '';
            $bdays = $this->dateDiff($from_date, $to_date);

            if($bdays >= 0 && $bdays < 31){
                $services = StudentLessonsBooking:: select(
                        DB::raw("to_char(lession_date, 'DD Mon') as date"),
                        DB::raw("sum(NULLIF(teacher_earnings,0)) as expense"),
                        DB::raw("sum(NULLIF(admin_earnings,0)) as revenue")
                    )
                    ->whereRaw("lession_date >= '".$from_date."'::date")
                    ->whereRaw("lession_date < '".date('Y-m-d',strtotime('+1 day', strtotime($to_date))) ."'::date")
                    ->where('status', 'completed')
                    ->groupBy('date')->get()->toArray();

                $amounts = [];
                foreach ($services as $sda) {
                    $amounts[$sda['date']]['expense'] = $sda['expense'];
                    $amounts[$sda['date']]['revenue'] = $sda['revenue'];
                }

                $lastMonth = $this->daterange($from_date,$to_date);
                $amtData = [];
                foreach ($lastMonth as $day) {
                    $amtData['lables'][] = $day;
                    $amtData['expense'][] = !empty($amounts[$day]['expense']) ? (int)$amounts[$day]['expense'] : 0;
                    $amtData['revenue'][] = !empty($amounts[$day]['revenue']) ? (int)$amounts[$day]['revenue'] : 0;
                    $amtData['ultimate'][] = !empty($settings['ultimate']) ? $settings['ultimate'] : 0;
                    $amtData['ideal'][] = !empty($settings['ideal']) ? $settings['ideal'] : 0;
                    $amtData['target'][] = !empty($settings['target']) ? $settings['target']  : 0;
                    $amtData['minimum'][] = !empty($settings['minimum']) ? $settings['minimum']  : 0;
                    $amtData['avg'][] = ($settings['minimum'] + $settings['target'] + $settings['ideal'] + $settings['ultimate'])/4;
                }
            } else {
                $services = StudentLessonsBooking:: select(
                            DB::raw("to_char(lession_date,'Mon') as mon"),
                            DB::raw("extract(year from lession_date) as yyyy"),
                            DB::raw("CONCAT(to_char(lession_date,'Mon') ,' ',extract(year from lession_date)) as mdate"),
                            DB::raw("sum(NULLIF(teacher_earnings,0)) as expense"),
                            DB::raw("sum(NULLIF(admin_earnings,0)) as revenue")
                        )
                        ->whereRaw("lession_date >= '".$from_date."'::date")
                        ->whereRaw("lession_date < '".date('Y-m-d',strtotime('+1 day', strtotime($to_date))) ."'::date")
                        ->where('status', 'completed')
                        ->groupBy(DB::raw('1,2'))->get()->toArray();


                $amounts = [];
                foreach ($services as $sda) {
                    $amounts[$sda['mdate']]['expense'] = $sda['expense'];
                    $amounts[$sda['mdate']]['revenue'] = $sda['revenue'];
                }

                $lastYear = $this->monthRange($from_date,$to_date);

                $amtData = [];
                foreach ($lastYear as $day) {
                    $monDays = cal_days_in_month(CAL_GREGORIAN, date('m',strtotime($day)), date('Y'));
                    $amtData['lables'][] = $day;
                    $amtData['expense'][] = !empty($amounts[$day]['expense']) ? (int)$amounts[$day]['expense'] : 0;
                    $amtData['revenue'][] = !empty($amounts[$day]['revenue']) ? (int)$amounts[$day]['revenue'] : 0;
                    $amtData['ultimate'][] = !empty($settings['ultimate']) ? $settings['ultimate'] * $monDays : 0;
                    $amtData['ideal'][] = !empty($settings['ideal']) ? $settings['ideal'] * $monDays : 0;
                    $amtData['target'][] = !empty($settings['target']) ? $settings['target'] * $monDays  : 0;
                    $amtData['minimum'][] = !empty($settings['minimum']) ? $settings['minimum'] * $monDays : 0;
                    $amtData['avg'][] = ($settings['minimum'] + $settings['target'] + $settings['ideal'] + $settings['ultimate'])/4;
                }
            }
        } else {
            if (!empty($filter) && $filter == 'm') {
                $date = date('Y-m', strtotime(today()));

                $services = StudentLessonsBooking:: select(
                        DB::raw("to_char(lession_date, 'DD Mon') as date"),
                        DB::raw("sum(NULLIF(teacher_earnings,0)) as expense"),
                        DB::raw("sum(NULLIF(admin_earnings,0)) as revenue")
                    )
                    ->whereRaw("to_char(lession_date, 'YYYY-MM') like '" . $date . "'")
                    ->where('status', 'completed')
                    ->groupBy('date')->get()->toArray();

                $amounts = [];
                foreach ($services as $sda) {
                    $amounts[$sda['date']]['expense'] = $sda['expense'];
                    $amounts[$sda['date']]['revenue'] = $sda['revenue'];
                }

                $stDate = date('Y-m')."-01";
                $lastMonth = $this->daterange($stDate,$today);
                $amtData = [];
                foreach ($lastMonth as $day) {
                    $amtData['lables'][] = $day;
                    $amtData['expense'][] = !empty($amounts[$day]['expense']) ? (int)$amounts[$day]['expense'] : 0;
                    $amtData['revenue'][] = !empty($amounts[$day]['revenue']) ? (int)$amounts[$day]['revenue'] : 0;
                    $amtData['ultimate'][] = !empty($settings['ultimate']) ? $settings['ultimate'] : 0;
                    $amtData['ideal'][] = !empty($settings['ideal']) ? $settings['ideal'] : 0;
                    $amtData['target'][] = !empty($settings['target']) ? $settings['target']  : 0;
                    $amtData['minimum'][] = !empty($settings['minimum']) ? $settings['minimum']  : 0;
                    $amtData['avg'][] = ($settings['minimum'] + $settings['target'] + $settings['ideal'] + $settings['ultimate'])/4;
                }

            } elseif (!empty($filter) && $filter == 'd') {

                $date = date('Y-m-d', strtotime(today()));

                $services = StudentLessonsBooking::select(
                                    DB::raw("to_char(lession_date, 'DD Mon YYYY') as date"),
                                    DB::raw("sum(NULLIF(teacher_earnings,0)) as expense"),
                                    DB::raw("sum(NULLIF(admin_earnings,0)) as revenue")
                                )
                                ->whereRaw("to_char(lession_date, 'YYYY-MM-DD') like '" . $date . "'")
                                ->where('status', 'completed')
                                ->groupBy('date')->get()->toArray();

                $amounts = [];
                foreach ($services as $sda) {
                    $amounts[$sda['date']]['expense'] = $sda['expense'];
                    $amounts[$sda['date']]['revenue'] = $sda['revenue'];
                }

                $amtData = [];
                $amtData['lables'][] = date('d M Y');
                $amtData['expense'][] = !empty($amounts[0]['expense']) ? (int)$amounts[0]['expense'] : 0;
                $amtData['revenue'][] = !empty($amounts[0]['revenue']) ? (int)$amounts[0]['revenue'] : 0;
                $amtData['ultimate'][] = !empty($settings['ultimate']) ? (int)$settings['ultimate'] : 0;
                $amtData['ideal'][] = !empty($settings['ideal']) ? (int)$settings['ideal'] : 0;
                $amtData['target'][] = !empty($settings['target']) ? (int)$settings['target'] : 0;
                $amtData['minimum'][] = !empty($settings['minimum']) ? (int)$settings['minimum'] : 0;
                $amtData['avg'][] = ($settings['minimum'] + $settings['target'] + $settings['ideal'] + $settings['ultimate'])/4;


            } elseif (!empty($filter) && $filter == 'y') {
                $services = StudentLessonsBooking:: select(
                            DB::raw("to_char(lession_date,'Mon') as mon"),
                            DB::raw("extract(year from lession_date) as yyyy"),
                            DB::raw("CONCAT(to_char(lession_date,'Mon') ,' ',extract(year from lession_date)) as mdate"),
                            DB::raw("sum(NULLIF(teacher_earnings,0)) as expense"),
                            DB::raw("sum(NULLIF(admin_earnings,0)) as revenue")
                        )
                        ->whereRaw("date_part('year', lession_date) = date_part('year', CURRENT_DATE)")
                        ->whereIn('status',["completed", "student_not_show", "csd"])
                        ->groupBy(DB::raw('1,2'))->get()->toArray();


                $amounts = [];
                foreach ($services as $sda) {
                    $amounts[$sda['mdate']]['expense'] = $sda['expense'];
                    $amounts[$sda['mdate']]['revenue'] = $sda['revenue'];
                }

                $stDate = date('Y')."-01-01";
                $lastYear = $this->monthRange($stDate);

                $amtData = [];
                foreach ($lastYear as $day) {
                    $monDays = cal_days_in_month(CAL_GREGORIAN, date('m',strtotime($day)), date('Y'));
                    $amtData['lables'][] = $day;
                    $amtData['expense'][] = !empty($amounts[$day]['expense']) ? (int)$amounts[$day]['expense'] : 0;
                    $amtData['revenue'][] = !empty($amounts[$day]['revenue']) ? (int)$amounts[$day]['revenue'] : 0;
                    $amtData['ultimate'][] = !empty($settings['ultimate']) ? $settings['ultimate'] * $monDays : 0;
                    $amtData['ideal'][] = !empty($settings['ideal']) ? $settings['ideal'] * $monDays : 0;
                    $amtData['target'][] = !empty($settings['target']) ? $settings['target'] * $monDays  : 0;
                    $amtData['minimum'][] = !empty($settings['minimum']) ? $settings['minimum'] * $monDays : 0;
                    $amtData['avg'][] = ($settings['minimum'] + $settings['target'] + $settings['ideal'] + $settings['ultimate'])/4;
                }

            } else {
                $services=StudentLessonsBooking:: select(
                                            DB::raw("to_char(lession_date, 'DD Mon') as date"),
                                            DB::raw("sum(NULLIF(teacher_earnings,0)) as expense"),
                                            DB::raw("sum(NULLIF(admin_earnings,0)) as revenue")
                                        )
                                        ->whereRaw("to_char(lession_date, 'YYYY-MM-DD') between '" . $last_date . "' and '" . $today . "'")->whereIn('status',["completed", "student_not_show", "csd"])
                                        ->groupBy('date')->get()->toArray();

                $amounts = [];
                foreach ($services as $sda) {
                    $amounts[$sda['date']]['expense'] = $sda['expense'];
                    $amounts[$sda['date']]['revenue'] = $sda['revenue'];
                }

                $lastWeek = $this->daterange($last_date,$today);
                $amtData = [];
                foreach ($lastWeek as $day) {
                    $amtData['lables'][] = $day;
                    $amtData['expense'][] = !empty($amounts[$day]['expense']) ? (int)$amounts[$day]['expense'] : 0;
                    $amtData['revenue'][] = !empty($amounts[$day]['revenue']) ? (int)$amounts[$day]['revenue'] : 0;
                    $amtData['ultimate'][] = !empty($settings['ultimate']) ? (int)$settings['ultimate'] : 0;
                    $amtData['ideal'][] = !empty($settings['ideal']) ? (int)$settings['ideal'] : 0;
                    $amtData['target'][] = !empty($settings['target']) ? (int)$settings['target'] : 0;
                    $amtData['minimum'][] = !empty($settings['minimum']) ? (int)$settings['minimum'] : 0;
                    $amtData['avg'][] = ($settings['minimum'] + $settings['target'] + $settings['ideal'] + $settings['ultimate'])/4;
                }
            }
        }

        return $amtData;
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
