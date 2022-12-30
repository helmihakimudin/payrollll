@extends('karyawan.account.index',[
	'pages'=>'general',
	'subpages'=>'education'
])
@section('content-account')

<div class="kt-portlet">
    <div class="kt-portlet__head">
        <div class="kt-portlet__head-label">
            <h3 class="kt-portlet__head-title">
                Education & Experience
            </h3>
        </div>
        <div class="kt-portlet__head-toolbar">
            
        </div>
    </div>
    <div class="kt-portlet__body">
        <!--Begin:: Portlet-->
        <div class="tab-content kt-margin-t-5">
            <!--Begin:: Tab Content-->
                <ul class="nav nav-tabs nav-tabs-space-lg nav-tabs-line nav-tabs-bold nav-tabs-line-3x nav-tabs-line-brand" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" data-toggle="tab" href="#kt_apps_contacts_view_tab_1" role="tab">
                             Formal Education
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="tab" href="#kt_apps_contacts_view_tab_2" role="tab">
                            Informal Education
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="tab" href="#kt_apps_contacts_view_tab_3" role="tab">
                             Working Experience
                        </a>
                    </li>
                </ul>
                <div class="tab-pane active" id="kt_apps_contacts_view_tab_1" role="tabpanel">
                    <div class="kt-portlet">
                        <div class="kt-portlet__head">
                            <div class="kt-portlet__head-label">
                                <h3 class="kt-portlet__head-title  kt-font-danger">
                                    Formal Education
                                </h3>
                            </div>
                            <div class="kt-portlet__head-toolbar">
                                <a href="javascript:;" data-attr="{{route('emp.account.education.create',Auth::guard('emp')->user()->id)}}" class="btn btn-default  btn-icon-sm btn-sm btn-add-education">
                                    <i class="la la-list"></i>
                                    Add 
                                </a>
                            </div>
                        </div>
                        <div class="kt-portlet__body">
                            <table class="table kt-datatable__tabletable-checkable dataTable no-footer dtr-inline karyawan-table" style="font-size:11px;" id="formal-education">
                                <thead>
                                    <tr role="row">
                                        <th>Grade</th>
                                        <th>Institution name</th>
                                        <th>Majors</th>
                                        <th>Start year</th>
                                        <th>End year</th>
                                        <th>Score</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                        </div>
        
                    </div>
                </div>
                <!--End:: Tab Content-->

                <!--Begin:: Tab Content-->
                <div class="tab-pane" id="kt_apps_contacts_view_tab_2" role="tabpanel">
                    <div class="kt-portlet">
                        <div class="kt-portlet__head">
                            <div class="kt-portlet__head-label">
                                <h3 class="kt-portlet__head-title  kt-font-danger">
                                    Informal Education
                                </h3>
                            </div>
                            <div class="kt-portlet__head-toolbar">
                                <a href="javascript:;" data-attr="{{route('emp.account.education.informal.create',Auth::guard('emp')->user()->id)}}" class="btn btn-default  btn-icon-sm btn-sm btn-add-education-informal">
                                    <i class="la la-list"></i>
                                    Add 
                                </a>
                            </div>
                        </div>
                        <div class="kt-portlet__body">
                            <table class="table kt-datatable__tabletable-checkable dataTable no-footer dtr-inline karyawan-table" style="font-size:11px;" id="informal-education">
                                <thead>
                                    <tr role="row">
                                        <th>name</th>
                                        <th>Held By</th>
                                        <th>Start date</th>
                                        <th>End date</th>
                                        <th>duration</th>
                                        <th>fee</th>
                                        <th>Certificate</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                        </div>
        
                    </div>
                </div>
                <!--End:: Tab Content-->

                <!--Begin:: Tab Content-->
                <div class="tab-pane" id="kt_apps_contacts_view_tab_3" role="tabpanel">
                    <div class="kt-portlet">
                        <div class="kt-portlet__head">
                            <div class="kt-portlet__head-label">
                                <h3 class="kt-portlet__head-title  kt-font-danger">
                                    Working Experience
                                </h3>
                            </div>
                            <div class="kt-portlet__head-toolbar">
                                <a href="javascript:;" data-attr="{{route('emp.account.education.working.create',Auth::guard('emp')->user()->id)}}" class="btn btn-default  btn-icon-sm btn-sm btn-add-education-working">
                                    <i class="la la-list"></i>
                                    Add 
                                </a>
                            </div>
                        </div>
                        <div class="kt-portlet__body">
                            <table class="table kt-datatable__tabletable-checkable dataTable no-footer dtr-inline karyawan-table" style="font-size:11px;" id="working-experience">
                                <thead>
                                    <tr role="row">
                                        <th>Company</th>
                                        <th>Position</th>
                                        <th>From</th>
                                        <th>To</th>
                                        <th>Lenght Of Service</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                        </div>
        
                    </div>
                </div>
                <!--End:: Tab Content-->
        </div>
        <!--End:: Portlet-->
    </div>
    <!--end::Form-->
