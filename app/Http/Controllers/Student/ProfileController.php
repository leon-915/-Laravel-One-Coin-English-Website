<?php

namespace App\Http\Controllers\Student;

use App\Helpers\AppHelper;
use App\Jobs\SendEmailJob;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\StudentDetail;
use App\Models\StudentShareRecord;
use App\Models\Country;
use Auth;
use File;
use Illuminate\Support\Facades\Mail;

use PayPal\Api\PaymentExecution;
use PayPal\Auth\OAuthTokenCredential;
use PayPal\Rest\ApiContext;
use PayPal\Api\Amount;
use PayPal\Api\CreditCard;
use PayPal\Api\FundingInstrument;
use PayPal\Api\Payer;
use PayPal\Api\Payment;
use PayPal\Api\RedirectUrls;
use PayPal\Api\Transaction;


class ProfileController extends Controller
{
    public function index() {
        $user = Auth::user();
        $student = StudentDetail::where(['user_id' => $user->id])->first();
        $emails = StudentShareRecord::where(['user_id' => $user->id, 'share_type' => 'lessons'])->get();
        if (!$student) {
            $student = StudentDetail::create(['user_id' => $user->id]);
        }
        if (empty($user->referral_code)) {
            $user->referral_code = uniqid();
            $user->save();
        }

        $countries = Country::pluck('name', 'name');		
		
		$japanese_resident = [
            '1' => 'Yes',
            '0' => 'No',
        ];
		
		$own_realstate_in_japan = [
            '1' => 'Yes',
            '0' => 'No',
        ];
		
		$conversation_topic = [
            'ba' => 'BA',
            'bs' => 'BS',
            'ma' => 'MA',
            'phd' => 'PhD',
            'mba' => 'MBA',
        ];
		
		$speaking_level  = [
            '1' => 'B',
            '2' => 'I',
            '3' => 'E',
        ];

        return view('students.profile.index', compact('user', 'student','emails', 'countries', 'japanese_resident', 'own_realstate_in_japan', 'conversation_topic', 'speaking_level'));
    }

    public function EarnReward(Request $request) {
        $input = $request->all();
        $student = $input['email'];

        $user = Auth::user();
        $userdata = [];
        $userdata['firstname'] = $user->firstname;
        $userdata['lastname'] = $user->lastname;
        $userdata['email'] = $user->email;
        $userdata['referral_code'] = $user->referral_code;

        $template = "emails.refer-earn-reward_email";
        $subject = "You Are Invited By " . $userdata['firstname'] . ' ' . $userdata['lastname'];

        $data = ['user' => $user, 'receiver' => $student];
        dispatch(new SendEmailJob($template, $data, $subject, 'other'));

        return redirect(route('students.profile.index'))->with('message', 'Referral Sent Successfully');
    }

    public function ShareGiftPoint(Request $request) {
        $input = $request->all();

        $user = User::where('email', $input['email'])
            ->where('email', '!=', Auth::user()->email)
            ->where('user_type', 'student')
            ->first();


        if (!empty($user->email)) {

            $authUser = Auth::user();
            $studentDetails = $authUser->details()->first();
            $studentAvailableBal = $studentDetails->credit_balance;

            if ($studentAvailableBal >= $input['amount']) {
                $studentDetails->credit_balance = $studentAvailableBal - $input['amount'];
                $studentDetails->save();

                $receiver = StudentDetail::where('user_id', $user->id)->first();
                $receiverBal = $receiver->credit_balance;
                $receiver->credit_balance = $receiverBal + $input['amount'];
                $receiver->save();

                //sent email
                $template = "emails.point-sent-email";
                $subject = "Reward Points Sent " . $authUser['firstname'] . ' ' . $authUser['lastname'];
                $data = ['user' => $authUser, 'receiver' => $user, 'amount' => $input['amount']];
                dispatch(new SendEmailJob($template, $data, $subject,'point_mail'));
                //sent email

                return redirect()->back()->with('message', 'Reward Points Sent Successfully');
            }
            return redirect()->back()->with('error', 'Insufficient Balance');
        }
        return redirect()->back()->with('error', 'Student Email Not Found');
    }

