@extends('layout-admin.base',[
	'pages'=>'payroll',
	'subpages'=>'settings'
])
@section('content')
@include('admin.payroll.settings.modal')
<div class="kt-body kt-grid__item kt-grid__item--fluid kt-grid kt-grid--hor kt-grid--stretch" id="kt_body">
    <div class="kt-content  kt-grid__item kt-grid__item--fluid kt-grid kt-grid--hor" id="kt_content">
        <div class="kt-subheader   kt-grid__item" id="kt_subheader">
            <div class="kt-container pt-3">
                <div class="kt-subheader__main">
                    <h1 class="kt-subheader__title">
                        Welcome to payroll E- Smart
                    </h1>
                    <span class="kt-subheader__separator kt-subheader__separator--v"></span>
                    <div class="kt-subheader__group" id="kt_subheader_search">
                        <h3 class="kt-subheader__desc">
                          PT DUAISI SEJAHTERA
                        </h3>
                    </div>
                    <span class="kt-subheader__separator kt-subheader__separator--v"></span>
                    <div class="kt-subheader__group" id="kt_subheader_search">
                        <h3 class="kt-subheader__desc">
                          Settings
                        </h3>
                    </div>
                </div>
            </div>
        </div>
        <div class="kt-container  kt-grid__item kt-grid__item--fluid pt-5">
            <div class="row">
                <div class="col-xl-4">
                    <div class="kt-portlet">
                        <div class="kt-portlet__head">
                            <div class="kt-portlet__head-label">
                                <h3 class="kt-portlet__head-title">
                                    Allowance
                                </h3>
                            </div>
                            <div class="kt-portlet__head-toolbar">
                                <a href="javascript:;" data-attr="{{route('payroll.setting.allowance.create')}}" class="btn btn-default  btn-icon-sm btn-sm btn-add-allow">
                                    <i class="la la-list"></i>
                                    Add 
                                </a>
                            </div>
                        </div>
                        <div class="kt-portlet__body">
                           @foreach($getallowances as $row)
                           <div class="row pt-5">
                                <div class="col-8">
                                    <button class="btn btn-primary btn-block">{{$row->name}}</button>
                                </div>
                                <div class="col-2">
                                    <button type="button" data-attr="{{route("payroll.setting.allowance.edit",$row->id)}}"  class="btn btn-outline-warning btn-elevate btn-icon btn-edit-allow" title="Edit"><i class="la la-edit"></i></button>
                                </div>
                                <div class="col-2">
                                    <button type="button" data-attr="{{route("payroll.setting.allowance.show",$row->id)}}"  class="btn btn-outline-danger btn-elevate btn-icon btn-delete-allow" title="Delete"><i class="flaticon-delete"></i></button>
                                </div>
                           </div>
                           @endforeach
                        </div>
                        <!--end::Form-->
                    </div>
                </div>
                <div class="col-xl-4">
                    <div class="kt-portlet">
                        <div class="kt-portlet__head">
                            <div class="kt-portlet__head-label">
                                <h3 class="kt-portlet__head-title">
                                    Deductions
                                </h3>
                            </div>
                            <div class="kt-portlet__head-toolbar">
                                <a href="javascript:;" data-attr="{{route('payroll.setting.deduction.create')}}" class="btn btn-default  btn-icon-sm btn-sm btn-add-deduction">
                                    <i class="la la-list"></i>
                                    Add 
                                </a>
                            </div>
                        </div>
                        <div class="kt-portlet__body">
                            <div class="kt-portlet__body">
                                @foreach($getdeductions as $row)
                                <div class="row pt-5">
                                     <div class="col-8">
                                         <button class="btn btn-primary btn-block">{{$row->name}}</button>
                                     </div>
                                     <div class="col-2">
                                        <button type="button" data-attr="{{route("payroll.setting.deduction.edit",$row->id)}}"  class="btn btn-outline-warning btn-elevate btn-icon btn-edit-deduction" title="Edit"><i class="la la-edit"></i></button>
                                    </div>
                                    <div class="col-2">
                                        <button type="button" data-attr="{{route("payroll.setting.deduction.show",$row->id)}}"  class="btn btn-outline-danger btn-elevate btn-icon btn-delete-deduction" title="Delete"><i class="flaticon-delete"></i></button>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>
                        <!--end::Form-->
                    </div>
                </div>
                <div class="col-xl-4">
                    <div class="kt-portlet">
                        <div class="kt-portlet__head">
                            <div class="kt-portlet__head-label">
                                <h3 class="kt-portlet__head-title">
                                    Benefits
                                </h3>
                            </div>
                            <div class="kt-portlet__head-toolbar">
                                <a href="javascript:;"data-attr="{{route('payroll.setting.benefit.create')}}" class="btn btn-default  btn-icon-sm btn-sm btn-add-benefit">
                                    <i class="la la-list"></i>
                                    Add 
                                </a>
                            </div>
                        </div>
                        <div class="kt-portlet__body">
                            <div class="kt-portlet__body">
                                @foreach($benefit as $row)
                                <div class="row pt-5">
                                     <div class="col-8">
                                         <button class="btn btn-primary btn-block">{{$row->name}}</button>
                                     </div>
                                     <div class="col-2">
                                         <button type="button" data-attr="{{route("payroll.setting.benefit.edit",$row->id)}}"  class="btn btn-outline-warning btn-elevate btn-icon btn-edit-benefit" title="Edit"><i class="la la-edit"></i></button>
                                     </div>
                                     <div class="col-2">
                                         <button type="button" data-attr="{{route("payroll.setting.benefit.show",$row->id)}}"  class="btn btn-outline-danger btn-elevate btn-icon btn-delete-benefit" title="Delete"><i class="flaticon-delete"></i></button>
                                     </div>
                                </div>
                                @endforeach
                            </div>
                        </div>
                        <!--end::Form-->
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@push('scriptjs')
<script>
$(document).on('click','.btn-show',function(e){
    e.preventDefault();
    var edit = $(this).attr('data-attr');
    $.ajax({
        url: edit,
        success: function(result) {
            $('#modalform .modal-title').html('Edit Akses izin');
            $('#modalform').modal("show");
            $('#modalcontent').html(result).show();	
        },
        timeout: 8000
    });
});


