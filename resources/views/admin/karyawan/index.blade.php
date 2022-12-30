@extends('layout-admin.base',[
	'pages'=>'employee',
	'subpages'=>'employee'
])
@section('content')
<style> 
th, td { 
    white-space: nowrap;
    text-align: left;
}
</style>
<div class="row">
    <div class="col-lg-3">
        <div class="form-group">
            <label for="">Organization</label>
            <select name="organization_id" class="form-control select2" id="organization_id">
                <option value="" selected>Select Organization</option>
                @foreach(DB::table("organization")->get() as $row)
                <option value="{{$row->id}}" >{{$row->name}}</option>
                @endforeach
            </select>
        </div>
    </div>
    <div class="col-lg-3">
        <div class="form-group">
            <label for="">Branch</label>
            <select name="branch_id" class="form-control select2" id="branch_id">
                <option value="" selected>Select Branch</option>
                @foreach(DB::table("branches")->get() as $row)
                <option value="{{$row->id}}" >{{$row->name}}</option>
                @endforeach
            </select>
        </div>
    </div>
    <div class="col-lg-3">
        <div class="form-group">
            <label for="">Job Position</label>
            <select name="job_position_id" class="form-control select2" id="job_position_id">
                <option value="" selected>Select Job Position</option>
                @foreach(DB::table("job_position")->get() as $row)
                <option value="{{$row->id}}" >{{$row->name}}</option>
                @endforeach
            </select>
        </div>
    </div>
    <div class="col-lg-3">
        <div class="form-group">
            <label for="">Job level</label>
            <select name="job_level_id" class="form-control select2" id="job_level_id">
                <option value="" selected>Select Job Level</option>
                @foreach(DB::table("job_level")->get() as $row)
                <option value="{{$row->id}}" >{{$row->name}}</option>
                @endforeach
            </select>
        </div>
    </div>
</div>
<div class="row pb-5">
    <div class="col-lg-3">
        <a href="" class="btn btn-primary btn-elevate btn-sm "><i class="flaticon-notes"></i>Export</a>
        <a href="" class="btn btn-primary btn-elevate btn-sm"><i class="flaticon-notes"></i>Bulk Update</a>
    </div>
</div>

<div class="kt-body kt-grid__item kt-grid__item--fluid kt-grid kt-grid--hor kt-grid--stretch" id="kt_body">
    <div class="kt-content  kt-grid__item kt-grid__item--fluid kt-grid kt-grid--hor" id="kt_content">
        <div class="kt-subheader   kt-grid__item" id="kt_subheader">
            <div class="kt-container pt-3">
                <div class="kt-subheader__main">
                    <h3 class="kt-subheader__title">
                        Employee List
                    </h3>
                    <span class="kt-subheader__separator kt-subheader__separator--v"></span>
                    <div class="kt-subheader__group" id="kt_subheader_search">
                        <span class="kt-subheader__desc" id="kt_subheader_total">
                            <a href="{{route('employee.create')}}" class="btn btn-primary rounded-fill">Add Employee</a></span>
                    </div>
                </div>
            </div>
        </div>
        <div class="kt-container  kt-grid__item kt-grid__item--fluid">
            <div class="row">
                <div class="col-lg-12">
                    <table class="table table-striped-  table-hover table-checkable dataTable no-footer dtr-inline" id="karyawan-table" >
                        <thead style="background-color: lightgray;">
                            <tr>
                                <th>Full name</th>
                                <th>Employee ID</th>
                                <th>Branch</th>
                                <th>Job Position</th>
                                <th>Job Level</th>
                                <th>Employement Status</th>
                                <th>Join Date</th>
                                <th>End Date</th>
                                <th>Email</th>
                                <th>Birth Date</th>
                                <th>Birth Place</th>
                                <th>Citiztion ID Address</th>
                                <th>Residential Address</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                           <tr>
                            <td colspan="14"></td>
                           </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@push('scriptjs')
<script>
$(document).ready(function(){
    var datatable1 = $("#karyawan-table").DataTable({
        drawCallback:function(){$(".dataTables_paginate > .pagination").addClass("pagination-rounded")},
        scrollX: true,
        bStateSave: true,
        select:true,
        serverSide:true,
        processing: true,
        paging:true,
        ajax:{
            url:'{{ route('employee.ajax') }}',
            type:'post',
            data:{"_token": "{{ csrf_token() }}"},
        },
        columns:[
            { data:'fullname'},
            { data:'employee_id'},
            { data:'branch'},
            { data:'job_position'},
            { data:'job_level'},
            { data:'employeement_status'},
            { data:'join_date'},
            { data:'end_date'},
            { data:'email'},
            { data:'date_of_birth'},
            { data:'place_of_birth'},
            { data:'residential_address'},
            { data:'citizien_id_address'},
            { data:'actions'},
        ],
    }); 
});
</script>
@endpush