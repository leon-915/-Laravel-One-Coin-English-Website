<?php

namespace App\Http\Controllers\Teacher;

use App\Helpers\AppHelper;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Country;
//use Illuminate\Foundation\Auth\User;
use App\User;

use App\Models\TeacherSchedule;
use App\Models\TeacherDetail;
use App\Jobs\SendEmailJob;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Models\TeacherAttachment;
//use Illuminate\Http\File;
use File;
use App\Models\StudentTransactions;
use App\Models\StudentLessonsBooking;
use Illuminate\Support\Facades\DB;
use App\Models\StudentLessons;
use App\Models\SearchAnalytics;
use App\Models\Settings;
use App\Models\OnePageLevels;
use App\Models\OnePageLevelsPoints;
use App\Models\RatingTypes;
use App\Models\Services;
use App\Models\StudentLessonsPoints;
use App\Models\StudentLessonsARP;
use App\Models\StudentLessonsCIP;
use App\Models\StudentLessonsKeyword;
use App\Models\StudentLessonsTopic;
use App\Models\StudentLessonsTasks;
use App\Models\StudentTeachers;
use App\Models\StudentShareRecord;
use App\Models\TeacherPayoutTransactions;
use App\Models\TeacherRatings;
use Illuminate\Support\Facades\Mail;
use Yajra\DataTables\DataTables;

use Stichoza\GoogleTranslate\GoogleTranslate;

class DashboardController extends Controller
{
	var $keywordArpId;
	var $keyPhraseArpId;
    public function __construct()
    {
        $this->middleware('auth');
		$this->keywordArpId = [];
		$this->keyPhraseArpId = [];
    }

    public function index(Request $request)
    {
        $ref = $request->get('ref', 'management');

        $book_before_time = Settings::getSettings('book_before_time');
        $settings = Settings::getSettings();

        $user_id = Auth::user()->id;
        $teacher = User::where('id', $user_id)->first();
        $teacherDetails = $teacher->details()->first();

        $levels = OnePageLevels::where('status', 0)->with([
            'ca',
            'fp',
            'lc',
            'v',
            'ga',
        ])->orderBy('id', 'ASC')->get();

        return view('teachers.dashboard.index', compact('teacher', 'teacherDetails', 'ref'));
    }

    public function getTops(Request $request)
    {
        $user_id = Auth::user()->id;

        $teacher = User::where('id', $user_id)->first();
        $teacherDetails = $teacher->details()->first();

		// get last 3 month earning
		$lessionsData['lables'] = [];
		$lessionsData['data'] = [];
        $last_3_month = date('Y-m-01', strtotime('-3 month'));
		$lessions = StudentLessonsBooking::Select(
                    DB::raw("to_char(lession_date, 'MM') as date"),
                    DB::raw("sum(teacher_earnings) as count"))
                    ->whereRaw("lession_date >= '$last_3_month'")
                    ->whereNotIn('status',['cancel', 'deleted'])
                    ->groupBy('date')->orderBy('date', 'ASC')->get()->pluck('count', 'date')->toArray();
		$months = ['start', 'Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec'];
		//echo '<pre>';print_r($lessions);	exit;	
		if(!empty($lessions)) {
			foreach ($lessions as $key => $value) {
				$lessionsData['lables'][] = $months[(int)$key];
				$lessionsData['data'][] = !empty($value) ? $value : 0;
			}
		}
		
		// get favorite count
		$fav = StudentTeachers::Select(DB::raw("count(id) as count"))->where('teacher_id', $user_id)->get()->pluck('count')->toArray();
		
		$fav_cnt = 0;
		//if(!empty($fav)) {
			$fav_cnt = $fav[0];
		//}
		
		// get session count
		$session = StudentLessonsBooking::Select(DB::raw("count(id) as count"))->where('teacher_id', $user_id)->get()->pluck('count')->toArray();
		//echo '<pre>';print_r($session);	exit;	
		$session_cnt = 0;
		//if(!empty($session)) {
			$session_cnt = $session[0];
		//}
		//echo $fav_cnt.''.$session_cnt;exit;
        $html = view('teachers.dashboard.index.top-charts', compact(
            'teacher',
            'teacherDetails',
            'lessionsData',
            'fav_cnt',
            'session_cnt',
        ))->render();

        return response()->json(['type' => 'success', 'html' => $html]);
    }

    public function getOnepage(Request $request)
    {
        $user_id = Auth::user()->id;

        $teacher = User::where('id', $user_id)->first();

        $teacherDetails = $teacher->details()->first();

        $teacherLessons = StudentLessonsBooking::select([
            'student_lessons_bookings.*',
            DB::raw("CONCAT(users.firstname, ' ', users.lastname) AS student_name"),
            DB::raw("location.title AS location"),
            'services.title AS service'
        ])
            ->where('teacher_id', $user_id)
            ->where('student_lessons_bookings.status', 'booked')
            ->whereDate('lession_date', '<=', date('Y-m-d'))
            ->leftJoin('users', 'users.id', 'student_lessons_bookings.user_id')
            ->leftJoin('location', 'location.id', 'student_lessons_bookings.location_id')
            ->leftJoin('services', 'services.id', 'student_lessons_bookings.service_id')
			->orderByRaw('student_lessons_bookings.lession_date desc, student_lessons_bookings.lession_time DESC')
            ->get();

        if (!empty($teacherLessons)) {
            $teacherLessons = $teacherLessons->toArray();
        }

        $html = view('teachers.dashboard.index.onepage', compact('teacher', 'teacherDetails', 'teacherLessons'))->render();

        return response()->json(['type' => 'success', 'html' => $html]);
    }
    public function autoSaveFilterPoint(Request $request)
    {
        $booking = StudentLessonsBooking::find($request->booking_id);
        $booking->filter_point_type = $request->filter_point_type;
        $booking->save();
    }
    public function autoSave(Request $request)
    {
        $booking = StudentLessonsBooking::find($request->booking_id);
		
		$points_to_improve_comment_textarea = $strong_points_comment_textarea = $lesson_comment_textarea = $ca = $fp = $lc = $v = $ga = '';
		if ($request->points_to_improve_comment_textarea != "") {
			$points_to_improve_comment_textarea = $request->points_to_improve_comment_textarea;
		}
		
		if ($request->strong_points_comment_textarea != "") {
			$strong_points_comment_textarea = $request->strong_points_comment_textarea;
		}
		
		if ($request->lesson_comment_textarea != "") {
			$lesson_comment_textarea = $request->lesson_comment_textarea;
		}
        // Update canvas HTML
        
		$ca_rating = $request->ca_rating;
		$fp_rating = $request->fp_rating;
		$lc_rating = $request->lc_rating;
		$v_rating = $request->v_rating;
		$ga_rating = $request->ga_rating;
		
		
        if ($request->canvas_html!= "") {
            $booking->canvas_html = $request->canvas_html;
            $booking->points_to_improve_comment = $points_to_improve_comment_textarea;
            $booking->strong_points_comment = $strong_points_comment_textarea;
            $booking->booking_comments = $lesson_comment_textarea;
            $booking->ca_rating = $ca_rating;
            $booking->fp_rating = $fp_rating;
            $booking->lc_rating = $lc_rating;
            $booking->v_rating = $v_rating;
            $booking->ga_rating = $ga_rating;
            $booking->save();
        }

        $task_record = StudentLessonsTasks::where('lesson_booking_id', $request->booking_id)->first();
        if (!$task_record) {
            $task_record = new StudentLessonsTasks();
            $task_record->lesson_booking_id = $request->booking_id;
            $task_record->student_lesson_id = $booking->student_lesson_id;
        }
        $task_record->lessons_material_and_tasks_1 = $request->lessons_material_and_tasks_1;
        $task_record->lessons_material_and_tasks_2 = $request->lessons_material_and_tasks_2;
        $task_record->lessons_material_and_tasks_3 = $request->lessons_material_and_tasks_3;
        $task_record->lessons_material_and_tasks_1 = $request->lessons_material_and_tasks_1;
        $task_record->lessons_tasks_1 = $request->lessons_tasks_1;
        $task_record->lessons_tasks_2 = $request->lessons_tasks_2;
        $task_record->lessons_tasks_3 = $request->lessons_tasks_3;
        $task_record->homework_lessons_material_and_tasks_1 = $request->homework_lessons_material_and_tasks_1;
        $task_record->homework_lessons_material_and_tasks_2 = $request->homework_lessons_material_and_tasks_2;
        $task_record->homework_lessons_material_and_tasks_3 = $request->homework_lessons_material_and_tasks_3;
        $task_record->next_lessons_tasks_1 = $request->next_lessons_tasks_1;
        $task_record->next_lessons_tasks_2 = $request->next_lessons_tasks_2;
        $task_record->next_lessons_tasks_3 = $request->next_lessons_tasks_3;
        $task_record->save();
		
		if(!empty($request->point_to_improve)) {				
			$studentWeakPoints = StudentLessonsPoints::where('lesson_booking_id', $request->booking_id)
							->whereIn('id', $request->point_to_improve)
							->update(['status' => 2]);
		}
		if(!empty($request->strong_points)) {				
			$studentStrongPoints = StudentLessonsPoints::where('lesson_booking_id', $request->booking_id)
							->whereIn('id', $request->strong_points)
							->update(['status' => 1]);				
		}

        //
        return response()->json(['type' => 'success']);
    }
    public function editItem(Request $request)
    {
        if ($request->type == "arp") {
            if ($request->line_1 =="" || $request->line_2 =="") {
                $response = [];
                $response['status'] = 'error';
                $action_chain['toastr']['type'] = 'error';
                $action_chain['toastr']['title'] = 'Error';
                $action_chain['toastr']['msg'] = 'Please insert a value';
                $response['action_chain'] = $action_chain;

                return response()->json($response);
            }
            StudentLessonsARP::find($request->id)->update(['line_1' => $request->line_1, 'line_2' => $request->line_2]);
        }
        if ($request->type == "cip") {
            if ($request->line_1 =="" || $request->line_2 =="") {
                $response = [];
                $response['status'] = 'error';
                $action_chain['toastr']['type'] = 'error';
                $action_chain['toastr']['title'] = 'Error';
                $action_chain['toastr']['msg'] = 'Please insert a value';
                $response['action_chain'] = $action_chain;

                return response()->json($response);
            }
            StudentLessonsCIP::find($request->id)->update(['incorrect_phrase' => $request->line_1, 'correct_phrase' => $request->line_2]);
        }
        if ($request->type == "keyword") {
            if ($request->line_1 =="") {
                $response = [];
                $response['status'] = 'error';
                $action_chain['toastr']['type'] = 'error';
                $action_chain['toastr']['title'] = 'Error';
                $action_chain['toastr']['msg'] = 'Please insert a value';
                $response['action_chain'] = $action_chain;

                return response()->json($response);
            }
            StudentLessonsKeyword::find($request->id)->update(['keyword' => $request->line_1]);
        }
        
        $response = [];
        $response['status'] = 'success';
        $response['selector'] = '.item-form-'.$request->id;
        $response['line_1_selector'] = '.line_1';
        $response['line_2_selector'] = '.line_2';
        $response['line_1'] = $request->line_1;
        $response['line_2'] = $request->line_2;
        $response['selector'] = '.item-form-'.$request->id;
        $action_chain['page'] = "none";
        $action_chain['Run function'] = 'hideForm';
        $response['action_chain'] = $action_chain;

        return response()->json($response);
    }

