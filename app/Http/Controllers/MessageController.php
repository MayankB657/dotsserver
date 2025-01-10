<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Group;
use App\Models\Roles;
use App\Models\User;
use App\Models\CommentReciver;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use App\Jobs\CommentMailSend;

class MessageController extends Controller
{
     public function getUsers()
    {

           $users = User::all();
        $groups = Group::all();
        $roles = Roles::all();
        return response()->json([
            'users' => $users,
            'groups' => $groups,
            'roles' => $roles,
        ]);


    }

    public function saveCommentOrReply(Request $request)
    {
        
        try {
            // fetching file key
             $fileKey = $request->input('fileID');
            if (!empty($fileKey)) {
            
            $fileKey = base64UrlDecode($fileKey);

            $group_id = $request->receiver_type == 'Group' ? $request->input('receiver_id') : null;
            $role_id = $request->receiver_type == 'Role' ? $request->input('receiver_id') : null;
            
            // Adjust the validation rules
            $request->validate([
                'user_id' => 'required|integer',
                'receiver_id' => 'nullable|string',
                'receiver_type' => 'nullable|string',
                'message' => 'required|string',
                'fileID' => 'nullable|string',
                'parent_message_id' => 'nullable|integer',
            ]);
            Log::info('Request Data:', $request->all());
            $comment = new Comment();
            $comment->sender = $request->input('user_id');
            $comment->message = $request->input('message');
            $comment->file_id = $fileKey;
            $comment->receiver_type = $request->input('receiver_type') ?: null;
            $comment->group_id = $group_id;
            $comment->role_id = $role_id;

            if ($request->input('parent_message_id')) {
                $comment->parent = $request->input('parent_message_id');
                $responseMessage = 'Reply saved successfully.';
            } else {
                $responseMessage = 'Comment saved successfully.';
            }
            $comment->save();

            if($request->receiver_type == 'User' && $request->input('receiver_id') != null){


                $commentReciver = CommentReciver::create([
                    'receiver_id' => $request->input('receiver_id'),
                    'comment_id' => $comment->id
                ]);

                
    } else if($request->receiver_type == 'Role'){
        $list = User::where('roleID', $request->input('receiver_id'))->get();
        foreach ($list as $key) {
            $commentReciver = CommentReciver::create([
                'receiver_id' => $key->id,
                'comment_id' => $comment->id
            ]);
    }

    } else if($request->receiver_type == 'Group'){
    $list = User::where('groupID', $request->input('receiver_id'))->get();
    foreach ($list as $key) {
        $commentReciver = CommentReciver::create([
            'receiver_id' => $key->id,
            'comment_id' => $comment->id
        ]);
                 
    }
 
 }

            //sending mail 
                            $cmt = $request->message;
                            $auth = Auth::user()->name;

                            foreach ($request->user_array as $el) {
                                if ($el['type'] == 'User') {
                                    $user = User::find($el['id']);
                                    $email = $user->email;

                   
                                CommentMailSend::dispatch($user, $cmt, $auth);

                    //dump($email,'user',$el['id']);/
                }

                if ($el['type'] == 'Role') {
                    $list = User::where('roleID', $el['id'])->get();
                    foreach ($list as $key) {
                        $commentReciver = CommentReciver::create([
                            'receiver_id' => $key->id,
                            'comment_id' => $comment->id
                        ]);

                        $user = User::find($key->id);
                        // $email = $user->email;

                        CommentMailSend::dispatch($user, $cmt, $auth);

                         }
                }

                if ($el['type'] == 'Group') {
                    $list = User::where('groupID', $el['id'])->get();
                    foreach ($list as $key) {
                        $commentReciver = CommentReciver::create([
                            'receiver_id' => $key->id,
                            'comment_id' => $comment->id
                        ]);

                        $user = User::find($key->id);
                        // $email = $user->email;

                        CommentMailSend::dispatch($user, $cmt, $auth);
                    
                    }
                }
            }


            return response()->json([
                'success' => true,
                'message' => $responseMessage,
                'comment' => $comment,
            ]);
         }
        } catch (\Exception $e) {
           
           Log::error("Error saving comment or reply: " . $e->getMessage());
           return response()->json([
            'success' => false,
            'message' => 'Error saving comment or reply',
            'error' => $e->getMessage(),
        ], 500);
       }
   }

    public function getMessageData(Request $request) {
        
        $fileKey = $request->input('fileID');

        $fileKey = base64UrlDecode($fileKey);   

        // Fetch messages based on fileKey
        $messages = Comment::where('file_id', $fileKey)
            ->where('parent', 0)
            ->with('user')
            ->with('group')
            ->with('role')
            ->with('commentRecivers.receiver')
            ->with('replies.user')
            ->get();

        return response()->json([
            'messages' => $messages,
        ]);
    }




                    public function destroy(Request $request) 
            {
                $message = Comment::find($request->id);
                if ($message) {
                        // dd('88');
                        // $message_2->delete();
                    $message->delete();
                    return response()->json(['success' => true, 'message' => 'Message deleted successfully']);
                }

                return response()->json(['success' => true, 'message' => 'Message not found']);
                    // return response()->json(['success' => false, 'message' => 'Message not found'], 404);
            }





}