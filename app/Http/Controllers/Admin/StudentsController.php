<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\AppHelper;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use Yajra\DataTables\DataTables;
use App\Models\StudentDetail;
use App\Models\StudentPackages;
use Asana\Client;
use Auth;
use App\Jobs\SendEmailJob;
use App\Helpers\ZohoHelper;
use App\Helpers\MailerliteHelper;
use Newsletter;

class StudentsController extends Controller
{
    public function index()
    {
        //To get account id from freshbook
        /*$curl = curl_init();

        curl_setopt_array($curl, array(
          CURLOPT_URL => "https://api.freshbooks.com/auth/api/v1/users/me",
          CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
          CURLOPT_CUSTOMREQUEST => "GET",
          CURLOPT_HTTPHEADER => array(
            'Content-Type: application/json',
            'Authorization: Bearer 03910ad1b5bc304c6cf2289f58a6b42d4f09b833c01531e84b703352f650103b', 
            'Api-Version: alpha'
          ),
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {
          echo "cURL Error #:" . $err;
        } else {
          echo $response;
        }
        die;*/
        return view('admin.students.index');
    }

    public function getStudents(Request $request)
    {
        $students = User::select('id', 'firstname', 'lastname', 'email', 'contact_no', 'status', 'profile_image')
            ->where('user_type', 'student');

        return Datatables::of($students)
            ->filter(function ($query) use ($request) {
                if (!empty($request->get('firstname'))) {
                    $query->whereRaw("LOWER(firstname) like '%" . strtolower($request->get('firstname')) . "%'");
                }
                if (!empty($request->get('lastname'))) {
                    $query->whereRaw("LOWER(lastname) like '%" . strtolower($request->get('lastname')) . "%'");
                }

                if (!empty($request->get('email'))) {
                    $query->whereRaw("LOWER(email) like '%" . strtolower($request->get('email')) . "%'");
                }

                if (!empty($request->get('status'))) {
                    $query->where("status", $request->get('status'));
                }
            })
            ->addIndexColumn()
            ->addColumn('case', function ($users) {
                return '<input type="checkbox" name="select" value="'.$users->id.'" onclick="checked_chkbx('.$users->id.')"  class="case" id="chk_'. $users->id .'">';
            })
            ->editColumn('status', function ($students) {
                if ($students->status == 1) {
                    return '<span class="badge badge-gradient-success badge-pill">Active</span>';
                } else if ($students->status == 3) {
                    return '<span class="badge badge-gradient-danger badge-pill">Inactive</span>';
                } else if ($students->status == 4) {
                    return '<span class="badge badge-gradient-dark badge-pill">Deleted</span>';
                }
            })
            /*->editColumn('profile_image', function ($students) {
				if ($students->profile_image) {
					return url('uploads/profile/'.$students->profile_image);
				} else {
					return url("uploads/profile/default.png");
				}
            })*/
            //->addColumn('service','service')
            ->addColumn('action', function ($students) {
                $editButton = '';
                $authUser = auth()->user();

                $package = StudentPackages::where('user_id', $students->id)
                                    ->whereRaw("start_date <= '".date('Y-m-d')."'::date")
                                    ->whereRaw("end_date >= '".date('Y-m-d')."'::date")
                                    ->where('status', 'active')
                                    ->first();

                if ($students->status != 4) {
                    $editButton .= '<a href="' . route('admin.students.edit', $students->id) . '" class="btn btn-outline-info btn-rounded btn-icon edit-row" data-toggle="tooltip" title="Edit" data-original-title="Edit"><i class="mdi mdi-pencil-box" aria-hidden="true"></i></a>';


                    $editButton .= '<a id="' . $students->id . '" class="btn btn-outline-danger btn-rounded btn-icon remove-row deleteStudent" data-toggle="tooltip" title="Delete" data-original-title="Delete"><i class="mdi mdi-delete" aria-hidden="true"></i></a>';

                    if(!empty($package)){
                        $editButton .= '<a href="' . route('admin.students.points', $students->id) . '" class="btn btn-outline-info btn-rounded btn-icon edit-row" data-toggle="tooltip" title="Points" data-original-title="Points"><i class="mdi mdi-cash" aria-hidden="true"></i></a>';
                    }
                }
                return $editButton;
            })
            ->rawColumns(['case','status', 'action'])
            ->make(true);
    }

