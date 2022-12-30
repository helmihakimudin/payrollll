<div class="modal-header">
    <h5 class="modal-title" id="exampleModalLabel">Create Family Information</h5>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
    </button>
</div>
<div class="modal-body">
    <form action="{{route('employee.account.personal.family.store',$karyawan->id)}}" method="POST" class="form" id="form-personal-family" enctype="multipart/form-data">
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
                    <label for="">Birthdate</label>
                    <input type="text" name="birthdate" class="form-control datepicker-modal"  placeholder="Birthday" readonly>
                </div>
                <div class="form-group">
                    <label><span style="color:red">*</span> Select Marital Status</label>
                    <select name="marital_status" id="marital_status" class="form-control select-custom" required>
                        <option value="" selected>Select</option>
                        <option value="Married">Married</option>
                        <option value="Not married yet">Not Married Yet</option>
                    </select>
                </div>
                <div class="form-group">
                    <label><span style="color:red">*</span> Select Marital Status</label>
                    <select name="gender" id="gender" class="form-control select-custom" required>
                        <option value="" selected>Select</option>
                        <option value="Male" selected>Male</option>
                        <option value="Female">Female</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="">Job</label>
                    <input type="text" name="job"  class="form-control">
                </div>
                <div class="form-group">
                    <label><span style="color:red">*</span>Religion</label>
                    <select name="religion" id="religion" class="form-control select-custom" required>
                        <option value="" selected>Select</option>
                        <option value="Islam">Islam</option>
                        <option value="Catholic">Catholic</option>
                        <option value="Christian">Christian</option>
                        <option value="Buddha">Buddha</option>
                        <option value="Confucius">Confucius</option>
                        <option value="Hindu">Hindu</option>
                    </select>
                </div>
            </div>
        </div>
    </form>	
</div>
<div class="modal-footer">
    <button type="submit" form="form-personal-family" class="btn btn-success btn-elevate btn-icon-sm">
        <i class="la la-save"></i>
        Create 
    </button>
</div>