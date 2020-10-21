<?php

namespace App\Http\Controllers\Student;

use App\Helpers\AppHelper;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\models\StudentLessonsARP;
use Auth;
use App\User;
use App\Models\StudentLessonsBooking;
use App\Models\StudentLessonsKeyword;
use App\models\StudentLessonsTopic;
use Stichoza\GoogleTranslate\GoogleTranslate;
use Yajra\DataTables\DataTables;

class KeywordsController extends Controller
{
    public function index(){
        $user_id = Auth::user()->id;
		$user = User::where('id', $user_id)->first();
        $userDetails = $user->details()->first();

        return view('students.keywords.index', compact('user', 'userDetails'));
    }

    public function getKeywordSearch(Request $request) {
        $user_id = Auth::user()->id;
		$teacher = User::where('id', $user_id)->first();
        $teacherDetails = $teacher->details()->first();

        $squery = $request->get('search-query','');

        $html = view('students.keywords.index.keywords.keyword-table',compact('teacher','teacherDetails','squery'))->render();

        return response()->json(['type' => 'success', 'html' => $html]);
    }

    public function getOnepageSearch(Request $request) {
        $user_id = Auth::user()->id;
		$teacher = User::where('id', $user_id)->first();
        $teacherDetails = $teacher->details()->first();

        $squery = $request->get('search-query','');

        $html = view('students.keywords.index.keywords.onepage-table',compact('teacher','teacherDetails','squery'))->render();

        return response()->json(['type' => 'success', 'html' => $html]);
    }

    public function getKeywordList(Request $request) {
        $user_id = Auth::user()->id;
        $teacherKeywrds = StudentLessonsKeyword::select([
                //'services.title AS service',
                'student_lessons_bookings.*',
                'student_lessons_keywords.keyword AS keyword',
                'student_lessons_bookings.created_at as cdate',
                'student_lessons_keywords.lesson_booking_id as lesson_booking_id'
            ])
            ->Join('student_lessons_bookings', 'student_lessons_bookings.id','student_lessons_keywords.lesson_booking_id')
            ->where('student_lessons_bookings.user_id', $user_id)
            ->where('student_lessons_bookings.status', 'completed')
            ->with('topics');

        if(request()->has('search') && request()->search){
            /*$teacherKeywrds->whereRaw("LOWER(keyword) LIKE '" . strtolower(request()->search) . "%'")
                ->orwhereRaw("LOWER(keyword_ja) LIKE '" . strtolower(request()->search) . "%'");*/
			$teacherKeywrds->where(function ($query) {
				$query->whereRaw("LOWER(keyword) LIKE '" . strtolower(request()->search) . "%'")
                ->orwhereRaw("LOWER(keyword_ja) LIKE '" . strtolower(request()->search) . "%'");
			});		
        }

        return DataTables::of($teacherKeywrds)
            ->addIndexColumn()
            ->addColumn('topic', function($keyword){
                if(!empty($keyword->topics) && $keyword->topics->toArray()){
                    $topics = current($keyword->topics->toArray());

                    //return !empty($topics['title']) ? $topics['title'] : '';
					return !empty($topics['title']) ? '<a target="_blank" href="'.route('students.share.onepage.index', ['id' => encrypt($keyword->id)]).'">'.$topics['title'].'</a>' : '';
                } else {
                    return '';
                }
            })
            ->addColumn('translate', function($keyword){
                if(!empty($keyword) && $keyword->toArray()){
                    $keyword = $keyword->toArray();
                    if(!empty($keyword['keyword_ja'])){
                        return $keyword['keyword_ja'];
                    } else {
                        //return GoogleTranslate::trans($keyword['keyword'], 'ja', 'en');
                        return $keyword['keyword'];
                    }
                } else {
                    return '';
                }
            })
			->rawColumns(['topic'])
            ->make(true);
    }

    public function getOnepageList(Request $request) {
        $user_id = Auth::user()->id;

        $bookings = StudentLessonsBooking::where('status','completed')
                                                ->where('user_id', $user_id)
                                                ->with('topics','student')
												->orderBy('onepage_title', 'Desc');

        return DataTables::of($bookings)
            ->addIndexColumn()
            ->filter(function($query){
                if(request()->has('search') && request()->search){
                    $query->whereRaw("LOWER(onepage_title) LIKE '" . strtolower(request()->search) . "%'");
                }
            })
            ->editColumn('onepage_title', function ($booking) {
                return '<b><a href="'.route('students.share.onepage.index', ['id' => encrypt($booking->id)]).'">Accent OnePage ' . $booking->onepage_title.'</a></b>';
            })
            ->addColumn('topic', function($booking){
                if(!empty($booking->topics) && $booking->topics->toArray()){
                    $topics = current($booking->topics->toArray());

                    return !empty($topics['title']) ? $topics['title'] : '';
                } else {
                    return '';
                }
            })
            ->addColumn('student', function($booking){
                if(!empty($booking->student) && $booking->student->toArray()){
                    $student = $booking->student->firstname .' '.$booking->student->lastname;

                    return '<span class="badge badge-info" style="background-color:#002e58;">'.$student.'</span>';
                } else {
                    return '';
                }
            })
            ->addColumn('action', function($booking){
                return'<a id="' . $booking->id . '" style="cursor:pointer;" class="btn btn-sm btn-icon btn-pure btn-default"
                       data-toggle="tooltip" title="View" data-original-title="View"><i class="fas fa-eye" aria-hidden="true"></i></a>';
            })
            ->rawColumns(['student','action', 'onepage_title'])
            ->make(true);
    }

