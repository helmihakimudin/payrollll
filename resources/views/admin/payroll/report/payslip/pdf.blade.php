<style>
    #first-section{
        margin-top:20px;
    }
    #section-first-image{
        display: inline-block;
        width: 20%;
        float: left;
    }
    #section-first-title{
        display: inline-block;
        width: 20%;
        float: right;
        color:red;
    }
    #second-section{
        display: inline-block;
        margin-top:50px;

    }
    #section-second-left{
        display: inline-block;
        float: left;
        width: 30%;
        font-size:15px;
        font-weight: bold;
        font-family: Arial, Helvetica, sans-serif;
    }
    #section-second-right{
        display: inline-block;
        margin-top: -2px;
        float: right;
        width: 20%;
        font-size:15px;
        font-weight: bold;
        font-family: Arial, Helvetica, sans-serif;
    }
    #third-section{
        display: inline-block;
        margin-top:50px;
    }
    #third-section-left{
        display: inline-block;
        float: left;
        width: 55%;
        font-family: Arial, Helvetica, sans-serif;
    }
    #third-section-right{
        display: inline-block;
        float: right;
        width: 40%;
        /* border: 1px solid; */
        font-family: Arial, Helvetica, sans-serif;
    }
    .table{
        font-size:12px;
        width: 100%;
        font-weight: :normal;
        font-family: Arial, Helvetica, sans-serif;
        padding-top:10px;
    }
    .table2{
        font-weight: bold;
        font-size:12px;
        font-family: Arial, Helvetica, sans-serif;
    }
    #td-table{
        vertical-align:top;
        padding:3px;

    }
    #four-section{
        display: inline-block;
        margin-top:20px;
        font-family: Arial, Helvetica, sans-serif;
    }
    #four-section-left{
        display: inline-block;
        float: left;
        width:50%;
        height:11%;
        font-family: Arial, Helvetica, sans-serif;
        border-right-style: dotted;
    }
    #four-section-right{
        display: inline-block;
        float: right;
        width: 49%;
        height:11%;
        font-family: Arial, Helvetica, sans-serif;


    }

    #thead-lights{
        background-color: #e2e2e2;
    }

    .font-arial{
        font-family: Arial, Helvetica, sans-serif;
    }

    .font-arial-bold{
        font-family: Arial, Helvetica, sans-serif;
        font-weight: bold;
        font-size: 14px;
    }

    .font-arial-bold-px{
        font-family: Arial, Helvetica, sans-serif;
        font-weight: bold;
        font-size: 20px;
    }

    #five-section{
        display: inline-block;
        margin-top:0px;
        font-family: Arial, Helvetica, sans-serif;
        border: 1px solid;
        border-color: #e2e2e2;

    }
    #five-section-left{
        display: inline-block;
        float: left;
        width:50%;
        min-width: 100px;
        font-family: Arial, Helvetica, sans-serif;
        border-right-style: dotted;
        border: 1px solid;
        border-color: #e2e2e2;
    }
    #five-section-right{
        display: inline-block;
        float: right;
        width: 49%;
        min-width: 100px;
        font-family: Arial, Helvetica, sans-serif;
        border: 1px solid;
        border-color: #e2e2e2;
    }

    #six-section{
        display: inline-block;
        margin-top:25px;
        font-size:15px;
        font-family: Arial, Helvetica, sans-serif;
    }
    #six-section-left{
        display: inline-block;
        float: left;
        width:50%;
        min-width: 100px;
        font-family: Arial, Helvetica, sans-serif;
        border-right-style: dotted;
    }
    #six-section-right{
        display: inline-block;
        float: right;
        width: 49%;
        min-width: 100px;
        font-family: Arial, Helvetica, sans-serif;
    }

    #seven-section{
        display: inline-block;
        margin-top:20px;
        font-family: Arial, Helvetica, sans-serif;
    }
    #seven-section-left{
        display: inline-block;
        float: left;
        width:50%;
        min-width: 100px;
        font-family: Arial, Helvetica, sans-serif;
        border-right-style: dotted;
    }
    #seven-section-right{
        display: inline-block;
        float: right;
        width: 49%;
        min-width: 100px;
        font-family: Arial, Helvetica, sans-serif;
    }

    #eight-section{
        display: inline-block;
        margin-top:170px;
        font-family: Arial, Helvetica, sans-serif;
    }
