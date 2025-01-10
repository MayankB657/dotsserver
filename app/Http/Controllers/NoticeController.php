<?php

namespace App\Http\Controllers;

use App\Jobs\SendNoticeJob;
use App\Jobs\SendWeakNoticeJob;
use App\Models\Group;
use App\Models\Notice;
use App\Models\NoticeGroups;
use App\Models\NoticeRoles;
use App\Models\NoticeUsers;
use App\Models\Role;
use App\Models\User;
use App\Notifications\NoticeNotification;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Notification;

class NoticeController extends Controller
{
    public function index()
    {
        $groups = Group::get();
        $roles = Role::get();
        $users = User::get();
        $data = Notice::paginate(10);
        return view('notice.index', compact('data', 'groups', 'roles', 'users'));
    }

    public function store(Request $request)
    {
        $url = 'https://node.sizaf.com/received';
        try {
            DB::beginTransaction();
            $notice = new Notice();
            $notice->title = ucfirst($request->title);
            $notice->content = $request->content;
            $notice->send_to = $request->send_to;
            $notice->is_schedule = $request->is_schedule;
            $notice->schedule_time = Carbon::parse($request->schedule_time)->format('Y-m-d H:i:s');
            $notice->type = $request->type;
            if (isset($request->is_enable)) {
                $notice->is_enable = $request->is_enable;
            } else {
                $notice->is_enable = 0;
            }
            $notice->save();


            //saving all groups, users and roles
            foreach ($request->groups_id ?? [] as $value) {
                $groups = new NoticeGroups();
                $groups->notice_id = $notice->id;
                $groups->groups_id = $value;
                $groups->save();
            }
            foreach ($request->roles ?? [] as $value) {
                $roles = new NoticeRoles();
                $roles->notice_id = $notice->id;
                $roles->roles_id = $value;
                $roles->save();
            }
            foreach ($request->users ?? [] as $value) {
                $user = new NoticeUsers();
                $user->notice_id = $notice->id;
                $user->users_id = $value;
                $user->save();
            }
            $users = [];
            if ($notice->type == "Weak hint") {
                if ($request->is_schedule == 0 && $notice->is_enable) {
                    $notice->send_at = now();
                    $notice->is_send = 1;
                    $notice->save();
                    $users = $this->getUsers($notice);
                    foreach ($users as $value) {
                        $dbuser = User::find($value);
                        Notification::send($dbuser, new NoticeNotification($notice));
                    }
                } else if ($request->is_schedule == 1) {
                    if ($notice->is_enable) {
                        $time = Carbon::parse($request->schedule_time);
                        $users = $this->getUsers($notice);
                        SendWeakNoticeJob::dispatch($notice->id)->delay($time);
                    }
                }
                DB::commit();
                return json_encode(['schedule' => true]);
            } else {
                if ($request->is_schedule == 0 && $notice->is_enable) {
                    //to send imidiatly
                    $users = $this->getUsers($notice);
                    $notice->send_at = now();
                    $notice->is_send = 1;
                    $notice->save();
                    foreach ($users as $value) {
                        $dbuser = User::find($value);
                        Notification::send($dbuser, new NoticeNotification($notice));
                    }
                    DB::commit();
                    return json_encode(['users' => $users, 'data' => $notice, 'schedule' => false]);
                } else if ($request->is_schedule == 1) {
                    // for schedule
                    $time = Carbon::parse($request->schedule_time);
                    $users = $this->getUsers($notice);
                    if ($notice->is_enable) {
                        SendWeakNoticeJob::dispatch($notice->id)->delay($time);
                    }
                    SendNoticeJob::dispatch($notice->id, $url)->delay($time);
                    DB::commit();
                    return json_encode(['schedule' => true]);
                }
            }
        } catch (\Throwable $th) {
            DB::rollback();
            throw $th;
        }
    }

    public function show($id)
    {
        //used for change status
        $data = Notice::find($id);
        $data->is_enable = $data->is_enable ? 0 : 1;
        $data->save();
        return json_encode(['status' => $data->is_enable]);
    }

    public function edit($id)
    {
        $groups = Group::get();
        $roles = Roles::get();
        $users = User::get();
        $data = Notice::find($id);
        $view = view('notice.edit', compact('data', 'groups', 'roles', 'users'))->render();
        return response()->json(['html' => $view]);
    }

