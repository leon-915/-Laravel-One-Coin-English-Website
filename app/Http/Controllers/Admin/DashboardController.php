<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\ReportSettings;
use App\Models\StudentLessons;
use App\Models\StudentLessonsBooking;
use App\Models\StudentPackages;
use App\Models\StudentTransactions;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request) {
        $input  = $request->all();
        $filter = !empty($input['filter']) ? $input['filter'] : '';
        $option = !empty($input['opt']) ? $input['opt'] : '';
        $sort   = !empty($input['sort']) ? $input['sort'] : '';
        $last_date = date('Y-m-d', strtotime('-6 days'));
        $today = date('Y-m-d', strtotime(today()));

        $from_date = !empty($input['from_date']) ? $input['from_date'] : '';
        $to_date   = !empty($input['to_date']) ? $input['to_date'] : '';

        $newCourseData  = $this->newCourses($input);
        $remaingData    = $this->remaingBalance($input);
        $expireData     = $this->courseExpires($input);
        $revenueData    = $this->courseRevenue($input);

        return view('admin.reports.dashboard.index',compact('filter','option','sort','newCourseData','remaingData','expireData','revenueData','from_date','to_date'));
    }

    private function newCourses($input = array()){
        $filter = !empty($input['filter']) ? $input['filter'] : '';
        $option = !empty($input['opt']) ? $input['opt'] : '';
        $sort   = !empty($input['sort']) ? $input['sort'] : '';
        $last_date = date('Y-m-d', strtotime('-6 days'));
        $today = date('Y-m-d', strtotime(today()));

        $from_date = !empty($input['from_date']) ? $input['from_date'] : '';
        $to_date   = !empty($input['to_date']) ? $input['to_date'] : '';

        if(!empty($from_date) && !empty($to_date)){
            $filter = '';
            $bdays = $this->dateDiff($from_date, $to_date);

            if($bdays >= 0 && $bdays < 31){
                $services = StudentTransactions:: select(
                    DB::raw("to_char(created_at, 'DD Mon') as date"),
                    DB::raw("sum(NULLIF(amount,0)) as total")
                )
                    ->whereRaw("created_at >= '".$from_date."'::date")
                    ->whereRaw("created_at < '".date('Y-m-d',strtotime('+1 day', strtotime($to_date))) ."'::date")
                    ->where('transaction_type','multi_service')
                    ->where('payment_status','succeeded')
                    ->groupBy('date')->pluck('total','date')->toArray();

                $packages = StudentTransactions:: select(
                    DB::raw("to_char(created_at, 'DD Mon') as date"),
                    DB::raw("sum(NULLIF(amount,0)) as total")
                )
                    ->whereRaw("created_at >= '".$from_date."'::date")
                    ->whereRaw("created_at < '".date('Y-m-d',strtotime('+1 day', strtotime($to_date))) ."'::date")
                    ->where('transaction_type','package')
                    ->where('payment_status','succeeded')
                    ->groupBy('date')->pluck('total','date')->toArray();


                $lastMonth = $this->daterange($from_date,$to_date);
                $amtData = [];
                foreach ($lastMonth as $day) {
                    $amtData['lables'][] = $day;
                    $amtData['sdata'][] = !empty($services[$day]) ? $services[$day] : 0;
                    $amtData['pdata'][] = !empty($packages[$day]) ? $packages[$day] : 0;
                }
            } else {
                $services = StudentTransactions:: select(
                    DB::raw("to_char(created_at,'Mon') as mon"),
                    DB::raw("extract(year from created_at) as yyyy"),
                    DB::raw("CONCAT(to_char(created_at,'Mon') ,' ',extract(year from created_at)) as mdate"),
                    DB::raw("sum(NULLIF(amount,0)) as total")
                )
                    ->whereRaw("created_at >= '".$from_date."'::date")
                    ->whereRaw("created_at < '".date('Y-m-d',strtotime('+1 day', strtotime($to_date))) ."'::date")
                    ->where('transaction_type','multi_service')
                    ->where('payment_status','succeeded')
                    ->groupBy(DB::raw('1,2'))->pluck('total','mdate')->toArray();

                $packages = StudentTransactions:: select(
                    DB::raw("to_char(created_at,'Mon') as mon"),
                    DB::raw("extract(year from created_at) as yyyy"),
                    DB::raw("CONCAT(to_char(created_at,'Mon') ,' ',extract(year from created_at)) as mdate"),
                    DB::raw("sum(NULLIF(amount,0)) as total")
                )
                    ->whereRaw("created_at >= '".$from_date."'::date")
                    ->whereRaw("created_at < '".date('Y-m-d',strtotime('+1 day', strtotime($to_date))) ."'::date")
                    ->where('transaction_type','package')
                    ->where('payment_status','succeeded')
                    ->groupBy(DB::raw('1,2'))->pluck('total','mdate')->toArray();

                $lastYear = $this->monthRange($from_date,$to_date);

                $amtData = [];
                foreach ($lastYear as $day) {
                    $amtData['lables'][] = $day;
                    $amtData['sdata'][] = !empty($services[$day]) ? $services[$day] : 0;
                    $amtData['pdata'][] = !empty($packages[$day]) ? $packages[$day] : 0;
                }
            }
        } else {
            if (!empty($filter) && $filter == 'm') {
                $date = date('Y-m', strtotime(today()));

                $services = StudentTransactions:: select(
                    DB::raw("to_char(created_at, 'DD Mon') as date"),
                    DB::raw("sum(NULLIF(amount,0)) as total")
                )
                    ->whereRaw("to_char(created_at, 'YYYY-MM') like '" . $date . "'")
                    ->where('transaction_type','multi_service')
                    ->where('transaction_type','multi_service')
                    ->where('payment_status','succeeded')
                    ->groupBy('date')->pluck('total','date')->toArray();

                $packages = StudentTransactions:: select(
                    DB::raw("to_char(created_at, 'DD Mon') as date"),
                    DB::raw("sum(NULLIF(amount,0)) as total")
                )
                    ->whereRaw("to_char(created_at, 'YYYY-MM') like '" . $date . "'")
                    ->where('transaction_type','package')
                    ->where('payment_status','succeeded')
                    ->groupBy('date')->pluck('total','date')->toArray();


                $stDate = date('Y-m')."-01";
                $lastMonth = $this->daterange($stDate,$today);
                $amtData = [];
                foreach ($lastMonth as $day) {
                    $amtData['lables'][] = $day;
                    $amtData['sdata'][] = !empty($services[$day]) ? $services[$day] : 0;
                    $amtData['pdata'][] = !empty($packages[$day]) ? $packages[$day] : 0;
                }

            } elseif (!empty($filter) && $filter == 'd') {

                $date = date('Y-m-d', strtotime(today()));

                $services = StudentTransactions::select(
                    DB::raw("to_char(created_at, 'DD Mon YYYY') as date"),
                    DB::raw("sum(NULLIF(amount,0)) as total")
                )
                    ->whereRaw("to_char(created_at, 'YYYY-MM-DD') like '" . $date . "'")
                    ->where('transaction_type','multi_service')
                    ->where('payment_status','succeeded')
                    ->groupBy('date')->get()->toArray();

                $packages = StudentTransactions::select(
                    DB::raw("to_char(created_at, 'DD Mon YYYY') as date"),
                    DB::raw("sum(NULLIF(amount,0)) as total")
                )
                    ->whereRaw("to_char(created_at, 'YYYY-MM-DD') like '" . $date . "'")
                    ->where('transaction_type','package')
                    ->where('payment_status','succeeded')
                    ->groupBy('date')->get()->toArray();


                $amtData = [];
                $amtData['lables'][] = date('d M Y');
                $amtData['sdata'][] = !empty($services[0]['total']) ? $services[0]['total']: 0;
                $amtData['pdata'][] = !empty($packages[0]['total']) ? $packages[0]['total']: 0;


            } elseif (!empty($filter) && $filter == 'y') {
                $services = StudentTransactions:: select(
                    DB::raw("to_char(created_at,'Mon') as mon"),
                    DB::raw("extract(year from created_at) as yyyy"),
                    DB::raw("CONCAT(to_char(created_at,'Mon') ,' ',extract(year from created_at)) as mdate"),
                    DB::raw("sum(NULLIF(amount,0)) as total")
                )
                    ->whereRaw("date_part('year', created_at) = date_part('year', CURRENT_DATE)")
                    ->where('transaction_type','multi_service')
                    ->where('payment_status','succeeded')
                    ->groupBy(DB::raw('1,2'))->pluck('total','mdate')->toArray();

                $packages = StudentTransactions:: select(
                    DB::raw("to_char(created_at,'Mon') as mon"),
                    DB::raw("extract(year from created_at) as yyyy"),
                    DB::raw("CONCAT(to_char(created_at,'Mon') ,' ',extract(year from created_at)) as mdate"),
                    DB::raw("sum(NULLIF(amount,0)) as total")
                )
                    ->whereRaw("date_part('year', created_at) = date_part('year', CURRENT_DATE)")
                    ->where('transaction_type','package')
                    ->where('payment_status','succeeded')
                    ->groupBy(DB::raw('1,2'))->pluck('total','mdate')->toArray();

                $stDate = date('Y')."-01-01";
                $lastYear = $this->monthRange($stDate);

                $amtData = [];
                foreach ($lastYear as $day) {
                    $amtData['lables'][] = $day;
                    $amtData['sdata'][] = !empty($services[$day]) ? $services[$day] : 0;
                    $amtData['pdata'][] = !empty($packages[$day]) ? $packages[$day] : 0;
                }

            } else {
                $services=StudentTransactions:: select(
                    DB::raw("to_char(created_at, 'DD Mon') as date"),
                    DB::raw("sum(NULLIF(amount,0)) as total")
                )
                    ->whereRaw("to_char(created_at, 'YYYY-MM-DD') between '" . $last_date . "' and'" . $today . "'")
                    ->where('transaction_type','multi_service')
                    ->where('payment_status','succeeded')
                    ->groupBy('date')->pluck('total','date')->toArray();

                $packages=StudentTransactions:: select(
                    DB::raw("to_char(created_at, 'DD Mon') as date"),
                    DB::raw("sum(NULLIF(amount,0)) as total")
                )
                    ->whereRaw("to_char(created_at, 'YYYY-MM-DD') between '" . $last_date . "' and'" . $today . "'")
                    ->where('transaction_type','package')
                    ->where('payment_status','succeeded')
                    ->groupBy('date')->pluck('total','date')->toArray();

                $lastWeek = $this->daterange($last_date,$today);
                $amtData = [];
                foreach ($lastWeek as $day) {
                    $amtData['lables'][] = $day;
                    $amtData['sdata'][] = !empty($services[$day]) ? $services[$day] : 0;
                    $amtData['pdata'][] = !empty($packages[$day]) ? $packages[$day] : 0;
                }
            }
        }

        return $amtData;
    }

    private function remaingBalance($input = array()){
        $filter = !empty($input['filter']) ? $input['filter'] : '';
        $option = !empty($input['opt']) ? $input['opt'] : '';
        $sort   = !empty($input['sort']) ? $input['sort'] : '';
        $last_date = date('Y-m-d', strtotime('-6 days'));
        $today = date('Y-m-d', strtotime(today()));

        $from_date = !empty($input['from_date']) ? $input['from_date'] : '';
        $to_date   = !empty($input['to_date']) ? $input['to_date'] : '';

        if(!empty($from_date) && !empty($to_date)){
            $filter = '';
            $bdays = $this->dateDiff($from_date, $to_date);

            if($bdays >= 0 && $bdays < 31){
                $services = StudentPackages:: select(
                    DB::raw("to_char(student_packages.end_date, 'DD Mon') as date"),
                    DB::raw("sum(NULLIF(student_details.credit_balance,0)) as total")
                )
                    ->whereRaw("student_packages.end_date >= '".$from_date."'::date")
                    ->whereRaw("student_packages.end_date < '".date('Y-m-d',strtotime('+1 day', strtotime($to_date))) ."'::date")
                    ->join('users','users.id','student_packages.user_id')
                    ->join('student_details','users.id','student_details.user_id')
                    ->groupBy('date')->pluck('total','date')->toArray();

                $lastMonth = $this->daterange($from_date,$to_date);
                $amtData = [];
                foreach ($lastMonth as $day) {
                    $amtData['lables'][] = $day;
                    $amtData['data'][] = !empty($services[$day]) ? (int)$services[$day] : 0;
                }
            } else {
                $services = StudentPackages:: select(
                    DB::raw("to_char(student_packages.end_date,'Mon') as mon"),
                    DB::raw("extract(year from student_packages.end_date) as yyyy"),
                    DB::raw("CONCAT(to_char(student_packages.end_date,'Mon') ,' ',extract(year from student_packages.end_date)) as mdate"),
                    DB::raw("sum(NULLIF(student_details.credit_balance,0)) as total")
                )
                    ->whereRaw("student_packages.end_date >= '".$from_date."'::date")
                    ->whereRaw("student_packages.end_date < '".date('Y-m-d',strtotime('+1 day', strtotime($to_date))) ."'::date")
                    ->join('users','users.id','student_packages.user_id')
                    ->join('student_details','users.id','student_details.user_id')
                    ->groupBy(DB::raw('1,2'))->pluck('total','mdate')->toArray();


                $lastYear = $this->monthRange($from_date,$to_date);

                $amtData = [];
                foreach ($lastYear as $day) {
                    $amtData['lables'][] = $day;
                    $amtData['data'][] = !empty($services[$day]) ? (int)$services[$day] : 0;
                }
            }
        } else {
            if (!empty($filter) && $filter == 'm') {
                $date = date('Y-m', strtotime(today()));

                $services = StudentPackages:: select(
                    DB::raw("to_char(student_packages.end_date, 'DD Mon') as date"),
                    DB::raw("sum(NULLIF(student_details.credit_balance,0)) as total")
                )
                    ->whereRaw("to_char(student_packages.end_date, 'YYYY-MM') like '" . $date . "'")
                    ->join('users','users.id','student_packages.user_id')
                    ->join('student_details','users.id','student_details.user_id')
                    ->groupBy('date')->pluck('total','date')->toArray();

                $stDate = date('Y-m')."-01";
                $lastMonth = $this->daterange($stDate,$today);
                $amtData = [];
                foreach ($lastMonth as $day) {
                    $amtData['lables'][] = $day;
                    $amtData['data'][] = !empty($services[$day]) ? (int)$services[$day] : 0;
                }

            } elseif (!empty($filter) && $filter == 'd') {

                $date = date('Y-m-d', strtotime(today()));

                $services = StudentPackages::select(
                    DB::raw("to_char(student_packages.end_date, 'DD Mon YYYY') as date"),
                    DB::raw("sum(NULLIF(student_details.credit_balance,0)) as total")
                )
                    ->whereRaw("to_char(student_packages.end_date, 'YYYY-MM-DD') like '" . $date . "'")
                    ->join('users','users.id','student_packages.user_id')
                    ->join('student_details','users.id','student_details.user_id')
                    ->groupBy('date')->get()->toArray();

                $amtData = [];
                $amtData['lables'][] = date('d M Y');
                $amtData['data'][] = !empty($services[0]['total']) ? (int)$services[0]['total'] : 0;


            } elseif (!empty($filter) && $filter == 'y') {
                $services = StudentPackages:: select(
                    DB::raw("to_char(student_packages.end_date,'Mon') as mon"),
                    DB::raw("extract(year from student_packages.end_date) as yyyy"),
                    DB::raw("CONCAT(to_char(student_packages.end_date,'Mon') ,' ',extract(year from student_packages.end_date)) as mdate"),
                    DB::raw("sum(NULLIF(student_details.credit_balance,0)) as total")
                )
                    ->whereRaw("date_part('year', student_packages.end_date) = date_part('year', CURRENT_DATE)")
                    ->join('users','users.id','student_packages.user_id')
                    ->join('student_details','users.id','student_details.user_id')
                    ->groupBy(DB::raw('1,2'))->pluck('total','mdate')->toArray();


                $stDate = date('Y')."-01-01";
                $lastYear = $this->monthRange($stDate);

                $amtData = [];
                foreach ($lastYear as $day) {
                    $amtData['lables'][] = $day;
                    $amtData['data'][] = !empty($services[$day]) ? (int)$services[$day] : 0;
                }

            } else {
                $services=StudentPackages:: select(
                    DB::raw("to_char(student_packages.end_date, 'DD Mon') as date"),
                    DB::raw("sum(NULLIF(student_details.credit_balance,0)) as total")
                )
                    ->whereRaw("to_char(student_packages.end_date, 'YYYY-MM-DD') between '" . $last_date . "' and '" . $today . "'")
                    ->leftjoin('users','student_packages.user_id','users.id')
                    ->leftjoin('student_details','student_packages.id','student_details.user_id')
                    ->groupBy('date')->pluck('total','date')->toArray();

                $lastWeek = $this->daterange($last_date,$today);
                $amtData = [];
                foreach ($lastWeek as $day) {
                    $amtData['lables'][] = $day;
                    $amtData['data'][] = !empty($services[$day]) ? (int)$services[$day] : 0;
                }
            }
        }

        return $amtData;
    }

    private function courseExpires($input = array()){
        $filter = !empty($input['filter']) ? $input['filter'] : '';
        $option = !empty($input['opt']) ? $input['opt'] : '';
        $sort   = !empty($input['sort']) ? $input['sort'] : '';
        $last_date = date('Y-m-d', strtotime('-6 days'));
        $today = date('Y-m-d', strtotime(today()));

        $from_date = !empty($input['from_date']) ? $input['from_date'] : '';
        $to_date   = !empty($input['to_date']) ? $input['to_date'] : '';


        if(!empty($from_date) && !empty($to_date)){
            $filter = '';
            $bdays = $this->dateDiff($from_date, $to_date);

            if($bdays >= 0 && $bdays < 31){
                $services = StudentLessons:: select(
                    DB::raw("to_char(expire_date, 'DD Mon') as date"),
                    DB::raw("count(*) as total")
                )
                    ->whereRaw("expire_date >= '".$from_date."'::date")
                    ->whereRaw("expire_date < '".date('Y-m-d',strtotime('+1 day', strtotime($to_date))) ."'::date")
                    ->groupBy('date')->pluck('total','date')->toArray();

                $lastMonth = $this->daterange($from_date,$to_date);
                $amtData = [];
                foreach ($lastMonth as $day) {
                    $amtData['lables'][] = $day;
                    $amtData['data'][] = !empty($services[$day]) ? (int)$services[$day] : 0;
                }
            } else {
                $services = StudentLessons:: select(
                    DB::raw("to_char(expire_date,'Mon') as mon"),
                    DB::raw("extract(year from expire_date) as yyyy"),
                    DB::raw("CONCAT(to_char(expire_date,'Mon') ,' ',extract(year from expire_date)) as mdate"),
                    DB::raw("count(*) as total")
                )
                    ->whereRaw("expire_date >= '".$from_date."'::date")
                    ->whereRaw("expire_date < '".date('Y-m-d',strtotime('+1 day', strtotime($to_date))) ."'::date")
                    ->groupBy(DB::raw('1,2'))->pluck('total','mdate')->toArray();

                $lastYear = $this->monthRange($from_date,$to_date);

                $amtData = [];
                foreach ($lastYear as $day) {
                    $amtData['lables'][] = $day;
                    $amtData['data'][] = !empty($services[$day]) ? (int)$services[$day] : 0;
                }
            }
        } else {
            if (!empty($filter) && $filter == 'm') {
                $date = date('Y-m', strtotime(today()));

                $services = StudentLessons:: select(
                    DB::raw("to_char(expire_date, 'DD Mon') as date"),
                    DB::raw("count(*) as total")
                )
                    ->whereRaw("to_char(expire_date, 'YYYY-MM') like '" . $date . "'")
                    ->groupBy('date')->pluck('total','date')->toArray();

                $stDate = date('Y-m')."-01";
                $lastMonth = $this->daterange($stDate,$today);
                $amtData = [];
                foreach ($lastMonth as $day) {
                    $amtData['lables'][] = $day;
                    $amtData['data'][] = !empty($services[$day]) ? (int)$services[$day] : 0;
                }

            } elseif (!empty($filter) && $filter == 'd') {

                $date = date('Y-m-d', strtotime(today()));

                $services = StudentLessons::select(
                    DB::raw("to_char(expire_date, 'DD Mon YYYY') as date"),
                    DB::raw("count(*) as total")
                )
                    ->whereRaw("to_char(expire_date, 'YYYY-MM-DD') like '" . $date . "'")
                    ->groupBy('date')->get()->toArray();

                $amtData = [];
                $amtData['lables'][] = date('d M Y');
                $amtData['data'][] = !empty($services[0]['total']) ? (int)$services[0]['total'] : 0;
            } elseif (!empty($filter) && $filter == 'y') {
                $services = StudentLessons:: select(
                    DB::raw("to_char(expire_date,'Mon') as mon"),
                    DB::raw("extract(year from expire_date) as yyyy"),
                    DB::raw("CONCAT(to_char(expire_date,'Mon') ,' ',extract(year from expire_date)) as mdate"),
                    DB::raw("count(*) as total")
                )
                    ->whereRaw("date_part('year', expire_date) = date_part('year', CURRENT_DATE)")
                    ->groupBy(DB::raw('1,2'))->pluck('total','mdate')->toArray();


                $stDate = date('Y')."-01-01";
                $lastYear = $this->monthRange($stDate);

                $amtData = [];
                foreach ($lastYear as $day) {
                    $amtData['lables'][] = $day;
                    $amtData['data'][] = !empty($services[$day]) ? (int)$services[$day] : 0;
                }
            } else {
                $services=StudentLessons:: select(
                    DB::raw("to_char(expire_date, 'DD Mon') as date"),
                    DB::raw("count(*) as total")
                )
                    ->whereRaw("to_char(expire_date, 'YYYY-MM-DD') between '" . $last_date . "' and '" . $today . "'")
                    ->groupBy('date')->pluck('total','date')->toArray();

                $lastWeek = $this->daterange($last_date,$today);
                $amtData = [];
                foreach ($lastWeek as $day) {
                    $amtData['lables'][] = $day;
                    $amtData['data'][] = !empty($services[$day]) ? (int)$services[$day] : 0;

                }
            }
        }

        return $amtData;
    }

    private function courseRevenue($input = array()){
        $filter = !empty($input['filter']) ? $input['filter'] : '';
        $option = !empty($input['opt']) ? $input['opt'] : '';
        $sort   = !empty($input['sort']) ? $input['sort'] : '';
        $last_date = date('Y-m-d', strtotime('-6 days'));
        $today = date('Y-m-d', strtotime(today()));

        $from_date = !empty($input['from_date']) ? $input['from_date'] : '';
        $to_date   = !empty($input['to_date']) ? $input['to_date'] : '';

        $settings = ReportSettings::find(1);

        if(!empty($from_date) && !empty($to_date)){
            $filter = '';
            $bdays = $this->dateDiff($from_date, $to_date);

            if($bdays >= 0 && $bdays < 31){
                $services = StudentLessonsBooking:: select(
                    DB::raw("to_char(completed_at, 'DD Mon') as date"),
                    DB::raw("sum(NULLIF(teacher_earnings,0)) as expense"),
                    DB::raw("sum(NULLIF(admin_earnings,0)) as revenue")
                )
                    ->whereRaw("completed_at >= '".$from_date."'::date")
                    ->whereRaw("completed_at < '".date('Y-m-d',strtotime('+1 day', strtotime($to_date))) ."'::date")
                    ->where('status', 'completed')
                    ->groupBy('date')->get()->toArray();

                $amounts = [];
                foreach ($services as $sda) {
                    $amounts[$sda['date']]['expense'] = $sda['expense'];
                    $amounts[$sda['date']]['revenue'] = $sda['revenue'];
                }

                $lastMonth = $this->daterange($from_date,$to_date);
                $amtData = [];
                foreach ($lastMonth as $day) {
                    $amtData['lables'][] = $day;
                    $amtData['expense'][] = !empty($amounts[$day]['expense']) ? (int)$amounts[$day]['expense'] : 0;
                    $amtData['revenue'][] = !empty($amounts[$day]['revenue']) ? (int)$amounts[$day]['revenue'] : 0;
                    $amtData['ultimate'][] = !empty($settings['ultimate']) ? $settings['ultimate'] : 0;
                    $amtData['ideal'][] = !empty($settings['ideal']) ? $settings['ideal'] : 0;
                    $amtData['target'][] = !empty($settings['target']) ? $settings['target']  : 0;
                    $amtData['minimum'][] = !empty($settings['minimum']) ? $settings['minimum']  : 0;
                    $amtData['avg'][] = ($settings['minimum'] + $settings['target'] + $settings['ideal'] + $settings['ultimate'])/4;
                }
            } else {
                $services = StudentLessonsBooking:: select(
                    DB::raw("to_char(completed_at,'Mon') as mon"),
                    DB::raw("extract(year from completed_at) as yyyy"),
                    DB::raw("CONCAT(to_char(completed_at,'Mon') ,' ',extract(year from completed_at)) as mdate"),
                    DB::raw("sum(NULLIF(teacher_earnings,0)) as expense"),
                    DB::raw("sum(NULLIF(admin_earnings,0)) as revenue")
                )
                    ->whereRaw("completed_at >= '".$from_date."'::date")
                    ->whereRaw("completed_at < '".date('Y-m-d',strtotime('+1 day', strtotime($to_date))) ."'::date")
                    ->where('status', 'completed')
                    ->groupBy(DB::raw('1,2'))->get()->toArray();


                $amounts = [];
                foreach ($services as $sda) {
                    $amounts[$sda['mdate']]['expense'] = $sda['expense'];
                    $amounts[$sda['mdate']]['revenue'] = $sda['revenue'];
                }

                $lastYear = $this->monthRange($from_date,$to_date);

                $amtData = [];
                foreach ($lastYear as $day) {
                    $monDays = cal_days_in_month(CAL_GREGORIAN, date('m',strtotime($day)), date('Y'));
                    $amtData['lables'][] = $day;
                    $amtData['expense'][] = !empty($amounts[$day]['expense']) ? (int)$amounts[$day]['expense'] : 0;
                    $amtData['revenue'][] = !empty($amounts[$day]['revenue']) ? (int)$amounts[$day]['revenue'] : 0;
                    $amtData['ultimate'][] = !empty($settings['ultimate']) ? $settings['ultimate'] * $monDays : 0;
                    $amtData['ideal'][] = !empty($settings['ideal']) ? $settings['ideal'] * $monDays : 0;
                    $amtData['target'][] = !empty($settings['target']) ? $settings['target'] * $monDays  : 0;
                    $amtData['minimum'][] = !empty($settings['minimum']) ? $settings['minimum'] * $monDays : 0;
                    $amtData['avg'][] = ($settings['minimum'] + $settings['target'] + $settings['ideal'] + $settings['ultimate'])/4;
                }
            }
        } else {
            if (!empty($filter) && $filter == 'm') {
                $date = date('Y-m', strtotime(today()));

                $services = StudentLessonsBooking:: select(
                    DB::raw("to_char(completed_at, 'DD Mon') as date"),
                    DB::raw("sum(NULLIF(teacher_earnings,0)) as expense"),
                    DB::raw("sum(NULLIF(admin_earnings,0)) as revenue")
                )
                    ->whereRaw("to_char(completed_at, 'YYYY-MM') like '" . $date . "'")
                    ->where('status', 'completed')
                    ->groupBy('date')->get()->toArray();

                $amounts = [];
                foreach ($services as $sda) {
                    $amounts[$sda['date']]['expense'] = $sda['expense'];
                    $amounts[$sda['date']]['revenue'] = $sda['revenue'];
                }

                $stDate = date('Y-m')."-01";
                $lastMonth = $this->daterange($stDate,$today);
                $amtData = [];
                foreach ($lastMonth as $day) {
                    $amtData['lables'][] = $day;
                    $amtData['expense'][] = !empty($amounts[$day]['expense']) ? (int)$amounts[$day]['expense'] : 0;
                    $amtData['revenue'][] = !empty($amounts[$day]['revenue']) ? (int)$amounts[$day]['revenue'] : 0;
                    $amtData['ultimate'][] = !empty($settings['ultimate']) ? $settings['ultimate'] : 0;
                    $amtData['ideal'][] = !empty($settings['ideal']) ? $settings['ideal'] : 0;
                    $amtData['target'][] = !empty($settings['target']) ? $settings['target']  : 0;
                    $amtData['minimum'][] = !empty($settings['minimum']) ? $settings['minimum']  : 0;
                    $amtData['avg'][] = ($settings['minimum'] + $settings['target'] + $settings['ideal'] + $settings['ultimate'])/4;
                }

            } elseif (!empty($filter) && $filter == 'd') {

                $date = date('Y-m-d', strtotime(today()));

                $services = StudentLessonsBooking::select(
                    DB::raw("to_char(completed_at, 'DD Mon YYYY') as date"),
                    DB::raw("sum(NULLIF(teacher_earnings,0)) as expense"),
                    DB::raw("sum(NULLIF(admin_earnings,0)) as revenue")
                )
                    ->whereRaw("to_char(completed_at, 'YYYY-MM-DD') like '" . $date . "'")
                    ->where('status', 'completed')
                    ->groupBy('date')->get()->toArray();

                $amounts = [];
                foreach ($services as $sda) {
                    $amounts[$sda['date']]['expense'] = $sda['expense'];
                    $amounts[$sda['date']]['revenue'] = $sda['revenue'];
                }

                $amtData = [];
                $amtData['lables'][] = date('d M Y');
                $amtData['expense'][] = !empty($amounts[0]['expense']) ? (int)$amounts[0]['expense'] : 0;
                $amtData['revenue'][] = !empty($amounts[0]['revenue']) ? (int)$amounts[0]['revenue'] : 0;
                $amtData['ultimate'][] = !empty($settings['ultimate']) ? (int)$settings['ultimate'] : 0;
                $amtData['ideal'][] = !empty($settings['ideal']) ? (int)$settings['ideal'] : 0;
                $amtData['target'][] = !empty($settings['target']) ? (int)$settings['target'] : 0;
                $amtData['minimum'][] = !empty($settings['minimum']) ? (int)$settings['minimum'] : 0;
                $amtData['avg'][] = ($settings['minimum'] + $settings['target'] + $settings['ideal'] + $settings['ultimate'])/4;


            } elseif (!empty($filter) && $filter == 'y') {
                $services = StudentLessonsBooking:: select(
                    DB::raw("to_char(completed_at,'Mon') as mon"),
                    DB::raw("extract(year from completed_at) as yyyy"),
                    DB::raw("CONCAT(to_char(completed_at,'Mon') ,' ',extract(year from completed_at)) as mdate"),
                    DB::raw("sum(NULLIF(teacher_earnings,0)) as expense"),
                    DB::raw("sum(NULLIF(admin_earnings,0)) as revenue")
                )
                    ->whereRaw("date_part('year', completed_at) = date_part('year', CURRENT_DATE)")
                    ->where('status', 'completed')
                    ->groupBy(DB::raw('1,2'))->get()->toArray();


                $amounts = [];
                foreach ($services as $sda) {
                    $amounts[$sda['mdate']]['expense'] = $sda['expense'];
                    $amounts[$sda['mdate']]['revenue'] = $sda['revenue'];
                }

                $stDate = date('Y')."-01-01";
                $lastYear = $this->monthRange($stDate);

                $amtData = [];
                foreach ($lastYear as $day) {
                    $monDays = cal_days_in_month(CAL_GREGORIAN, date('m',strtotime($day)), date('Y'));
                    $amtData['lables'][] = $day;
                    $amtData['expense'][] = !empty($amounts[$day]['expense']) ? (int)$amounts[$day]['expense'] : 0;
                    $amtData['revenue'][] = !empty($amounts[$day]['revenue']) ? (int)$amounts[$day]['revenue'] : 0;
                    $amtData['ultimate'][] = !empty($settings['ultimate']) ? $settings['ultimate'] * $monDays : 0;
                    $amtData['ideal'][] = !empty($settings['ideal']) ? $settings['ideal'] * $monDays : 0;
                    $amtData['target'][] = !empty($settings['target']) ? $settings['target'] * $monDays  : 0;
                    $amtData['minimum'][] = !empty($settings['minimum']) ? $settings['minimum'] * $monDays : 0;
                    $amtData['avg'][] = ($settings['minimum'] + $settings['target'] + $settings['ideal'] + $settings['ultimate'])/4;
                }

            } else {
                $services=StudentLessonsBooking:: select(
                    DB::raw("to_char(completed_at, 'DD Mon') as date"),
                    DB::raw("sum(NULLIF(teacher_earnings,0)) as expense"),
                    DB::raw("sum(NULLIF(admin_earnings,0)) as revenue")
                )
                    ->whereRaw("to_char(completed_at, 'YYYY-MM-DD') between '" . $last_date . "' and '" . $today . "'")->where('status', 'completed')
                    ->groupBy('date')->get()->toArray();

                $amounts = [];
                foreach ($services as $sda) {
                    $amounts[$sda['date']]['expense'] = $sda['expense'];
                    $amounts[$sda['date']]['revenue'] = $sda['revenue'];
                }

                $lastWeek = $this->daterange($last_date,$today);
                $amtData = [];
                foreach ($lastWeek as $day) {
                    $amtData['lables'][] = $day;
                    $amtData['expense'][] = !empty($amounts[$day]['expense']) ? (int)$amounts[$day]['expense'] : 0;
                    $amtData['revenue'][] = !empty($amounts[$day]['revenue']) ? (int)$amounts[$day]['revenue'] : 0;
                    $amtData['ultimate'][] = !empty($settings['ultimate']) ? (int)$settings['ultimate'] : 0;
                    $amtData['ideal'][] = !empty($settings['ideal']) ? (int)$settings['ideal'] : 0;
                    $amtData['target'][] = !empty($settings['target']) ? (int)$settings['target'] : 0;
                    $amtData['minimum'][] = !empty($settings['minimum']) ? (int)$settings['minimum'] : 0;
                    $amtData['avg'][] = ($settings['minimum'] + $settings['target'] + $settings['ideal'] + $settings['ultimate'])/4;
                }
            }
        }

        return $amtData;
    }

    private function dateRange( $first, $last=null, $step = '+1 day', $format = 'd M' ) {

        $dates = array();
        $current = strtotime( $first );
        if($last){
            $last = strtotime( $last );
        } else {
            $last = time();
        }

        while( $current <= $last ) {

            $dates[] = date( $format, $current );
            $current = strtotime( $step, $current );
        }

        return $dates;
    }

    private function monthRange( $first, $last=null, $step = '+1 month', $format = 'M Y' ) {
        $dates = array();
        $current = strtotime( $first );

        if($last){
            $last = strtotime( $last );
        } else {
            $last = time();
        }

        while( $current <= $last ) {
            $dates[] = date( $format, $current );
            $current = strtotime( $step, $current );
        }

        return $dates;
    }

    private function dateDiff($date1, $date2) {
        $date1_ts = strtotime($date1);
        $date2_ts = strtotime($date2);
        $diff = $date2_ts - $date1_ts;
        return round($diff / 86400);
    }

}
