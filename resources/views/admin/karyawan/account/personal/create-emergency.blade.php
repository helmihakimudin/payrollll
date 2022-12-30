<div class="modal-header">
    <h5 class="modal-title" id="exampleModalLabel">Create Emergency Information</h5>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
    </button>
</div>
<div class="modal-body">
    <form action="{{route('employee.account.personal.emergency.store',$karyawan->id)}}" method="POST" class="form" id="form-personal-emergency" enctype="multipart/form-data">
        {{ csrf_field() }}
        <div class="row">
            <div class="col-lg-12">
                <div class="form-group">
                    <label>Name</label>
                    <input type="text" class="form-control" name="name">
                </div>
                <div class="form-group">
                    <label>Relationship</label>
                    <input type="text" class="form-control" name="relationship">
                </div>
                <div class="form-group">
                    <label for="">Phone number</label>
                    <input type="number" name="phone_number" class="form-control"  placeholder="Phone number">
                </div>
            </div>
        </div>
    </form>	
</div>
<div class="modal-footer">
    <button type="submit" form="form-personal-emergency" class="btn btn-success btn-elevate btn-icon-sm">
        <i class="la la-save"></i>
        Create 
    </button>
</div>