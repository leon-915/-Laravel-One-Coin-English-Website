<?php

namespace App\Http\Controllers\Admin\LessonReports;

use App\Models\StudentLessons;
use App\Models\StudentLessonsBooking;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class AdminLessonController extends Controller
{
    public function index(Request $request) {

        $input  = $request->all();
        $option = !empty($input['opt']) ? $input['opt'] : '';

        switch ($option) {

            case 'per_stu':
                return $this->totalLessonByPerStudent($input);
                break;

            case 'top_students':
                return $this->Top10Students($input);
                break;

            case 'top_teachers':
                return $this->Top10Teachers($input);
                break;

            case 'allteachers':
                return $this->TotalLessonByTeacher($input);
                break;

            case 'total_trial_lessons':
                return $this->TotalTrialLession($input);
                break;

            default:
                return $this->totalLessonByAllStudent($input);
                break;
        }
    }

    private function totalLessonByAllStudent($input = array()){

        $filter = !empty($input['filter']) ? $input['filter'] : '';
        $filter2 = !empty($input['filter2']) ? $input['filter2'] : '';
        $option = !empty($input['opt']) ? $input['opt'] : '';
        $sort   = !empty($input['sort']) ? $input['sort'] : '';
        $last_date = date('Y-m-d', strtotime('-6 days'));
        $today = date('Y-m-d', strtotime(today()));
        $sid = !empty($input['sid']) ? $input['sid'] : '';

        $from_date = !empty($input['from_date']) ? date('Y-m-d', strtotime($input['from_date'])) : '';
        $to_date = !empty($input['to_date']) ? date('Y-m-d', strtotime($input['to_date'])) : '';

        if(!empty($from_date) && !empty($to_date)) {

            $date1=date_create($from_date);
            $date2=date_create($to_date);
            $diff=date_diff($date1,$date2);

            $stDate = $date1->format('Y-m-d');
            $endDate = $date2->format('Y-m-d');

            if($diff->d <= 30 and $diff->m == 0 and $diff->y == 0){

                $lessions = StudentLessonsBooking::select(
                    DB::raw("to_char(lession_date, 'DD Mon') as date"),
                    DB::raw("count(*) as count"))
                    ->whereRaw("to_char(lession_date, 'YYYY-MM-DD') >= '" . $stDate . "' and to_char(lession_date, 'YYYY-MM-DD') <= '" . $endDate . "'")
                    ->whereNotIn('status',['cancel', 'deleted'])
                    ->groupBy('date')->get()->pluck('count','date')->toArray();

                $lastYear = $this->dateRange($stDate,$endDate);

            } else{

                $lessions = StudentLessonsBooking::Select(
                    DB::raw("to_char(lession_date, 'Mon YYYY') as date"),
                    DB::raw("count(*) as count"))
                    //->whereRaw("date_part('month', lession_date) = date_part('month', CURRENT_DATE)")
					->whereRaw("to_char(lession_date, 'YYYY-MM-DD') >= '" . $stDate . "' and to_char(lession_date, 'YYYY-MM-DD') <= '" . $endDate . "'")
                    ->whereNotIn('status',['cancel', 'deleted'])
                    ->groupBy('date')->get()->pluck('count','date')->toArray();

                $lastYear = $this->monthRange($stDate);
            }

            $lessionsData = [];
            foreach ($lastYear as $key => $day) {
                $lessionsData['lables'][] = $day;
                $lessionsData['data'][] = !empty($lessions[$day]) ? (int)$lessions[$day] : 0;
            }

        } else {

            if (!empty($filter) && $filter == 'm') {

                $date = date('Y-m', strtotime(today()));

                $lessions = StudentLessonsBooking::select(
                    DB::raw("to_char(lession_date, 'DD Mon') as date"),
                    DB::raw("count(*) as count"))
                    ->whereRaw("to_char(lession_date, 'YYYY-MM') like '" . $date . "'")
                    ->whereNotIn('status',['cancel', 'deleted'])
                    ->groupBy('date')->get()->pluck('count','date')->toArray();

                $stDate = date('Y-m')."-01";
				
				$lastDateOfThisMonth =strtotime('last day of this month') ;
				$last_day = date('Y-m-d', $lastDateOfThisMonth);
                $week = $this->dateRange($stDate,$last_day);

                $lessionsData = [];
                foreach ($week as $key => $day) {
                    $lessionsData['lables'][] = $day;
                    $lessionsData['data'][] = !empty($lessions[$day]) ? (int)$lessions[$day] : 0;
                }

            } elseif (!empty($filter) && $filter == 'd') {

                $date = date('Y-m-d', strtotime(today()));

                $lessions = StudentLessonsBooking::select(
                    DB::raw("to_char(lession_date, 'DD Mon') as date"),
                    DB::raw("count(*) as count"))
                    ->whereRaw("to_char(lession_date, 'YYYY-MM-DD') like '" . $date . "'")
                    ->whereNotIn('status',['cancel', 'deleted'])
                    ->groupBy('date')->get()->pluck('count','date')->toArray();

                $week = $this->dateRange($today,$today);

                $lessionsData = [];
                foreach ($week as $key => $day) {
                    $lessionsData['lables'][] = $day;
                    $lessionsData['data'][] = !empty($lessions[$day]) ? (int)$lessions[$day] : 0;
                }

            } elseif (!empty($filter) && $filter == 'y') {
                $lessions = StudentLessonsBooking::Select(
                    DB::raw("to_char(lession_date, 'Mon YYYY') as date"),
                    DB::raw("count(*) as count"))
                    ->whereRaw("date_part('year', lession_date) = date_part('year', CURRENT_DATE)")
                    ->whereNotIn('status',['cancel', 'deleted'])
                    ->groupBy('date')->get()->pluck('count', 'date')->toArray();

                $stDate = date('Y') . "-01-01";
                $lastYear = $this->monthRange($stDate);

                $lessionsData = [];
                foreach ($lastYear as $key => $day) {
                    $lessionsData['lables'][] = $day;
                    $lessionsData['data'][] = !empty($lessions[$day]) ? (int)$lessions[$day] : 0;
                }
            }
            else {

                $lessions = StudentLessonsBooking::select(
                    DB::raw("to_char(lession_date, 'DD Mon') as date"),
                    DB::raw("count(*) as count"))
                    ->whereRaw("to_char(lession_date, 'YYYY-MM-DD') >= '" . $last_date . "' and to_char(lession_date, 'YYYY-MM-DD') <= '" . $today . "'")
                    ->whereNotIn('status',['cancel', 'deleted'])
                    ->groupBy('date')->get()->pluck('count','date')->toArray();

                $week = $this->dateRange($last_date,$today);
                $lessionsData = [];
                foreach ($week as $key => $day) {
                    $lessionsData['lables'][] = $day;
                    $lessionsData['data'][] = !empty($lessions[$day]) ? (int)$lessions[$day] : 0;
                }
            }

        }


        return view('admin.reports.admin-lessons.index', compact('lessionsData','lessions','filter','option','sort','sid','filter2'));
    }

    private function totalLessonByPerStudent($input = array()){

        $last_date = date('Y-m-d', strtotime('-6 days'));
        $today = date('Y-m-d', strtotime(today()));
        $filter = !empty($input['filter']) ? $input['filter'] : '';
        $option = !empty($input['opt']) ? $input['opt'] : '';
        $sort = !empty($input['sort']) ? $input['sort'] : '';
        $sid = !empty($input['sid']) ? $input['sid'] : '';

        $filter2 = !empty($input['filter2']) ? $input['filter2'] : '';
        $from_date = !empty($input['from_date']) ? date('Y-m-d', strtotime($input['from_date'])) : '';
        $to_date = !empty($input['to_date']) ? date('Y-m-d', strtotime($input['to_date'])) : '';


        $students = User::select('users.id', 'users.email', 'users.firstname',
                        DB::raw("CONCAT(users.firstname, ' ', users.lastname) AS full_name"))
						->join('student_lessons', 'users.id', 'student_lessons.user_id')
						//->join('student_packages', 'users.id', 'student_packages.user_id')
                        //->whereRaw("student_packages.end_date >= '".date('Y-m-d')."'")
                        ->whereRaw("student_lessons.expire_date >= '".date('Y-m-d')."'")
                        ->whereNotIn('student_lessons.service_id', [env('ONEPAGE_SERVICE_ID'), env('REGISTRATION_SERVICE_ID')])
                        ->where('user_type','student')
                        ->where('users.status',1)
						->orderBy('firstname')
						->groupBy('users.id')
                        ->get()->toArray();

//        $lessions = StudentLessonsBooking::Select(
//                    DB::raw("to_char(created_at, 'Mon YYYY') as date"),
//                    DB::raw("count(*) as count"))
//                    //->whereRaw("to_char(created_at, 'YYYY-MM-DD') between '" . $last_date . "' and'" . $today . "'")
//                    ->groupBy('date');


        if(!empty($from_date) && !empty($to_date)){

            $date1 = date_create($from_date);
            $date2 = date_create($to_date);
            $diff = date_diff($date1, $date2);
            $stDate = $date1->format('Y-m-d');
            $endDate = $date2->format('Y-m-d');
            $filter = '';

            if ($diff->d <= 30 and $diff->m == 0 and $diff->y == 0) {

                $week = $this->dateRange($stDate,$endDate);

                $lessions = StudentLessonsBooking::Select(
                    DB::raw("to_char(lession_date, 'DD Mon') as date"),
                    DB::raw("count(*) as count"))
                    ->whereRaw("to_char(student_lessons_bookings.lession_date, 'YYYY-MM-DD') >= '" . $stDate . "' and to_char(student_lessons_bookings.lession_date, 'YYYY-MM-DD') <= '" . $endDate . "'")
                    ->whereNotIn('status',['cancel', 'deleted'])
                    ->where(function ($q) use ($sid){
                        if($sid){
                            $q->where('user_id',$sid);
                        }
                    })
                    ->groupBy('date');
            } else {

                $week = $this->monthRange($stDate,$endDate);

                $lessions = StudentLessonsBooking::Select(
                    DB::raw("to_char(lession_date, 'Mon YYYY') as date"),
                    DB::raw("count(*) as count"))
                    //->whereRaw("date_part('month', lession_date) = date_part('month', CURRENT_DATE)")
					->whereRaw("to_char(student_lessons_bookings.lession_date, 'YYYY-MM-DD') >= '" . $stDate . "' and to_char(student_lessons_bookings.lession_date, 'YYYY-MM-DD') <= '" . $endDate . "'")
                    ->whereNotIn('status',['cancel', 'deleted'])
                    ->where(function ($q) use ($sid){
                        if($sid){
                            $q->where('user_id',$sid);
                        }
                    })
                    ->groupBy('date');
            }

        } else{

            if(!empty($filter) && !empty($option) && $filter == 'm'){

                $date = date('Y-m', strtotime(today()));
                $stDate = date('Y-m')."-01";
				
				$lastDateOfThisMonth =strtotime('last day of this month') ;
				$last_day = date('Y-m-d', $lastDateOfThisMonth);
                $week = $this->dateRange($stDate,$last_day);

                $lessions = StudentLessonsBooking::Select(
                    DB::raw("to_char(lession_date, 'DD Mon') as date"),
                    DB::raw("count(*) as count"))
                    ->whereRaw("to_char(student_lessons_bookings.lession_date, 'YYYY-MM') like '" . $date . "'")
                    ->whereNotIn('status',['cancel', 'deleted'])
                    ->where(function ($q) use ($sid){
                        if($sid){
                            $q->where('user_id',$sid);
                        }
                    })
                    ->groupBy('date');
            } elseif(!empty($filter) && !empty($option) && $filter == 'y') {

                $stDate = date('Y')."-01-01";
                $week = $this->monthRange($stDate);

                $lessions = StudentLessonsBooking::
                Select(
                    DB::raw("to_char(lession_date, 'Mon YYYY') as date"),
                    DB::raw("count(*) as count"))
                    ->whereRaw("date_part('year', student_lessons_bookings.lession_date) = date_part('year', CURRENT_DATE)")
                    ->whereNotIn('status',['cancel', 'deleted'])
                    ->where(function ($q) use ($sid){
                        if($sid){
                            $q->where('user_id',$sid);
                        }
                    })
                    ->groupBy('date');

            } elseif(!empty($filter) && !empty($option) && $filter == 'd') {
                $date = date('Y-m-d', strtotime(today()));
                $week = $this->dateRange($today,$today);

                $lessions = StudentLessonsBooking::
                Select(
                    DB::raw("to_char(lession_date, 'DD Mon') as date"),
                    DB::raw("count(*) as count"))
                    ->whereRaw("to_char(student_lessons_bookings.lession_date, 'YYYY-MM-DD') like '" . $date . "'")
                    ->whereNotIn('status',['cancel', 'deleted'])
                    ->where(function ($q) use ($sid){
                        if($sid){
                            $q->where('user_id',$sid);
                        }
                    })
                    ->groupBy('date');
            } else {

                $week = $this->dateRange($last_date,$today);

                $lessions = StudentLessonsBooking::Select(
                    DB::raw("to_char(lession_date, 'DD Mon') as date"),
                    DB::raw("count(*) as count"))
                    ->whereRaw("to_char(student_lessons_bookings.lession_date, 'YYYY-MM-DD') between '" . $last_date . "' and'" . $today . "'")
                    ->whereNotIn('status',['cancel', 'deleted'])
                    ->where(function ($q) use ($sid){
                        if($sid){
                            $q->where('user_id',$sid);
                        }
                    })
                    ->groupBy('date');
            }
        }

        $lessions = $lessions->get()->pluck('count','date')->toArray();
        $lessionsData = [];



        foreach ($week as $key => $day) {
            $lessionsData['lables'][] = $day;
            $lessionsData['data'][] = !empty($lessions[$day]) ? (int)$lessions[$day] : 0;
        }
        return view('admin.reports.admin-lessons.index', compact('lessionsData', 'lessions','filter','option','students','sort','sid'));
    }

    private function Top10Students($input = array()){

        $last_date = date('Y-m-d', strtotime('-6 days'));
        $today = date('Y-m-d', strtotime(today()));
        $filter = !empty($input['filter']) ? $input['filter'] : '';
        $option = !empty($input['opt']) ? $input['opt'] : '';
        $sort = !empty($input['sort']) ? $input['sort'] : '';
        $sid = !empty($input['sid']) ? $input['sid'] : '';
        $from_date = !empty($input['from_date']) ? date('Y-m-d', strtotime($input['from_date'])) : '';
        $to_date = !empty($input['to_date']) ? date('Y-m-d', strtotime($input['to_date'])) : date('Y-m-d', strtotime('-7 days'));
        $filter2 = !empty($input['filter2']) ? $input['filter2'] : '';

        $lessions = StudentLessonsBooking::select('users.id',
                DB::raw("CONCAT(users.firstname, ' ', users.lastname) AS full_name"),
                DB::raw("count(*) as count"))
                ->join('users','users.id','student_lessons_bookings.user_id')
                ->where('users.user_type','student')
                ->where('student_lessons_bookings.status','!=','cancel')
                ->limit(10)
                ->groupBy('users.id');

        if(!empty($from_date) && !empty($to_date)){
            $lessions = $lessions->whereRaw("to_char(student_lessons_bookings.lession_date, 'YYYY-MM-DD') between '" . $from_date . "' and'" . $to_date . "'");
        } else {

            if(!empty($filter) && !empty($option) && $filter == 'm'){
                $date = date('Y-m', strtotime(today()));
                $lessions = $lessions->whereRaw("to_char(student_lessons_bookings.lession_date, 'YYYY-MM') like '" . $date . "'");
            }
            elseif(!empty($filter) && !empty($option) && $filter == 'y'){

                $lessions = $lessions->whereRaw("date_part('year', student_lessons_bookings.lession_date) = date_part('year', CURRENT_DATE)");
            }
            elseif(!empty($filter) && !empty($option) && $filter == 'd'){
                $lessions = $lessions->whereRaw("to_char(student_lessons_bookings.lession_date, 'YYYY-MM-DD') like '" . $today . "'");
            }
            else{
                $lessions = $lessions->whereRaw("to_char(student_lessons_bookings.lession_date, 'YYYY-MM-DD') between '" . $to_date . "' and'" . $today . "'");
            }
        }

        $lessions = $lessions->orderBy('count',$sort)->get()->toArray();

        $lessionsData = [];
        foreach ($lessions as $key => $value) {
            $lessionsData['lables'][] = $value['full_name'];
            $lessionsData['data'][] = $value['count'];
        }

        return view('admin.reports.admin-lessons.index', compact('lessionsData', 'lessions','filter','option','sort','sid','from_date','to_date'));
    }

    private function Top10Teachers($input = array()){

        $last_date = date('Y-m-d', strtotime('-6 days'));
        $today = date('Y-m-d', strtotime(today()));
        $filter = !empty($input['filter']) ? $input['filter'] : '';
        $option = !empty($input['opt']) ? $input['opt'] : '';
        $sort = !empty($input['sort']) ? $input['sort'] : '';
        $sid = !empty($input['sid']) ? $input['sid'] : '';
        $from_date = !empty($input['from_date']) ? date('Y-m-d', strtotime($input['from_date'])) : '';
        $to_date = !empty($input['to_date']) ? date('Y-m-d', strtotime($input['to_date'])) : '';
        $filter2 = !empty($input['filter2']) ? $input['filter2'] : '';

        $lessions = StudentLessonsBooking::
        select('student_lessons_bookings.teacher_id',
            DB::raw("CONCAT(users.firstname, ' ', users.lastname) AS full_name"),
            DB::raw("count(*) as count"))
            ->join('users','users.id','student_lessons_bookings.teacher_id')
            ->where('student_lessons_bookings.status','!=','cancel')
            ->where('users.user_type','teacher')
            ->groupBy('student_lessons_bookings.teacher_id','users.firstname','users.lastname')
            ->limit(10);

        if(!empty($from_date) && !empty($to_date)){
            $lessions = $lessions->whereRaw("to_char(student_lessons_bookings.lession_date, 'YYYY-MM-DD') between '" . $from_date . "' and'" . $to_date . "'");
        } else {

            if(!empty($filter) && !empty($option) && $filter == 'm'){
                $date = date('Y-m', strtotime(today()));
                $lessions = $lessions->whereRaw("to_char(student_lessons_bookings.lession_date, 'YYYY-MM') like '" . $date . "'");
            }
            elseif(!empty($filter) && !empty($option) && $filter == 'y'){
                $lessions = $lessions->whereRaw("date_part('year', student_lessons_bookings.lession_date) = date_part('year', CURRENT_DATE)");
            }
            elseif(!empty($filter) && !empty($option) && $filter == 'd'){
                $date = date('Y-m-d', strtotime(today()));
                $lessions = $lessions->whereRaw("to_char(student_lessons_bookings.lession_date, 'YYYY-MM-DD') like '" . $date . "'");
            }
            else{
                $lessions = $lessions->whereRaw("to_char(student_lessons_bookings.lession_date, 'YYYY-MM-DD') between '" . $last_date . "' and'" . $today . "'");
            }
        }

        $lessions = $lessions->orderBy('count',$sort)->get()->toArray();
        $lessionsData = [];
        foreach ($lessions as $key => $value) {
            $lessionsData['lables'][] = $value['full_name'];
            $lessionsData['data'][] = $value['count'];
        }
        return view('admin.reports.admin-lessons.index', compact('lessionsData', 'lessions','filter','option','sort','sid'));
    }

    private function TotalLessonByTeacher($input = array()){

        $last_date = date('Y-m-d', strtotime('-6 days'));
        $today = date('Y-m-d', strtotime(today()));
        $filter = !empty($input['filter']) ? $input['filter'] : '';
        $option = !empty($input['opt']) ? $input['opt'] : '';
        $sort = !empty($input['sort']) ? $input['sort'] : '';
        $sid = !empty($input['sid']) ? $input['sid'] : '';

        $filter2 = !empty($input['filter2']) ? $input['filter2'] : '';
        $from_date = !empty($input['from_date']) ? date('Y-m-d', strtotime($input['from_date'])) : '';
        $to_date = !empty($input['to_date']) ? date('Y-m-d', strtotime($input['to_date'])) : '';

        if($sort == 'perteacher'){
            $students = User::select('id', 'email', 'firstname',
                DB::raw("CONCAT(users.firstname,' ', users.lastname) AS full_name"))
                ->where('user_type','teacher')
                ->where('status',1)
                ->get()->toArray();
        } else {
            $students = [];
        }


        if(!empty($from_date) && !empty($to_date)){

            $date1 = date_create($from_date);
            $date2 = date_create($to_date);
            $diff = date_diff($date1, $date2);
            $stDate = $date1->format('Y-m-d');
            $endDate = $date2->format('Y-m-d');

            if ($diff->d <= 30 and $diff->m == 0 and $diff->y == 0) {

                $week = $this->dateRange($stDate,$endDate);

                $lessions = StudentLessonsBooking::Select(
                    DB::raw("to_char(lession_date, 'DD Mon') as date"),
                    DB::raw("count(*) as count"))
                    ->whereNotIn('status',['cancel', 'deleted'])
                    ->whereRaw("to_char(student_lessons_bookings.lession_date, 'YYYY-MM-DD') >= '" . $stDate . "' and to_char(student_lessons_bookings.lession_date, 'YYYY-MM-DD') <= '" . $endDate . "'")
                    ->where(function ($q) use ($sid){
                        if($sid){
                            $q->where('teacher_id',$sid);
                        }
                    })
                    ->groupBy('date');
            }
            else{
                $week = $this->monthRange($stDate,$endDate);

                $lessions = StudentLessonsBooking::Select(
                    DB::raw("to_char(lession_date, 'Mon YYYY') as date"),
                    DB::raw("count(*) as count"))
                    ->whereNotIn('status',['cancel', 'deleted'])
                    //->whereRaw("date_part('month', lession_date) = date_part('month', CURRENT_DATE)")
					
                    ->whereRaw("to_char(student_lessons_bookings.lession_date, 'YYYY-MM-DD') >= '" . $stDate . "' and to_char(student_lessons_bookings.lession_date, 'YYYY-MM-DD') <= '" . $endDate . "'")
                    ->where(function ($q) use ($sid){
                        if($sid){
                            $q->where('teacher_id',$sid);
                        }
                    })
                    ->groupBy('date');
            }

        } else {

            if(!empty($filter) && !empty($option) && $filter == 'm'){
                $date = date('Y-m', strtotime(today()));
                $stDate = date('Y-m')."-01";
				
				$lastDateOfThisMonth =strtotime('last day of this month') ;
				$last_day = date('Y-m-d', $lastDateOfThisMonth);
                $week = $this->dateRange($stDate,$last_day);

                $lessions = StudentLessonsBooking::Select(
                    DB::raw("to_char(lession_date, 'DD Mon') as date"),
                    DB::raw("count(*) as count"))
                    ->whereNotIn('status',['cancel', 'deleted'])
                    ->whereRaw("to_char(student_lessons_bookings.lession_date, 'YYYY-MM') like '" . $date . "'")
                    ->where(function ($q) use ($sid){
                        if($sid){
                            $q->where('teacher_id',$sid);
                        }
                    })
                    ->groupBy('date');
            }
            elseif(!empty($filter) && !empty($option) && $filter == 'y'){

                $stDate = date('Y')."-01-01";
                $week = $this->monthRange($stDate);

                $lessions = StudentLessonsBooking::Select(
                    DB::raw("to_char(lession_date, 'Mon YYYY') as date"),
                    DB::raw("count(*) as count"))
                    ->whereNotIn('status',['cancel', 'deleted'])
                    ->whereRaw("date_part('year', student_lessons_bookings.lession_date) = date_part('year', CURRENT_DATE)")
                    ->where(function ($q) use ($sid){
                        if($sid){
                            $q->where('teacher_id',$sid);
                        }
                    })
                    ->groupBy('date');
            }
            elseif(!empty($filter) && !empty($option) && $filter == 'd'){

                $date = date('Y-m-d', strtotime(today()));
                $week = $this->dateRange($today,$today);

                $lessions = StudentLessonsBooking::Select(
                    DB::raw("to_char(lession_date, 'DD Mon') as date"),
                    DB::raw("count(*) as count"))
                    ->whereNotIn('status',['cancel', 'deleted'])
                    ->whereRaw("to_char(student_lessons_bookings.lession_date, 'YYYY-MM-DD') like '" . $date . "'")
                    ->where(function ($q) use ($sid){
                        if($sid){
                            $q->where('teacher_id',$sid);
                        }
                    })
                    ->groupBy('date');
            } else{

                $week = $this->dateRange($last_date,$today);

                $lessions = StudentLessonsBooking::Select(
                    DB::raw("to_char(lession_date, 'DD Mon') as date"),
                    DB::raw("count(*) as count"))
                    ->whereNotIn('status',['cancel', 'deleted'])
                    ->whereRaw("to_char(student_lessons_bookings.lession_date, 'YYYY-MM-DD') between '" . $last_date . "' and'" . $today . "'")
                    ->where(function ($q) use ($sid){
                        if($sid){
                            $q->where('teacher_id',$sid);
                        }
                    })
                    ->groupBy('date');
            }


        }
        $lessions = $lessions->get()->pluck('count','date')->toArray();


        $lessionsData = [];
        foreach ($week as $key => $day) {
            $lessionsData['lables'][] = $day;
            $lessionsData['data'][] = !empty($lessions[$day]) ? (int)$lessions[$day] : 0;
        }

        return view('admin.reports.admin-lessons.index', compact('lessionsData', 'lessions','filter','option','students','sort','sid'));
    }

    private function TotalTrialLession($input = array()){


        $last_date = date('Y-m-d', strtotime('-6 days'));
        $today = date('Y-m-d', strtotime(today()));
        $filter = !empty($input['filter']) ? $input['filter'] : '';
        $option = !empty($input['opt']) ? $input['opt'] : '';
        $sort = !empty($input['sort']) ? $input['sort'] : '';
        $sid = !empty($input['sid']) ? $input['sid'] : '';

        $from_date = !empty($input['from_date']) ? date('Y-m-d', strtotime($input['from_date'])) : '';
        $to_date = !empty($input['to_date']) ? date('Y-m-d', strtotime($input['to_date'])) : '';
        $filter2 = !empty($input['filter2']) ? $input['filter2'] : '';

        if($sort == 'perteacher'){
            $students = User::select('id','email', 'firstname',
                        DB::raw("CONCAT(users.firstname, ' ', users.lastname) AS full_name"))
                            ->where('user_type','teacher')
                            ->where('status',1)
                            ->get()->toArray();
        } else {
            $students = [];
        }

        if(!empty($from_date) && !empty($to_date)) {

            $date1 = date_create($from_date);
            $date2 = date_create($to_date);
            $diff = date_diff($date1,$date2);
            $stDate = $date1->format('Y-m-d');
            $endDate = $date2->format('Y-m-d');

            if($diff->d <= 30 and $diff->m == 0 and $diff->y == 0) {

                $lessions = StudentLessonsBooking::Select(
                    DB::raw("to_char(lession_date, 'DD Mon') as date"),
                    DB::raw("count(*) as count"))
                    ->whereNotIn('status',['cancel', 'deleted'])
                    ->where('lession_type', 'trial')
                    ->whereRaw("to_char(lession_date, 'YYYY-MM-DD') >= '" . $stDate . "' and to_char(lession_date, 'YYYY-MM-DD') <= '" . $endDate . "'")
                    ->where(function ($q) use ($sid) {
                        if ($sid) {
                            $q->where('teacher_id', $sid);
                        }
                    })
                    ->groupBy('date')->pluck('count', 'date')->toArray();

                $week = $this->dateRange($stDate, $endDate);
            }
            else{

                $lessions = StudentLessonsBooking::Select(
                    DB::raw("to_char(lession_date, 'Mon YYYY') as date"),
                    DB::raw("count(*) as count"))
                    ->whereNotIn('status',['cancel', 'deleted'])
                    ->where('lession_type', 'trial')
                    //->whereRaw("date_part('month', lession_date) = date_part('month', CURRENT_DATE)")
                    ->whereRaw("to_char(lession_date, 'YYYY-MM-DD') >= '" . $stDate . "' and to_char(lession_date, 'YYYY-MM-DD') <= '" . $endDate . "'")
                    ->where(function ($q) use ($sid) {
                        if ($sid) {
                            $q->where('teacher_id', $sid);
                        }
                    })
                    ->groupBy('date')->get()->pluck('count','date')->toArray();

                $week = $this->monthRange($stDate,$endDate);
            }

            $lessionsData = [];
            foreach ($week as $key => $day) {
                $lessionsData['lables'][] = $day;
                $lessionsData['data'][] = !empty($lessions[$day]) ? (int)$lessions[$day] : 0;
            }

        } else {

            if(!empty($filter) && $filter == 'm'){
                $date = date('Y-m', strtotime(today()));
                $lessions = StudentLessonsBooking::Select(
                    DB::raw("to_char(lession_date, 'DD Mon') as date"),
                    DB::raw("count(*) as count"))
                    ->whereNotIn('status',['cancel', 'deleted'])
                    ->where('lession_type','trial')
                    ->whereRaw("to_char(lession_date, 'YYYY-MM') like '" . $date . "'")
                    ->where(function ($q) use ($sid){
                        if($sid){
                            $q->where('teacher_id',$sid);
                        }
                    })
                    ->groupBy('date')->pluck('count','date')->toArray();

                $stDate = date('Y-m')."-01";
				
				$lastDateOfThisMonth =strtotime('last day of this month') ;
				$last_day = date('Y-m-d', $lastDateOfThisMonth);
                $week = $this->dateRange($stDate,$last_day);

                $lessionsData = [];
                foreach ($week as $key => $day) {
                    $lessionsData['lables'][] = $day;
                    $lessionsData['data'][] = !empty($lessions[$day]) ? (int)$lessions[$day] : 0;
                }

            } elseif(!empty($filter) && $filter == 'y'){

                $lessions = StudentLessonsBooking::
                Select(
                    DB::raw("to_char(lession_date, 'Mon YYYY') as date"),
                    DB::raw("count(*) as count"))
                    ->whereNotIn('status',['cancel', 'deleted'])
                    ->where('lession_type','trial')
                    ->whereRaw("date_part('year', student_lessons_bookings.lession_date) = date_part('year', CURRENT_DATE)")
                    ->where(function ($q) use ($sid){
                        if($sid){
                            $q->where('teacher_id',$sid);
                        }
                    })
                    ->groupBy('date')->pluck('count','date')->toArray();

                $stDate = date('Y')."-01-01";
                $week = $this->monthRange($stDate);

                $lessionsData = [];
                foreach ($week as $key => $day) {
                    $lessionsData['lables'][] = $day;
                    $lessionsData['data'][] = !empty($lessions[$day]) ? (int)$lessions[$day] : 0;
                }
            }
            elseif(!empty($filter) && $filter == 'd'){

                $date = date('Y-m-d', strtotime(today()));

                $lessions = StudentLessonsBooking::Select(
                    DB::raw("to_char(lession_date, 'DD Mon') as date"),
                    DB::raw("count(*) as count"))
                    ->whereNotIn('status',['cancel', 'deleted'])
                    ->where('lession_type','trial')
                    ->whereRaw("to_char(lession_date, 'YYYY-MM-DD') like '" . $date . "'")
                    ->where(function ($q) use ($sid){
                        if($sid){
                            $q->where('teacher_id',$sid);
                        }
                    })
                    ->groupBy('date')->pluck('count','date')->toArray();

                $week = $this->dateRange($today,$today);

                $lessionsData = [];
                foreach ($week as $key => $day) {
                    $lessionsData['lables'][] = $day;
                    $lessionsData['data'][] = !empty($lessions[$day]) ? (int)$lessions[$day] : 0;
                }
            }
            else{
                $lessions = StudentLessonsBooking::Select(
                    DB::raw("to_char(lession_date, 'DD Mon') as date"),
                    DB::raw("count(*) as count"))
                    ->whereNotIn('status',['cancel', 'deleted'])
                    ->where('lession_type','trial')
                    ->whereRaw("to_char(lession_date, 'YYYY-MM-DD') between '" . $last_date . "' and'" . $today . "'")
                    ->where(function ($q) use ($sid){
                        if($sid){
                            $q->where('teacher_id',$sid);
                        }
                    })
                    ->groupBy('date')->pluck('count','date')->toArray();

                $week = $this->dateRange($last_date,$today);

                $lessionsData = [];
                foreach ($week as $key => $day) {
                    $lessionsData['lables'][] = $day;
                    $lessionsData['data'][] = !empty($lessions[$day]) ? (int)$lessions[$day] : 0;
                }
            }
        }

        return view('admin.reports.admin-lessons.index', compact('lessionsData', 'lessions','filter','option','students','sort','sid'));
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
}
