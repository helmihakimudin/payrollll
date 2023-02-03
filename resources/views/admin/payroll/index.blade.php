@extends('layout-admin.base',[
	'pages'=>'payroll',
	'subpages'=>'payroll'
])
@section('content')

@include('admin.payslip-type.view')
@include('admin.payslip-type.modal')
<div class="kt-body kt-grid__item kt-grid__item--fluid kt-grid kt-grid--hor kt-grid--stretch" id="kt_body">
    <div class="kt-content  kt-grid__item kt-grid__item--fluid kt-grid kt-grid--hor" id="kt_content">
        <div class="kt-subheader kt-grid__item" id="kt_subheader">
            <div class="kt-container">
                <div class="kt-subheader__main">
                    <h1 class="kt-subheader__title">
                        Welcome to payroll E- Smart
                    </h1>
                    <span class="kt-subheader__separator kt-subheader__separator--v"></span>
                    <div class="kt-subheader__group" id="kt_subheader_search">
                        <h3 class="kt-subheader__desc m-0">
                          PT DUAISI SEJAHTERA
                        </h3>
                    </div>
                </div>
            </div>
        </div>
        <div class="kt-container kt-grid__item kt-grid__item--fluid">
            <div class="row">
                <div class="col-3 mb-lg-4">
                    <a href="{{route("payroll.component")}}">
                        <img src="{{asset("image/update_payroll.jpg")}}" class="rounded" width="100%" alt="image">
                        <div class="bottom-left text-image-cover">Update Payroll Component</div>
                    </a>
                </div>
                <div class="col-3 mb-lg-4">
                    <a href="javascript:;" data-attr="{{route('payroll.show.run')}}" class="btn-run-payroll">
                        <img src="{{asset("image/run_payroll.jpg")}}" class="rounded" width="100%" alt="image">
                        <div class="bottom-left text-image-cover">Run Payroll</div>
                    </a>
                </div>
                <div class="col-3 mb-lg-4">
                    <a href="{{route('payroll.report')}}">
                        <img src="{{asset("image/view_report.jpg")}}" class="rounded" width="100%" alt="image">
                        <div class="bottom-left text-image-cover">View Report</div>
                    </a>
                </div>
                <div class="col-3 mb-lg-4">
                    <a href="{{route('payroll.setting')}}">
                        <img src="{{asset("image/setting.jpg")}}" class="rounded" width="100%" alt="image">
                        <div class="bottom-left text-image-cover">Settings</div>
                    </a>
                </div>
                <div class="col-3">
                    <a href="{{route('payroll.import')}}">
                        <img src="{{asset("image/import_payroll.jpg")}}" class="rounded" width="100%" alt="image">
                        <div class="bottom-left text-image-cover">Import Payroll</div>
                    </a>
                </div>
                <div class="col-3">
                    <a href="{{route('payroll.show.thr')}}">
                        <img src="{{asset("image/run_thr.jpg")}}" width="100%" alt="image">
                        <div class="bottom-left text-image-cover">Run THR</div>
                    </a>
                </div>
                <div class="col-3">
                    <a href="">
                        <img src="{{asset("image/ex_employee-1.jpg")}}" width="100%" alt="image">
                        <div class="bottom-left text-image-cover">Ex Employee Allowance </div>
                    </a>
                </div>
                <div class="col-3">
                    <a href="{{route('payroll.calculator')}}">
                        <img src="{{asset("image/salary_tax-1.jpg")}}" width="100%" alt="image">
                        <div class="bottom-left text-image-cover">Salary Tax Calculator</div>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@include('admin.payroll.run-payroll.modal')
@push('scriptjs')
<script>
$(document).on('click','.btn-run-payroll',function(e){
    e.preventDefault();
    var edit = $(this).attr('data-attr');
    $.ajax({
        url: edit,
        success: function(result) {
            $('#modalrunform .modal-title').html('Edit Akses izin');
            $('#modalrunform').modal("show");
            $('#modalruncontent').html(result).show();
            $('.select2').select2();
            $('#kt_select2_3, #kt_select2_3_validate').select2({
                placeholder: "Select a state",
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
</script>
@endpush