    public function ShareLessonRecord(Request $request){
        $input = $request->all();

        $user_id = Auth::user()->id;
        $oldEmails = StudentShareRecord::where(['user_id'=>$user_id, 'share_type' => $input['share_type']])->get();
        $emails = [];
        if(!empty($oldEmails)){
            foreach ($oldEmails as $value) {
                $emails[] = $value['email'];
            }
        }
        $exist = [];
        $new = [];

        $input['email'] = array_filter($input['email']);

        if(!empty($input['email'])){
           foreach ($input['email'] as $key => $email) {
                if(!empty($emails) && in_array($email,$emails)){
                    $exist[] = $email;
                }else{
                    $record = new StudentShareRecord;
                    $record->user_id = $user_id;
                    $record->share_type = $input['share_type'];
                    $record->email = $email;
                    $record->save();
                    $new[] = $email;
                }

           }
        }

        $all = array_merge($exist,$new);

        $allEmails = StudentShareRecord::select('*')
                        ->where(['user_id'=>$user_id, 'share_type' => $input['share_type']])
                        ->whereNotIn('email', $all)
                        ->pluck('id');

        $deleteOther = StudentShareRecord::whereIn('id', $allEmails)->delete();

        return redirect()->back()->with('message', 'Share Lesson Record Successfully');
    }

    public function update(Request $request) {
        $this->validate($request, [
            'firstname' => 'required',
            'lastname' => 'required',
            'confirm_password' => 'same:password',
            //'contact_no' => 'required'
        ]);
        $user = Auth::user();
        $student = StudentDetail::where(['user_id' => $user->id])->first();
		$input = $request->all();
        $update_user = [
            'nickname' => isset($request->nickname) ? $request->nickname : '',
            //'nationality' => isset($request->nationality) ? $request->nationality : '',
            'firstname' => $request->firstname,
            'lastname' => $request->lastname,
			'dob' => isset($request->dob) ? $request->dob : '',
			'gender' => isset($request->gender) ? $request->gender : '',
			'japanese_resident' => $request->japanese_resident,
			'occupation' => $request->occupation,
			'conversation_topic' => isset($request->conversation_topic) ? implode(',', $request->conversation_topic) : '',
			'speaking_level' => $request->speaking_level,
			//'message_en' => isset($request->message_en) ? $request->message_en : '',
            'contact_no' => isset($request->contact_no) ? $request->contact_no : '',
            'skype_name' => isset($request->skype_name) ? $request->skype_name : '',
            'line_reply_token' => isset($request->line_reply_token) ? $request->line_reply_token : '',
        ];

        if ($request->password != '') {
            $update_user['password'] = bcrypt($request->password);
        }
		
		if ($request->has('image') && !empty($input['image'])){
            $image          = $input['image'];
            $image          = str_replace('data:image/png;base64,', '', $image);
            $image          = str_replace(' ', '+', $image);
            $imageName      = str_random(10).'.'.'png';
            $image          = base64_decode($image);

            if (!is_dir('uploads/users/students')) {
                mkdir('uploads/users/students');
            }
			
			if (!is_dir('uploads/users/students/'.$user->id)) {
                mkdir('uploads/users/students/'.$user->id);
            }

            $file_path = 'uploads/users/students/'.$user->id;

            $move = file_put_contents($file_path.'/'.$imageName, $image);

            if($move){
                //if(url('') == "http://localhost:8000"){
                    if(file_exists(public_path($user->profile_image))){
                        File::delete(public_path($user->profile_image));
                    }

                //}
                $user->profile_image = $file_path.'/'.$imageName;
            }

        }

        $user->update($update_user);
        $student->update([
            'address' => $request->address,
            'city' => $request->city,
            'country' => $request->country,
            'post_code' => $request->post_code,
        ]);

        //return redirect(route('students.profile.index'))->with(['success' => __('labels.profile_success')]);
		return response()->json(['type' => 'success', 'message' => 'Personal Info successfully updated.', 'redirect' => route('students.profile.index')]);
    }
}
