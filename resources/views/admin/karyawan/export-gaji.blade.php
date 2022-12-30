<table>
    <thead>
    <tr>
        <td rowspan="2" align="center" style="width:50px; background-color:yellow; border: solid black"><b>No.</b></td>
        <td rowspan="2" align="center" style="width:150px; background-color:yellow; border: solid black"><b>Employee ID</b></td>
        <td rowspan="2" align="center" style="width:300px; background-color:yellow; border: solid black"><b>Nama</b></td>
        <td rowspan="2" align="center" style="width:100px; background-color:yellow; border: solid black"><b>Jenis Kelamin<br>(L/P)</b></td>
        <td rowspan="2" align="center" style="width:150px; background-color:yellow; border: solid black"><b>Status Pernikahan</b></td>
        <td rowspan="2" align="center" style="width:150px; background-color:yellow; border: solid black"><b>Divisi - Jabatan</b></td>
        <td rowspan="2" align="center" style="width:100px; background-color:yellow; border: solid black"><b>Join Date</b></td>
        <td rowspan="2" align="center" style="width:100px; background-color:yellow; border: solid black"><b>Status Kontrak</b></td>
        <td rowspan="2" align="center" style="width:150px; background-color:yellow; border: solid black"><b>Jumlah kehadiran<br>(s.d Tgl 25)</b></td>
        <td rowspan="2" align="center" style="width:150px;background-color:yellow; border: solid black"><b>Jumlah Hari Kerja<br>(dalam sebulan)</b>
        </td>
        <td colspan="11" align="center" style="width:100px;background-color:yellow; border: solid black"><b>PENDAPATAN</b></td>
        <td colspan="7" align="center" style="width:100px;background-color:yellow; border: solid black"><b>POTONGAN</b></td>
        <td rowspan="2" align="center" style="width:250px; background-color:yellow; border: solid black"><b>Total Gaji <br>yang dibayarkan ke karyawan(nett)</b></td>
    </tr>
    <tr>
        <td align="center" style="width:100px;background-color:yellow; border: solid black"><b>Gaji Pokok</b></td>
        <td align="center" style="width:100px;background-color:yellow; border: solid black"><b>Gaji Prorate</b></td>
        <td align="center" style="width:150px;background-color:yellow; border: solid black"><b>Tunjangan Operasional</b></td>
        <td align="center" style="width:150px;background-color:yellow; border: solid black"><b>Tunjangan Jabatan</b></td>
        <td align="center" style="width:150px;background-color:yellow; border: solid black"><b>Tunjangan Kerajinan</b></td>
        <td align="center" style="width:150px;background-color:yellow; border: solid black"><b>Tunjangan Kehadiran</b></td>
        <td align="center" style="width:100px;background-color:yellow; border: solid black"><b>Uang Makan</b></td>
        <td align="center" style="width:100px;background-color:yellow; border: solid black"><b>Komisi/Reward</b></td>
        <td align="center" style="width:100px;background-color:yellow; border: solid black"><b>Yamcha</b></td>
        <td align="center" style="width:100px;background-color:yellow; border: solid black"><b>Lembur</b></td>
        <td align="center" style="width:100px;background-color:yellow; border: solid black"><b>Rapel/lainnya</b></td>
        <td align="center" style="width:100px;background-color:yellow; border: solid black"><b>Denda Telat</b></td>
        <td align="center" style="width:150px;background-color:yellow; border: solid black"><b>Potongan Izin/Alpha</b></td>
        <td align="center" style="width:150px;background-color:yellow; border: solid black"><b>Mistake</b></td>
        <td align="center" style="width:150px;background-color:yellow; border: solid black"><b>Donasi</b></td>
        <td align="center" style="width:150px;background-color:yellow; border: solid black"><b>Kasbon</b></td>
        <td align="center" style="width:150px;background-color:yellow; border: solid black"><b>WP</b></td>
        <td align="center" style="width:100px;background-color:yellow; border: solid black"><b>Lainnya</b></td>
    </tr>
    </thead>
    <tbody>
        @foreach($karyawan as $employee)
        @php
            $components = json_decode($employee->component,true);
        @endphp
        <tr>
            <td>{{($loop->iteration) }}</td>
            <td>{{$employee->employee_id}}</td>
            <td>{{$employee->full_name}}</td>
            <td>{{$employee->gender}}</td>
            <td>{{$employee->marital_status}}</td>
            <td>{{$employee->jobposition_name}}</td>
            <td>{{$employee->join_date}}</td>
            <td>{{$employee->employeement_status}}</td>
            <td>{{$employee->total_attendance}}</td>
            <td>{{$employee->total_working_permonth}}</td>
            <td>{{@$components[0]['amount']}}</td>
            <td>{{@$components[1]['amount']}}</td>
            <td>{{@$components[2]['amount']}}</td>
            <td>{{@$components[3]['amount']}}</td>
            <td>{{@$components[4]['amount']}}</td>
            <td>{{@$components[5]['amount']}}</td>
            <td>{{@$components[6]['amount']}}</td>
            <td>{{@$components[7]['amount']}}</td>
            <td>{{@$components[8]['amount']}}</td>
            <td>{{@$components[9]['amount']}}</td>
            <td>{{@$components[10]['amount']}}</td>
            <td>{{@$components[11]['amount']}}</td>
            <td>{{@$components[12]['amount']}}</td>
            <td>{{@$components[13]['amount']}}</td>
            <td>{{@$components[14]['amount']}}</td>
            <td>{{@$components[15]['amount']}}</td>
            <td>{{@$components[16]['amount']}}</td>
            <td>{{@$components[17]['amount']}}</td>
        </tr>
        @endforeach
    </tbody>
</table>