</div>

@endsection
@include('karyawan.account.education.modal')
@push('scriptjs')
<script>
$(document).ready(function(){
    var datatable1 = $("#formal-education").DataTable({
        drawCallback:function(){$(".dataTables_paginate > .pagination").addClass("pagination-rounded")},
        responsive:true,
        "bFilter": true,
        bStateSave: true,
        "bJQueryUI": true,
        paging:true,
        select:true,
        serverSide:true,
        ajax:{
            url:'{{ route('emp.account.education.ajax') }}',
            type:'post',
            data:{"_token": "{{ csrf_token() }}"},
        },
        columns:[
            { data:'grade'},
            { data:'institute_name'},
            { data:'major'},
            { data:'start_year'},
            { data:'end_year'},
            { data:'score'},
            { data:'actions'}
        ],
    });


    var datatable2 = $("#informal-education").DataTable({
        drawCallback:function(){$(".dataTables_paginate > .pagination").addClass("pagination-rounded")},
        responsive:true,
        "bFilter": true,
        bStateSave: true,
        "bJQueryUI": true,
        paging:true,
        select:true,
        serverSide:true,
        ajax:{
            url:'{{ route('emp.account.education.informal.ajax') }}',
            type:'post',
            data:{"_token": "{{ csrf_token() }}"},
        },
        columns:[
            { data:'name'},
            { data:'held_by'},
            { data:'start_date'},
            { data:'end_date'},
            { data:'duration'},
            { data:'fee'},
            { data:'certificate'},
            { data:'actions'}
        ],
    });

    var datatable3 = $("#working-experience").DataTable({
        drawCallback:function(){$(".dataTables_paginate > .pagination").addClass("pagination-rounded")},
        responsive:true,
        "bFilter": true,
        bStateSave: true,
        "bJQueryUI": true,
        paging:true,
        select:true,
        serverSide:true,
        ajax:{
            url:'{{ route('emp.account.education.working.ajax') }}',
            type:'post',
            data:{"_token": "{{ csrf_token() }}"},
        },
        columns:[
            { data:'company'},
            { data:'position'},
            { data:'froms'},
            { data:'tos'},
            { data:'length'},
            { data:'actions'}
        ],
    });  
});


$(document).on('click','.btn-add-education',function(e){
    e.preventDefault();
    var create = $(this).attr('data-attr');
    $.ajax({
        url: create,
        success: function(results) {
            console.log(results,create);
            $('#modaleducationsform .modal-title').html('Edit Akses izin');
            $('#modaleducationsform').modal("show");
            $('#modaleducationscontent').html(results).show();
            $('.select-custom').select2({
				placeholder: "Select a choose"
			});
            $('.datepicker-modal').datepicker({
                format: "yyyy",
                viewMode: "years",
                minViewMode: "years"
			});

        },
        timeout: 8000
    });
});

$(document).on('click','.btn-edit-education',function(e){
    e.preventDefault();
    var create = $(this).attr('data-attr');
    $.ajax({
        url: create,
        success: function(results) {
            console.log(results,create);
            $('#modaleducationsform .modal-title').html('Edit Akses izin');
            $('#modaleducationsform').modal("show");
            $('#modaleducationscontent').html(results).show();
            $('.select-custom').select2({
				placeholder: "Select a choose"
			});
            $('.datepicker-modal').datepicker({
                format: "yyyy",
                viewMode: "years",
                minViewMode: "years"
			});

        },
        timeout: 8000
    });
});
$(document).on('click','.btn-show-education',function(e){
    e.preventDefault();
    var create = $(this).attr('data-attr');
    $.ajax({
        url: create,
        success: function(results) {
            console.log(results,create);
            $('#modaleducationsform .modal-title').html('Edit Akses izin');
            $('#modaleducationsform').modal("show");
            $('#modaleducationscontent').html(results).show();
        },
        timeout: 8000
    });
});



