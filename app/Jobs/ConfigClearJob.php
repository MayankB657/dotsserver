<?php

namespace App\Jobs;

use Carbon\Carbon;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class ConfigClearJob implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new job instance.
     */
    public function __construct()
    {

    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $email = "mayu.bhandure657@gmail.com"; //server admin email here when created
        $dt = Carbon::now()->format('Y-m-d H:i:s');
        Mail::send('mail-templates.configclear',compact('dt'), function ($message) use ($email) {
            $message->to($email);
            $message->subject('Configuration Cleared');
        });
    }
}
