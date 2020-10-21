<?php

namespace App\Jobs;

use App\Models\Settings;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\Log;
use Mail;

class SendEmailJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $template;
    public $data;
    public $subject;
    public $type;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($template, $data, $subject, $type = 'admin')
    {
        $this->template = $template;
        $this->data = $data;
        $this->subject = $subject;
        $this->type = $type;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $template = $this->template;
        $data = $this->data;
        $subject = $this->subject;

        $from_email = Settings::getSettings('email_address');
        $to_email   = Settings::getSettings('to_email');

        if ($this->type == 'admin') {
            Mail::send($template, ['data' => $data], function ($m) use ($data, $subject, $from_email, $to_email) {
                $m->from($from_email, env('MAIL_FROM_NAME'));
                $m->to('phpjoomlawp@gmail.com', 'Admin')->cc($to_email)->subject($subject);
            });
        } else if ($this->type == 'user') {
            Mail::send($template, ['data' => $data], function ($m) use ($data, $subject, $from_email, $to_email) {
                $m->from($from_email, env('MAIL_FROM_NAME'));
                $m->to($data['user']['email'])->cc($to_email)->subject($subject);
				$m->bcc(env('BCC_EMAIL'), env('BCC_EMAIL_NAME'));
            });
        } else if ($this->type == 'other') {
            Mail::send($template, ['data' => $data], function ($m) use ($data, $subject, $from_email, $to_email) {
                $m->from($from_email, env('MAIL_FROM_NAME'));
                $m->to($data['receiver'])->cc($to_email)->subject($subject);
				$m->bcc(env('BCC_EMAIL'), env('BCC_EMAIL_NAME'));
            });
        } else if ($this->type == 'point_mail') {
            Mail::send($template, ['data' => $data], function ($m) use ($data, $subject, $from_email, $to_email) {
                $m->from($from_email, env('MAIL_FROM_NAME'));
                $m->to($data['receiver']['email'])->cc($to_email)->subject($subject);
				$m->bcc(env('BCC_EMAIL'), env('BCC_EMAIL_NAME'));
            });
        } else {
            Mail::send($template, ['data' => $data], function ($m) use ($data, $subject, $from_email, $to_email) {
                $m->from($from_email, env('MAIL_FROM_NAME'));
                $m->to($data['user']['email'])->cc($to_email)->subject($subject);
				$m->bcc(env('BCC_EMAIL'), env('BCC_EMAIL_NAME'));
            });
        }

    }
}
