<?php

namespace App\Http\Controllers\Teacher;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Country;
//use Illuminate\Foundation\Auth\User;
use App\User;
use App\Http\Requests\Teacher\Register\RegisterRequest;
use App\Http\Requests\Teacher\Profile\StoreRequest;
use App\Http\Requests\Teacher\Profile\SaveInfoRequest;
use App\Models\TeacherSchedule;
use App\Models\TeacherLocations;
use App\Models\TeacherDetail;
use App\Jobs\SendEmailJob;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Models\TeacherAttachment;
use App\Models\RatingTypes;
use App\Models\TeacherRatings;
use App\Models\StudentTeacherFavorite;
use App\Models\Settings;
use App\Models\StudentDetail;
use App\Models\StudentLessonsBooking;
//use Illuminate\Http\File;
use File;
use DB;

class PublictProfileController extends Controller
{

    public function index($id) {

        $countries = Country::pluck('name', 'name');

        $degrees = [
            'ba' => 'BA',
            'bs' => 'BS',
            'ma' => 'MA',
            'phd' => 'PhD',
            'mba' => 'MBA',
            'others' => 'Others',
        ];

        $certificates = [
            'n/a' => 'N/A',
            'celta' => 'CELTA',
            'tesol' => 'TESOL',
            'tefl' => 'TEFL',
        ];

        $abilities = [
            'beginner' => 'Beginner',
            'intermediate' => 'Intermediate',
            'advanced' => 'Advanced',
            'jplt_score' => 'JPLT Score',
        ];

        $courses_teach = [
            'Daily Conversation'=>"Daily Conversation",
            'Business English'=>"Business English",
            'TOEIC'=>"TOEIC",
           ' IELTS'=>" IELTS",
            'Kids Lessons'=>"Kids Lessons",
            'Job Interview'=>"Job Interview",
            'Medical English'=>"Medical English",
            'Olympic English'=>"Olympic English",
            'Eloquent English'=>"Eloquent English",
            'Travel English'=>"Travel English",
            'English for Fashion Industry'=>"English for Fashion Industry",
            'Showbiz and Entertainment English'=>"Showbiz and Entertainment English",
            'Hotel and Restaurant English'=>"Hotel and Restaurant English",
            'Jobs and Occupation English'=>"Jobs and Occupation English",
            'Computer English'=>"Computer English",
            'Health and Fitness English'=>"Health and Fitness English",
            'Academic English'=>"Academic English",
            'English Literature'=>"English Literature",
            'Creative Writing'=>"Creative Writing",
            'English for Mass Communication (Media)'=>"English for Mass Communication (Media)",
            'English for Agriculture'=>"English for Agriculture",
        ];

        $visa_type = [
            'DIPLOMATIC VISA - Diplomat'    => 'DIPLOMATIC VISA - Diplomat',
            'OFFICIAL VISA - Official'  => 'OFFICIAL VISA - Official',
            'WORKING VISA - Artist' => 'WORKING VISA - Artist',
            'WORKING VISA - Journalist' => 'WORKING VISA - Journalist',
            'WORKING VISA - Religious Activities'   => 'WORKING VISA - Religious Activities',
            'WORKING VISA - Investor/Business Manager'  => 'WORKING VISA - Investor/Business Manager',
            'WORKING VISA - Legal/Accounting Services'  => 'WORKING VISA - Legal/Accounting Services',
            'WORKING VISA - Medical Services'   => 'WORKING VISA - Medical Services',
            'WORKING VISA - Researcher' => 'WORKING VISA - Researcher',
            'WORKING VISA - Instructor' => 'WORKING VISA - Instructor',
            'WORKING VISA - Engineer'   => 'WORKING VISA - Engineer',
            'WORKING VISA - Specialist in Humanities/International Services'    => 'WORKING VISA - Specialist in Humanities/International Services',
            'WORKING VISA - Intracompany Transferee'    => 'WORKING VISA - Intracompany Transferee',
            'WORKING VISA - Entertainer'    => 'WORKING VISA - Entertainer',
            'WORKING VISA - Skilled Labor'  => 'WORKING VISA - Skilled Labor',
            'GENERAL VISA - Cultural Activities'    => 'GENERAL VISA - Cultural Activities',
            'GENERAL VISA - College Student'    => 'GENERAL VISA - College Student',
            'GENERAL VISA - Precollege Student' => 'GENERAL VISA - Precollege Student',
            'GENERAL VISA - Trainee'    => 'GENERAL VISA - Trainee',
            'GENERAL VISA - Dependent'  => 'GENERAL VISA - Dependent',
            'SPECIFIED VISA - Designated Activities (Working Holiday Visa included)'    => 'SPECIFIED VISA - Designated Activities (Working Holiday Visa included)',
            'SPECIFIED VISA - Spouse or Child of Japanese National' => 'SPECIFIED VISA - Spouse or Child of Japanese National',
            'SPECIFIED VISA - Spouse or Child of Permanent Resident'    => 'SPECIFIED VISA - Spouse or Child of Permanent Resident',
            'SPECIFIED VISA - Long-term Resident'   => ' SPECIFIED VISA - Long-term Resident',
            'NO VISA GIVEN - Permanent Resident'    => 'NO VISA GIVEN - Permanent Resident',
        ];

       // $teacher = Auth::user();

        //$user_id = Auth::user()->id;
        //select('*', DB::raw('YEAR(CURDATE()) - YEAR(dob) AS age'))
        $teacher = User::where('id', $id)
                        ->where('user_type','teacher')
                        ->where('status',1)
                        ->first();
        if(!$teacher){
            abort('404');
        }

        $teacherDetails     = $teacher->details()->first();
        $teacherSchedule    = TeacherSchedule::where('user_id', $id)->orderBy('id','ASC')->get();
        $teacherLocations   = TeacherLocations::where('user_id',$id)->where('is_deleted',0)->with('location')->get();
        $tratingsData       = TeacherRatings::select(
                                        DB::raw('avg(ratings)'),
                                        DB::raw('count(rating_id) AS total'),
                                        'rating_id'
                                    )
                                    ->with('rating')
                                    ->groupBy('rating_id')
                                    ->where('teacher_id', $id)
                                    ->where('status', 1)
                                    ->get();

        $tratings = [];
        foreach ($tratingsData as $key => $value) {
            $tratings[$value['rating']['id']] = $value->toArray();
        }
//echo '<pre>';print_r($tratings);exit;
        $tratingTypes = RatingTypes::where('status',1)->get()->toArray();

        $student_id = 0;
        $teacherRatings = [];
        $favorite = [];
        $lessons = [];
        $ratingTypes = [];
        $booking = [];
        if (Auth::user() && Auth::user()->user_type == 'student') {
            $student_id = Auth::user()->id;
            /*$teacherRatings = TeacherRatings::where([ 'student_id' => $student_id,
                                            'teacher_id' =>  $id])->pluck('ratings','rating_id');*/
            $favorite = StudentTeacherFavorite::where([ 'student_id' => $student_id,
                                            'teacher_id' =>  $id])->first();

            $booking = StudentLessonsBooking::select('id','is_rated')->where('status', 'completed')
                                            //->with('topics')
                                            ->where('user_id', Auth::user()->id)
                                            ->where('teacher_id', $id)
                                            ->where('is_rated', 'no')
                                            ->orderByRaw('completed_at DESC NULLS LAST')
                                            ->first();
//echo '<pre>';print_r($booking);exit;
            if($booking) {
                $ratingTypes = TeacherRatings::where('lesson_booking_id',$booking->id)
                                                ->with('rating')
                                                ->get();

            }
        }

        $totalRatings = TeacherRatings::select(DB::raw('avg(ratings)'))
                                    ->where('teacher_id', $id)
                                    ->where('status', 1)
                                    ->value('avg');

        $countStudentsRated = 0;

        $countStudentsRated =TeacherRatings::distinct('lesson_booking_id')
        //$countStudentsRated =TeacherRatings::
		->where('teacher_id', $id)
                             ->where('status', 1)
                             ->count('lesson_booking_id');

        return view('teachers.public-profile.index', compact('teacher','teacherDetails','courses_teach', 'visa_type','degrees','countries','certificates','abilities','teacherSchedule', 'teacherLocations','ratingTypes', 'teacherRatings', 'favorite','lessons','booking','tratings','tratingTypes','totalRatings','countStudentsRated'));

    }

