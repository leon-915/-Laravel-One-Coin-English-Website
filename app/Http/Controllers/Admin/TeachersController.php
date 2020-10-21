<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\AppHelper;
use App\Helpers\MailerliteHelper;
use App\Http\Controllers\Controller;
use App\Libraries\Ical\iCalEasyReader;
use App\Models\City;
use App\Models\TeacherIcal;
use Illuminate\Http\Request;
use App\User;
use App\Models\State;
use Illuminate\Support\Facades\DB;
use Hash;
use Kigkonsult\Icalcreator\IcalBase;
use Kigkonsult\Icalcreator\Vcalendar;
use Yajra\Datatables\Datatables;
use Auth;
use View;
use File;
use App\Http\Requests\Admin\Teachers\AddRequest;
use App\Http\Requests\Admin\Teachers\EditRequest;
use App\Jobs\SendEmailJob;
use App\Models\Country;
use App\Models\TeacherDetail;
use App\Models\TeacherAttachment;
use App\Models\Locations;
use App\Models\Services;
use App\Models\TeacherLocations;
use App\Models\TeacherServices;
use App\Models\TeacherSchedule;
use App\Models\TeacherScheduleException;
use App\Models\Settings;
use App\Models\StudentLessonsBooking;
use Carbon\Carbon;
use DateTime;
use DateTimeZone;
use Asana\Client;
use Newsletter;

class TeachersController extends Controller
{
    function __construct()
    {
        // $this->middleware('permission:admin-user-list');
        // $this->middleware('permission:admin-user-create', ['only' => ['create','store']]);
        // $this->middleware('permission:admin-user-edit', ['only' => ['edit','update']]);
        // $this->middleware('permission:admin-user-delete', ['only' => ['destroy']]);
    }

    public function index(Request $request)
    {
        return view('admin.teachers.index');
    }

    public function getTeachers(Request $request)
    {
        $users = User::select(
            'users.*',
            DB::raw("CONCAT(users.firstname, ' ', users.lastname) AS fullname"),
            'teacher_detail.is_ambassador',
            'teacher_detail.per_hour_salary',
            'teacher_detail.nationality AS nationality',
            'teacher_detail.address_line1 AS address_line1',
            'teacher_detail.address_line2 AS address_line2',
            'teacher_detail.city AS city',
            'teacher_detail.zipcode AS zipcode',
            'teacher_detail.gender AS gender',
            'teacher_detail.dob AS dob',
            'teacher_detail.state AS state',
            'teacher_detail.country AS country'
        )
            ->leftJoin('teacher_detail', 'users.id', '=', 'teacher_detail.user_id')
            ->where("users.user_type", 'teacher');

        return Datatables::of($users)
            ->order(function ($query) {
                $sort = request()->order;
                $sort = current($sort);
                switch ($sort['column']) {
                    case '1':
                        $query->orderBy('id', $sort['dir']);
                        break;
                    case '2':
                        $query->orderBy('firstname', $sort['dir']);
                        break;
                    case '3':
                        $query->orderBy('lastname', $sort['dir']);
                        break;
                    case '4':
                        $query->orderBy('email', $sort['dir']);
                        break;
                    case '5':
                        $query->orderBy('dob', $sort['dir']);
                        break;
                    /* case '6':
                         $query->orderBy('teacher_detail.city', $sort['dir']);
                         break;
                     case '7':
                         $query->orderBy('teacher_detail.state', $sort['dir']);
                         break;
                     case '8':
                         $query->orderBy('teacher_detail.country', $sort['dir']);
                         break;
                     case '9':
                         $query->orderBy('zipcode', $sort['dir']);
                         break;*/
                    case '10':
                        $query->orderBy('status', $sort['dir']);
                        break;
                        break;
                }

            })
            ->filter(function ($query) use ($request) {
                if (!empty($request->get('firstname'))) {
                    $query->whereRaw("LOWER(users.firstname) like '%" . strtolower($request->get('firstname')) . "%'");
                }
                if (!empty($request->get('lastname'))) {
                    $query->whereRaw("LOWER(users.lastname) like '%" . strtolower($request->get('lastname')) . "%'");
                }

                if (!empty($request->get('email'))) {
                    $query->whereRaw("LOWER(users.email) like '%" . strtolower($request->get('email')) . "%'");
                }
                if (!empty($request->get('status'))) {
                    $query->where("users.status", $request->get('status'));
                }
                if (!empty($request->get('step_verified'))) {
                    if ($request->get('step_verified') == 1) {
                        $query->where(["users.status" => 2, "users.step2_verification_token" => null]);
                    } else if ($request->get('step_verified') == 2) {
                        $query->where("users.status", 5)
                            ->where('users.step2_verification_token', '<>', '', 'and');
                    } else if ($request->get('step_verified') == 3) {
                        $query->where("users.status", 2)
                            ->where('users.step2_verification_token', '<>', '', 'and');
                    } else if ($request->get('step_verified') == 4) {
                        $query->where("users.status", 6);
                    }
                }
            })
            ->addIndexColumn()
            ->editColumn('status', function ($users) {
                if ($users->status == '1') {
                    return '<span class="badge badge-gradient-success badge-pill">Active</span>';
                } else if ($users->status == '3') {
                    return '<span class="badge badge-gradient-danger badge-pill">Inactive</span>';
                } else if ($users->status == '2' || $users->status == '8') {
                    return '<span class="badge badge badge-gradient-warning badge-pill">Pending</span>';
                } else if ($users->status == '4') {
                    return '<span class="badge badge-gradient-dark badge-pill" >Deleted</span>';
                } else if ($users->status == '5' || $users->status == '7') {
                    return '<span class="badge badge-gradient-info badge-pill">Approved</span>';
                } else if ($users->status == '6') {
                    return '<span class="badge badge-gradient-primary badge-pill">Archived</span>';
                }
            })

            ->addColumn('case', function ($users) {
                return '<input type="checkbox" name="select" value="'.$users->id.'" onclick="checked_chkbx('.$users->id.')"  class="case" id="chk_'. $users->id .'">';
            })

            ->editColumn('profile_image', function ($users) {
                if ($users->profile_image) {
                    return '<image src="' . asset($users->profile_image) . '" height="50" width="50">';
                    //return url('uploads/profile/'.$users->profile_image);
                } else {
                    return '<image src="' . asset('uploads/users/teachers/default.png') . '" height="50" width="50">';
                    //return url("uploads/profile/default.png");
                }
            })
            ->editColumn('name', function ($users) {

                return $users->fullname;

            })
            ->editColumn('last_login_at', function ($users) {
                if ($users->last_login_at) {
                    return $users->last_login_at->diffForHumans();
                } else {
                    return "-";
                }
            })
            /* ->editColumn('earning', function ($users) {

                 if($users->is_ambassador != 1){
                     $TeacherEarning = StudentLessonsBooking::select(
                                         DB::raw("sum(teacher_earnings) as total_earning"))
                                         ->where('teacher_id',$users->id)->first();

                     return !empty($TeacherEarning['total_earning']) ? $TeacherEarning['total_earning'] : '0' ;
                 }else{
                     return '0';
                 }

             })*/
            ->addColumn('action', function ($users) {
                $editButton = '';
                $authUser = auth()->user();

                $teacherAtt = TeacherAttachment::where('user_id', $users->id)->get()->toArray();
                $teacherAudio = TeacherDetail::select('audio_attachment')->where('user_id', $users->id)->pluck('audio_attachment');

                /*$editButton .= '<a href="' . route('admin.teachers.location', $users->id) . '" class="btn btn-outline-info btn-rounded btn-icon edit-row" data-toggle="tooltip" title="Location" data-original-title="Location"><i class="mdi mdi-map-marker" aria-hidden="true"></i></a>';
                */
                $editButton .= '<a href="' . route('admin.teachers.get.schedule', $users->id) . '" class="btn btn-outline-info btn-rounded btn-icon edit-row" data-toggle="tooltip" title="Schedule" data-original-title="Schedule"><i class="mdi mdi-calendar" aria-hidden="true"></i></a>';

                if ($users->is_ambassador == 1) {

                    $editButton .= '<a href="' . route('admin.teachers.get.earnings', $users->id) . '" class="btn btn-outline-info btn-rounded btn-icon edit-row" data-toggle="tooltip" title="Earnings" data-original-title="Earnings"><i class="mdi mdi-cash-multiple" aria-hidden="true"></i></a>';
                } else {
                    $editButton .= '<a href="#" class="btn btn-outline-info btn-rounded btn-icon edit-row" data-toggle="tooltip">-</a>';
                }

                $editButton .= '<a href="' . route('admin.teachers.edit', $users->id) . '" class="btn btn-outline-info btn-rounded btn-icon edit-row" data-toggle="tooltip" title="Edit" data-original-title="Edit"><i class="mdi mdi-pencil-box" aria-hidden="true"></i></a>';

                $editButton .= '<a id="' . $users->id . '" class="btn btn-outline-danger btn-rounded btn-icon remove-row deleteUser"
				   data-toggle="tooltip" title="Delete" data-original-title="Delete"><i class="mdi mdi-delete" aria-hidden="true"></i></a>';

                if ((!empty($teacherAtt)) || (!empty($teacherAudio[0]))) {

                    $editButton .= '<a href="' . route('admin.teachers.attachment', $users->id) . '" class="btn btn-outline-primary btn-rounded btn-icon edit-row attachment-row" data-toggle="tooltip" title="Attachment" data-original-title="Attachment"><i class="mdi mdi-attachment" aria-hidden="true"></i></a>';
                }
                return $editButton;
            })
            ->addColumn('step1_verified', function ($users) {
                $verification = '';
                $authUser = auth()->user();

                if ($users->status == '2' && !empty($users->step2_verification_token)) {
                    $verification = '<span class="badge badge-gradient-success badge-pill">Yes</span>';
                } else if ($users->status == '2' && empty($users->step2_verification_token)) {
                    $verification = '<span class="badge badge-gradient-danger badge-pill">No</span>';
                } else if ($users->status == '6' && empty($users->step2_verification_token)) {
                    $verification = '<span class="badge badge-gradient-danger badge-pill">No</span>';
                } else if ($users->status != '2') {
                    $verification = '<span class="badge badge-gradient-success badge-pill">Yes</span>';
                }

                return $verification;
            })
            ->rawColumns(['case','status', 'action', 'profile_image', 'step1_verified', 'last_login_at'])
            ->make(true);
    }