    public function updatePoints(Request $request)
    {
        if ($request->has('strong_ids')) {
            $moveToStrongPoints = StudentLessonsPoints::whereIn('id', $request->strong_ids)->update(['status' => 1]);
        }
        if ($request->has('week_ids')) {
            $moveToWeekPoints = StudentLessonsPoints::whereIn('id', $request->week_ids)->update(['status' => 2]);
        }
		//echo $request->booking_id;
    }

    public function startSession(Request $request)
    {
        $user_id = Auth::user()->id;
        $teacher = User::where('id', $user_id)->first();
        $teacherDetails = $teacher->details()->first();

        $input = $request->all();

        $student_id = $input['student_id'];
		$student = User::where('id', $student_id)->first();
        $service_id = $input['service_id'];
        $booking_id = $input['booking_id'];
		
		$request->session()->put('session_student_id', $student_id);
		
		$booking = StudentLessonsBooking::where('id', $input['booking_id'])->with('topics')->first();

        $studentLesson = StudentLessons::where('user_id', $input['student_id'])
            ->where('service_id', $input['service_id'])
            ->where('id', $booking->student_lessons_id)
            ->with(
                'student_level',
                'tasks',
                'cips',
                'keywords',
                'topics',
                'last_topic'
            )
			->with([
                    'arps' => function ($aq) use ($booking_id) {
                        $aq->where('lesson_booking_id', $booking_id);
                    }]
            )
            ->first();

        if (!empty($studentLesson->student_package_id)) {
            $alertLesson = 5;
        } else {
            $service = Services::find($service_id);
            $alertLesson = round($service->available_lessons * 20 / 100);
        }

        if (empty($studentLesson)) {
            StudentLessons::create(['user_id' => $input['student_id'], 'service_id' => $input['service_id']]);
            $studentLesson = StudentLessons::where('user_id', $input['student_id'])
                ->where('service_id', $input['service_id'])
                ->with(
                    'student_level',
                    'tasks',
                    'cips',
                    'keywords',
                    'topics',
                    'last_topic'
                )
			->with([
                    'arps' => function ($aq) use ($booking_id) {
                        $aq->where('lesson_booking_id', $booking_id);
                    }]
            )
                ->first();
        }

        

        $completedBookingsIds = StudentLessonsBooking::where('user_id', $input['student_id'])
            ->where('service_id', $input['service_id'])
            ->orderByRaw('id')
            ->pluck('id')
            ->toArray();

        $currBookingIndx = '';

        $currBooking = array_search($input['booking_id'], $completedBookingsIds);
        $currBookingIndx = $currBooking + 1;

        $levels = OnePageLevels::where('status', 1)->with([
            'ca',
            'fp',
            'lc',
            'v',
            'ga',
        ])->orderBy('id', 'ASC')->get();


        $studentLessonPoints = StudentLessonsPoints::where('lesson_booking_id', $booking->id)
            ->where('level_id', $student->student_level_id)
            ->with('point')
            ->get();

        if (empty($studentLessonPoints->toArray())) {
            $points = OnePageLevelsPoints::where('level_id', $student->student_level_id)->where('status', 1)->get();

            foreach ($points as $pkey => $point) {
                StudentLessonsPoints::create([
                    'student_lesson_id' => $studentLesson->id,
                    'lesson_booking_id' => $booking->id,
                    'level_id' => $student->student_level_id,
                    'point_id' => $point->id,
                    'rating_point' => $point->rating_point,
                    'status' => 2,
                    'user_id' => $student_id,
                    'teacher_id' => $user_id,
                ]);
            }
        }

		$level_detail = OnePageLevels::where('id', $student->student_level_id)->where('status', 1)->first();

        /*$studentLessonPoints = StudentLessonsPoints::where('lesson_booking_id', $booking->id)
            ->where('level_id', $student->student_level_id)
            ->with('point')
            ->get();

        $studentLessonPTI = StudentLessonsPoints::where('lesson_booking_id', $booking->id)
            ->where('status', 2)
            ->where('level_id', $student->student_level_id)
            ->with('point')
            ->get();

        $studentLessonSP = StudentLessonsPoints::where('lesson_booking_id', $booking->id)
            ->where('level_id', $studentLesson->student_level_id)
            ->where('status', 1)
            ->with('point')
            ->get();*/


        $allBookingsIds = StudentLessonsBooking::where('status', 'completed')
            ->with('topics')
            ->where('user_id', $student_id)
            ->where('service_id', $studentLesson->service_id)
            ->orderByRaw('completed_at DESC NULLS LAST')
            ->pluck('id')
            //->get()
            ->toArray();

         /*$prevID = current($allBookingsIds);
	   
	   
        $previousBooking = [];
        if ($prevID) {
            $previousBooking = StudentLessonsBooking::where('id', $prevID)->with('topics')->first();
        }*/
		$previousBooking = StudentLessonsBooking::where('status', 'completed')->where('user_id', $student_id)->with('topics')->orderBy('lession_date', 'desc')->orderBy('lession_time', 'desc')->first();
		//echo '<pre>';print_r($previousBooking);	exit;	
        if ($previousBooking) {
            if(!$booking->filter_point_type){
                $booking->filter_point_type = $previousBooking->filter_point_type;
                $booking->save();
            
				$previous_booking_points = StudentLessonsPoints::where('lesson_booking_id', $previousBooking->id)->get();
				foreach ($previous_booking_points as $key => $previous_booking_point) {
					$corresponding_current_booking_point = StudentLessonsPoints::where('lesson_booking_id', $booking->id)
					->where('point_id', $previous_booking_point->point_id)
					->first();
					if ($corresponding_current_booking_point) {
						$corresponding_current_booking_point->status = $previous_booking_point->status;
						$corresponding_current_booking_point->save();
					}
				}
			}
        }
        $isAlertRating = 0;

        $newAlertArray = array_slice($allBookingsIds, 0, $alertLesson, true);
        $avgAlertRatings = 5;
        foreach ($newAlertArray as $akey => $alert) {
            $alertBooking = StudentLessonsBooking::where('id', $alert)->first();
            $tempAvgAltRatings = ($alertBooking->ca_rating +
                                $alertBooking->fp_rating +
                                $alertBooking->lc_rating +
                                $alertBooking->v_rating +
                                $alertBooking->ga_rating) / 5;
            if ($avgAlertRatings == $tempAvgAltRatings) {
                $isAlertRating = 1;
                $avgAlertRatings = $tempAvgAltRatings;
            } else {
                $isAlertRating = 0;
                break;
            }
        }

        

        $avgRatData = [];
        if (!empty($studentLesson) && $studentLesson->toArray()) {
            $totalRatingData = StudentLessonsPoints::select(
                'rating_point',
                DB::raw('COUNT(*) AS total_count')
                )
                ->where('student_lesson_id', $studentLesson->id)
                ->where('level_id', $student->student_level_id)
                ->groupBy(DB::raw('rating_point'))
                ->get()->toArray();
            $ptoiData = StudentLessonsPoints::select(
                'rating_point',
                DB::raw('COUNT(*) AS imp_count')
                )
                ->where('student_lesson_id', $studentLesson->id)
                ->where('status', 2)
                ->where('level_id', $student->student_level_id)
                ->groupBy(DB::raw('rating_point'))
                ->get()->toArray();

            $finalArray = array();
            $totalPoints = array();
            foreach ($totalRatingData as $tk => $trd) {
                foreach ($ptoiData as $pk => $pid) {
                    if ($trd['rating_point'] == $pid['rating_point']) {
                        $finalArray[$trd['rating_point']] = [
                            'total_count'  => $trd['total_count'],
                            'imp_count'    => $pid['imp_count'],
                        ];

                        $totalPoints[$trd['rating_point']] = $trd['total_count'];
                    }
                }
            }

            $avgRatData = [];
            foreach ($finalArray as $fkey => $fpo) {
                if ($fpo['imp_count']) {
                    if ($fpo['total_count'] == $fpo['imp_count']) {
                        $avgRatData[$fkey] = '5.00';
                    } else {
                        $avgRatData[$fkey] = number_format((5*$fpo['imp_count']/$fpo['total_count']), 2);
                        if ($avgRatData[$fkey] < 1) {
                            $avgRatData[$fkey] = 1;
                        }
                    }
                } else {
                    $avgRatData[$fkey] = 1;
                }

                $avgRatData[$fkey] = !empty($avgRatData[$fkey]) ? $avgRatData[$fkey] : 1;
            }
        }
		$onepage_level_points_cnt = [];
		$onepage_level_points = OnePageLevelsPoints::select(
                'rating_point',
                DB::raw('COUNT(*) AS cnt')
                )
                ->where('level_id', $student->student_level_id)
                ->groupBy(DB::raw('rating_point'))
                ->get()->toArray();
		foreach ($onepage_level_points as $onepage_level_points) {
			$onepage_level_points_cnt[$onepage_level_points['rating_point']] = $onepage_level_points['cnt'];
		}
		//echo '<pre>';print_r($onepage_level_points_cnt);	exit;	
			
        if ($previousBooking) {
            /*foreach ($studentLessonPoints as $key => $point) {
                $previousBookingPoint =  StudentLessonsPoints::where('lesson_booking_id', $previousBooking->id)
                    ->where('point_id', $point->point_id)
                    ->first();
                if (isset($previousBookingPoint->status)) {
                    if ($previousBookingPoint->status != 2) {
                        $point->status = $previousBookingPoint->status;
                        $point->save();
                    }
                }
            }*/
			
            $task_record = StudentLessonsTasks::where('lesson_booking_id', $booking->id)->first();
            $prevRecord = StudentLessonsTasks::where('lesson_booking_id', $previousBooking->id)->first();
            if (!$task_record && $prevRecord) {
                $task_record = new StudentLessonsTasks();
                $task_record->lesson_booking_id = $booking->id;
                $task_record->student_lesson_id = $booking->student_lessons_id;
                $task_record->lessons_material_and_tasks_1 = $prevRecord->homework_lessons_material_and_tasks_1;
                $task_record->lessons_material_and_tasks_2 = $prevRecord->homework_lessons_material_and_tasks_2;
                $task_record->lessons_material_and_tasks_3 = $prevRecord->homework_lessons_material_and_tasks_3;
                $task_record->lessons_tasks_1 = $prevRecord->next_lessons_tasks_1;
                $task_record->lessons_tasks_2 = $prevRecord->next_lessons_tasks_2;
                $task_record->lessons_tasks_3 = $prevRecord->next_lessons_tasks_3;				
                $task_record->user_id = $student_id;
                $task_record->teacher_id = $user_id;
                $task_record->save();
            }
            $already_added = StudentLessonsARP::where('lesson_booking_id', $booking->id)->count();
            if ($already_added==0) {
				
				$booking->ca_rating = $previousBooking->ca_rating;
				$booking->fp_rating = $previousBooking->fp_rating;
				$booking->lc_rating = $previousBooking->lc_rating;
				$booking->v_rating = $previousBooking->v_rating;
				$booking->ga_rating = $previousBooking->ga_rating;		
				$booking->save();
			
				$keywordsArray = [];
				if (!empty($previousBooking->keywords)) {
					foreach ($previousBooking->keywords as $key => $keyword) {
						if (in_array($keyword->status, [1,3])) {
							$keywordsArray[] = $keyword->keyword;
						}
					}
				}
				
				
                foreach ($previousBooking->arps as $key => $arp) {
                    if (in_array($arp->status, [1,3])) {
                        /*$narp = new StudentLessonsARP;
                        $narp->student_lesson_id = $booking->student_lessons_id;
                        $narp->line_1 = $arp->line_1;
                        $narp->line_2 = $arp->line_2;
                        $narp->status = $arp->status;
                        $narp->status_changed_booking_id = $arp->status_changed_booking_id;
                        $narp->lesson_booking_id = $booking->id;
                        $narp->save();*/
						
						$arpdata = array(
							'student_lesson_id' => $booking->student_lessons_id,
							'lesson_booking_id' => $booking->id,
							'line_1'            => $arp->line_1,
							'line_2'            => $arp->line_2,
							'status'            => $arp->status,
							'status_changed_booking_id' => $arp->status_changed_booking_id,
							'user_id' => $student_id,
							'teacher_id' => $user_id,
						);
						$arpid = StudentLessonsARP::create($arpdata);
						$arp_id = $arpid->id;
						if(!empty($keywordsArray)){							 
							$this->checkKeywordInArp($arp->line_1, $arp->line_2, $keywordsArray, $arp_id);							
						}
						
                    }
                }
                foreach ($previousBooking->cips as $key => $cip) {
                    if (in_array($cip->status, [1,3])) {
                        $ncip = new StudentLessonsCIP;
                        $ncip->student_lesson_id = $booking->student_lessons_id;
                        $ncip->correct_phrase = $cip->correct_phrase;
                        $ncip->incorrect_phrase = $cip->incorrect_phrase;
                        $ncip->status = $cip->status;
                        $ncip->status_changed_booking_id = $cip->status_changed_booking_id;
                        $ncip->lesson_booking_id = $booking->id;			
						$ncip->user_id = $student_id;
						$ncip->teacher_id = $user_id;
                        $ncip->save();
                    }
                }
                foreach ($previousBooking->keywords as $key => $keyword) {
                    if (in_array($keyword->status, [1,3])) {
                        $nkeyword = new StudentLessonsKeyword;
                        $nkeyword->student_lesson_id = $booking->student_lessons_id;
                        $nkeyword->keyword = $keyword->keyword;
                        $nkeyword->keyword_ja = $keyword->keyword_ja;
                        $nkeyword->status = $keyword->status;
                        $nkeyword->status_changed_booking_id = $keyword->status_changed_booking_id;
                        $nkeyword->lesson_booking_id = $booking->id;			
						$nkeyword->user_id = $student_id;
						$nkeyword->teacher_id = $user_id;
						if(isset($this->keywordArpId[$keyword->keyword])) {
							$nkeyword->arp_id = $this->keywordArpId[$keyword->keyword];
						}
                        //$nkeyword->arp_id = $keyword->arp_id;
                        $nkeyword->save();
                    }
                }
            }
        }
		
		$studentLessonPoints = StudentLessonsPoints::where('lesson_booking_id', $booking->id)
            ->where('level_id', $student->student_level_id)
            ->with('point')
            ->get();
			
		$studentLessonPTI = StudentLessonsPoints::where('lesson_booking_id', $booking->id)
            ->where('status', 2)
            ->where('level_id', $student->student_level_id)
            ->with('point')
            ->get();
			
		$studentLessonSP = StudentLessonsPoints::where('lesson_booking_id', $booking->id)
            ->where('level_id', $student->student_level_id)
            ->where('status', 1)
            ->with('point')
            ->get();

        $arpData = StudentLessonsARP::select(
            'status',
            DB::raw('count(*) as total')
        )
            ->where('lesson_booking_id', $booking->id)
            ->groupBy('status')
            ->get()->toArray();

        $cipData = StudentLessonsCIP::select(
            'status',
            DB::raw('count(*) as total')
        )
            ->where('lesson_booking_id', $booking->id)
            ->groupBy('status')
            ->get()->toArray();

        $keypData = StudentLessonsKeyword::select(
            'status',
            DB::raw('count(*) as total')
        )
            ->where('lesson_booking_id', $booking->id)
            ->groupBy('status')
            ->get()->toArray();

        $statusData = [];

        foreach ($arpData as $arps) {
            if (!empty($statusData[$arps['status']])) {
                $statusData[$arps['status']] += $arps['total'];
            } else {
                $statusData[$arps['status']] = $arps['total'];
            }
        }
        foreach ($cipData as $cips) {
            if (!empty($statusData[$cips['status']])) {
                $statusData[$cips['status']] += $cips['total'];
            } else {
                $statusData[$cips['status']] = $cips['total'];
            }
        }
        foreach ($keypData as $ks) {
            if (!empty($statusData[$ks['status']])) {
                $statusData[$ks['status']] += $ks['total'];
            } else {
                $statusData[$ks['status']] = $ks['total'];
            }
        }

        //$student = User::find($student_id);
        $drive_id = $student->drive_folder_id;
        $drivefolders = [];
        if ($drive_id) {
            $drivefolders = AppHelper::getFolderData($drive_id);
        }
        $open_folder_id = $drive_id;

        $html = view('teachers.dashboard.index.onepage.detail', compact(
            'teacher',
            'teacherDetails',
            'studentLesson',
            'studentLessonPoints',
            'booking',
            'levels',
            'level_detail',
            'student',
            'student_id',
            'service_id',
            'booking_id',
            'previousBooking',
            'avgRatData',
            'drivefolders',
            'drive_id',
            'open_folder_id',
            'totalPoints',
            'statusData',
            'studentLessonPTI',
            'studentLessonSP',
            'isAlertRating',
            'onepage_level_points_cnt',
            'currBookingIndx'
        ))->render();

        return response()->json(['type' => 'success', 'html' => $html]);
    }

