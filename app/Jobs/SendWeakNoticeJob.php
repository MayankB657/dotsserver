<?php

namespace App\Jobs;

use App\Models\Group;
use App\Models\Notice;
use App\Models\Roles;
use App\Models\User;
use App\Notifications\NoticeNotification;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Notification;

class SendWeakNoticeJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $noticeId;

    public function __construct($noticeId)
    {
        $this->noticeId = $noticeId;
    }

    public function handle(): void
    {
        $notice = Notice::find($this->noticeId);
        if ($notice->is_enable) {
            if ($notice->send_at == null) {
                $notice->is_send = 1;
                $notice->send_at = now();
                $notice->save();
            }
            $users = $this->getUsers($notice);
            foreach ($users ?? [] as $userId) {
                $dbuser = User::find($userId);
                Notification::send($dbuser, new NoticeNotification($notice));
            }
        }
    }

    private function getUsers($notice)
    {
        $user_ids = [];

        foreach ($notice->users as $noticeUser) {
            if (!in_array($noticeUser->users_id, $user_ids)) {
                $user_ids[] = $noticeUser->users_id;
            }
        }
        foreach ($notice->groups as $noticeGroup) {
            $group = Group::find($noticeGroup->groups_id);
            foreach ($group->users as $user) {
                if (!in_array($user->id, $user_ids)) {
                    $user_ids[] = $user->id;
                }
            }
        }
        foreach ($notice->roles as $noticeRole) {
            $role = Roles::find($noticeRole->roles_id);
            foreach ($role->users as $user) {
                if (!in_array($user->id, $user_ids)) {
                    $user_ids[] = $user->id;
                }
            }
        }
        if ($notice->send_to == "Everyone") {
            $users = User::all();
            foreach ($users as $user) {
                if (!in_array($user->id, $user_ids)) {
                    $user_ids[] = $user->id;
                }
            }
        }
        return $user_ids;
    }
}
