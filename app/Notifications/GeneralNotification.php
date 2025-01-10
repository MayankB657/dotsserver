<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class GeneralNotification extends Notification
{
    use Queueable;

    protected $title;
    protected $desc;

    public function __construct($title,$desc)
    {
        $this->title = $title;
        $this->desc = $desc;
    }

    public function via(object $notifiable): array
    {
        return ['database'];
    }

    public function toDatabase(object $notifiable): array
    {
        $email = $notifiable->email;
        // SendNotificationEmail::dispatch($email,$notifiable, $this->data);
        return [
            'title' => $this->title,
            'content' => $this->desc,
            'time' => now()
        ];
    }
}