    public function getKeywords(Request $request)
    {
        $user_id = Auth::user()->id;
        $teacher = User::where('id', $user_id)->first();
        $teacherDetails = $teacher->details()->first();

        $html = view('teachers.dashboard.index.keywords', compact('teacher', 'teacherDetails'))->render();

        return response()->json(['type' => 'success', 'html' => $html]);
    }

    public function getKeywordSearch(Request $request)
    {
        $user_id = Auth::user()->id;
        $teacher = User::where('id', $user_id)->first();
        $teacherDetails = $teacher->details()->first();

        $squery = $request->get('search-query', '');

        $html = view('teachers.dashboard.index.keywords.keyword-table', compact('teacher', 'teacherDetails', 'squery'))->render();

        return response()->json(['type' => 'success', 'html' => $html]);
    }

    public function getSearch(Request $request)
    {
        $user_id = Auth::user()->id;
        $teacher = User::where('id', $user_id)->first();
        $teacherDetails = $teacher->details()->first();
        $ref = $squery = '';
        $results = [];
		
		$session_student_id = 0;
		if ($request->session()->has('session_student_id')) {
			$session_student_id = $request->session()->get('session_student_id');
		}
		
        //echo request()->radio_search_by;
        if (request()->has('radio_search_by') && request()->radio_search_by == 'onepage') {
			$keyword = strtolower(request()->search_query);
			$serch_date = $keyword;
			if (strpos($keyword, ':')) {
                $recived_string = explode(':', $keyword);
                $serch_date = $recived_string[0];
                $student_name = $recived_string[1];
            }
            $bookings = StudentLessonsBooking::where('student_lessons_bookings.status', 'completed')
                ->where('student_lessons_bookings.teacher_id', $user_id)
                ->with('topics', 'student');
            
			
            if (request()->has('search_query') && request()->search_query) {
                $bookings->whereRaw("LOWER(onepage_title) LIKE '" . $serch_date . "%'");
            }
			
			/*if ($session_student_id > 0) {
                $bookings->where('student_lessons_bookings.user_id', $session_student_id);
            }*/
			
			
			/*$bookings = StudentLessonsBooking::select('student_lessons_bookings.*', 'student_lessons_topic.title as topic_title')
			->where('student_lessons_bookings.status', 'completed')
                ->where('student_lessons_bookings.teacher_id', $user_id);
                //->with('topics');
            $bookings->Join('student_lessons_topic', 'student_lessons_topic.lesson_booking_id', 'student_lessons_bookings.id');
			
            if (request()->has('search_query') && request()->search_query) {
                $bookings->whereRaw("LOWER(onepage_title) LIKE '" . $serch_date . "%'");
            }
			if($student_name != '') {
				$bookings->Join('users', 'users.id', 'student_lessons_bookings.user_id');
				
			}*/
			
            $results = $bookings->get();
        } else {
            if (request()->has('search_query') && request()->search_query) {
                $date = date('Y-m-d');
                //$get_one_key = "select id, search_count from " . $wpdb->prefix . "search_analytics where user_id = " . $user_id . " and keyword = '" . $keyword . "' and STR_TO_DATE(searched_on, '%Y-%m-%d')= '" . $date . "'";
                $keyword = strtolower(request()->search_query);
                $get_one_key = SearchAnalytics::where('user_id', $user_id)
                ->where('keyword', $keyword)
                ->where('searched_on', $date)
                ->first();
                
                if (!empty($get_one_key) && $get_one_key->toArray()) {
                    $date = date('Y-m-d');
                    $keyword_count = $get_one_key->search_count + 1;
                    //$query = "update " . $wpdb->prefix . "search_analytics set search_count = $keyword_count, searched_on = '" . $date . "' where id = " . $last_inserted_key['id'];
                    
                    $studentWeakPoints = SearchAnalytics::where('id', $get_one_key->id)
                        ->update(['search_count' => $keyword_count, 'searched_on' => $date]);
                } else {
                    $date = date('Y-m-d');
                    $keyword_count = 1;
                    /*$insert1 = 'insert into ' . $wpdb->prefix . 'search_analytics set ';
                    $insert1 .= 'user_id = "' . $user_id . '", ';
                    $insert1 .= 'keyword = "' . $keyword . '", ';
                    $insert1 .= 'searched_on = "' . $date . '", ';
                    $insert1 .= 'search_count = "' . $keyword_count . '"';
                    $wpdb->query($insert1);*/
                    
                    $insertdata[] = array('user_id'=>$user_id, 'keyword'=> $keyword, 'searched_on'=>$date, 'search_count'=>$keyword_count);
                    DB::table('search_analytics')->insert($insertdata); // Query Builder approach
                }
            }
            
            
            $teacherKeywrds = StudentLessonsKeyword::select([
                'student_lessons_bookings.*',
                'student_lessons_keywords.id AS id',
                'student_lessons_keywords.keyword AS keyword',
                'student_lessons_keywords.keyword_ja AS keyword_ja',
                'student_lessons_bookings.lession_date as cdate',
                'student_lessons_keywords.lesson_booking_id as lesson_booking_id',
                DB::raw("CONCAT(users.firstname, ' ', users.lastname) AS student_name"),
            ])
                ->Join('student_lessons_bookings', 'student_lessons_bookings.id', 'student_lessons_keywords.lesson_booking_id')
                ->Join('users', 'users.id', 'student_lessons_bookings.user_id')
                ->where('student_lessons_bookings.teacher_id', $user_id)
                ->with('topics')
                ->orderBy('student_lessons_keywords.id', 'DESC');

            if (request()->has('search_query') && request()->search_query) {
			$teacherKeywrds->whereRaw("(LOWER(keyword) LIKE '" . strtolower(request()->search_query) . "%' or LOWER(keyword_ja) LIKE '" . strtolower(request()->search_query) . "%')");
                    //->orwhereRaw("LOWER(keyword_ja) LIKE '" . strtolower(request()->search_query) . "%'");
            }
			if ($session_student_id > 0) {
                $teacherKeywrds->where('student_lessons_bookings.user_id', $session_student_id);
            }
			
            $results = $teacherKeywrds->get();
        }
    
        return view('teachers.dashboard.index.search', compact('teacher', 'teacherDetails', 'ref', 'squery', 'results'));
    }
    
