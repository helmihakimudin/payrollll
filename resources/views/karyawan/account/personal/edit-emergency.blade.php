<div class="modal-header">
    <h5 class="modal-title" id="exampleModalLabel">Edit Family Information</h5>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
    </button>
</div>
<div class="modal-body">
    <form action="{{route('emp.account.personal.emergency.update',$emergency->id)}}" method="POST" class="form" id="form-personal-emergency" enctype="multipart/form-data">
        {{ csrf_field() }}
        @method('PUT')
        <div class="row">
            <div class="col-lg-12">
                <div class="form-group">
                    <label>Name</label>
                    <input type="text" class="form-control" name="name" value="{{$emergency->name}}">
                </div>
                <div class="form-group">
                    <label>Relationship</label>
                    <input type="text" class="form-control" name="relationship" value="{{$emergency->relationship}}">
                </div>
                <div class="form-group">
                    <label>Phone Number</label>
                    <input type="text" class="form-control" name="phone_number" value="{{$emergency->phone_number}}">
                </div>
            </div>
        </div>
    </form>	
</div>
<div class="modal-footer">
    <button type="submit" form="form-personal-emergency" class="btn btn-success btn-elevate btn-icon-sm">
        <i class="la la-save"></i>
        update 
    </button>
</div>