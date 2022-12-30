
<div class="modal-header">
    <h5 class="modal-title" id="exampleModalLabel" style="font-size:12px;">Edit Allowance</h5>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
    </button>
</div>
<div class="modal-body">
    <form action="{{route('payroll.setting.allowance.update',$allowanceoption->id)}}" method="POST" class="form" id="form-allowance-option" enctype="multipart/form-data">
        {{ csrf_field() }}
        @method('PUT')
        <div class="form-group">
            <label>Allowance</label>
            <input type="text" class="form-control" name="name" value="{{$allowanceoption->name}}"  placeholder="Enter Allowance Option">
        </div>
    </form>
</div>
<div class="modal-footer">
    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
    <button type="submit"  form="form-allowance-option" class="btn btn-primary">Update</button>
</div>