<table>
    <thead>
    <tr>
        <th align="left">Emp ID</th>
        <th align="left">Full Name</th>
        <th align="left">User Id</th>
        <th align="right">Component id</th>
        <th align="left">Component</th>
        <th align="left">Type</th>
        <th align="right">Current Amount</th>
        <th align="right">Amount</th>
    </tr>
    </thead>
    <tbody>
    @foreach ($empcomponent as $row)
        @if(isset($row->component))
            @php
            $component = json_decode($row->component)
            @endphp
            @foreach($component as $rows)
            <tr>
                <td align="left"> {{ $row->emp_id }}</td>
                <td align="left"> {{ $row->full_name }}</td>
                <td align="left"> {{ $row->employee_id }}</td>
                <td align="right">{{ $rows->component_id }}</td>
                <td align="left"> {{ $rows->component }}</td>
                <td align="left"> {{ $rows->type }}</td>
                <td align="right">{{ $rows->amount }}</td>
                <td align="right">{{ $rows->amount }}</td>
            </tr>
            @endforeach
        @endif
        @endforeach
    </tbody>
</table>
