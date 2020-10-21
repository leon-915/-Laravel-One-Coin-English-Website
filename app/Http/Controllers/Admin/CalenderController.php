<?php
namespace App\Http\Controllers\Admin;

use App\Libraries\Ical\iCalEasyReader;
use App\Models\StudentLessonsBooking;
use App\Http\Controllers\Controller;

use App\Models\TeacherDetail;
use App\Models\TeacherIcal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\User;
use Auth;
use App\Models\Locations;

class CalenderController extends Controller
{
    public function index() {
        $teachers = User::select(
            'users.id AS id',
            DB::raw("CONCAT(users.firstname, ' ', users.lastname) AS teacher")
        )->where('user_type', 'teacher')
            ->where('status', 1)
            ->pluck('teacher', 'id');

        $locations = Locations::select(
            'id AS id',
            'title AS location'
        )
            ->pluck('location', 'id');

        return view('admin.admin-calender.calender', compact('teachers', 'locations'));
    }

    public function getCalender(Request $request) {

        $teacherLessonsSql = StudentLessonsBooking::select([
            'student_lessons_bookings.*',
            DB::raw("CONCAT(users.firstname, ' ', users.lastname) AS student_name"),
            DB::raw("location.title AS location"),
            'services.title AS service',
            DB::raw("'0' AS earnings"),
        ])->with('teacherDetail')
            ->leftJoin('users', 'users.id', 'student_lessons_bookings.user_id')
            ->leftJoin('location', 'location.id', 'student_lessons_bookings.location_id')
            ->leftJoin('services', 'services.id', 'student_lessons_bookings.service_id')
            ->whereRaw("CONCAT(lession_date,' ',lession_time) >= '" . $request['start'] . "'")
            ->whereRaw("CONCAT(lession_date,' ',lession_time) <= '" . $request['end'] . "'")
			->whereNotIn('student_lessons_bookings.status',['csd', 'cancel', 'deleted']);
        if ($request->has('teacher_id')) {
            $teacherLessonsSql->where('student_lessons_bookings.teacher_id', $request->get('teacher_id'));
        }
        if ($request->has('location_id')) {
            $teacherLessonsSql->where('student_lessons_bookings.location_id', $request->get('location_id'));
        }

        $teacherLessons = $teacherLessonsSql->get();
        $teacherLData = [];
        foreach ($teacherLessons as $tkey => $lesson) {
            $startDate = null;
            $endDate = null;
            $startDate = $lesson['lession_date'] . 'T' . $lesson['lession_time'];
            $endDate = date("Y-m-d" . '\T' . "H:i:s", strtotime("+" . $lesson['lesson_duration'] . " minutes", strtotime($startDate)));
			if (Auth::guard('admin')->user()->role == 'sub_admin') {
				$editurl = '';
			} else {
				$editurl = route('admin.bookings.edit', $lesson['id']) . '?ref=calender';
			}
			
            $teacherLData[] = [
                'title' => $lesson['location'] . '-' . $lesson['service'] . '-' . $lesson['student_name'],
                'start' => $startDate,
                'end' => $endDate,
                'data' => $lesson,
                'url' => $editurl,
                'backgroundColor' => !empty($lesson['teacherDetail']['calendar_color']) ? $lesson['teacherDetail']['calendar_color'] : 'rgba(0, 45, 88, 1)'
            ];
        }
        return response()->json($teacherLData);
    }

    public function getIcalData() {
        $getIcalData = TeacherIcal::all();

        $finalArray = [];
        $icalArray = [];

        foreach ($getIcalData as $key => $ical2) {
            $url = $ical2->ical_link;
            $rurl = str_ireplace('webcal://', 'http://', $url);

            $teacherDetail = TeacherDetail::where('user_id', $ical2->teacher_id)->first();
            $getData = @file_get_contents($rurl);
            if($getData){
                $ical = new iCalEasyReader();
                $lines = $ical->load($getData);
                $events = $lines['VEVENT'];

                if (count($events) > 0) {
                    $i = 0;
					$newArray = [];

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

                        /*$newArray[$i]['title'] = 'BLOCKED';
                        $newArray[$i]['start'] = $startDate;
                        $newArray[$i]['end'] = $endDate;
                        $newArray[$i]['data'] = '';
                        $newArray[$i]['url'] = '';
                        $newArray[$i]['backgroundColor'] = !empty($teacherDetail->calendar_color) ? $teacherDetail->calendar_color : 'rgba(0, 45, 88, 1)';*/
						$newArray[] = array('title' => 'BLOCKED', 'teacher' => $ical2->teacher_id, 'start' => $startDate, 'end' => $endDate, 'data' => '', 'url' => '', 'backgroundColor' => !empty($teacherDetail->calendar_color) ? $teacherDetail->calendar_color : 'rgba(0, 45, 88, 1)');
                        $i++;
                    }
                    $icalArray = array_merge($icalArray, $newArray);

                }
            }
        }
		//echo '<pre>';print_r($icalArray);echo '</pre>';exit;
        return response()->json($icalArray);
    }
}
