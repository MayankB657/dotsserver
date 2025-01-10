<?php

namespace App\Jobs;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;
use App\Models\User;

class CommentMailSend implements ShouldQueue
{
    // use Queueable;
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;


    /**
     * Create a new job instance.
     */
    protected $user;
    protected $cmt;
    protected $auth;
 

    public function __construct($user, $cmt, $auth)
    {
        $this->user = $user;
        $this->cmt = $cmt;
        $this->auth = $auth;      
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $user = $this->user;
        $email = $user->email;
        $cmt = $this->cmt;
        $auth = $this->auth;

        Mail::send('mail-templates.Comment', compact('user','cmt','email','auth'), function ($message) use ($email) {    
            $message->to($email);
            $message->subject("You are Tagged in a Comment.");
        });

    }
}
