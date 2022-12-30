<div class="modal-header">
    <h5 class="modal-title" id="exampleModalLabel">Edit Files</h5>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
    </button>
</div>
<div class="modal-body">
    <form action="{{route('emp.myfile.update',$documents->id)}}" method="POST" class="form" id="form-documents" enctype="multipart/form-data">
        {{ csrf_field() }}
        @method('PUT')
        <div class="row">
            <div class="col-lg-12">
                <div class="form-group">
                    <label for="education">Name</label>
                    <input type="text" class="form-control" name="name" value="{{$documents->name}}">
                </div>
                <div class="form-group">
                    <label for="">Documents</label>
                    <input type="file" name="documents" accept="image/gif,image/jpeg, image/png, application/pdf">
                </div>
            </div>
        </div>
    </form>	
</div>
<div class="modal-footer">
    <button type="submit" form="form-documents" class="btn btn-success btn-elevate btn-icon-sm">
        <i class="la la-save"></i>
        Save 
    </button>
</div>