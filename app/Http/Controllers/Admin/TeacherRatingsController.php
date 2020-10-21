<?php

namespace App\Http\Controllers\Admin;

use App\Models\TeacherRatings;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Yajra\DataTables\DataTables;
use App\Models\StudentLessonsBooking;
use DB;

class TeacherRatingsController extends Controller
{
    public function index()
    {
        $teacher_ratings  = TeacherRatings::all();

        return view('admin.teacher-ratings.index',compact('teacher_ratings'));
    }
    public function getTeacherRatings(Request $request)
    {
        //$teacher_ratings = TeacherRatings::with('teacher','student','rating')->where('status',1);
        $bookings = StudentLessonsBooking::with('teacher','student','service')
                        ->where('status','completed');
            

        return DataTables::of($bookings)
            ->addIndexColumn()
            ->filter(function ($query) use ($request) {
                if (!empty($request->get('student'))) {
                    $query->whereHas('student', function ($q) use ($request) {
                        $q->whereRaw("LOWER(CONCAT(firstname,' ',lastname)) like '%" . strtolower($request->get('student')) . "%'");
                    });
                }

                if (!empty($request->get('teacher'))) {
                    $query->whereHas('teacher', function ($q) use ($request) {
                        $q->whereRaw("LOWER(CONCAT(firstname,' ',lastname)) like '%" . strtolower($request->get('teacher')) . "%'");
                    });
                }
            })
            ->order(function ($query) {
                $sort  =request()->order;
                $sort  =current($sort);

                switch ($sort['column']) {
                    case '0':
                        $query->orderBy('id', $sort['dir']);
                        break;
                    case '1':
                        $query->orderBy('teacher.firstname', $sort['dir']);
                        break;
                    case '2':
                        $query->orderBy('student.firstname', $sort['dir']);
                        break;
                    case '3':
                        $query->orderBy('service.title', $sort['dir']);
                        break;
                    break;
                }

            })
            ->editColumn('teacher', function ($bookings) {
                if ($bookings->teacher->firstname && $bookings->teacher->lastname) {
                    return $bookings->teacher->firstname.' '.$bookings->teacher->lastname;
                }
            })
            ->editColumn('student', function ($bookings) {
                if ($bookings->student->firstname && $bookings->student->lastname) {
                    return $bookings->student->firstname.' '.$bookings->student->lastname;
                }
            })
            ->editColumn('title', function ($bookings) {
                if ($bookings->service->title) {
                    return $bookings->service->title;
                }
            })->addColumn('action', function ($bookings) {

                // Hide Action Buttons 
                $editButton = '';
               
                    $editButton .= '<a href="'.route('admin.rating.details', $bookings->id).'" class="edit-row" title="View" data-toggle="tooltip" title="View" data-original-title="View">View Ratings</a>';
                
                return $editButton;

            })
            ->rawColumns(['teacher','student','title','action'])
            ->make(true);
    }

    public function RatingDetails($id) {

        $ratings    = [];
        $booking   = [];

        $ratings = TeacherRatings::with('rating')
                                    ->where('lesson_booking_id',$id)
                                    ->get();

        $booking = StudentLessonsBooking::where('id',$id)
                                            ->with('teacher','student','service')->first();
       /* echo "<pre>";
        print_r($ratings->toArray());
        print_r($bookings->toArray());
        echo "</pre>";
        die;*/
                
        return view('admin.teacher-ratings.show', compact('ratings', 'booking'));

    }
}
