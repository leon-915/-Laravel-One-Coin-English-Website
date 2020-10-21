<?php

namespace App\Http\Controllers\Teacher;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use App\Models\Country;
//use Illuminate\Foundation\Auth\User;
use App\User;
use App\Http\Requests\Teacher\Register\RegisterRequest;
use App\Http\Requests\Teacher\Profile\StoreRequest;
use App\Http\Requests\Teacher\Profile\SaveInfoRequest;
use App\Models\TeacherSchedule;
use App\Models\TeacherDetail;
use App\Jobs\SendEmailJob;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Models\TeacherAttachment;
use App\Models\StudentLessonsBooking;
use App\Models\StudentTeachers;
use App\Models\Settings;
use App\Models\StudentShareRecord;
//use Illuminate\Http\File;
use File;
use Illuminate\Support\Facades\Mail;
use App\Helpers\AppHelper;

class ProfileController extends Controller
{
    public function __construct() {
        $this->middleware('auth');
    }

    public function index() {
        $countries = Country::pluck('name', 'name');

        $conversation_topic = [
            'ba' => 'BA',
            'bs' => 'BS',
            'ma' => 'MA',
            'phd' => 'PhD',
            'mba' => 'MBA',
        ];
		
		$japanese_resident = [
            '1' => 'Yes',
            '0' => 'No',
        ];
		
		$teach_beginers = [
            '1' => 'Yes',
            '0' => 'No',
        ];
		
		$own_realstate_in_japan = [
            '1' => 'Yes',
            '0' => 'No',
        ];
		
		$is_available = [
            '1' => 'Yes',
            '0' => 'No',
        ];
		
		$english_language_specialization  = [
            'marketing' => 'Marketing',
            'sales' => 'Sales',
            'it' => 'IT',
            'cooking' => 'Cooking',
        ];
		
		$teaching_english_in  = [
            '-1' => 'Select',
            'en' => 'English',
            'ja' => 'Japanese',
            'hi' => 'Hindi',
        ];
		
		$speaking_level  = [
            '1' => 'B',
            '2' => 'I',
            '3' => 'E',
        ];

       // $teacher = Auth::user();

        $user_id = Auth::user()->id;

        $teacher = User::where('id', $user_id)->first();

        if (empty($teacher->referral_code)) {
            $teacher->referral_code = uniqid();
            $teacher->save();
        }

        $teacherDetails = $teacher->details()->first();

        $setting =  Settings::getSettings();
		
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
		if(!empty($fav)) {
			$fav_cnt = $fav[0];
		}
		
		// get session count
		$session = StudentLessonsBooking::Select(DB::raw("count(id) as count"))->where('teacher_id', $user_id)->get()->pluck('count')->toArray();
		//echo '<pre>';print_r($session);	exit;	
		$session_cnt = 0;
		if(!empty($session)) {
			$session_cnt = $session[0];
		}
		
        return view('teachers.profile.index', compact('teacher','teacherDetails','conversation_topic','countries','setting', 'english_language_specialization', 'teaching_english_in','japanese_resident','own_realstate_in_japan','is_available','teacherDetails', 'lessionsData', 'fav_cnt', 'session_cnt', 'teach_beginers','speaking_level'));
    }

    public function ReferEarnReward(Request $request) {
        $input = $request->all();

        $student = $input['email'];

        $user = Auth::user();
        $userdata = [];
        $userdata['firstname'] = $user->firstname;
        $userdata['lastname'] = $user->lastname;
        $userdata['email'] = $user->email;
        $userdata['referral_code'] = $user->referral_code;

        $template = "emails.teacher-refer-earn-reward";
        $subject = "You Are Invited By " . $userdata['firstname'] . ' ' . $userdata['lastname'];

        $data = ['user' => $user, 'receiver' => $student];
        dispatch(new SendEmailJob($template, $data, $subject, 'other'));

        return redirect()->back()->with('message', 'Referral Sent Successfully');
    }