$(document).on('click','.btn-add-allow',function(e){
    e.preventDefault();
    var add = $(this).attr('data-attr');
    $.ajax({
        url: add,
        success: function(result) {

            $('#modalform .modal-title').html('Edit Akses izin');
            $('#modalform').modal("show");
            $('#modalcontent').html(result).show();	
        },
        timeout: 8000
    });
});


$(document).on('click','.btn-edit-allow',function(e){
    e.preventDefault();
    var edit = $(this).attr('data-attr');
    $.ajax({
        url: edit,
        success: function(result) {

            $('#modalform .modal-title').html('Edit Akses izin');
            $('#modalform').modal("show");
            $('#modalcontent').html(result).show();	
        },
        timeout: 8000
    });
});



$(document).on('click','.btn-delete-allow',function(e){
    e.preventDefault();
    var deletes = $(this).attr('data-attr');
    $.ajax({
        url: deletes,
        success: function(result) {

            $('#modalform .modal-title').html('Edit Akses izin');
            $('#modalform').modal("show");
            $('#modalcontent').html(result).show();	
        },
        timeout: 8000
    });
});

$(document).on('click','.btn-add-deduction',function(e){
    e.preventDefault();
    var create = $(this).attr('data-attr');
    $.ajax({
        url: create,
        success: function(result) {
            $('#modalform .modal-title').html('Edit Akses izin');
            $('#modalform').modal("show");
            $('#modalcontent').html(result).show();	
        },
        timeout: 8000
    });
});


$(document).on('click','.btn-edit-deduction',function(e){
    e.preventDefault();
    var edit = $(this).attr('data-attr');
    $.ajax({
        url: edit,
        success: function(result) {
            $('#modalform .modal-title').html('Edit Akses izin');
            $('#modalform').modal("show");
            $('#modalcontent').html(result).show();	
        },
        timeout: 8000
    });
});


$(document).on('click','.btn-delete-deduction',function(e){
    e.preventDefault();
    var show = $(this).attr('data-attr');
    $.ajax({
        url: show,
        success: function(result) {
            $('#modalform .modal-title').html('Edit Akses izin');
            $('#modalform').modal("show");
            $('#modalcontent').html(result).show();	
        },
        timeout: 8000
    });
});




$(document).on('click','.btn-add-benefit',function(e){
    e.preventDefault();
    var create = $(this).attr('data-attr');
    $.ajax({
        url: create,
        success: function(result) {
            $('#modalform .modal-title').html('Edit Akses izin');
            $('#modalform').modal("show");
            $('#modalcontent').html(result).show();	
        },
        timeout: 8000
    });
});


$(document).on('click','.btn-edit-benefit',function(e){
    e.preventDefault();
    var edit = $(this).attr('data-attr');
    $.ajax({
        url: edit,
        success: function(result) {
            $('#modalform .modal-title').html('Edit Akses izin');
            $('#modalform').modal("show");
            $('#modalcontent').html(result).show();	
        },
        timeout: 8000
    });
});

$(document).on('click','.btn-delete-benefit',function(e){
    e.preventDefault();
    var deletes = $(this).attr('data-attr');
    $.ajax({
        url: deletes,
        success: function(result) {
            $('#modalform .modal-title').html('Edit Akses izin');
            $('#modalform').modal("show");
            $('#modalcontent').html(result).show();	
        },
        timeout: 8000
    });
});
</script>
@endpush