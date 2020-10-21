<?php

namespace App\Http\Controllers;

use App\Helpers\AppHelper;
use App\Jobs\SendEmailJob;
use App\Models\AdminUser;
use App\Models\ContactUs;
use App\Models\Settings;
use App\Models\StudentLessonsBooking;
use App\Models\Services;
use App\Models\Packages;
use App\Models\StudentPackages;
use App\Models\Testimonial;
use Illuminate\Http\Request;
use App\User;
use Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Redirect;
use Kigkonsult\Icalcreator\IcalBase;
use Kigkonsult\Icalcreator\Vcalendar;
use Carbon\Carbon;
use DateTime;
use DateTimeZone;

class CmsController extends Controller
{
    public function __construct()
    {
        //$this->middleware('auth');
    }

    public function privacy_policy()
    {
        return view('cms.privacy_policy');
    }

    public function terms_of_use()
    {
        return view('cms.terms_of_use');
    }

    public function about_us()
    {
        return view('cms.about_us');
    }

    public function faq()
    {
        return view('cms.faq');
    }

    public function company_profile()
    {
        return view('cms.company_profile');
    }

    public function contact_us()
    {
        return view('cms.contact_us');
    }

    public function aspire_couching()
    {
        return view('cms.aspire_couching');
    }

    public function eatt()
    {
        return view('cms.eatt');
    }

    public function customised_course()
    {
		$testimonials = Testimonial::all()->where('status', 1)->random(3);	
		$teachers = AppHelper::get_published_teachers();		
        return view('cms.customised_course', compact('testimonials', 'teachers'));
    }

    public function onepage_canvas()
    {
		$testimonials = Testimonial::all()->where('status', 1)->random(3);	
		$teachers = AppHelper::get_published_teachers();		
        return view('cms.onepage_canvas', compact('testimonials', 'teachers'));
    }

    public function lesson_anywhere()
    {
		$testimonials = Testimonial::all()->where('status', 1)->random(3);	
		$teachers = AppHelper::get_published_teachers();		
        return view('cms.lesson_anywhere', compact('testimonials', 'teachers'));
    }	

    public function language_partners()
    {
		$testimonials = Testimonial::all()->where('status', 1)->random(3);		
		$teachers = AppHelper::get_published_teachers();		
        return view('cms.language_partners', compact('testimonials', 'teachers'));
    }	

    public function pricing()
    {
		$packages =  Packages::where('status',1)->orderBy('id','ASC')->get();
        $studentPackage = StudentPackages::where('user_id',Auth::id())->first();
        $onbreak = Services::where('service_type', 'onbreak')->first();
		$ref = 'classroom';
		
		$testimonials = Testimonial::all()->where('status', 1)->random(3);	
		$teachers = AppHelper::get_published_teachers();		
        return view('cms.pricing', compact('testimonials', 'teachers', 'packages', 'studentPackage', 'onbreak', 'ref'));
    }

    public function testimonials()
    {
		$testimonials = Testimonial::where('status', 1)->get();	
		$teachers = AppHelper::get_published_teachers();										
        return view('cms.testimonials', compact('testimonials', 'teachers'));
    }

    public function casual_conversation()
    {
		$testimonials = Testimonial::all()->where('status', 1)->random(3);
		$teachers = AppHelper::get_published_teachers();		
        return view('cms.casual_conversation', compact('testimonials', 'teachers'));
    }

    public function kids()
    {
		$testimonials = Testimonial::all()->where('status', 1)->random(3);	
		$teachers = AppHelper::get_published_teachers();		
        return view('cms.kids', compact('testimonials', 'teachers'));
    }

    public function aspire_coaching()
    {
		$testimonials = Testimonial::all()->where('status', 1)->random(3);	
		$teachers = AppHelper::get_published_teachers();		
        return view('cms.aspire_coaching', compact('testimonials', 'teachers'));
    }

    public function newhome()
    {
		$testimonials = Testimonial::all()->where('status', 1)->random(3);
		$teachers = AppHelper::get_published_teachers();

        return view('newhome', compact('testimonials', 'teachers'));
    }

