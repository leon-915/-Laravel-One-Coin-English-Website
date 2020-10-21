<?php

namespace App\Http\Controllers\Admin\LessonReports;

use App\Models\StudentLessons;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\StudentLessonsBooking;
use App\Models\StudentTransactions;
use App\Models\TeacherRatings;
use Illuminate\Support\Facades\DB;

class RatingReportController extends Controller
{
    public function index(Request $request) {
        $input  = $request->all();
        $option = !empty($input['opt']) ? $input['opt'] : 'rating_evaluate_by_students';

        switch ($option) {
            case 'rating_evaluate_by_students':
                return $this->ratingEvaluateByStudents($input);
                break;

            case 'rating_evaluate_per_student':
                return $this->ratingEvaluatePerStudent($input);
                break;

            case 'top_10_student_by_rating':
                return $this->top10StudentByRating($input);
                break;

            case 'last_10_student_by_rating':
                return $this->last10StudentByRating($input);
                break;

            case 'rating_received_by_teachers':
                return $this->ratingReceivedByTeachers($input);
                break;

            case 'rating_received_per_teacher':
                return $this->ratingReceivedPerTeacher($input);
                break;

            case 'top_10_teacher_by_rating':
                return $this->top10TeacherByRating($input);
                break;

            case 'last_10_teacher_by_rating':
                return $this->last10TeacherByRating($input);
                break;
        }
    }

