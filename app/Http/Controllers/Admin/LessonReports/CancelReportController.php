<?php

namespace App\Http\Controllers\Admin\LessonReports;

use App\Models\StudentLessons;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Locations;
use App\Models\StudentLessonsBooking;
use App\Models\StudentTransactions;
use App\Models\TeacherRatings;
use Illuminate\Support\Facades\DB;

class CancelReportController extends Controller
{
    public function index(Request $request) {
        $input  = $request->all();
        $option = !empty($input['opt']) ? $input['opt'] : 'total_cancelled';

        switch ($option) {
            case 'total_cancelled':
                return $this->totalCancelled($input);
                break;

            case 'total_cancelled_per_teacher':
                return $this->totalCancelledPerTeacher($input);
                break;

            case 'total_cancelled_per_student':
                return $this->totalCancelledPerStudent($input);
                break;

            case 'total_cancelled_per_location':
                return $this->totalCancelledPerLocation($input);
                break;

            case 'time_of_cancellations':
                return $this->timeOfCancellations($input);
                break;
        }
    }

    private function totalCancelled($input = array()){
        $filter = !empty($input['filter']) ? $input['filter'] : '';
        $option = !empty($input['opt']) ? $input['opt'] : 'total_cancelled';
        $sort   = !empty($input['sort']) ? $input['sort'] : '';
        $last_date = date('Y-m-d', strtotime('-6 days'));
        $today = date('Y-m-d', strtotime(today()));

        $type = !empty($input['type']) ? $input['type'] : '';
        $status = !empty($input['type']) ? [$input['type']] : ['csd', 'cancel', 'student_not_show', 'teacher_not_show'];

        $from_date = !empty($input['from_date']) ? $input['from_date'] : '';
        $to_date   = !empty($input['to_date']) ? $input['to_date'] : '';

        if(!empty($from_date) && !empty($to_date)){
            $filter = '';
            $bdays = $this->dateDiff($from_date, $to_date);

            if($bdays >= 0 && $bdays < 31){
                $amountSql = StudentLessonsBooking:: select(
                            DB::raw("to_char(lession_date, 'DD Mon') as date"),
                            DB::raw("count(*) as total")
                        )
                        ->whereRaw("lession_date >= '".$from_date."'::date")
                        ->whereRaw("lession_date < '".date('Y-m-d',strtotime('+1 day', strtotime($to_date))) ."'::date")
                        ->whereIn('status',$status);

                /*if($type == 'CSD'){
                    $amountSql->whereRaw("cancelled_at::date = lession_date::date");
                } elseif( $type == 'Snoshow') {
                    $amountSql->where('is_student_present',1);
                } elseif( $type == 'Tnoshow') {
                    $amountSql->where('is_teacher_present',1);
                }*/

                $amounts = $amountSql->groupBy('date')->pluck('total','date')->toArray();

                $lastMonth = $this->daterange($from_date,$to_date);
                $amtData = [];
                foreach ($lastMonth as $day) {
                    $amtData['lables'][] = $day;
                    $amtData['data'][] = !empty($amounts[$day]) ? (int)$amounts[$day] : 0;
                }
            } else {
                 $amountSql = StudentLessonsBooking:: select(
                            DB::raw("to_char(lession_date,'Mon') as mon"),
                            DB::raw("extract(year from lession_date) as yyyy"),
                            DB::raw("CONCAT(to_char(lession_date,'Mon') ,' ',extract(year from lession_date)) as mdate"),
                            DB::raw("count(*) as total")
                        )
                        ->whereRaw("lession_date >= '".$from_date."'::date")
                        ->whereRaw("lession_date < '".date('Y-m-d',strtotime('+1 day', strtotime($to_date))) ."'::date")
                        ->whereIn('status',$status);

                /*if($type == 'CSD'){
                    $amountSql->whereRaw("cancelled_at::date = lession_date::date");
                } elseif( $type == 'Snoshow') {
                    $amountSql->where('is_student_present',1);
                } elseif( $type == 'Tnoshow') {
                    $amountSql->where('is_teacher_present',1);
                }*/

                $amounts = $amountSql->groupBy(DB::raw('1,2'))->pluck('total','mdate')->toArray();

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

                $amountSql = StudentLessonsBooking:: select(
                            DB::raw("to_char(lession_date, 'DD Mon') as date"),
                            DB::raw("count(*) as total")
                        )
                        ->whereRaw("to_char(lession_date, 'YYYY-MM') like '" . $date . "'")
                        ->whereIn('status',$status);

                /*if($type == 'CSD'){
                    $amountSql->whereRaw("cancelled_at::date = lession_date::date");
                } elseif( $type == 'Snoshow') {
                    $amountSql->where('is_student_present',1);
                } elseif( $type == 'Tnoshow') {
                    $amountSql->where('is_teacher_present',1);
                }*/

                $amounts = $amountSql->groupBy('date')->pluck('total','date')->toArray();

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
                $amountSql = StudentLessonsBooking::select(
                                    DB::raw("to_char(lession_date, 'DD Mon YYYY') as date"),
                                    DB::raw("count(*) as total")
                                )
                                ->whereRaw("to_char(lession_date, 'YYYY-MM-DD') like '" . $date . "'")
                                ->whereIn('status',$status);

                /*if($type == 'CSD'){
                    $amountSql->whereRaw("cancelled_at::date = lession_date::date");
                } elseif( $type == 'Snoshow') {
                    $amountSql->where('is_student_present',1);
                } elseif( $type == 'Tnoshow') {
                    $amountSql->where('is_teacher_present',1);
                }*/

                $amounts = $amountSql->groupBy('date')->get()->toArray();

                $amtData = [];
                $amtData['lables'][] = date('d M Y');
                $amtData['data'][] = !empty($amounts[0]['total']) ? (int)$amounts[0]['total'] : 0;
            } elseif (!empty($filter) && $filter == 'y') {
                $amountSql = StudentLessonsBooking:: select(
                            DB::raw("to_char(lession_date,'Mon') as mon"),
                            DB::raw("extract(year from lession_date) as yyyy"),
                            DB::raw("CONCAT(to_char(lession_date,'Mon') ,' ',extract(year from lession_date)) as mdate"),
                            DB::raw("count(*) as total")
                        )
                        ->whereRaw("date_part('year', lession_date) = date_part('year', CURRENT_DATE)")
                        ->whereIn('status',$status);

                /*if($type == 'CSD'){
                    $amountSql->whereRaw("cancelled_at::date = lession_date::date");
                } elseif( $type == 'Snoshow') {
                    $amountSql->where('is_student_present',1);
                } elseif( $type == 'Tnoshow') {
                    $amountSql->where('is_teacher_present',1);
                }*/

                $amounts = $amountSql->groupBy(DB::raw('1,2'))->pluck('total','mdate')->toArray();

                $stDate = date('Y')."-01-01";
                $lastYear = $this->monthRange($stDate);

                $amtData = [];
                foreach ($lastYear as $day) {
                    $amtData['lables'][] = $day;
                    $amtData['data'][] = !empty($amounts[$day]) ? (int)$amounts[$day] : 0;
                }
            } else {
                $amountSql = StudentLessonsBooking:: select(
                                            DB::raw("to_char(lession_date, 'DD Mon') as date"),
                                            DB::raw("count(*) as total")
                                        )
                                        ->whereRaw("to_char(lession_date, 'YYYY-MM-DD') between '" . $last_date . "' and'" . $today . "'")
                                        ->whereIn('status',$status);

                /*if($type == 'CSD'){
                    $amountSql->whereRaw("cancelled_at::date = lession_date::date");
                } elseif( $type == 'Snoshow') {
                    $amountSql->where('is_student_present',1);
                } elseif( $type == 'Tnoshow') {
                    $amountSql->where('is_teacher_present',1);
                }*/

                $amounts = $amountSql->groupBy('date')->pluck('total','date')->toArray();

                $lastWeek = $this->daterange($last_date,$today);
                $amtData = [];
                foreach ($lastWeek as $day) {
                    $amtData['lables'][] = $day;
                    $amtData['data'][] = !empty($amounts[$day]) ? (int)$amounts[$day] : 0;
                }
            }
        }

        return view('admin.reports.cancelled.index', compact('amounts','filter','option','sort','amtData','type','from_date','to_date'));
    }

