<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class Notification_CenterController extends Controller
{
    public function index($id)
    {
        $User = \App\Models\User::find($id);
        $Notifications = $User->unreadNotifications;

        return view('notification_center.index', ['User'=>$User,'Notifications'=>$Notifications]);
    }

    public function viewMessage($userid,$messageid)
    {
        $User = \App\Models\User::find($userid);

        $Notification = "";

        foreach ($User->notifications as $notification){
            if($notification->id == $messageid){
                $Notification = $notification;
            }
        }
 
        return view('notification_center.view-message', ['user_id'=>$userid,'Notification'=>$Notification]);
    }

    public function deleteMessage($userid, $messageid)
    {
        $User = \App\Models\User::find($userid);

        foreach ($User->unreadNotifications as $notification){
            if($notification->id == $messageid){
                $notification->markAsRead();
            }
        }

        return redirect()->route('user-notification-center', ['user_id' => $User->id]);
    }
}
