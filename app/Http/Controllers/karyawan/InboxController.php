<?php

namespace App\Http\Controllers\karyawan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Inbox;
use Auth;
use App\Employee;

class InboxController extends Controller
{
    public function index(){
        $employeeId = Auth::guard('emp')->user()->id;
        $inboxEmployee = Inbox::where("request_to",$employeeId)->paginate(10);
        $recipients = Employee::where('organization_id', Auth::guard('emp')->user()->organization_id)->orWhere('organization_id', 3)->where('id','!=', Auth::guard('emp')->user()->id)->get();
        
        return view("karyawan.inbox.index",compact('inboxEmployee','recipients'));

    }

    public function detail($id){
        $employeeId = Auth::guard('emp')->user()->id;
        $inbox = Inbox::where("request_to", $employeeId)->get();
        $detail = Inbox::find($id);

        //update status when view inbox by employee
        Inbox::where("id",$id)->update(['status_read'=>1]);

        return view("karyawan.inbox.detail", compact('detail', 'inbox'));
    }

    public function inboxMessage($employee_id, $request_to,$title,$message, $type){
        $inbox = new Inbox();
        $inbox->employee_id = $employee_id;
        $inbox->request_to = $request_to;
        $inbox->title = $title;
        $inbox->message = $message;
        $inbox->type = $type;
        $inbox->save();
    }

    public function sendMessage(Request $request){
        if(is_array($request->recipients)){
            foreach($request->recipients as $employee){
                $this->inboxMessage(Auth::guard('emp')->user()->id, $employee, $request->subject, $request->message, 'employee_message');
            }

            return redirect()->back()->with(['succes'=>"Message berhasil terkirim"]);
        }else{
            return redirect()->back()->with(['error'=>"Message belum berhasil terkirim"]);
        }    
    }
}
