<div class="modal-header">
    <h5 class="modal-title" id="exampleModalLabel">Add Formal Education</h5>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
    </button>
</div>
<div class="modal-body">
    <form action="{{route('emp.account.education.store',Auth::guard('emp')->user()->id)}}" method="POST" class="form" id="form-education-formal" enctype="multipart/form-data">
        {{ csrf_field() }}
        <div class="row">
            <div class="col-lg-12">
                <div class="form-group">
                    <label >Grade :</label>
                    <select class="form-control select-custom"  style="width:100%;" id="grade" name="grade" required>
                        <option value="">Select Grade</option>
                        @foreach(DB::table('master_grade')->get() as $row)
                        <option value="{{$row->name}}">{{$row->name}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label >Institusion :</label>
                    <input type="text" class="form-control" name="institute_name">
                </div>
                <div class="form-group">
                    <label>Majors :</label>
                    <input type="text" class="form-control" name="major">
                </div>
                <div class="form-group">
                    <label>score :</label>
                    <input type="text" class="form-control" name="score">
                </div>
                <div class="form-group">
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label for="">Start year</label>
                                <input type="text" name="start_year" class="form-control datepicker-modal" placeholder="Start year">
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label for="">End year</label>
                                <input type="text" name="end_year" class="form-control datepicker-modal" placeholder="End year">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>	
</div>
<div class="modal-footer">
    <button type="submit" form="form-education-formal" class="btn btn-success btn-elevate btn-icon-sm">
        <i class="la la-save"></i>
        Save 
    </button>
</div>