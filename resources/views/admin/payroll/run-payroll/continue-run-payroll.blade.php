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
                        Run Payroll {{date("F Y")}}
                    </h3>
                    <span class="kt-subheader__separator kt-subheader__separator--v"></span>
                </div>
            </div>
        </div>
        <div class="kt-container  kt-grid__item kt-grid__item--fluid">
            <div class="row">
                <div class="col-lg-12">
                    <div class="text-right">
                        <label for="">Select All </label>
                        <input type="checkbox" id="checkAll" name="check-all" class="form-controll">
                    </div>
                    <form action="{{route('payroll.run.payroll')}}" method="POST" id="run-payroll">
                        {{ csrf_field() }}
                        <table class="table kt-datatable__tabletable-checkable dataTable no-footer dtr-inline karyawan-table" style="font-size:11px;" id="continue-table">
                            <thead>
                                <tr role="row">
                                    <th>Employee</th>
                                    <th>Organization</th>
                                    <th>Allowance</th>
                                    <th>Deductions</th>
                                    <th>Take Home Pay</th>
                                    <th>check</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($payrollemployeecomponent as $row)
                                @php
                                    $json = json_decode($row->component);
                                    $total_allowance  = 0;
                                    $total_deductions = 0;
                                @endphp
                                <tr>
                                    <td>{{$row->full_name}}</td>
                                    <td>{{$row->organization}}</td>
                                    <td>
                                    @php
                                        foreach($json as $rows){
                                            if($rows->type == "Allowance"){
                                                $total_allowance += empty($rows->amount) ? 0 : (int)$rows->amount;
                                            }
                                        }

                                        echo "Rp. ". number_format($total_allowance);
                                    @endphp
                                    </td>
                                    <td>
                                        @php
                                            $total_deductions =0;
                                            foreach($json as $rows){
                                                if($rows->type == "Deduction"){
                                                    $total_deductions += $rows->amount;
                                                }
                                            }
                                            echo "Rp. ". number_format($total_deductions);
                                        @endphp
                                </td>
                                    <td>
                                    @php
                                        $total = $total_allowance - $total_deductions;
                                        echo "Rp. ". number_format($total);
                                    @endphp
                                    <input type="hidden" name="total" value="{{$total}}">
                                    </td>
                                    <td>
                                        <input type="checkbox" class="form-controll" name="employee_id[]" value="{{$row->employee_id}}">
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </form>
                </div>
            </div>
            <div class="row pt-5">
                <div class="col-2">
                    &nbsp;
                </div>
                <div class="col-2">
                    &nbsp;
                </div>
                <div class="col-2">
                    <button type="submit" form="run-payroll" class="btn btn-secondary btn-block btn-add-employee">Save And Run Payroll </button>
                </div>
                <div class="col-2">
                    <a href="{{route('payroll')}}" class="btn btn-secondary btn-block btn-add-employee">Back to menu </a>
                </div>
                <div class="col-2">
                    &nbsp;
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@include('admin.employetransfer.modal')
@push('scriptjs')
<script>
var datatable1 = $("#continue-table").DataTable({
    bState:true,
});
$("#checkAll").click(function(){
    $('input:checkbox').not(this).prop('checked', this.checked);
});
</script>
@endpush
