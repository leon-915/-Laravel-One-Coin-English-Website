<?php

namespace App\Http\Controllers\Admin;

use App\Exports\ActiveStudents;
use App\Exports\lessonReport;
use App\Models\StudentLessons;
use App\Models\StudentLessonsBooking;
use App\Models\StudentPackages;
use App\Models\Services;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use Yajra\DataTables\DataTables;

class StudentLessonRecordController extends Controller
{
    public function index()
    {
        return view('admin.student-lesson-records.index');
    }

    public function getLessonRecord(Request $request) {
        $users = User::select('id','email',
                DB::raw("CONCAT(users.firstname, ' ', users.lastname) AS student_name")
            )->where('user_type','student');
            //->whereRaw('student_package_id IS NULL');

        if (!empty($request->student_name)){
            $users->whereRaw("LOWER(CONCAT(users.firstname,' ',users.lastname))    like'" . strtolower($request->student_name) ."%'" );
        }
        if (!empty($request->email)){
            $users->whereRaw("LOWER(email) like'" . strtolower($request->email) ."%'" );
        }
        return DataTables::of($users)
            ->addIndexColumn()
            ->addColumn('action', function ($users)
            {
                $editButton = '';
                $editButton .= '<a href="' . route('admin.student.lesson.records.package', $users->id) . '" class="btn btn-outline-info btn-rounded btn-icon edit-row" title="View Packages"
                                data-toggle="tooltip" title="View Packages" data-original-title="View Packages"><i class="mdi mdi-eye" aria-hidden="true"></i></a>';

                return $editButton;
            })
            ->rawColumns(['action'])
            ->make(true);
    }

    public function packages($id) {
        $courses = StudentLessons::where('user_id',$id)
                                    ->with('student','service')
									->whereNotIn('service_id', [env('ONEPAGE_SERVICE_ID'), env('REGISTRATION_SERVICE_ID'), env('CAFE25_SERVICE_ID'), env('CAFE50_SERVICE_ID'), env('VIRTUAL25_SERVICE_ID'), env('VIRTUAL50_SERVICE_ID'), env('CLASSROOM25_BASIC_SERVICE_ID'), env('CLASSROOM25_COMPLETE_SERVICE_ID'), env('CLASSROOM50_BASIC_SERVICE_ID'), env('CLASSROOM50_COMPLETE_SERVICE_ID'), env('CLASSROOM50_PRO_SERVICE_ID')])
									->orderBy('id', 'desc')
                                    ->get()->toArray(); 
		$packages = StudentPackages::where('user_id',$id)
                                    ->with('package')
									->orderBy('id', 'desc')
                                    ->get()->toArray();    									

        return view('admin.student-lesson-records.packages',compact('courses', 'packages'));
    }

    public function bookings(Request $request) {
        $input    = $request->all();
        $package  = StudentLessons::where('user_id',$input['user_id'])
                                    ->where('id', $input['id'])
                                    ->with('student','service')
                                    ->first();
        $bookings = StudentLessonsBooking::where('user_id', $input['user_id'])
            ->where('student_lessons_id', $input['id'])
            ->with('student')
            ->with('teacher')
            ->with('location')
            ->with('service')
            ->orderBy('lession_date','DESC')
            ->orderBy('lession_time','DESC')->get()->toArray();

        return view('admin.student-lesson-records.bookings',compact('bookings','package'));
    }

    public function packagebookings(Request $request) {
        $input    = $request->all();
		$user_id = $input['user_id'];
        $package_id = $input['id'];
		$spCompleted = $tnoshowcnt = 0;
		
        $student = User::where('id', $user_id)->first();
        $studentDetails = $student->details()->first();
		
        $package  = StudentPackages::where('user_id',$input['user_id'])
                                    ->where('id', $input['id'])
                                    ->with('student','package')
                                    ->first();
		$packageServices = Services::where('status',1)
                                ->where('is_system_service', 1)
                                ->pluck('id')->toArray();	
		if(!empty($packageServices)){
			$spCompleted = StudentLessonsBooking::where('user_id', $user_id)
                                            ->whereIN('service_id', $packageServices)
                                            ->where('student_lessons_id', $package_id)
                                            ->where('status', 'completed')
                                            ->count();
			$tnoshowcnt = StudentLessonsBooking::where('user_id', $user_id)
                                            ->where('student_lessons_id', $package_id)
                                            ->where('status', 'teacher_not_show')
                                            ->count();	
		}			
								
        $bookings = StudentLessonsBooking::where('user_id', $input['user_id'])
            ->where('student_lessons_id', $input['id'])
            ->with('student')
            ->with('teacher')
            ->with('location')
            ->with('service')
            ->orderBy('lession_date','DESC')
            ->orderBy('lession_time','DESC')->get()->toArray();

        return view('admin.student-lesson-records.packagebookings',compact('bookings','package', 'studentDetails', 'spCompleted', 'tnoshowcnt'));
    }

    public function ExportCsv()
    {
        return Excel::download(new lessonReport, ' Financial_CSV.xlsx');
    }

    public function ActiveStudentExportCsv(Request $request)
    {
        return Excel::download(new ActiveStudents, ' Active_Student_Csv.xlsx');
    }
}