    public function getKeywordOnepageSearch(Request $request) {
        $user_id = Auth::user()->id;
        $teacher = User::where('id', $user_id)->first();
        $teacherDetails = $teacher->details()->first();

        $squery = $request->get('search-query', '');

        $html = view('students.keywords.index.keywords.keyword-onepage-table', compact('teacher', 'teacherDetails', 'squery'))->render();

        return response()->json(['type' => 'success', 'html' => $html]);
    }

    public function getKeywordOnepageList(Request $request) {
        $user_id = Auth::user()->id;
        $keywords = StudentLessonsKeyword::select([
                'student_lessons_keywords.keyword AS topics',
                'student_lessons_keywords.lesson_booking_id as lesson_booking_id',
                'student_lessons_bookings.user_id as student_id'
            ])
            ->Join('student_lessons_bookings', 'student_lessons_bookings.id', 'student_lessons_keywords.lesson_booking_id')
            ->where('student_lessons_bookings.user_id', $user_id)
            ->where('student_lessons_bookings.status', 'completed')
            /*->whereRaw("LOWER(keyword) LIKE '%" . strtolower($request->search) . "%'")
            ->orwhereRaw("LOWER(keyword_ja) LIKE '%" . strtolower($request->search) . "%'")
            ->get()->toArray();*/
			
			->where(function ($query) {
					if (request()->has('search') && request()->search) {
					$query->whereRaw("LOWER(keyword) LIKE '" . strtolower(request()->search) . "%'")
					->orwhereRaw("LOWER(keyword_ja) LIKE '" . strtolower(request()->search) . "%'");
					}
				})
			->get()->toArray();	
			
			
			
        $arpsLine1 = StudentLessonsARP::select([
                'student_lessons_active_recall_pairs.line_1 AS topics',
                'student_lessons_active_recall_pairs.lesson_booking_id as lesson_booking_id',
                'student_lessons_bookings.user_id as student_id'
            ])
            ->Join('student_lessons_bookings', 'student_lessons_bookings.id', 'student_lessons_active_recall_pairs.lesson_booking_id')
            ->where('student_lessons_bookings.user_id', $user_id)
            ->whereRaw("LOWER(student_lessons_active_recall_pairs.line_1) LIKE '%" . strtolower($request->search) . "%'")
            ->get()->toArray()
            ;
        $arpsLine2 = StudentLessonsARP::select([
                'student_lessons_active_recall_pairs.line_2 AS topics',
                'student_lessons_active_recall_pairs.lesson_booking_id as lesson_booking_id',
                'student_lessons_bookings.user_id as student_id'
            ])
            ->Join('student_lessons_bookings', 'student_lessons_bookings.id', 'student_lessons_active_recall_pairs.lesson_booking_id')
            ->where('student_lessons_bookings.user_id', $user_id)
            ->whereRaw("LOWER(student_lessons_active_recall_pairs.line_2) LIKE '%" . strtolower($request->search) . "%'")
            ->get()->toArray()
            ;
        $topics = StudentLessonsTopic::select([
                'student_lessons_topic.title AS topics',
                'student_lessons_topic.lesson_booking_id as lesson_booking_id',
                'student_lessons_bookings.user_id as student_id'
            ])
            ->Join('student_lessons_bookings', 'student_lessons_bookings.id', 'student_lessons_topic.lesson_booking_id')
            ->where('student_lessons_bookings.user_id', $user_id)
            ->where('student_lessons_bookings.status', 'completed')
            ->whereRaw("LOWER(student_lessons_topic.title) LIKE '%" . strtolower($request->search) . "%'")
            ->get()->toArray()
            ;

        //$teacherKeywrds = array_merge($keywords,$arpsLine1,$arpsLine2,$topics);
        $teacherKeywrds = array_merge($keywords, $topics);

        return DataTables::of($teacherKeywrds)
            ->addIndexColumn()
            ->addColumn('topic', function ($booking) {
                if (!empty($booking['topics'])) {
                    return '<a target="_blank" href="https://translate.google.com/#en/ja/'.urlencode($booking['topics']).'">'.$booking['topics'].'</a>';
                } else {
                    return '';
                }
            })
            ->addColumn('translate', function ($booking) {
                if (!empty($booking['topics'])) {
                    //$topic = GoogleTranslate::trans($booking['topics'], 'ja', 'en');
                    $topic = $booking['topics'];
                    return '<a target="_blank" href="https://translate.google.com/#ja/en/'.urlencode($topic).'">'.$topic.'</a>';
                } else {
                    return '';
                }
            })
            ->addColumn('student', function ($booking) {
                $student = Auth::user();
                if (!empty($student) && $student->toArray()) {
                    $studentname = $student->firstname . ' ' . $student->lastname;

                    return '<span class="badge badge-info" style="background-color:#002e58;">' . $studentname . '</span>';
                } else {
                   return '';
                }
            })
            ->addColumn('action', function ($booking) {
                return '<b><a target="_blank" class="onepage-report-action p-2" href="'.route('students.share.onepage.index', ['id' => encrypt($booking['lesson_booking_id'])]).'">ONEPAGE REPORT</a></b>';
            })
            ->rawColumns(['student', 'action','onepage_title','topic','translate'])
            ->make(true);
    }
}
