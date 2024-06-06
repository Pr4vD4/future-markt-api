<?php

namespace App\Jobs;

use App\Mail\ApplicationMail;
use App\Models\Application;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class ApplicationMailJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $mail_to, $data;


    protected function create_mail_data(Application $application)
    {
        $data = [
            'title' => 'Заявка с сайта FutureMarkt:' . $application->web_site->name,
            'phone' => 'Телефон:' . $application->phone,
        ];

        if (isset($application->name)) {
            $data['name'] = $application->name;
        }

        if (isset($application->body)) {

            $data['body'] = json_decode($application->body);

        }

        return $data;
    }

    /**
     * Create a new job instance.
     */
    public function __construct(Application $application)
    {
        $this->mail_to = 'sergei.future.work@gmail.com';
        $this->data = $this->create_mail_data($application);
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $email = new ApplicationMail($this->data);
        Mail::to($this->mail_to)->send($email);
    }
}
