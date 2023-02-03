<table>
    <thead>
        <tr>
            <td style="width:150px; background-color:yellow; border: solid black"><b>Transaction ID</b></td>
            <td style="width:150px; background-color:yellow; border: solid black"><b>Timeoff ID</b></td>
            <td style="width:150px; background-color:yellow; border: solid black"><b>Type</b></td>
            <td style="width:150px; background-color:yellow; border: solid black"><b>Description</b></td>
            <td style="width:150px; background-color:yellow; border: solid black"><b>Employee ID</b></td>
            <td style="width:150px; background-color:yellow; border: solid black"><b>Input Balance</b></td>
            <td style="width:150px; background-color:yellow; border: solid black"><b>Start Date</b></td>
            <td style="width:150px; background-color:yellow; border: solid black"><b>End Date</b></td>
        </tr>
    </thead>
    <tbody>
        @foreach ($timeoffemployee as $item)
        <tr>
            <td>{{$item->transaction_id}}</td>
            <td>{{$item->timeoff_id}}</td>
            <td>{{$item->type}}</td>
            <td>{{$item->description}}</td>
            <td>{{$item->employee_id}}</td>
            <td>{{$item->input_balance}}</td>
            <td>{{date("Y-m-d",strtotime($item->start_date))}}</td>
            <td>{{date("Y-m-d",strtotime($item->end_date))}}</td>
        </tr>
        @endforeach
    </tbody>
</table>