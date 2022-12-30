<?php

namespace App\Http\Controllers\karyawan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Notification;
use Auth;

class NotificationController extends Controller
{
    public function getnotifkaryawan(){
        $notif  = Notification::orderBy('id','DESC')->where('read_at',2)->where('employee_id','=',Auth::guard('karyawan')->user()->id)->get();
        $count  = $notif->count();
        return response()->json(['notif'=>$notif,'count'=>$count]);
    }

    public function readatkaryawan($id){
        $notif = Notification::find($id);
        $notif->read_at = 0;
        $notif->save();
        return response()->json($notif);
    }
}
