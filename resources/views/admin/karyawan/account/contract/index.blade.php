@extends('admin.karyawan.account.base',[
	'pages'=>'file',
	'subpages'=>'contract'
])
@section('content-account')
@include('admin.karyawan.account.contract.modal')
<div class="kt-portlet">
    <div class="kt-portlet__head">
        <div class="kt-portlet__head-label">
            <h3 class="kt-portlet__head-title">
                Contract 
            </h3>
        </div>
        <div class="kt-portlet__head-toolbar">
            <a href="javascript:;" data-attr="{{route('employee.contract.create',$karyawan->id)}}" class="btn btn-default  btn-icon-sm btn-sm btn-add-contract">
                <i class="la la-list"></i>
                Add 
            </a>
        </div>
    </div>
    <div class="kt-portlet__body">
        <div class="kt-portlet__body">
            <div class="row">
                <div class="col-lg-12">
                    <table class="table kt-datatable__tabletable-checkable dataTable no-footer dtr-inline document-table" style="font-size:11px;" id="document-table">
                        <thead>
                            <tr role="row">
                                <th width="15%">Start Date</th>
                                <th width="15%">End Date</th>
                                <th width="15%">Contract File</th>
                                <th width="25%">Actions</th>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
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
@push('scriptjs')
<script>
var karyawan_id = {{ $karyawanid }};
$(document).ready(function(){
    var datatable1 = $("#document-table").DataTable({
        drawCallback:function(){$(".dataTables_paginate > .pagination").addClass("pagination-rounded")},
        responsive:true,
        "bFilter": true,
        bStateSave: true,
        "bJQueryUI": true,
        paging:true,
        select:true,
        serverSide:true,
        ajax:{
            url:'{{ route('employee.contract.ajax') }}',
            type:'post',
            data:{"_token": "{{ csrf_token() }}","id":karyawan_id},
        },
        columns:[
            { data:'start_date'},
            { data:'end_date'},
            { data:'contract'},
            { data:'actions'},
        ],
    });
});

$(document).on('click','.btn-add-contract',function(e){
    e.preventDefault();
    var create = $(this).attr('data-attr');
    $.ajax({
        url: create,
        success: function(results) {
            $('#modaleducationsform .modal-title').html('Edit Akses izin');
            $('#modaleducationsform').modal("show");
            $('#modaleducationscontent').html(results).show();
            $('.datepicker-modal').datepicker({
				todayHighlight: true,
				orientation: "bottom left",
			});
        },
        timeout: 8000
    });
});

$(document).on('click','.btn-edit-contract',function(e){
    e.preventDefault();
    var edit = $(this).attr('data-attr');
    $.ajax({
        url: edit,
        success: function(results) {
            $('#modaleducationsform .modal-title').html('Edit Akses izin');
            $('#modaleducationsform').modal("show");
            $('#modaleducationscontent').html(results).show();
            $('.datepicker-modal').datepicker({
				todayHighlight: true,
				orientation: "bottom left",
			});
        },
        timeout: 8000
    });
});

$(document).on('click','.btn-show-contract',function(e){
    e.preventDefault();
    var show = $(this).attr('data-attr');
    $.ajax({
        url: show,
        success: function(results) {
            $('#modaleducationsform .modal-title').html('Edit Akses izin');
            $('#modaleducationsform').modal("show");
            $('#modaleducationscontent').html(results).show();
        },
        timeout: 8000
    });
});
</script>
@endpush