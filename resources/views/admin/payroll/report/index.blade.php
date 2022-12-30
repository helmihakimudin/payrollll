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
                        Report Payroll {{date("F Y")}}
                    </h3>
                    <span class="kt-subheader__separator kt-subheader__separator--v"></span>
                    <div class="kt-subheader__group" id="kt_subheader_search">
                        <h3 class="kt-subheader__desc">
                            <a href="{{route('payroll.report')}}" class="kt-nav__link">Report</a>
                        </h3>
                    </div>
                </div>
            </div>
        </div>
        <div class="kt-container  kt-grid__item kt-grid__item--fluid">
            <div class="kt-portlet">
                <div class="kt-portlet__body kt-portlet__body--fit">
                    <div class="row row-no-padding row-col-separator-xl">
                        <div class="col-md-12 col-lg-12 col-xl-6">

                            <!--begin:: Widgets/Stats2-1 -->
                            <div class="kt-widget1">
                                <div class="kt-widget1__item">
                                    <div class="kt-widget1__info">
                                        <h3 class="kt-widget1__title">Salary Detail</h3>
                                    </div>
                                   <a href="{{route('payroll.salary.detail')}}" class="btn btn btn-warning">View Detail</a>
                                </div>
                                <div class="kt-widget1__item">
                                    <div class="kt-widget1__info">
                                        <h3 class="kt-widget1__title">Summary Report By Organization</h3>
                                    </div>
                                   <button class="btn btn btn-warning">View Detail</button>
                                </div>
                                <div class="kt-widget1__item">
                                    <div class="kt-widget1__info">
                                        <h3 class="kt-widget1__title">Payslip</h3>
                                    </div>
                                    <a href="{{route('payroll.report.payslip')}}" class="btn btn btn-warning">View Detail</a>
                                </div>
                            </div>

                            <!--end:: Widgets/Stats2-1 -->
                        </div>
                        <div class="col-md-12 col-lg-12 col-xl-6">

                            <!--begin:: Widgets/Stats2-2 -->
                            <div class="kt-widget1">
                                <div class="kt-widget1__item">
                                    <div class="kt-widget1__info">
                                        <h3 class="kt-widget1__title">THR Report</h3>
                                    </div>
                                   <button class="btn btn btn-warning">View Detail</button>
                                </div>
                                <div class="kt-widget1__item">
                                    <div class="kt-widget1__info">
                                        <h3 class="kt-widget1__title">THR Slip</h3>
                                    </div>
                                   <button class="btn btn btn-warning">View Detail</button>
                                </div>
                            </div>

                            <!--end:: Widgets/Stats2-2 -->
                        </div>
                    </div>
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