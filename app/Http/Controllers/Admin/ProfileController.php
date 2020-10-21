<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\Admin\AdminUser\EditProfile;
use App\Models\AdminUser;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use Auth;
use View;
use DB;
use Hash;
use File;
class ProfileController extends Controller
{
    public function profile() {
        $user = Auth::guard('admin')->user();
        return view('admin.profile.edit', compact('user'));
    }

    public function editprofile(EditProfile $request) {
        
        $userLoggedIn = Auth::guard('admin')->user();
        $input = $request->all();
        $user = AdminUser::find($userLoggedIn->id);

        if ($request->has('image')) {
            $file = $request->file('image');
            $file_name = time() . $file->getClientOriginalName();
            $input['image'] = $file_name;
            $file_path = 'uploads/profile';
            $move = $file->move($file_path, $file_name);

            if(file_exists(public_path($userLoggedIn->image))){
                File::delete(public_path($userLoggedIn->image));
            }

            if($move){
				$input['image'] = $file_path.'/'.$file_name;
			}
		}

       $result = $user->update($input);
        if($result){
       	return redirect()->route('admin.dashboard')->with('message', 'Profile updated successfully');
       }
       	return redirect()->route('admin.dashboard')->with('error', 'Profile not updated.');
    }

    public function changepassword() {
     	$user = Auth::guard('admin')->user();
		return view('admin.profile.changepassword', compact('user'));
    }

    public function storenewpassword(Request $request) {
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
            return redirect()->back()->with('message','Password Changed Successfully');
        } else {

            return redirect()->back()->with('error', 'Invalid Current Password');
        }
    }

}
