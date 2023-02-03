<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\EmployeeEmail;
use App\Employee;
use App\MailInvitation;
use Validator;

class AktivasiController extends Controller
{
    public function sendEmailToUser($id) {

        $employee = Employee::where('id',$id)->get()->first();
        
        $to_email = $employee->email;
        
        if(isset($id)){
            $mailinvite = new MailInvitation();
            $mailinvite->employee_id = $id;
            $mailinvite->email = $to_email;
            $mailinvite->verification_status = 0;
            $mailinvite->save();
        }

       
        Mail::to($to_email)->send(new EmployeeEmail($mailinvite));
        if (count(Mail::failures()) > 0) {
            return 'Error Send mail';
        }else{
            return true;
        }

    }

    public function index($id){
        $employee = Employee::find($id);
        return view("aktivasi.index", compact('employee'));
    }
    
    public function create($id){
        $emailInvitation = MailInvitation::where('employee_id',$id)->where('verification_status',0)->get();
        if($emailInvitation->count()==1){
            return view("aktivasi.create", compact('id'));
        }else{
            return view("aktivasi.invalid");
        }
    }   
        
    public function changePassword(Request $request){
        $validator = Validator::make($request->all(),["password"=>"required|min:8'","ulangi-password"=>"required"]);
        if($validator->fails()){
            $errors = $validator->errors();
            return redirect()->back()->withInput()->withErrors($errors);
        }else{
            $employee = Employee::find($request->employee_id);
            $employee->password = bcrypt($request->password);
            $employee->save();

            //update verification status in email invitation
            MailInvitation::where('employee_id',$request->employee_id)->update(['verification_status'=>1]);
        
            return redirect()->route('emp.dashboard')->with(['success'=>'Password berhasil dirubah !']);
        }
    }
}
