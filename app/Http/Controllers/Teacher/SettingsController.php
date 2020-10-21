<?php

namespace App\Http\Controllers\Teacher;

use App\Libraries\Ical\iCalEasyReader;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Country;
use App\User;
use App\Http\Requests\Teacher\Register\RegisterRequest;
use App\Http\Requests\Teacher\Settings\FacebookPostRequest;
use App\Models\TeacherSchedule;
use App\Models\TeacherDetail;
use App\Models\Locations;
use App\Jobs\SendEmailJob;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Models\TeacherAttachment;
use File;
use App\Models\TeacherLocations;
use App\Models\StudentLessonsBooking;
use App\Models\StudentLessons;
use App\Models\ServicePackages;
use App\Models\Services;
use App\Models\StudentShareRecord;
use App\Models\StudentDetail;
use Illuminate\Support\Facades\DB;
use App\Models\TeacherScheduleException;
use App\Models\TeacherFacebookPost;
use Yajra\DataTables\DataTables;
use Facebook\Exceptions\FacebookSDKException;
use Facebook\Facebook;
use Kigkonsult\Icalcreator\Vcalendar;
use App\Models\TeacherIcal;
use DateTimeZone;
use DateTime;

class SettingsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $ref = $request->get('ref', 'schedule');

        $user_id = Auth::user()->id;
        $teacher = User::where('id', $user_id)->first();
        $teacherDetails = $teacher->details()->first();

        return view('teachers.settings.index', compact('teacher', 'teacherDetails', 'ref'));
    }

    public function getSchedule(Request $request)
    {
        $user_id = Auth::user()->id;

        $teacher = User::where('id', $user_id)->first();
        $teacherSch = TeacherSchedule::where('user_id', $user_id)->orderBy('id', 'ASC')->get();
        $teacherExc = TeacherScheduleException::where('user_id', $user_id)->orderBy('id', 'ASC')->get();

        $teacherDetails = $teacher->details()->first();
        $locations = Locations::where('status', 1)->pluck('title', 'id')->toArray();
        $teacherLocations = TeacherLocations::where('user_id', $user_id)->where('is_deleted', 0)->pluck('location_id')->toArray();

        $html = view('teachers.settings.index.schedule', compact('teacher', 'teacherSch', 'teacherDetails', 'locations', 'teacherLocations', 'teacherExc'))->render();

        return response()->json(['type' => 'success', 'html' => $html]);
    }

    public function updateSchedule(Request $request)
    {
        $input = $request->all();

        //$exceptions = $this->generateSchedule($input['exception']);

        $user_id = Auth::user()->id;
        $teacher = User::where('id', $user_id)->first();

        $teacherDetails = $teacher->details()->first();
        $teacherDetails->lesson_minute_able_to_teach = !empty($input['lesson_minute_able_to_teach']) ? implode(',', $input['lesson_minute_able_to_teach']) : "";
        $teacherDetails->book_before_time = $input['book_before_time'];
        $teacherDetails->cancel_before_time = $input['cancel_before_time'];
        $teacherDetails->save();

        TeacherScheduleException::where('user_id', $user_id)->delete();
        if (!empty($input['exception'])) {
            foreach ($input['exception'] as $key => $exc) {
                if ($exc['from'] && $exc['to']) {
                    $times = !empty($exc['times']) ? $exc['times'] : [];

                    $userExc = new TeacherScheduleException();
                    $userExc->user_id = $user_id;
                    $userExc->from_time = $exc['from'];
                    $userExc->to_time = $exc['to'];
                    $userExc->from_date = $exc['from_date'];
                    $userExc->to_date = $exc['to_date'];
                    $userExc->monday = in_array('mon', $times) ? 1 : 0;
                    $userExc->tuesday = in_array('tue', $times) ? 1 : 0;
                    $userExc->wednesday = in_array('wed', $times) ? 1 : 0;
                    $userExc->thursday = in_array('thu', $times) ? 1 : 0;
                    $userExc->friday = in_array('fri', $times) ? 1 : 0;
                    $userExc->saturday = in_array('sat', $times) ? 1 : 0;
                    $userExc->sunday = in_array('sun', $times) ? 1 : 0;
                    $userExc->save();
                }
            }
        }

        if (!empty($input['schedule'])) {
            $updateSchIDs = array_keys($input['schedule']);

            foreach ($input['schedule'] as $sid => $days) {
                $userSchedule = TeacherSchedule::find($sid);
                $userSchedule->monday = (!empty($days['monday']) && $days['monday'] == 1) ? 1 : 0;
                $userSchedule->tuesday = (!empty($days['tuesday']) && $days['tuesday'] == 1) ? 1 : 0;
                $userSchedule->wednesday = (!empty($days['wednesday']) && $days['wednesday'] == 1) ? 1 : 0;
                $userSchedule->thursday = (!empty($days['thursday']) && $days['thursday'] == 1) ? 1 : 0;
                $userSchedule->friday = (!empty($days['friday']) && $days['friday'] == 1) ? 1 : 0;
                $userSchedule->saturday = (!empty($days['saturday']) && $days['saturday'] == 1) ? 1 : 0;
                $userSchedule->sunday = (!empty($days['sunday']) && $days['sunday'] == 1) ? 1 : 0;
                $userSchedule->save();
            }

            TeacherSchedule::where('user_id', $user_id)
                ->whereNotIn('id', $updateSchIDs)
                ->update([
                    'monday' => 0,
                    'tuesday' => 0,
                    'wednesday' => 0,
                    'thursday' => 0,
                    'friday' => 0,
                    'saturday' => 0,
                    'sunday' => 0,
                ]);
        }

        if (!empty($input['teacher_locations'])) {
            $oldLocations = TeacherLocations::where('user_id', $user_id)->pluck('location_id');
            $oldLoc = TeacherLocations::where('user_id', $user_id)->get();

            if ($oldLocations) {
                $oldLocations = $oldLocations->toArray();
            }

            $deleteArray = array_diff($oldLocations, $input['teacher_locations']);
            $insertArray = array_diff($input['teacher_locations'], $oldLocations);

            TeacherLocations::where('user_id', $user_id)->whereIn('location_id', $deleteArray)->update(['is_deleted' => 1]);
            TeacherLocations::where('user_id', $user_id)->whereNotIn('location_id', $deleteArray)->update(['is_deleted' => 0]);

            foreach ($insertArray as $Lkey => $location_id) {
                TeacherLocations::create([
                    'user_id' => $user_id,
                    'location_id' => $location_id,
                    'is_deleted' => 0
                ]);
            }
        } else {
            $oldLocations = TeacherLocations::where('user_id', $user_id)->pluck('location_id');
            if (!empty($oldLocations)) {
                if ($oldLocations) {
                    $oldLocations = $oldLocations->toArray();
                    TeacherLocations::where('user_id', $user_id)
                        ->whereIn('location_id', $oldLocations)
                        ->update(['is_deleted' => 1]);
                }
            }
        }

        $teacher = User::where('id', $user_id)->first();
        $teacherSch = TeacherSchedule::where('user_id', $user_id)->orderBy('id', 'ASC')->get();
        $teacherDetails = $teacher->details()->first();
        $locations = Locations::where('status', 1)->pluck('title', 'id')->toArray();
        $teacherLocations = TeacherLocations::where('user_id', $user_id)->where('is_deleted', 0)->pluck('location_id')->toArray();
        $teacherExc = TeacherScheduleException::where('user_id', $user_id)->orderBy('id', 'ASC')->get();

        $html = view('teachers.settings.index.schedule', compact('teacher', 'teacherSch', 'teacherDetails', 'locations', 'teacherLocations', 'teacherExc'))->render();

        return response()->json(['type' => 'success', 'message' => 'Schedule updated successfully.', 'html' => $html]);
    }

    public function getLessons(Request $request)
    {
        $user_id = Auth::user()->id;
        $teacher = User::where('id', $user_id)->first();
        $teacherDetails = $teacher->details()->first();

        $earnings = StudentLessonsBooking::select(
            DB::raw("SUM(teacher_earnings) AS earnings"),
            DB::raw("COUNT(teacher_earnings) AS thought")
        )
            ->where('teacher_id', $user_id)
            ->where('status', 'completed')
            ->first();

        $html = view('teachers.settings.index.lesson-record', compact('teacher', 'teacherDetails', 'earnings'))->render();

        return response()->json(['type' => 'success', 'html' => $html]);
    }

    public function getLessonsList(Request $request)
    {
        $user_id = Auth::user()->id;
        $teacherLessons = StudentLessonsBooking::select([
            'student_lessons_bookings.*',
            DB::raw("CONCAT(users.firstname, ' ', users.lastname) AS student_name"),
            DB::raw("location.title AS location"),
            'services.title AS service',
            DB::raw("teacher_earnings AS earnings"),
        ])
            ->where('teacher_id', $user_id)					
            ->whereRaw("to_char(student_lessons_bookings.lession_date, 'YYYY-MM-DD') >= '" . date('Y-m-d', strtotime('-90 days')) . "'")
            ->whereNotIn('student_lessons_bookings.status', ['deleted'])
            ->leftJoin('users', 'users.id', 'student_lessons_bookings.user_id')
            ->leftJoin('location', 'location.id', 'student_lessons_bookings.location_id')
            ->leftJoin('services', 'services.id', 'student_lessons_bookings.service_id')
			->orderBy('student_lessons_bookings.lession_date', 'DESC');

        return DataTables::of($teacherLessons)
            ->addIndexColumn()
            ->filter(function ($query) use ($request) {
                if (!empty($request->get('from')) && !empty($request->get('to'))) {
                    $from = date('Y-m-d', strtotime($request->get('from')));
                    $to = date('Y-m-d', strtotime($request->get('to')));
                    $query->whereRaw("date(lession_date) between '" . $from . "' and'" . $to . "'");
                } else if (!empty($request->get('from'))) {
                    $from = date('Y-m-d', strtotime($request->get('from')));
                    $query->where('lession_date', '>=', $from)->get();
                } else if (!empty($request->get('to'))) {
                    $to = date('Y-m-d', strtotime($request->get('to')));
                    $query->where('lession_date', '<=', $to)->get();
                }
            })
            ->editColumn('status', function ($users) {
                $booking = $users->toArray();
                if ($booking['status'] == 'booked') {
                    return '<span class="badge badge-success badge-pill">Scheduled</span>';
                } elseif ($booking['status'] == 'completed') {
                    return '<span class="badge badge-primary badge-pill">Completed</span>';
                } elseif ($booking['status'] == 'csd') {
                    return '<span class="badge badge-primary badge-pill">CSD</span>';
                } elseif ($booking['status'] == 'teacher_not_show') {
                    return '<span class="badge badge-primary badge-pill">Tnoshow</span>';
                } elseif ($booking['status'] == 'student_not_show') {
                    return '<span class="badge badge-primary badge-pill">Snoshow</span>';
                } elseif ($booking['status'] == 'cancel') {
                    $temp = 'Cancelled';
                    if ((!empty($booking['lession_date'])) && (!empty($booking['cancelled_at']))) {
                        $lesson_at = date('Y-m-d', strtotime($booking['lession_date']));
                        $cancel_at = date('Y-m-d', strtotime($booking['cancelled_at']));

                        if ($lesson_at == $cancel_at) {
                            $temp = 'CSD';
                        }
                    }
                    if (($booking['is_student_present'] == 1)) {
                        $temp = 'Snoshow';
                    }else if (($booking['is_teacher_present'] == 1)) {
                        $temp = 'Tnoshow';
                    }

                    return '<span class="badge badge-danger badge-pill">' . $temp . '</span>';
                } elseif ($booking['status'] == 'expired') {
                    return '<span class="badge badge-secondary badge-pill">Expired</span>';
                }
            })
            ->editColumn('service', function ($users) {
                if($users->status == "completed"){
                    return '<b><a target="_blank" href="'.route('students.share.onepage.index', ['id' => encrypt($users->id)]).'"> '.$users->service.'</a></b>';
                } else {
                    return $users->service;
                }
            })


            ->editColumn('action', function ($users) {
                /*$booking = $users->toArray();
                if(($booking['status'] !='completed') && ($booking['status'] !='cancel')){

                    return '<a href="' . url('teacher/edit-lesson/' . $booking['id']) . '"><i class="fas fa-edit" aria-hidden="true"></i></a>';
                }else{*/
                    return '<a href="#">-</a>';
                //}
            })

            ->rawColumns(['service','status','action'])
            ->make(true);
    }

    public function getCalender(Request $request)
    {
        $user_id = Auth::user()->id;
        $teacher = User::where('id', $user_id)->first();
        $teacherDetails = $teacher->details()->first();

        $teacherLessons = StudentLessonsBooking::select([
            'student_lessons_bookings.*',
            DB::raw("CONCAT(users.firstname, ' ', users.lastname) AS student_name"),
            DB::raw("location.title AS location"),
            'services.title AS service',
            DB::raw("'0' AS earnings"),
        ])
            ->where('teacher_id', $user_id)
			->whereNotIn('student_lessons_bookings.status',['csd', 'cancel', 'deleted'])
			->whereRaw("lession_date >= '2019-06-01'::date")
            ->leftJoin('users', 'users.id', 'student_lessons_bookings.user_id')
            ->leftJoin('location', 'location.id', 'student_lessons_bookings.location_id')
            ->leftJoin('services', 'services.id', 'student_lessons_bookings.service_id')->get();


        $teacherLData = [];
        foreach ($teacherLessons as $tkey => $lesson) {
            $startDate = null;
            $endDate = null;
            $startDate = $lesson['lession_date'] . 'T' . $lesson['lession_time'];
            $endDate = date("Y-m-d" . '\T' . "H:i:s", strtotime("+" . $lesson['lesson_duration'] . " minutes", strtotime($startDate)));

            $teacherLData[] = [
                'title' => $lesson['location'] . '-' . $lesson['service'] . '-' . $lesson['student_name'],
                'start' => $startDate,
                'end' => $endDate,
                'backgroundColor' => !empty($teacherDetails->calendar_color) ? $teacherDetails->calendar_color : 'rgba(0, 45, 88, 1)',
                'data' => ''
            ];
        }
		$icaldata = $this->getIcalData();
		$teacherLData = array_merge($teacherLData, $icaldata);
		//$teacherLData[] = $icaldata;
		
		//echo '<pre>';print_r($teacherLData);exit;
        $html = view('teachers.settings.index.calender', compact('teacher', 'teacherDetails', 'teacherLData'))->render();

        return response()->json(['type' => 'success', 'html' => $html]);
    }

    public function getIcalData() {
		$teacher_id = Auth::user()->id;
        $getIcalData = TeacherIcal::where('teacher_id', $teacher_id)->get();

        $finalArray = [];
        $icalArray = [];

        foreach ($getIcalData as $key => $ical) {
            $url = $ical->ical_link;
            $rurl = str_ireplace('webcal://', 'http://', $url);

            $teacherDetail = TeacherDetail::where('user_id', $ical->teacher_id)->first();
            $getData = @file_get_contents($rurl);
            if($getData){
                $ical = new iCalEasyReader();
                $lines = $ical->load($getData);
                $events = $lines['VEVENT'];

                if (count($events) > 0) {
                    $i = 0;

                    foreach ($events as $event) {
                        if(!empty($event['DTSTART']['value'])){
                            $startDate = $event['DTSTART']['value'];
                        } else {
                            $startDate = $event['DTSTART'];
                        }
                        if(!empty($event['DTEND']['value'])){
                            $endDate = $event['DTEND']['value'];
                        } else {
                            $endDate = $event['DTEND'];
                        }

                        $startDate = date('Y-m-d\TH:i:s', strtotime($startDate));
                        $endDate = date('Y-m-d\TH:i:s', strtotime($endDate));

                        $newArray[$i]['title'] = 'BLOCKED';
                        $newArray[$i]['start'] = $startDate;
                        $newArray[$i]['end'] = $endDate;
                        $newArray[$i]['data'] = '';
                        $newArray[$i]['url'] = '';
                        $newArray[$i]['backgroundColor'] = !empty($teacherDetail->calendar_color) ? $teacherDetail->calendar_color : 'rgba(0, 45, 88, 1)';
                        $i++;
                    }
                    $icalArray = array_merge($icalArray, $newArray);

                }
            }
        }

        return $icalArray;
    }

    public function getFacebookPost(Request $request) {
        $user_id = Auth::user()->id;


        $posts = TeacherFacebookPost::where('user_id', $user_id)->get();

        $html = view('teachers.settings.index.facebook-post', compact('posts'))->render();

        return response()->json(['type' => 'success', 'html' => $html]);
    }

    public function getFacebookPostList(Request $request) {
        $user_id = Auth::user()->id;

        $posts = TeacherFacebookPost::select([
            'teacher_facebook_post.*',
            DB::raw("CONCAT(users.firstname, ' ', users.lastname) AS user"),

        ])
            ->where('user_id', $user_id)
            ->leftJoin('users', 'users.id', 'teacher_facebook_post.user_id')
            ->orderBy('teacher_facebook_post.id', 'ASC');

        return DataTables::of($posts)
            ->addIndexColumn()
            ->addColumn('action', function ($posts)
            {
                $editButton = '';
                if ($posts->status != 4) {
                    $editButton .= '<a data-url="' . route('teacher.facebook.post.edit', $posts->id) . '" class="editPost" title="Edit"
                    data-toggle="tooltip" title="Edit" data-original-title="Edit"><i class="fas fa-edit"></i></a>';

                    $editButton .= '<a data-url="' . route('teacher.facebook.post.delete', $posts->id) . '" id="' . $posts->id . '" class="deletePost" data-toggle="tooltip" title="Delete" data-original-title="Delete"><i class="fas fa-trash-alt"></i></a>';
                }
                return $editButton;
            })
            ->filter(function ($query) use ($request) {
                if (!empty($request->get('filter_id'))) {
                    $query->where("teacher_facebook_post.status", $request->get('filter_id'));
                }
            })
            ->editColumn('image', function ($posts) {
                if ($posts->image) {
                    return '<image src="' . asset($posts->image) . '" height="50" width="50">';
                    //return url('uploads/profile/'.$users->profile_image);
                } /*else {
                    return '<image src="' . asset('uploads/profile/default.png') . '" height="50" width="50">';
                    //return url("uploads/profile/default.png");
                }*/
            })
            ->editColumn('status', function ($posts) {
                if ($posts->status == '1') {
                    return '<span class="badge badge badge-gradient-warning badge-pill">Pending</span>';
                } else if ($posts->status == '2') {
                    return '<span class="badge badge-gradient-success badge-pill">Approved</span>';
                } else if ($posts->status == '3') {
                    return '<span class="badge badge-gradient-danger badge-pill">Not Approved</span>';
                } else if ($posts->status == '4') {
                    return '<span class="badge badge-gradient-primary badge-pill">Archived</span>';
                }
            })
            ->rawColumns(['action', 'image', 'status'])
            //->rawColumns(['status', 'action','profile_image','step1_verified'])
            ->make(true);
    }

    public function storeFacebookPost(FacebookPostRequest $request) {
        $input = $request->all();

        if (isset($input['post_id']) && !empty($input['post_id'])) {    //For update record
            $post_id = $input['post_id'];
            $fb = TeacherFacebookPost::find($post_id);
        } else {   //For create record
            $fb = new TeacherFacebookPost;
            $fb->status = 1;
        }
        $user_id = Auth::user()->id;
        $fb->user_id = $user_id;
        $fb->subject = !empty($input['subject']) ? $input['subject'] : '';
        $fb->message = !empty($input['message']) ? $input['message'] : '';

        if ($request->has('image')) {
            $file = $request->file('image');

            $file_name = time() . $file->getClientOriginalName();

            $input['image'] = $file_name;
            $file_path = 'uploads';
            $move = $file->move($file_path, $file_name);

            if (file_exists(public_path($fb->image))) {
                File::delete(public_path($fb->image));
            }

            if ($move) {
                $fb->image = $file_path . '/' . $file_name;
            }

        }

        $fb->save();


        return response()->json([
            'type' => 'success'
        ]);
        //return back();
    }

    public function editFacebookPost(Request $request, $id)
    {
        $fb = TeacherFacebookPost::find($id);
        $url = route('teachers.settings.get.facebook.post');
        $image = !empty($fb->image) ? asset($fb->image) : '';

        return response()->json([
            'type' => 'success',
            'id' => $fb->id,
            'subject' => $fb->subject,
            'message' => $fb->message
        ]);
    }

    public function deleteFacebookPost(Request $request, $id)
    {
        $post = TeacherFacebookPost::findOrFail($id);
        $post->status = 4;
        $result = $post->save();
        if ($result) {
            $request->session()->flash('message', 'Archived Successfully.');
            return response()->json([
                'type' => 'success'
            ]);
        } else {
            $request->session()->flash('error', 'Something Went Wrong.');
            return response()->json([
                'type' => 'error'
            ]);
        }
    }

    public function editLesson(Request $request, $id)
    {
        $booking = StudentLessonsBooking::find($id);
        $teacherDetail = TeacherDetail::where('user_id', $booking->teacher_id)->first();
        $permission = $teacherDetail->permission;
        $permissions = '';
        if(!empty($permission)){
            $permissions = explode(',', $permission);
        }

        $is_teacher_present = 0;
        $is_student_present = 0;
        $is_free_lesson = 0;
        $status = '';
        $three = 0;

        if($booking->is_teacher_present == 1){
            $is_teacher_present = 1;
            $three = 1;
        }

        if($booking->is_student_present == 1){
            $is_student_present = 1;
            $three = 1;
        }

        if($booking->is_free_lesson == 1){
            $is_free_lesson = 1;
            $three = 1;
        }

        if($three == 0){
            $threeStatus = ['booked', 'completed', 'cancel'];

            if(in_array($booking->status, $threeStatus)){
                $status = $booking->status;
            }
        }

        return view('teachers.settings.index.orders.edit', compact('is_teacher_present','is_student_present',
        'is_free_lesson','status','booking','permissions'));
    }

    public function updateLesson(Request $request, $id)
    {
        $input = $request->all();

        $booking = StudentLessonsBooking::find($id);
        $student = User::find($booking['user_id']);
        $teacher = User::find($booking['teacher_id']);
        $lesson = StudentLessons::where('user_id', $booking['user_id'])
                                        ->where('service_id', $booking['service_id'])
                                        ->where('status', 1)
                                        ->first();
        $studentService = Services::find($booking['service_id']);
        $location = Locations::find($booking['location_id']);


        $bdata= [];

        $threeStatus = ['booked', 'completed', 'cancel'];

        if(in_array($input['status'], $threeStatus)){
            $bdata['status'] = $input['status'];
        }


        if((($input['status'] == 'teacher_not_show')) || ($input['status'] == 'cancel')){

            $bdata['status'] = 'cancel';
            $bdata['cancelled_at'] = date('Y-m-d H:i:s');
            if($input['status'] == 'teacher_not_show'){
                $bdata['is_teacher_present'] = 1;
            } else {
                $bdata['is_teacher_present'] = 0;
            }


            $studentDetail = StudentDetail::where('user_id', $booking['user_id'])->first();

            $service = ServicePackages::where('service_id', $booking['service_id'])
                                        ->where('is_deleted', 0)
                                        ->first();

            $serviceDetail = Services::find($booking['service_id']);

            if($booking['lession_type'] == 'trial'){
                $lesson->available_bookings = 1;
                $lesson->save();

               // $message = "Trail Lesson Canceled.";
            } else if(!empty($service)) {
                if($lesson['available_bookings'] != 0){

                    $lesson->available_bookings = $lesson['available_bookings'] + 1;
                    $lesson->save();

                }
                $studentDetail->credit_balance = $studentDetail['credit_balance'] + $booking['total_earnings'];
                if(!empty($serviceDetail->receive_credit_on_booking)){
                    $studentDetail->reward_balance = $studentDetail['reward_balance'] - $serviceDetail->receive_credit_on_booking;
                }
                //$message = "Lesson Canceled.";
            } else if(empty($service)) {
                $lesson->available_bookings = $lesson['available_bookings'] + 1;
                $lesson->save();

                //$message = "Lesson Canceled.";
            }

            $studentDetail->save();

            if(!empty($student['email'])){

                $template = "admin.emails.student-cancel-lesson";
                $subject = "Lesson Cancelled";

                $data = ['user' => $student,
                            'student' => $student,
                            'booking' => $booking,
                            'teacher' => $teacher,
                            'date' => $booking['lession_date'],
                            'time' => $booking['lession_time'],
                            'lesson' => $studentService->title,
                            'location' => $location->title
                        ];

                dispatch(new SendEmailJob($template, $data, $subject,'cancel_mail'));

               /* $sdata = [
                    'user' => $student,
                    'student' => $student,
                    'teacher' => $teacher,
                    'date' => $booking['lession_date'],
                    'time' => $booking['lession_time'],
                    'lesson' => $studentService->title
                ];
                dispatch(new SendEmailJob($template, $sdata, $subject, 'user'));*/
            }

            if(!empty($teacher['email'])){
               /*
                $data = ['user' => $teacher, 'teacher' => $teacher,
                        'student' => $student, 'booking' => $booking];
                dispatch(new SendEmailJob($template, $data, $subject,'cancel_mail'));*/
                $template = "admin.emails.teacher-cancel-lesson";
                $subject = "Lesson Cancelled";
                $data = [
                    'user' => $teacher,
                    'student' => $student,
                    'teacher' => $teacher,
                    'date' => $booking['lession_date'],
                    'time' => $booking['lession_time'],
                    'lesson' => $studentService->title,
                    'location' => $location->title
                ];
                dispatch(new SendEmailJob($template, $data, $subject, 'user'));

            }

            //Send mail(to share record emails)

            $shareRecords = StudentShareRecord::where('user_id', $booking['user_id'])
                                                ->where('share_type', 'lessons')
                                                ->pluck('email');

            if(!empty($shareRecords) && $shareRecords->toArray()){
                $shareTemplate = "emails.lession-cancel";
                $shareSubject = "Lesson cancelled for ".$student->firstname .' '. $student->lastname;
                $shdata = [
                    'student' => $student,
                    'teacher' => $teacher,
                    'date' => $booking['lession_date'],
                    'time' => $booking['time'],
                    'lesson' =>  $studentService->title,
                    'location' =>  $location->title,
                    //'booking' => $booking
                ];

                foreach ($shareRecords as $shareEmail) {
                    Mail::send($shareTemplate, ['data' => $shdata], function ($m) use ($shareEmail, $shareSubject) {
                        $m->from(env('MAIL_FROM_ADDRESS'), env('MAIL_FROM_NAME'));
                        $m->to($shareEmail)->subject($shareSubject);
						$m->bcc(env('BCC_EMAIL'), env('BCC_EMAIL_NAME'));
                    });
                }
            }

            /* Send Push to Student */
            if(!empty($student->line_token)){
                $messages = [];
                $messages['to'] = $student->line_token;
                $msg = "Your booking is cancelled.\n";
                $msg .= "Lesson : ". $studentService->title ."\n";
                $msg .= "Location : ". $location->title ."\n";
                $msg .= "Teacher Name : ". $teacher['firstname'] .' '.$teacher['lastname'] ."\n";
                $msg .= "Booking Date : " . $booking['lession_date'] .' '.$booking['time']."\n";
                $messages['messages'][] = AppHelper::getFormatTextMessage($msg);
                $encodeJson = json_encode($messages);
                AppHelper::sentMessage($encodeJson);
            }

            /* Send Push to Teaacher */
            if(!empty($teacher->line_token)){
                $tmessages = [];
                $tmessages['to'] = $teacher->line_token;
                $tmsg = "Your booking is cancelled.\n";
                $tmsg .= "Lesson :". $studentService->title ."\n";
                $tmsg .= "Location : ". $location->title ."\n";
                $tmsg .= "Student Name :". $student['firstname'] .' '.$student['firstname'] ."\n";
                $tmsg .= "Booking Date : " . $booking['lession_date'] .' '.$booking['time']."\n";
                $tmessages['messages'][] = AppHelper::getFormatTextMessage($tmsg);
                $tencodeJson = json_encode($tmessages);
                AppHelper::sentMessage($tencodeJson);
            }

        }

        if($input['status'] == 'student_not_show'){
            $bdata['status'] = 'cancel';
            $bdata['is_student_present'] = 1;

             if(!empty($student['email'])){

                $template = "emails.student-not-show";
                $subject = "Lesson Cancelled";

                $data = ['user' => $student,
                            'student' => $student,
                            'booking' => $booking,
                            'teacher' => $teacher,
                            'date' => $booking['lession_date'],
                            'time' => $booking['lession_time'],
                            'lesson' => $studentService->title,
                            'location' => $location->title
                        ];

                dispatch(new SendEmailJob($template, $data, $subject,'cancel_mail'));
            }
        }

        if($input['status'] == 'free_lesson'){
            $bdata['status'] = 'completed';
            $bdata['is_free_lesson'] = 1;
            if($lesson['available_bookings'] != 0){
                $lesson->available_bookings = $lesson['available_bookings'] + 1;
                $lesson->save();
            }

        }


        $booking->update($bdata);

        return redirect('teacher/settings?ref=lessons-recordes');
    }

    public function testIcal()
    {
        $user_id = Auth::user()->id;
        $teacher = User::where('id', $user_id)->first();
        $teacherDetails = $teacher->details()->first();

        $teacherLessons = StudentLessonsBooking::select([
            'student_lessons_bookings.*',
            DB::raw("CONCAT(users.firstname, ' ', users.lastname) AS student_name"),
            DB::raw("CONCAT(location.title, '.', location.title_jp) AS location"),
            'services.title AS service',
            DB::raw("'0' AS earnings"),
        ])
            ->where('teacher_id', $user_id)
            ->leftJoin('users', 'users.id', 'student_lessons_bookings.user_id')
            ->leftJoin('location', 'location.id', 'student_lessons_bookings.location_id')
            ->leftJoin('services', 'services.id', 'student_lessons_bookings.service_id')->get();

        $vcalendar = Vcalendar::factory();
        if (!empty($teacherLessons)) {
            foreach ($teacherLessons as $lesson) {
                $startDate = str_replace('-', '', $lesson['lession_date']);
                $startTime = str_replace(':', '', $lesson['lession_time']);
                $startDate = $startDate . 'T' . $startTime;

                $endDate = date("Ymd" . '\T' . "His", strtotime("+" . $lesson['lesson_duration'] . " minutes", strtotime($startDate)));


                $vcalendar->newVevent()
                    ->setTransp(Vcalendar::OPAQUE)
                    ->setClass(Vcalendar::P_BLIC)
                    ->setSequence(1)
                    ->setDescription(
                        $lesson['location'] . '-' . $lesson['service'] . '-' . $lesson['student_name']
                    )
                    ->setLocation($lesson->location)
                    ->setDtstart(
                        new DateTime(
                            $startDate,
                            new DateTimezone('Asia/Tokyo')
                        )
                    )
                    ->setDtend(
                        new DateTime(
                            $endDate,
                            new DateTimezone('Asia/Tokyo')
                        )
                    );
            }
        }

        $vcalendarString =
            // apply appropriate Vtimezone with Standard/DayLight components
            $vcalendar->vtimezonePopulate()
                // and create the (string) calendar
                ->createCalendar();

        header('Content-type: text/calendar; charset=utf-8');
        header('Content-Disposition: attachment; filename=event.ics');
        echo $vcalendarString;

    }


    public function testdata()
    {
        $url = 'http://p56-caldav.icloud.com/published/2/MTA0NTM3MTkyNzkxMDQ1M3Co1y15Mdgowbm9PBbmVZiiGw3cZHj0ZWbsNj-ZEWes';
        $test = file_get_contents($url);
        $ical = new iCalEasyReader();
        $lines = $ical->load($test);
        dd($lines);
    }
}
