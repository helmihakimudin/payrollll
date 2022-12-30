@extends('layout-admin.base',[
	'pages'=>'payroll',
	'pages'=>'payroll',
])
@section('content')
<div class="kt-body kt-grid__item kt-grid__item--fluid kt-grid kt-grid--hor kt-grid--stretch" id="kt_body">
    <div class="kt-content  kt-grid__item kt-grid__item--fluid kt-grid kt-grid--hor" id="kt_content">
        <div class="kt-subheader   kt-grid__item" id="kt_subheader">
            <div class="kt-container pt-3">
                <div class="kt-subheader__main">
                    <h3 class="kt-subheader__title">
                        Salary Detail Payroll {{date("F Y")}}
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
                            <a href="{{route('payroll.salary.detail')}}" class="kt-nav__link">Salary Detail</a>
                        </h3>
                    </div>
                </div>
            </div>
        </div>
        <div class="kt-container  kt-grid__item kt-grid__item--fluid">
            <form action="{{route('payroll.salary.detail')}}"  method="GET" id="filter">
                <div class="row mt-4">
                    <div class="col-lg-4">
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
                    <div class="col-lg-4">
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
                    <div class="col-lg-3 ">
                        <button type="submit" form="filter" class="btn btn-primary mt-4">
                            <i class="fa fa-filter"></i>
                            Filter
                        </button>
                    </div>
                </div>
            </form>
            <div class="kt-portlet">
                <div class="kt-portlet__body ">
                    <table class="table kt-datatable__tabletable-checkable dataTable no-footer dtr-inline karyawan-table" style="font-size:11px;" id="continue-table">
                        <thead>
                            <tr role="row">
                                <th>Employee</th>
                                <th>Organization</th>
                                <th>Month</th>
                                <th>Basic Salary</th>
                                <th>Allowance</th>
                                <th>Deductions</th>
                                <th>Take Home Pay</th>
                                <th>Detail</th>
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
                                <td>{{$row->full_name}}</td>
                                <td>{{$row->organization}}</td>
                                <td>{{date("M Y",strtotime($row->salary_month))}}</td>
                                <td>{{"Rp. ".number_format($row->basic_salary)}}</td>
                                <td>{{"Rp. ".number_format($total_allowance)}}</td>
                                <td>{{"Rp. ".number_format($total_deduction)}}</td>
                                <td>{{"Rp. ".number_format($row->net_payble)}}</td>
                                <td>
                                    <a class="btn btn-sm btn-clean btn-icon btn-show-salary" href="javascript:;" data-attr="{{route('payroll.salary.detail.show',$row->id)}}" title="Detail">
                                        <i class="flaticon2-expand"></i>
                                    </a>
                                </td>
                                <td>
                                    <a class="btn btn-sm btn-clean btn-icon btn-show-salarytype" data-attr="{{route('payroll.report.salary.show',['id' => $row->id])}}" title="Delete">
                                        <i class="flaticon-delete"></i>
                                    </a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>

                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@include('admin.payroll.report.salary-type.modal')
@include('admin.payroll.report.salary-type.modal-delete')
@push('scriptjs')
<script>
var datatable1 = $("#continue-table").DataTable({
    bState:true,
});

$(document).on('click','.btn-show-salarytype',function(e){
    e.preventDefault();
    var show = $(this).attr('data-attr');
    $.ajax({
        url: show,
        success: function(result) {
            $('#modalsalarytype .modal-title').html('Edit Akses izin');
            $('#modalsalarytype').modal("show");
            $('#modalsalarytypecontent').html(result).show();

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
</script>
@endpush
