<?php

namespace App\Http\Controllers\Admin\LessonReports;

use App\Models\ReportSettings;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;

class ReportSettingsController extends Controller
{
    public function index()
    {
        $report_settings = ReportSettings::find(1);

        if (!empty($report_settings)){

            return view('admin.reports.report-settings.create', compact('report_settings'));
        }
        else{

            $report_settings = ReportSettings::create();
            return view('admin.reports.report-settings.create', compact('report_settings'));
        }
    }

    public function store(Request $request)
    {
        $input = $request->all();
        $report_settings = ReportSettings::find($input['id']);
        $report_settings->update($input);

        Session::flash('message', 'Report Settings Update successfully');
        return redirect()->route('admin.report.settings.index')->with('message', 'Report Settings Update successfully');
    }
}