    public function create()
    {
        $type = 'create';
        return view('admin.students.create', compact('type'));
    }

    public function store(Request $request)
    {
        $student = new User();
        $request->validate([
            'firstname' => 'required',
            'lastname' => 'required',
            'email' => 'required|unique:users,email',
            'password' => 'required',
            'contact_no' => 'required',
            'status' => 'required',
            //'profile_image' => 'mimes:jpeg,png'
        ]);

        $asanaToken = env('ASANA_TOKEN');
        $workspaceId = env('ASANA_WORKSPACE_ID');
        $client = Client::accessToken($asanaToken); // Change When Upload to client's server

        //$project = $client->projects->createInWorkspace($workspaceId, array('name' => $request->firstname . " " . $request->lastname));

        $create = [
            'firstname' => $request->firstname,
            'lastname' => $request->lastname,
            'email' => $request->email,
            'contact_no' => $request->contact_no,
            'status' => $request->status,
            'user_type' => 'student',
            'student_level_id' => isset($request->student_level_id) ? $request->student_level_id : 9,
        ];

        if ($request->password != '') {
            $create['password'] = bcrypt($request->password);
        }

        $newStudent = $student->create($create);
		$student_name = $request->firstname . " " . $request->lastname;
		$firstname = $request->firstname;
		$lastname = $request->lastname;
		$email = $request->email;
		$phone = isset($request->contact_no) ? $request->contact_no : '';

        if ($newStudent) {

			$student = User::find($newStudent->id);
			if(env('IS_ASANA_ENABLED') == 1 && strtolower($firstname) != 'panacea') {
				$project = $client->projects->createInWorkspace(
					$workspaceId,
					array(
						'name' => $student_name
					)
				);            
				$student->asana_project_id = !empty($project->gid) ? $project->gid : '';			
				$task = $client->tasks->createInWorkspace(
					$workspaceId,
					array(
						'name'          => $student_name . " New Lokalingo Registration.",
						'notes'         => "Email : ".$email.", Contact : ".$request->contact_no,
					)
				);

				$client->tasks->addProject(
					$task->gid,
					array(
						'project' => $project->gid
					)
				);
			}
			
			if(env('IS_ZOHO_ENABLED') == 1 && strtolower($firstname) != 'panacea') {
				$jsondata = '{"contact_name": '.$student_name.', "company_name": '.$student_name.', "contact_persons": [{"email":'.$email.',"first_name":'.$firstname.',"last_name":'.$lastname.', "phone":'.$phone.'}]}';
				$output = ZohoHelper::createInvoiceCustomer($jsondata);
				if($output['code'] == 0) {
					$zoho_user_id = $output['contact']['contact_id'];
					$student->zoho_user_id = $zoho_user_id;
					$contact_person_id = $output['contact']['contact_persons'][0]['contact_person_id'];
					$jsondata = '{"contact_persons": [{"contact_person_id": '.$contact_person_id.'}]}';
					$enable_output = ZohoHelper::enableportal($jsondata, $zoho_user_id);
				}
			}
            $student->save();

            $gcon = AppHelper::createGoogleContact($student->toArray());

            //Create Folder In Google drive

            /*$folderId = env('MAIN_FOLDER_ID_GDRIVE');
            $name = $student['firstname'] . ' ' . $student['lastname'];
            $fileId = AppHelper::createFolderInFolder($folderId, $name);
            $student->drive_folder_id = $fileId;
            $student->save();

            AppHelper::createFolderInFolder($fileId, 'Progress Homework | ' . $name);
            AppHelper::createFolderInFolder($fileId, 'Accent OnePage | ' . $name);
            AppHelper::createFolderInFolder($fileId, 'Archive | ' . $name);*/

            $studentDetail = new StudentDetail();
            $studentDetail->user_id = $newStudent['id'];
            $studentDetail->hide_price = !empty($request->hide_price) ? $request->hide_price : 0;
			$studentDetail->save();		

            //Newsletter::subscribe($email, ['FNAME'=>$firstname, 'LNAME'=>$lastname], 'subscribers');
			MailerliteHelper::createSubscriber_student($email, $student_name, $phone);
        }

        return redirect(route('admin.students.index'))->with('message', 'Student Created Successfully');
    }

