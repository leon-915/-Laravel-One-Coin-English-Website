<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home');
    }

    public function setLineNotificationFlag(Request $request){
        $id = $request->user_id;
        $data_to_update = $request->data_to_update;
        $user = User::find($id);
        $user->update(['send_line_notifications'=> $data_to_update]);

        return 'true';
    }

}
