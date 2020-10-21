<?php

namespace App\Http\Controllers\Admin;

use App\Models\Settings;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Services;
use Illuminate\Support\Facades\Session;

class SettingsController extends Controller
{
    public function index()
    {
        $settings           = Settings::find(1);
        $onepageFee         = Services::where('service_type','onepage')->first();
        $registrationFee    = Services::where('service_type','registration')->first();

        if (!empty($settings)){
            $settings['default_payment_getway'] = explode(',', $settings['default_payment_getway']);
            return view('admin.settings.create', compact('settings','onepageFee','registrationFee'));
        } else {
            $settings['default_payment_getway'] = implode(',',$settings['default_payment_getway']);
            $settings = Settings::create();
            return view('admin.settings.create', compact('settings','onepageFee','registrationFee'));
        }
    }

    public function store(Request $request)
    {
        $input = $request->all();

        if (!empty($input['default_payment_getway'])) {
            $input['default_payment_getway'] = implode(',', $input['default_payment_getway']);
        } else {
            $input['default_payment_getway'] = null;
        }
		
		if (isset($input['reset_trial_lessons'])) {
            $input['reset_trial_lessons'] = $input['reset_trial_lessons'];
        } else {
            $input['reset_trial_lessons'] = null;
        }
		
        $settings = Settings::find($input['id']);
        $settings['package_expire_reminder_days'] = $input['package_expire_reminder_days'];

        $settings->update($input);

        $onepageFee = Services::where('service_type','onepage')->first();
        if($onepageFee) {
            $onepageFee->price = $input['onepage_certified_fee'];
            $onepageFee->save();
        }

        $registrationFee = Services::where('service_type','registration')->first();
        if($registrationFee) {
            $registrationFee->price = $input['registration_fee'];
            $registrationFee->save();
        }

        Session::flash('message', 'Settings Update successfully');
        return redirect()->route('admin.settings.index')->with('message', 'Settings Update successfully');
    }
}
