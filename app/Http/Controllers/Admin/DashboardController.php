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
use App\Events\PengumumanEvent;
use Validator;
use DB;
class DashboardController extends Controller
{
    public function index(){
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
        return view('admin.dashboard.index',compact('gender','pengumuman','avatar'));
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