    private function ratingEvaluateByStudents($input = array()){
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

                $amounts=TeacherRatings:: select(
                    DB::raw("to_char(created_at, 'DD Mon') as date"),
                    DB::raw("count(distinct(lesson_booking_id)) as total")
                )
                ->whereRaw("created_at >= '".$from_date."'::date")
                ->whereRaw("created_at < '".date('Y-m-d',strtotime('+1 day', strtotime($to_date))) ."'::date")
                ->where('status',1)
                ->groupBy('date')->pluck('total','date')->toArray();

                $lastMonth = $this->daterange($from_date,$to_date);
                $amtData = [];
                foreach ($lastMonth as $day) {
                    $amtData['lables'][] = $day;
                    $amtData['data'][] = !empty($amounts[$day]) ? (int)$amounts[$day] : 0;
                }
            } else {
                $amounts = TeacherRatings:: select(
                            DB::raw("to_char(created_at,'Mon') as mon"),
                            DB::raw("extract(year from created_at) as yyyy"),
                            DB::raw("CONCAT(to_char(created_at,'Mon') ,' ',extract(year from created_at)) as mdate"),
                            DB::raw("count(distinct(lesson_booking_id)) as total")
                        )
                        ->whereRaw("created_at >= '".$from_date."'::date")
                        ->whereRaw("created_at < '".date('Y-m-d',strtotime('+1 day', strtotime($to_date))) ."'::date")
                        ->where('status',1)
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

                $amounts=TeacherRatings:: select(
                    DB::raw("to_char(created_at, 'DD Mon') as date"),
                    DB::raw("count(distinct(lesson_booking_id)) as total")
                )
                ->whereRaw("to_char(created_at, 'YYYY-MM') like '" . $date . "'")
                ->where('status',1)
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

                $amounts = TeacherRatings::select(
                                    DB::raw("to_char(created_at, 'DD Mon YYYY') as date"),
                                    DB::raw("count(distinct(lesson_booking_id)) as total")
                                )
                                ->whereRaw("to_char(created_at, 'YYYY-MM-DD') like '" . $date . "'")
                                ->where('status',1)
                                ->groupBy('date')->get()->toArray();

                $amtData = [];
                $amtData['lables'][] = date('d M Y');
                $amtData['data'][] = !empty($amounts[0]['total']) ? (int)$amounts[0]['total'] : 0;


            } elseif (!empty($filter) && $filter == 'y') {
                $amounts = TeacherRatings:: select(
                            DB::raw("to_char(created_at,'Mon') as mon"),
                            DB::raw("extract(year from created_at) as yyyy"),
                            DB::raw("CONCAT(to_char(created_at,'Mon') ,' ',extract(year from created_at)) as mdate"),
                            DB::raw("count(distinct(lesson_booking_id)) as total")
                        )
                        ->whereRaw("date_part('year', created_at) = date_part('year', CURRENT_DATE)")
                        ->where('status',1)
                        ->groupBy(DB::raw('1,2'))->pluck('total','mdate')->toArray();

                $stDate = date('Y')."-01-01";
                $lastYear = $this->monthRange($stDate);

                $amtData = [];
                foreach ($lastYear as $day) {
                    $amtData['lables'][] = $day;
                    $amtData['data'][] = !empty($amounts[$day]) ? (int)$amounts[$day] : 0;
                }

            } else {
                $amounts=TeacherRatings:: select(
                                            DB::raw("to_char(created_at, 'DD Mon') as date"),
                                            DB::raw("count(distinct(lesson_booking_id)) as total")
                                        )
                                        ->whereRaw("to_char(created_at, 'YYYY-MM-DD') between '" . $last_date . "' and'" . $today . "'")
                                        ->where('status',1)
                                        ->groupBy('date')->pluck('total','date')->toArray();

                $lastWeek = $this->daterange($last_date,$today);
                $amtData = [];
                foreach ($lastWeek as $day) {
                    $amtData['lables'][] = $day;
                    $amtData['data'][] = !empty($amounts[$day]) ? (int)$amounts[$day] : 0;
                }
            }
        }

        return view('admin.reports.ratings.index', compact('amounts','filter','option','sort','amtData','from_date','to_date'));
    }

    private function ratingEvaluatePerStudent($input = array()){
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
                $amounts=TeacherRatings:: select(
                                DB::raw("to_char(created_at, 'DD Mon') as date"),
                                DB::raw("count(distinct(lesson_booking_id)) as total")
                            )
                            ->whereRaw("created_at >= '".$from_date."'::date")
                            ->whereRaw("created_at < '".date('Y-m-d',strtotime('+1 day', strtotime($to_date))) ."'::date")
                            ->where('student_id', $user_id)
                            ->where('status',1)
                            ->groupBy('date')->pluck('total','date')->toArray();

                $lastMonth = $this->daterange($from_date,$to_date);
                $amtData = [];
                foreach ($lastMonth as $day) {
                    $amtData['lables'][] = $day;
                    $amtData['data'][] = !empty($amounts[$day]) ? (int)$amounts[$day] : 0;
                }
            } else {

                $amounts = TeacherRatings:: select(
                            DB::raw("to_char(created_at,'Mon') as mon"),
                            DB::raw("extract(year from created_at) as yyyy"),
                            DB::raw("CONCAT(to_char(created_at,'Mon') ,' ',extract(year from created_at)) as mdate"),
                            DB::raw("count(distinct(lesson_booking_id)) as total")
                        )
                        ->whereRaw("created_at >= '".$from_date."'::date")
                        ->whereRaw("created_at < '".date('Y-m-d',strtotime('+1 day', strtotime($to_date))) ."'::date")
                        ->where('student_id', $user_id)
                        ->where('status',1)
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

                $amounts=TeacherRatings:: select(
                                DB::raw("to_char(created_at, 'DD Mon') as date"),
                                DB::raw("count(distinct(lesson_booking_id)) as total")
                            )
                            ->whereRaw("to_char(created_at, 'YYYY-MM') like '" . $date . "'")
                            ->where('student_id', $user_id)
                            ->where('status',1)
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

                $amounts = TeacherRatings::select(
                                    DB::raw("to_char(created_at, 'DD Mon YYYY') as date"),
                                    DB::raw("count(distinct(lesson_booking_id)) as total")
                                )
                                ->whereRaw("to_char(created_at, 'YYYY-MM-DD') like '" . $date . "'")
                                ->where('student_id', $user_id)
                                ->where('status',1)
                                ->groupBy('date')->get()->toArray();

                $amtData = [];
                $amtData['lables'][] = date('d M Y');
                $amtData['data'][] = !empty($amounts[0]['total']) ? (int)$amounts[0]['total'] : 0;


            } elseif (!empty($filter) && $filter == 'y') {
                $amounts = TeacherRatings:: select(
                            DB::raw("to_char(created_at,'Mon') as mon"),
                            DB::raw("extract(year from created_at) as yyyy"),
                            DB::raw("CONCAT(to_char(created_at,'Mon') ,' ',extract(year from created_at)) as mdate"),
                            DB::raw("count(distinct(lesson_booking_id)) as total")
                        )
                        ->whereRaw("date_part('year', created_at) = date_part('year', CURRENT_DATE)")
                        ->where('student_id', $user_id)
                        ->where('status',1)
                        ->groupBy(DB::raw('1,2'))->pluck('total','mdate')->toArray();

                $stDate = date('Y')."-01-01";
                $lastYear = $this->monthRange($stDate);

                $amtData = [];
                foreach ($lastYear as $day) {
                    $amtData['lables'][] = $day;
                    $amtData['data'][] = !empty($amounts[$day]) ? (int)$amounts[$day] : 0;
                }

            } else {
                $amounts=TeacherRatings:: select(
                                            DB::raw("to_char(created_at, 'DD Mon') as date"),
                                            DB::raw("count(distinct(lesson_booking_id)) as total")
                                        )
                                        ->whereRaw("to_char(created_at, 'YYYY-MM-DD') between '" . $last_date . "' and'" . $today . "'")
                                        ->where('student_id', $user_id)
                                        ->where('status',1)
                                        ->groupBy('date')->pluck('total','date')->toArray();

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

        return view('admin.reports.ratings.index', compact('amounts','filter','option','user_id','sort','amtData','users','from_date','to_date'));
    }

    private function top10StudentByRating($input = array()){
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
                $amounts=TeacherRatings:: select(
                            'student_id',
                            DB::raw("count(distinct(lesson_booking_id)) as total")
                        )
                        ->whereRaw("created_at >= '".$from_date."'::date")
                        ->whereRaw("created_at < '".date('Y-m-d',strtotime('+1 day', strtotime($to_date))) ."'::date")
                        ->with('student')
                        ->where('status',1)
                        ->orderByRaw('total DESC NULLS LAST')
                        ->groupBy('student_id')->limit(10)->get()->toArray();

                $lastMonth = $this->daterange($from_date,$to_date);
                $amtData = [];
                foreach ($lastMonth as $day) {
                    $amtData['lables'][] = $day;
                    $amtData['data'][] = !empty($amounts[$day]) ? (int)$amounts[$day] : 0;
                }
            } else {

                $amounts = TeacherRatings:: select(
                                'student_id',
                                DB::raw("count(distinct(lesson_booking_id)) as total")
                            )
                            ->whereRaw("created_at >= '".$from_date."'::date")
                            ->whereRaw("created_at < '".date('Y-m-d',strtotime('+1 day', strtotime($to_date))) ."'::date")
                            ->with('student')
                            ->where('status',1)
                            ->orderByRaw('total DESC NULLS LAST')
                            ->groupBy('student_id')->limit(10)->get()->toArray();

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

                $amounts=TeacherRatings:: select(
                            'student_id',
                            DB::raw("count(distinct(lesson_booking_id)) as total")
                        )
                        ->whereRaw("to_char(created_at, 'YYYY-MM') like '" . $date . "'")
                        ->with('student')
                        ->where('status',1)
                        ->orderByRaw('total DESC NULLS LAST')
                        ->groupBy('student_id')->limit(10)->get()->toArray();

            } elseif (!empty($filter) && $filter == 'd') {

                $date = date('Y-m-d', strtotime(today()));

                $amounts = TeacherRatings::select(
                                    'student_id',
                                    DB::raw("count(distinct(lesson_booking_id)) as total")
                                )
                                ->whereRaw("to_char(created_at, 'YYYY-MM-DD') like '" . $date . "'")
                                ->with('student')
                                ->where('status',1)
                                ->orderByRaw('total DESC NULLS LAST')
                                ->groupBy('student_id')->limit(10)->get()->toArray();

            } elseif (!empty($filter) && $filter == 'y') {
                $amounts = TeacherRatings:: select(
                                'student_id',
                                DB::raw("count(distinct(lesson_booking_id)) as total")
                            )
                            ->whereRaw("date_part('year', created_at) = date_part('year', CURRENT_DATE)")
                            ->with('student')
                            ->where('status',1)
                            ->orderByRaw('total DESC NULLS LAST')
                            ->groupBy('student_id')->limit(10)->get()->toArray();
            } else {
                $amounts=TeacherRatings:: select(
                                            'student_id',
                                            DB::raw("count(distinct(lesson_booking_id)) as total")
                                        )
                                        ->whereRaw("to_char(created_at, 'YYYY-MM-DD') between '" . $last_date . "' and'" . $today . "'")
                                        ->with('student')
                                        ->where('status',1)
                                        ->groupBy('student_id')
                                        ->orderByRaw('total DESC NULLS LAST')
                                        ->limit(10)->get()->toArray();
            }
        }

        $amtData = [];
        foreach ($amounts as $amt) {
            $amtData['lables'][] = $amt['student']['firstname'].' '.$amt['student']['lastname'];
            $amtData['data'][] = $amt['total'];
        }

        if(!$amtData){
            $amtData['lables'] = [];
            $amtData['data'] = [];
        }

        return view('admin.reports.ratings.index', compact('amounts','filter','option','sort','amtData','from_date','to_date'));
    }

    private function last10StudentByRating($input = array()){
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
                $amounts=TeacherRatings:: select(
                            'student_id',
                            DB::raw("count(distinct(lesson_booking_id)) as total")
                        )
                        ->whereRaw("created_at >= '".$from_date."'::date")
                        ->whereRaw("created_at < '".date('Y-m-d',strtotime('+1 day', strtotime($to_date))) ."'::date")
                        ->with('student')
                        ->where('status',1)
                        ->orderByRaw('total ASC NULLS FIRST')
                        ->groupBy('student_id')->limit(10)->get()->toArray();

                $lastMonth = $this->daterange($from_date,$to_date);
                $amtData = [];
                foreach ($lastMonth as $day) {
                    $amtData['lables'][] = $day;
                    $amtData['data'][] = !empty($amounts[$day]) ? (int)$amounts[$day] : 0;
                }
            } else {

                $amounts = TeacherRatings:: select(
                                'student_id',
                                DB::raw("count(distinct(lesson_booking_id)) as total")
                            )
                            ->whereRaw("created_at >= '".$from_date."'::date")
                            ->whereRaw("created_at < '".date('Y-m-d',strtotime('+1 day', strtotime($to_date))) ."'::date")
                            ->with('student')
                            ->where('status',1)
                            ->orderByRaw('total ASC NULLS FIRST')
                            ->groupBy('student_id')->limit(10)->get()->toArray();

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

                $amounts=TeacherRatings:: select(
                            'student_id',
                            DB::raw("count(distinct(lesson_booking_id)) as total")
                        )
                        ->whereRaw("to_char(created_at, 'YYYY-MM') like '" . $date . "'")
                        ->with('student')
                        ->where('status',1)
                        ->orderByRaw('total ASC NULLS FIRST')
                        ->groupBy('student_id')->limit(10)->get()->toArray();

            } elseif (!empty($filter) && $filter == 'd') {

                $date = date('Y-m-d', strtotime(today()));

                $amounts = TeacherRatings::select(
                                    'student_id',
                                    DB::raw("count(distinct(lesson_booking_id)) as total")
                                )
                                ->whereRaw("to_char(created_at, 'YYYY-MM-DD') like '" . $date . "'")
                                ->with('student')
                                ->where('status',1)
                                ->orderByRaw('total ASC NULLS FIRST')
                                ->groupBy('student_id')->limit(10)->get()->toArray();

            } elseif (!empty($filter) && $filter == 'y') {
                $amounts = TeacherRatings:: select(
                                'student_id',
                                DB::raw("count(distinct(lesson_booking_id)) as total")
                            )
                            ->whereRaw("date_part('year', created_at) = date_part('year', CURRENT_DATE)")
                            ->with('student')
                            ->where('status',1)
                            ->orderByRaw('total ASC NULLS FIRST')
                            ->groupBy('student_id')->limit(10)->get()->toArray();
            } else {
                $amounts=TeacherRatings:: select(
                                            'student_id',
                                            DB::raw("count(distinct(lesson_booking_id)) as total")
                                        )
                                        ->whereRaw("to_char(created_at, 'YYYY-MM-DD') between '" . $last_date . "' and'" . $today . "'")
                                        ->with('student')
                                        ->where('status',1)
                                        ->groupBy('student_id')
                                        ->orderByRaw('total ASC NULLS FIRST')
                                        ->limit(10)->get()->toArray();
            }
        }

        $amtData = [];
        foreach ($amounts as $amt) {
            $amtData['lables'][] = $amt['student']['firstname'].' '.$amt['student']['lastname'];
            $amtData['data'][] = $amt['total'];
        }

        if(!$amtData){
            $amtData['lables'] = [];
            $amtData['data'] = [];
        }

        return view('admin.reports.ratings.index', compact('amounts','filter','option','sort','amtData','from_date','to_date'));
    }

    private function ratingReceivedByTeachers($input = array()){
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
                $amounts=TeacherRatings:: select(
                    DB::raw("to_char(created_at, 'DD Mon') as date"),
                    DB::raw("count(distinct(lesson_booking_id)) as total")
                )
                ->whereRaw("created_at >= '".$from_date."'::date")
                ->whereRaw("created_at < '".date('Y-m-d',strtotime('+1 day', strtotime($to_date))) ."'::date")
                ->where('status',1)
                ->groupBy('date')->pluck('total','date')->toArray();


                $lastMonth = $this->daterange($from_date,$to_date);
                $amtData = [];
                foreach ($lastMonth as $day) {
                    $amtData['lables'][] = $day;
                    $amtData['data'][] = !empty($amounts[$day]) ? (int)$amounts[$day] : 0;
                }
            } else {
                /*$amounts = StudentLessonsBooking:: select(
                    DB::raw("to_char(created_at,'Mon') as mon"),
                    DB::raw("extract(year from created_at) as yyyy"),
                    DB::raw("CONCAT(to_char(created_at,'Mon') ,' ',extract(year from created_at)) as mdate"),
                    DB::raw("sum(NULLIF(teacher_earnings,0)) as total")
                )
                ->whereRaw("created_at >= '".$from_date."'::date")
                ->whereRaw("created_at < '".date('Y-m-d',strtotime('+1 day', strtotime($to_date))) ."'::date")
                ->groupBy(DB::raw('1,2'))->pluck('total','mdate')->toArray();*/

                $amounts = TeacherRatings:: select(
                            DB::raw("to_char(created_at,'Mon') as mon"),
                            DB::raw("extract(year from created_at) as yyyy"),
                            DB::raw("CONCAT(to_char(created_at,'Mon') ,' ',extract(year from created_at)) as mdate"),
                            DB::raw("count(distinct(lesson_booking_id)) as total")
                        )
                        ->whereRaw("created_at >= '".$from_date."'::date")
                        ->whereRaw("created_at < '".date('Y-m-d',strtotime('+1 day', strtotime($to_date))) ."'::date")
                        ->where('status',1)
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

                $amounts=TeacherRatings:: select(
                    DB::raw("to_char(created_at, 'DD Mon') as date"),
                    DB::raw("count(distinct(lesson_booking_id)) as total")
                )
                ->whereRaw("to_char(created_at, 'YYYY-MM') like '" . $date . "'")
                ->where('status',1)
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

                $amounts = TeacherRatings::select(
                                    DB::raw("to_char(created_at, 'DD Mon YYYY') as date"),
                                    DB::raw("count(distinct(lesson_booking_id)) as total")
                                )
                                ->whereRaw("to_char(created_at, 'YYYY-MM-DD') like '" . $date . "'")
                                ->where('status',1)
                                ->groupBy('date')->get()->toArray();

                $amtData = [];
                $amtData['lables'][] = date('d M Y');
                $amtData['data'][] = !empty($amounts[0]['total']) ? (int)$amounts[0]['total'] : 0;


            } elseif (!empty($filter) && $filter == 'y') {
                $amounts = TeacherRatings:: select(
                            DB::raw("to_char(created_at,'Mon') as mon"),
                            DB::raw("extract(year from created_at) as yyyy"),
                            DB::raw("CONCAT(to_char(created_at,'Mon') ,' ',extract(year from created_at)) as mdate"),
                            DB::raw("count(distinct(lesson_booking_id)) as total")
                        )
                        ->whereRaw("date_part('year', created_at) = date_part('year', CURRENT_DATE)")
                        ->where('status',1)
                        ->groupBy(DB::raw('1,2'))->pluck('total','mdate')->toArray();

                $stDate = date('Y')."-01-01";
                $lastYear = $this->monthRange($stDate);

                $amtData = [];
                foreach ($lastYear as $day) {
                    $amtData['lables'][] = $day;
                    $amtData['data'][] = !empty($amounts[$day]) ? (int)$amounts[$day] : 0;
                }

            } else {
                $amounts=TeacherRatings:: select(
                                            DB::raw("to_char(created_at, 'DD Mon') as date"),
                                            DB::raw("count(distinct(lesson_booking_id)) as total")
                                        )
                                        ->whereRaw("to_char(created_at, 'YYYY-MM-DD') between '" . $last_date . "' and'" . $today . "'")
                                        ->where('status',1)
                                        ->groupBy('date')->pluck('total','date')->toArray();

                $lastWeek = $this->daterange($last_date,$today);
                $amtData = [];
                foreach ($lastWeek as $day) {
                    $amtData['lables'][] = $day;
                    $amtData['data'][] = !empty($amounts[$day]) ? (int)$amounts[$day] : 0;
                }
            }
        }

        return view('admin.reports.ratings.index', compact('amounts','filter','option','sort','amtData','from_date','to_date'));
    }

    private function ratingReceivedPerTeacher($input = array()){
        $filter = !empty($input['filter']) ? $input['filter'] : '';
        $option = !empty($input['opt']) ? $input['opt'] : '';
        $sort   = !empty($input['sort']) ? $input['sort'] : '';
        $last_date = date('Y-m-d', strtotime('-6 days'));
        $today = date('Y-m-d', strtotime(today()));
        $user_id = !empty($input['user_id']) ? $input['user_id'] : '';

        $from_date = !empty($input['from_date']) ? $input['from_date'] : '';
        $to_date   = !empty($input['to_date']) ? $input['to_date'] : '';

        $users = User::where('user_type','teacher')->where('status',1)->orderBy('email')->get()->toArray();
        if(!$user_id){
            $user_id = current($users)['id'];
        }

        if(!empty($from_date) && !empty($to_date)){
            $filter = '';
            $bdays = $this->dateDiff($from_date, $to_date);

            if($bdays >= 0 && $bdays < 31){

                $amounts=TeacherRatings:: select(
                    DB::raw("to_char(created_at, 'DD Mon') as date"),
                    DB::raw("count(distinct(lesson_booking_id)) as total")
                )
                ->whereRaw("created_at >= '".$from_date."'::date")
                ->whereRaw("created_at < '".date('Y-m-d',strtotime('+1 day', strtotime($to_date))) ."'::date")
                ->where('teacher_id', $user_id)
                ->where('status',1)
                ->groupBy('date')->pluck('total','date')->toArray();


                $lastMonth = $this->daterange($from_date,$to_date);
                $amtData = [];
                foreach ($lastMonth as $day) {
                    $amtData['lables'][] = $day;
                    $amtData['data'][] = !empty($amounts[$day]) ? (int)$amounts[$day] : 0;
                }
            } else {
                $amounts = TeacherRatings:: select(
                    DB::raw("to_char(created_at,'Mon') as mon"),
                    DB::raw("extract(year from created_at) as yyyy"),
                    DB::raw("CONCAT(to_char(created_at,'Mon') ,' ',extract(year from created_at)) as mdate"),
                    DB::raw("count(distinct(lesson_booking_id)) as total")
                )
                ->whereRaw("created_at >= '".$from_date."'::date")
                ->whereRaw("created_at < '".date('Y-m-d',strtotime('+1 day', strtotime($to_date))) ."'::date")
                ->where('teacher_id', $user_id)
                ->where('status',1)
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

                $amounts=TeacherRatings:: select(
                                DB::raw("to_char(created_at, 'DD Mon') as date"),
                                DB::raw("count(distinct(lesson_booking_id)) as total")
                            )
                            ->whereRaw("to_char(created_at, 'YYYY-MM') like '" . $date . "'")
                            ->where('teacher_id', $user_id)
                            ->where('status',1)
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

                $amounts = TeacherRatings::select(
                                    DB::raw("to_char(created_at, 'DD Mon YYYY') as date"),
                                    DB::raw("count(distinct(lesson_booking_id)) as total")
                                )
                                ->whereRaw("to_char(created_at, 'YYYY-MM-DD') like '" . $date . "'")
                                ->where('teacher_id', $user_id)
                                ->where('status',1)
                                ->groupBy('date')->get()->toArray();

                $amtData = [];
                $amtData['lables'][] = date('d M Y');
                $amtData['data'][] = !empty($amounts[0]['total']) ? (int)$amounts[0]['total'] : 0;


            } elseif (!empty($filter) && $filter == 'y') {
                $amounts = TeacherRatings:: select(
                            DB::raw("to_char(created_at,'Mon') as mon"),
                            DB::raw("extract(year from created_at) as yyyy"),
                            DB::raw("CONCAT(to_char(created_at,'Mon') ,' ',extract(year from created_at)) as mdate"),
                            DB::raw("count(distinct(lesson_booking_id)) as total")
                        )
                        ->whereRaw("date_part('year', created_at) = date_part('year', CURRENT_DATE)")
                        ->where('teacher_id', $user_id)
                        ->where('status',1)
                        ->groupBy(DB::raw('1,2'))->pluck('total','mdate')->toArray();

                $stDate = date('Y')."-01-01";
                $lastYear = $this->monthRange($stDate);

                $amtData = [];
                foreach ($lastYear as $day) {
                    $amtData['lables'][] = $day;
                    $amtData['data'][] = !empty($amounts[$day]) ? (int)$amounts[$day] : 0;
                }

            } else {
                $amounts=TeacherRatings:: select(
                                            DB::raw("to_char(created_at, 'DD Mon') as date"),
                                            DB::raw("count(distinct(lesson_booking_id)) as total")
                                        )
                                        ->whereRaw("to_char(created_at, 'YYYY-MM-DD') between '" . $last_date . "' and'" . $today . "'")
                                        ->where('teacher_id', $user_id)
                                        ->where('status',1)
                                        ->groupBy('date')->pluck('total','date')->toArray();

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

        return view('admin.reports.ratings.index', compact('amounts','filter','option','user_id','sort','amtData','users','from_date','to_date'));
    }

    private function top10TeacherByRating($input = array()){
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

            $amounts=TeacherRatings:: select(
                'teacher_id',
                DB::raw("count(distinct(lesson_booking_id)) as total")
            )
            ->whereRaw("created_at >= '".$from_date."'::date")
            ->whereRaw("created_at < '".date('Y-m-d',strtotime('+1 day', strtotime($to_date))) ."'::date")
            ->with('teacher')
            ->where('status',1)
            ->orderByRaw('total DESC NULLS LAST')
            ->groupBy('teacher_id')->limit(10)->get()->toArray();
        } else {
            if (!empty($filter) && $filter == 'm') {
                $date = date('Y-m', strtotime(today()));

                $amounts=TeacherRatings:: select(
                            'teacher_id',
                            DB::raw("count(distinct(lesson_booking_id)) as total")
                        )
                        ->whereRaw("to_char(created_at, 'YYYY-MM') like '" . $date . "'")
                        ->with('teacher')
                        ->where('status',1)
                        ->orderByRaw('total DESC NULLS LAST')
                        ->groupBy('teacher_id')->limit(10)->get()->toArray();

            } elseif (!empty($filter) && $filter == 'd') {

                $date = date('Y-m-d', strtotime(today()));

                $amounts = TeacherRatings::select(
                                    'teacher_id',
                                    DB::raw("count(distinct(lesson_booking_id)) as total")
                                )
                                ->whereRaw("to_char(created_at, 'YYYY-MM-DD') like '" . $date . "'")
                                ->with('teacher')
                                ->where('status',1)
                                ->orderByRaw('total DESC NULLS LAST')
                                ->groupBy('teacher_id')->limit(10)->get()->toArray();

            } elseif (!empty($filter) && $filter == 'y') {
                $amounts = TeacherRatings:: select(
                                'teacher_id',
                                DB::raw("count(distinct(lesson_booking_id)) as total")
                            )
                            ->whereRaw("date_part('year', created_at) = date_part('year', CURRENT_DATE)")
                            ->with('teacher')
                            ->where('status',1)
                            ->orderByRaw('total DESC NULLS LAST')
                            ->groupBy('teacher_id')->limit(10)->get()->toArray();
            } else {
                $amounts=TeacherRatings:: select(
                                            'teacher_id',
                                            DB::raw("count(distinct(lesson_booking_id)) as total")
                                        )
                                        ->whereRaw("to_char(created_at, 'YYYY-MM-DD') between '" . $last_date . "' and'" . $today . "'")
                                        ->with('teacher')
                                        ->where('status',1)
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

        return view('admin.reports.ratings.index', compact('amounts','filter','option','sort','amtData','from_date','to_date'));
    }

    private function last10TeacherByRating($input = array()){
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

            $amounts=TeacherRatings:: select(
                'teacher_id',
                DB::raw("count(distinct(lesson_booking_id)) as total")
            )
            ->whereRaw("created_at >= '".$from_date."'::date")
            ->whereRaw("created_at < '".date('Y-m-d',strtotime('+1 day', strtotime($to_date))) ."'::date")
            ->with('teacher')
            ->where('status',1)
            ->orderByRaw('total ASC NULLS FIRST')
            ->groupBy('teacher_id')->limit(10)->get()->toArray();
        } else {
            if (!empty($filter) && $filter == 'm') {
                $date = date('Y-m', strtotime(today()));

                $amounts=TeacherRatings:: select(
                            'teacher_id',
                            DB::raw("count(distinct(lesson_booking_id)) as total")
                        )
                        ->whereRaw("to_char(created_at, 'YYYY-MM') like '" . $date . "'")
                        ->with('teacher')
                        ->where('status',1)
                        ->orderByRaw('total ASC NULLS FIRST')
                        ->groupBy('teacher_id')->limit(10)->get()->toArray();

            } elseif (!empty($filter) && $filter == 'd') {

                $date = date('Y-m-d', strtotime(today()));

                $amounts = TeacherRatings::select(
                                    'teacher_id',
                                    DB::raw("count(distinct(lesson_booking_id)) as total")
                                )
                                ->whereRaw("to_char(created_at, 'YYYY-MM-DD') like '" . $date . "'")
                                ->with('teacher')
                                ->where('status',1)
                                ->orderByRaw('total ASC NULLS FIRST')
                                ->groupBy('teacher_id')->limit(10)->get()->toArray();

            } elseif (!empty($filter) && $filter == 'y') {
                $amounts = TeacherRatings:: select(
                                'teacher_id',
                                DB::raw("count(distinct(lesson_booking_id)) as total")
                            )
                            ->whereRaw("date_part('year', created_at) = date_part('year', CURRENT_DATE)")
                            ->with('teacher')
                            ->where('status',1)
                            ->orderByRaw('total ASC NULLS FIRST')
                            ->groupBy('teacher_id')->limit(10)->get()->toArray();
            } else {
                $amounts=TeacherRatings:: select(
                                            'teacher_id',
                                            DB::raw("count(distinct(lesson_booking_id)) as total")
                                        )
                                        ->whereRaw("to_char(created_at, 'YYYY-MM-DD') between '" . $last_date . "' and'" . $today . "'")
                                        ->with('teacher')
                                        ->where('status',1)
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

        return view('admin.reports.ratings.index', compact('amounts','filter','option','sort','amtData','from_date','to_date'));
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