    public function update(Request $request, $id)
    {
        $url = 'https://node.sizaf.com/received';

        try {
            DB::beginTransaction();
            $notice = Notice::find($id);
            $notice->title = ucfirst($request->title);
            $notice->content = $request->content;
            $notice->send_to = $request->send_to;
            $notice->is_schedule = $request->is_schedule;
            $notice->schedule_time = Carbon::parse($request->schedule_time)->format('Y-m-d H:i:s');
            $notice->type = $request->type;
            if (isset($request->is_enable)) {
                $notice->is_enable = $request->is_enable;
            } else {
                $notice->is_enable = 0;
            }
            $notice->save();

            //deleting all old data
            NoticeUsers::where('notice_id', $id)->delete();
            NoticeGroups::where('notice_id', $id)->delete();
            NoticeRoles::where('notice_id', $id)->delete();
            //saving all groups, users and roles
            foreach ($request->groups_id ?? [] as $value) {
                $groups = new NoticeGroups();
                $groups->notice_id = $notice->id;
                $groups->groups_id = $value;
                $groups->save();
            }
            foreach ($request->roles ?? [] as $value) {
                $roles = new NoticeRoles();
                $roles->notice_id = $notice->id;
                $roles->roles_id = $value;
                $roles->save();
            }
            foreach ($request->users ?? [] as $value) {
                $user = new NoticeUsers();
                $user->notice_id = $notice->id;
                $user->users_id = $value;
                $user->save();
            }
            $users = [];
            if ($notice->type == "Weak hint") {
                if ($request->is_schedule == 0 && $notice->is_enable) {
                    $notice->send_at = now();
                    $notice->is_send = 1;
                    $notice->save();
                    $users = $this->getUsers($notice);
                    foreach ($users as $value) {
                        $dbuser = User::find($value);
                        Notification::send($dbuser, new NoticeNotification($notice));
                    }
                } else if ($request->is_schedule == 1) {
                    if ($notice->is_enable) {
                        $time = Carbon::parse($request->schedule_time);
                        $users = $this->getUsers($notice);
                        SendWeakNoticeJob::dispatch($notice->id)->delay($time);
                    }
                }
                DB::commit();
                return json_encode(['schedule' => true]);
            } else {
                if ($request->is_schedule == 0 && $notice->is_enable) {
                    //to send imidiatly
                    $notice->send_at = now();
                    $notice->is_send = 1;
                    $notice->save();
                    $users = $this->getUsers($notice);
                    foreach ($users as $value) {
                        $dbuser = User::find($value);
                        Notification::send($dbuser, new NoticeNotification($notice));
                    }
                    DB::commit();
                    return json_encode(['users' => $users, 'data' => $notice, 'schedule' => false]);
                } else if ($request->is_schedule == 1) {
                    // for schedule
                    $time = Carbon::parse($request->schedule_time);
                    $users = $this->getUsers($notice);
                    if ($notice->is_enable) {
                        SendWeakNoticeJob::dispatch($notice->id)->delay($time);
                    }
                    SendNoticeJob::dispatch($notice->id, $url)->delay($time);
                    DB::commit();
                    return json_encode(['schedule' => true]);
                }
            }
            DB::commit();
        } catch (\Throwable $th) {
            DB::rollback();
            throw $th;
        }
    }

    public function destroy($id)
    {
        try {
            DB::beginTransaction();
            $notice = Notice::find($id);
            $notice->delete();
            DB::commit();
        } catch (\Throwable $th) {
            DB::rollback();
            return redirect()->back()->with('error', $th->getMessage());
        }
        return redirect()->back()->with('success', 'Notice deleted successfully.');
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

    public function RunNow($id)
    {
        $url = 'https://node.sizaf.com/received';

        $notice = Notice::find($id);
        $users = $this->getUsers($notice);
        if ($notice->type == "Weak hint") {
            foreach ($users as $value) {
                $dbuser = User::find($value);
                Notification::send($dbuser, new NoticeNotification($notice));
            }
        } else {
            foreach ($users as $value) {
                $dbuser = User::find($value);
                Notification::send($dbuser, new NoticeNotification($notice));
            }
            SendNoticeJob::dispatch($id, $url);
        }
        return true;
    }

    public function ReadNoti($id)
    {
        $user = Auth::user();
        // Find the notification by ID for the authenticated user
        $notification = $user->notifications()->find($id);

        if ($notification) {
            $notification->markAsRead();
            return response()->json([
                'status' => 'success',
                'message' => 'Notification marked as read.',
            ]);
        } else {
            return response()->json([
                'status' => 'error',
                'message' => 'Notification not found.',
            ], 404);
        }
    }

    public function ReadAll()
    {
        $user = Auth::user();
        $user->unreadNotifications->each->markAsRead();
        return response()->json([
            'status' => 'success',
            'message' => 'All notification marked as read.',
        ]);
    }
}
