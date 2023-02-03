@extends('admin.karyawan.account.base',[
	'pages'=>'payroll',
	'subpages'=>'payroll-payslip-thr'
])
@section('content-account')

<div class="kt-portlet">
    <div class="kt-portlet__head">
        <div class="kt-portlet__head-label justify-content-center">
            <h3 class="kt-portlet__head-title">
                Detail Payslip THR
            </h3>
        </div>
        <div class="kt-portlet__head-toolbar ustify-content-right">
            <a href="{{route('employee.payroll.payslip.thr.download.pdf',$karyawan->id)}}" target="_blank" class="btn btn-secondary btn-pill"><i class="fa fa-download"></i> Download</a>
        </div>
    </div>
    <div class="kt-portlet__body" id="printableArea">
        <div class="form-group mb-5">
            <div class="row">
                <div class="col-lg-8">
                    <img src="{{asset("logo/duasisi.png")}}" alt="" width="20%">
                </div>
                <div class="col-lg-4 align-self-center text-right">
                    <h4 class="kt-portlet__head-title text-danger m-0">
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
                        PAYSLIP THR
                    </h5>
                </div>
            </div>
        </div>
        <div class="form-group">
            <div class="row">
                <div class="col-6">
                    <div class="d-flex p-1">
                        <div class="pl-0 col-5">ID/ Name</div>
                        <div class="col-auto">:</div>
                        <div class="col">{{$karyawan->full_name}}</div>
                    </div>
                    <div class="d-flex p-1">
                        <div class="pl-0 col-5">Organization</div>
                        <div class="col-auto">:</div>
                        <div class="col">{{$karyawan->organization->name}}</div>
                    </div>
                    <div class="d-flex p-1">
                        <div class="pl-0 col-5">Length Off Service</div>
                        <div class="col-auto">:</div>
                        <div class="col">
                        @php
                            $entry_date = \Carbon\Carbon::parse($karyawan->join_date);
                            $year   = \Carbon\Carbon::now()->diffInYears($entry_date);
                            $entry_date->addYears($year);
                            $month  = \Carbon\Carbon::now()->diffInMonths($entry_date);
                            $entry_date->addMonths($month);
                            $day    = \Carbon\Carbon::now()->diffInDays($entry_date);
                        @endphp
                        {{$year}} Year {{$month}} Month {{$day}} Day
                        </div>
                    </div>
                </div>
                <div class="col-6">
                    <div class="d-flex p-1">
                        <div class="col-5">Job Position</div>
                        <div class="col-auto">:</div>
                        <div class="col">{{$karyawan->jobPosition->name}}</div>
                    </div>
                    <div class="d-flex p-1">
                        <div class="col-5">PTKP</div>
                        <div class="col-auto">:</div>
                        <div class="col">{{$karyawan->ptkp_status}}</div>
                    </div>
                    <div class="d-flex p-1">
                        <div class="col-5">NPWP</div>
                        <div class="col-auto">:</div>
                        <div class="col">{{$karyawan->npwp}}</div>
                    </div>
                </div>
            </div>
            <div class="row py-5">
                <div class="col-lg-6 col-merge border">
                    <table class="table">
                        <thead class="thead-light">
                            <tr>
                                <th colspan="2">Earnings</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td> <small>THR</small></td><td class="text-right"><small>@currency($karyawan->thr->amount_thr)</small></td>
                            </tr>
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
                            <tr>
                                <td><small>PPH 21 (THR)</small></td><td class="text-right"><small>@currency($karyawan->thr->amount_thr)</small></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="col-lg-6 col-merge border">
                    <table class="table m-0">
                        <thead class="thead-light">
                            <tr>
                                <th colspan="2">Total earnings</th><th class="text-right">@currency($karyawan->thr->amount_thr)</th>
                            </tr>
                        </thead>
                    </table>
                </div>
                <div class="col-lg-6 col-merge border">
                    <table class="table m-0">
                        <thead class="thead-light">
                            <tr>
                                <th colspan="2">Total Deductions</th><th class="text-right">@currency($karyawan->thr->amount_thr)</th>
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
                                <th colspan="2" style="font-size:18px;">Take Home Pay</th><th class="text-right" style="font-size:18px;">Rp. 2.000.000</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
            <div class="row">
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
            </div>
        </div>
    </div>
    <!--end::Form-->
</div>


@endsection
@push('scriptjs')
<script>

</script>
@endpush
