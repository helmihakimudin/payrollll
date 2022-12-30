@extends('layout-admin.base',[
	'pages'=>'payroll',
	'subpages'=>'payroll-payslip'
])
@section('content')
<div class="kt-body kt-grid__item kt-grid__item--fluid kt-grid kt-grid--hor kt-grid--stretch" id="kt_body">
    <div class="kt-content  kt-grid__item kt-grid__item--fluid kt-grid kt-grid--hor" id="kt_content">
        <div class="kt-subheader   kt-grid__item" id="kt_subheader">
            <div class="kt-container pt-3">
                <div class="kt-subheader__main">
                    <h3 class="kt-subheader__title">
                        Detail Payslip
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
                    <span class="kt-subheader__separator kt-subheader__separator--v"></span>
                    <div class="kt-subheader__group" id="kt_subheader_search">
                        <h3 class="kt-subheader__desc">
                            <a href="javascript:;" class="kt-nav__link">Detail Payslip</a>
                        </h3>
                    </div>
                </div>
            </div>
        </div>
        <div class="kt-container  kt-grid__item kt-grid__item--fluid">
            <div class="kt-portlet">
                <div class="kt-portlet__head">
                    <div class="kt-portlet__head-label justify-content-center">
                        <h3 class="kt-portlet__head-title">
                            Detail Payslip
                        </h3>
                    </div>
                    <div class="kt-portlet__head-toolbar ustify-content-right">
                        <a href="{{route('payroll.report.payslip.detail.pdf',$payslip->id)}}" target="_blank" class="btn btn-secondary btn-pill"><i class="fa fa-download"></i> Download</a>
                    </div>
                </div>
                <div class="kt-portlet__body" id="printableArea">
                    <div class="form-group">
                        <div class="row">
                            <div class="col-lg-8">
                                <img src="{{asset("logo/duasisi.png")}}" alt="" width="20%">
                            </div>
                            <div class="col-lg-4 text-right">
                                <h4 class="kt-portlet__head-title text-danger">
                                    *CONFIDENTIAL
                                </h4>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-lg-8">
                                <h5 class="kt-portlet__head-title">
                                    Cabang Golf Lake
                                </h5>
                            </div>
                            <div class="col-lg-4 text-right">
                                <h5 class="kt-portlet__head-title ">
                                    PAYSLIP
                                </h5>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-6">
                                <div class="d-flex p-1">
                                    <div class="col-5">payroll cut off</div>
                                    <div class="col-auto">:</div>
                                    @php
                                     $date = strtotime($payslip->salary_month);
                                    @endphp
                                    <div class="col">{{date('26 M',strtotime('-1 month',$date))}} - {{date('25 M Y',strtotime($payslip->salary_month))}}</div>
                                </div>
                                <div class="d-flex p-1">
                                    <div class="col-5">ID/ Name</div>
                                    <div class="col-auto">:</div>
                                    <div class="col">{{$payslip->full_name}}</div>
                                </div>
                                <div class="d-flex p-1">
                                    <div class="col-5">Organization</div>
                                    <div class="col-auto">:</div>
                                    <div class="col">{{$payslip->organization}}</div>
                                </div>
                                <div class="d-flex p-1">
                                    <div class="col-5">Job Level</div>
                                    <div class="col-auto">:</div>
                                    <div class="col">{{$payslip->job_level}}</div>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="d-flex p-1">
                                    <div class="col-5">Job Position</div>
                                    <div class="col-auto">:</div>
                                    <div class="col">{{$payslip->job_position}}</div>
                                </div>
                                <div class="d-flex p-1">
                                    <div class="col-5">PTKP</div>
                                    <div class="col-auto">:</div>
                                    <div class="col">{{$payslip->ptkp_status}}</div>
                                </div>
                                <div class="d-flex p-1">
                                    <div class="col-5">NPWP</div>
                                    <div class="col-auto">:</div>
                                    @if($payslip->npwp != null)
                                    <div class="col">{{$payslip->npwp}}</div>
                                    @else
                                    <div class="col">00.0000.000.0-0000.000</div>
                                    @endif

                                </div>
                            </div>
                        </div>
                        <div class="row pt-5">
                            <div class="col-lg-6 col-merge border">
                                <table class="table">
                                    <thead class="thead-light">
                                        <tr>
                                            <th colspan="2">Earnings</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                            $total_allowance = 0;
                                            $allowance = json_decode($payslip->allowance)

                                        @endphp
                                        @foreach($allowance as $row)
                                        @php
                                            $total_allowance += $row->amount;
                                        @endphp
                                        <tr>
                                            <td> <small>{{$row->component}}</small></td><td class="text-right"><small>Rp. {{number_format($row->amount)}}</small></td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <div class="col-lg-6 col-merge border">
                                <table class="table">
                                    <thead class="thead-light">
                                        <tr>
                                            <th colspan="2">Deductions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                        $total_deduction = 0;
                                        $deduction = json_decode($payslip->deduction);
                                        @endphp
                                        @foreach($deduction as $deduc)
                                        @php
                                            $total_deduction += $deduc->amount;
                                        @endphp
                                        <tr>
                                            <td> <small>{{$deduc->component}}</small></td><td class="text-right"><small>Rp. {{number_format($deduc->amount)}}</small></td>
                                        </tr>
                                        @endforeach
                                        @if($payslip->is_bpjs_active)
                                            @php
                                                $bpjs_kesehatan = 0;
                                                $jht_employee = 0;

                                                $bpjs_kesehatan = (1/100 * $payslip->basic_salary);
                                                $jht_employee   = (2/100 * $payslip->basic_salary);
                                                $total_deduction = $total_deduction + $bpjs_kesehatan + $jht_employee;

                                                $mergebpjs =  $bpjs_kesehatan + $jht_employee;
                                                $netpayble =  $payslip->net_payble - $mergebpjs;
                                            @endphp
                                            <tr>
                                                <td> <small>Bpjs Kesehatan Employee</small></td><td class="text-right"><small>Rp. {{number_format($bpjs_kesehatan)}}</small></td>
                                            </tr>
                                            <tr>
                                                <td> <small>JHT  Employee</small></td><td class="text-right"><small>Rp. {{number_format($jht_employee)}}</small></td>
                                            </tr>
                                        @else
                                            @php
                                                $bpjs_kesehatan = 0;
                                                $jht_employee = 0;
                                                $mergebpjs =  $bpjs_kesehatan + $jht_employee;
                                                $netpayble =  $payslip->net_payble - $mergebpjs;
                                            @endphp
                                        @endif
                                    </tbody>
                                </table>
                            </div>
                            <div class="col-lg-6 col-merge border">
                                <table class="table m-0">
                                    <thead class="thead-light">
                                        <tr>
                                            <th colspan="2">Total earnings</th><th class="text-right">Rp. {{number_format($total_allowance)}}</th>
                                        </tr>
                                    </thead>
                                </table>
                            </div>
                            <div class="col-lg-6 col-merge border">
                                <table class="table m-0">
                                    <thead class="thead-light">
                                        <tr>
                                            <th colspan="2">Total Deductions</th><th class="text-right">Rp. {{number_format($total_deduction)}}</th>
                                        </tr>
                                    </thead>
                                </table>
                            </div>
                            <div class="col-lg-6 col-merge">
                                <table class="table m-0">
                                    <thead class="thead-light">
                                        <tr>
                                            &nbsp;
                                        </tr>
                                    </thead>
                                </table>
                            </div>
                            <div class="col-lg-6">
                                <table class="table m-0 no-border">
                                    <thead>
                                        <tr >
                                            <th colspan="2" style="font-size:18px;">Take Home Pays</th><th class="text-right" style="font-size:18px;">Rp. {{number_format($netpayble)}}</th>
                                        </tr>
                                    </thead>
                                </table>
                            </div>
                        </div>

                        <div class="row pt-5">
                            <div class="col-lg-6 col-merge">
                                <table class="table">
                                    <thead >
                                        <tr>
                                            <th colspan="2">Benefit *</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                        $jkk = 0;
                                        $jkk = (0.24/100 * $payslip->basic_salary);
                                        $jkm = 0;
                                        $jkm = (0.3/100 * $payslip->basic_salary);
                                        $jht = 0;
                                        $jht = (3.7/100 * $payslip->basic_salary);
                                        $bkc = 0;
                                        $bkc = (4/100 * $payslip->basic_salary);
                                        @endphp
                                        <tr>
                                            <td> <small>JKK</small></td><td class="text-right"><small>Rp. {{number_format($jkk)}}</small></td>
                                        </tr>
                                        <tr>
                                            <td><small>JKM</small></td><td class="text-right"><small>Rp. {{number_format($jkm)}}</small></td>
                                        </tr>
                                        <tr>
                                            <td><small>JHT Company</small></td><td class="text-right"><small>Rp. {{number_format($jht)}}</small></td>
                                        </tr>
                                        <tr>
                                            <td><small>BPJS Kesehatan Company</small></td><td class="text-right"><small>Rp. {{number_format($bkc)}}</small></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div class="col-lg-6 col-merge">
                                <!-- <table class="table">
                                    <thead>
                                        <tr>
                                            <th colspan="2">Attendance Summary *</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td> <small>Actual Working Day</small></td><td class="text-right"><small>19</small></td>
                                        </tr>
                                        <tr>
                                            <td> <small>Schedule Working Day</small></td><td class="text-right"><small>19</small></td>
                                        </tr>
                                        <tr>
                                            <td> <small>Day Off</small></td><td class="text-right"><small>7</small></td>
                                        </tr>
                                        <tr>
                                            <td><small>National Holiday</small></td><td class="text-right"><small>7</small></td>
                                        </tr>
                                        <tr>
                                            <td><small>Company Holiday</small></td><td class="text-right"><small>7</small></td>
                                        </tr>
                                        <tr>
                                            <td><small>Attendance / Time Off Code</small></td><td class="text-right"><small>H:17 CT:2</small></td>
                                        </tr>
                                    </tbody>
                                </table> -->
                            </div>
                        </div>
                        <div class="row pt-5">
                            <p class="text-dark justify-content-center">
                                <small>*These are the benefits you'll get from the company, but not included in your take-home pay (THP).</small>
                                <br>
                                <br>
                                THIS IS COMPUTER GENERATED PRINTOUT AND NO SIGNATURE IS REQUIRED
                                <br>
                                <br>
                                PLEASE NOTE THAT THE CONTENTS OF THIS STATEMENT SHOULD BE TREATED WITH ABSOLUTE CONFIDENTIALITY EXCEPT TO THE EXTENT YOU ARE REQUIRED TO
                                MAKE DISCLOSURE FOR ANY TAX, LEGAL, OR REGULATORY PURPOSES. ANY BREACH OF THIS CONFIDENTIALITY OBLIGATION WILL BE DEALT WITH SERIOUSLY,
                                WHICH MAY INVOLVE DISCPLINARY ACTION BEING TAKEN.
                                <br>
                                <br>
                                HARAP DIPERHATIKAN, ISI PERNYATAAN INI ADALAH RAHASIA KECUALI ANDA DIMINTA UNTUK MENGUNGKAPKANNYA UNTUK KEPERLUAN PAJAK, HUKUM, ATAU
                                KEPENTINGAN PEMERINTAH. SETIAP PELANGGARAN ATAS KEWAJIBAN MENJAGA KERAHASIAAN INI AKAN DIKENAKAN SANKSI, YANG MUNGKIN BERUPA TINDAKAN
                                KEDISIPLINAN.
                            </p>
                        </div>
                        <div  class="row pt-5">
                            <div class="col">
                                <small class="font-weight-bold text-dark">This payslip generated by E-Smart</small>
                            </div>
                            <div class="col text-right">
                                <a href="https://hr.talenta.co" target="_blank" class="font-weight-bold"><small dclass="font-weight-bold text-dark">https://duasisi.id</small></a>
                            </div>
                        </div>
                    </div>
                </div>
                <!--end::Form-->
            </div>
        </div>
    </div>
</div>


@endsection
@push('scriptjs')
<script>

</script>
@endpush
