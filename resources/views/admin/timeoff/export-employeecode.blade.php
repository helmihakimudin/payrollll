<table>
    <thead>
        <tr>
            <td style="width:150px; background-color:yellow; border: solid black"><b>ID</b></td>
            <td style="width:150px; background-color:yellow; border: solid black"><b>Employee Name</b></td>
            <td style="width:150px; background-color:yellow; border: solid black"><b>NIK</b></td>

        </tr>
    </thead>
    <tbody>
        @foreach ($employee as $item)
        <tr>
            <td>{{$item->id}}</td>
            <td>{{$item->full_name}}</td>
            <td>{{$item->employee_id}}</td>

        </tr>
        @endforeach
    </tbody>
</table>