    public function checkEmailAlready(Request $request)
    {
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

    public function create()
    {
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
        return view('admin.teachers.create', compact('degrees', 'countries', 'certificates', 'abilities'));
    }

    public function store(AddRequest $request)
    {
        $input = $request->all();

        $input['email'] = strtolower($input['email']);
        $password = $input['password'];
		$email = !empty($input['email']) ? $input['email'] : '';
        $contact_no = !empty($input['contact_no']) ? $input['contact_no'] : '';
		$first_name = !empty($input['firstname']) ? $input['firstname'] : '';
		$last_name = !empty($input['lastname']) ? $input['lastname'] : '';
		$teaacher_name = $first_name.' '.$last_name;
				
		$user = new User;
        $user->email = $email;
        $user->password = Hash::make($input['password']);
        $user->firstname = !empty($input['firstname']) ? $input['firstname'] : '';
        $user->lastname = !empty($input['lastname']) ? $input['lastname'] : '';
        $user->contact_no = $contact_no;
        $user->status = $input['status'];
        $user->user_type = 'teacher';

        /*if ($request->has('image') && !empty($input['image'])) {
            $image = $input['image'];
            $image = str_replace('data:image/png;base64,', '', $image);
            $image = str_replace(' ', '+', $image);
            $imageName = str_random(10) . '.' . 'png';
            $image = base64_decode($image);
            file_put_contents('uploads/users/teachers/' . $imageName, $image);
            $user->profile_image = url('') . '/uploads/users/teachers/' . $imageName;
        } else {
            $user->profile_image = url('') . '/uploads/profile/default.png';
        }
        */
        $user->save();

        if ($user->save()) {

            if ($request->has('image') && !empty($input['image'])) {
                $user = User::find($user->id);
                $image = $input['image'];
                $image = str_replace('data:image/png;base64,', '', $image);
                $image = str_replace(' ', '+', $image);
                $imageName = str_random(10) . '.' . 'png';
                $image = base64_decode($image);

                if (!is_dir('uploads/users/teachers/' . $user->id)) {
                    mkdir('uploads/users/teachers/' . $user->id);
                }

                file_put_contents('uploads/users/teachers/' .$user->id.'/'. $imageName, $image);
                $user->profile_image = url('') . '/uploads/users/teachers/'.$user->id.'/' . $imageName;
            } else {
                $user->profile_image = url('') . '/uploads/users/teachers/default.png';
            }
            $user->save();

            $userDetail = new TeacherDetail;
            $userDetail->user_id = $user->id;
            $userDetail->dob = !empty($input['dob']) ? $input['dob'] : '';
            $userDetail->gender = !empty($input['gender']) ? $input['gender'] : '';
            $userDetail->state = !empty($input['state']) ? $input['state'] : '';;
            $userDetail->city = !empty($input['city']) ? $input['city'] : '';
            $userDetail->country = !empty($input['country']) ? $input['country'] : '';
            $userDetail->nationality = !empty($input['nationality']) ? $input['nationality'] : '';
            $userDetail->zipcode = !empty($input['zipcode']) ? $input['zipcode'] : '0';
            //$userDetail->phone = $input['phone'];
            $userDetail->address_line1 = !empty($input['address_line1']) ? $input['address_line1'] : '';
            $userDetail->address_line2 = !empty($input['address_line2']) ? $input['address_line2'] : '';
            $userDetail->save();

            $scheduleArray = $this->generateSchedule();

            foreach ($scheduleArray as $key => $sch) {
                $userSchedule = new TeacherSchedule;
                $userSchedule->user_id = $user->id;
                $userSchedule->from_time = $sch['from_time'];
                $userSchedule->to_time = ($sch['to_time'] == '24:00') ? '00:00' : $sch['to_time'];
                $userSchedule->monday = $sch['monday'];
                $userSchedule->tuesday = $sch['tuesday'];
                $userSchedule->wednesday = $sch['wednesday'];
                $userSchedule->thursday = $sch['thursday'];
                $userSchedule->friday = $sch['friday'];
                $userSchedule->saturday = $sch['saturday'];
                $userSchedule->sunday = $sch['sunday'];
                $userSchedule->save();
            }
        }

        //$gcon = AppHelper::createGoogleContact($user->toArray());
		if(env('IS_ASANA_ENABLED') == 1) {
			//try {
				$asanaToken = env('ASANA_TOKEN');
				$workspaceId = env('ASANA_TEACHERS_WORKSPACE_ID');
				$client = Client::accessToken($asanaToken);
				
				//exit;
				$project = $client->projects->createInWorkspace(
					$workspaceId,
					array(
						'name' => $first_name . " " . $last_name
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
						'name'          => $first_name . ' ' . $last_name . ' New '.env('APP_NAME').' Teacher Registration.',
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

			/*} catch (\Throwable $th) {

			}*/
		}
		
		MailerliteHelper::createSubscriber_teacher($email, $teaacher_name, $contact_no);
		
		if(env('IS_EMAIL_ENABLED') == 1){
			Newsletter::subscribe($email, ['FNAME'=>$first_name, 'LNAME'=>$last_name], 'subscribers_teacher');
			$template = "admin.emails.welcome";
			$subject = 'Welcome to '.env('APP_NAME');
			$data = ['user' => $user, 'password' => $password];

			dispatch(new SendEmailJob($template, $data, $subject));
		}
        $request->session()->flash('message', 'Teacher Created Successfully');
        return response()->json(['type' => 'success', 'message' => 'Teacher Created Successfully', 'redirect' => route('admin.teachers.index')]);

    }

    private function generateSchedule($schedules = [])
    {
        $schAvilable = false;

        $finalSchedule = [];

        if (!empty($schedules)) {
            if (count($schedules) > 1) {
                $schAvilable = true;
            } else {
                $sch = current($schedules);
                if (!empty($sch['from']) && !empty($sch['to'])) {
                    $schAvilable = true;
                } else {
                    $schAvilable = false;
                }
            }
        }

        if ($schAvilable) {
            $scheduleArrays = [];
            foreach ($schedules as $key => $schedule) {
                if (!empty($schedule['from']) && !empty($schedule['to'])) {
                    $formHour = substr($schedule['from'], 0, -3);
                    $toHour = substr($schedule['to'], 0, -3);
                    $times = !empty($schedule['times']) ? $schedule['times'] : [];
                    for ($h = (int)$formHour; $h < (int)$toHour; $h++) {
                        $fromTimeA = str_pad($h, 2, "0", STR_PAD_LEFT) . ':00';
                        $toTimeA = str_pad(($h + 1), 2, "0", STR_PAD_LEFT) . ':00';

                        $schA = [];
                        $schA['from_time'] = $fromTimeA;
                        $schA['to_time'] = $toTimeA;
                        $schA['monday'] = in_array('mon', $times) ? 1 : 0;
                        $schA['tuesday'] = in_array('tue', $times) ? 1 : 0;
                        $schA['wednesday'] = in_array('wed', $times) ? 1 : 0;
                        $schA['thursday'] = in_array('thu', $times) ? 1 : 0;
                        $schA['friday'] = in_array('fri', $times) ? 1 : 0;
                        $schA['saturday'] = in_array('sat', $times) ? 1 : 0;
                        $schA['sunday'] = in_array('sun', $times) ? 1 : 0;

                        $scheduleArrays[] = $schA;
                    }
                }
            }

            $finalArrayA = [];
            $unsetKeys = [];

            foreach ($scheduleArrays as $key_a => $schA) {
                $array = $schA;
                foreach ($scheduleArrays as $key_b => $schB) {
                    if ($key_a != $key_b && $key_a < $key_b) {
                        if ($array['from_time'] == $schB['from_time'] && $array['to_time'] == $schB['to_time']) {
                            if ($array['monday'] == 0) {
                                $array['monday'] = ($schB['monday'] == 1) ? $schB['monday'] : 0;
                            }

                            if ($array['tuesday'] == 0) {
                                $array['tuesday'] = ($schB['tuesday'] == 1) ? $schB['tuesday'] : 0;
                            }

                            if ($array['wednesday'] == 0) {
                                $array['wednesday'] = ($schB['wednesday'] == 1) ? $schB['wednesday'] : 0;
                            }

                            if ($array['thursday'] == 0) {
                                $array['thursday'] = ($schB['thursday'] == 1) ? $schB['thursday'] : 0;
                            }

                            if ($array['friday'] == 0) {
                                $array['friday'] = ($schB['friday'] == 1) ? $schB['friday'] : 0;
                            }

                            if ($array['saturday'] == 0) {
                                $array['saturday'] = ($schB['saturday'] == 1) ? $schB['saturday'] : 0;
                            }

                            if ($array['sunday'] == 0) {
                                $array['sunday'] = ($schB['sunday'] == 1) ? $schB['sunday'] : 0;
                            }

                            $unsetKeys[] = $key_b;
                        } else {
                            continue;
                        }
                    }
                }

                $finalArrayA[] = $array;
            }

            foreach ($unsetKeys as $uk) {
                unset($finalArrayA[$uk]);
            }

            $allDaySch = [];

            for ($i = 0; $i < 24; $i++) {
                $fromTime = str_pad($i, 2, "0", STR_PAD_LEFT) . ':00';
                $toTime = str_pad(($i + 1), 2, "0", STR_PAD_LEFT) . ':00';
                $allDaySch[$i]['from_time'] = $fromTime;
                $allDaySch[$i]['to_time'] = $toTime;
                $allDaySch[$i]['monday'] = 0;
                $allDaySch[$i]['tuesday'] = 0;
                $allDaySch[$i]['wednesday'] = 0;
                $allDaySch[$i]['thursday'] = 0;
                $allDaySch[$i]['friday'] = 0;
                $allDaySch[$i]['saturday'] = 0;
                $allDaySch[$i]['sunday'] = 0;
            }


            $finalSchedule = [];
            $unsetSKeys = [];

            $schA = [];
            $schB = [];

            foreach ($allDaySch as $key_a => $schA) {
                $array = $schA;
                foreach ($finalArrayA as $key_b => $schB) {
                    if ($array['from_time'] == $schB['from_time'] && $array['to_time'] == $schB['to_time']) {
                        if ($array['monday'] == 0) {
                            $array['monday'] = ($schB['monday'] == 1) ? $schB['monday'] : 0;
                        }

                        if ($array['tuesday'] == 0) {
                            $array['tuesday'] = ($schB['tuesday'] == 1) ? $schB['tuesday'] : 0;
                        }

                        if ($array['wednesday'] == 0) {
                            $array['wednesday'] = ($schB['wednesday'] == 1) ? $schB['wednesday'] : 0;
                        }

                        if ($array['thursday'] == 0) {
                            $array['thursday'] = ($schB['thursday'] == 1) ? $schB['thursday'] : 0;
                        }

                        if ($array['friday'] == 0) {
                            $array['friday'] = ($schB['friday'] == 1) ? $schB['friday'] : 0;
                        }

                        if ($array['saturday'] == 0) {
                            $array['saturday'] = ($schB['saturday'] == 1) ? $schB['saturday'] : 0;
                        }

                        if ($array['sunday'] == 0) {
                            $array['sunday'] = ($schB['sunday'] == 1) ? $schB['sunday'] : 0;
                        }

                        $unsetKeys[] = $key_b;
                    } else {
                        continue;
                    }
                }

                $finalSchedule[] = $array;
            }

            foreach ($unsetSKeys as $usk) {
                unset($finalSchedule[$usk]);
            }
        } else {
            for ($i = 0; $i < 24; $i++) {
                $fromTime = str_pad($i, 2, "0", STR_PAD_LEFT) . ':00';
                $toTime = str_pad(($i + 1), 2, "0", STR_PAD_LEFT) . ':00';
                $finalSchedule[$i]['from_time'] = $fromTime;
                $finalSchedule[$i]['to_time'] = $toTime;
                $finalSchedule[$i]['monday'] = 0;
                $finalSchedule[$i]['tuesday'] = 0;
                $finalSchedule[$i]['wednesday'] = 0;
                $finalSchedule[$i]['thursday'] = 0;
                $finalSchedule[$i]['friday'] = 0;
                $finalSchedule[$i]['saturday'] = 0;
                $finalSchedule[$i]['sunday'] = 0;
            }
        }

        return $finalSchedule;
    }

    public function edit($id)
    {
        $teacher = User::select('users.*', 'teacher_detail.*', 'users.id as id')
                    ->leftJoin('teacher_detail', 'users.id', '=', 'teacher_detail.user_id')
                    ->whereRaw("users.user_type LIKE 'teacher'")
                    ->where('users.id', $id)->first();

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

        $setting = Settings::getSettings();
        $locations = Locations::where('status', 1)->pluck('title', 'id')->toArray();

        return view('admin.teachers.edit', compact('degrees', 'countries', 'certificates', 'abilities', 'teacher', 'setting', 'locations'));
    }

    public function update(EditRequest $request, $id)
    {
        $input = $request->all();
        $validatedData = $request->validate([
			'video' => 'max:5120',
		]);
		
		$user = User::find($id);
        //$input['email'] = strtolower($input['email']);

        //$user->email        =  !empty($input['email']) ? $input['email'] : '';
        $user->firstname = !empty($input['firstname']) ? $input['firstname'] : '';
        $user->lastname = !empty($input['lastname']) ? $input['lastname'] : '';
        $user->contact_no = !empty($input['contact_no']) ? $input['contact_no'] : '';
        if (!empty($input['freshbook_user_id'])) {
            $user->freshbook_user_id = $input['freshbook_user_id'];
        }
        if (!empty($input['freshbook_task_id'])) {
            $user->freshbook_task_id = $input['freshbook_task_id'];
        }

        $user->freshbook_api_url = !empty($input['freshbook_api_url']) ? $input['freshbook_api_url'] : '';
        $user->freshbook_token = !empty($input['freshbook_token']) ? $input['freshbook_token'] : '';
        $user->paypal_email = !empty($input['paypal_email']) ? $input['paypal_email'] : '';
        $user->line_token = !empty($input['line_token']) ? $input['line_token'] : '';
        //$user->status = $input['status'];

		if ($input['status'] != 99) {
			if ($input['status'] == 5) {
				/*if (!empty($user->step2_verification_token)) {
					$input['in_training'] = 1;
					$input['is_ambassador'] = 1;
					$classroom = false;
					
					$password = str_random(10);
					$user->step2_verification_token = '';
					$user->password = Hash::make($password);
					$user->status = 1;
					$template = "emails.welcome";
					$subject = 'Welcome to '.env('APP_NAME');
					$data = ['user' => $user, 'password' => $password];
					if(env('IS_EMAIL_ENABLED') == 1){
						dispatch(new SendEmailJob($template, $data, $subject, 'user'));
					}
				} else {*/
					$user->step2_verification_token = str_random(60);
					$user->status = 7;
					$input['in_training'] = 1;
					$input['is_ambassador'] = 1;
					$template = "emails.teacher_recruitment_1";
					$subject = "New Teacher Recruitment Step I";
					$data = ['user' => $user];
					if(env('IS_EMAIL_ENABLED') == 1){
						dispatch(new SendEmailJob($template, $data, $subject, 'user'));
					}
				//}
			} else if ($input['status'] == 1 && !empty($user->step2_verification_token)) {
				$input['in_training'] = 1;
				$input['is_ambassador'] = 1;
				$input['is_available_in_trial'] = 1;
				$classroom = false;
				
				$password = str_random(10);
				$user->step2_verification_token = '';
				$user->password = Hash::make($password);
				$user->status = 1;
				$template = "emails.welcome";
				$subject = 'Welcome to '.env('APP_NAME');
				$data = ['user' => $user, 'password' => $password];
				if(env('IS_EMAIL_ENABLED') == 1){
					dispatch(new SendEmailJob($template, $data, $subject, 'user'));
				}
			} else {
				if (!empty($input['password'])) {
					$user->password = Hash::make($input['password']);
				}
			}
		}
//exit;

		if($input['status'] == 99) {
			$input['status'] = $user->status;
		}
		
        if ($request->has('image') && !empty($input['image'])) {
            $image = $input['image'];
            $image = str_replace('data:image/png;base64,', '', $image);
            $image = str_replace(' ', '+', $image);
            $imageName = str_random(10) . '.' . 'png';
            $image = base64_decode($image);

            if (!is_dir('uploads/users/teachers/' . $user->id)) {
                mkdir('uploads/users/teachers/' . $user->id);
            }

            $file_path = 'uploads/users/teachers/' . $user->id;

            $move = file_put_contents($file_path . '/' . $imageName, $image);

            if ($move) {
                $imageDel = parse_url($user->profile_image, PHP_URL_PATH);
                if (file_exists(public_path($imageDel))) {
                    File::delete(public_path($imageDel));
                }

                $user->profile_image = $file_path . '/' . $imageName;
            }
        } /*else{
            if(empty($user->image)){
                $user->profile_image =  url('').'/images/teacher_profile.png';
            }
        }*/

        $user->save();

        $teaching_certificate = (!empty($input['teaching_certificate'])) ? implode(',', $input['teaching_certificate']) : "";
        $lesson_minute_able_to_teach = (!empty($input['lesson_minute_able_to_teach'])) ? implode(',', $input['lesson_minute_able_to_teach']) : 0;

        $teaching_category = '';
        if (!empty($input['teaching_category'])) {
            $teaching_category = implode(',', $input['teaching_category']);
        }
        $highest_education = (!empty($input['highest_education'])) ? implode(',', $input['highest_education']) : "";

        if ($user->save()) {

            $userDetail = TeacherDetail::where('user_id', $user->id)->first();
            $userDetail->user_id = $user->id;
            $userDetail->dob = !empty($input['dob']) ? $input['dob'] : '';
            $userDetail->gender = !empty($input['gender']) ? $input['gender'] : '';
            $userDetail->state = !empty($input['state']) ? $input['state'] : '';;
            $userDetail->city = !empty($input['city']) ? $input['city'] : '';
            $userDetail->country = !empty($input['country']) ? $input['country'] : '';
            $userDetail->nationality = !empty($input['nationality']) ? $input['nationality'] : '';
            $userDetail->zipcode = !empty($input['zipcode']) ? $input['zipcode'] : 0;
            $userDetail->address_line1 = !empty($input['address_line1']) ? $input['address_line1'] : '';
            $userDetail->address_line2 = !empty($input['address_line2']) ? $input['address_line2'] : '';
            $userDetail->hobby = !empty($input['hobby']) ? $input['hobby'] : '';
            $userDetail->major_subject = !empty($input['major_subject']) ? $input['major_subject'] : '';
            $userDetail->teaching_certificate = !empty($teaching_certificate) ? $teaching_certificate : '';
            $userDetail->teaching_year_begun = !empty($input['teaching_year_begun']) ? $input['teaching_year_begun'] : 0;
            $userDetail->lesson_minute_able_to_teach = !empty($lesson_minute_able_to_teach) ? $lesson_minute_able_to_teach : 0;
            $userDetail->highest_education = !empty($highest_education) ? $highest_education : '';
            $userDetail->internet_connection_speed_link = !empty($input['internet_connection_speed_link']) ? $input['internet_connection_speed_link'] : '';
            $userDetail->skype_id = !empty($input['skype_id']) ? $input['skype_id'] : '';
            $userDetail->virtual_lesson_percentage = !empty($input['virtual_lesson_percentage']) ? $input['virtual_lesson_percentage'] : 0;
            $userDetail->cafe_lesson_percentage = !empty($input['cafe_lesson_percentage']) ? $input['cafe_lesson_percentage'] : 0;
            $userDetail->classroom_lesson_percentage = !empty($input['classroom_lesson_percentage']) ? $input['classroom_lesson_percentage'] : 0;
            $userDetail->kids_lesson_price = !empty($input['kids_lesson_price']) ? $input['kids_lesson_price'] : 0;
            $userDetail->aspire_lesson_price = !empty($input['aspire_lesson_price']) ? $input['aspire_lesson_price'] : 0;
            $userDetail->global_lesson_price = !empty($input['global_lesson_price']) ? $input['global_lesson_price'] : 0;
            //$userDetail->global_lesson_price = !empty($input['global_lesson_price']) ? number_format($input['global_lesson_price'],2) : 0;
            $userDetail->japanese_ability = !empty($input['japanese_ability']) ? $input['japanese_ability'] : '';
            $userDetail->jplt_score = !empty($input['jplt_score']) ? $input['jplt_score'] : 0;
            $userDetail->preferred_interview_method = !empty($input['preferred_interview_method']) ?
                $input['preferred_interview_method'] : '';
            $userDetail->is_remote_teaching = !empty($input['is_remote_teaching']) ? $input['is_remote_teaching'] : 0;
            $userDetail->message_en = !empty($input['message_en']) ? $input['message_en'] : '';
            $userDetail->message_jp = !empty($input['message_jp']) ? $input['message_jp'] : '';
            $userDetail->is_ambassador = !empty($input['is_ambassador']) ? $input['is_ambassador'] : 0;
            $userDetail->per_hour_salary = !empty($input['per_hour_salary']) ? $input['per_hour_salary'] : 0;
            $userDetail->onepage_certified = !empty($input['onepage_certified']) ? $input['onepage_certified'] : 0;
            $userDetail->coaching_certified = !empty($input['coaching_certified']) ? $input['coaching_certified'] : 0;
            $userDetail->is_teacher_salary_based = !empty($input['is_teacher_salary_based']) ? $input['is_teacher_salary_based'] : 0;
            $userDetail->temporarily_unavailable = !empty($input['temporarily_unavailable']) ? $input['temporarily_unavailable'] : 0;
            $userDetail->in_training   = !empty($input['in_training']) ? $input['in_training'] : 0;
            $userDetail->publish_profile   = !empty($input['publish_profile']) ? $input['publish_profile'] : 0;
            /* $userDetail->can_teacher_update_lesson_record = !empty($input['can_teacher_update_lesson_record']) ? $input['can_teacher_update_lesson_record'] : 0; */
            $userDetail->teacher_verified = !empty($input['is_teacher_verified']) ? $input['is_teacher_verified'] : 0;
            $userDetail->teaching_category = $teaching_category;
            $userDetail->is_available_in_trial = !empty($input['is_available_in_trial']) ? $input['is_available_in_trial'] : 0;
            $userDetail->pocket_wifi_available = !empty($input['pocket_wifi_available']) ? $input['pocket_wifi_available'] : 0;
            $userDetail->teaching_locations = !empty($input['teaching_locations']) ? implode(',', $input['teaching_locations']) : "";
			
			if(!empty($input['is_training_completed']) && $input['is_training_completed'] == 1) {
				$userDetail->is_training_completed   = !empty($input['is_training_completed']) ? $input['is_training_completed'] : 0;
				$kids_category_id = env('KIDS_CATEGORY_ID');
				$casual_category_id = env('CASUAL_CATEGORY_ID');
				if(isset($input['teaching_locations']) && in_array('classroom', $input['teaching_locations'])) { // assign kids and casual conversation services
					$category_id = [$casual_category_id, $kids_category_id];							
				} else { // assign casual conversation services
					$category_id = [$casual_category_id]; 
				}
				
				$casual_kids_service_ids  = Services::where('services.status', 1)
						->join('services_categories', 'services_categories.service_id', '=', 'services.id')
						->join('categories', 'categories.id', '=', 'services_categories.category_id')
						->whereIn('categories.id', [$casual_category_id, $kids_category_id])
						->where('categories.status', 1)
						->pluck('services.id');

				if ($casual_kids_service_ids){
					$casual_kids_service_ids = $casual_kids_service_ids->toArray();		
					//echo '<pre>';print_r($casual_kids_service_ids);exit;				
					$delete = TeacherServices::where('teacher_id', $user->id)->whereIn('service_id',$casual_kids_service_ids)->delete();
				}	
				
				$products  = Services::select('services.*')
						->where('services.status', 1)
						->join('services_categories', 'services_categories.service_id', '=', 'services.id')
						->join('categories', 'categories.id', '=', 'services_categories.category_id')
						->whereIn('categories.id', $category_id)
						->where('categories.status', 1)
						->get();
						
				if(!empty($products)) {
					foreach($products as $product) {
						TeacherServices::create([
							'teacher_id' => $id,
							'service_id' => $product->id,
							'is_deleted' => 0
						]);
					}
				}
			}

            /*if (!empty($input['teacher_locations'])){
                $oldLocations   = TeacherLocations::where('user_id',$user->id)->pluck('location_id');
                $oldLoc         = TeacherLocations::where('user_id',$user->id)->get();

                if ($oldLocations){
                    $oldLocations = $oldLocations->toArray();
                }

                $deleteArray = array_diff($oldLocations,$input['teacher_locations']);
                $insertArray = array_diff($input['teacher_locations'],$oldLocations);

                TeacherLocations::where('user_id',$user->id)->whereIn('location_id',$deleteArray)->update(['is_deleted' => 1]);
                TeacherLocations::where('user_id',$user->id)->whereNotIn('location_id',$deleteArray)->update(['is_deleted' => 0]);

                foreach ($insertArray as $Lkey => $location_id){
                    TeacherLocations::create([
                        'user_id'       => $user->id,
                        'location_id'   => $location_id,
                        'is_deleted'    => 0
                    ]);
                }
            }else{

                $oldLocations = TeacherLocations::where('user_id',$user->id)->pluck('location_id');
                if (!empty($oldLocations)){
                    if ($oldLocations){
                        $oldLocations = $oldLocations->toArray();
                    }
                    TeacherLocations::where('user_id',$user->id)
                                    ->whereIn('location_id',$oldLocations)
                                    ->update(['is_deleted' => 1]);
                }
            }
            */
            if ($request->has('audio_attachment')) {
                $afile = $request->file('audio_attachment');
                $afile_name = time() . $afile->getClientOriginalName();
                $afile_path = 'uploads/users/teachers/' . $user->id . '/attachment';
                $amove = $afile->move($afile_path, $afile_name);
                if ($amove) {
                    if (file_exists(public_path($userDetail->audio_attachment))) {
                        File::delete(public_path($userDetail->audio_attachment));
                    }

                    $userDetail->audio_attachment = $afile_path . '/' . $afile_name;
                }
            }

            $userDetail->save();
			
			
			if($user && $request->has('video')){
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
        }
		
		

        $request->session()->flash('message', 'Teacher Detail Updated Successfully');
        return response()->json(['type' => 'success', 'message' => 'Teacher Detail Updated Successfully', 'redirect' => route('admin.teachers.index')]);
        //return redirect()->route('admin.teachers.index')->with('message', 'Teacher Updated Successfully');
    }

    public function destroy($id, Request $request)
    {
        if($id == 'all'){
            $delete = User::whereIn('id',$request->id)->delete();
        } else {

            $user = User::findOrFail($id);


            if ($user->profile_image) {
                /*if (url('') == "http://127.0.0.1:8000") {
                    $old = explode('/', $user->profile_image);
                    $i = 3;
                    $oldurl = "";
                    foreach ($old as $key => $value) {
                        if ($key > 2) {
                            $oldurl .= $value . '/';
                        }
                    }
                    $oldurl = rtrim($oldurl, '/');
                    if (file_exists(public_path($oldurl))) {
                        File::delete(public_path($oldurl));
                    }
                }*/
                $image = parse_url($user->profile_image, PHP_URL_PATH);
                if (file_exists(public_path($image))) {
                    File::delete(public_path($image));
                }
            }
            $user->delete();
        }

        $request->session()->flash('message', 'Teacher Deleted Successfully.');
        return response()->json([
            'success' => 'success',
            'message' => 'Teacher Deleted Successfully.'

        ]);

    }

    public function getCities(Request $request)
    {
        $citySql = City::query();

        if ($request->has('state')) {
            $citySql->where('id_state', $request->state);
        }

        $citySql->orderBy('city');

        $cities = $citySql->pluck('city', 'id');

        $citiesHtml = View::make("admin.users.cities")->with('cities', $cities)->render();

        return response()->json(['citiesHtml' => $citiesHtml]);
    }

    public function attachment($id)
    {
        $teacher = User::find($id);
        $teacherDetail = (TeacherDetail::where('user_id', $id)->get()->toArray())[0];
        $teacherAtt = TeacherAttachment::where('user_id', $id)->get();
        $attachments = [];
        if (!empty($teacherAtt)) {
            $attachments = $teacherAtt->toArray();
        }

        /*  echo "<pre>";
           print_r($teacherDetail);
           echo "</pre>";
           die;*/

        return view('admin.teachers.attachment', compact('teacher', 'attachments', 'teacherDetail'));
    }

    public function location($id)
    {

        $teacher = User::find($id)->toArray();
        $teacherDetail = TeacherDetail::where('user_id', $id)->first()->toArray();
        $locations = Locations::where('status', 1)->pluck('title', 'id')->toArray();
        $services = Services::where('status', 1)->pluck('title', 'id')->toArray();

        $teacherLocations = TeacherLocations::where('user_id', $id)
            ->where('is_deleted', 0)
            ->pluck('location_id');

        if ($teacherLocations) {
            $teacherLocations = $teacherLocations->toArray();
        }

        $teacherServices = TeacherServices::where('teacher_id', $id)
            ->where('is_deleted', 0)
            ->pluck('service_id');

        if ($teacherServices) {
            $teacherServices = $teacherServices->toArray();
        }

        return view('admin.teachers.location', compact('teacher', 'teacherLocations', 'teacherServices', 'locations', 'services', 'teacherDetail'));
    }

    public function addLocationService(Request $request, $id)
    {
        $input = $request->all();
        $user_id = $id;

        $is_available_in_trial = !empty($input['is_available_in_trial']) ? $input['is_available_in_trial'] : 0;
        $teacherDetail = TeacherDetail::where('user_id', $user_id)
            ->update(['is_available_in_trial' => $is_available_in_trial]);

        if (!empty($input['locations'])) {
            $oldLocations = TeacherLocations::where('user_id', $user_id)->pluck('location_id');
            $oldLoc = TeacherLocations::where('user_id', $user_id)->get();

            if ($oldLocations) {
                $oldLocations = $oldLocations->toArray();
            }

            $deleteArray = array_diff($oldLocations, $input['locations']);
            $insertArray = array_diff($input['locations'], $oldLocations);

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
                }
                TeacherLocations::where('user_id', $user_id)
                    ->whereIn('location_id', $oldLocations)
                    ->update(['is_deleted' => 1]);
            }
        }

        if (!empty($input['services'])) {
            $oldServices = TeacherServices::where('teacher_id', $user_id)->pluck('service_id');
            $oldLoc = TeacherServices::where('teacher_id', $user_id)->get();

            if ($oldServices) {
                $oldServices = $oldServices->toArray();
            }

            $deleteArray = array_diff($oldServices, $input['services']);
            $insertArray = array_diff($input['services'], $oldServices);

            TeacherServices::where('teacher_id', $user_id)->whereIn('service_id', $deleteArray)->update(['is_deleted' => 1]);
            TeacherServices::where('teacher_id', $user_id)->whereNotIn('service_id', $deleteArray)->update(['is_deleted' => 0]);

            foreach ($insertArray as $Lkey => $service_id) {
                TeacherServices::create([
                    'teacher_id' => $user_id,
                    'service_id' => $service_id,
                    'is_deleted' => 0
                ]);
            }
        } else {
            $oldServices = TeacherServices::where('teacher_id', $user_id)->pluck('service_id');
            if (!empty($oldServices)) {
                if ($oldServices) {
                    $oldServices = $oldServices->toArray();
                }
                TeacherServices::where('teacher_id', $user_id)
                    ->whereIn('service_id', $oldServices)
                    ->update(['is_deleted' => 1]);
            }
        }
        return redirect(route('admin.teachers.index'))->with('message', 'Location/Service Detail Updated Successfully');
    }

    public function getSchedule(Request $request, $id)
    {
        $user_id = $id;


        $teacher = User::where('id', $user_id)->first();

        $teacherSch = TeacherSchedule::where('user_id', $user_id)->orderBy('id', 'ASC')->get();
        $teacherExc = TeacherScheduleException::where('user_id', $user_id)->orderBy('id', 'ASC')->get();

        $teacherDetails = $teacher->details()->first();

        $locations = Locations::where('status', 1)->pluck('title', 'id')->toArray();
        $services = Services::where('status', 1)->whereRaw('service_type IS NULL')->pluck('title', 'id')->toArray();

        $icalLink = TeacherIcal::where('teacher_id', $user_id)->get();
//        $ical_link = '';
//        if (!empty($icalLink)) {
//            $ical_link = $icalLink->ical_link;
//        }

        $teacherLocations = TeacherLocations::where('user_id', $id)
            ->where('is_deleted', 0)
            ->pluck('location_id');

        if ($teacherLocations) {
            $teacherLocations = $teacherLocations->toArray();
        }

        $teacherServices = TeacherServices::where('teacher_id', $id)
            ->where('is_deleted', 0)
            ->pluck('service_id');

        if ($teacherServices) {
            $teacherServices = $teacherServices->toArray();
        }

        return view('admin.teachers.settings.schedule', compact('teacher', 'teacherSch', 'teacherDetails', 'teacherExc', 'teacherLocations', 'teacherServices', 'locations', 'services', 'icalLink'));
    }

    public function updateSchedule(Request $request, $id)
    {
        $input = $request->all();

        //$exceptions = $this->generateSchedule($input['exception']);

        $user_id = $id;
        $teacher = User::where('id', $user_id)->first();

        $teacherDetails = $teacher->details()->first();

        $teacherDetails->lesson_minute_able_to_teach = !empty($input['lesson_minute_able_to_teach']) ? implode(',', $input['lesson_minute_able_to_teach']) : "";
        $teacherDetails->book_before_time = $input['book_before_time'];
        $teacherDetails->cancel_before_time = $input['cancel_before_time'];
        $teacherDetails->google_calender_link = !empty($input['google_calender_link']) ? $input['google_calender_link'] : '';
        $teacherDetails->calendar_color = !empty($input['calendar_color']) ? $input['calendar_color'] : '';
        $teacherDetails->can_teacher_update_lesson_record = !empty($input['can_teacher_update_lesson_record']) ? $input['can_teacher_update_lesson_record'] : 0;

        $permission = '';
        if (!empty($input['permission'])) {
            $permission = implode(',', $input['permission']);
        }

        $teacherDetails->permission = $permission;
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

        //Update loactions & services

        /* $is_available_in_trial = !empty($input['is_available_in_trial']) ? $input['is_available_in_trial'] : 0;
         $teacherDetail = TeacherDetail::where('user_id', $user_id)
                         ->update(['is_available_in_trial' => $is_available_in_trial]);
 */
        if (!empty($input['locations'])) {
            $oldLocations = TeacherLocations::where('user_id', $user_id)->pluck('location_id');
            $oldLoc = TeacherLocations::where('user_id', $user_id)->get();

            if ($oldLocations) {
                $oldLocations = $oldLocations->toArray();
            }

            $deleteArray = array_diff($oldLocations, $input['locations']);
            $insertArray = array_diff($input['locations'], $oldLocations);

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
                }
                TeacherLocations::where('user_id', $user_id)
                    ->whereIn('location_id', $oldLocations)
                    ->update(['is_deleted' => 1]);
            }
        }

        if (!empty($input['services'])) {
            $oldServices = TeacherServices::where('teacher_id', $user_id)->pluck('service_id');
            $oldLoc = TeacherServices::where('teacher_id', $user_id)->get();

            if ($oldServices) {
                $oldServices = $oldServices->toArray();
            }

            $deleteArray = array_diff($oldServices, $input['services']);
            $insertArray = array_diff($input['services'], $oldServices);

            TeacherServices::where('teacher_id', $user_id)->whereIn('service_id', $deleteArray)->update(['is_deleted' => 1]);
            TeacherServices::where('teacher_id', $user_id)->whereNotIn('service_id', $deleteArray)->update(['is_deleted' => 0]);

            foreach ($insertArray as $Lkey => $service_id) {
                TeacherServices::create([
                    'teacher_id' => $user_id,
                    'service_id' => $service_id,
                    'is_deleted' => 0
                ]);
            }
        } else {
            $oldServices = TeacherServices::where('teacher_id', $user_id)->pluck('service_id');
            if (!empty($oldServices)) {
                if ($oldServices) {
                    $oldServices = $oldServices->toArray();
                }
                TeacherServices::where('teacher_id', $user_id)
                    ->whereIn('service_id', $oldServices)
                    ->update(['is_deleted' => 1]);
            }
        }

        $cal_link_array = !empty($input['google_calendar_link']) ? $input['google_calendar_link'] : [];
        TeacherIcal::where('teacher_id', $user_id)->delete();
        if (count($cal_link_array) > 0) {
            foreach ($cal_link_array as $link) {
                $icalData['teacher_id'] = $user_id;
                $icalData['ical_link'] = $link;

                TeacherIcal::create($icalData);
            }


        }

        $request->session()->flash('message', 'Teacher Schedule Updated Successfully');
        return response()->json(['type' => 'success', 'message' => 'Teacher Schedule Updated Successfully', 'redirect' => route('admin.teachers.index')]);
        /*
                $html = view('admin.teachers.index')->render();
                return response()->json(['type' => 'success', 'message' => 'Teacher Schedule Updated Successfully', 'html' => $html]);*/

        /* return redirect()->route('admin.teachers.index')->with('message', 'Teacher Schedule Updated Successfully');*/


        /* $teacher            = User::where('id', $user_id)->first();
         $teacherSch         = TeacherSchedule::where('user_id', $user_id)->orderBy('id','ASC')->get();
         $teacherDetails     = $teacher->details()->first();
         $locations          = Locations::where('status',1)->pluck('title','id')->toArray();
         $teacherLocations   = TeacherLocations::where('user_id',$user_id)->where('is_deleted',0)->pluck('location_id')->toArray();
         $teacherExc         = TeacherScheduleException::where('user_id', $user_id)->orderBy('id','ASC')->get();

         $html = view('teachers.settings.index.schedule',compact('teacher','teacherSch','teacherDetails','locations','teacherLocations','teacherExc'))->render();

         return response()->json(['type' => 'success', 'message' => 'Schedule updated successfully.', 'html' => $html]);*/
    }

