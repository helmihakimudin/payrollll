<div class="modal-header">
    <h5 class="modal-title" id="exampleModalLabel">Employee Transfer</h5>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
    </button>
</div>
<div class="modal-body">
    <form action="{{route('employee.transfer.store',$karyawan->id)}}" method="POST" class="form" id="form-transfer" enctype="multipart/form-data">
        {{ csrf_field() }}
        <div class="row">
            <div class="col-lg-12">
                <div class="form-group">
                    <label for=""> employee*</label>
                    <select name="employee_id" id="employee_id" class="form-control select2">
                        @foreach($employee as $row)
                        <option value="{{$row->id}}">{{$row->full_name}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label for=""> Effective Date*</label>
                    <input type="text" name="effective_date" class="form-control datepicker" readonly>
                </div>
                <div class="form-group">
                    <label for=""> Employee status *</label>
                    <input type="text" name="employeement_status" class="form-control">
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-6">
                <div class="form-group">
                    <label for="">Branch</label>
                    <select name="branch_id" id="branch_id" class="form-control select2">
                        @foreach($branch as $row)
                        <option value="{{$row->id}}">{{$row->name}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label for="">Job Position</label>
                    <select name="job_position_id" id="job_position_id" class="form-control select2">
                        @foreach($jobposition as $row)
                        <option value="{{$row->id}}">{{$row->name}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="form-group">
                    <label for="">Organization</label>
                    <select name="organization_id" id="organization_id" class="form-control select2">
                        @foreach($organization as $row)
                        <option value="{{$row->id}}">{{$row->name}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label for="">Job Level</label>
                    <select name="job_level_id" id="job_level_id" class="form-control select2">
                        @foreach($joblevel as $row)
                        <option value="{{$row->id}}">{{$row->name}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>
        <div class="form-group">
            <label for="">Transfer Reason</label>
            <textarea name="transfer_reason" id="transfer_reason" class="form-control" cols="30" rows="3"></textarea>
        </div>
    </form>	
</div>
<div class="modal-footer">
    <button type="submit" form="form-transfer" class="btn btn-success btn-elevate btn-icon-sm">
        <i class="la la-save"></i>
        Transfer 
    </button>
</div>



