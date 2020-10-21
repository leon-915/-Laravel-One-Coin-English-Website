<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\AdminUser;
use App\Http\Requests\Admin\AdminUser\AddRequest;
use App\Http\Requests\Admin\AdminUser\EditRequest;
use App\Http\Requests\Admin\AdminUser\EditProfile;

use Spatie\Permission\Models\Role;
use Yajra\Datatables\DataTables;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use Carbon\Carbon;
use Illuminate\Support\Facades\File;

use DB;
use Hash;
use Auth;
use Mail;
use PDF;

use App\Jobs\SendEmailJob;

class AdminUsersController extends Controller
{
    function __construct() {
        //$this->guard('admin')->middleware('permission:admin-user-list');
        // $this->middleware('permission:admin-user-create', ['only' => ['create','store']]);
        // $this->middleware('permission:admin-user-edit', ['only' => ['edit','update']]);
        // $this->middleware('permission:admin-user-delete', ['only' => ['destroy']]);
    }

    public function index(Request $request) {

        //$roles = Role::orderBy('id', 'ASC')->pluck('name', 'name')->all();
        $roles = ['Admin' => 'Admin','Sub Admin' => 'Sub Admin'];

        return view('admin.admin-users.index', compact('roles'));
    }

    public function getusers(Request $request) {
        $input = $request->all();
        $users = AdminUser::where('id', '!=', Auth::guard('admin')->id());

        if ($request->has('name') && $request->name != null) {
            $users->whereRaw("LOWER(name) LIKE '%" . strtolower($request->name) . "%'");
        }

        if ($request->has('email') && $request->email != null) {
            $users->whereRaw("LOWER(email) LIKE '%" . strtolower($request->email) . "%'");
        }

        if ($request->has('status') && $request->status != null) {
            $users->where('status', $request->status);
        }

        if ($request->has('role') && $request->role != null) {
            $users->where('role', $request->role);
        }

        //$users->orderBy('id','desc');
       // dd($users->get());
        return Datatables::of($users)
            //->addIndexColumn()
            ->addColumn('case', function ($users) {
                return '<input type="checkbox" name="select" value="'.$users->id.'" onclick="checked_chkbx('.$users->id.')"  class="case" id="chk_'. $users->id .'">';

            })
            ->addColumn('action', function ($user) {
                $editButton = '';
                $editButton .= '<a href="' . route('admin-users.edit', $user->id) . '" class="btn btn-outline-info btn-rounded btn-icon edit-row" title="Edit"
                    data-toggle="tooltip" title="Edit" data-original-title="Edit"><i class="mdi mdi-pencil-box" aria-hidden="true"></i></a>';
                $editButton .= '<a id="' . $user->id . '" class="btn btn-outline-danger btn-rounded btn-icon remove-row deleteUser" data-toggle="tooltip" title="cancel" data-original-title="Delete"><i class="mdi mdi-delete" aria-hidden="true"></i></a>';
                return $editButton;
            })
            ->editColumn('status', function ($user) {
                if($user->status == 1){
                    return '<span class="badge badge-success badge-pill">Active</span>';
                } else if($user->status == 2) {
                    return '<span class="badge badge-danger badge-pill">Inactive</span>';
                } else if ($user->status == 3) {
                    return '<span class="badge badge-warning badge-pill">Suspended</span>';
                }
            })
            ->rawColumns(['case','status','action'])
            ->make(true);
    }

    public function create() {
        $roles = ['Admin' => 'Admin','sub_admin' => 'Sub Admin'];
        $userRole = array();
        $formType = 'create';
        return view('admin.admin-users.create', compact('roles', 'formType', 'userRole'));
    }

    public function store(AddRequest $request) {

        $input = $request->all();
        $roles = $request->get('roles');
        $input['role'] = !empty($roles) ? current($roles) : 'Admin';
        $password = $input['password'];
        $input['password'] = Hash::make($input['password']);
        $input['email'] = strtolower($input['email']);
        $user = AdminUser::create($input);

        //$user->assignRole($request->get('roles', [0 => 'Admin']));

        /*Mail::send('emails.welcome', compact('user','password'), function ($message) use ($user,$pdfArray) {
            $pdf = PDF::loadView('invoice.pdf', array('pdfArray' => $pdfArray));
            $message->to($user->email)
                ->from('jui.shah@trootech.com')
                ->subject('Welcome to Loyalty App');
            $message->attachData($pdf->output(),$pdfArray['invoice']['invoice_id'].'.pdf');
        });*/


       /* $template = "admin.emails.welcome";
        $subject = "Welcome to Lokalingo.";
        $data = ['user' => $user, 'password' => $password];
        dispatch(new SendEmailJob($template, $data, $subject));*/

        Session::flash('message', 'User Created Successfully');
        return redirect()->route('admin-users.index');
    }