    private function totalCancelledPerTeacher($input = array()){
        $filter = !empty($input['filter']) ? $input['filter'] : '';
        $option = !empty($input['opt']) ? $input['opt'] : '';
        $sort   = !empty($input['sort']) ? $input['sort'] : '';
        $last_date = date('Y-m-d', strtotime('-6 days'));
        $today = date('Y-m-d', strtotime(today()));
        $user_id = !empty($input['user_id']) ? $input['user_id'] : '';
        $type = !empty($input['type']) ? $input['type'] : '';
        $status = !empty($input['type']) ? [$input['type']] : ['csd', 'cancel', 'student_not_show', 'teacher_not_show'];

        $from_date = !empty($input['from_date']) ? $input['from_date'] : '';
        $to_date   = !empty($input['to_date']) ? $input['to_date'] : '';
        $users = User::where('user_type','teacher')->where('status',1)->get()->toArray();

        if(!$user_id){
            $user_id = current($users)['id'];
        }

        if(!empty($from_date) && !empty($to_date)){
            $filter = '';
            $bdays = $this->dateDiff($from_date, $to_date);

            if($bdays >= 0 && $bdays < 31){
                $amountSql = StudentLessonsBooking:: select(
                                DB::raw("to_char(lession_date, 'DD Mon') as date"),
                                DB::raw("count(*) as total")
                            )
                            ->whereRaw("lession_date >= '".$from_date."'::date")
                            ->whereRaw("lession_date < '".date('Y-m-d',strtotime('+1 day', strtotime($to_date))) ."'::date")
                            ->whereIn('status',$status)
                            ->where('teacher_id', $user_id);


                /*if($type == 'CSD'){
                    $amountSql->whereRaw("cancelled_at::date = lession_date::date");
                } elseif( $type == 'Snoshow') {
                    $amountSql->where('is_student_present',1);
                } elseif( $type == 'Tnoshow') {
                    $amountSql->where('is_teacher_present',1);
                }*/

                $amounts = $amountSql->groupBy('date')->pluck('total','date')->toArray();

                $lastMonth = $this->daterange($from_date,$to_date);
                $amtData = [];
                foreach ($lastMonth as $day) {
                    $amtData['lables'][] = $day;
                    $amtData['data'][] = !empty($amounts[$day]) ? (int)$amounts[$day] : 0;
                }
            } else {
                $amounts = StudentTransactions:: select(
                            DB::raw("to_char(created_at,'Mon') as mon"),
                            DB::raw("extract(year from created_at) as yyyy"),
                            DB::raw("CONCAT(to_char(created_at,'Mon') ,' ',extract(year from created_at)) as mdate"),
                            DB::raw("sum(NULLIF(amount,0)) as total")
                        )
                        ->whereRaw("created_at >= '".$from_date."'::date")
                        ->whereRaw("created_at < '".date('Y-m-d',strtotime('+1 day', strtotime($to_date))) ."'::date")
                        ->where('user_id', $user_id)
                        ->groupBy(DB::raw('1,2'))->pluck('total','mdate')->toArray();

                $amountSql = StudentLessonsBooking:: select(
                            DB::raw("to_char(lession_date,'Mon') as mon"),
                            DB::raw("extract(year from lession_date) as yyyy"),
                            DB::raw("CONCAT(to_char(lession_date,'Mon') ,' ',extract(year from lession_date)) as mdate"),
                            DB::raw("count(*) as total")
                        )
                        ->whereRaw("lession_date >= '".$from_date."'::date")
                        ->whereRaw("lession_date < '".date('Y-m-d',strtotime('+1 day', strtotime($to_date))) ."'::date")
                        ->where('teacher_id', $user_id)
						->whereIn('status',$status);
                        ;

                /*if($type == 'CSD'){
                    $amountSql->whereRaw("cancelled_at::date = lession_date::date");
                } elseif( $type == 'Snoshow') {
                    $amountSql->where('is_student_present',1);
                } elseif( $type == 'Tnoshow') {
                    $amountSql->where('is_teacher_present',1);
                }*/

                $amounts = $amountSql->groupBy(DB::raw('1,2'))->pluck('total','mdate')->toArray();

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

                $amountSql = StudentLessonsBooking:: select(
                                DB::raw("to_char(lession_date, 'DD Mon') as date"),
                                DB::raw("count(*) as total")
                            )
                            ->whereRaw("to_char(lession_date, 'YYYY-MM') like '" . $date . "'")
                            ->whereIn('status',$status)
                            ->where('teacher_id', $user_id);


                /*if($type == 'CSD'){
                    $amountSql->whereRaw("cancelled_at::date = lession_date::date");
                } elseif( $type == 'Snoshow') {
                    $amountSql->where('is_student_present',1);
                } elseif( $type == 'Tnoshow') {
                    $amountSql->where('is_teacher_present',1);
                }*/

                $amounts = $amountSql->groupBy('date')->pluck('total','date')->toArray();

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

                $amountSql = StudentLessonsBooking::select(
                                    DB::raw("to_char(lession_date, 'DD Mon YYYY') as date"),
                                    DB::raw("count(*) as total")
                                )
                                ->whereRaw("to_char(lession_date, 'YYYY-MM-DD') like '" . $date . "'")
                                ->where('teacher_id', $user_id)
								->whereIn('status',$status);


                /*if($type == 'CSD'){
                    $amountSql->whereRaw("cancelled_at::date = lession_date::date");
                } elseif( $type == 'Snoshow') {
                    $amountSql->where('is_student_present',1);
                } elseif( $type == 'Tnoshow') {
                    $amountSql->where('is_teacher_present',1);
                }*/

                $amounts = $amountSql->groupBy('date')->get()->toArray();

                $amtData = [];
                $amtData['lables'][] = date('d M Y');
                $amtData['data'][] = !empty($amounts[0]['total']) ? (int)$amounts[0]['total'] : 0;


            } elseif (!empty($filter) && $filter == 'y') {
                $amountSql = StudentLessonsBooking:: select(
                            DB::raw("to_char(lession_date,'Mon') as mon"),
                            DB::raw("extract(year from lession_date) as yyyy"),
                            DB::raw("CONCAT(to_char(lession_date,'Mon') ,' ',extract(year from lession_date)) as mdate"),
                            DB::raw("count(*) as total")
                        )
                        ->whereRaw("date_part('year', lession_date) = date_part('year', CURRENT_DATE)")
                        ->where('teacher_id', $user_id)
						->whereIn('status',$status);
                        ;

                /*if($type == 'CSD'){
                    $amountSql->whereRaw("cancelled_at::date = lession_date::date");
                } elseif( $type == 'Snoshow') {
                    $amountSql->where('is_student_present',1);
                } elseif( $type == 'Tnoshow') {
                    $amountSql->where('is_teacher_present',1);
                }*/

                $amounts = $amountSql->groupBy(DB::raw('1,2'))->pluck('total','mdate')->toArray();

                $stDate = date('Y')."-01-01";
                $lastYear = $this->monthRange($stDate);

                $amtData = [];
                foreach ($lastYear as $day) {
                    $amtData['lables'][] = $day;
                    $amtData['data'][] = !empty($amounts[$day]) ? (int)$amounts[$day] : 0;
                }

            } else {
                $amountSql=StudentLessonsBooking:: select(
                                            DB::raw("to_char(lession_date, 'DD Mon') as date"),
                                            DB::raw("count(*) as total")
                                        )
                                        ->whereRaw("to_char(lession_date, 'YYYY-MM-DD') between '" . $last_date . "' and'" . $today . "'")
                                        ->where('teacher_id', $user_id)
										->whereIn('status',$status);
                                        ;

                /*if($type == 'CSD'){
                    $amountSql->whereRaw("cancelled_at::date = lession_date::date");
                } elseif( $type == 'Snoshow') {
                    $amountSql->where('is_student_present',1);
                } elseif( $type == 'Tnoshow') {
                    $amountSql->where('is_teacher_present',1);
                }*/

                $amounts = $amountSql->groupBy('date')->pluck('total','date')->toArray();

                $lastWeek = $this->daterange($last_date,$today);
                $amtData = [];
                foreach ($lastWeek as $day) {
                    $amtData['lables'][] = $day;
                    $amtData['data'][] = !empty($amounts[$day]) ? (int)$amounts[$day] : 0;
                }
            }
        }

        if(!$amtData){
            $amtData['lables'] = [];
            $amtData['data'] = [];
        }

        return view('admin.reports.cancelled.index', compact('amounts','filter','option','user_id','sort','amtData','users','from_date','to_date','type'));
    }

