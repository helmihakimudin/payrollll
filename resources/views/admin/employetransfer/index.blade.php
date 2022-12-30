@extends('layout-admin.base',[
	'pages'=>'employee-transfer',
	'pages'=>'employee-transfer',
])
@section('content')
<style> 
th, td { 
    white-space: nowrap;
    text-align: left;
}
</style>

<div class="row pb-5">
    <div class="col-lg-3">
        @if($countRequest != 0)
            <a href="javascript:;" data-attr="{{route('emp.transfer.message.show')}}" class="btn btn-primary btn-elevate btn-sm notification btn-show-message"><i class="flaticon-email "></i>Message  <span class="badge">{{$countRequest}}</span></a>
        @else 
            <a href="javascript:;" data-attr="" class="btn btn-primary btn-elevate btn-sm"><i class="flaticon-email "></i>Message</a>
        @endif
    </div>
</div>

<div class="kt-body kt-grid__item kt-grid__item--fluid kt-grid kt-grid--hor kt-grid--stretch" id="kt_body">
    <div class="kt-content  kt-grid__item kt-grid__item--fluid kt-grid kt-grid--hor" id="kt_content">
        <div class="kt-subheader   kt-grid__item" id="kt_subheader">
            <div class="kt-container pt-3">
                <div class="kt-subheader__main">
                    <h3 class="kt-subheader__title">
                        Employee Transfer List
                    </h3>
                    <span class="kt-subheader__separator kt-subheader__separator--v"></span>
                    <div class="kt-subheader__group" id="kt_subheader_search">
                        <span class="kt-subheader__desc" id="kt_subheader_total">
                            <a href="javascript:;" data-attr="{{route('employee.transfer.create')}}" class="btn btn-primary rounded-fill btn-add">Transfer Employee</a></span>
                    </div>
                </div>
            </div>
        </div>
        <div class="kt-container  kt-grid__item kt-grid__item--fluid">
            <div class="row">
                <div class="col-lg-12">
                    <table class="table kt-datatable__tabletable-checkable dataTable no-footer dtr-inline karyawan-table" style="font-size:11px;" id="transfer-table">
                        <thead>
                            <tr role="row">
                                <th>Employee Name</th>
                                <th>Effective Date</th>
                                <th>Branch Name</th>
                                <th>Job Position</th>
                                <th>Employeement Status</th>
                                <th>Organization Name</th>
                                <th>Job Level</th>
                                <th>Transfer Reason</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td colspan="10"></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@include('admin.employetransfer.modal')
@push('scriptjs')
<script>
 var datatable1 = $("#transfer-table").DataTable({
        drawCallback:function(){$(".dataTables_paginate > .pagination").addClass("pagination-rounded")},
        scrollX: true,
        bStateSave: true,
        select:true,
        serverSide:true,
        processing: true,
        paging:true,
        ajax:{
            url:'{{ route('employee.transfer.ajax') }}',
            type:'post',
            data:{"_token": "{{ csrf_token() }}"},
        },
        columns:[
            { data:'employee_name'},
            { data:'effective_date'},
            { data:'branch_name'},
            { data:'job_position_name'},
            { data:'employeement_status'},
            { data:'organization_name'},
            { data:'job_level_name'},
            { data:'transfer_reason'},
            { data:'actions'},
        ],
    }); 


$(document).on('click','.btn-add',function(e){
    e.preventDefault();
    var create = $(this).attr('data-attr');
    $.ajax({
        url: create,
        success: function(results) {
            $('#modalform .modal-title').html('');
            $('#modalform').modal("show");
            $('#modalcontent').html(results).show();
            $('.select2').select2({
				placeholder: "Select a choose"
			});
            $('.datepicker').datepicker({
				todayHighlight: true,
				orientation: "bottom left",
			});
        },
        timeout: 8000
    });
});

$(document).on('click','.btn-edit',function(e){
    e.preventDefault();
    var edit = $(this).attr('data-attr');
    $.ajax({
        url: edit,
        success: function(results) {
            $('#modalform .modal-title').html('');
            $('#modalform').modal("show");
            $('#modalcontent').html(results).show();
            $('.select2').select2({
				placeholder: "Select a choose"
			});
            $('.datepicker').datepicker({
				todayHighlight: true,
				orientation: "bottom left",
			});
        },
        timeout: 8000
    });
});

$(document).on('click','.btn-show',function(e){
    e.preventDefault();
    var show = $(this).attr('data-attr');
    $.ajax({
        url: show,
        success: function(results) {
            $('#modalform .modal-title').html('');
            $('#modalform').modal("show");
            $('#modalcontent').html(results).show();
        },
        timeout: 8000
    });
});

$(document).on('click','.btn-show-message',function(e){
    e.preventDefault();
    var show = $(this).attr('data-attr');
    $.ajax({
        url: show,
        success: function(results) {
            $('#modalform .modal-title').html('');
            $('#modalform').modal("show");
            $('#modalcontent').html(results).show();
        },
        timeout: 8000
    });
});
</script>
@endpush