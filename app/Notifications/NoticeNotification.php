<?php

namespace App\Notifications;

use App\Jobs\SendNotificationEmail;
use App\Mail\NoticeMail;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Mail;

class NoticeNotification extends Notification
{
    use Queueable;

    protected $data;

    public function __construct($data)
    {
        $this->data = $data;
    }

    public function via(object $notifiable): array
    {
        return ['database'];
    }

    public function toMail(object $notifiable)
    {
    }

    public function toDatabase(object $notifiable): array
    {
        $email = $notifiable->email;
        SendNotificationEmail::dispatch($email,$notifiable, $this->data);
        return [
            'title' => $this->data->title,
            'content' => $this->data->content,
            'time' => now()
        ];
    }
}