    private function totalCancelledPerStudent($input = array()){
        $filter = !empty($input['filter']) ? $input['filter'] : '';
        $option = !empty($input['opt']) ? $input['opt'] : '';
        $sort   = !empty($input['sort']) ? $input['sort'] : '';
        $last_date = date('Y-m-d', strtotime('-6 days'));
        $today = date('Y-m-d', strtotime(today()));
        $user_id = !empty($input['user_id']) ? $input['user_id'] : '';
        $type = !empty($input['type']) ? $input['type'] : '';
        $status = !empty($input['type']) ? [$input['type']] : ['csd', 'cancel', 'student_not_show', 'teacher_not_show'];

        $users = User::where('user_type','student')
			->join('student_lessons', 'users.id', 'student_lessons.user_id')
			->whereRaw("student_lessons.expire_date >= '".date('Y-m-d')."'")
			->whereNotIn('student_lessons.service_id', [env('ONEPAGE_SERVICE_ID'), env('REGISTRATION_SERVICE_ID')])
			->where('users.status',1)
			->orderBy('firstname')
			->get()
			->toArray();
        $from_date = !empty($input['from_date']) ? $input['from_date'] : '';
        $to_date   = !empty($input['to_date']) ? $input['to_date'] : '';

        if(!empty($from_date) && !empty($to_date)){
            $filter = '';
            $bdays = $this->dateDiff($from_date, $to_date);

            if($bdays >= 0 && $bdays < 31){

                $amountSql = StudentLessonsBooking:: select(
                                DB::raw("to_char(lession_date, 'DD Mon') as date"),
                                DB::raw("count(*) as total")
                            )
                            ->whereRaw("lession_date >= '".$from_date."'::date")
                            ->whereRaw("lession_date < '".date('Y-m-d',strtotime('+1 day', strtotime($to_date))) ."'::date")
                            ->whereIn('status',$status)
                            ->where('user_id', $user_id)
                            ;

                /*if($type == 'CSD'){
                    $amountSql->whereRaw("cancelled_at::date = lession_date::date");
                } elseif( $type == 'Snoshow') {
                    $amountSql->where('is_student_present',1);
                } elseif( $type == 'Tnoshow') {
                    $amountSql->where('is_teacher_present',1);
                }*/

                $amounts = $amountSql->groupBy('date')->pluck('total','date')->toArray();

                $lastMonth = $this->daterange($from_date,$to_date);
                $amtData = [];
                foreach ($lastMonth as $day) {
                    $amtData['lables'][] = $day;
                    $amtData['data'][] = !empty($amounts[$day]) ? (int)$amounts[$day] : 0;
                }
            } else {

                $amountSql = StudentLessonsBooking:: select(
                            DB::raw("to_char(lession_date,'Mon') as mon"),
                            DB::raw("extract(year from lession_date) as yyyy"),
                            DB::raw("CONCAT(to_char(lession_date,'Mon') ,' ',extract(year from lession_date)) as mdate"),
                            DB::raw("count(*) as total")
                        )
                        ->whereRaw("lession_date >= '".$from_date."'::date")
                        ->whereRaw("lession_date < '".date('Y-m-d',strtotime('+1 day', strtotime($to_date))) ."'::date")
                        ->where('user_id', $user_id)
						->whereIn('status',$status)
                        ;

                /*if($type == 'CSD'){
                    $amountSql->whereRaw("cancelled_at::date = lession_date::date");
                } elseif( $type == 'Snoshow') {
                    $amountSql->where('is_student_present',1);
                } elseif( $type == 'Tnoshow') {
                    $amountSql->where('is_teacher_present',1);
                }*/

                $amounts = $amountSql->groupBy(DB::raw('1,2'))->pluck('total','mdate')->toArray();

                $lastYear = $this->monthRange($from_date,$to_date);
                $amtData = [];
                foreach ($lastYear as $day) {
                    $amtData['lables'][] = $day;
                    $amtData['data'][] = !empty($amounts[$day]) ? (int)$amounts[$day] : 0;
                }
            }
        } else {

            if(!$user_id){
                $user_id = current($users)['id'];
            }

            if (!empty($filter) && $filter == 'm') {
                $date = date('Y-m', strtotime(today()));
                $amountSql = StudentLessonsBooking:: select(
                                DB::raw("to_char(lession_date, 'DD Mon') as date"),
                                DB::raw("count(*) as total")
                            )
                            ->whereRaw("to_char(lession_date, 'YYYY-MM') like '" . $date . "'")
                            ->whereIn('status',$status)
                            ->where('user_id', $user_id)
                            ;

                /*if($type == 'CSD'){
                    $amountSql->whereRaw("cancelled_at::date = lession_date::date");
                } elseif( $type == 'Snoshow') {
                    $amountSql->where('is_student_present',1);
                } elseif( $type == 'Tnoshow') {
                    $amountSql->where('is_teacher_present',1);
                }*/

                $amounts = $amountSql->groupBy('date')->pluck('total','date')->toArray();

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

                $amountSql = StudentLessonsBooking::select(
                                    DB::raw("to_char(lession_date, 'DD Mon YYYY') as date"),
                                    DB::raw("count(*) as total")
                                )
                                ->whereRaw("to_char(lession_date, 'YYYY-MM-DD') like '" . $date . "'")
                                ->where('user_id', $user_id)
								->whereIn('status',$status)
                                ;


                /*if($type == 'CSD'){
                    $amountSql->whereRaw("cancelled_at::date = lession_date::date");
                } elseif( $type == 'Snoshow') {
                    $amountSql->where('is_student_present',1);
                } elseif( $type == 'Tnoshow') {
                    $amountSql->where('is_teacher_present',1);
                }*/

                $amounts = $amountSql->groupBy('date')->get()->toArray();

                $amtData = [];
                $amtData['lables'][] = date('d M Y');
                $amtData['data'][] = !empty($amounts[0]['total']) ? (int)$amounts[0]['total'] : 0;


            } elseif (!empty($filter) && $filter == 'y') {
                $amountSql = StudentLessonsBooking:: select(
                            DB::raw("to_char(lession_date,'Mon') as mon"),
                            DB::raw("extract(year from lession_date) as yyyy"),
                            DB::raw("CONCAT(to_char(lession_date,'Mon') ,' ',extract(year from lession_date)) as mdate"),
                            DB::raw("count(*) as total")
                        )
                        ->whereRaw("date_part('year', lession_date) = date_part('year', CURRENT_DATE)")
                        ->where('user_id', $user_id)
						->whereIn('status',$status)
                        ;

                /*if($type == 'CSD'){
                    $amountSql->whereRaw("cancelled_at::date = lession_date::date");
                } elseif( $type == 'Snoshow') {
                    $amountSql->where('is_student_present',1);
                } elseif( $type == 'Tnoshow') {
                    $amountSql->where('is_teacher_present',1);
                }*/

                $amounts = $amountSql->groupBy(DB::raw('1,2'))->pluck('total','mdate')->toArray();

                $stDate = date('Y')."-01-01";
                $lastYear = $this->monthRange($stDate);

                $amtData = [];
                foreach ($lastYear as $day) {
                    $amtData['lables'][] = $day;
                    $amtData['data'][] = !empty($amounts[$day]) ? (int)$amounts[$day] : 0;
                }

            } else {
                $amountSql = StudentLessonsBooking:: select(
                                            DB::raw("to_char(lession_date, 'DD Mon') as date"),
                                            DB::raw("count(*) as total")
                                        )
                                        ->whereRaw("to_char(lession_date, 'YYYY-MM-DD') between '" . $last_date . "' and'" . $today . "'")
                                        ->where('user_id', $user_id)
										->whereIn('status',$status)
                                        ;

                /*if($type == 'CSD'){
                    $amountSql->whereRaw("cancelled_at::date = lession_date::date");
                } elseif( $type == 'Snoshow') {
                    $amountSql->where('is_student_present',1);
                } elseif( $type == 'Tnoshow') {
                    $amountSql->where('is_teacher_present',1);
                }*/

                $amounts = $amountSql->groupBy('date')->pluck('total','date')->toArray();

                $lastWeek = $this->daterange($last_date,$today);
                $amtData = [];
                foreach ($lastWeek as $day) {
                    $amtData['lables'][] = $day;
                    $amtData['data'][] = !empty($amounts[$day]) ? (int)$amounts[$day] : 0;
                }
            }
        }

        if(!$amtData){
            $amtData['lables'] = [];
            $amtData['data'] = [];
        }

        return view('admin.reports.cancelled.index', compact('amounts','filter','option','user_id','sort','amtData','users','from_date','to_date','type'));
    }

