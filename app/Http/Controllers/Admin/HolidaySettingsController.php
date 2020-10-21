<?php

namespace App\Http\Controllers\Admin;

use App\Models\HolidaySettings;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;

class HolidaySettingsController extends Controller
{
    public function index(){

        $holiday_settings = HolidaySettings::find(1);

        if (!empty($holiday_settings)) {
            return view('admin.holiday-settings.create',compact('holiday_settings'));
        } else {
            $holiday_settings = HolidaySettings::create();
            return view('admin.holiday-settings.create',compact('holiday_settings'));
        }
    }

    public function store(Request $request){

        $input = $request->all();

        $holiday_settings = HolidaySettings::find($input['id']);

        $holiday_settings->update($input);

        Session::flash('message', 'Holiday Settings Updated successfully');

        return redirect()->route('admin.holiday.setting.index')->with('message','Holiday Settings Updated Successfully');
    }
}
