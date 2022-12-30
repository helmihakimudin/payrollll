@extends('karyawan.account.index',[
	'pages'=>'payroll-info',
	'subpages'=>''
])
@section('content-account')

<div class="kt-portlet">
    <div class="kt-portlet__head">
        <div class="kt-portlet__head-label justify-content-center">
            <h3 class="kt-portlet__head-title">
                Detail Payslip
            </h3>
        </div>
        <div class="kt-portlet__head-toolbar ustify-content-right">
            <a href="{{route('emp.payroll.payslip.download.pdf',$payslip->id)}}" target="_blank" class="btn btn-secondary btn-pill"><i class="fa fa-download"></i> Download</a>
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
                        <div class="col">tests</div>
                    </div>
                    <div class="d-flex p-1">
                        <div class="col-5">ID/ Name</div>
                        <div class="col-auto">:</div>
                        <div class="col">Sakti Tua Petrus davici Banjarnahor</div>
                    </div> 
                    <div class="d-flex p-1">
                        <div class="col-5">Organization</div>
                        <div class="col-auto">:</div>
                        <div class="col">TADS</div>
                    </div> 
                    <div class="d-flex p-1">
                        <div class="col-5">Grade / Level</div>
                        <div class="col-auto">:</div>
                        <div class="col">-/ Supervisor</div>
                    </div> 
                </div>
                <div class="col-6">
                    <div class="d-flex p-1">
                        <div class="col-5">Job Position</div>
                        <div class="col-auto">:</div>
                        <div class="col">Programmer Supervisor</div>
                    </div>
                    <div class="d-flex p-1">
                        <div class="col-5">PTKP</div>
                        <div class="col-auto">:</div>
                        <div class="col">TK/0</div>
                    </div> 
                    <div class="d-flex p-1">
                        <div class="col-5">NPWP</div>
                        <div class="col-auto">:</div>
                        <div class="col">00.0000.000.0-0000.000</div>
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
                            <tr>
                                <td> <small>Basic Salary</small></td><td class="text-right"><small>Rp. 3.500.000</small></td>
                            </tr>
                            <tr>
                                <td><small>Tunjangan Jabatan</small></td><td class="text-right"><small>Rp.1.500.000</small></td>
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
                                <td> <small>BPJS kesehatan</small></td><td class="text-right"><small>Rp. 3.500.000</small></td>
                            </tr>
                            <tr>
                                <td><small>JHT Employee</small></td><td class="text-right"><small>Rp.1.500.000</small></td>
                            </tr>
                            <tr>
                                <td><small>Potongan Keterlambatan</small></td><td class="text-right"><small>Rp.1.500.000</small></td>
                            </tr>
                            <tr>
                                <td><small>Potongan Pph 21</small></td><td class="text-right"><small>Rp.1.500.000</small></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="col-lg-6 col-merge border">
                    <table class="table m-0">
                        <thead class="thead-light">
                            <tr>
                                <th colspan="2">Total earnings</th><th class="text-right">Rp. 3.500.000</th>
                            </tr>
                        </thead>
                    </table>
                </div>
                <div class="col-lg-6 col-merge border">
                    <table class="table m-0">
                        <thead class="thead-light">
                            <tr>
                                <th colspan="2">Total Deductions</th><th class="text-right">Rp. 3.500.000</th>
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
                                <th colspan="2" style="font-size:18px;">Take Home Pays</th><th class="text-right" style="font-size:18px;">Rp. 4.130.000</th>
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
                            <tr>
                                <td> <small>JKK</small></td><td class="text-right"><small>Rp. 16.800</small></td>
                            </tr>
                            <tr>
                                <td><small>JKM</small></td><td class="text-right"><small>Rp. 21.000</small></td>
                            </tr>
                            <tr>
                                <td><small>JHT Company</small></td><td class="text-right"><small>Rp. 259.000</small></td>
                            </tr>
                            <tr>
                                <td><small>BPJS Kesehatan Company</small></td><td class="text-right"><small>Rp. 280.000</small></td>
                            </tr>
                        </tbody>
                    </table>  
                </div>
                <div class="col-lg-6 col-merge">
                    <table class="table">
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
                    </table>
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
                    <small class="font-weight-bold text-dark">This payslip generated by Talenta.co</small>
                </div> 
                <div class="col text-right">
                    <a href="https://hr.talenta.co" target="_blank" class="font-weight-bold"><small dclass="font-weight-bold text-dark">https://duasisi.id</small></a>
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