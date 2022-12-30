<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\User;
use Auth;

class AccountController extends Controller
{
    public function index($id){
        $account = User::find(Auth::user()->id);
        return view('admin.account.index',compact('account'));
    }

    public function update(Request $request)
    {
        if($request->file('avatar')){
            $file1 = $request->file('avatar')->getClientOriginalName();
            $filename1 = pathinfo($file1, PATHINFO_FILENAME);
            $extension1 = $request->file('avatar')->getClientOriginalExtension();
            $fileNameToStore1 = $filename1.'_'.time().'.'.$extension1;
            $path1 = $request->file('avatar')->storeAs('/public/avatar',$fileNameToStore1);
        }else{
            $fileNameToStore1 = $request->avatars;
        } 
        if($request->file('signature')){
            $file2 = $request->file('signature')->getClientOriginalName();
            $filename2 = pathinfo($file2, PATHINFO_FILENAME);
            $extension2 = $request->file('signature')->getClientOriginalExtension();
            $fileNameToStore2 = $filename2.'_'.time().'.'.$extension2;
            $path2 = $request->file('signature')->storeAs('/public/avatar',$fileNameToStore2);
        }else{
            $fileNameToStore2 = $request->signatures;
        }
        if($request->password != null){
            $user = User::find(Auth::user()->id);
            $user->name      = $request->name;
            $user->branch_id = $request->branch_id;
            $user->email     = $request->email;
            $user->no_telp   = $request->no_telp;
            $user->password  = Hash::make($request->password);
            $user->signature = $fileNameToStore2;
            $user->avatar    = $fileNameToStore1;
            $user->save();
        }else{
            $user = User::find(Auth::user()->id);
            $user->name      = $request->name;
            $user->branch_id = $request->branch_id;
            $user->email     = $request->email;
            $user->no_telp   = $request->no_telp;
            $user->signature = $fileNameToStore2;
            $user->avatar    = $fileNameToStore1;
            $user->save();
        }

        return redirect()->back()->with(['success'=>'Data Account Berhasil Diperbarui !']);
        
    }

}
