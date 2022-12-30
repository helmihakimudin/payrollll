<div class="modal-header">
    <h5 class="modal-title" id="exampleModalLabel">Add Informal Education</h5>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
    </button>
</div>
<div class="modal-body">
    <form action="{{route('emp.account.education.informal.store',Auth::guard('emp')->user()->id)}}" method="POST" class="form" id="form-education-informal" enctype="multipart/form-data">
        {{ csrf_field() }}
        <div class="row">
            <div class="col-lg-12">
                <div class="form-group">
                    <label for="education">Education Name</label>
                    <input type="text" class="form-control" name="name">
                </div>
                <div class="form-group">
                    <label for="Held B">Held By</label>
                    <input type="text" class="form-control" name="held_by">
                </div>
                <div class="form-group">
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label for="">Start date</label>
                                <input type="text" name="start_date" class="form-control datepicker-modal" placeholder="Start Date">
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label for="">End date</label>
                                <input type="text" name="end_date" class="form-control datepicker-modal" placeholder="End Date">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label for="duration type">Duration Type</label>
                                <select name="duration" id="duration" name="duration" class="select-custom" style="width:100%">
                                    <option value="Days">Days</option>
                                    <option value="Hours">Hours</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label for="">Duration</label>
                                <input type="text" name="dayshour" class="form-control" value="1">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label for="">Expired Date</label>
                    <input type="text" name="expired_date" class="form-control datepicker-modal">
                </div>
                <div class="form-group">
                    <label for="">Fee</label>
                    <input type="text" name="fee" class="form-control nominal">
                </div>
                <div class="form-group">
                    <label for="">Certificate</label>
                    <input type="file" name="certificate" accept="image/gif,image/jpeg, image/png, application/pdf">
                </div>
            </div>
        </div>
    </form>	
</div>
<div class="modal-footer">
    <button type="submit" form="form-education-informal" class="btn btn-success btn-elevate btn-icon-sm">
        <i class="la la-save"></i>
        Save 
    </button>
</div>