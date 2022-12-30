<table>
    <thead>
    <tr>
        <th>Acc #</th>
        <th>Amount</th>
        <th>Employee Name</th>
    </tr>
    </thead>
    <tbody>
        @foreach($payslip as $key => $row)
        <tr>        
            <td>{{ intval($row->account_number)}}</td>
            <td>{{"Rp.".number_format($row->net_payble,0,',','.')}}</td>
            <td>{{$row->name}}</td>
        </tr>
        @endforeach
    </tbody>
</table>