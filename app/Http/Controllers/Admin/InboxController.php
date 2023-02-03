<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Inbox;
use Auth;
use App\Employee;
use App\EmployeeRequestShift;
use Carbon\Carbon;

class InboxController extends Controller
{
    public function index(){
        
        $employeeId = Employee::where('user_id',Auth::user()->id)->pluck('id')->first();
        $inbox = Inbox::where("request_to",$employeeId)->paginate(10);
        $recipients = Employee::get();
        return view("admin.inbox.index",compact('inbox','recipients'));

    }

    public function detail($id){
        $inbox = Inbox::where("request_to",Auth::user()->id)->get();
        $detail = Inbox::find($id);

        //update status when view inbox by employee
        Inbox::where("id",$id)->update(['status_read'=>1]);

        return view("admin.inbox.detail", compact('detail', 'inbox'));
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
            $employeeId = Employee::where('user_id',Auth::user()->id)->pluck('id')->first();
            foreach($request->recipients as $employee){
                $this->inboxMessage($employeeId, $employee, $request->subject, $request->message, 'employee_message');
            }

            return redirect()->back()->with(['succes'=>"Message berhasil terkirim"]);
        }else{
            return redirect()->back()->with(['error'=>"Message belum berhasil terkirim"]);
        }    
    }

}
