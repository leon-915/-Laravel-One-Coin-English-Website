<?php

namespace App\Http\Controllers\Teacher;

use App\Helpers\AppHelper;
use App\Models\PostJob;
use App\Models\PostJobBid;
use App\Models\StudentDetail;
use App\Models\TeacherPayoutTransactions;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use PayPal\Api\Currency;
use PayPal\Api\Payout;
use PayPal\Api\PayoutItem;
use PayPal\Api\PayoutSenderBatchHeader;
use PayPal\Auth\OAuthTokenCredential;
use PayPal\Rest\ApiContext;
use Yajra\DataTables\DataTables;
use App\User;
use Illuminate\Support\Facades\Mail;

class BidJobController extends Controller
{
    public function jobList()
    {
        $jobs = PostJob::with('student')
            ->whereNull('bid_id')
            ->get();

        return view('teachers.bid-job.index', compact('jobs'));
    }

    public function acceptBid($id)
    {
        $job = PostJob::where('id', $id)->first();

        $bidJobData['job_id'] = $id;
        $bidJobData['user_id'] = Auth::id();
        $bidJobData['bid_price'] = $job->price;
        $bidJobData['status'] = 'accepted';

        $bid = PostJobBid::create($bidJobData);

        $job->bid_id = $bid->id;
        $job->save();
	
		$student_id = $job->user_id;
		$student = User::where('id', $student_id)->first();
		
		$teacher = User::where('id', Auth::id())->first();	
		
		if ((env('APP_ENV') == 'production')) {
            $shareTemplate = "emails.accept-bid";
			$jobpostSubject = "Bid accepted on translation job";
			
				$shdata = [				
					'teacher_firstname' => $teacher->firstname,
					'teacher_lastname' => $teacher->lastname,
					'job_title' => $job->subject,
					'job_description' => $job->highlights,
					'bid_amount' => $job->price,
					'id' => $job->bid_id,
				];
				$email = $student->email;
				
				Mail::send($shareTemplate, ['data' => $shdata], function ($m) use ($email, $jobpostSubject) {
                    $m->from(env('MAIL_FROM_ADDRESS'), env('MAIL_FROM_NAME'));
                    $m->to($email)->subject($jobpostSubject);
					$m->bcc(env('BCC_EMAIL'), env('BCC_EMAIL_NAME'));
                });
               
        }
        return redirect()->route('teachers.job.list')->with(['message' => 'Job bid Successfully Accepted']);
    }

    public function jobBidHistory()
    {
//        $jobs = PostJobBid::with('job')->where('user_id',Auth::id())->get();
//        dd($jobs);
        return view('teachers.bid-job.history');
    }

    public function jobBidTable()
    {
        $jobs = PostJobBid::with('job')->where('job_post_bid.user_id', Auth::id());

        return DataTables::of($jobs)

            ->addIndexColumn()
            ->addColumn('student', function ($jobs) {
                return $jobs->job->student->firstname . ' ' . $jobs->job->student->lastname;
            })
            ->editColumn('created_at', function ($jobs) {
                return Carbon::parse($jobs->created_at)->format('Y-m-d');
            })
            ->editColumn('time', function ($jobs) {
                return Carbon::parse($jobs->created_at)->format('H:i');
            })
            ->editColumn('bid_price', function ($jobs) {
                return '¥'.number_format($jobs->bid_price,2);
            })
            ->editColumn('job.price', function ($jobs) {
                return '¥'.number_format($jobs->job->price,2);
            })
            ->editColumn('action', function ($job) {
                return '<a href="' . url('teacher/history-detail/' . $job->id) . '">View</a>';
            })
            ->make(true);
    }

    public function historyDetail($id)
    {
//        $job = PostJob::with('postJobBid')
//            ->where('id', $id)
//            ->first();

        $postJobBid = PostJobBid::with('job', 'teacher')->where('id', $id)
//            ->where('status', 'pending')
            ->first();

        return view('teachers.bid-job.history-detail', compact('postJobBid'));
    }

