<?php

namespace App\Console\Commands;

use App\Models\Settings;
use App\Models\StudentPackages;
use App\Models\StudentTransactions;
use App\Models\TeacherPayoutTransactions;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class PackageReminder extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'package:reminder';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle() {
        $this->remindBeforeDays();
        $this->packageExpired();
        $this->packageHoldCheck();
        $this->startHoldPackage();
        $this->teacherPaypalCheck();
    }

    private function remindBeforeDays() {
        $remindDays = Settings::getSettings('package_expire_reminder_days');
        if(!$remindDays){
            $remindDays = 5;
        }
        $remindDate = date('Y-m-d', strtotime('+'.$remindDays.' days'));
        $packages = StudentPackages::whereRaw("end_date = '".$remindDate."'::date")
                                    ->where('status', 'active')
                                    ->with([
                                        'package',
                                        'student'
                                    ])
                                    ->get();

        foreach ($packages as $package) {
            $rTemplate  = "emails.expire.package-expire-reminder";
            $rSubject   = "Your subscription plan will expire on ".date('F d,Y',strtotime($package->end_date)).".";
            $rEmail     = $package->student->email;
            $data = [
                'package'   => $package,
                'days'      => $remindDays,
            ];
            Mail::send($rTemplate, $data, function ($m) use ($rEmail, $rSubject) {
                $m->from(env('MAIL_FROM_ADDRESS'), env('MAIL_FROM_NAME'));
                $m->to($rEmail)->subject($rSubject);
            });
        }
    }

    private function packageExpired() {
        $remindDate = date('Y-m-d');
        $packages = StudentPackages::whereRaw("end_date < '".$remindDate."'::date")
                                    ->where('status', 'active')
                                    ->with(['package', 'student'])
                                    ->get();

        foreach ($packages as $sp) {
            $sp->status = 'expired';


            $packageDetail = $sp->package;
            $taxPer = Settings::getSettings('tax');

            if($sp->payment_type == 'cash'){
                $sp->payment_status = 'pending';
                $studentTransaction = [
                    "user_id" => $sp->user_id,
                    "provider" => 'cash',
                    "amount" => $packageDetail->price + ($packageDetail->price * $taxPer / 100),
                    "transaction_type" => "package",
                    "transaction_type_id" => $sp->package->id,
                    "payment_status" => "Pending",
                    "subtotal" => $packageDetail->price,
                    "one_page_fee" => 0,
                    "tax" => ($packageDetail->price * $taxPer / 100)
                ];

                StudentTransactions::create($studentTransaction);
            }

            $sp->save();

            $rTemplate  = "emails.expire.package-expired";
            $rSubject   = "Your subscription plan is expired on ".date('F d,Y',strtotime($sp->end_date)).".";
            $rEmail     = $sp->student->email;
            $data = ['package' => $sp];
            Mail::send($rTemplate, $data, function ($m) use ($rEmail, $rSubject) {
                $m->from(env('MAIL_FROM_ADDRESS'), env('MAIL_FROM_NAME'));
                $m->to($rEmail)->subject($rSubject);
            });
        }
    }

    private function packageHoldCheck() {
        $remindDate = date('Y-m-d', strtotime('+7 days'));
        $packages = StudentPackages::whereRaw("start_date = '".$remindDate."'::date")
                                    ->where('status', 'onhold')
                                    ->with(['package', 'student'])
                                    ->get();

        foreach ($packages as $package) {
            $rTemplate  = "emails.expire.onbreak-expire-reminder";
            $rSubject   = "Your OnBreak subscription plan is expired on ".date('F d,Y',strtotime($package->end_date)).".";
            $rEmail     = $package->student->email;
            $data = ['package' => $package];
            Mail::send($rTemplate, $data, function ($m) use ($rEmail, $rSubject) {
                $m->from(env('MAIL_FROM_ADDRESS'), env('MAIL_FROM_NAME'));
                $m->to($rEmail)->subject($rSubject);
            });
        }
    }

    private function startHoldPackage() {
        $remindDate = date('Y-m-d');
        $packages = StudentPackages::whereRaw("start_date = '".$remindDate."'::date")
                                    ->where('status', 'onhold')
                                    ->with(['package', 'student'])
                                    ->get();

        foreach ($packages as $package) {
            $package->status = 'active';
            $package->save();
            $rTemplate  = "emails.expire.onbreak-expired";
            $rSubject   = "Your OnBreak subscription plan is expired on ".date('F d,Y',strtotime($package->end_date)).".";
            $rEmail     = $package->student->email;
            $data = ['package' => $package];
            Mail::send($rTemplate, $data, function ($m) use ($rEmail, $rSubject) {
                $m->from(env('MAIL_FROM_ADDRESS'), env('MAIL_FROM_NAME'));
                $m->to($rEmail)->subject($rSubject);
            });
        }
    }

    private function teacherPaypalCheck() {
        $teacherTransactions = TeacherPayoutTransactions::where('status','Pending')
                                ->with('teacher','teacherDetail')->all();
        foreach ($teacherTransactions as $tptK => $tpt) {
            if ($tpt->teacher->paypal_email) {
                $output = AppHelper::payout($tpt->amount, $tpt->teacher_id);
                if ($output != 'Fail') {
                    $tpt->transaction_ref_id = $output->getBatchHeader()->getPayoutBatchId();
                    $tpt->transaction_response = json_encode($output);
                    $tpt->status = 'success';
                    $tpt->save();
                } else {
                    $tpt->transaction_ref_id = '';
                    $tpt->transaction_response = json_encode($output);
                    $tpt->status = 'fail';
                    $tpt->save();
                }
            }
        }
    }
}
