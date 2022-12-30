<?php

namespace App\Http\Controllers\karyawan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Front\Employees;
use Validator;
use Auth;


class LoginController extends Controller
{
    public function index(){
        return view('auth.karyawan.login');
    }

    public function login(request $request){
        $validator = Validator::make($request->all(), [
            'email' => 'required',
            'password' => 'required'
        ]);

        if ($validator->fails()) {
            return redirect()->back()->with('error','field required');
        }
        $credential = [
            'email' => $request->email,
            'password' => $request->password,
        ];
        $employee = Auth::guard('emp')->attempt($credential);
        if(Auth::guard('emp')->attempt($credential)){
           return redirect()->route('emp.dashboard');
        }else{
            return redirect('/emp/login');
        }   
    }

    public function logout(Request $request)
    {
        Auth::guard('emp')->logout();
        return $request->wantsJson()
            ? new JsonResponse([], 204)
            : redirect('/emp/login');
    }
}