    private function totalCancelledPerLocation($input = array()){
        $filter = !empty($input['filter']) ? $input['filter'] : '';
        $option = !empty($input['opt']) ? $input['opt'] : '';
        $sort   = !empty($input['sort']) ? $input['sort'] : '';
        $last_date = date('Y-m-d', strtotime('-6 days'));
        $today = date('Y-m-d', strtotime(today()));
        $location_id = !empty($input['location_id']) ? $input['location_id'] : '';
        $type = !empty($input['type']) ? $input['type'] : '';
        $status = !empty($input['type']) ? [$input['type']] : ['csd', 'cancel', 'student_not_show', 'teacher_not_show'];

        $from_date = !empty($input['from_date']) ? $input['from_date'] : '';
        $to_date   = !empty($input['to_date']) ? $input['to_date'] : '';

        $locations = Locations::where('status',1)->get()->toArray();

        if(!$location_id){
            $location_id = current($locations)['id'];
        }

        if(!empty($from_date) && !empty($to_date)){
            $filter = '';
            $bdays = $this->dateDiff($from_date, $to_date);

            if($bdays >= 0 && $bdays < 31){
                $amountSql = StudentLessonsBooking:: select(
                                DB::raw("to_char(lession_date, 'DD Mon') as date"),
                                DB::raw("count(*) as total")
                            )
                            ->whereRaw("lession_date >= '".$from_date."'::date")
                            ->whereRaw("lession_date < '".date('Y-m-d',strtotime('+1 day', strtotime($to_date))) ."'::date")
                            ->whereIn('status',$status)
                            ->where('location_id', $location_id)
                            ;

                /*if($type == 'CSD'){
                    $amountSql->whereRaw("lession_date::date = lession_date::date");
                } elseif( $type == 'Snoshow') {
                    $amountSql->where('is_student_present',1);
                } elseif( $type == 'Tnoshow') {
                    $amountSql->where('is_teacher_present',1);
                }*/

                $amounts = $amountSql->groupBy('date')->pluck('total','date')->toArray();


                $lastMonth = $this->daterange($from_date,$to_date);
                $amtData = [];
                foreach ($lastMonth as $day) {
                    $amtData['lables'][] = $day;
                    $amtData['data'][] = !empty($amounts[$day]) ? (int)$amounts[$day] : 0;
                }
            } else {

                $amountSql = StudentLessonsBooking:: select(
                            DB::raw("to_char(lession_date,'Mon') as mon"),
                            DB::raw("extract(year from lession_date) as yyyy"),
                            DB::raw("CONCAT(to_char(lession_date,'Mon') ,' ',extract(year from lession_date)) as mdate"),
                            DB::raw("count(*) as total")
                        )
                        ->whereRaw("lession_date >= '".$from_date."'::date")
                        ->whereRaw("lession_date < '".date('Y-m-d',strtotime('+1 day', strtotime($to_date))) ."'::date")
                        ->where('location_id', $location_id)
						->whereIn('status',$status)
                        ;

                /*if($type == 'CSD'){
                    $amountSql->whereRaw("cancelled_at::date = lession_date::date");
                } elseif( $type == 'Snoshow') {
                    $amountSql->where('is_student_present',1);
                } elseif( $type == 'Tnoshow') {
                    $amountSql->where('is_teacher_present',1);
                }*/

                $amounts = $amountSql->groupBy(DB::raw('1,2'))->pluck('total','mdate')->toArray();

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

                $amountSql = StudentLessonsBooking:: select(
                                DB::raw("to_char(lession_date, 'DD Mon') as date"),
                                DB::raw("count(*) as total")
                            )
                            ->whereRaw("to_char(lession_date, 'YYYY-MM') like '" . $date . "'")
                            ->whereIn('status',$status)
                            ->where('location_id', $location_id)
                            ;

                /*if($type == 'CSD'){
                    $amountSql->whereRaw("cancelled_at::date = lession_date::date");
                } elseif( $type == 'Snoshow') {
                    $amountSql->where('is_student_present',1);
                } elseif( $type == 'Tnoshow') {
                    $amountSql->where('is_teacher_present',1);
                }*/

                $amounts = $amountSql->groupBy('date')->pluck('total','date')->toArray();

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

                $amountSql = StudentLessonsBooking::select(
                                    DB::raw("to_char(lession_date, 'DD Mon YYYY') as date"),
                                    DB::raw("count(*) as total")
                                )
                                ->whereRaw("to_char(lession_date, 'YYYY-MM-DD') like '" . $date . "'")
                                ->where('location_id', $location_id)
								->whereIn('status',$status)
                                ;

                /*if($type == 'CSD'){
                    $amountSql->whereRaw("cancelled_at::date = lession_date::date");
                } elseif( $type == 'Snoshow') {
                    $amountSql->where('is_student_present',1);
                } elseif( $type == 'Tnoshow') {
                    $amountSql->where('is_teacher_present',1);
                }*/

                $amounts = $amountSql->groupBy('date')->get()->toArray();

                $amtData = [];
                $amtData['lables'][] = date('d M Y');
                $amtData['data'][] = !empty($amounts[0]['total']) ? (int)$amounts[0]['total'] : 0;


            } elseif (!empty($filter) && $filter == 'y') {
                $amountSql = StudentLessonsBooking:: select(
                            DB::raw("to_char(lession_date,'Mon') as mon"),
                            DB::raw("extract(year from lession_date) as yyyy"),
                            DB::raw("CONCAT(to_char(lession_date,'Mon') ,' ',extract(year from lession_date)) as mdate"),
                            DB::raw("count(*) as total")
                        )
                        ->whereRaw("date_part('year', lession_date) = date_part('year', CURRENT_DATE)")
                        ->where('location_id', $location_id)
						->whereIn('status',$status)
                        ;

                /*if($type == 'CSD'){
                    $amountSql->whereRaw("cancelled_at::date = lession_date::date");
                } elseif( $type == 'Snoshow') {
                    $amountSql->where('is_student_present',1);
                } elseif( $type == 'Tnoshow') {
                    $amountSql->where('is_teacher_present',1);
                }*/

                $amounts = $amountSql->groupBy(DB::raw('1,2'))->pluck('total','mdate')->toArray();

                $stDate = date('Y')."-01-01";
                $lastYear = $this->monthRange($stDate);

                $amtData = [];
                foreach ($lastYear as $day) {
                    $amtData['lables'][] = $day;
                    $amtData['data'][] = !empty($amounts[$day]) ? (int)$amounts[$day] : 0;
                }

            } else {
                $amountSql = StudentLessonsBooking:: select(
                                            DB::raw("to_char(lession_date, 'DD Mon') as date"),
                                            DB::raw("count(*) as total")
                                        )
                                        ->whereRaw("to_char(lession_date, 'YYYY-MM-DD') between '" . $last_date . "' and'" . $today . "'")
                                        ->where('location_id', $location_id)
										->whereIn('status',$status)
                                        ;

                /*if($type == 'CSD'){
                    $amountSql->whereRaw("cancelled_at::date = lession_date::date");
                } elseif( $type == 'Snoshow') {
                    $amountSql->where('is_student_present',1);
                } elseif( $type == 'Tnoshow') {
                    $amountSql->where('is_teacher_present',1);
                }*/

                $amounts = $amountSql->groupBy('date')->pluck('total','date')->toArray();

                $lastWeek = $this->daterange($last_date,$today);
                $amtData = [];
                foreach ($lastWeek as $day) {
                    $amtData['lables'][] = $day;
                    $amtData['data'][] = !empty($amounts[$day]) ? (int)$amounts[$day] : 0;
                }
            }
        }

        if(!$amtData){
            $amtData['lables'] = [];
            $amtData['data'] = [];
        }

        return view('admin.reports.cancelled.index', compact('amounts','filter','option','location_id','locations','sort','amtData','from_date','to_date','type'));
    }

