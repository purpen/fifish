<?php

namespace App\Jobs;

use Log;
use DB;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Contracts\Mail\Mailer;

use App\Jobs\Job;
use App\Http\Models\User;

class SendReminderEmail extends Job implements ShouldQueue
{
    use InteractsWithQueue, SerializesModels;
    
    /**
     * User Model
     */
    protected $user;
    
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(User $user)
    {
        $this->user = $user;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle(Mailer $mailer)
    {
        Log::debug('This is a send mail job!');
        // $mailer->send('emails.reminder', ['user' => $this->user], function ($m) {
        //     Log::debug('This is a send mail job!');
        // });
    }
    
}
