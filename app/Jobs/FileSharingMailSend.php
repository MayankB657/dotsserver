<?php

namespace App\Jobs;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class FileSharingMailSend implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $userId;
    protected $data;
    protected $url;

    public function __construct($userId, $data,$url)
    {
        $this->userId = $userId;
        $this->data = $data;
        $this->url = $url;
    }

    public function handle(): void
    {
        $user = User::find($this->userId);
        $email = $user->email;
        $data = $this->data;
        $link = $this->url;
            Mail::send('mail-templates.filesharing', compact('data', 'user','link'), function ($message) use ($email) {
            $message->to($email);
            $message->subject("File shared with you.");
        });
    }
}
