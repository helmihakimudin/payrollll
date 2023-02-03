@extends('admin.karyawan.account.base',[
	'pages'=>'general',
	'subpages'=>'personality'
])

@push('css')
<style>
  .select2-container {
    display: block;
    width: 100%;
  }
</style>            
@endpush
@section('content-account')
<div class="kt-portlet">
    <div class="kt-portlet__head">
        <div class="kt-portlet__head-label">
            <h3 class="kt-portlet__head-title">
                Personal
            </h3>
        </div>
        <div class="kt-portlet__head-toolbar">
            <ul class="nav nav-tabs nav-tabs-bold nav-tabs-line nav-tabs-line-right nav-tabs-line-brand" role="tablist">
                <li class="nav-item">
                    <a class="nav-link active" data-toggle="tab" href="#kt_apps_contacts_view_tab_1" role="tab">
                         Basic Info
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-toggle="tab" href="#kt_apps_contacts_view_tab_2" role="tab">
                        Family
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-toggle="tab" href="#kt_apps_contacts_view_tab_3" role="tab">
                         Emergency Contact
                    </a>
                </li>
            </ul>
        </div>
    </div>
    <div class="kt-portlet__body">
        <div class="tab-content">
            <div class="tab-pane active" id="kt_apps_contacts_view_tab_1" role="tabpanel">
                <div class="row">
                    <div class="col-lg-4">
                        <span class="font-weight-bold"> Personal Data </span><br>
                        <span style="font-size:11px;">Your email address is your identity on E-Smart is used to log in.</span>
                    </div>
                    <div class="col-lg-6">
                        <ul class="list-unstyled mb-0">
                            <li>
                                <div class="row py-2">
                                    <div class="col-sm-4 d-flex align-items-center">
                                        <span class="font-weight-bold"> Full name </span>
                                    </div>
                                    <div class="col-sm-8"><p class="m-0">{{$karyawan->full_name}}</p></div>
                                </div>
                            </li>
                            <li>
                                <div class="row py-2">
                                    <div class="col-sm-4 d-flex align-items-center">
                                        <span class="font-weight-bold"> Phone Number (Home) </span>
                                    </div>
                                    <div class="col-sm-8"><p class="m-0">{{$karyawan->phone}}</p></div>
                                </div>
                            </li>
                            <li>
                                <div class="row py-2">
                                    <div class="col-sm-4 d-flex align-items-center">
                                        <span class="font-weight-bold"> Mobile phone </span>
                                    </div>
                                    <div class="col-sm-8"><p class="m-0">{{$karyawan->mobile_phone}}</p></div>
                                </div>
                            </li>
                            <li>
                                <div class="row py-2">
                                    <div class="col-sm-4 d-flex align-items-center">
                                        <span class="font-weight-bold"> Email </span>
                                    </div>
                                    <div class="col-sm-8"><p class="m-0">{{$karyawan->email}}</p></div>
                                </div>
                            </li>
                            <li>
                                <div class="row py-2">
                                    <div class="col-sm-4 d-flex align-items-center">
                                        <span class="font-weight-bold">Place Of Birth</span>
                                    </div>
                                    <div class="col-sm-8"><p class="m-0">{{$karyawan->place_of_birth}}</p></div>
                                </div>
                            </li>
                            <li>
                                <div class="row py-2">
                                    <div class="col-sm-4 d-flex align-items-center">
                                        <span class="font-weight-bold">Date of Birth</span>
                                    </div>
                                    <div class="col-sm-8"><p class="m-0">{{date('d M Y',strtotime($karyawan->date_of_birth))}} <span class="ml-2 text-warning kt-font-bold kt-badge--inline">( {{$age}} years old )</span></p></div>
                                </div>
                            </li>
                            <li>
                                <div class="row py-2">
                                    <div class="col-sm-4 d-flex align-items-center">
                                        <span class="font-weight-bold">Blood Type</span>
                                    </div>
                                    <div class="col-sm-8"><p class="m-0"> {{$karyawan->blood_type}}</p></div>
                                </div>
                            </li>
                            <li>
                                <div class="row py-2">
                                    <div class="col-sm-4 d-flex align-items-center">
                                        <span class="font-weight-bold">Merriage status</span>
                                    </div>
                                    <div class="col-sm-8"><p class="m-0"> {{$karyawan->marital_status}}</p></div>
                                </div>
                            </li>
                            <li>
                                <div class="row py-2">
                                    <div class="col-sm-4 d-flex align-items-center">
                                        <span class="font-weight-bold">Religion</span>
                                    </div>
                                    <div class="col-sm-8"><p class="m-0"> {{$karyawan->religion}}</p></div>
                                </div>
                            </li>
                        </ul>
                    </div>
                    @if($karyawan->is_req_personal == 1)
                    <div class="col-lg-2">
                        <button type="button" data-attr="{{route("employee.account.personal.request.edit",$karyawan->id)}}" class="btn btn-outline-secondary btn-sm btn-elevate-hover btn-edit-personal"><i class="la la-edit"></i>Request Edit</button>
                    </div>
                    @endif
                </div>
                <div class="kt-separator kt-separator--border-dashed kt-separator--space-lg"></div>
                <div class="row">
                    <div class="col-lg-4">
                        <span class="font-weight-bold">Identity & Address</span><br>
                    </div>
                    <div class="col-lg-6">
                        <ul class="list-unstyled mb-0">
                            <li>
                                <div class="row py-2">
                                        <div class="col-sm-4 d-flex align-items-center">
                                            <span class="font-weight-bold"> ID TYPE </span>
                                        </div>
                                    <div class="col-sm-8"><p class="m-0">{{$karyawan->identity_type}}</p></div>
                                </div>
                            </li>
                            <li>
                                <div class="row py-2">
                                        <div class="col-sm-4 d-flex align-items-center">
                                            <span class="font-weight-bold"> ID Number </span>
                                        </div>
                                    <div class="col-sm-8"><p class="m-0">{{$karyawan->identity_number}}</p></div>
                                </div>
                            </li>
                            <li>
                                <div class="row py-2">
                                        <div class="col-sm-4 d-flex align-items-center">
                                            <span class="font-weight-bold"> Postal code </span>
                                        </div>
                                    <div class="col-sm-8"><p class="m-0">{{$karyawan->postal_code}}</p></div>
                                </div>
                            </li>
                            <li>
                                <div class="row py-2">
                                        <div class="col-sm-4 d-flex align-items-center">
                                            <span class="font-weight-bold"> Citizen ID address</span>
                                        </div>
                                    <div class="col-sm-8"><p class="m-0">{{$karyawan->citizien_id_address}}</p></div>
                                </div>
                            </li>
                            <li>
                                <div class="row py-2">
                                        <div class="col-sm-4 d-flex align-items-center">
                                            <span class="font-weight-bold"> Residential address</span>
                                        </div>
                                    <div class="col-sm-8"><p class="m-0">{{$karyawan->residential_address}}</p></div>
                                </div>
                            </li>
                        </ul>
                    </div>
                    @if($karyawan->is_req_identity == 1)
                    <div class="col-lg-2">
                        <button type="button" data-attr="{{route("employee.account.identity.request.edit",$karyawan->id)}}" class="btn btn-outline-secondary btn-elevate-hover btn-sm rounded btn-edit-personal"><i class="la la-edit"></i>Request Edit</button>
                    </div>
                    @endif
                </div>
            </div>
            <div class="tab-pane" id="kt_apps_contacts_view_tab_2" role="tabpanel">
                <div class="kt-portlet">
                    <div class="kt-portlet__head">
                        <div class="kt-portlet__head-label">
                            <h3 class="kt-portlet__head-title  kt-font-danger">
                               Family
                            </h3>
                        </div>
                        <div class="kt-portlet__head-toolbar">
                            <a href="javascript:;" data-attr="{{route('employee.account.personal.family.create',$karyawan->id)}}" class="btn btn-default  btn-icon-sm btn-sm btn-add-family">
                                <i class="la la-list"></i>
                                Add
                            </a>
                        </div>
                    </div>
                    <div class="kt-portlet__body">
                        <table class="table kt-datatable__tabletable-checkable dataTable no-footer dtr-inline karyawan-table" style="font-size:11px;" id="personal-family">
                            <thead>
                                <tr role="row">
                                    <th>Name</th>
                                    <th>Relationship</th>
                                    <th>Birthdate</th>
                                    <th>Marital Status</th>
                                    <th>Gender</th>
                                    <th>Job</th>
                                    <th>Religion</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
            <div class="tab-pane" id="kt_apps_contacts_view_tab_3" role="tabpanel">
                <div class="kt-portlet">
                    <div class="kt-portlet__head">
                        <div class="kt-portlet__head-label">
                            <h3 class="kt-portlet__head-title  kt-font-danger">
                               Emergency Contact
                            </h3>
                        </div>
                        <div class="kt-portlet__head-toolbar">
                            <a href="javascript:;" data-attr="{{route('employee.account.personal.emergency.create',$karyawan->id)}}" class="btn btn-default  btn-icon-sm btn-sm btn-add-emergency">
                                <i class="la la-list"></i>
                                Add
                            </a>
                        </div>
                    </div>
                    <div class="kt-portlet__body">
                        <table class="table kt-datatable__tabletable-checkable dataTable no-footer dtr-inline karyawan-table" style="font-size:11px;" id="emergency-personal">
                            <thead>
                                <tr role="row">
                                    <th>Name</th>
                                    <th>Relationship</th>
                                    <th>Phone Number</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
        </div>
    </div>
    <!--end::Form-->
