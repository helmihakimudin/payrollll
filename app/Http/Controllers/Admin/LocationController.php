<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class LocationController extends Controller
{
    public function index(){
        return view("admin.location.index");
    }
    public function create(){
        return view("admin.location.create");
    }
    public function edit(){
        return view("admin.location.edit");
    }
}
