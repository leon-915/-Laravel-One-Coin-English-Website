<?php

namespace App\Http\Controllers\Student;

use App\Http\Requests\Student\PostJob\PostJobRequest;
use App\Models\PostJob;
use App\Models\PostJobBid;
use App\Models\StudentPackages;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\DataTables;
use App\User;
use Illuminate\Support\Facades\DB;
use App\Jobs\SendEmailJob;
use Illuminate\Support\Facades\Mail;
use App\Models\StudentDetail;


class JobPostController extends Controller
{
    public function index()
    {
        $user_id = Auth::id();
        $job = PostJob::with('postJobBid')->where('user_id', $user_id)
            ->whereNull('bid_id')
            ->latest()
            ->first();

        return view('students.post-job.index', compact('job'));
    }

    public function postJobForm()
    {
        $user_id = Auth::id();
        $package = StudentPackages::where('user_id', $user_id)
            ->whereRaw("start_date <= '" . date('Y-m-d') . "'::date")
            ->whereRaw("end_date >= '" . date('Y-m-d') . "'::date")
            ->where('status', 'active')
            ->with('package')
            ->first();

        if (empty($package)) {
            return redirect()->route('students.post.job.index')->with(['error' => 'Please Subscribe for package for posting job']);
        }

        return view('students.post-job.form');
    }

    public function postJobStore(PostJobRequest $request)
    {
        $user = Auth::user();
        $input = $request->all();
		$user_id = Auth::user()->id;
		$student = User::where('id', $user_id)->first();
        $studentDetails = $student->details()->first();		
		if($input['price'] > ($studentDetails->credit_balance)) {
			return redirect()->route('students.post.job.index')->with(['error' => 'You don\'t have sufficient balance to post this job.']);
		}
		
        $finalArray['user_id'] = $user->id;
        $finalArray['title'] = $input['subject'];
        $finalArray['subject'] = $input['subject'];
        $finalArray['price'] = $input['price'];
        $finalArray['highlights'] = $input['description'];
        $finalArray['status'] = 'pending';
        PostJob::create($finalArray);
		
		$teachers = User::select('users.*')
                    ->whereRaw("users.user_type LIKE 'teacher'")
                    ->get();
		


		if ((env('APP_ENV') == 'production')) {
            $shareTemplate = "emails.job-post";
			$jobpostSubject = "Translation work from accent-language";
			
			foreach ($teachers as $teacher) {
				$shdata = [
				
					'student_firstname' => $user->firstname,
					'student_lastname' => $user->lastname,
					'teacher_fname' => $teacher->firstname,
					'teacher_lname' => $teacher->lastname,
					'job_title' => $input['subject'],
					'job_description' => $input['description'],
					'price' => $input['price'],
				];
				$email = $teacher->email;
				
                Mail::send($shareTemplate, ['data' => $shdata], function ($m) use ($email, $jobpostSubject) {
                    $m->from(env('MAIL_FROM_ADDRESS'), env('MAIL_FROM_NAME'));
                    $m->to($email)->subject($jobpostSubject);
					$m->bcc(env('BCC_EMAIL'), env('BCC_EMAIL_NAME'));
                });
            }     
        }
		
        return redirect()->route('students.post.job.index')->with(['message' => 'Job posted Successfully']);
    }

    public function jobhistory()
    {
        return view('students.post-job.history');
    }

    public function jobhistoryTable()
    {
        $user_id = Auth::id();
        $job = PostJob::with('bid')
            ->where('user_id', $user_id)
            ->latest();

        return DataTables::of($job)
            ->editColumn('subject', function ($job) {
                 return '<a href="' . url('student/bid-detail/' . $job->id) . '">'.$job->subject.'</a>';
            })
			->editColumn('created_at', function ($job) {
                return Carbon::parse($job->created_at)->format('M d,Y');
            })
            ->editColumn('bid.bid_price', function ($job) {
                return $job->bid ? $job->bid->bid_price : 0;
            })
            ->editColumn('bid.teacher.firstname', function ($job) {
                return $job->bid ? $job->bid->teacher->firstname : '';
            })
            ->editColumn('action', function ($job) {
                return '<a href="' . url('student/history-detail/' . $job->id) . '">View</a>';
            })
            ->make(true);
    }

