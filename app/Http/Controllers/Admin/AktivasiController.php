<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AktivasiController extends Controller
{
    public function index(){
        return view("admin.karyawan.aktivasi.index");
    }
    public function create(){
        return view("admin.karyawan.aktivasi.create");
    }
    public function success(){
        return view("admin.karyawan.aktivasi.success");
    }
    public function invalid(){
        return view("admin.karyawan.aktivasi.invalid");
    }
}
