@extends('karyawan.account.index',[
	'pages'=>'general',
	'subpages'=>'personality'
])
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
                <div id="show-personal">
                    <div class="row">
                        <div class="col-lg-4">
                            <span class="font-weight-bold"> Personal Data </span><br>
                            <span style="font-size:11px;">Your email address is your identity on Talenta is used to log in.</span>
                        </div>
                        <div class="col-lg-6">
                            <ul class="list-unstyled mb-0">
                                <li>
                                    <div class="row py-2">
                                        <div class="col-sm-4 d-flex align-items-center">
                                            <span class="font-weight-bold"> Full name </span>
                                        </div>
                                        <div class="col-sm-8"><p class="m-0">{{Auth::guard('emp')->user()->full_name}}</p></div>
                                    </div>
                                </li>
                                <li>
                                    <div class="row py-2">
                                            <div class="col-sm-4 d-flex align-items-center">
                                                <span class="font-weight-bold"> Phone number (Home) </span>
                                            </div>
                                        <div class="col-sm-8"><p class="m-0">{{Auth::guard('emp')->user()->phone}}</p></div>
                                    </div>
                                </li>
                                <li>
                                    <div class="row py-2">
                                            <div class="col-sm-4 d-flex align-items-center">
                                                <span class="font-weight-bold"> Mobile phone </span>
                                            </div>
                                        <div class="col-sm-8"><p class="m-0">{{Auth::guard('emp')->user()->mobile_phone}}</p></div>
                                    </div>
                                </li>
                                <li>
                                    <div class="row py-2">
                                            <div class="col-sm-4 d-flex align-items-center">
                                                <span class="font-weight-bold"> Email </span>
                                            </div>
                                        <div class="col-sm-8"><p class="m-0">{{Auth::guard('emp')->user()->email}}</p></div>
                                    </div>
                                </li>
                                <li>
                                    <div class="row py-2">
                                            <div class="col-sm-4 d-flex align-items-center">
                                                <span class="font-weight-bold">Place Of Birth</span>
                                            </div>
                                        <div class="col-sm-8"><p class="m-0">{{Auth::guard('emp')->user()->place_of_birth}}</p></div>
                                    </div>
                                </li>
                                <li>
                                    <div class="row py-2">
                                            <div class="col-sm-4 d-flex align-items-center">
                                                <span class="font-weight-bold">Date of Birth</span>
                                            </div>
                                        <div class="col-sm-8"><p class="m-0">{{date('d M Y',strtotime(Auth::guard('emp')->user()->date_of_birth))}}&nbsp;<span class="ml-2 text-warning kt-font-bold kt-badge--inline">({{$age}} years old )</span></p></div>
                                    </div>
                                </li>
                                <li>
                                    <div class="row py-2">
                                            <div class="col-sm-4 d-flex align-items-center">
                                                <span class="font-weight-bold">Blood of type</span>
                                            </div>
                                        <div class="col-sm-8"><p class="m-0">{{Auth::guard('emp')->user()->blood_type}}</p></div>
                                    </div>
                                </li>
                                <li>
                                    <div class="row py-2">
                                            <div class="col-sm-4 d-flex align-items-center">
                                                <span class="font-weight-bold">Merriage status</span>
                                            </div>
                                        <div class="col-sm-8"><p class="m-0"> {{Auth::guard('emp')->user()->marital_status}}</p></div>
                                    </div>
                                </li>
                                <li>
                                    <div class="row py-2">
                                            <div class="col-sm-4 d-flex align-items-center">
                                                <span class="font-weight-bold">Religion</span>
                                            </div>
                                        <div class="col-sm-8"><p class="m-0"> {{Auth::guard('emp')->user()->religion}}</p></div>
                                    </div>
                                </li>
                            </ul>
                        </div>
                        <div class="col-lg-2">
                            <button type="button" data-attr="{{route("emp.account.personal.request.edit",Auth::guard('emp')->user()->id)}}" class="btn btn-light btn-elevate-hover btn-edit-personal rounded"><i class="la la-edit"></i> Edit</button>
                        </div>
                    </div>
                </div>
                <div id="edit-personal" class="d-none">
                    {{-- show edit --}}
                </div>

                <div class="kt-separator kt-separator--border-dashed kt-separator--space-lg"></div>
                <div class="row" id="show-identity">
                    <div class="col-lg-4">
                        <span class="font-weight-bold">  Identity & Address</span><br>
                    </div>
                    <div class="col-lg-6">
                        <ul class="list-unstyled mb-0">
                            <li>
                                <div class="row py-2">
                                        <div class="col-sm-4 d-flex align-items-center">
                                            <span class="font-weight-bold"> ID TYPE </span>
                                        </div>
                                    <div class="col-sm-8"><p class="m-0">{{Auth::guard("emp")->user()->identity_type}}</p></div>
                                </div>
                            </li>
                            <li>
                                <div class="row py-2">
                                        <div class="col-sm-4 d-flex align-items-center">
                                            <span class="font-weight-bold"> ID Number </span>
                                        </div>
                                    <div class="col-sm-8"><p class="m-0">{{Auth::guard('emp')->user()->identity_number}}</p></div>
                                </div>
                            </li>
                            <li>
                                <div class="row py-2">
                                        <div class="col-sm-4 d-flex align-items-center">
                                            <span class="font-weight-bold"> ID expiration date </span>
                                        </div>
                                    <div class="col-sm-8"><p class="m-0">{{"Permanent"}}</p></div>
                                </div>
                            </li>
                            <li>
                                <div class="row py-2">
                                        <div class="col-sm-4 d-flex align-items-center">
                                            <span class="font-weight-bold"> Postal code </span>
                                        </div>
                                    <div class="col-sm-8"><p class="m-0">{{Auth::guard("emp")->user()->postal_code}}</p></div>
                                </div>
                            </li>
                            <li>
                                <div class="row py-2">
                                        <div class="col-sm-4 d-flex align-items-center">
                                            <span class="font-weight-bold"> Citizen ID address</span>
                                        </div>
                                    <div class="col-sm-8"><p class="m-0">{{Auth::guard('emp')->user()->citizien_id_address}}</p></div>
                                </div>
                            </li>
                            <li>
                                <div class="row py-2">
                                        <div class="col-sm-4 d-flex align-items-center">
                                            <span class="font-weight-bold"> Residential address</span>
                                        </div>
                                    <div class="col-sm-8"><p class="m-0">{{Auth::guard('emp')->user()->residential_address}}</p></div>
                                </div>
                            </li>
                        </ul>
                    </div>
                    <div class="col-lg-2">
                        <button type="button" data-attr="{{route("emp.account.personal.identity.request.edit",Auth::guard('emp')->user()->id)}}" class="btn btn-light btn-elevate-hover rounded btn-edit-personal-identity"><i class="la la-edit"></i> Edit</button>
                    </div>
                </div>
                <div id="edit-identity" class="d-none">
                    {{-- show edit --}}
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
                            <a href="javascript:;" data-attr="{{route('emp.account.personal.family.create',Auth::guard('emp')->user()->id)}}" class="btn btn-default  btn-icon-sm btn-sm btn-add-family">
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
                            <a href="javascript:;" data-attr="{{route('emp.account.personal.emergency.create',Auth::guard('emp')->user()->id)}}" class="btn btn-default  btn-icon-sm btn-sm btn-add-emergency">
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
@endsection
@include('karyawan.account.personal.modal')
@push('scriptjs')
<script>
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
            url:'{{ route('emp.account.personal.family.ajax') }}',
            type:'post',
            data:{"_token": "{{ csrf_token() }}"},
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
            url:'{{ route('emp.account.personal.emergency.ajax') }}',
            type:'post',
            data:{"_token": "{{ csrf_token() }}"},
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
            // console.log(results,create);
            $('#modalpersonalform .modal-title').html('');
            $('#modalpersonalform').modal("show");
            $('#modalpersonalcontent').html(results).show();
            $('.select-custom').select2({
				placeholder: "Select a choose"
			});
            $('.datepicker-modal').datepicker({
				todayHighlight: true,
                orientation: "bottom left",
                format: "dd/mm/yyyy",
                autoclose: true,
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
            // console.log(results,create);
            $('#modalpersonalform .modal-title').html('');
            $('#modalpersonalform').modal("show");
            $('#modalpersonalcontent').html(results).show();
            $('.select-custom').select2({
				placeholder: "Select a choose"
			});
            $('.datepicker-modal').datepicker({
				todayHighlight: true,
                orientation: "bottom left",
                format: "dd/mm/yyyy",
                autoclose: true,
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
            // console.log(results,create);
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
            // console.log(results,create);
            $('#modalpersonalform .modal-title').html('');
            $('#modalpersonalform').modal("show");
            $('#modalpersonalcontent').html(results).show();
            $('.select-custom').select2({
				placeholder: "Select a choose"
			});
            $('.datepicker-modal').datepicker({
				todayHighlight: true,
                orientation: "bottom left",
                format: "dd/mm/yyyy",
                autoclose: true,
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
            // console.log(results,create);
            $('#modalpersonalform .modal-title').html('');
            $('#modalpersonalform').modal("show");
            $('#modalpersonalcontent').html(results).show();
            $('.select-custom').select2({
				placeholder: "Select a choose"
			});
            $('.datepicker-modal').datepicker({
				todayHighlight: true,
                orientation: "bottom left",
                format: "dd/mm/yyyy",
                autoclose: true,
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
            // console.log(results,create);
            $('#modalpersonalform .modal-title').html('');
            $('#modalpersonalform').modal("show");
            $('#modalpersonalcontent').html(results).show();
        },
        timeout: 8000
    });
});



$(document).on('click','.btn-edit-personal',function(e){
    e.preventDefault();
    var personal = $(this).attr('data-attr');
    $.ajax({
        url: personal,
        success: function(result) {
            $("#edit-personal").html(result);
            $("#edit-personal").removeClass('d-none');
            $("#show-personal").addClass('d-none');
            $('.datepicker-modal').datepicker({
                todayHighlight: true,
                orientation: "bottom left",
                format: "dd/mm/yyyy",
                autoclose: true,
			});
            $('.select-custom').select2({
				placeholder: "Select a choose"
			});
            $('.btn-cancel-personal').on('click',function(){
                $("#edit-personal").addClass('d-none');
                $("#show-personal").removeClass('d-none');
            });
        },
        timeout: 8000
    });
});

$(document).on('click','.btn-edit-personal-identity',function(e){
    e.preventDefault();
    var identity = $(this).attr('data-attr');
    $.ajax({
        url: identity,
        success: function(result) {
            // console.log(result)
            $("#edit-identity").html(result);
            $("#edit-identity").removeClass('d-none');
            $("#show-identity").addClass('d-none');
            $('.datepicker-modal').datepicker({
				todayHighlight: true,
                orientation: "bottom left",
                format: "dd/mm/yyyy",
                autoclose: true,
			});
            $('.select-custom').select2({
				placeholder: "Select a choose"
			});
            $('.btn-cancel-identity').on('click',function(){
                $("#edit-identity").addClass('d-none');
                $("#show-identity").removeClass('d-none');
            });
        },
        timeout: 8000
    });
});

$(document).on('click',"input[name='checkbox_residential_address']",function(){
    if ($(this).is(":checked")){
        let checked = $("#citizien_id_address").val();
        $("#residential_address").val(checked)
    } else {
        $("#residential_address").val($("[name='residential_address_hidden']").val())
    }
});
</script>
@endpush
