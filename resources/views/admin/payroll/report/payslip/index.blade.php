@extends('layout-admin.base',[
	'pages'=>'payroll',
	'pages'=>'payroll',
])
@section('content')
<form action="{{route('payroll.report.payslip')}}"  method="GET" id="filter">
    <div class="form-group">
        <div class="row">
            <div class="col-lg-3">
                <div class="form-group">
                    <label for="">Organization</label>
                    @if($organization != null)
                    <select name="organization_id" id="organization_id" class="form-control select2">
                        @foreach(DB::table('organization')->get() as $row)
                        <option @if($organization == $row->id) {{"selected"}} @endif value="{{$row->id}}">{{$row->name}}</option>
                        @endforeach
                    </select>
                    @else
                    <select name="organization_id" id="organization_id" class="form-control select2">
                        @foreach(DB::table('organization')->get() as $row)
                        <option value="{{$row->id}}">{{$row->name}}</option>
                        @endforeach
                    </select>
                    @endif
                </div>
            </div>
            <div class="col-lg-3">
                <div class="form-group">
                    <label for="">Choose Month</label>
                    <div class="input-group">
                        <div class="input-group-prepend"><span class="input-group-text"><i class="fa fa-calendar"></i></span></div>
                        @if($monthpicker != null)
                        <input class="form-control monthpicker" type="text" name="monthpicker" value="{{date('Y-m',strtotime($monthpicker))}}"  placeholder="" required>
                        @else
                        <input class="form-control monthpicker" type="text" name="monthpicker"  placeholder="" required>
                        @endif
                    </div>
                </div>
            </div>
            <div class="col-lg-3">
                <button type="submit" form="filter" class="btn btn-primary" style="margin-top:25px;">
                    <i class="fa fa-filter"></i>
                    Filter
                </button>
                &nbsp;
                <button type="submit" form="form-email-all" class="btn btn-secondary" style="margin-top:25px;">
                    <i class="fa fa-mail-bulk"></i>
                    Send By Email
                </button>
            </div>
            <div class="col-lg-3">

            </div>
        </div>
    </div>
    <div class="row">

    </div>
</form>
<div class="kt-body kt-grid__item kt-grid__item--fluid kt-grid kt-grid--hor kt-grid--stretch" id="kt_body">
    <div class="kt-content  kt-grid__item kt-grid__item--fluid kt-grid kt-grid--hor" id="kt_content">
        <div class="kt-subheader   kt-grid__item" id="kt_subheader">
            <div class="kt-container pt-3">
                <div class="kt-subheader__main">
                    <h3 class="kt-subheader__title">
                        Payslip {{date("F Y")}}
                    </h3>
                    <span class="kt-subheader__separator kt-subheader__separator--v"></span>
                    <div class="kt-subheader__group" id="kt_subheader_search">
                        <h3 class="kt-subheader__desc">
                            <a href="{{route('payroll.report')}}" class="kt-nav__link">Report</a>
                        </h3>
                    </div>
                    <span class="kt-subheader__separator kt-subheader__separator--v"></span>
                    <div class="kt-subheader__group" id="kt_subheader_search">
                        <h3 class="kt-subheader__desc">
                            <a href="{{route('payroll.report.payslip')}}" class="kt-nav__link">Payslip</a>
                        </h3>
                    </div>
                </div>
            </div>
        </div>



        <div class="kt-container  kt-grid__item kt-grid__item--fluid">
            <div class="form-group">
                <label class="kt-checkbox">
                    <input type="checkbox" id="checkAll">Select All
                    <span></span>
                </label>
            </div>
            <div class="kt-portlet">
                <div class="kt-portlet__body ">
                    <form method="POST" action="{{route("payroll.report.payslip.email.all")}}" id="form-email-all">
                        {{ csrf_field() }}
                        <table class="table kt-datatable__tabletable-checkable dataTable no-footer dtr-inline karyawan-table" style="font-size:11px;" id="continue-table">
                            <thead>
                                <tr role="row">
                                    <th>&nbsp;</th>
                                    <th>Employee</th>
                                    <th>Organization</th>
                                    <th>Month</th>
                                    <th>Take Home Pay</th>
                                    <th>Detail</th>
                                    <th>&nbsp;</th>
                                    <th>Delete</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($payslip as $row)
                                @php
                                $allowance = json_decode($row->allowance);
                                $deduction = json_decode($row->deduction);

                                $total_allowance = 0;
                                foreach($allowance as $temp){
                                        $total_allowance += $temp->amount;
                                }

                                $total_deduction = 0;
                                foreach($deduction as $temp2){
                                        $total_deduction += $temp2->amount;
                                }
                                @endphp
                                <tr>
                                    <td>
                                        <label class="kt-checkbox">
                                            <input type="checkbox" name="checkboxid[]"  value="{{$row->id}}" >
                                            <span></span>
                                        </label>
                                    </td>
                                    <td>{{$row->full_name}}</td>
                                    <td>{{$row->organization}}</td>
                                    <td>{{date("M Y",strtotime($row->salary_month))}}</td>
                                    <td>{{"Rp. ".number_format($row->net_payble)}}</td>
                                    <td>
                                        <a class="btn btn-sm btn-clean btn-icon" href="{{route('payroll.report.payslip.detail',$row->id)}}" title="Detail">
                                            <i class="flaticon2-expand"></i>
                                        </a>
                                    </td>
                                    <td>
                                        @if($row->slipbyemail !=0)
                                            <a href="{{route('payroll.report.payslip.byemail',$row->id)}}"  class="btn btn-success  btn-elevate-hover btn-pill"><i class="la la-message"></i>Send Email</a>
                                        @else
                                            <a href="{{route('payroll.report.payslip.byemail',$row->id)}}"  class="btn btn-secondary  btn-elevate-hover btn-pill"><i class="la la-message"></i>Send Email</a>
                                        @endif
                                    </td>
                                    <td>
                                        <a class="btn btn-sm btn-clean btn-icon btn-show-payslip" data-attr="{{route('payroll.report.payslip.show',['id' => $row->id])}}" title="Delete">
                                            <i class="flaticon-delete"></i>
                                        </a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@include('admin.payroll.report.payslip.modal')
@push('scriptjs')
<script>
var datatable1 = $("#continue-table").DataTable({
    bState:true,
});

$(document).on('click','.btn-show-payslip',function(e){
    e.preventDefault();
    var show = $(this).attr('data-attr');
    $.ajax({
        url: show,
        success: function(result) {
            $('#modalpayslip .modal-title').html('');
            $('#modalpayslip').modal("show");
            $('#modalpayslipcontent').html(result).show();

        },
        timeout: 8000
    });
});

$(document).on('click','.btn-show-salary',function(e){
    e.preventDefault();
    var show = $(this).attr('data-attr');
    $.ajax({
        url: show,
        success: function(result) {
            $('#modalshow .modal-title').html('Edit Akses izin');
            $('#modalshow').modal("show");
            $('#modalshowcontent').html(result).show();

        },
        timeout: 8000
    });
});


$('.select2').select2({
    placeholder: "Select a state",
});
$('.monthpicker').datepicker({
    format: "yyyy-mm",
    startView: "months",
    minViewMode: "months",
});

$("#checkAll").click(function(){
    $('input:checkbox').not(this).prop('checked', this.checked);
});

</script>
@endpush
