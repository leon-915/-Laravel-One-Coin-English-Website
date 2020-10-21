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

class OnepageController extends Controller
{
    public function index(Request $request) {
        $user_id = Auth::user()->id;
        $student = User::where('id', $user_id)->first();
        $studentDetails = $student->details()->first();


        $drive_id = $student->drive_folder_id;
        $drivefolders = [];
        if ($drive_id) {
            $drivefolders = AppHelper::getFolderData($drive_id);
        }
        $open_folder_id = $drive_id;


        $allBookingsIds = StudentLessonsBooking::where('status', 'completed')
            ->with('topics')
            ->where('user_id', $user_id)
            ->orderByRaw('lession_date DESC NULLS LAST')
            ->pluck('id')
            ->toArray();

        $booking_id = $request->get('booking_id', current($allBookingsIds));

        $nextIndx = 0;
        $prevIndx = 0;
        $isFirst = 0;
        $isLast = 0;
        $nextID = 0;
        $prevID = 0;
        $currIndx = array_search($booking_id, $allBookingsIds);

        if ($currIndx) {
            $nextIndx = $currIndx - 1;
            $nextID = $allBookingsIds[$nextIndx];
        }

        $prevIndx = $currIndx + 1;
        $prevID = array_key_exists($prevIndx, $allBookingsIds) ? $allBookingsIds[$prevIndx] : 0;

        if ($booking_id == current($allBookingsIds)) {
            $isFirst = 1;
            $isLast = 0;
        }

        if ($booking_id == end($allBookingsIds)) {
            $isFirst = 0;
            $isLast = 1;
            $nextIndx = $currIndx - 1;
            if ($nextIndx >= 0) {
                $nextID = $allBookingsIds[$nextIndx];
            }
            $prevID = 0;
        }

        $booking = StudentLessonsBooking::where('id', $booking_id)
            ->where('status', 'completed')
            ->with('topics')
			->with([
                    'arps' => function ($aq) use ($booking_id) {
                        $aq->where('lesson_booking_id', $booking_id);
                    }]
				)
            ->orderBy('lession_date', 'DESC')
            ->orderBy('lession_time', 'DESC')
            ->first();

        $currBookingIndx = '';


        $emails = StudentShareRecord::where(['user_id' => $user_id, 'share_type' => 'onepage'])->get();

        if (!empty($booking) && $booking->toArray()) {
            $completedBookingsIds = StudentLessonsBooking::where('user_id', $user_id)
                ->where('service_id', $booking->service_id)
                ->orderByRaw('id')
                ->pluck('id')
                ->toArray();

            $currBooking = array_search($booking_id, $completedBookingsIds);
            $currBookingIndx = $currBooking + 1;

            $studentLesson = StudentLessons::where('user_id', $user_id)
                ->where('service_id', $booking->service_id)
                ->where('id', $booking->student_lessons_id)
                ->with([
                    'student_level',
                    'tasks' =>function ($tq) use ($booking_id) {
						$tq->where('lesson_booking_id', $booking_id);
					},
                    /*'arps' => function ($aq) use ($booking_id) {
                        $aq->where('lesson_booking_id', $booking_id);
                    },*/
                    'cips' => function ($cq) use ($booking_id) {
                        $cq->where('lesson_booking_id', $booking_id);
                    },
                    'keywords' => function ($kq) use ($booking_id) {
                        $kq->where('lesson_booking_id', $booking_id);
                    },
                    'topics',
                    'last_topic'
                ])
                ->first();
            if (empty($studentLesson)) {
                //StudentLessons::create(['user_id' => $user_id, 'service_id' => $booking->service_id]);
                $studentLesson = StudentLessons::where('user_id', $user_id)
                    ->where('service_id', $booking->service_id)
                    ->with([
                        'student_level',
                        'tasks',
                        /*'arps' => function ($aq) use ($booking_id) {
                            $aq->where('lesson_booking_id', $booking_id);
                        },*/
                        'cips' => function ($cq) use ($booking_id) {
                            $cq->where('lesson_booking_id', $booking_id);
                        },
                        'keywords' => function ($kq) use ($booking_id) {
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
                        if($trd['rating_point'] == $pid['rating_point']){
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
                    if($fpo['imp_count']){
                        if($fpo['total_count'] == $fpo['imp_count']){
                            $avgRatData[$fkey] = 5;
                        } else {
                            $avgRatData[$fkey] = number_format((5*$fpo['imp_count']/$fpo['total_count']),2);
                            if($avgRatData[$fkey] < 1){
                                $avgRatData[$fkey] = 1;
                            }
                        }
                    } else {
                        $avgRatData[$fkey] = 1;
                    }

                    $avgRatData[$fkey] = !empty($avgRatData[$fkey]) ? $avgRatData[$fkey] : 1;
                }
            }

            $arpData = StudentLessonsARP::select(
                'status',
                DB::raw('count(*) as total'))
                ->where('lesson_booking_id', $booking->id)
                ->groupBy('status')
                ->get()->toArray();

            $cipData = StudentLessonsCIP::select(
                'status',
                DB::raw('count(*) as total'))
                ->where('lesson_booking_id', $booking->id)
                ->groupBy('status')
                ->get()->toArray();

            $keypData = StudentLessonsKeyword::select(
                'status',
                DB::raw('count(*) as total'))
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
            return view('students.onepage.index', compact(
                'student',
                'booking',
                'studentLesson',
                'studentLessonPoints',
                'allBookingsIds',
                'previousBooking',
                'nextBooking',
                'isFirst',
                'isLast',
                'nextID',
                'prevID',
                'avgRatData',
                'statusData',
                'emails',
                'statusData',
                'keywordChartData',
                'arpChartData',
                'keyChartData',
                'keyPhraseChartData',
                'drivefolders',
                'drive_id',
                'open_folder_id',
                'currBookingIndx',
				'levels',
            ));
        } else {
            return view('students.onepage.index', compact(
                'student',
                'booking',
                'emails',
                'currBookingIndx'
            ));
        }
    }

    public function generatePdf(Request $request) {
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
            $nextIndx = $currIndx - 1;
            $nextID = $allBookingsIds[$nextIndx];
        }

        $prevIndx = $currIndx + 1;
        $prevID = array_key_exists($prevIndx, $allBookingsIds) ? $allBookingsIds[$prevIndx] : 0;

        if ($booking_id == end($allBookingsIds)) {
            $nextIndx = $currIndx - 1;
            $nextID = $allBookingsIds[$nextIndx];
            $prevID = 0;
        }

        $booking = StudentLessonsBooking::where('id', $booking_id)
            ->where('status', 'completed')
            ->with('topics')
            ->orderBy('lession_date', 'DESC')
            ->orderBy('lession_time', 'DESC')
            ->first();

        $currBookingIndx = '';

        if (!empty($booking) && $booking->toArray()) {
            $completedBookingsIds = StudentLessonsBooking::where('user_id', $user_id)
                ->where('service_id', $booking->service_id)
                ->orderByRaw('id')
                ->pluck('id')
                ->toArray();

            $currBooking = array_search($booking_id, $completedBookingsIds);
            $currBookingIndx = $currBooking + 1;

            $studentLesson = StudentLessons::where('user_id', $booking->user_id)
                ->where('service_id', $booking->service_id)
                ->where('id', $booking->student_lessons_id)
                ->with([
                    'student_level',
                    'tasks' => function ($tq) use ($booking_id) {
                        $tq->where('lesson_booking_id', $booking_id);
                    },
                    'arps' => function ($aq) use ($booking_id) {
                        $aq->where('lesson_booking_id', $booking_id);
                    },
                    'cips' => function ($cq) use ($booking_id) {
                        $cq->where('lesson_booking_id', $booking_id);
                    },
                    'keywords' => function ($kq) use ($booking_id) {
                        $kq->where('lesson_booking_id', $booking_id);
                    },
                    'topics',
                    'last_topic'
                ])
                ->first();
				
			$studentLessonPoints = [];	
			if(!empty($studentLesson)) {

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

            $data = [
                'student' => $student,
                'booking' => $booking,
                'studentLesson' => $studentLesson,
                'studentLessonPoints' => $studentLessonPoints,
                'allBookingsIds' => $allBookingsIds,
                'previousBooking' => $previousBooking,
                'currBookingIndx' => $currBookingIndx
            ];
			
			$booking->canvas_html = preg_replace("/<\\/?b(\\s+.*?>|>)/", "", $booking->canvas_html);
			$pdf = PDF::loadView('pdf.onepage', $data);
            return $pdf->stream($booking['onepage_title'].'.pdf');
			
			/*header('Content-Type: application/pdf; charset=utf-8');
            $pdf = PDF::loadView('pdf.onepage', $data)->save(storage_path('onepage_pdfs/'.$booking['onepage_title'].'.pdf'));
			//$pdf->save('onepage_pdfs/'.$booking['onepage_title'].'.pdf');           
            //header('Content-disposition: inline; filename="' .  $no . '.pdf"', true);			
            return $pdf->download($booking['onepage_title'] . '-' . now() . '.pdf');*/

        } else {
            abort(404);
        }
    }

    public function getFolderData(Request $request) {
        $drive_folder_id = $request->folder_id;
        $drivefolders = AppHelper::getFolderData($drive_folder_id);

        $drive_id = $request->main_drive_id;
        $open_folder_id = $drive_folder_id;

        $html = view('students.onepage.index.onepage.details.drive',
            compact('drivefolders', 'drive_id', 'open_folder_id'))
            ->render();

        return response()->json([
            'type' => 'success',
            'html' => $html
        ]);
    }

    public function uploadFile(Request $request) {
        $folder_id = $request->folder_id;
        $files = $request->file('file');
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
}