    public function show($id) {
        $user = AdminUser::find($id);
        return view('admin.admin-users.show', compact('user'));
    }

    public function userdetail(Request $request) {
        $id = $request->id;
        $user = AdminUser::where('id', $id)->with('roles')->first();
        $returnHTML = view('admin.admin-users.show')->with('user', $user)->render();

        return response()->json(array(
                'success' => true,
                'returnHTML' => $returnHTML
            )
        );
    }

    public function edit($id) {

        $user = AdminUser::find($id);
        $roles = ['Admin' => 'Admin','Sub Admin' => 'Sub Admin'];
        $userRole = $user->pluck('role', 'role')->all();
        //dd($userRole,$roles,$user->role);

        $formType = 'edit';
        return view('admin.admin-users.edit', compact('user', 'roles', 'userRole', 'formType'));
    }

    public function update(EditRequest $request, $id) {

        $input = $request->all();
        if (!empty($input['password'])) {
            $input['password'] = Hash::make($input['password']);
        } else {
            $input = array_except($input, array('password'));
        }

        $user = AdminUser::find($id);

        $input['email'] = strtolower($input['email']);
        $input['role'] = current($input['roles']);
        $role = current($input['roles']);

        unset($input['roles']);

        $user->update($input);

        //DB::table('model_has_roles')->where('model_id',$id)->delete();

        //$user->removeRole('Super Admin');
        //$user->removeRole('Admin');

        //$user->assignRole($request->get('roles'));

        Session::flash('message', 'User Updated Successfully');
        return redirect()->route('admin-users.index');
    }

    public function destroy($id, Request $request) {

        if($id == 'all'){
            $admin_users = AdminUser::whereIn('id',$request->id)->get()->toArray();
            foreach ($admin_users as $user){
                $user = AdminUser::findOrFail($user['id']);
                $oldFile = config('constants.user.image_path') . '/' . $user['image'];
                $logoFile = config('constants.user.logo_path') . '/' . $user['logo'];
                File::delete($oldFile, $logoFile);
                $user->delete();
            }

        } else {
            $user = AdminUser::findOrFail($id);
            $oldFile = config('constants.user.image_path') . '/' . $user->image;
            $logoFile = config('constants.user.logo_path') . '/' . $user->logo;
            File::delete($oldFile, $logoFile);

            $user->delete();
        }

        $request->session()->flash('message', 'User Deleted Successfully.');
        return response()->json([
            'success' => 'success',
            'message' => 'User deleted successfully.'
        ]);
    }

    public function profile() {
        $user = AdminUser::find(Auth::guard('admin')->id());
        return view('admin.admin-users.editprofile', compact('user'));
    }

    public function editprofile(EditProfile $request) {
        $id = Auth::guard('admin')->id();
        $input = $request->all();
        if (!empty($input['password'])) {
            $input['password'] = Hash::make($input['password']);
        } else {
            $input = array_except($input, array('password'));
        }

        if ($request->has('image')) {
            $file = $request->file('image');
            $file_name = time() . $file->getClientOriginalName();
            $input['image'] = $file_name;
            $file_path = config('constants.adminuser.image_path');
            $file->move($file_path, $file_name);
        }

        $user = AdminUser::find($id);
        $user->update($input);
        Session::flash('message', 'Profile Updated Successfully');
        return redirect('admin/admin-profile');
    }

    public function changepassword() {
        return view('admin.admin-users.changepassword');
    }

    public function storechangepassword(Request $request) {
        $request->validate([
            'current_password' => 'required|min:6',
            'new_password' => 'required|min:6',
            'confirm_password' => 'required|min:6|same:new_password'
        ]);

        $user = Auth::guard('admin')->user();

        if (Hash::check($request->current_password, $user->password)) {
            $user->update([
                'password' => Hash::make($request->new_password)
            ]);

            $email_data = [
                'user' => $user
            ];

            $template = "emails.password-changed";
            $subject = "Password Changed - Realign";
            dispatch(new SendEmailJob($template, $email_data, $subject));

            return redirect()->back()->with('message','Password Changed Successfully');
        } else {
            return redirect()->back()->with('error', 'Invalid Current Password');
        }
    }
}