    public function store(StoreRequest $request) {
        $input = $request->all();
        $user_id = Auth::user()->id;

		$user = User::where('id', $user_id)->first();

        $userDetail = TeacherDetail::where('user_id', $user_id)->first();
        $userDetail->major_subject = $input['major_subject'];
        $userDetail->teaching_year_begun = $input['teaching_year_begun'];
        $userDetail->japanese_ability = $input['japanese_ability'];
        $userDetail->jplt_score = !empty($input['jplt_score']) ? $input['jplt_score'] : 0;
        $userDetail->hobby = $input['hobby'];
        $userDetail->message_en = $input['message_en'];
        $userDetail->message_jp = $input['message_jp'];
        $userDetail->highest_education = !empty($input['highest_education']) ? implode(',', $input['highest_education']) : "" ;
        $userDetail->teaching_certificate = !empty($input['teaching_certificate']) ? implode(',', $input['teaching_certificate']) : "" ;
        $userDetail->courses_teach = !empty($input['courses_teach']) ? implode(',', $input['courses_teach']) : '';
            if(!empty($input['visa_type'])){
                $userDetail->visa_type = !empty($input['visa_type']) ? $input['visa_type'] : '';
            }
            if(!empty($input['visa_expiry_date'])){
                $userDetail->visa_expiry_date = !empty($input['visa_expiry_date']) ? $input['visa_expiry_date'] : '';
            }

        $userDetail->save();

		return redirect()->route('teachers.profile.index')->with('message', 'Your profile successfully updated. ');
    }

    public function saveInfo(SaveInfoRequest $request) {
        $input = $request->all();
		/*$validatedData = $request->validate([
			'video' => 'max:5120',
		]);*/
		
		//echo '<pre>';print_r($input);exit;
		$teaching_english_in = implode(',', array($input['teaching_english_in_1'], $input['teaching_english_in_2'], $input['teaching_english_in_3']));
		$speaking_level = implode(',', array($input['speaking_level1'], $input['speaking_level2'], $input['speaking_level3']));
        $user_id = Auth::user()->id;

		$user = User::where('id', $user_id)->first();

        $user->nickname            = !empty($input['nickname']) ? $input['nickname'] : '';
        $user->firstname            = !empty($input['firstname']) ? $input['firstname'] : '';
		$user->lastname             = !empty($input['lastname']) ? $input['lastname'] : '';
        $user->line_reply_token     = !empty($input['line_reply_token']) ? $input['line_reply_token'] : '';
        $user->paypal_email         = !empty($input['paypal_email']) ? $input['paypal_email'] : '';

        if ($request->has('image') && !empty($input['image'])){
            $image          = $input['image'];
            $image          = str_replace('data:image/png;base64,', '', $image);
            $image          = str_replace(' ', '+', $image);
            $imageName      = str_random(10).'.'.'png';
            $image          = base64_decode($image);

            if (!is_dir('uploads/users/teachers/'.$user->id)) {
                mkdir('uploads/users/teachers/'.$user->id);
            }

            $file_path = 'uploads/users/teachers/'.$user->id;

            $move = file_put_contents($file_path.'/'.$imageName, $image);

            if($move){
                if(url('') == "http://localhost:8000"){
                    if(file_exists(public_path($user->profile_image))){
                        File::delete(public_path($user->profile_image));
                    }

                }
                $user->profile_image = $file_path.'/'.$imageName;
            }

        }

        /*if ($request->has('profile_image')){
            $file           = $request->file('profile_image');
            $file_name      = time() . $file->getClientOriginalName();
            $file_path      = 'uploads/users/teachers/'.$user->id;
            $move           = $file->move($file_path, $file_name);
            if($move){
                if(file_exists(public_path($user->profile_image))){
                    File::delete(public_path($user->profile_image));
                }

                $user->profile_image = $file_path.'/'.$file_name;
            }
        }*/
		
		
		if($user && $request->has('video')){
			if (!is_dir('uploads/users/teachers/'.$user->id)) {
                mkdir('uploads/users/teachers/'.$user->id);
            }
			$video = $request->file('video');
			
				$insertvideo = [];
				$ext      = $video->getClientOriginalExtension();
				$video_name      = md5(time()).'.'.$ext;
				$file_path      = 'uploads/users/teachers/'.$user->id;
				$move           = $video->move($file_path, $video_name);
				if($move){
					$user->video = url('').'/'.$file_path.'/'.$video_name;
					$user->save();
				}
			
        }

        $user->save();
		
		$nationality = $input['nationality'];		
		$countryCode = AppHelper::getCountryCode($nationality);
		if(!empty($countryCode)){
			$countryCode = strtolower($countryCode);
		}
			
        $userDetail = TeacherDetail::where('user_id', $user_id)->first();
		$userDetail->dob = isset($input['dob']) ? $input['dob'] : '';
        $userDetail->gender = isset($input['gender']) ? $input['gender'] : '';
        $userDetail->nationality = $nationality;
        $userDetail->country_code = $countryCode;
        $userDetail->message_en = $input['message_en'];
        $userDetail->japanese_resident = $input['japanese_resident'];
        $userDetail->address_line1 = $input['japanese_resident'] == 0 ? $input['address_line1'] : '';
        //$userDetail->own_realstate_in_japan = $input['own_realstate_in_japan'];
        $userDetail->occupation = $input['occupation'];
        $userDetail->conversation_topic = isset($input['conversation_topic']) ? implode(',', $input['conversation_topic']) : '';
        $userDetail->english_language_specialization = isset($input['english_language_specialization']) ? implode(',', $input['english_language_specialization']) : '';
        $userDetail->teaching_english_in = $teaching_english_in;
        $userDetail->speaking_level = $speaking_level;
        $userDetail->is_available = isset($input['is_available']) ? $input['is_available'] : 1;
		
        if ($request->has('audio_attachment')){
			if (!is_dir('uploads/users/teachers/'.$user->id)) {
                mkdir('uploads/users/teachers/'.$user->id);
            }
            $afile           = $request->file('audio_attachment');
            $afile_name      = time() . $afile->getClientOriginalName();
            $afile_path      = 'uploads/users/teachers/'.$user->id.'/attachment';
            $amove           = $afile->move($afile_path, $afile_name);
            if($amove){
                if(file_exists(public_path($userDetail->audio_attachment))){
                    File::delete(public_path($userDetail->audio_attachment));
                }

                $userDetail->audio_attachment = $afile_path.'/'.$afile_name;
            }
        }
        $userDetail->save();

        $files = [];
		if($request->has('attachments')){
			$files           = $request->file('attachments');
			foreach ($files as $atfile) {
				$insertImages = [];
				$file_name      = time() . $atfile->getClientOriginalName();
				$file_path      = 'uploads/users/teachers/'.$user->id.'/attachment';
				$move           = $atfile->move($file_path, $file_name);
				if($move){
					$insertImages['attachment_url'] = $file_path.'/'.$file_name;
					$insertImages['user_id'] = $user->id;
					$insertImages['type'] = $atfile->getClientMimeType();
					TeacherAttachment::create($insertImages);
				}
			}
        }

		//return redirect()->route('teachers.profile.index')->with('message', 'Personal Info successfully updated. ');
        $request->session()->flash('message', 'Personal Info successfully updated.');
        return response()->json(['type' => 'success', 'message' => 'Personal Info successfully updated.', 'redirect' => route('teachers.profile.index')]);
    }