    public function getEarning(Request $request, $id)
    {
        $teacher_id = $id;
        return view('admin.teachers.earnings.index', compact('teacher_id'));
    }

    public function getEarningDetail(Request $request)
    {
        $input = $request->all();
        $teacher_id = $input['teacher_id'];
        $teacher_bookings = StudentLessonsBooking::where('teacher_id', $teacher_id)
            ->with('teacher', 'student', 'service');

        return DataTables::of($teacher_bookings)
            ->addIndexColumn()
            /*->editColumn('student', function ($teacher_bookings) {
                return $teacher_bookings['student']['firstname'].' '.$teacher_bookings['student']['lastname'];
            })*/
            // ->editColumn('service', function ($teacher_bookings) {
            //     return $teacher_bookings['service']['title'];
            // })
            /* ->editColumn('teacher_earnings', function ($teacher_bookings) {
                 $earning = !empty($teacher_bookings['teacher_earnings']) ? $teacher_bookings['teacher_earnings'] : 0;
                 return $earning;
             })*/
            /* ->editColumn('date', function ($teacher_bookings) {
                 $date = Carbon::parse($teacher_bookings['created_at'])->format('d-M-Y');
                 return $date;
             })*/
            ->editColumn('created_at', function ($teacher_bookings) {
                return Carbon::parse($teacher_bookings['created_at'])->format('M d,Y');
            })
            ->filter(function ($query) use ($request) {
                if (!empty($request->get('from')) && !empty($request->get('to'))) {
                    $from = date('Y-m-d', strtotime($request->get('from')));
                    $to = date('Y-m-d', strtotime($request->get('to')));

                    $query->whereRaw("date(created_at) between '" . $from . "' and'" . $to . "'");
                } else if (!empty($request->get('from'))) {
                    $from = date('Y-m-d', strtotime($request->get('from')));
                    $query->where('created_at', '>=', $from)->get();
                } else if (!empty($request->get('to'))) {
                    $to = date('Y-m-d', strtotime($request->get('to')));
                    $query->where('created_at', '<=', $to)->get();
                }
            })
            ->rawColumns(['student', 'service', 'earning', 'date'])
            ->make(true);
        /*  echo "<pre>";
          print_r($input['teacher_id']);
          echo "</pre>";
          die;*/

    }