$(document).on('click','.btn-add-education-informal',function(e){
    e.preventDefault();
    var create = $(this).attr('data-attr');
    $.ajax({
        url: create,
        success: function(results) {
            console.log(results,create);
            $('#modaleducationsform .modal-title').html('Edit Akses izin');
            $('#modaleducationsform').modal("show");
            $('#modaleducationscontent').html(results).show();
            $('.select-custom').select2({
				placeholder: "Select a choose"
			});
            $('.datepicker-modal').datepicker({
				todayHighlight: true,
				orientation: "bottom left",
			});
            $(".nominal").on('keyup', function(){
                 var n = parseInt($(this).val().replace(/\D/g,''),10) || '';
                $(this).val(n.toLocaleString());
            });
        },
        timeout: 8000
    });
});

$(document).on('click','.btn-add-education-informal',function(e){
    e.preventDefault();
    var create = $(this).attr('data-attr');
    $.ajax({
        url: create,
        success: function(results) {
            console.log(results,create);
            $('#modaleducationsform .modal-title').html('Edit Akses izin');
            $('#modaleducationsform').modal("show");
            $('#modaleducationscontent').html(results).show();
            $('.select-custom').select2({
				placeholder: "Select a choose"
			});
            $('.datepicker-modal').datepicker({
				todayHighlight: true,
				orientation: "bottom left",
			});
            $(".nominal").on('keyup', function(){
                 var n = parseInt($(this).val().replace(/\D/g,''),10) || '';
                $(this).val(n.toLocaleString());
            });

        },
        timeout: 8000
    });
});

$(document).on('click','.btn-edit-education-informal',function(e){
    e.preventDefault();
    var edit = $(this).attr('data-attr');
    console.log(edit);
    $.ajax({
        url: edit,
        success: function(results) {

            $('#modaleducationsform .modal-title').html('Edit Akses izin');
            $('#modaleducationsform').modal("show");
            $('#modaleducationscontent').html(results).show();
            $('.select-custom').select2({
				placeholder: "Select a choose"
			});
            $('.datepicker-modal').datepicker({
				todayHighlight: true,
				orientation: "bottom left",
			});
            $(".nominal").on('keyup', function(){
                 var n = parseInt($(this).val().replace(/\D/g,''),10) || '';
                $(this).val(n.toLocaleString());
            });

        },
        timeout: 8000
    });
});

$(document).on('click','.btn-show-education-informal',function(e){
    e.preventDefault();
    var create = $(this).attr('data-attr');
    $.ajax({
        url: create,
        success: function(results) {
            console.log(results,create);
            $('#modaleducationsform .modal-title').html('Edit Akses izin');
            $('#modaleducationsform').modal("show");
            $('#modaleducationscontent').html(results).show();
        },
        timeout: 8000
    });
});


$(document).on('click','.btn-add-education-working',function(e){
    e.preventDefault();
    var create = $(this).attr('data-attr');
    $.ajax({
        url: create,
        success: function(results) {
            $('#modaleducationsform .modal-title').html('Edit Akses izin');
            $('#modaleducationsform').modal("show");
            $('#modaleducationscontent').html(results).show();
            $('.select-custom').select2({
				placeholder: "Select a choose"
			});
            $('.monthpicker').datepicker({
                format: "yyyy-mm",
                startView: "months", 
                minViewMode: "months",
            });
        },
        timeout: 8000
    });
});

$(document).on('click','.btn-edit-education-working',function(e){
    e.preventDefault();
    var edit = $(this).attr('data-attr');
    $.ajax({
        url: edit,
        success: function(results) {
            $('#modaleducationsform .modal-title').html('Edit Akses izin');
            $('#modaleducationsform').modal("show");
            $('#modaleducationscontent').html(results).show();
            $('.select-custom').select2({
				placeholder: "Select a choose"
			});
            $('.monthpicker').datepicker({
                format: "yyyy-mm",
                startView: "months", 
                minViewMode: "months",
            });
        },
        timeout: 8000
    });
});


$(document).on('click','.btn-show-education-working',function(e){
    e.preventDefault();
    var create = $(this).attr('data-attr');
    $.ajax({
        url: create,
        success: function(results) {
            console.log(results,create);
            $('#modaleducationsform .modal-title').html('Edit Akses izin');
            $('#modaleducationsform').modal("show");
            $('#modaleducationscontent').html(results).show();
        },
        timeout: 8000
    });
});

</script>
@endpush