    public function showChangePassword() {
        return view('teachers.profile.change-password');
    }

    public function changePassword(Request $request) {
        $this->validate($request,[
            'password' => 'required',
            'confirm_password' => 'same:password'
        ]);

        $user = Auth::user();
        if($request->password != ''){
            $user->password = Hash::make($request->password);
        }

        $user->save();

        return redirect(route('teachers.profile.change.password'))->with('message', trans('labels.password_success'));
    }

    public function deleteAccount(Request $request) {
       
        $userId = Auth::user()->id;
        
        $user = User::findOrFail($userId);

        if ($user->profile_image) {
            $image = parse_url($user->profile_image, PHP_URL_PATH);
            if (file_exists(public_path($image))) {
                File::delete(public_path($image));
            }
        }

        $user->delete();

        //return redirect(route('teacher.login'))->with('message', 'Deleted Account Successfully.');
        return response()->json(['type' => 'success', 'message' => 'Deleted Account Successfully.', 'redirect' => route('teacher.login')]);
    }
	
	function deletemedia(Request $request) {
		$user_id = Auth::user()->id;
        $teacher = User::where('id', $user_id)->first();
        $teacherDetails = $teacher->details()->first();
		$input = $request->all();
		$type = $input['media'];
		
		if($type == 'audio') {
			$teacherDetails->audio_attachment = '';
			$teacherDetails->save();
			return response()->json(['type' => 'success', 'message' => 'Audio deleted successfully.']);
		}
		
		if($type == 'video') {
			$teacher->video = '';
			$teacher->save();
			return response()->json(['type' => 'success', 'message' => 'Video deleted successfully.']);
		}
		return response()->json(['type' => 'failure', 'message' => 'Error in deleting media.']);
	}
}
