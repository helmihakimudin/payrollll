<style>
  #border{
        border-style: solid;
        border-width: 2px;
    }
    #all-section{
        margin:20px;
    }
    #section-image{
        display: inline-block;
        width: 20%;
        float: left;
    }
    #section-title{
        display: inline-block;
        width: 78%;
        float: right;
    }
    #left-title{
        margin-top:0px;
        font-family: "Arial, Helvetica, sans-serif";
        display: inline-block;
        width:50%;
        float: left;
    }
    #right-title{
        margin-top:0px;ddddddd
        font-family: "Arial, Helvetica, sans-serif";
        display: inline-block;
        width:20%;
        float: right;
    }
    hr.new5{
      border: 10px ;
      border-radius: 5px;
      margin-right: -50px;
      margin-top:-10px;
      height: 5px;
      color:black;
    }
    #section-address{
        display: inline-block;
        width:100%;
        margin-top:-2px;
        font-size:12px;
        font-family: "Arial, Helvetica, sans-serif";
       
    }
    #bottom-left-title{
        font-family: "Arial, Helvetica, sans-serif";
        display: inline-block;
        width:50%;
        float: left;
    }
    #bottom-right-title{
        margin-left: 60px;
        font-family: "Arial, Helvetica, sans-serif";
        float: right;
        width:21%;
    }
    #card-members{
        margin-top:15px;
        display: inline-block;
        width:100%;
    }
    #card-member-1{
        font-family: "Arial, Helvetica, sans-serif";
        font-size:12px; 
    }
    #card-left-member{
        font-family: "Arial, Helvetica, sans-serif";
        width:40%;
        float: left;
        display: inline-block;
    }
    #pendapatan-content{
        font-family: "Arial, Helvetica, sans-serif";
        font-size:16px; 
    }
    
    #card-right-member{
        font-family: "Arial, Helvetica, sans-serif";
        width:40%;
        float: right;
        display: inline-block; 
    }
    #header{
        margin-top:5px;
        display: inline-block;
        width:100%;
    }
    #line-1{
        margin-bottom:-1px;
        height: 2px;
        color:black;
    }
    #line-2{
        margin-top:2px;
        height: 2px;
        color:black;
    }
    #line-3{
        margin-top:-9px;
        height: 2px;
        color:black;
    }
    #pdt-left{
        font-family: "Arial, Helvetica, sans-serif";
        width:40%;
        float: left;
        display: inline-block;
    }
    #pdt-right{
        font-family: "Arial, Helvetica, sans-serif";
        width:40%;
        float: right;
        display: inline-block;
    }
    #content{
        margin-top:0px;
        display: inline-block;
        width:100%;
    }
    #content-left{
        width:45%;
        float: left;
        display: inline-block;
     
    }
    #content-right{
        width:40%;
        float: right;
        display: inline-block;
       
    }
    .text-small{
        font-family: "Arial, Helvetica, sans-serif";
        font-size:12px; 
    }
    #footer{
        margin-top:1px;
        display: inline-block;
        width:100%;
        height: -1%;
        background-color:#f3bc07;
    }
    #clear-slip{
        margin-top:1px;
        display: inline-block;
        width:45%; 
    }
    #keterangan{
        margin-left:5px;
        margin-top:35px;
        display: inline-block;
        width:54%; 
    }
    #signature{
        margin-top:-50px;
        width:25%;
        float: right;
        display: inline-block;
    }
    </style>
       @php
        $dt = date('m',strtotime($payslip->salary_month));
        $dts = strtotime($payslip->salary_month);
        $comissionmonth = date("F", strtotime("-1 month", $dts));
        $comissionmonths = $dt;
        $komisidate="";
        $komisidates="";
        if($comissionmonths == "01"){
            $komisidates  = "Januari";
        }else if($comissionmonths == "02"){
            $komisidates = "Februari";
        }else if($comissionmonths == "03"){
            $komisidates  = "Maret";
        }else if($comissionmonths == "04"){
            $komisidates = "April";
        }else if($comissionmonths == "05"){
            $komisidates = "Mei";
        }else if($comissionmonths == "06"){
            $komisidates = "Juni";
        }else if($comissionmonths == "07"){
            $komisidates = "July";
        }else if($comissionmonths == "08"){
            $komisidates = "Agustus";
        }else if($comissionmonths == "09"){
            $komisidates = "September";
        }else if($comissionmonths == "10"){
            $komisidates = "Oktober";
        }else if($comissionmonths == "11"){
            $komisidates = "November";
        }else if($comissionmonths == "12"){
            $komisidates = "Desember";
        }
        
        if($comissionmonth == "January"){
            $komisidate  = "Januari";
        }elseif($comissionmonth == "February"){
            $komisidate  = "Februari";
        }elseif($comissionmonth == "March"){
            $komisidate  = "Maret";   
        }elseif($comissionmonth == "April"){
            $komisidate  = "April";  
        }elseif($comissionmonth == "May"){
            $komisidate  = "Mei";    
        }elseif($comissionmonth == "Juny"){
            $komisidate  = "Juni";    
        }elseif($comissionmonth == "July"){
            $komisidate  = "July"; 
        }elseif($comissionmonth == "August"){
            $komisidate  = "Agustus"; 
        }elseif($comissionmonth == "September"){
            $komisidate  = "September";   
        }elseif($comissionmonth == "October"){
            $komisidate  = "Oktober";
        }elseif($comissionmonth == "November"){
            $komisidate  = "November"; 
        }elseif($comissionmonth == "December"){
            $komisidate  = "Desember";    
        }
       @endphp
    <div id="border">
        <div id="all-section">
            <div id="section-image">
                <img src="{{ public_path('logo/duasisi.png')}}" width="100%" alt="">
            </div>
            <div id="section-title">
                <div id="title">
                    <h5 id="left-title">PT. DUASISI SEJAHTERA</h5>
                    <h5 id="right-title">Slip Gaji</h5>
                    <hr class="new5">
                </div>
                <div id="section-address">
                    <div id="bottom-left-title">
                        <span >
                            Jl. Lapangan Bola No. 9C, Kebon Jeruk, Jakarta Barat 11520<br>
                            Telp. 021-53666356
                          </span>
                    </div>
                    <div id="bottom-right-title">
                        <span id="bottomrighttitle" >{{$komisidates." ".date('Y',strtotime($payslip->salary_month))}}</span>
                    </div>    
                </div>
            </div>
            <div id="card-members">
                <div id="card-left-member">
                    <table width="100%"  id="card-member-1">
                        <tr>
                            <td>Nama</td><td>:</td><td>{{$employee->name}}</td>
                        </tr>
                        <tr>
                          <td>NIK</td><td>:</td><td>{{$employee->id_card}}</td>
                       </tr>
                    </table>
                </div>
                <div id="card-right-member">
                    <table width="100%"  id="card-member-1">
                        <tr>
                            @if(isset($desgination->name))
                            <td>Jabatan</td><td>:</td><td>{{$desgination->name}}</td>
                            @else 
                            <td>Jabatan</td><td>:</td><td>-</td>
                            @endif
                         
                        </tr>
                        <tr>
                          @if(isset($employee->tax_payer_id))
                          <td>NPWP</td><td>:</td><td>{{$employee->tax_payer_id}}</td>
                          @else 
                          <td>NPWP</td><td>:</td><td>-</td>
                          @endif
                      </tr>
                    </table>
                </div> 
            </div>
            <div id="header">
                <hr id="line-1">
                <div id="pdt-left">
                    <span id="pendapatan-content" >PENDAPATAN</span>
                </div>
                <div id="pdt-right">
                    <span id="pendapatan-content" >PEMOTONGAN</span>
                </div>
                <hr id="line-2">
                <hr id="line-3">
            </div>
            <div id="content">
                <div style="width:100%">
                    <div id="content-left">
                        @php 
                            $allowance = json_decode($payslip->allowance);
                            $allowances      = \App\Allowance::where('employee_id', '=', $employee->id)->where('month',date('Y-m'))->get();
                            $total_allowance = 0;
                            foreach ($allowances as $allowancer) {
                                $total_allowance = $allowancer->amount + $total_allowance;
                            }
                            $netpayble = $employee->net_salary + $total_allowance;
                        @endphp
                        <table width="100%" class="text-small">
                           
                           
                        </table> 
                    </div>
                </div>
                <div style="width:100%">
                    
                    <div id="content-left">
                        <table width="100%" class="text-small">
                            @if($employee->salary != $employee->net_salary)
                                <tr>
                                    <td>Gaji Pokok </td><td>&nbsp;</td><td>&nbsp;</td><td style="text-align:right;">Rp</td><td style="text-align:right;">{{number_format($payslip->basic_salary)}}</td>
                                </tr>
                           @else
                                <tr>
                                    <td>Gaji Pokok </td><td>&nbsp;</td><td>&nbsp;</td><td style="text-align:right;">Rp</td><td style="text-align:right;">{{number_format($payslip->basic_salary)}}</td>
                                </tr>
                            @endif
                            @if($employee->salary != $employee->net_salary)
                                 @if($employee->calculate_work != null || $employee->amount_work != null)
                                <tr>
                                    <td>&nbsp;</td><td style="text-align:center;font-size:9px;">Kehadiran</td><td style="text-align:center;font-size:9px;">Hari Kerja (1 Bulan)</td><td>&nbsp;</td>
                                </tr>
                                <tr>
                                    <td>Prorate <b>{{$komisidates}}</b></td><td style="text-align:center;font-size:11px;">{{$employee->calculate_work}}</td>:<td style="text-align:center;font-size:11px;">{{$employee->amount_work}} </td><td style="text-align:right;">Rp</td><td style="text-align:right;">{{number_format($employee->net_salary,0,',',',')}}</td>
                                </tr>
                                @endif
                            @endif
                          
                            @foreach($allowance as $key => $row1)
                                @php 
                                    $allowance = \App\AllowanceOption::where('id','=',$row1->allowance_option)->first();
                                @endphp 
                               @if($employee->salary != $employee->net_salary)
                                    <tr>
                                        @if($allowance->name == "Komisi")
                                            @if($row1->amount !=0)
                                            <td>@if(isset($allowance->name)){{$allowance->name}} <b>({{$komisidate}})<b>  @else {{"-"}} @endif</td><td>&nbsp;</td><td>&nbsp;</td><td style="text-align:right;width:50px;">Rp</td><td style="text-align:right;width:100px;">{{number_format($row1->amount,0,',',',')}}</td>
                                            @endif 
                                           
                                          
                                        @else
                                            @if($row1->amount !=0)
                                            <td>@if(isset($allowance->name)){{$allowance->name}} @else {{"-"}} @endif</td><td>&nbsp;</td><td>&nbsp;</td><td style="text-align:right;width:50px;">Rp</td><td style="text-align:right;width:100px;">{{number_format($row1->amount,0,',',',')}}</td> 
                                            @endif
                                        @endif
                                    </tr>
                                @else
                                    <tr>
                                        @if($allowance->name == "Komisi")
                                             @if($row1->amount !=0)
                                            <td>@if(isset($allowance->name)){{$allowance->name}}<b>({{$komisidate}})<b>  @else {{"-"}} @endif</td><td>&nbsp;</td><td>&nbsp;</td><td style="text-align:right;width:50px;">Rp</td><td style="text-align:right;width:100px;">{{number_format($row1->amount,0,',',',')}}</td>
                                            @endif
                                        @else
                                            @if($row1->amount !=0)
                                            <td>@if(isset($allowance->name)){{$allowance->name}} @else {{"-"}} @endif</td><td>&nbsp;</td><td>&nbsp;</td><td style="text-align:right;width:50px;">Rp</td><td style="text-align:right;width:100px;">{{number_format($row1->amount,0,',',',')}}</td> 
                                            @endif
                                        @endif
                                    </tr>
                                @endif
                            @endforeach
                        </table>
                    </div>
                    <div id="content-right">
                        @php 
                            $deduction = json_decode($payslip->saturation_deduction);
                            $saturation_deductions      = App\SaturationDeduction::where('employee_id', '=', $employee->id)->where('month',date('Y-m'))->get();
                            $total_saturation_deduction = 0;
                            foreach ($saturation_deductions as $saturation_deduction) {
                                $total_saturation_deduction = $saturation_deduction->amount + $total_saturation_deduction;
                            }       
                        @endphp
                        <table width="100%" class="text-small">
                            @if($employee->salary != $employee->net_salary)
                                <tr>
                                    <td>&nbsp;</td>
                                </tr>
                                <tr>
                                    <td>&nbsp;</td>
                                </tr>
                                @foreach($deduction as $key => $row2)
                                    @php 
                                        $saturdeduction = \App\DeductionOption::where('id','=',$row2->deduction_option)->first();
                                    @endphp                            
                                    <tr>
                                        @if($row2->amount !=0)
                                            <td>@if(isset($saturdeduction->name)){{$saturdeduction->name}} @else {{"-"}} @endif</td><td style="text-align:right;">Rp</td><td style="text-align:right;">{{number_format($row2->amount,0,',',',')}}</td>
                                        @endif  
                                    </tr>
                                @endforeach
                            @else
                                @foreach($deduction as $key => $row2)
                                    @php 
                                        $saturdeduction = \App\DeductionOption::where('id','=',$row2->deduction_option)->first();
                                    @endphp                            
                                    <tr>
                                        @if($row2->amount !=0)
                                            <td>@if(isset($saturdeduction->name)){{$saturdeduction->name}} @else {{"-"}} @endif</td><td style="text-align:right;">Rp</td><td style="text-align:right;">{{number_format($row2->amount,0,',',',')}}</td>
                                        @endif
                                    </tr>
                                @endforeach
                            @endif
                        </table>
                    </div>
                </div>
                <div style="width:100%">
                    <div id="content-left">
                        <table width="100%" class="text-small">
                            <tr >
                                <td height="20px">&nbsp;</td>
                            </tr>
                            @if($employee->salary != $employee->net_salary)
                                <tr>
                                    
                                    <td style="font-weight: bold;">A. Total Pendapatan</td><td style="text-align:right;font-weight: bold;width:100px;">Rp</td><td style="font-weight: bold;text-align:right;width:100px;">{{number_format($netpayble, 0, ',', ',')}}</td>
                                </tr>
                            @else
                                <tr>
                                    <td style="font-weight: bold;">A. Total Pendapatan</td><td>&nbsp;</td><td style="text-align:right;font-weight:bold;width:108px;">Rp</td><td style="font-weight: bold;text-align:right;">{{number_format($netpayble, 0, ',', ',')}}</td>
                                </tr>
                            @endif
                        </table>
                    </div>
                    <div id="content-right">
                        <table width="100%" class="text-small">
                            <tr >
                                <td height="20px">&nbsp;</td>
                            </tr>
                            <tr >
                                <td style="font-weight: bold;">B. Total Pemotongan </td><td style="font-weight: bold;text-align:right">Rp</td><td style="font-weight: bold;text-align:right">{{number_format($total_saturation_deduction,0,',',',')}}</td>
                            </tr>
                        </table>
                    </div>
                </div>
                <div id="footer">
                    <div class="text-small" style="text-align: center;"><b>A-B</b></div>
                </div>
                <div  id="clear-slip">
                    @php 
                        $netsalary = 0;
                        $netsalary = $netpayble - $total_saturation_deduction;
                    @endphp
                    <table width="100%" class="text-small">
                        @if($employee->salary != $employee->net_salary)
                        <tr>
                            <td style="font-weight: bold;font-size:13px;">GAJI BERSIH </td><td>&nbsp;</td><td style="font-weight: bold;text-align:right;font-size:13px;">Rp</td><td style="font-weight: bold;text-align:right;font-size:13px;border:1px solid;width:100px;">{{number_format($payslip->net_payble,0,',',',')}}</td>
                        </tr>
                        @else 
                        <tr>
                            <td style="font-weight: bold;font-size:13px;">GAJI BERSIH </td><td style="font-weight: bold;text-align:right;font-size:13px;width:200px;">Rp</td><td style="font-weight: bold;text-align:right;font-size:13px;border:1px solid;">{{number_format($payslip->net_payble,0,',',',')}}</td>
                        </tr>
                        @endif
                    </table>
                </div>
            <div id="keterangan">
                @if($employee->salary != $employee->net_salary)
                    <span style="font-weight: bold; border-style: solid border-width: 2px;" class="text-small">Keterangan :</span><br>
                    <span class="text-small" style="white-space: pre-line">- Cut Off dari tanggal 26 ke 25 (1 Bulan)</span><br>
                    <span class="text-small" style="white-space: pre-line">- Gaji Prorate = Kehadiran : Hari Kerja (1 Bulan) x Gaji Pokok</span>
                @else 
                    <span style="font-weight: bold; border-style: solid border-width: 2px;" class="text-small">Keterangan :</span><br>
                    <span class="text-small" style="white-space: pre-line">- Cut Off dari tanggal 26 ke 25 (1 Bulan)</span>
                @endif
            </div>
            <div id="signature">
                <span class="text-small" >
                    @if($payslip->status == 1)
                    Jakarta, {{"28 "}} {{$komisidates." ".date('Y',strtotime($payslip->salary_month))}}<br>
                    @else 
                    Jakarta, <br>
                    @endif
                    HR / Finance Manager
                    </span>
                    <div style="margin-top:5px;">
                    <img src="{{ public_path('storage/logo/signature.png')}}" width="30%" alt="">
                    </div>
                    <span class="text-small" style="margin-left:120px;">
                    Akbar Syaputra
                    </span>
            </div>
        </div>
    </div>
