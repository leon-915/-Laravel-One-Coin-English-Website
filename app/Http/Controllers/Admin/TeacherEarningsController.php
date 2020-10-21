<?php

namespace App\Http\Controllers\Admin;

use App\Models\StudentLessonsBooking;
use App\Models\TeacherEarnings;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;

class TeacherEarningsController extends Controller
{
    public function index()
    {
        return view('admin.teachers-earnings.index');
    }

    public function getEarnings(Request $request)
    {

        $from_date = $request->from_date;
        $to_date = $request->to_date;

        /*$tEarning = DB::select("select users.id,
                        sum(student_lessons_bookings.teacher_earnings) as total_earning
                        from users left join teacher_detail
                        on teacher_detail.user_id = users.id
                        left join student_lessons_bookings
                         on student_lessons_bookings.teacher_id = users.id
                         where teacher_detail.is_ambassador = 0
                         and users.user_type = 'teacher'
                         group by users.id");*/

        $tEarning = StudentLessonsBooking::select('users.id',
                    DB::raw("sum(student_lessons_bookings.teacher_earnings) as total_earning"),
                    DB::raw("CONCAT(users.firstname,' ',users.lastname) as teacher_name")
                )
                ->leftjoin('users','users.id','student_lessons_bookings.teacher_id')
                ->leftjoin('teacher_detail','users.id','teacher_detail.user_id')
                ->where('users.user_type','teacher')
                ->where('teacher_detail.is_ambassador','=',0)
                ->groupBy('users.id');


        if (!empty($request->teacher_name)){
            $tEarning->havingRaw("LOWER(CONCAT(users.firstname,' ',users.lastname)) like'%" . strtolower($request->teacher_name) ."%'" );
        }

        if (!empty($request->from_date)){
            $tEarning->whereRaw("lession_date >= '".$from_date."'::date");
        }
        if (!empty($request->to_date)) {
            $tEarning->whereRaw("lession_date < '" . date('Y-m-d', strtotime('+1 day', strtotime($to_date))) . "'::date");
        }
        return DataTables::of($tEarning)

//            ->addColumn('teacher_name', function ($ern) {
//                $teacher = User::where('id', $ern->teacher_id)->first();
//                return $teacher->firstname . ' ' . $teacher->lastname;
//            })
            ->editColumn('total_earning', function ($ern) {
                return $ern->total_earning ? '¥ ' . $ern->total_earning : '¥ '.'0';
            })
            ->make(true);
    }
}