    public function show($id)
    {
        $student = User::find($id);
        return view('admin.students.show', compact('student'));
    }

    public function edit($id)
    {
        $student = User::find($id);
        $studentDetail = StudentDetail::where('user_id',$id)->first();
        if ($student->status == 4) {
            return redirect(404);
        }
        return view('admin.students.edit', compact('student','studentDetail'));
    }

    public function update(Request $request, $id)
    {
        $input = $request->all();
      
        $student = User::find($id);
        $request->validate([
            'firstname' => 'required',
            'lastname' => 'required',
            //'email'  => 'required|email|unique:users,email,'.$id,
           // 'password' => 'required',
            'contact_no' => 'required',
            'status' => 'required',
            'profile_image' => 'mimes:jpeg,png'
        ]);
        $update = [
            'firstname' => $request->firstname,
            'lastname' => $request->lastname,
          //  'email' => $request->email,
            'contact_no' => $request->contact_no,
            'status' => $request->status,
            'student_level_id' => isset($request->student_level_id) ? $request->student_level_id : 9,
        ];
        if ($request->password != '') {
            $update['password'] = bcrypt($request->password);
        }
        /*if ($request->has('profile_image')) {
            $file = $request->file('profile_image');
            $file_name = time() . $file->getClientOriginalName();
            $update['profile_image'] = $file_name;
            $file_path = public_path('uploads/profile');
            $file->move($file_path, $file_name);
        }*/
        $student->update($update);
        $studentDetail = StudentDetail::where('user_id',$id)->first();
        $studentDetail->hide_price = !empty($input['hide_price']) ? $input['hide_price'] : 0;
        $studentDetail->save();

        return redirect(route('admin.students.index'))->with('message', 'Student Updated Successfully');
    }

    public function destroy(Request $request, $id)
    {
        if($id == 'all'){
            $students = User::whereIn('id',$request->id)->get()->pluck('id')->toArray();
            foreach ($students as $student_id){
                $student_data = User::find($student_id);
                if (!empty($student_data)) {
                    $student_data->update(['status' => 4]);
                }
            }
            if(!empty($students)){
                $request->session()->flash('message', 'Student Deleted Successfully.');
                return response()->json([
                    'success' => 'success',
                    'message' => 'Student Deleted Successfully.'
                ]);
            }  else {
                $request->session()->flash('message', 'Student not found.');
                return response()->json(['success' => 'success']);
            }

        } else {

            $student = User::find($id);

            if (!empty($student)) {

                $student->update(['status' => 4]);

                $request->session()->flash('message', 'Student Deleted Successfully');
                return response()->json(['success' => 'success']);

            } else {
                $request->session()->flash('message', 'Student not found.');
                return response()->json(['success' => 'success']);
            }

        }

    }

    public function points($id)
    {
        $student = User::select( 'users.*', 'student_details.*', 'users.id as id' )
                    ->leftJoin('student_details', 'users.id','=','student_details.user_id')
                    ->where('users.id', $id)->first();


        if ($student->status == 4) {
            return redirect(404);
        }

        return view('admin.students.points', compact('student'));
    }

    public function updatePoints(Request $request, $id)
    {
        $input = $request->all();
        $authUser = Auth::user();
        $student = User::find($id);
        $studentDetail = StudentDetail::where('user_id', $id)->first();
        $request->validate([
            'reward_points' => 'numeric'
        ]);

        $reward_points = !empty($input['reward_points']) ? $input['reward_points'] : 0;

        $studentDetail->reward_balance = $reward_points;
        $studentDetail->save();

        if(!empty($student->email) && ($reward_points != 0)){
            $template = "admin.emails.point-sent-email";
            $subject = "Reward Points By LokaLingo";
            $data = ['user' => $authUser, 'receiver' => $student, 'amount' => $reward_points];
            dispatch(new SendEmailJob($template, $data, $subject,'point_mail'));
        }

        return redirect(route('admin.students.index'))->with('message', 'Student Reward Points Updated Successfully');
    }

}
