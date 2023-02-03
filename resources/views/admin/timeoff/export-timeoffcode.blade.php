<table>
    <thead>
        <tr>
            <td style="width:150px; background-color:yellow; border: solid black"><b>ID Timeoff</b></td>
            <td style="width:150px; background-color:yellow; border: solid black"><b>Timeoff Code</b></td>
            <td style="width:150px; background-color:yellow; border: solid black"><b>Timeoff Name</b></td>
            <td style="width:150px; background-color:yellow; border: solid black"><b>Description</b></td>
            <td style="width:150px; background-color:yellow; border: solid black"><b>Effective Date</b></td>
            <td style="width:150px; background-color:yellow; border: solid black"><b>Expired Date</b></td>
        </tr>
    </thead>
    <tbody>
        @foreach ($timeoff as $item)
        <tr>
            <td>{{$item->id}}</td>
            <td>{{$item->code}}</td>
            <td>{{$item->name}}</td>
            <td>{{$item->description}}</td>
            <td>{{$item->effective_date}}</td>
            <td>{{$item->expired_date}}</td>
        </tr>
        @endforeach
    </tbody>
</table>