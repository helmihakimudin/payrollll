<div class="modal-header">
    <h5 class="modal-title" id="exampleModalLabel">Warning !</h5>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
    </button>
</div>
<div class="modal-body">
    <p class="text">Are you sure delete Allowance <b>{{$component->name}}</b> ?  </p>
</div>
<div class="modal-footer">
    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
    <a href="{{route('payroll.setting.component.delete',$component->id)}}"class="btn btn-primary">Delete</a>
</div>