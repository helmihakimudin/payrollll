<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\AllowanceOption;
use App\DeductionOption;
use DB;
use Auth;
use App\Benefit;
use Validator;

class SettingController extends Controller
{
    public function index(){
        $getallowances  = AllowanceOption::select('id','name','id as actions')->get();
        $getdeductions  = DeductionOption::select('id','name','id as actions')->get(); 
        $benefit        = Benefit::select('id','name','id as actions')->get(); 
        return view('admin.payroll.settings.index',compact('getallowances','getdeductions','benefit'));
    }

    public function createallow(){
        return view("admin.payroll.settings.allowance.create");
    }
    public function storeallow(request $request){
        $validator = Validator::make($request->all(),[
            'name' =>'required',
        ]);

        if($validator->fails()){
            return redirect()->back()->with(['danger'=>$validator->errors()->first()]);
        }else{
            if($request->name == 'Komisi' ||$request->name =='komisi' ){
                return redirect()->back()->with(['error'=>'Komisi Telah Dibuat']);
            }else{
                $allowanceoption = new AllowanceOption;
                $allowanceoption->name = $request->name;
                $allowanceoption->created_by = Auth::user()->id;
                $allowanceoption->save();
            }
            return redirect()->back()->with(['success'=>'Allowance Successfull Created !']);
        }
    }
    public function editallow($id) {
        $allowanceoption = AllowanceOption::find($id);
        return view("admin.payroll.settings.allowance.edit",compact('allowanceoption'));
    }

    public function updateallow(Request $request, $id)
    {
        $validator = Validator::make($request->all(),[
            'name' =>'required',
        ]);

        if($validator->fails()){
            return redirect()->back()->with(['danger'=>$validator->errors()->first()]);
        }else{
            if($request->name == 'Komisi' ||$request->name =='komisi' ){
                return redirect()->back()->with(['error'=>'Komisi Telah Ada']);
            }else{
                $allowanceoption = AllowanceOption::find($id);
                $allowanceoption->name = $request->name;
                $allowanceoption->created_by = Auth::user()->id;
                $allowanceoption->save();
            }
            return redirect()->back()->with(['success'=>'Allowance Successfull updated !']);
        }
    }

    public function showallow($id) {
        $allowanceoption = AllowanceOption::find($id);
        return view("admin.payroll.settings.allowance.show",compact('allowanceoption'));
    }

    public function deleteallow($id){
        $allowanceoption = AllowanceOption::find($id);
        $allowanceoption->delete();
        return redirect()->back()->with(['success'=>'Allowance Successfull Deleted !']);
    }

    public function createdeductions(){
        return view("admin.payroll.settings.deductions.create");
    }
 
    public function storedeductions(request $request){
        $validator = Validator::make($request->all(),[
            'name' =>'required',
        ]);

        if($validator->fails()){
            return redirect()->back()->with(['danger'=>$validator->errors()->first()]);
        }else{
            if($request->name == 'Komisi' ||$request->name =='komisi' ){
                return redirect()->back()->with(['error'=>'Komisi Telah Dibuat']);
            }else{
                $deductions = new DeductionOption;
                $deductions->name = $request->name;
                $deductions->created_by = Auth::user()->id;
                $deductions->save();
            }
            return redirect()->back()->with(['success'=>'Deductions Successfull Created !']);
        }
    }
    public function editdeductions($id) {
        $deductions = DeductionOption::find($id);
        return view("admin.payroll.settings.deductions.edit",compact('deductions'));
    }

    public function updatedeductions(Request $request, $id){    
        $validator = Validator::make($request->all(),[
            'name' =>'required',
        ]);

        if($validator->fails()){
            return redirect()->back()->with(['danger'=>$validator->errors()->first()]);
        }else{
            if($request->name == 'Komisi' ||$request->name =='komisi' ){
                return redirect()->back()->with(['error'=>'Komisi Telah Ada']);
            }else{
                $deductions = DeductionOption::find($id);
                $deductions->name = $request->name;
                $deductions->created_by = Auth::user()->id;
                $deductions->save();
            }
            return redirect()->back()->with(['success'=>'Deductions Successfull updated !']);
        }
    }

    public function showdeductions($id) {
        $deductions = DeductionOption::find($id);
        return view("admin.payroll.settings.deductions.show",compact('deductions'));
    }

    public function deletedeductions($id){
        $deductions = DeductionOption::find($id);
        $deductions->delete();
        return redirect()->back()->with(['success'=>'Deductions Successfull Deleted !']);
    }

    public function createbenefit(){
        return view("admin.payroll.settings.benefit.create");
    }
 
    public function storebenefit(request $request){
        $validator = Validator::make($request->all(),[
            'name' =>'required',
        ]);

        if($validator->fails()){
            return redirect()->back()->with(['danger'=>$validator->errors()->first()]);
        }else{
            $benefit = new Benefit;
            $benefit->name = $request->name;
            $benefit->created_by = Auth::user()->id;
            $benefit->save();
            return redirect()->back()->with(['success'=>'Benefit Successfull Created !']);
        }
    }
    public function editbenefit($id) {
        $benefit = Benefit::find($id);
        return view("admin.payroll.settings.benefit.edit",compact('benefit'));
    }

    public function updatebenefit(Request $request, $id){    
        $validator = Validator::make($request->all(),[
            'name' =>'required',
        ]);

        if($validator->fails()){
            return redirect()->back()->with(['danger'=>$validator->errors()->first()]);
        }else{
            $benefit = Benefit::find($id);
            $benefit->name = $request->name;
            $benefit->created_by = Auth::user()->id;
            $benefit->save();
            return redirect()->back()->with(['success'=>'Benefit Successfull updated !']);
        }
    }

    public function showbenefit($id) {
        $benefit = Benefit::find($id);
        return view("admin.payroll.settings.benefit.show",compact('benefit'));
    }

    public function deletebenefit($id){
        $benefit = Benefit::find($id);
        $benefit->delete();
        return redirect()->back()->with(['success'=>'Benefit Successfull Deleted !']);
    }

}