</style>
<div id="first-section">
    <div id="section-first-image">
        <img src="{{ public_path('logo/duasisi.png')}}" width="100%" alt="">
    </div>
    <div id="section-first-title">
        *COFINDENTAL
    </div>
</div>

<div id="second-section">
    <div id="section-second-left">
       Cabang Golf Lake
    </div>

    <div id="section-second-right">
        Payslip
     </div>

     <div id="third-section">
        <div id="third-section-left">
            <table class="table">
                <tbody>
                    @php
                        $date = strtotime($payslip->salary_month);
                    @endphp
                    <tr>
                        <td id="td-table">Payroll Cut Off</td><td id="td-table">:</td><td id="td-table">{{date('26 M',strtotime('-1 month',$date))}} - {{date('25 M Y',strtotime($payslip->salary_month))}}</td>
                    </tr>
                    <tr>
                        <td id="td-table">ID / Name </td><td id="td-table">:</td><td id="td-table">{{$payslip->employee_id}} / {{$payslip->full_name}}</td>
                    </tr>
                    <tr>
                        <td id="td-table">Organization </td><td id="td-table">:</td><td id="td-table">{{$payslip->organization}}</td>
                    </tr>
                    <tr>
                        <td id="td-table">Job Level </td><td id="td-table">:</td><td id="td-table">{{$payslip->job_level}}</td>
                    </tr>
                <tbody>
            </table>
        </div>
        <div id="third-section-right">
            <table class="table">
                <tbody>
                    <tr>
                        <td id="td-table">Job Position</td><td id="td-table">:</td><td id="td-table">{{$payslip->job_position}}</td>
                    </tr>
                    <tr>
                        <td id="td-table">PTKP</td><td id="td-table">:</td><td id="td-table">{{$payslip->ptkp_status}}</td>
                    </tr>
                    @if($payslip->npwp != null)
                    <tr>
                        <td id="td-table">NPWP </td><td id="td-table">:</td><td id="td-table">{{$payslip->npwp}}</td>
                    </tr>
                    @else
                    <tr>
                        <td id="td-table">NPWP </td><td id="td-table">:</td><td id="td-table">00.000.000.0000</td>
                    </tr>
                    @endif

                <tbody>
            </table>
        </div>
     </div>

     <div id="four-section">
        <div id="four-section-left">
            <table  id="border-table-1" width="100%">
                <thead  id="thead-light">
                    <tr>
                        <th colspan="2" id="thead-lights" class="table2">Earnings</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $total_allowance = 0;
                        $allowance = json_decode($payslip->allowance);
        
                 
                        
                    @endphp
                  
                    @foreach($allowance as $allow)
                    @php
                        $total_allowance += $allow->amount;
                    @endphp
                    <tr>
                        <td class="font-arial"><small>{{$allow->component}} </small></td><td style="text-align:right;"><small>Rp. {{number_format($allow->amount)}}</small></td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div id="four-section-right">
            <table id="border-table-1" width="100%">
                <thead id="thead-lights">
                    <tr>
                        <th colspan="2" id="thead-lights" class="table2">Deductions</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $total_deduction = 0;
                        $deduction = json_decode($payslip->deduction)
                    @endphp
                    @foreach($deduction as $deduc)
                    @php
                        $total_deduction += $deduc->amount;
                    @endphp
                    <tr>
                        <td class="font-arial"><small>{{$deduc->component}}</small></td><td style="text-align:right;"><small>Rp. {{number_format($deduc->amount)}}</small></td>
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
                        <td class="font-arial"><small>Bpjs Kesehatan Employee</small></td><td style="text-align:right;"><small>Rp. {{number_format($bpjs_kesehatan)}}</small></td>
                    </tr>
                    <tr>
                        <td class="font-arial"><small>JHT  Employee</small></td><td style="text-align:right;"><small>Rp. {{number_format($jht_employee)}}</small></td>
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
     </div>

     <div id="five-section">
        <div id="five-section-left">
            <table  id="border-table-1" width="100%">
                <tbody>
                    <tr>
                        <td class="font-arial-bold"><small>Total Earnings</small></td><td style="text-align:right;" class="font-arial-bold"><small>Rp. {{number_format($total_allowance)}}</small></td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div id="five-section-right">
            <table id="border-table-1" width="100%">
                <tbody>
                    <tr>
                        <td class="font-arial-bold"><small>Total Deductions</small></td><td style="text-align:right;" class="font-arial-bold"><small>Rp. {{number_format($total_deduction)}}</small></td>
                    </tr>
                </tbody>
            </table>
        </div>
     </div>

     <div id="six-section">
        <div id="six-section-left">
            <table  id="border-table-1" width="100%">
                <tbody>
                    <tr>
                        &nbsp;
                    </tr>
                </tbody>
            </table>
        </div>
        <div id="six-section-right">
            <table id="border-table-1" width="100%">
                <tbody>
                    <tr>
                        <td class="font-arial-bold-px"><small>Take Home Pays</small></td><td style="text-align:right;" class="font-arial-bold-px"><small>Rp.{{number_format($netpayble)}}</small></td>
                    </tr>
                </tbody>
            </table>
        </div>
     </div>

      <div id="seven-section">
        <div id="four-section-left">
            <table  id="border-table-1" width="100%">
                <thead  id="thead-light">
                    <tr>
                        <th colspan="2" id="thead-lights" class="table2" style="text-align:left;">Benefit *</th>
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
                        <td class="font-arial"> <small>JKK</small></td><td style="text-align:right;"><small>Rp. {{number_format($jkk)}}</small></td>
                    </tr>
                    <tr>
                        <td class="font-arial"><small>JKM</small></td><td style="text-align:right;"><small>Rp. {{number_format($jkm)}}</small></td>
                    </tr>
                    <tr>
                        <td class="font-arial"><small>JHT Company</small></td><td style="text-align:right;"><small>Rp. {{number_format($jht)}}</small></td>
                    </tr>
                    <tr>
                        <td class="font-arial"><small>BPJS Kesehatan Company</small></td><td style="text-align:right;"><small>Rp. {{number_format($bkc)}}</small></td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div id="seven-section-right">
            <!-- <table id="border-table-1" width="100%">
                <thead id="thead-lights">
                    <tr>
                        <th colspan="2" id="thead-lights" class="table2" style="text-align:left;">Attendance Summary</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td> <small>Actual Working Day</small></td><td style="text-align:right;"><small>19</small></td>
                    </tr>
                    <tr>
                        <td> <small>Schedule Working Day</small></td><td style="text-align:right;"><small>19</small></td>
                    </tr>
                    <tr>
                        <td> <small>Day Off</small></td><td style="text-align:right;"><small>7</small></td>
                    </tr>
                    <tr>
                        <td><small>National Holiday</small></td><td style="text-align:right;"><small>7</small></td>
                    </tr>
                    <tr>
                        <td><small>Company Holiday</small></td><td style="text-align:right;"><small>7</small></td>
                    </tr>
                    <tr>
                        <td><small>Attendance / Time Off Code</small></td><td style="text-align:right;"><small>H:17 CT:2</small></td>
                    </tr>
                </tbody>
            </table> -->
        </div>
     </div>

     <div id="eight-section">
        <small style="font-size:9px;">*These are the benefits you'll get from the company, but not included in your take-home pay (THP).</small>
        <p style="font-size:9px;text-align:justify;">
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
</div>
