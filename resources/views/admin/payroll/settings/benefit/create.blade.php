<div class="modal-header">
    <h5 class="modal-title" id="exampleModalLabel" style="font-size:12px;">Add Benefit</h5>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
    </button>
</div>
<div class="modal-body">
    <form action="{{route('payroll.setting.component.store')}}" method="POST" class="form" id="form-deductions-option" enctype="multipart/form-data">
        {{ csrf_field() }}
        <div class="form-group">
            <label>Benefit</label>
            <input type="text" class="form-control" name="name"  placeholder="Enter Benefit">
            <input type="hidden" class="form-control" name="type" value="Benefit">
        </div>
    </form>
</div>
<div class="modal-footer">
    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
    <button type="submit"  form="form-deductions-option" class="btn btn-primary">Submit</button>
</div>