    private function timeOfCancellations($input = array()){
        $filter = !empty($input['filter']) ? $input['filter'] : '';
        $option = !empty($input['opt']) ? $input['opt'] : '';
        $sort   = !empty($input['sort']) ? $input['sort'] : '';
        $last_date = date('Y-m-d', strtotime('-6 days'));
        $today = date('Y-m-d', strtotime(today()));
        $type = !empty($input['type']) ? $input['type'] : '';
        $status = !empty($input['type']) ? [$input['type']] : ['csd', 'cancel', 'student_not_show', 'teacher_not_show'];

        $from_date = !empty($input['from_date']) ? $input['from_date'] : '';
        $to_date   = !empty($input['to_date']) ? $input['to_date'] : '';

        if(!empty($from_date) && !empty($to_date)){
            $filter = '';
            $bdays = $this->dateDiff($from_date, $to_date);

            if($bdays >= 0 && $bdays < 31){

                $amountSql = StudentLessonsBooking:: select(
                            DB::raw("to_char(lession_date, 'DD Mon') as date"),
                            DB::raw("count(*) as total")
                        )
                        ->whereRaw("lession_date >= '".$from_date."'::date")
                        ->whereRaw("lession_date < '".date('Y-m-d',strtotime('+1 day', strtotime($to_date))) ."'::date")
                        ->whereIn('status',$status)
                        ;



                /*if($type == 'CSD'){
                    $amountSql->whereRaw("cancelled_at::date = lession_date::date");
                } elseif( $type == 'Snoshow') {
                    $amountSql->where('is_student_present',1);
                } elseif( $type == 'Tnoshow') {
                    $amountSql->where('is_teacher_present',1);
                }*/


                $amounts = $amountSql->groupBy('date')->pluck('total','date')->toArray();



                $lastMonth = $this->daterange($from_date,$to_date);
                $amtData = [];
                foreach ($lastMonth as $day) {
                    $amtData['lables'][] = $day;
                    $amtData['data'][] = !empty($amounts[$day]) ? (int)$amounts[$day] : 0;
                }
            } else {
                $amountSql = StudentLessonsBooking:: select(
                            DB::raw("to_char(lession_date,'Mon') as mon"),
                            DB::raw("extract(year from lession_date) as yyyy"),
                            DB::raw("CONCAT(to_char(lession_date,'Mon') ,' ',extract(year from lession_date)) as mdate"),
                            DB::raw("count(*) as total")
                        )
                        ->whereRaw("lession_date >= '".$from_date."'::date")
                        ->whereRaw("lession_date < '".date('Y-m-d',strtotime('+1 day', strtotime($to_date))) ."'::date")
                        ->whereIn('status',$status)
                        ;

                /*if($type == 'CSD'){
                    $amountSql->whereRaw("cancelled_at::date = lession_date::date");
                } elseif( $type == 'Snoshow') {
                    $amountSql->where('is_student_present',1);
                } elseif( $type == 'Tnoshow') {
                    $amountSql->where('is_teacher_present',1);
                }*/

                $amounts = $amountSql->groupBy(DB::raw('1,2'))->pluck('total','mdate')->toArray();


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

                $amountSql = StudentLessonsBooking:: select(
                            DB::raw("to_char(lession_date, 'DD Mon') as date"),
                            DB::raw("count(*) as total")
                        )
                        ->whereRaw("to_char(lession_date, 'YYYY-MM') like '" . $date . "'")
                        ->whereIn('status',$status)
                        ;

                /*if($type == 'CSD'){
                    $amountSql->whereRaw("cancelled_at::date = lession_date::date");
                } elseif( $type == 'Snoshow') {
                    $amountSql->where('is_student_present',1);
                } elseif( $type == 'Tnoshow') {
                    $amountSql->where('is_teacher_present',1);
                }*/

                $amounts = $amountSql->groupBy('date')->pluck('total','date')->toArray();

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
                $amountSql = StudentLessonsBooking::select(
                                    DB::raw("to_char(lession_date, 'DD Mon YYYY') as date"),
                                    DB::raw("count(*) as total")
                                )
                                ->whereRaw("to_char(lession_date, 'YYYY-MM-DD') like '" . $date . "'")
                                ->whereIn('status',$status)
                                ;

                /*if($type == 'CSD'){
                    $amountSql->whereRaw("cancelled_at::date = lession_date::date");
                } elseif( $type == 'Snoshow') {
                    $amountSql->where('is_student_present',1);
                } elseif( $type == 'Tnoshow') {
                    $amountSql->where('is_teacher_present',1);
                }*/

                $amounts = $amountSql->groupBy('date')->get()->toArray();

                $amtData = [];
                $amtData['lables'][] = date('d M Y');
                $amtData['data'][] = !empty($amounts[0]['total']) ? (int)$amounts[0]['total'] : 0;
            } elseif (!empty($filter) && $filter == 'y') {
                $amountSql = StudentLessonsBooking:: select(
                            DB::raw("to_char(lession_date,'Mon') as mon"),
                            DB::raw("extract(year from lession_date) as yyyy"),
                            DB::raw("CONCAT(to_char(lession_date,'Mon') ,' ',extract(year from lession_date)) as mdate"),
                            DB::raw("count(*) as total")
                        )
                        ->whereRaw("date_part('year', lession_date) = date_part('year', CURRENT_DATE)")
                        ->whereIn('status',$status)
                        ;

                /*if($type == 'CSD'){
                    $amountSql->whereRaw("cancelled_at::date = lession_date::date");
                } elseif( $type == 'Snoshow') {
                    $amountSql->where('is_student_present',1);
                } elseif( $type == 'Tnoshow') {
                    $amountSql->where('is_teacher_present',1);
                }*/

                $amounts = $amountSql->groupBy(DB::raw('1,2'))->pluck('total','mdate')->toArray();

                $stDate = date('Y')."-01-01";
                $lastYear = $this->monthRange($stDate);

                $amtData = [];
                foreach ($lastYear as $day) {
                    $amtData['lables'][] = $day;
                    $amtData['data'][] = !empty($amounts[$day]) ? (int)$amounts[$day] : 0;
                }

            } else {
                $amountSql = StudentLessonsBooking:: select(
                                            DB::raw("to_char(lession_date, 'DD Mon') as date"),
                                            DB::raw("count(*) as total")
                                        )
                                        ->whereRaw("to_char(lession_date, 'YYYY-MM-DD') between '" . $last_date . "' and'" . $today . "'")
                                        ->whereIn('status',$status)
                                        ;

                /*if($type == 'CSD'){
                    $amountSql->whereRaw("cancelled_at::date = lession_date::date");
                } elseif( $type == 'Snoshow') {
                    $amountSql->where('is_student_present',1);
                } elseif( $type == 'Tnoshow') {
                    $amountSql->where('is_teacher_present',1);
                }*/

                $amounts = $amountSql->groupBy('date')->pluck('total','date')->toArray();

                $lastWeek = $this->daterange($last_date,$today);
                $amtData = [];
                foreach ($lastWeek as $day) {
                    $amtData['lables'][] = $day;
                    $amtData['data'][] = !empty($amounts[$day]) ? (int)$amounts[$day] : 0;
                }
            }
        }

        return view('admin.reports.cancelled.index', compact('amounts','filter','option','sort','amtData','from_date','to_date','type'));
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
