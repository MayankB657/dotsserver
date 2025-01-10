<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class SendNotificationEmail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $email;
    protected $notifiable;
    protected $data;

    public function __construct($email,$notifiable,$data)
    {
        $this->email = $email;
        $this->notifiable = $notifiable;
        $this->data = $data;
    }

    public function handle()
    {
        $data = $this->data;
        $notifiable = $this->notifiable;
        $email = $this->email;
        Mail::send('mail-templates.notice',compact('email','data','notifiable'), function ($message) use ($email,$data) {
            $message->to($email);
            $message->subject($data->title);
        });
    }
}