    public function makebid(Request $request)
    {
        $bidJobData['job_id'] = $request->job_id;
        $bidJobData['user_id'] = Auth::id();
        $bidJobData['bid_price'] = $request->amount;
        $bidJobData['status'] = 'pending';

        PostJobBid::create($bidJobData);
		
		$job = PostJob::where('id', $request->job_id)->first();
		$student_id = $job->user_id;
		$student = User::where('id', $student_id)->first();
		
		$user_id = Auth::user()->id;
        $teacher = User::where('id', $user_id)->first();
		
		if ((env('APP_ENV') == 'production')) {
            $shareTemplate = "emails.make-bid";
			$jobpostSubject = "Bid recieved on translation job";
			
			
				$shdata = [				
					'teacher_firstname' => $teacher->firstname,
					'teacher_lastname' => $teacher->lastname,
					'job_title' => $job->subject,
					'job_description' => $job->highlights,
					'bid_amount' => $request->amount,
				];
				$email = $student->email;
				
                Mail::send($shareTemplate, ['data' => $shdata], function ($m) use ($email, $jobpostSubject) {
                    $m->from(env('MAIL_FROM_ADDRESS'), env('MAIL_FROM_NAME'));
                    $m->to($email)->subject($jobpostSubject);
					$m->bcc(env('BCC_EMAIL'), env('BCC_EMAIL_NAME'));
                });
               
        }
		
        return response()->json(['type' => 'success', 'message' => 'Bid added Successfully']);
    }

    public function addTranslation(Request $request)
    {
        $input = $request->all();

        $job = PostJob::where('id', $input['id'])->first();
		
		$student_id = $job->user_id;
		$student = User::where('id', $student_id)->first();
		
        $postjobBid = PostJobBid::where('id', $input['bid_id'])->first();

        //$amount = number_format((float)$postjobBid->bid_price, 2, '.', '');
		
		$admin_commision = Settings::getSettings('admin_commision');
		$student_referred_admin_commision = Settings::getSettings('student_referred_admin_commision');

        if(Auth::id() == $student->referred_by){
			$percent = 100 - $student_referred_admin_commision;
        } else {
			$percent = 100 - $admin_commision;
        }
		$teacher_earning = round($postjobBid->bid_price * ($percent / 100));
		$amount = number_format((float)$teacher_earning, 2, '.', '');
		
		
		
        $output = AppHelper::payout($amount, Auth::id());
        if ($output != 'Fail') {
            $teacherPayoutArray['teacher_id'] = Auth::id();
            $teacherPayoutArray['amount'] = $amount;
            $teacherPayoutArray['transaction_ref_id'] = $output->getBatchHeader()->getPayoutBatchId();
            $teacherPayoutArray['transaction_response'] = json_encode($output);
            $teacherPayoutArray['payout_type'] = 'job';
            $teacherPayoutArray['payout_ref_id'] = $job->id;
            $teacherPayoutArray['status'] = 'success';

            TeacherPayoutTransactions::create($teacherPayoutArray);


            $job->translation = $input['text'];
            $job->status = 'completed';
            $job->save();

            $postjobBid->status = 'completed';
            $postjobBid->save();

            $studentDetails = StudentDetail::where('user_id', $student_id)->first();
            $creditPoints = $studentDetails->credit_balance;
            $rew_points = $studentDetails->reward_balance;

            if ($creditPoints >= $amount) {
                $finalCredit = $creditPoints - $amount;
                $studentDetails->credit_balance = $finalCredit;
            } else {
                $reward_points = $creditPoints - $amount;
                $final_rew_points = $rew_points - $reward_points;
                $studentDetails->credit_balance = 0;
                $studentDetails->reward_balance = $final_rew_points;
            }

            $studentDetails->save();


            return response()->json(['type' => 'success', 'message' => 'Post added Successfully']);
        } else {
            $teacherPayoutArray['teacher_id'] = Auth::id();
            $teacherPayoutArray['amount'] = $amount;
            $teacherPayoutArray['transaction_ref_id'] = '';
            $teacherPayoutArray['transaction_response'] = json_encode($output);
            $teacherPayoutArray['payout_type'] = 'job';
            $teacherPayoutArray['payout_ref_id'] = $job->id;
            $teacherPayoutArray['status'] = 'fail';

            TeacherPayoutTransactions::create($teacherPayoutArray);

            return response()->json(['type' => 'fail', 'message' => json_encode($output)]);
        }
    }
}
