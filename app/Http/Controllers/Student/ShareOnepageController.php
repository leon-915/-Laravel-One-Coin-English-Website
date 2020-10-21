<?php

namespace App\Http\Controllers\Student;

use App\Helpers\AppHelper;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;
use App\User;
use App\Models\Packages;
use Illuminate\Support\Facades\DB;
use Stripe\Customer;
use Stripe\Stripe;
use Stripe\Charge;
use App\Models\StudentPackages;
use App\Models\StudentTransactions;
use App\Models\Services;
use App\Models\ServicePackages;
use App\Models\ServiceLocations;
use App\Models\TeacherServices;
use App\Models\StudentLessonsBooking;
use App\Models\StudentDetail;
use App\Models\StudentLessons;
use App\Models\TeacherRatings;
use Asana\Client;
use App\Jobs\SendEmailJob;
use App\Models\StudentLessonsARP;
use App\Models\StudentLessonsCIP;
use App\Models\StudentLessonsKeyword;
use Throwable;
use App\Models\StudentLessonsPoints;
use PDF;
use App\Models\StudentShareRecord;

use App\Models\OnePageLevels;
use App\Models\OnePageLevelsPoints;

class ShareOnepageController extends Controller
{
    public function index(Request $request, $id)
    {
        $booking_id = decrypt($id);

        $booking = StudentLessonsBooking::where('id', $booking_id)
                                                ->where('status', 'completed')
                                                ->with('topics')
                                                ->orderBy('lession_date', 'DESC')
                                                ->orderBy('lession_time', 'DESC')
                                                ->first();

        if (!$booking) {
            abort(404);
        }


        $user_id = $booking->user_id;
        $teacher_id = $booking->teacher_id;
        $service_id = $booking->service_id;

        $completedBookingsIds = StudentLessonsBooking::where('user_id', $booking->user_id)
            ->where('service_id', $booking->service_id)
            ->orderByRaw('id')
            ->pluck('id')
            ->toArray();

        $currBookingIndx = '';

        $currBooking = array_search($booking_id, $completedBookingsIds);
        $currBookingIndx = $currBooking + 1;


        $student = User::where('id', $user_id)->first();
        $studentDetails = $student->details()->first();

        $allBookingsIds = StudentLessonsBooking::where('status', 'completed')
                                                ->with('topics')
                                                ->where('user_id', $user_id)
                                                ->orderByRaw('lession_date DESC NULLS LAST')
                                                ->pluck('id')
                                                ->toArray();
        //echo '<pre>';print_r($allBookingsIds);
        
        //$booking_id = $request->get('booking_id', current($allBookingsIds));
        $booking_id = $request->get('booking_id', $booking_id);

        $nextIndx = 0;
        $prevIndx = 0;
        $isFirst = 0;
        $isLast = 0;
        $nextID = 0;
        $prevID = 0;
        $currIndx = array_search($booking_id, $allBookingsIds);

        if ($currIndx) {
            $nextIndx = $currIndx-1;
            $nextID = $allBookingsIds[$nextIndx];
        }

        $prevIndx = $currIndx+1;
        $prevID = array_key_exists($prevIndx, $allBookingsIds) ? $allBookingsIds[$prevIndx] : 0;

        if ($booking_id == current($allBookingsIds)) {
            $isFirst = 1;
            $isLast = 0;
        }

        if ($booking_id == end($allBookingsIds)) {
            $isFirst = 0;
            $isLast = 1;
            $nextIndx = $currIndx-1;
            if ($nextIndx >= 0) {
                $nextID = $allBookingsIds[$nextIndx];
            }
            $prevID = 0;
        }

        $booking = StudentLessonsBooking::where('id', $booking_id)
                                                ->where('status', 'completed')
                                                ->with('topics')
                                                ->orderBy('lession_date', 'DESC')
                                                ->orderBy('lession_time', 'DESC')
                                                ->first();

        $emails = StudentShareRecord::where(['user_id' => $user_id])->get();


        if (!empty($booking) && $booking->toArray()) {
            $studentLesson = StudentLessons::where('user_id', $user_id)
                                            ->where('service_id', $booking->service_id)
                                            ->with([
                                                'student_level',
                                                'tasks',
                                                'arps' => function ($aq) use ($booking_id) {
                                                    $aq->where('lesson_booking_id', $booking_id);
                                                },
                                                'cips'=> function ($cq) use ($booking_id) {
                                                    $cq->where('lesson_booking_id', $booking_id);
                                                },
                                                'keywords'=> function ($kq) use ($booking_id) {
                                                    $kq->where('lesson_booking_id', $booking_id);
                                                },
                                                'topics',
                                                'last_topic'
                                            ])
                                            ->first();
            if (empty($studentLesson)) {
                StudentLessons::create(['user_id' => $user_id,'service_id'=>$booking->service_id]);
                $studentLesson = StudentLessons::where('user_id', $user_id)
                                                ->where('service_id', $booking->service_id)
                                                ->with([
                                                    'student_level',
                                                    'tasks',
                                                    'arps' => function ($aq) use ($booking_id) {
                                                        $aq->where('lesson_booking_id', $booking_id);
                                                    },
                                                    'cips'=> function ($cq) use ($booking_id) {
                                                        $cq->where('lesson_booking_id', $booking_id);
                                                    },
                                                    'keywords'=> function ($kq) use ($booking_id) {
                                                        $kq->where('lesson_booking_id', $booking_id);
                                                    },
                                                    'topics',
                                                    'last_topic'
                                                ])
                                                ->first();
            }

            $studentLessonPoints = [];
            if (!empty($studentLesson) && $studentLesson->toArray()) {
                $studentLessonPoints = StudentLessonsPoints::where('student_lesson_id', $studentLesson->id)
                                                ->where('level_id', $student->student_level_id)
                                                ->with('point')
                                                ->get();
            }

            $previousBooking = [];
            if ($prevID) {
                $previousBooking = StudentLessonsBooking::where('id', $prevID)
                                                ->where('status', 'completed')
                                                ->with('topics')
                                                ->orderBy('lession_date', 'DESC')
                                                ->orderBy('lession_time', 'DESC')
                                                ->first();
            }

            $nextBooking = [];
            if ($nextID) {
                $nextBooking = StudentLessonsBooking::where('id', $nextID)
                                                ->where('status', 'completed')
                                                ->with('topics')
                                                ->orderBy('lession_date', 'DESC')
                                                ->orderBy('lession_time', 'DESC')
                                                ->first();
            }

            $avgRatData = [];
            if (!empty($studentLesson) && $studentLesson->toArray()) {
                $ratingData = StudentLessonsPoints::select(
                    'rating_point',
                    'level_id',
                    DB::raw('COUNT(*) AS strong_count')
                                                )
                                                ->where('student_lesson_id', $studentLesson->id)
                                                ->where('status', 1)
                                                ->groupBy(DB::raw('rating_point,level_id'))
                                                ->get();

                $ratingAvg = [];
                if (!empty($ratingData) && $ratingData->toArray()) {
                    foreach ($ratingData as $key => $p) {
                        $ratingAvg[$p->rating_point][$p->level_id] = $p->strong_count;
                    }
                }

                $avgRatData = [];
                foreach ($ratingAvg as $key => $rat) {
                    $rat = array_filter($rat);
                    $avgRatData[$key] = array_sum($rat)/count($rat);
                }
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

            $keywordCData = StudentLessonsKeyword::select('lesson_booking_id', DB::raw('count(*) as total'))
                                                        ->with('booking')
                                                        ->whereIn('lesson_booking_id', $allBookingsIds)
                                                        ->groupBy('lesson_booking_id')
														->orderBy('lesson_booking_id', 'ASC')
                                                        ->get();
            $arpCData = StudentLessonsARP::select('lesson_booking_id', DB::raw('count(*) as total'))
                                                        ->with('booking')
                                                        ->whereIn('lesson_booking_id', $allBookingsIds)
                                                        ->groupBy('lesson_booking_id')
														->orderBy('lesson_booking_id', 'ASC')
                                                        ->get();

            $keyCData = StudentLessonsKeyword::select('lesson_booking_id', DB::raw('count(*) as total'))
                                                        ->with('booking')
                                                        ->whereIn('lesson_booking_id', $allBookingsIds)
                                                        ->where('type', 'keyword')
                                                        ->groupBy('lesson_booking_id')
														->orderBy('lesson_booking_id', 'ASC')
                                                        ->get();
            $keyPhraseCData = StudentLessonsKeyword::select('lesson_booking_id', DB::raw('count(*) as total'))
                                                        ->with('booking')
                                                        ->whereIn('lesson_booking_id', $allBookingsIds)
                                                        ->where('type', 'keyphrase')
                                                        ->groupBy('lesson_booking_id')
														->orderBy('lesson_booking_id', 'ASC')
                                                        ->get();

            $keywordChartData = [];
            if (!empty($keywordCData) && $keywordCData->toArray()) {
                foreach ($keywordCData as $key => $kc) {
                    $keywordChartData['labels'][] = $kc->booking->onepage_title;
                    $keywordChartData['data'][] = $kc->total;
                }
            }
            $arpChartData = [];
            if (!empty($arpCData) && $arpCData->toArray()) {
                foreach ($arpCData as $key => $kc) {
                    $arpChartData['labels'][] = $kc->booking->onepage_title;
                    $arpChartData['data'][] = $kc->total;
                }
            }
            $keyChartData = [];
            if (!empty($keyCData) && $keyCData->toArray()) {
                foreach ($keyCData as $key => $kc) {
                    $keyChartData['labels'][] = $kc->booking->onepage_title;
                    $keyChartData['data'][] = $kc->total;
                }
            }
            $keyPhraseChartData = [];
            if (!empty($keyPhraseCData) && $keyPhraseCData->toArray()) {
                foreach ($keyPhraseCData as $key => $kc) {
                    $keyPhraseChartData['labels'][] = $kc->booking->onepage_title;
                    $keyPhraseChartData['data'][] = $kc->total;
                }
            }
            $levels = OnePageLevels::where('status', 1)->with([
                        'ca',
                        'fp',
                        'lc',
                        'v',
                        'ga',
                    ])->orderBy('id', 'ASC')->get();
            
            return view('students.share-onepage.index', compact(
                'student',
                'booking',
                'studentLesson',
                'studentLessonPoints',
                'allBookingsIds',
                'previousBooking',
                'isFirst',
                'isLast',
                'nextID',
                'prevID',
                'avgRatData',
                'statusData',
                'emails',
                'levels',
                'statusData',
                'keywordChartData',
                'arpChartData',
                'keyChartData',
                'keyPhraseChartData',
                'currBookingIndx'
            ));
        } else {
            return view('students.onepage.index', compact(
                'student',
                'booking',
                'emails',
                'currBookingIndx'
            ));
        }

        // $previousBooking = StudentLessonsBooking::where('id', '!=' ,$input['booking_id'])
        //                                         ->whereRaw("CONCAT(lession_date,' ',lession_time) < '".$booking['lession_date']." ".$booking['lession_time']."'")
        //                                         ->where('status','completed')
        //                                         ->with('topics')
        //                                         ->orderBy('lession_date','DESC')
        //                                         ->orderBy('lession_time','DESC')
        //                                         ->first();
    }

    public function generatePdf(Request $request)
    {
        $user_id = Auth::user()->id;
        $student = User::where('id', $user_id)->first();
        $studentDetails = $student->details()->first();

        $allBookingsIds = StudentLessonsBooking::where('status', 'completed')
                                                ->with('topics')
                                                ->orderBy('lession_date', 'DESC')
                                                ->orderBy('lession_time', 'DESC')->pluck('id')->toArray();

        $booking_id = $request->get('booking_id', current($allBookingsIds));

        $nextIndx = 0;
        $prevIndx = 0;

        $nextID = 0;
        $prevID = 0;
        $currIndx = array_search($booking_id, $allBookingsIds);


        if ($currIndx) {
            $nextIndx = $currIndx-1;
            $nextID = $allBookingsIds[$nextIndx];
        }

        $prevIndx = $currIndx+1;
        $prevID = array_key_exists($prevIndx, $allBookingsIds) ? $allBookingsIds[$prevIndx] : 0;

        if ($booking_id == end($allBookingsIds)) {
            $nextIndx = $currIndx-1;
            $nextID = $allBookingsIds[$nextIndx];
            $prevID = 0;
        }

        $booking = StudentLessonsBooking::where('id', $booking_id)
                                                ->where('status', 'completed')
                                                ->with('topics')
                                                ->orderBy('lession_date', 'DESC')
                                                ->orderBy('lession_time', 'DESC')
                                                ->first();
        if (!empty($booking) && $booking->toArray()) {
            $studentLesson = StudentLessons::where('user_id', $user_id)
                                            ->where('service_id', $booking->service_id)
                                            ->with([
                                                'student_level',
                                                'tasks',
                                                'arps' => function ($aq) use ($booking_id) {
                                                    $aq->where('lesson_booking_id', $booking_id);
                                                },
                                                'cips'=> function ($cq) use ($booking_id) {
                                                    $cq->where('lesson_booking_id', $booking_id);
                                                },
                                                'keywords'=> function ($kq) use ($booking_id) {
                                                    $kq->where('lesson_booking_id', $booking_id);
                                                },
                                                'topics',
                                                'last_topic'
                                            ])
                                            ->first();

            $studentLessonPoints = StudentLessonsPoints::where('student_lesson_id', $studentLesson->id)
                                            ->where('level_id', $student->student_level_id)
                                            ->with('point')
                                            ->get();

            if ($prevID) {
                $previousBooking = StudentLessonsBooking::where('id', $prevID)
                                                ->where('status', 'completed')
                                                ->with('topics')
                                                ->orderBy('lession_date', 'DESC')
                                                ->orderBy('lession_time', 'DESC')
                                                ->first();
            }

            $data = [
                'student'               => $student,
                'booking'               => $booking,
                'studentLesson'         => $studentLesson,
                'studentLessonPoints'   => $studentLessonPoints,
                'allBookingsIds'        => $allBookingsIds,
                'previousBooking'       => $previousBooking
            ];

            $pdf = PDF::loadView('pdf.onepage', $data);

            header('Content-Type: application/pdf; charset=utf-8');
            //header('Content-disposition: inline; filename="' .  $no . '.pdf"', true);

            return $pdf->download($booking['onepage_title'].'-'.now().'.pdf');
        } else {
            abort(404);
        }
    }

    public function dbTable($table, $column)
    {
        //$sql = "ALTER TABLE ".$table." DROP COLUMN ".$column;
        //DB::statement($sql);
    }
}
