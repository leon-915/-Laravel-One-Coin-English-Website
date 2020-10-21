<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;

class TeacherController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //$this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $teachers = User::select('id','profile_image','firstname', 'lastname')
                        ->where('user_type','teacher')
                        ->where('status',1)
                        ->get();
        if(!$teachers){
            abort('404');
        }

        return view('teachers.index', compact('teachers'));
    }

}