    public function getOnepageSearch(Request $request)
    {
        $user_id = Auth::user()->id;
        $teacher = User::where('id', $user_id)->first();
        $teacherDetails = $teacher->details()->first();

        $squery = $request->get('search-query', '');

        $html = view('teachers.dashboard.index.keywords.onepage-table', compact('teacher', 'teacherDetails', 'squery'))->render();

        return response()->json(['type' => 'success', 'html' => $html]);
    }

    public function getKeywordOnepageSearch(Request $request)
    {
        $user_id = Auth::user()->id;
        $teacher = User::where('id', $user_id)->first();
        $teacherDetails = $teacher->details()->first();

        $squery = $request->get('search-query', '');

        $html = view('teachers.dashboard.index.keywords.keyword-onepage-table', compact('teacher', 'teacherDetails', 'squery'))->render();

        return response()->json(['type' => 'success', 'html' => $html]);
    }

    public function getKeywordList(Request $request)
    {
		$session_student_id = 0;
		if ($request->session()->has('session_student_id')) {
			$session_student_id = $request->session()->get('session_student_id');
		}
        $user_id = Auth::user()->id;
        $teacherKeywrds = StudentLessonsKeyword::select([
            'student_lessons_bookings.*',
            'student_lessons_keywords.id AS id',
            'student_lessons_keywords.keyword AS keyword',
            'student_lessons_bookings.lession_date as cdate',
            'student_lessons_keywords.lesson_booking_id as lesson_booking_id'
        ])
            ->Join('student_lessons_bookings', 'student_lessons_bookings.id', 'student_lessons_keywords.lesson_booking_id')
            ->where('student_lessons_bookings.teacher_id', $user_id)
            ->where('student_lessons_bookings.status', 'completed')
			->where(function($query) use ($session_student_id)  {
				if($session_student_id > 0) {
					$query->where('student_lessons_bookings.user_id', $session_student_id);
				}
			 })
            ->with('topics')
            ->orderBy('student_lessons_keywords.id', 'DESC');

        if (request()->has('search') && request()->search) {
            /*$teacherKeywrds->whereRaw("LOWER(keyword11) LIKE '" . strtolower(request()->search) . "%'")
                ->orwhereRaw("LOWER(keyword_ja) LIKE '" . strtolower(request()->search) . "%'");*/
				
			$teacherKeywrds->where(function ($query) {
				$query->whereRaw("LOWER(keyword) LIKE '" . strtolower(request()->search) . "%'")
                ->orwhereRaw("LOWER(keyword_ja) LIKE '" . strtolower(request()->search) . "%'");
			});	
        }

        return DataTables::of($teacherKeywrds)

            ->addIndexColumn()
            //->orderColumn('id', 'DESC')

            ->editColumn('id', function ($keyword) {
                return $keyword->id;
            })
            ->addColumn('topic', function ($keyword) {
                if (!empty($keyword->topics) && $keyword->topics->toArray()) {
                    $topics = current($keyword->topics->toArray());

                    return !empty($topics['title']) ? $topics['title'] : '';
                } else {
                    return '';
                }
            })
            ->addColumn('translate', function ($keyword) {
                if (!empty($keyword) && $keyword->toArray()) {
                    $keyword = $keyword->toArray();
                    if (!empty($keyword['keyword_ja'])) {
                        return $keyword['keyword_ja'];
                    } else {
                        //return GoogleTranslate::trans($keyword['keyword'], 'ja', 'en');
                        return $keyword['keyword'];
                    }
                } else {
                    return '';
                }
            })
            ->addColumn('lession_date', function ($keyword) {
                if (!empty($keyword) && $keyword->toArray()) {
                    $keyword = $keyword->toArray();
                    if (!empty($keyword['lession_date'])) {
                        return '<a target="_blank" class="onepage-report-action p-2" href="'.route('students.share.onepage.index', ['id' => encrypt($keyword['lesson_booking_id'])]).'">'.$keyword['lession_date'].'</a>';
                    }
                } else {
                    return '';
                }
            })
			->rawColumns(['lession_date',])
            ->make(true);
    }

    public function getOnepageList(Request $request)
    {
        $user_id = Auth::user()->id;

        $bookings = StudentLessonsBooking::where('status', 'completed')
            ->where('teacher_id', $user_id)
            ->with('topics', 'student');

        return DataTables::of($bookings)
            ->addIndexColumn()
            ->filter(function ($query) {
                if (request()->has('search') && request()->search) {
                    $query->whereRaw("LOWER(onepage_title) LIKE '" . strtolower(request()->search) . "%'");
                }
            })
            ->editColumn('onepage_title', function ($booking) {
                return '<b><a href="'.route('students.share.onepage.index', ['id' => encrypt($booking->id)]).'">Lokalingo OnePage ' . $booking->onepage_title.'</a></b>';
            })
            ->addColumn('topic', function ($booking) {
                if (!empty($booking->topics) && $booking->topics->toArray()) {
                    $topics = current($booking->topics->toArray());

                    return !empty($topics['title']) ? $topics['title'] : '';
                } else {
                    return '';
                }
            })
            ->addColumn('student', function ($booking) {
                if (!empty($booking->student) && $booking->student->toArray()) {
                    $student = $booking->student->firstname . ' ' . $booking->student->lastname;

                    return '<span class="badge badge-info" style="background-color:#002e58;">' . $student . '</span>';
                } else {
                    return '';
                }
            })
            ->addColumn('action', function ($booking) {
                return '<a id="' . $booking->id . '" style="cursor:pointer;" class="btn btn-sm btn-icon btn-pure btn-default"
                       data-toggle="tooltip" title="View" data-original-title="View"><i class="fas fa-eye" aria-hidden="true"></i></a>';
            })
            ->rawColumns(['student', 'action', 'onepage_title'])
            ->make(true);
    }