</div>
@php
$karyawanid = $karyawan->id;
@endphp
@endsection
@include('admin.karyawan.account.personal.modal')
@include('admin.karyawan.account.personal.edit.modal')
@push('scriptjs')
<script>
var karyawan_id = {{ $karyawanid }};
$(document).ready(function(){

    var datatable1 = $("#personal-family").DataTable({
        drawCallback:function(){$(".dataTables_paginate > .pagination").addClass("pagination-rounded")},
        responsive:true,
        "bFilter": true,
        bStateSave: true,
        "bJQueryUI": true,
        paging:true,
        select:true,
        serverSide:true,
        ajax:{
            url:'{{ route('employee.account.personal.family.ajax') }}',
            type:'post',
            data:{"_token": "{{ csrf_token() }}","id":karyawan_id},
        },
        columns:[
            { data:'name'},
            { data:'relationship'},
            { data:'birthdate'},
            { data:'marital_status'},
            { data:'gender'},
            { data:'job'},
            { data:'religion'},
            { data:'actions'}
        ],
    });

    var datatable2 = $("#emergency-personal").DataTable({
        drawCallback:function(){$(".dataTables_paginate > .pagination").addClass("pagination-rounded")},
        responsive:true,
        "bFilter": true,
        bStateSave: true,
        "bJQueryUI": true,
        paging:true,
        select:true,
        serverSide:true,
        ajax:{
            url:'{{ route('employee.account.personal.emergency.ajax') }}',
            type:'post',
            data:{"_token": "{{ csrf_token() }}","id":karyawan_id},
        },
        columns:[
            { data:'name'},
            { data:'relationship'},
            { data:'phone_number'},
            { data:'actions'}
        ],
    });
});