    public function storeRating(Request $request) {
        $student_id = Auth::user()->id;
        $input = $request->all();

        $teacher_id = !empty($input['teacher_id']) ? $input['teacher_id'] : '';
        $booking_id = !empty($input['booking_id']) ? $input['booking_id'] : '';
        $comments = !empty($input['comments']) ? $input['comments'] : '';

        /*TeacherRatings::create(['student_id'    => $student_id,
                                'teacher_id'    => $teacher_id,
                                'lesson_booking_id' => $booking_id,
                                'comments'      => $comments]);*/

        $booking = StudentLessonsBooking::where('id', $booking_id)->first();
        $booking->is_rated = 'yes';
        $booking->save();

        if(!empty($input['rating'])){
            $rewardPoints = Settings::getSettings('teacher_credits_rate');
            if(!empty($rewardPoints)){
                $student = StudentDetail::where('user_id',$student_id)->first();
                $student->reward_balance = $student->reward_balance + $rewardPoints;
                $student->save();
            }
        }

        /*$allBookingsIds = StudentLessonsBooking::where('status', 'completed')
                            ->with('topics')
                            ->where('user_id', $student_id)
                            ->orderByRaw('completed_at DESC NULLS LAST')
                            ->first();*/

        foreach($input['rating'] as $rating_id => $star) {
             TeacherRatings::updateOrCreate([
                                    'student_id'    => $student_id,
                                    'teacher_id'    => $teacher_id,
                                    'rating_id'     => $rating_id,
                                    'lesson_booking_id' => $booking_id,
                                ] , [
                                    'status' => 1,
                                    'ratings' => $star,
                                    'comments' => $comments,
									
                                ]);
        }

        /*$favorite = (isset($input['is_favorite']) && !empty($input['is_favorite'])) ? 1 : 0;
        StudentTeacherFavorite::updateOrCreate([
                            'student_id' => $student_id,
                            'teacher_id' =>  $teacher_id,
                        ] , [
                            'is_favorite' => $favorite
                        ]);*/

        return response()->json(['type' => 'success', 'message' => 'Detail Updated Successfully.']);
    }
	
	public function favorite(Request $request) {
        $student_id = Auth::user()->id;
        $input = $request->all();

        $teacher_id = !empty($input['teacher_id']) ? $input['teacher_id'] : '';
		StudentTeacherFavorite::updateOrCreate([
                            'student_id' => $student_id,
                            'teacher_id' =>  $teacher_id,
                        ] , [
                            'is_favorite' => 1
                        ]);

        return response()->json(['type' => 'success', 'message' => 'You have made teacher favorite.']);
    }
	
	
	public function unfavorite(Request $request) {
        $student_id = Auth::user()->id;
        $input = $request->all();
        $teacher_id = !empty($input['teacher_id']) ? $input['teacher_id'] : '';
		StudentTeacherFavorite::updateOrCreate([
                            'student_id' => $student_id,
                            'teacher_id' =>  $teacher_id,
                        ] , [
                            'is_favorite' => 0
                        ]);

        return response()->json(['type' => 'success', 'message' => 'You have made teacher unfavorite.']);
    }
}
