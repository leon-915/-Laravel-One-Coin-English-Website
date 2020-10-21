<?php

namespace App\Http\Controllers\Admin;

use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;

class LastLoginTeacherController extends Controller
{
    public function index()
    {
        return view('admin.teachers-last-login.index');
    }

    public function getRecords(Request $request)
    {
        $users = User::select('id','email','last_login_at',
            DB::raw("CONCAT(users.firstname, ' ', users.lastname) AS teacher_name")
        )
        ->where('user_type','teacher')
        ->whereRaw("last_login_at::date <= '".date('Y-m-d H:i:s',strtotime('-2 months'))."'::date");

        return DataTables::of($users)
            ->addIndexColumn()
            ->editColumn('last_login_at', function ($users) {
                if($users->last_login_at){
                    return $users->last_login_at->diffForHumans();
                } else {
                    return "-";
                }
            })
            ->rawColumns(['action'])
            ->make(true);
    }
}