    public function contact_us_store(Request $request) {
        $request->validate([
            'captcha_code' => 'required|valid_captcha',
        ]);

        $input = $request->all();
        $data = [];
        $data['name'] = $input['name'];
        $data['email'] = $input['email'];
        $data['subject'] = $input['subject'];
        $data['message'] = $input['message'];
        $data['status'] = 2;

        ContactUs::create($data);

        $admin = AdminUser::pluck('email')->first();

        $from_email = Settings::getSettings('email_address');
        $site_title = Settings::getSettings('site_title');
        $to_email = Settings::getSettings('to_email');

        if (!empty($admin)) {
            $template = "emails.contact_us_email";
            $subject = $data['name'] . " Want us to contact you ";

            $data = ['user' => $data, 'receiver' => $admin,'site_title'=>$site_title];

            Mail::send($template, ['data' => $data], function ($m) use ($input, $to_email, $subject) {
                $m->from($input['email'], $input['name']);
                $m->to($to_email)->subject($subject);
				$m->bcc(env('BCC_EMAIL'), env('BCC_EMAIL_NAME'));
            });

            //dispatch(new SendEmailJob($template, $data, $subject, 'other'));
        }

        return Redirect::back()->with('message','Message Send Successfully');
    }

    public function freshbookToken(Request $request) {
        AppHelper::freshbookAuth($request->get('code'));
    }

    public function generateIcal($teacher_id) {
        $user_id = $teacher_id;
        $teacher = User::where('id', $user_id)->first();
        $teacherDetails = $teacher->details()->first();

        $teacherLessons = StudentLessonsBooking::select([
            'student_lessons_bookings.*',
            DB::raw("CONCAT(users.firstname, ' ', users.lastname) AS student_name"),
            DB::raw("location.title AS location"),
            'services.title AS service',
            DB::raw("'0' AS earnings"),
        ])
		->where('teacher_id', $user_id)
		->whereRaw("lession_date >= '".date('Y-m-d')."'::date")
		
            ->leftJoin('users', 'users.id', 'student_lessons_bookings.user_id')
            ->leftJoin('location', 'location.id', 'student_lessons_bookings.location_id')
            ->leftJoin('services', 'services.id', 'student_lessons_bookings.service_id')->get();

        $vcalendar = Vcalendar::factory()
                        ->setMethod( Vcalendar::PUBLISH )
                        ->setXprop( Vcalendar::X_WR_CALNAME, env('APP_NAME')." calender")
                        ->setXprop( Vcalendar::X_WR_CALDESC, env('APP_NAME')." calender")
                        ->setXprop( Vcalendar::X_WR_RELCALID, "3E26604A-50F4-4449-8B3E-E4F4932D05B5")
                        ->setXprop( Vcalendar::X_WR_TIMEZONE, "Asia/Tokyo");
        if (!empty($teacherLessons)) {
            foreach ($teacherLessons as $lesson) {
                $startDate = str_replace('-', '', $lesson['lession_date']);
                $startTime = str_replace(':', '', $lesson['lession_time']);
                $startDate = $startDate . 'T' . $startTime;

                $endDate = date("Ymd" . '\T' . "His", strtotime("+" . $lesson['lesson_duration'] . " minutes", strtotime($startDate)));


                $vcalendar->newVevent()
                    ->setTransp(Vcalendar::OPAQUE)
                    ->setClass(Vcalendar::P_BLIC)
                    ->setSequence(1)
                    ->setSummary(
                        $lesson['student_name']
                    )
					->setDescription(
                        $lesson['service'] . '-' . $lesson['student_name']
                    )
                    ->setLocation($lesson->location)
                    ->setDtstart(
                        new DateTime(
                            $startDate,
                            new DateTimezone('Asia/Tokyo')
                        )
                    )
                    ->setDtend(
                        new DateTime(
                            $endDate,
                            new DateTimezone('Asia/Tokyo')
                        )
                    );
            }
        }

        $vcalendarString =$vcalendar->vtimezonePopulate()->createCalendar();

        header('Content-type: text/calendar; charset=utf-8');
        header('Content-Disposition: attachment; filename=event.ics');
        echo $vcalendarString;
    }
}
