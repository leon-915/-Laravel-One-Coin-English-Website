<?php

namespace App\Http\Controllers\Teacher;

use App\Helpers\AppHelper;
use App\Helpers\MailerliteHelper;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Teacher\Register\RegisterRequest;
use App\Http\Requests\Teacher\Register\Step2RegisterRequest;
use App\User;
use App\Models\TeacherDetail;
use App\Jobs\SendEmailJob;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use File;
use App\Models\Settings;
use Illuminate\Support\Facades\Redirect;
use Asana\Client;

class RegisterController extends Controller
{
    public function __construct() {
        //$this->middleware('auth');
    }

    public function index() {

        if((Auth::user()) && (Auth::user()->user_type == 'teacher')){
            return redirect(route('teachers.dashboard.index'));
        }
        
        $setting =  Settings::getSettings();
        return view('teachers.register.index', compact('setting'));
    }

    public function store(RegisterRequest $request) {

        $input = $request->all();
		$firstname = isset($input['firstname']) ? $input['firstname'] : '';
		$lastname = isset($input['lastname']) ? $input['lastname'] : '';
		$contact_no = isset($input['contact_no']) ? $input['contact_no'] : '';
		$teacher_name = $firstname.' '.$lastname;
		$email = $input['email'];
		
        $user = new User;
        $user->email = strtolower($email);
        $user->firstname = $firstname;
        $user->lastname = $lastname;
        $user->referral_code = uniqid();
        $user->status = 1;
        $user->user_type = 'teacher';
		$password = 'wQ26$4bC';//str_random(10);
		$user->step2_verification_token = '';
		$user->password = Hash::make($password);
        $user->save();
		
        if($user->save()) {			
			$userDetail = new TeacherDetail;
            $userDetail->user_id = $user->id;
            
			$userDetail->save();
        }
		
		TeacherLocations::create([
                        'user_id'       => $user->id,
                        'location_id'   => env('OCE_LOCATION_ID'),
                        'is_deleted'    => 0
                    ]);
					
		TeacherServices::create([
                    'teacher_id' => $user->id,
                    'service_id' => env('OCE_SERVICE_ID'),
                    'is_deleted' => 0
                ]);	
					
		$template = "emails.welcome";
		$subject = 'Welcome to '.env('APP_NAME');
		$data = ['user' => $user, 'password' => $password];
		if(env('IS_EMAIL_ENABLED') == 1){
			dispatch(new SendEmailJob($template, $data, $subject, 'user'));
		}

		if(env('IS_ASANA_ENABLED') == 1 && ($firstname != '') && (strtolower($firstname) != 'panacea')) {
			$gcon = AppHelper::createGoogleContact($user->toArray());
			try {
				$asanaToken = env('ASANA_TOKEN');
				//$workspaceId = env('ASANA_WORKSPACE_ID');
				$workspaceId = env('ASANA_TEACHERS_WORKSPACE_ID');
				$client = Client::accessToken($asanaToken);
				$project = $client->projects->createInWorkspace(
					$workspaceId,
					array(
						'name' => $firstname . " " . $lastname
					)
				);

				$teacheruser = User::find($user->id);
				$teacheruser->asana_project_id = !empty($project->gid) ? $project->gid : '';
				$teacheruser->save();

				$assignee = 'ryan.ahamer@accent-admin.com';
				$due_date = date('Y-m-d');
				
				// create task 1
				$task = $client->tasks->createInWorkspace(
					$workspaceId,
					array(
						'name'          => $firstname . ' ' . $lastname . ' New '.env('APP_NAME').' Teacher Registration.',
						'notes'         => "Email : ".$email.", Contact : ".$contact_no,
						"assignee" => $assignee, // Right now we autoassign the task to the owner of the API key.					
						"due_on" => $due_date
					)
				);

				$client->tasks->addProject(
					$task->gid,
					array(
						'project' => $project->gid
					)
				);

			} catch (\Throwable $th) {

			}
		}
		
		if($firstname != '') {
			MailerliteHelper::createSubscriber_teacher($email, $teacher_name, $contact_no);
		}
        //Newsletter::subscribe($input['email']);
        
		/*if(env('IS_EMAIL_ENABLED') == 1){
			
			$teach_template = "emails.teacher-register-step1";
			$teach_subject = "You have successfully completed stage 1 of 2 of the application process.";
			$teach_data = ['user' => $user];

			dispatch(new SendEmailJob($teach_template, $teach_data, $teach_subject, 'user'));
		}*/
		return redirect()->route('teachers.register.index')->with('message', 'You have been registered successfully. Please check your spam box in case you have not received the email we have just sent in your inbox. Login and update your profile <a href="'.route('teachers.profile.index').'">here</a> first to get started.');
    }

    public function checkEmailAlready(Request $request) {
		$input = $request->all();
		if (isset($input['user_id'])) {
			$user = User::where('email', $input['email'])
				->where('id', '!=', $input['user_id'])->count();
		} else {
			$user = User::where('email', $input['email'])->count();
		}
		if ($user > 0) {
			return "false";
		} else {
			return "true";
		}
    }

    public function recruitment() {
        return view('teachers.register.recruitment');
    }
}
