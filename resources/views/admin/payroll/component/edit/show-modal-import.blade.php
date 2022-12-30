<div class="modal-header">
    <h5 class="modal-title" id="exampleModalLabel">Import Component !</h5>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
    </button>
</div>
<div class="modal-body">
    <form action="{{route('payroll.component.edit.import',$id)}}" method="POST" id="form-import" enctype="multipart/form-data">
        @csrf
        <div class="row">
            <div class="form-group">
                <input type="file" name="import" class="form-control">
            </div>
        </div>
    </form>
</div>
<div class="modal-footer">
    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
    <button type="submit" form="form-import" class="btn btn-primary">Import</button>
</div>