    public function generateIcal($teacher_id) {
        $user_id = $teacher_id;
        $teacher = User::where('id', $user_id)->first();
        $teacherDetails = $teacher->details()->first();

        $teacherLessons = StudentLessonsBooking::select([
            'student_lessons_bookings.*',
            DB::raw("CONCAT(users.firstname, ' ', users.lastname) AS student_name"),
            DB::raw("CONCAT(location.title, '.', location.title_jp) AS location"),
            'services.title AS service',
            DB::raw("'0' AS earnings"),
        ])->where('teacher_id', $user_id)
            ->leftJoin('users', 'users.id', 'student_lessons_bookings.user_id')
            ->leftJoin('location', 'location.id', 'student_lessons_bookings.location_id')
            ->leftJoin('services', 'services.id', 'student_lessons_bookings.service_id')->get();

        // $tz = "Europe/Stockholm";
        //     // set Your unique id,
        //     // required if any component UID is missing
        // $config = [
        //     Util::$UNIQUE_ID => "kigkonsult.se",
        //         // opt. set "calendar" timezone
        //     Util::$TZID      => $tz
        // ];
        // // create a new calendar object instance
        // $vcalendar = new Vcalendar( $config );

        // // required of some calendar software
        // $vcalendar->setProperty( Util::$METHOD,   "PUBLISH" );
        // $vcalendar->setProperty( "x-wr-calname",  "Calendar Sample" );
        // $vcalendar->setProperty( "X-WR-CALDESC",  "Calendar Description" );
        // $vcalendar->setProperty( "X-WR-TIMEZONE", $tz );

        $vcalendar = Vcalendar::factory()
                    ->setMethod( Vcalendar::PUBLISH )
                    ->setXprop(
                        Vcalendar::X_WR_CALNAME,
                        env('APP_NAME')." calender"
                    )
                    ->setXprop(
                        Vcalendar::X_WR_CALDESC,
                        env('APP_NAME')." calender"
                    )
                    ->setXprop(
                        Vcalendar::X_WR_RELCALID,
                        "3E26604A-50F4-4449-8B3E-E4F4932D05B5"
                    )
                    ->setXprop(
                        Vcalendar::X_WR_TIMEZONE,
                        "Asia/Tokyo"
                    );
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

    public function deleteAllTeachers(Request $request){
        dd('yesss');
    }
}
