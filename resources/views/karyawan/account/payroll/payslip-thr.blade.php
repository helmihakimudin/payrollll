@extends('karyawan.account.index',[
	'pages'=>'payroll',
	'subpages'=>'payslip-thr'
])
@section('content-account')
@include('karyawan.account.payroll.modal')
<div class="kt-portlet">
    <div class="kt-portlet__head">
        <div class="kt-portlet__head-label">
            <h3 class="kt-portlet__head-title">
                Payslip THR
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
                            <th width="75%">Month & Years</th>
                            <th width="60%">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>September 2022</td>
                            <td>
                                <a href="{{route('emp.payroll.payslip-thr-detail',$karyawan->id)}}" class="btn btn-secondary btn-sm" title="View Payslip">
                                    View Payslip THR
                                </a>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

        </div>
    </div>
</div>
@endsection
@push('scriptjs')
<script>
    
</script>
@endpush