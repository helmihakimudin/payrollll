<div class="modal-header">
    <h5 class="modal-title" id="exampleModalLabel" style="font-size:12px;">Add Allowance</h5>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
    </button>
</div>
<div class="modal-body">
    <form action="{{route('payroll.setting.allowance.store')}}" method="POST" class="form" id="form-allowance-option" enctype="multipart/form-data">
        {{ csrf_field() }}
        <div class="form-group">
            <label>Allowance</label>
            <input type="text" class="form-control" name="name"  placeholder="Enter Allowance">
        </div>
    </form>
</div>
<div class="modal-footer">
    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
    <button type="submit"  form="form-allowance-option" class="btn btn-primary">Submit</button>
</div>