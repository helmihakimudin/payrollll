<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use App\Notification;
use Auth;

class NotificationController extends Controller
{

    public function getnotif(){
        $notif  = Notification::orderBy('id','DESC')->where('read_at',1)->where('user_id',Auth::user()->id)->get();
        $count  = $notif->count();
        return response()->json(['notif'=>$notif,'count'=>$count]);
    }

    public function readat($id){
        $notif = Notification::find($id);
        $notif->read_at = 0;
        $notif->save();
        return response()->json($notif);
    }

  
}
