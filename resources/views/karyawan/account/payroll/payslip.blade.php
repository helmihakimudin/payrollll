@extends('karyawan.account.index',[
	'pages'=>'payroll',
	'subpages'=>'payroll-payslip'
])
@section('content-account')
@include('karyawan.account.payroll.modal')
<div class="kt-portlet">
    <div class="kt-portlet__head">
        <div class="kt-portlet__head-label">
            <h3 class="kt-portlet__head-title">
                Payslip
            </h3>
        </div>
        <div class="kt-portlet__head-toolbar">
            
        </div>
    </div>
    <div class="kt-portlet__body">
        <div class="row">
            <div class="col-lg-12">
                <table class="table kt-datatable__tabletable-checkable dataTable no-footer dtr-inline karyawan-table" style="font-size:11px;" id="payslip">
                    <thead>
                        <tr role="row">
                            <th width="15%">Month</th>
                            <th width="60%">Payroll Cut Off</th>
                            <th width="25%">&nbsp;</th>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
           
        </div>
    </div>
    <!--end::Form-->
</div>

@endsection
@push('scriptjs')
<script>
$(document).ready(function(){
    var datatable1 = $("#payslip").DataTable({
        drawCallback:function(){$(".dataTables_paginate > .pagination").addClass("pagination-rounded")},
        responsive:true,
        "bFilter": true,
        bStateSave: true,
        "bJQueryUI": true,
        paging:true,
        select:true,
        serverSide:true,
        ajax:{
            url:'{{ route('emp.payroll.payslip.ajax') }}',
            type:'post',
            data:{"_token": "{{ csrf_token() }}"},
        },
        columns:[
            { data:'salary_month'},
            { data:'payroll_cut_off'},
            { data:'actions'},
        ],
    });
});

$(document).on('click','.btn-show-form-password',function(e){
    e.preventDefault();
    var show = $(this).attr('data-attr');
    $.ajax({
        url: show,
        success: function(result) {
            console.log(show,result)
            $('#modaleducationsform .modal-title').html('Show Passwrod');
            $('#modaleducationsform').modal("show");
            $('#modaleducationscontent').html(result).show();
        },
        timeout: 8000
    });
});
</script>
@endpush