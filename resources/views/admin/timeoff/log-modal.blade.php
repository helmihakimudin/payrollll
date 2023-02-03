<table class="table table-striped- table-bordered m-0 kt_table_1" >
    <thead>
        <tr>
            <th>Transaction time</th>
            <th>Action</th>
            <th>Adjustment balance (days)</th>
            <th>Detail</th>
        </tr>
    </thead>
    <tbody>
        
        @foreach ($logs as $item)
        @php
            $timeoff = App\Timeoff::where('id', $item->timeoff_id)->first();
            $emp = App\Employee::where('id', $item->employee_id)->first();
        @endphp
        <tr>
            <td>{{date('d M Y', strtotime($item->created_at))}}</td>
            <td>{{$item->action}}</td>
            @if ($item->type == 'time_off_taken' || $item->type == 'expired')
            <td class="text-danger text-center font-weight-bold">{{$item->value}}</td>
            @else
            <td class="text-success text-center font-weight-bold">+{{$item->value}}</td>
            @endif
            <td><div tabindex="0" data-html="true" data-toggle="popover" data-trigger="focus" class="text-danger hover text-center font-weight-bold" title="<strong>{{$item->action}}</strong>" data-content="{{$item->value}} days {{$timeoff->name}} {{$emp->full_name}} is {{$item->action}} by sistem <br><hr>expired date : {{$item->end_date}}">View Detail</div></td>
        </tr>
        @endforeach
    </tbody>
</table>

<script>
    $("[data-toggle=popover]").popover();
    $('.popover-dismiss').popover({
        trigger: 'focus'
    });
</script>

