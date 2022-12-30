<?php

namespace App\Http\Controllers\Admin;

use App\Branch;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;
use Auth;

class CompanyController extends Controller
{
    
    public function index(){
        $branch=Branch::get();
        
        return view('admin.company.index', compact ('branch'));
    }

    public function edit($id)
    {
        $branch = Branch::find($id);
        return view('admin.company.edit',compact('branch'));
    }

    public function destroy($id)
    {
        $branch = Branch::find($id);
        $branch->delete();
        return redirect()->route('company.index')->with(['success'=>'Kantor Cabang Berhasil Dihapus !']);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function setting()
    {
        $ii = \Auth::user()->branch_id;
        $branch = Branch::find($ii);
        return view('admin.company.edit',compact('branch'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function save(Request $request, $id)
    {
        $validator = Validator::make($request->all(),[
            'name' =>'required',
        ]);
        $image = $request->file('gambaredit');
        if($image != null){
            $gmbr = time().'.'.$image->getClientOriginalExtension();
            $destinationPath = storage_path('/app/public/logo');
            $image->move($destinationPath, $gmbr);

            if($validator->fails()){
                return redirect()->back()->with(['error'=>'Required Field!']);
            }else{
                $branch = Branch::find($id);
                $branch->name = $request->name;
                $branch->email = $request->email;
                $branch->telepon = $request->telepon;
                $branch->alamat = $request->alamat;
                $branch->kodepos = $request->kodepos;
                $branch->provinsi = $request->provinsi;
                $branch->country = $request->country;
                $branch->logo = $gmbr;
                $branch->save();
                return redirect()->route('company.setting')->with(['success'=>'Detail Perusahaan Berhasil Diubah !']);
            }
        }
        else{
            if($validator->fails()){
                return redirect()->back()->with(['error'=>'Required Field!']);
            }else{
                $branch = Branch::find($id);
                $branch->name = $request->name;
                $branch->email = $request->email;
                $branch->telepon = $request->telepon;
                $branch->alamat = $request->alamat;
                $branch->kodepos = $request->kodepos;
                $branch->provinsi = $request->provinsi;
                $branch->country = $request->country;
                $branch->save();
                return redirect()->route('company.setting')->with(['success'=>'Detail Perusahaan Berhasil Diubah !']);
            }
        }
    }
}
