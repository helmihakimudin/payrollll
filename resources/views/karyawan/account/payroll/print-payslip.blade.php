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
        *CONFIDENTIAL
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
                    <tr>
                        <td id="td-table">Payroll Cut Off</td><td id="td-table">:</td><td id="td-table">26 {{\Carbon\Carbon::parse($payslip->salary_month)->subMonth(1)->format("F Y")}} - 25 {{\Carbon\Carbon::parse($payslip->salary_month)->format("F Y")}}</td>
                    </tr>
                    <tr>
                        <td id="td-table">ID / Name </td><td id="td-table">:</td><td id="td-table">{{$employee->employee_id}} / {{$employee->full_name}}</td>
                    </tr>
                    <tr>
                        <td id="td-table">Organization </td><td id="td-table">:</td><td id="td-table">{{$employee->organization->name}}</td>
                    </tr>
                    <tr>
                        <td id="td-table">Grade / Level </td><td id="td-table">:</td><td id="td-table">{{$employee->jobLevel->name}}</td>
                    </tr>
                <tbody>
            </table>
        </div>
        <div id="third-section-right">
            <table class="table">
                <tbody>
                    <tr>
                        <td id="td-table">Job Position</td><td id="td-table">:</td><td id="td-table">{{$employee->jobPosition->name}}</td>
                    </tr>
                    <tr>
                        <td id="td-table">PTKP</td><td id="td-table">:</td><td id="td-table">{{$employee->ptkp_status}}</td>
                    </tr>
                    <tr>
                        <td id="td-table">NPWP </td><td id="td-table">:</td><td id="td-table">{{$employee->npwp}}</td>
                    </tr>

                <tbody>
            </table>
        </div>
     </div>
     @php
        $jsonAllowance = json_decode($payslip->allowance);
        $jsonDeduction = json_decode($payslip->deduction);
        $total_allowance = (int)$employee->basic_salary;
        $total_deductions = 0;
    @endphp
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
                        foreach($jsonAllowance as $rows)
                        {
                            $total_allowance += empty($rows->amount) ? 0 : (int)$rows->amount;
                        }
                    @endphp
                        <tr>
                            <td class="font-arial"><small>Basic Salary</small></td><td style="text-align:right;"><small>Rp. {{number_format($employee->basic_salary)}}</small></td>
                        </tr>
                    @foreach($jsonAllowance as $rows)
                        <tr>
                            <td class="font-arial"><small>{{$rows->component}}</small></td><td style="text-align:right;"><small>@currency($rows->amount)</small></td>
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
                        foreach($jsonDeduction as $rows)
                        {
                            $total_deductions += empty($rows->amount) ? 0 : (int)$rows->amount;
                        }
                    @endphp
                    @foreach($jsonDeduction as $rows)
                        <tr>
                            <td> <small>{{$rows->component}}</small></td><td style="text-align:right;"><small>@currency($rows->amount)</small></td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
     </div>

     <div id="five-section">
        <div id="five-section-left">
            <table  id="border-table-1" width="100%">
                <tbody>
                    <tr>
                        <td class="font-arial-bold"><small>Total Earnings</small></td><td style="text-align:right;" class="font-arial-bold"><small>@currency($total_allowance)</small></td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div id="five-section-right">
            <table id="border-table-1" width="100%">
                <tbody>
                    <tr>
                        <td class="font-arial-bold"><small>Total Deductions</small></td><td style="text-align:right;" class="font-arial-bold"><small>@currency($total_deductions)</small></td>
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
                        <td class="font-arial-bold-px"><small>Take Home Pays</small></td><td style="text-align:right;" class="font-arial-bold-px"><small>@currency($total_allowance-$total_deductions)</small></td>
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
                    <tr>
                        <td class="font-arial"> <small>JKK</small></td><td style="text-align:right;"><small>Rp. 16.800</small></td>
                    </tr>
                    <tr>
                        <td class="font-arial"><small>JKM</small></td><td style="text-align:right;"><small>Rp. 21.000</small></td>
                    </tr>
                    <tr>
                        <td class="font-arial"><small>JHT Company</small></td><td style="text-align:right;"><small>Rp. 259.000</small></td>
                    </tr>
                    <tr>
                        <td class="font-arial"><small>BPJS Kesehatan Company</small></td><td style="text-align:right;"><small>Rp. 280.000</small></td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div id="seven-section-right">
            <table id="border-table-1" width="100%">
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
            </table>
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
