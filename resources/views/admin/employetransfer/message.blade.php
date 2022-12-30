<div class="modal-header">
    <h5 class="modal-title" id="exampleModalLabel">Message  !</h5>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
    </button>
</div>
<div class="modal-body">
    <div class="kt-notes">
        <div class="kt-notes__items">
            @foreach($employeetransfer as $row)
            <div class="kt-notes__item kt-notes__item--clean">
                <div class="kt-notes__media">
                    <img class="kt-hidden" src="assets/media/users/100_1.jpg" alt="image">
                    <span class="kt-notes__icon kt-font-boldest kt-hidden">
                        <i class="flaticon2-cup"></i>
                    </span>
                    <h3 class="kt-notes__user kt-font-boldest kt-hidden">
                        M E
                    </h3>
                    <span class="kt-notes__circle kt-hidden-"></span>
                </div>
                <div class="kt-notes__content">
                    <div class="kt-notes__section">
                        <div class="kt-notes__info">
                            <a href="#" class="kt-notes__title">
                                Order
                            </a>
                            <span class="kt-notes__desc">
                                {{date('d F Y h:i:s',strtotime($row->created_at))}}
                            </span>
                            <a href="{{route('employee.transfer.accept',$row->id)}}" class="kt-badge kt-badge--success kt-badge--inline">Approved</a>
                            &nbsp;
                            <a href="{{route('employee.transfer.reject',$row->id)}}"  class="kt-badge kt-badge--danger kt-badge--inline">Reject</a>
                        </div>
                    </div>
                    <span class="kt-notes__body">
                            <b>{{$row->full_name}}</b> <br>
                            from :<br>
                            Organization Current  <b>{{$row->organization_current}}</b><br>
                            Branch  Current <b>{{$row->currenct_branch_name}}</b><br>
                            Job Position Current  <b>{{$row->job_position_current}}</b><br>
                            Job Level Current  <b>{{$row->job_level_current}}</b><br>                   
                            Move To :<br>
                            Organization <b>{{$row->organization}}</b><br>
                            Branch<b> {{$row->branch_name}}</b> <br>
                            Job Position <b>{{$row->job_position}}</b><br>
                            Job Level <b>{{$row->job_level}}</b><br>
                    </span>
                </div>
            </div>
            <div class="kt-separator kt-separator--border-dashed kt-separator--space-lg"></div>
            @endforeach
        </div>
    </div>
</div>
<div class="modal-footer">
    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
    {{-- <a href="{{route('employee.transfer.delete',$employeetransfer->id)}}"class="btn btn-primary">Delete</a> --}}
</div>