<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class SendEmailJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $email;
    private $name;
    private $code;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(string $email, string $name, string $code)
    {
        $this->email = $email;
        $this->name = $name;
        $this->code = $code;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $email = $this->email;
        $name = $this->name;
        $data['appName'] = 'Blog App';
        $data['code'] = $this->code;
        Mail::send('emails.email_verification', $data, function ($message) use ($email, $name) {
            $message->from('blog@gmail.com', 'Blog App');
            $message->to($email, $name)->subject('Verification Code');
        });
    }
}