    public function getKeywordOnepageList(Request $request)
    {
        $user_id = Auth::user()->id;
        $keywords = StudentLessonsKeyword::select([
                'student_lessons_keywords.keyword AS topics',
                'student_lessons_keywords.lesson_booking_id as lesson_booking_id',
                'student_lessons_bookings.user_id as student_id'
            ])
            ->Join('student_lessons_bookings', 'student_lessons_bookings.id', 'student_lessons_keywords.lesson_booking_id')
            ->where('student_lessons_bookings.teacher_id', $user_id)
            ->whereRaw("LOWER(keyword) LIKE '%" . strtolower($request->search) . "%'")
            ->orwhereRaw("LOWER(keyword_ja) LIKE '%" . strtolower($request->search) . "%'")
            ->get()->toArray()
            ;
        $arpsLine1 = StudentLessonsARP::select([
                'student_lessons_active_recall_pairs.line_1 AS topics',
                'student_lessons_active_recall_pairs.lesson_booking_id as lesson_booking_id',
                'student_lessons_bookings.user_id as student_id'
            ])
            ->Join('student_lessons_bookings', 'student_lessons_bookings.id', 'student_lessons_active_recall_pairs.lesson_booking_id')
            ->where('student_lessons_bookings.teacher_id', $user_id)
            ->whereRaw("LOWER(student_lessons_active_recall_pairs.line_1) LIKE '%" . strtolower($request->search) . "%'")
            ->get()->toArray()
            ;
        $arpsLine2 = StudentLessonsARP::select([
                'student_lessons_active_recall_pairs.line_2 AS topics',
                'student_lessons_active_recall_pairs.lesson_booking_id as lesson_booking_id',
                'student_lessons_bookings.user_id as student_id'
            ])
            ->Join('student_lessons_bookings', 'student_lessons_bookings.id', 'student_lessons_active_recall_pairs.lesson_booking_id')
            ->where('student_lessons_bookings.teacher_id', $user_id)
            ->whereRaw("LOWER(student_lessons_active_recall_pairs.line_2) LIKE '%" . strtolower($request->search) . "%'")
            ->get()->toArray()
            ;
        $topics = StudentLessonsTopic::select([
                'student_lessons_topic.title AS topics',
                'student_lessons_topic.lesson_booking_id as lesson_booking_id',
                'student_lessons_bookings.user_id as student_id'
            ])
            ->Join('student_lessons_bookings', 'student_lessons_bookings.id', 'student_lessons_topic.lesson_booking_id')
            ->where('student_lessons_bookings.teacher_id', $user_id)
            ->whereRaw("LOWER(student_lessons_topic.title) LIKE '%" . strtolower($request->search) . "%'")
            ->get()->toArray()
            ;

        $teacherKeywrds = array_merge($keywords, $arpsLine1, $arpsLine2, $topics);

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
                $student = User::find($booking['student_id']);
                if (!empty($student) && $student->toArray()) {
                    $studentname = $student->firstname . ' ' . $student->lastname;

                    return '<span class="badge badge-info" style="background-color:#002e58;">' . $studentname . '</span>';
                } else {
                    return '';
                }
            })
            ->addColumn('action', function ($booking) {
                return '<a target="_blank" class="onepage-report-action p-2" href="'.route('students.share.onepage.index', ['id' => encrypt($booking['lesson_booking_id'])]).'">ONEPAGE REPORT</a>';
            })
            ->rawColumns(['student', 'action','onepage_title','topic','translate'])
            ->make(true);
    }

    public function updateStudentLevel(Request $request)
    {
		
        $input = $request->all();

        /*$studentLesson = StudentLessons::where('id', $input['id'])->first();		
        $studentLesson->student_level_id = $input['student_level_id'];
        $studentLesson->save();*/

		$booking_id = $input['booking_id'];
		$student_id = $input['user_id'];
		$student = User::where('id', $student_id)->first();		
        $student->student_level_id = $input['student_level_id'];
		$student->save();
		
		$booking = StudentLessonsBooking::where('id', $booking_id)->first();
		$booking->ca_rating = 5;
		$booking->fp_rating = 5;
		$booking->lc_rating = 5;
		$booking->v_rating = 5;
		$booking->ga_rating = 5;
		$booking->save();
		
        /*$points = OnePageLevelsPoints::where('level_id', $input['student_level_id'])->where('status', 1)->get();

        foreach ($points as $pkey => $point) {
            StudentLessonsPoints::create([
                'student_lesson_id' => $input['id'],
                'level_id' => $input['student_level_id'],
                'point_id' => $point->id,
                'rating_point' => $point->rating_point,
                'status' => 2
            ]);
        }

        $studentLesson = StudentLessons::where('id', $input['id'])->with('student_level')->first();

        $studentLessonPoints = StudentLessonsPoints::where('student_lesson_id', $input['id'])
            ->where('level_id', $input['student_level_id'])
            ->with('point')
            ->get();

        $studentLessonPTI = StudentLessonsPoints::where('student_lesson_id', $input['id'])
            ->where('status', 2)
            ->with('point')
            ->get();

        $studentLessonSP = StudentLessonsPoints::where('student_lesson_id', $input['id'])
            ->where('level_id', $input['student_level_id'])
            ->where('status', 1)
            ->with('point')
            ->get();

        $avgRatData = [];
        if (!empty($studentLesson) && $studentLesson->toArray()) {
            $totalRatingData = StudentLessonsPoints::select(
                'rating_point',
                DB::raw('COUNT(*) AS total_count')
                )
                ->where('student_lesson_id', $studentLesson->id)
                ->where('level_id', $input['student_level_id'])
                ->groupBy(DB::raw('rating_point'))
                ->get()->toArray();
            $ptoiData = StudentLessonsPoints::select(
                'rating_point',
                DB::raw('COUNT(*) AS imp_count')
                )
                ->where('student_lesson_id', $studentLesson->id)
                ->where('status', 2)
                ->where('level_id', $input['student_level_id'])
                ->groupBy(DB::raw('rating_point'))
                ->get()->toArray();

            $finalArray = array();
            $totalPoints = array();
            foreach ($totalRatingData as $tk => $trd) {
                foreach ($ptoiData as $pk => $pid) {
                    if ($trd['rating_point'] == $pid['rating_point']) {
                        $finalArray[$trd['rating_point']] = [
                            'total_count'  => $trd['total_count'],
                            'imp_count'    => $pid['imp_count'],
                        ];

                        $totalPoints[$trd['rating_point']] = $trd['total_count'];
                    }
                }
            }

            $avgRatData = [];
            foreach ($finalArray as $fkey => $fpo) {
                if ($fpo['imp_count']) {
                    if ($fpo['total_count'] == $fpo['imp_count']) {
                        $avgRatData[$fkey] = 5;
                    } else {
                        $avgRatData[$fkey] = number_format((5*$fpo['imp_count']/$fpo['total_count']), 2);
                        if ($avgRatData[$fkey] < 1) {
                            $avgRatData[$fkey] = 1;
                        }
                    }
                } else {
                    $avgRatData[$fkey] = 1;
                }

                $avgRatData[$fkey] = ($avgRatData[$fkey] == 0) ? $avgRatData[$fkey] : 1;
            }
        }*/

$phtml = '';
        /*$phtml = view('teachers.dashboard.index.onepage.detail.report.point-to-improve.detail', compact(
            'studentLessonPoints',
            'studentLesson',
            'avgRatData',
            'totalPoints',
            'studentLessonPTI',
            'studentLessonSP'
        ))->render();

        $html = view('teachers.dashboard.index.onepage.detail.report.student-lesson-profile.detail', compact(
            'studentLesson'
        ))->render();*/
$html = '';
        return response()->json(['type' => 'success', 'html' => $html, 'phtml' => $phtml]);
    }

    public function updateStudentPoints(Request $request)
    {
        $input = $request->all();

        /*$studentLesson = StudentLessons::where('id', $input['id'])->first();
        $studentLesson->student_level_id = $input['student_level_id'];
        $studentLesson->save();*/

		$student_id = $studentLesson->user_id;
		$student = User::where('id', $student_id)->first();		
        $student->student_level_id = $input['student_level_id'];
		$student->save();
		
        $points = OnePageLevelsPoints::where('level_id', $input['student_level_id'])->where('status', 1)->get();

        foreach ($points as $pkey => $point) {
            StudentLessonsPoints::create([
                'student_lesson_id' => $input['id'],
                'level_id' => $input['student_level_id'],
                'point_id' => $point->id,
                'status' => 2
            ]);
        }


        $studentLesson = StudentLessons::where('id', $input['id'])->with('student_level')->first();

        $studentLessonPoints = StudentLessonsPoints::where('student_lesson_id', $input['id'])
            ->where('level_id', $input['student_level_id'])
            ->with('point')
            ->get();

        $html = view('teachers.dashboard.index.onepage.detail.report.student-lesson-profile.detail', compact(
            'studentLesson'
        ))->render();

        return response()->json(['type' => 'success', 'html' => $html]);
    }

    public function wrapLesson(Request $request)
    {
		
        $user_id = Auth::user()->id;
        $teacher = User::where('id', $user_id)->first();
        $teacherDetails = $teacher->details()->first();

        $isAlertRating = 0;

        $input = $request->all();
        $lesson_record_id = $input['booking_id'];
        $order_id = $input['lesson_id'];
        
        $booking = $get_prev_lessons_id_result = StudentLessonsBooking::where('id', $lesson_record_id)->with('student')->first();
        $lesson_date_time = $booking->lession_date.' '.$booking->lession_time;
        $completedBookingsIds = StudentLessonsBooking::where('user_id', $booking->user_id)
            ->where('service_id', $booking->service_id)
            ->orderByRaw('id')
            ->pluck('id')
            ->toArray();

        $currBookingIndx = '';

        $currBooking = array_search($lesson_record_id, $completedBookingsIds);
        $currBookingIndx = $currBooking + 1;

        $arpData = array_filter(explode('^^', $input['arp_data']));
        $correctData = array_filter(explode('%%', $input['cor_incor_data']));
        $phrases = array_filter(explode('**', $input['keyword_not_under_arp_data']));
        $keywords = array_filter(explode('$$', $input['keyword_phrase_not_under_arp_data']));
        $topics = array_filter(explode('*$', $input['topic_tag_html']));

        if ($booking && $booking->toArray()) {
            if ($booking->is_wrapped == 1) {
                return response()->json(['type' => 'failure', 'message' => 'Lesson already has been wrapped!']);
            }
        } else {
            return response()->json(['type' => 'failure', 'message' => 'Lesson not available']);
        }
        
        //$select_other_lessons_results = '';
        $delete_from_temp_table = '';
        $wrap_lessons[0] = $lesson_record_id;
        $unique_var = '';
        $select_other_lessons_results = StudentLessonsBooking::where('user_id', $booking->user_id)
                                                                    ->where('teacher_id', $booking->teacher_id)
                                                                    ->where('service_id', $booking->service_id)
                                                                    ->where('lession_date', $booking->lession_date)
                                                                    ->where('status', 'booked')
                                                                    ->get();
        
        //if ($booking) {

        /*$select_other_lessons = 'select * from ' . $wpdb->prefix . 'lesson_record where student_id = ' . $get_prev_lessons_id_result['student_id'] . ' and teacher = "' . $get_prev_lessons_id_result['teacher'] . '" and service_id = ' . $get_prev_lessons_id_result['service_id'] . ' and taught_on = "' . $get_prev_lessons_id_result['taught_on'] . '" and status = "scheduled"';
        $select_other_lessons_results = $wpdb->get_results($select_other_lessons, ARRAY_A);*/
            
            
        //}
        /*$current_lesson_time = date('H:i:s', strtotime($get_prev_lessons_id_result['taught_at'] . ' + ' . $get_prev_lessons_id_result['duration'] . ' minutes'));
        $current_open_lesson_date = strtotime($get_prev_lessons_id_result['taught_on'] . ' ' . $get_prev_lessons_id_result['taught_at']);*/
        
        $current_lesson_time = date('H:i:s', strtotime($booking->lession_time . ' + ' . $booking->lesson_duration . ' minutes'));
        $current_open_lesson_date = strtotime($booking->lession_date . ' ' . $booking->lession_time);
        $i = 1;

        foreach ($select_other_lessons_results as $select_other_lessons_result) {
            $next_lesson_time = date('H:i:s', strtotime($select_other_lessons_result->lession_time));
            $cur_time = strtotime($current_lesson_time);
            $next_time = strtotime($next_lesson_time);
            $diff = ($next_time - $cur_time);
            $hours = date('H', $diff);
            $total_hours = $hours * 60;
            $minutes = date('i', $diff);
            $total_minutes = $total_hours + $minutes;
            $date_sum = strtotime($select_other_lessons_result->lession_date . ' ' . $select_other_lessons_result->lession_time);
            //$total_minutes < 30;

            if ($diff > 1800 && $date_sum > $current_open_lesson_date) {
                $delete_daat_of_next_lessons[$i] = $select_other_lessons_result->id;
            }
            //echo $date_sum.' < '.$current_open_lesson_date.' || ('.$diff .'<= 1800 && '.$date_sum.' > '.$current_open_lesson_date.')';
            if ($date_sum < $current_open_lesson_date || ($diff <= 1800 && $date_sum > $current_open_lesson_date)) {
                $wrap_lessons[$i] = $select_other_lessons_result->id;
                $current_lesson_time = date('H:i:s', strtotime($select_other_lessons_result->lession_time . ' + ' . $select_other_lessons_result['lesson_duration'] . ' 	minutes'));
                $i++;
            }
        }
    
        //echo '<pre>';
        
        $studentLesson = StudentLessons::where('id', $order_id)->first();
        $student_id = $studentLesson->user_id;
        $service_id = $studentLesson->service_id;
        $booking_id = $lesson_record_id;
        $student = User::find($student_id);
        $student_name = $student->firstname.' '.$student->lastname;
		
        $drive_id = $student->drive_folder_id;
        $drivefolders = [];
        if ($drive_id) {
            $drivefolders = AppHelper::getFolderData($drive_id);
        }
        $open_folder_id = $drive_id;

        $service = Services::find($service_id);
        
        $shareRecords = StudentShareRecord::where('user_id', $booking->user_id)
            ->where('share_type', 'onepage')
            ->pluck('email');
        
        $ratingTypes = RatingTypes::all();
        
        if ($studentLesson) {
            $studentLesson->last_booking_canvas_html = $input['canva_htm'];
            $studentLesson->last_booking_canvas_core = $input['canvas_html'];
            $studentLesson->show_comment_to_student = $input['show_comment_to_student'];
            $studentLesson->lesson_comment = $input['lesson_comment'];
            $studentLesson->save();
        }
        
        // get and save lesson rating points from current sessions to all other back to back sessions.
		if(!empty($input['point_to_improve'])){
			$currentsessionWeakPoints = StudentLessonsPoints::where('lesson_booking_id', $lesson_record_id)
						->where('level_id', $student->student_level_id)
						->whereIn('id', $input['point_to_improve'])
						->get();
			$weekpointsdata = [];
			$strongpointsdata = [];
			if (!empty($currentsessionWeakPoints)) {
				foreach ($wrap_lessons as $key=>$value) {
					if ($value != $lesson_record_id) {
						foreach ($currentsessionWeakPoints as $weekpoints) {
							$weekpointsdata[] = array('student_lesson_id'=>$order_id, 'level_id'=> $weekpoints->level_id, 'point_id'=>$weekpoints->point_id, 'status'=>$weekpoints->status, 'rating_point' =>$weekpoints->rating_point, 'lesson_booking_id'=> $value, 'user_id'=> $student_id, 'teacher_id'=> $user_id);
						}
					}
				}
				if (count($weekpointsdata) > 0) {
					DB::table('student_lessons_level_points')->insert($weekpointsdata); // Query Builder approach
				}
			}
		}
        //print_r($weekpointsdata);
        if(!empty($input['strong_points'])){
			$currentsessionStrongPoints = StudentLessonsPoints::where('lesson_booking_id', $lesson_record_id)
						->where('level_id', $student->student_level_id)
						->whereIn('id', $input['strong_points'])
						->get();
			if (!empty($currentsessionStrongPoints)) {
				foreach ($wrap_lessons as $key=>$value) {
					if ($value != $lesson_record_id) {
						foreach ($currentsessionStrongPoints as $strongpoints) {
							$strongpointsdata[] = array('student_lesson_id'=>$order_id, 'level_id'=> $strongpoints->level_id, 'point_id'=>$strongpoints->point_id, 'status'=>$strongpoints->status, 'rating_point' =>$strongpoints->rating_point, 'lesson_booking_id'=> $value, 'user_id'=> $student_id, 'teacher_id'=> $user_id);
						}
					}
				}
				if (count($strongpointsdata) > 0) {
					DB::table('student_lessons_level_points')->insert($strongpointsdata); // Query Builder approach
				}
			}
		}
        //print_r($strongpointsdata);
        
        
        //exit;
        foreach ($wrap_lessons as $key=>$new_lesson_record_id) {
            $booking = $get_prev_lessons_id_result = StudentLessonsBooking::where('id', $new_lesson_record_id)->with('student')->first();
            if ($studentLesson) {
                if (!empty($input['point_to_improve'])) {
                    $studentWeakPoints = StudentLessonsPoints::where('student_lesson_id', $order_id)
                        ->where('level_id', $student->student_level_id)
                        ->where('lesson_booking_id', $new_lesson_record_id)
                        ->whereIn('id', $input['point_to_improve'])
                        ->update(['status' => 2]);
                }

                if (!empty($input['strong_points'])) {
                    $studentStrongPoints = StudentLessonsPoints::where('student_lesson_id', $order_id)
                        ->where('level_id', $student->student_level_id)
                        ->where('lesson_booking_id', $new_lesson_record_id)
                        ->whereIn('id', $input['strong_points'])
                        ->update(['status' => 1]);
                }
                
                $booking->is_wrapped = 1;
                $booking->filter_point_type = $input['filter_point_type'];
                $booking->canvas_html = $input['canva_htm'];
                $booking->canvas_core = $input['canvas_html'];
                $booking->onepage_title = date('ymd', strtotime($booking->lession_date));
                $booking->completed_at = date('Y-m-d H:i:s');
                $booking->booking_comments = $input['lesson_comment'];
                $booking->points_to_improve_comment = $input['points_to_improve_comment_textarea'];
                $booking->strong_points_comment = $input['strong_points_comment_textarea'];
                $booking->is_student_present = $input['show_comment_to_student'];
                $booking->ca_rating = $input['ca_rating'];
                $booking->fp_rating = $input['fp_rating'];
                $booking->lc_rating = $input['lc_rating'];
                $booking->v_rating = $input['v_rating'];
                $booking->ga_rating = $input['ga_rating'];
                $booking->onepage_level_id = $input['onepage_level_id'];

                if (!empty($input['show_comment_to_student']) && $input['show_comment_to_student'] == 1) {
                    $booking->status = 'student_not_show';
                    //$booking->cancelled_at = date('Y-m-d H:i:s');
                } else {
                    $booking->status = 'completed';
                }
                $booking->save();
                $tasksData = [];
				
				$tasksData['user_id'] = $student_id;
				$tasksData['teacher_id'] = $user_id;

                foreach ($input['tasks'] as $tkey => $task) {
                    $tasksData[$task['name']] = $task['value'];
                }
				

                StudentLessonsTasks::updateOrCreate(
                    ['student_lesson_id' => $order_id],
                    $tasksData
                );

                $order = array("{", "}", ' -');
                $replace = '';
				
				/*$keywordsArray = [];
				if (!empty($keywords)) {
					foreach ($keywords as $akey => $keyword) {
						$keywordsArray[] = $keyword;
					}
				}
				
				$keyPhraseArray = [];
				if (!empty($phrases)) {
					foreach ($phrases as $akey => $keyword) {
						$keyPhraseArray[] = $keyword;
					}
				}*/
				
                if (!empty($arpData)) {
                    foreach ($arpData as $akey => $arp) {
                        $arpitem = explode('<br>', $arp);
						
                        $narp = new StudentLessonsARP;
                        $narp->student_lesson_id = $order_id;
                        $narp->lesson_booking_id = $new_lesson_record_id;
                        $narp->line_1 = str_replace($order, $replace, strip_tags($arpitem[0]));
                        $narp->line_2 = str_replace($order, $replace, strip_tags($arpitem[1]));
                        $narp->status = 1;
                        $narp->is_new = 1;
                        $narp->user_id = $student_id;
                        $narp->teacher_id = $user_id;
                        $narp->save();
                    }
                }
                 
                if (!empty($correctData)) {
                    foreach ($correctData as $akey => $cip) {
                        $cipitem = explode('<br>', $cip);
                        $ncip = new StudentLessonsCIP;
                        $ncip->student_lesson_id = $order_id;
                        $ncip->lesson_booking_id = $new_lesson_record_id;
                        $ncip->incorrect_phrase = str_replace($order, $replace, strip_tags($cipitem[0]));
                        $ncip->correct_phrase = str_replace($order, $replace, strip_tags($cipitem[1]));
                        $ncip->status = 1;
                        $ncip->user_id = $student_id;
                        $ncip->teacher_id = $user_id;
                        $ncip->save();
                    }
                }

                if (!empty($keywords)) {
                    foreach ($keywords as $akey => $keyword) {
                        $nkeyword = new StudentLessonsKeyword;
                        $nkeyword->student_lesson_id = $order_id;
                        $nkeyword->lesson_booking_id = $new_lesson_record_id;
                        $nkeyword->keyword = $keyword;
						$nkeyword->keyword_ja = $keyword;
                        //$nkeyword->keyword_ja = GoogleTranslate::trans($keyword, 'ja', 'en');
                        $nkeyword->status = 1;
                        $nkeyword->is_new = 1;
                        $nkeyword->user_id = $student_id;
                        $nkeyword->teacher_id = $user_id;
                        $nkeyword->type = 'keyword';
						/*if(isset($this->keywordArpId[$keyword])) {
							$nkeyword->arp_id = $this->keywordArpId[$keyword];
						}*/
                        $nkeyword->save();
                    }
                }
                if (!empty($phrases)) {
                    foreach ($phrases as $akey => $phrase) {
                        $nkeyword = new StudentLessonsKeyword;
                        $nkeyword->student_lesson_id = $order_id;
                        $nkeyword->lesson_booking_id = $new_lesson_record_id;
                        $nkeyword->keyword = $phrase;
                        $nkeyword->keyword_ja = $phrase;
						//$nkeyword->keyword_ja = GoogleTranslate::trans($phrase, 'ja', 'en');
                        $nkeyword->status = 1;
                        $nkeyword->is_new = 1;
                        $nkeyword->user_id = $student_id;
                        $nkeyword->teacher_id = $user_id;
                        $nkeyword->type = 'keyphrase';
						/*if(isset($this->keyPhraseArpId[$phrase])) {
							$nkeyword->arp_id = $this->keyPhraseArpId[$phrase];
						}*/
                        $nkeyword->save();
                    }
                }

                if (!empty($topics)) {
                    foreach ($topics as $tkey => $topic) {
                        $ntopic = new StudentLessonsTopic();
                        $ntopic->student_lesson_id = $order_id;
                        $ntopic->lesson_booking_id = $new_lesson_record_id;
                        $ntopic->title = $topic;
                        $ntopic->user_id = $student_id;
                        $ntopic->teacher_id = $user_id;
                        $ntopic->save();
                    }
                }
            }
            
            $previousBooking = [];
            if (!empty($booking['completed_at'])) {
                $previousBooking = StudentLessonsBooking::where('id', '!=', $new_lesson_record_id)
                    //->whereRaw("CONCAT(lession_date,' ',lession_time) < '".$booking['lession_date']." ".$booking['lession_time']."'")
                    ->whereRaw("completed_at < '" . $booking['completed_at'] . "'::date")
                    ->where('user_id', $studentLesson->user_id)
                    ->where('service_id', $studentLesson->service_id)
                    ->where('status', 'completed')
                    ->with('topics')
                    ->orderByRaw('completed_at DESC NULLS LAST')
                    ->first();
            }
			
			$payoutBatchId = '';
			$paid = 0;
			if (Auth::id() != env('RYAN_USER_ID') && $teacherDetails->is_ambassador == 1 && ($input['show_comment_to_student'] != 1)) {
                if ($teacher->paypal_email) {
                    //$student_name = '';
                    //$lesson_date_time = '';
                    
					/*$studentLesson = StudentLessonsBooking::select([
                            'student_lessons_bookings.*',
                            DB::raw("CONCAT(users.firstname, ' ', users.lastname) AS student_name"),
                        ])
                        ->where('student_lessons_bookings.id', $new_lesson_record_id)
                        ->leftJoin('users', 'users.id', 'student_lessons_bookings.user_id')
                        ->get()->first();

                    if (!empty($studentLesson)) {
                        $studentLesson = $studentLesson->toArray();
                        $student_name = $studentLesson['student_name'];
                        $lesson_date_time = $studentLesson['lession_date'].' '.$studentLesson['lession_time'];
                    }*/
					$teacher_earnings = $booking->teacher_earnings;
					if($user_id == 364) {
						$teacher_earnings = 1;
					}
                    $output = AppHelper::payout($teacher_earnings, $user_id, $student_name, $lesson_date_time);
					$payoutBatchId = $output->getBatchHeader()->getPayoutBatchId();
					//$output = 'Fail';
                    if ($output != 'Fail') {
						$paid = 1;
                        $teacherPayoutArray['teacher_id'] = Auth::id();
                        $teacherPayoutArray['amount'] = $booking->teacher_earnings;
                        $teacherPayoutArray['transaction_ref_id'] = $payoutBatchId;
                        $teacherPayoutArray['transaction_response'] = json_encode($output);
                        $teacherPayoutArray['payout_type'] = 'lesson';
                        $teacherPayoutArray['payout_ref_id'] = $new_lesson_record_id;
                        $teacherPayoutArray['status'] = 'success';

                        TeacherPayoutTransactions::create($teacherPayoutArray);
                    } else {
                        $teacherPayoutArray['teacher_id'] = Auth::id();
                        $teacherPayoutArray['amount'] = $booking->teacher_earnings;
                        $teacherPayoutArray['transaction_ref_id'] = '';
                        $teacherPayoutArray['transaction_response'] = json_encode($output);
                        $teacherPayoutArray['payout_type'] = 'lesson';
                        $teacherPayoutArray['payout_ref_id'] = $new_lesson_record_id;
                        ;
                        $teacherPayoutArray['status'] = 'fail';

                        TeacherPayoutTransactions::create($teacherPayoutArray);
                    }
                } else {
                    $teacherPayoutArray['teacher_id'] = Auth::id();
                    $teacherPayoutArray['amount'] = $booking->teacher_earnings;
                    $teacherPayoutArray['transaction_ref_id'] = '';
                    $teacherPayoutArray['transaction_response'] = '';
                    $teacherPayoutArray['payout_type'] = 'lesson';
                    $teacherPayoutArray['payout_ref_id'] = $new_lesson_record_id;
                    ;
                    $teacherPayoutArray['status'] = 'Pending';

                    TeacherPayoutTransactions::create($teacherPayoutArray);
                }
            }
            $booking = StudentLessonsBooking::find($new_lesson_record_id);	
			$booking->payment_id = $payoutBatchId;
			$booking->paid = $paid;
            $booking->save();

            $booking = StudentLessonsBooking::where('id', $new_lesson_record_id)->with('student')->first();

            $avgRatData = [];
            if (!empty($studentLesson) && $studentLesson->toArray()) {
                $totalRatingData = StudentLessonsPoints::select(
                    'rating_point',
                    DB::raw('COUNT(*) AS total_count')
                    )
                    ->where('student_lesson_id', $studentLesson->id)
                    ->where('level_id', $student->student_level_id)
                    ->groupBy(DB::raw('rating_point'))
                    ->get()->toArray();
                $ptoiData = StudentLessonsPoints::select(
                    'rating_point',
                    DB::raw('COUNT(*) AS imp_count')
                    )
                    ->where('student_lesson_id', $studentLesson->id)
                    ->where('status', 2)
                    ->where('level_id', $student->student_level_id)
                    ->groupBy(DB::raw('rating_point'))
                    ->get()->toArray();

                $finalArray = array();
                $totalPoints = array();
                foreach ($totalRatingData as $tk => $trd) {
                    foreach ($ptoiData as $pk => $pid) {
                        if ($trd['rating_point'] == $pid['rating_point']) {
                            $finalArray[$trd['rating_point']] = [
                                'total_count'  => $trd['total_count'],
                                'imp_count'    => $pid['imp_count'],
                            ];

                            $totalPoints[$trd['rating_point']] = $trd['total_count'];
                        }
                    }
                }

                $avgRatData = [];
                foreach ($finalArray as $fkey => $fpo) {
                    if ($fpo['imp_count']) {
                        if ($fpo['total_count'] == $fpo['imp_count']) {
                            $avgRatData[$fkey] = 5;
                        } else {
                            $avgRatData[$fkey] = number_format((5*$fpo['imp_count']/$fpo['total_count']), 2);
                            if ($avgRatData[$fkey] < 1) {
                                $avgRatData[$fkey] = 1;
                            }
                        }
                    } else {
                        $avgRatData[$fkey] = 1;
                    }

                    $avgRatData[$fkey] = !empty($avgRatData[$fkey]) ? $avgRatData[$fkey] : 1;
                }
            }

            if (!empty($ratingTypes) && $ratingTypes->toArray()) {
                foreach ($ratingTypes as $rating) {
                    TeacherRatings::updateOrCreate([
                        'student_id' => $student->id,
                        'teacher_id' => $teacher->id,
                        'rating_id' => $rating->id,
                        'lesson_booking_id' => $booking->id
                    ]);
                }
            }
        }
        //loop ends here

        // out of loop
        
        $studentLesson = StudentLessons::where('id', $order_id)
            ->with(
                'student_level',
                'tasks',
                'arps',
                'cips',
                'keywords',
                'topics',
                'last_topic'
            )->first();

        $studentLessonPoints = StudentLessonsPoints::where('student_lesson_id', $order_id)
            ->where('level_id', $student->student_level_id)
            ->with('point')
            ->get();

        $studentLessonPTI = StudentLessonsPoints::where('student_lesson_id', $order_id)
            ->where('status', 2)
            ->with('point')
            ->get();

        $studentLessonSP = StudentLessonsPoints::where('student_lesson_id', $order_id)
            ->where('level_id', $student->student_level_id)
            ->where('status', 1)
            ->with('point')
            ->get();

        $levels = OnePageLevels::where('status', 1)->with([
            'ca',
            'fp',
            'lc',
            'v',
            'ga',
        ])->orderBy('id', 'ASC')->get();
        
        $teacherLessons = StudentLessonsBooking::select([
                'student_lessons_bookings.*',
                DB::raw("CONCAT(users.firstname, ' ', users.lastname) AS student_name"),
                DB::raw("CONCAT(location.title, '.', location.title_jp) AS location"),
                'services.title AS service'
            ])
            ->where('teacher_id', $user_id)
            //->where('student_lessons_bookings.status', 'booked')
            ->whereDate('lession_date', '=', date('Y-m-d'))
            ->leftJoin('users', 'users.id', 'student_lessons_bookings.user_id')
            ->leftJoin('location', 'location.id', 'student_lessons_bookings.location_id')
            ->leftJoin('services', 'services.id', 'student_lessons_bookings.service_id')
            ->get();
        
        if (!empty($teacherLessons)) {
            $teacherLessons = $teacherLessons->toArray();
        }
        
        if ((env('APP_ENV') == 'production') && (!empty($shareRecords) && $shareRecords->toArray())) {
            $shareTemplate = "emails.onepage-share";
            $shareSubject = "Lesson successfully wrapped for " . $student['firstname'] . ' ' . $student['lastname'];
            $shdata = [
                'student' => $student,
                'teacher' => $teacher,
                'date' => $booking->lesson_date,
                'time' => $booking->lesson_time,
                'lesson' => $studentLesson,
                'booking' => $booking
            ];

            foreach ($shareRecords as $shareEmail) {
                Mail::send($shareTemplate, ['data' => $shdata], function ($m) use ($shareEmail, $shareSubject) {
                    $m->from(env('MAIL_FROM_ADDRESS'), env('MAIL_FROM_NAME'));
                    $m->to($shareEmail)->subject($shareSubject);
					$m->bcc(env('BCC_EMAIL'), env('BCC_EMAIL_NAME'));
                });
            }
        }
        
        if (env('APP_ENV') == 'production') {
            $template = "emails.lession-wrap";
            $subject = "OnePage wrapped on Accent Language Inc.";
            $sdata = [
                'user' => $student,
                'student' => $student,
                'teacher' => $teacher,
                'date' => $request->reserve_date,
                'time' => $request->time,
                'lesson' => $studentLesson,
                'site_url' => url('/'),
            ];
            dispatch(new SendEmailJob($template, $sdata, $subject, 'user'));
        }

        /* Send Push to Student */
        if (!empty($student->line_token)) {
            $messages = [];
            $messages['to'] = $student->line_token;

            $msg = "Your lesson successfully wrapped.\n";
            $msg .= "Lesson :" . $service->title . "\n";
            $msg .= "Teacher Name :" . $teacher->firstname . ' ' . $teacher->lastname . "\n";

            $messages['messages'][] = AppHelper::getFormatTextMessage($msg);

            $encodeJson = json_encode($messages);
            $message = AppHelper::sentMessage($encodeJson);
        }

        $arpData = StudentLessonsARP::select(
            'status',
            DB::raw('count(*) as total')
        )
            ->where('lesson_booking_id', $booking->id)
            ->groupBy('status')
            ->get()->toArray();

        $cipData = StudentLessonsCIP::select(
            'status',
            DB::raw('count(*) as total')
        )
            ->where('lesson_booking_id', $booking->id)
            ->groupBy('status')
            ->get()->toArray();

        $keypData = StudentLessonsKeyword::select(
            'status',
            DB::raw('count(*) as total')
        )
            ->where('lesson_booking_id', $booking->id)
            ->groupBy('status')
            ->get()->toArray();

        $statusData = [];

        foreach ($arpData as $arps) {
            if (!empty($statusData[$arps['status']])) {
                $statusData[$arps['status']] += $arps['total'];
            } else {
                $statusData[$arps['status']] = $arps['total'];
            }
        }
        foreach ($cipData as $cips) {
            if (!empty($statusData[$cips['status']])) {
                $statusData[$cips['status']] += $cips['total'];
            } else {
                $statusData[$cips['status']] = $cips['total'];
            }
        }
        foreach ($keypData as $ks) {
            if (!empty($statusData[$ks['status']])) {
                $statusData[$ks['status']] += $ks['total'];
            } else {
                $statusData[$ks['status']] = $ks['total'];
            }
        }

        /*$sessionHtml = view('teachers.dashboard.index.onepage.sessions', compact('teacher', 'teacherDetails', 'teacherLessons'))->render();

        $html = view('teachers.dashboard.index.onepage.detail', compact(
            'teacher',
            'teacherDetails',
            'studentLesson',
            'studentLessonPoints',
            'booking',
            'levels',
            'student_id',
            'service_id',
            'booking_id',
            'previousBooking',
            'avgRatData',
            'drivefolders',
            'drive_id',
            'open_folder_id',
            'totalPoints',
            'statusData',
            'studentLessonPTI',
            'studentLessonSP',
            'currBookingIndx',
            'isAlertRating'
        ))->render();*/
		
		$html = '';
		$sessionHtml = '';
		if($input['show_comment_to_student'] == 1) {
			$url = route('teachers.dashboard.index').'?ref=canvas';
			$message = 'Lesson wrapped with SnoShow.';
			$type = 'snoshow';
		} else {
			$url = route('students.share.onepage.index', ['id' => encrypt($booking->id)]);
			$message = 'Lesson wrapped successfully.';
			$type = 'success';
		}
        return response()->json([
            'type' => $type,
			'url' => $url,
            'html' => $html,
            'lessons' => $sessionHtml,
            'message' => $message
        ]);
    }

    public function updateStatus(Request $request)
    {
        $user_id = Auth::user()->id;
        $teacher = User::where('id', $user_id)->first();
        $teacherDetails = $teacher->details()->first();

        $input = $request->all();
		//echo '<pre>';print_r($input);exit;
        $view = '';
        $replace = '';
		$view2 = '';
        $replace2 = '';
		$html2 = '';
		
        if ($input['type'] == 'arps') {
			if($input['status'] == 5) {
				$StudentLessonsARP = StudentLessonsARP::whereIn('id', $input['ids'])->get();
				if(!empty($StudentLessonsARP)) {
					foreach($StudentLessonsARP as $student_arp) {
						$line_1 = $student_arp->line_1;
						$line_2 = $student_arp->line_2;
						
						$student_arp->line_1 = $line_2;
						$student_arp->line_2 = $line_1;
						$student_arp->status = 3;
						$student_arp->status_changed_booking_id = $input['booking_id'];
						$student_arp->save();
					}
				}
				
			} else {				
				StudentLessonsARP::whereIn('id', $input['ids'])->update([
					'status' => $input['status'],
					'status_changed_booking_id' => $input['booking_id']
				]);
			}
            $view = 'teachers.dashboard.index.onepage.detail.report.review.arp';
            $replace = 'lk-onepage-arp-container';
			
			//also change status of keyword/phrases
			if($input['status'] == 5) {
				$newstatus = 3;
			} else {
				$newstatus = $input['status'];
			}
			StudentLessonsKeyword::whereIn('arp_id', $input['ids'])->where('lesson_booking_id', $input['booking_id'])->update([
                'status' => $newstatus,
                'status_changed_booking_id' => $input['booking_id']
            ]);
            $view2 = 'teachers.dashboard.index.onepage.detail.report.review.keywords';
            $replace2 = 'lk-onepage-keywords-container';
			
        }
        if ($input['type'] == 'keywords') {
            StudentLessonsKeyword::whereIn('id', $input['ids'])->update([
                'status' => $input['status'],
                'status_changed_booking_id' => $input['booking_id']
            ]);
            $view = 'teachers.dashboard.index.onepage.detail.report.review.keywords';
            $replace = 'lk-onepage-keywords-container';
        }
        if ($input['type'] == 'cips') {
            StudentLessonsCIP::whereIn('id', $input['ids'])->update([
                'status' => $input['status'],
                'status_changed_booking_id' => $input['booking_id']
            ]);
            $view = 'teachers.dashboard.index.onepage.detail.report.review.cips';
            $replace = 'lk-onepage-cips-container';
        }

        $booking = StudentLessonsBooking::where('id', $input['booking_id'])->with('topics')->first();

        $studentLesson = StudentLessons::where('user_id', $booking->user_id)
            ->where('service_id', $input['service_id'])
            ->where('id', $booking->student_lessons_id)
            ->with(
                'student_level',
                'tasks',
                'arps',
                'cips',
                'keywords',
                'topics',
                'last_topic'
            )
            ->first();
        $student_id = $booking->user_id;
        $service_id = $input['service_id'];
        $booking_id = $input['booking_id'];
        $type = $input['type'];

        $html = view($view, compact(
            'teacher',
            'teacherDetails',
            'studentLesson',
            'booking',
            'student_id',
            'service_id',
            'booking_id',
            'type'
        ))->render();
		if($view2 != ''){
			$html2 = view($view2, compact(
				'teacher',
				'teacherDetails',
				'studentLesson',
				'booking',
				'student_id',
				'service_id',
				'booking_id',
				'type'
			))->render();
		}
        return response()->json([
            'type' => 'success',
            'message' => [
                'header' => 'Success',
                'msg' => 'Status changed successfully.',
            ],
            'replace' => $replace,
            'html' => $html,
            'replace2' => $replace2,
            'html2' => $html2,
        ]);
    }

    public function getFolderData(Request $request)
    {
        $drive_folder_id = $request->folder_id;
        $drivefolders = AppHelper::getFolderData($drive_folder_id);

        $drive_id = $request->main_drive_id;
        $open_folder_id = $drive_folder_id;

        $html = view(
            'teachers.dashboard.index.onepage.detail.report.drive',
            compact('drivefolders', 'drive_id', 'open_folder_id')
        )
            ->render();

        return response()->json([
            'type' => 'success',
            'html' => $html
        ]);
    }

    public function uploadFile(Request $request)
    {
        $folder_id = $request->folder_id;
        $files = $request->file('file');
        // dd($folder_id);
        foreach ($files as $file) {
            $mimeType = $file->getMimeType();
            $filename = $file->getClientOriginalName();
            $content = file_get_contents($file->getRealPath());
            $file_id = AppHelper::uploadfileToFolder($folder_id, $content, $mimeType, $filename);
        }


        return response()->json([
            'type' => 'success',
        ]);
    }
        
    public function getAllPdfs(Request $request)
    {
        $teacher_id = $request->teacher_id;
        $student_id = $request->student_id;
        $page_number = 0;
        if (isset($_POST["page"])) {
            $page_number = filter_var($_POST["page"], FILTER_SANITIZE_NUMBER_INT, FILTER_FLAG_STRIP_HIGH);
        }
        $item_per_page = isset($_REQUEST['limit']) ? $_REQUEST['limit'] : 12;
        //get current starting point of records
        $position = (($page_number - 1) * $item_per_page);
        $html = '';
        $previous_year_month = '';
		
        
        
        if ($student_id != '') {
            $allBookings = StudentLessonsBooking::where('status', 'completed')
                ->where(function($allBookings) use ($teacher_id)  {
				if(isset($teacher_id)) {
					$allBookings->where('teacher_id', $teacher_id);
				}
			 })
                ->where('user_id', $student_id)
                ->orderByRaw('completed_at DESC NULLS LAST')
                ->offset($position)
                ->limit($item_per_page)
                ->get();
            //echo '<pre>';print_r($allBookings);	exit;
            
            if (!empty($allBookings)) {
                $i =1;
                foreach ($allBookings as $select_pdf_result) {
                    $year = date('M, Y', strtotime($select_pdf_result->lession_date));
                    if ($previous_year_month == '') {
                        $previous_year_month = $year;
                    }
                    if ($previous_year_month != $year) {
                        $previous_year_month = $year;
                    }
                    if ($i == 1) {
                        $html .= '<div class="col-sm-3 col-md-3 col-lg-3 pdf-download">';
                    }
                                    
                    $pdf_link = route('students.onepage.generate.pdf').'?booking_id='.$select_pdf_result->id;//createPdfFileUrl($folder_name, $select_pdf_result['unique_key']);
                    
                    $html .=  '<p>'.$select_pdf_result->lession_date.' <a target="blank" class="glow" href="' . $pdf_link . '">'.__('labels.download').'</a>';
                    $html .=  '</p>';
                    
                    $i++;
                    if ($i == 4) {
                        $i = 1;
                        $html .=  '</div>';
                    }
                }
            }
        }
        echo $html;
        exit();
    }
	
	function checkKeywordInArp($arp1 = '', $arp2, $keywordsArray = array(), $arp_id = '') {
		if($arp1 != '' && $arp2 != '' && !empty($keywordsArray) && $arp_id!='') {
			foreach ($keywordsArray as $keyword) {
				//echo $arp1.'--'.$arp2.'--'.$keyword.'----';
				if(strstr($arp1, $keyword) || strstr($arp2, $keyword)) {					
					$this->keywordArpId[$keyword] = $arp_id;
					
				}
			}			
		}
	}
	
	function checkKeyPhraseInArp($arp1 = '', $arp2, $keyPhraseArray = array(), $arp_id = '') {
		if($arp1 != '' && $arp2 != '' && !empty($keyPhraseArray) && $arp_id!='') {
			foreach ($keyPhraseArray as $keyword) {
				//echo $arp1.'--'.$arp2.'--'.$keyword.'----';
				if(strstr($arp1, $keyword) || strstr($arp2, $keyword)) {					
					$this->keyPhraseArpId[$keyword] = $arp_id;
					
				}
			}			
		}
	}
}