$(document).on('click','.btn-add-family',function(e){
    e.preventDefault();
    var create = $(this).attr('data-attr');
    $.ajax({
        url: create,
        success: function(results) {
            console.log(results,create);
            $('#modalpersonalform .modal-title').html('');
            $('#modalpersonalform').modal("show");
            $('#modalpersonalcontent').html(results).show();
            $('.select-custom').select2({
				placeholder: "Select a choose"
			});
            $('.datepicker-modal').datepicker({
				todayHighlight: true,
				orientation: "bottom left",
			});

        },
        timeout: 8000
    });
});

$(document).on('click','.btn-edit-family',function(e){
    e.preventDefault();
    var create = $(this).attr('data-attr');
    $.ajax({
        url: create,
        success: function(results) {
            console.log(results,create);
            $('#modalpersonalform .modal-title').html('');
            $('#modalpersonalform').modal("show");
            $('#modalpersonalcontent').html(results).show();
            $('.select-custom').select2({
				placeholder: "Select a choose"
			});
            $('.datepicker-modal').datepicker({
				todayHighlight: true,
				orientation: "bottom left",
			});
        },
        timeout: 8000
    });
});

$(document).on('click','.btn-show-family',function(e){
    e.preventDefault();
    var create = $(this).attr('data-attr');
    $.ajax({
        url: create,
        success: function(results) {
            console.log(results,create);
            $('#modalpersonalform .modal-title').html('');
            $('#modalpersonalform').modal("show");
            $('#modalpersonalcontent').html(results).show();
        },
        timeout: 8000
    });
});

$(document).on('click','.btn-add-emergency',function(e){
    e.preventDefault();
    var create = $(this).attr('data-attr');
    $.ajax({
        url: create,
        success: function(results) {
            console.log(results,create);
            $('#modalpersonalform .modal-title').html('');
            $('#modalpersonalform').modal("show");
            $('#modalpersonalcontent').html(results).show();
            $('.select-custom').select2({
				placeholder: "Select a choose"
			});
            $('.datepicker-modal').datepicker({
				todayHighlight: true,
				orientation: "bottom left",
			});

        },
        timeout: 8000
    });
});

$(document).on('click','.btn-edit-emergency',function(e){
    e.preventDefault();
    var create = $(this).attr('data-attr');
    $.ajax({
        url: create,
        success: function(results) {
            console.log(results,create);
            $('#modalpersonalform .modal-title').html('');
            $('#modalpersonalform').modal("show");
            $('#modalpersonalcontent').html(results).show();
            $('.select-custom').select2({
				placeholder: "Select a choose"
			});
            $('.datepicker-modal').datepicker({
				todayHighlight: true,
				orientation: "bottom left",
			});
        },
        timeout: 8000
    });
});

$(document).on('click','.btn-show-emergency',function(e){
    e.preventDefault();
    var create = $(this).attr('data-attr');
    $.ajax({
        url: create,
        success: function(results) {
            console.log(results,create);
            $('#modalpersonalform .modal-title').html('');
            $('#modalpersonalform').modal("show");
            $('#modalpersonalcontent').html(results).show();
        },
        timeout: 8000
    });
});

$(document).on('click','.btn-edit-personal',function(e){
    e.preventDefault();
    var create = $(this).attr('data-attr');
    $.ajax({
        url: create,
        success: function(results) {
            console.log(results,create);
            $('#modalpersosnaleditform .modal-title').html('');
            $('#modalpersosnaleditform').modal("show");
            $('#modalpersosnaleditcontent').html(results).show();
        },
        timeout: 8000
    });
});


$(document).on('click','#reject-request',function() {
    swal.fire({
        title: 'Auto close alert!',
        text: 'I will close in 5 seconds.',
        timer: 2000,
        position: 'center',
        type: 'error',
        showConfirmButton: false,
    })
});

</script>
@endpush
