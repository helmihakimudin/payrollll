<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Cuti;
use App\Kasbon;
use Auth;
use App\Karyawan;
use App\Izin;
use App\User;
use App\Pengumuman;
use App\Employee;
use App\Events\PengumumanEvent;
use App\LogTimeOffBalance;
use App\SettingTimeOff;
use Carbon\Carbon;
use Validator;
use DB;
class DashboardController extends Controller
{
    public function index(){
        $employee = Employee::where(['user_id'=> Auth::user()->id])->first();
        $gender = DB::table('users')->where('id',Auth::user()->id)->first();
        $pengumuman = DB::table('announcement')->orderBy('id','DESC')->paginate(3);
        if(file_exists(public_path().'/storage/avatar/'.Auth::user()->avatar)){
            if(Auth::user()->avatar != null){
                $avatar = asset('/storage/avatar/'.Auth::user()->avatar);
            }else{
                $avatar = asset('image/avatar-uknown.png');
            }
        }else{
            $avatar = asset('image/avatar-uknown.png');
        }

        $expired = LogTimeOffBalance::where('type','beginning_balance')->where('end_date', '<', Carbon::now())->where('status', 0)->get();
        /* 
        Column Status
        0 -> data awal,
        1 -> expired,
        2 -> carry forward,
        3 -> expired 2x
        */
        foreach ($expired as $exp) {
            $logs = new LogTimeOffBalance();
            $logs->employee_id = $exp->employee_id;
            $logs->transaction_id = $exp->transaction_id;
            $logs->timeoff_id = $exp->timeoff_id;
            $logs->type = "expired";
            $logs->value = -$exp->value;
            $logs->ending_balance = $logs->ending_balance - $exp->ending_balance;
            $logs->start_date = date("Y-m-d",strtotime($exp->start_date));
            $logs->end_date = date("Y-m-d",strtotime($exp->end_date));
            $logs->status = 1;
            $logs->action = "Expired";

            $logs->save();

            $exp->status = 1;
            $exp->save();

        }
        // $carry = LogTimeOffBalance::max('id');
        $carry = LogTimeOffBalance::whereIn('id', function($query) {
            $query->from('log_time_off_balances')->where('type','expired')->where('status',1)->groupBy('employee_id')->selectRaw('MAX(id)');
         })->get();
        $carrys = LogTimeOffBalance::where('type','expired')->where('status',1)->orderBy('id', 'desc')->get();
        
        foreach ($carry as $car) {
            $setting = SettingTimeOff::where('timeoff_id', $car->timeoff_id)->get();
                foreach ($setting as $key => $settings) {
                    
                    // $c->value = $car->ending_balance;
                    if ($settings->carry_forward == 1) {
                        
                        $c = new LogTimeOffBalance();
                        $c->employee_id = $car->employee_id;
                        $c->transaction_id = $car->transaction_id;
                        $c->timeoff_id = $car->timeoff_id;
                        $c->type = "carry_forward";
                        
                        if ($car->ending_balance <= ($settings->carry_amount*-1)) {
                            $c->value = $settings->carry_amount;
                        } else {
                            $c->value = $car->ending_balance*-1;
                        }
                        if ($car->ending_balance <= ($settings->carry_amount*-1)) {
                            $c->ending_balance = $settings->carry_amount;
                        } else {
                            $c->ending_balance = $car->ending_balance*-1;
                        }
                        $c->start_date = date("Y-m-d",strtotime($car->end_date));
                        $c->end_date = date("Y-m-d",strtotime(Carbon::parse($car->end_date)->addMonths($settings->carry_forward))); 
                        $c->status = 2;
                        $c->action = "Carry Forward";

                        $c->save();
                    }
                }

            foreach ($carrys as $key => $value) {
                $value->status = 2;
                $value->save();
            }
        }

        return view('admin.dashboard.index',compact('gender','pengumuman','avatar','employee'));
    }



    public function editpengumuman($id){
        $pengumuman = Pengumuman::find($id);
        return view('admin.include.edit-pengumuman',compact('pengumuman'));
    }

    public function pengumumanstore(request $request){

        $validator = Validator::make($request->all(),[
            'announcement_title' => 'required',
            'announcement' =>'required',
        ]);
        if($validator->fails()){
            return redirect()->back()->with(['error'=>'Required Field!']);
        }else{
            $pengumuman = new Pengumuman;
            $pengumuman->announcement_date = date('Y-m-d');
            $pengumuman->announcement_title = $request->announcement_title;
            $pengumuman->announcement = $request->announcement;
            $pengumuman->month = date('Y-m');
            $pengumuman->created_by = Auth::user()->id;
            $pengumuman->save();
            $karyawan = Karyawan::where('employee_status','Aktif')->get();
            foreach($karyawan as $row){
                event(new PengumumanEvent($name="pengumuman", $description=" Broadcast hari ini  dari ".Auth::user()->name, $read_at = 2, $employee_id = $row->id));
            }
            return redirect()->back()->with(['success'=>'Pengumuman Berhasil Dibuat !']);
        }
    }

    public function pengumumanupdate(request $request,$id){
        $validator = Validator::make($request->all(),[
            'announcement' =>'required',
        ]);

        if($validator->fails()){
            return redirect()->back()->with(['error'=>'Required Field!']);
        }else{
            $pengumuman = Pengumuman::find($id);
            $pengumuman->announcement_date = date('Y-m-d');
            $pengumuman->announcement_title = $request->announcement_title;
            $pengumuman->announcement = $request->announcement;
            $pengumuman->month = date('Y-m');
            $pengumuman->created_by = Auth::user()->id;
            $pengumuman->save();
            $karyawan = Karyawan::where('employee_status','Aktif')->get();
            foreach($karyawan as $row){
                event(new PengumumanEvent($name="Pengumuman", $description="Perubahan Broadcast hari ini  dari ".Auth::user()->name."", $read_at = 2, $employee_id = $row->id));
            }
            return redirect()->back()->with(['success'=>'Pengumuman Berhasil Diubah !']);
        }
    }

    public function showpengumuman($id){
        $pengumuman = Pengumuman::find($id);
        return view('admin.include.show-pengumuman',compact('pengumuman'));
    }
    public function pengumumandestroy($id){
        $pengumuman  = Pengumuman::find($id);
        $pengumuman->delete();
        return redirect()->back()->with(['success'=>'pengumuman berhasil dihapus']);
    }

}
