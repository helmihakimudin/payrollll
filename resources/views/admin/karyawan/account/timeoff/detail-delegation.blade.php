<table class="table table-striped- table-bordered table-hover m-0">
    <thead>
        <tr>
            <th>Approval</th>
            <th>Employee ID</th>
            <th>PIC</th>
            <th>Status</th>
            <th>Comment</th>
            {{-- <th>Decision By</th> --}}
            <th>Updated Date</th>
        </tr>
    </thead>
    <tbody>
        @forelse ($status as $key => $item)
        <tr>
            <td>{{$key+1}}</td>
            <td>{{$item->employee_id}}</td>
            <td>{{$item->full_name}}</td>
            @if ($item->status == 'APPROVED')
            <td><span class="kt-badge kt-badge--success kt-badge--dot"></span>&nbsp;<span class="kt-font-bold kt-font-success">{{$item->status}}</span></td>
            @elseif($item->status == 'REQUEST' || $item->status == 'PENDING')
            <td><span class="kt-badge kt-badge--warning kt-badge--dot"></span>&nbsp;<span class="kt-font-bold kt-font-warning">{{$item->status}}</span></td>
            @else
            <td><span class="kt-badge kt-badge--danger kt-badge--dot"></span>&nbsp;<span class="kt-font-bold kt-font-danger">{{$item->status}}</span></td>
            @endif
            <td>{{$item->notes}}</td>
            {{-- <td>-</td> --}}
            <td>{{$item->updated_at}}</td>
        </tr>
        @empty
        <tr>
            <td colspan="7"><div class="text-center">No Data</div></td>
        </tr>
        @endforelse     
    </tbody>
</table>