    public function historyDetail($id)
    {
        $job = PostJob::with('bid','postJobBid')
            ->where('id', $id)
            ->first();

        return view('students.post-job.history-detail', compact('job'));
    }
	
	public function bidDetail($id)
    {
        $job = PostJob::select([
                'student_job_post.*', 'job_post_bid.user_id as teacher_id', 'job_post_bid.bid_price', 'job_post_bid.status as bid_status', 'job_post_bid.id as bid_id',
				DB::raw("CONCAT(users.firstname, ' ', users.lastname) AS teacher_name"),
				])
			->where('student_job_post.id', $id)
			->leftJoin('job_post_bid', 'job_post_bid.job_id', 'student_job_post.id')
			->leftJoin('users', 'users.id', 'job_post_bid.user_id')
            ->get();
		

        return view('students.post-job.biddetail', compact('job'));
    }
	
    public function acceptBid($id)
    {
		$bid = PostJobBid::where('id', $id)->first();
		$user_id = Auth::user()->id;
		$student = User::where('id', $user_id)->first();
        $studentDetails = $student->details()->first();		
		if($bid->bid_price > ($studentDetails->credit_balance)) {
			return redirect()->route('students.post.job.bidDetail',['id' => $bid->job_id])->with(['error' => 'You don\'t have sufficient balance to accept this job.']);
		}
        
        $bid->status = 'accepted';
        $bid->save();

        $job_id = $bid->job_id;
        $job = PostJob::where('id', $job_id)->first();
        $job->bid_id = $id;
        $job->status = 'Processing';
        $job->save();
		
		$teacher_id = $bid->user_id;
		$teacher = User::where('id', $teacher_id)->first();
		
		$student = User::where('id', Auth::id())->first();	
		
		if ((env('APP_ENV') == 'production')) {
            $shareTemplate = "emails.bid-approved";
			$jobpostSubject = "Your bid has been accepted on translation job";
			
				$shdata = [				
					'job_title' => $job->subject,
					'job_description' => $job->highlights,
					'bid_amount' => $bid->bid_price,
				];
				$email = $teacher->email;
				
				Mail::send($shareTemplate, ['data' => $shdata], function ($m) use ($email, $jobpostSubject) {
                    $m->from(env('MAIL_FROM_ADDRESS'), env('MAIL_FROM_NAME'));
                    $m->to($email)->subject($jobpostSubject);
					$m->bcc(env('BCC_EMAIL'), env('BCC_EMAIL_NAME'));
                });
               
        }
		
        return redirect()->route('students.post.job.index')->with(['message' => 'Bid accepted']);
    }

    public function rejectBid($id)
    {
        $bid = PostJobBid::where('id', $id)->first();
        $bid->status = 'rejected';
        $bid->save();

		$teacher_id = $bid->user_id;
		$teacher = User::where('id', $teacher_id)->first();
		
		$student = User::where('id', Auth::id())->first();	
		$job = PostJob::where('id', $bid->job_id)->first();
		
		if ((env('APP_ENV') == 'production')) {
            $shareTemplate = "emails.bid-rejected";
			$jobpostSubject = "Your bid on translation job has been rejected";
			
				$shdata = [				
					'job_title' => $job->subject,
					'job_description' => $job->highlights,
					'bid_amount' => $bid->bid_price,
				];
				$email = $teacher->email;
				
				Mail::send($shareTemplate, ['data' => $shdata], function ($m) use ($email, $jobpostSubject) {
                    $m->from(env('MAIL_FROM_ADDRESS'), env('MAIL_FROM_NAME'));
                    $m->to($email)->subject($jobpostSubject);
					$m->bcc(env('BCC_EMAIL'), env('BCC_EMAIL_NAME'));
                });
               
        }
		
        return redirect()->route('students.post.job.index')->with(['message' => 'Bid rejected']);
    }

    public function addRating(Request $request)
    {
        $rating = $request->rate;
        $job_id = $request->job_id;
        $job = PostJob::where('id', $job_id)->first();
        $job->rating = $rating;
        $job->save();

        return response()->json(['message' => 'Job rated successfully']);

    }
}
