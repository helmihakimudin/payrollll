<?php

namespace App\Http\Controllers\Admin;

use App\Employee;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\User;
use Illuminate\Support\Facades\Storage;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Pion\Laravel\ChunkUpload\Handler\HandlerFactory;
use Pion\Laravel\ChunkUpload\Receiver\FileReceiver;
use Validator;
use Illuminate\Support\Facades\Hash;
use App\Peran;
use Spatie\Permission\Models\Role;



class PenggunaController extends Controller
{
    public function index(){
        if(auth()->user()->can('Manage Pengguna')){
            $pengguna = User::all();
            return view('admin.pengguna.index',compact('pengguna'));
        }
    }

    public function create(){
        $employee = Employee::select('id','full_name')->get();

        return view('admin.pengguna.create',compact('employee'));
    }

    public function edit($id){
        $pengguna = User::find($id);
        $employee = Employee::select('id','full_name')->get();
        return view('admin.pengguna.edit',compact('pengguna','employee'));
    }
    public function show($id){
        $pengguna = User::find($id);
        return view('admin.pengguna.show',compact('pengguna'));
    }

    public function destroy($id){
        $user = User::find($id);
        $user->delete();
        return redirect()->route('pengguna')->with(['success'=>'Users Successfull Deleted!']);
    }

    public function avatar(Request $request) {
        $receiver = new FileReceiver('file', $request, HandlerFactory::classFromRequest($request));
        if (!$receiver->isUploaded()) {
        }
        $fileReceived = $receiver->receive();
        if ($fileReceived->isFinished()) {
            $file = $fileReceived->getFile();
            $extension = $file->getClientOriginalExtension();
            $fileName = str_replace('.'.$extension, '', $file->getClientOriginalName().time());
            $fileName .= '_' . md5(time()) . '.' . $extension;

            $disk = Storage::disk(config('filesystems.default'));
            $path = $disk->putFileAs('/public/avatar', $file, $fileName);
            unlink($file->getPathname());
            return [
                'path' => asset('storage/avatar' . $path),
                'filename' => $fileName
            ];
        }
        $handler = $fileReceived->handler();
        return [
            'done' => $handler->getPercentageDone(),
            'status' => true
        ];
    }

    public function signature(Request $request) {
        $receiver = new FileReceiver('file', $request, HandlerFactory::classFromRequest($request));
        if (!$receiver->isUploaded()) {
        }
        $fileReceived = $receiver->receive();
        if ($fileReceived->isFinished()) {
            $file = $fileReceived->getFile();
            $extension = $file->getClientOriginalExtension();
            $fileName = str_replace('.'.$extension, '', $file->getClientOriginalName().time());
            $fileName .= '_' . md5(time()) . '.' . $extension;

            $disk = Storage::disk(config('filesystems.default'));
            $path = $disk->putFileAs('/public/avatar', $file, $fileName);
            unlink($file->getPathname());
            return [
                'path' => asset('storage/avatar' . $path),
                'filename' => $fileName
            ];
        }
        $handler = $fileReceived->handler();
        return [
            'done' => $handler->getPercentageDone(),
            'status' => true
        ];
    }

    public function store(request $request){
        $validator = Validator::make($request->all(),[
            'name'=>'required',
            'branch_id'=>'required',
            'no_telp'=>'required',
            'password'=>'required',
            'email'=>'required',

        ]);
        if($validator->fails()){
            return redirect()->back()->with(['error'=>'Required Field!']);
        }else{
            $employee = Employee::where('id',$request->employee_id)->first();

            if($request->avatar != null){
                $avatar  = $request->avatar;
            }else{
                $avatar  = null;
            }
            if($request->signature != null){
                $signature  = $request->signature;
            }else{
                $signature  = null;
            }

            $user = new User;
            $user->name = $employee->full_name;
            $user->email = $request->email;
            $user->branch_id = $request->branch_id;
            $user->no_telp = $request->no_telp;
            $user->role_id = $request->type;
            $user->password = Hash::make($request->password);
            $user->lang= "id";
            $user->is_active = 0;
            $role = Role::find($request->type);
            dd($role);
            $user->role_id = $role->id;
            $user->assignRole($role->name);
            $user->avatar = $avatar;
            $user->signature = $signature;
            $user->created_by = Auth::user()->id;
            $user->save();

            //update employee by employee id
            Employee::where('id', $request->employee_id)->update(['user_id' => $user->id]);

            return redirect()->route('pengguna')->with(['success'=>'User Successfull Created !']);
        }

    }


    public function update(request $request, $id){

        if($request->avatar != null){
            $avatar  = $request->avatar;
        }else{
            $avatar  = null;
        }
        if($request->signature != null){
            $signature  = $request->signature;
        }else{
            $signature  = null;
        }

        if($request->password != null){
            $user = User::find($id);
            $user->role_id = $request->type;
            $role = Role::where('id',$request->type)->first();
            $user->role_id = $role['id'];
            $user->assignRole($role['name']);
            $user->password = Hash::make($request->password);
            $user->lang= "id";
            $user->avatar = $avatar;
            $user->signature = $signature;
            $user->created_by = Auth::user()->id;
            $user->save();
        }else{
            $user = User::find($id);
            $role = Role::where('id',$request->type)->first();
            $user->role_id = $role->id;
            $user->assignRole($role->name);
            $user->lang= "id";
            $user->avatar = $avatar;
            $user->signature = $signature;
            $user->created_by = Auth::user()->id;
            $user->save();
        }
        return redirect()->route('pengguna')->with(['success'=>'User Successfull updated!']);

    }

    public function active($id){
        $active = User::find($id);
        $active->is_active = 1;
        $active->save();
        return redirect()->route('pengguna')->with(['success'=>'Activation Success!']);
    }

    public function deactive($id){
        $active = User::find($id);
        $active->is_active = 0;
        $active->save();
        return redirect()->route('pengguna')->with(['success'=>'Deactive Success!']);
    }

    public function autogenerate($id){
        $employee = Employee::where('id', $id)->get(['mobile_phone','branch_id','email'])->first()->toJson();
        return $employee;
    }

}
