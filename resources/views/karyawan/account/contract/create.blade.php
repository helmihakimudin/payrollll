<div class="modal-header">
    <h5 class="modal-title" id="exampleModalLabel">Add Contract</h5>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
    </button>
</div>
<div class="modal-body">
    <form action="{{route('emp.contract.store',Auth::guard('emp')->user()->id)}}" method="POST" class="form" id="form-documents" enctype="multipart/form-data">
        {{ csrf_field() }}
        <div class="row">
            <div class="col-lg-12">
                <div class="form-group">
                    <label for="">Start Date</label>
                    <input type="text" class="form-control datepicker-modal" name="start_date" readonly>
                </div>
                <div class="form-group">
                    <label for="">End Date</label>
                    <input type="text" class="form-control datepicker-modal" name="end_date" readonly>
                </div>
                <div class="form-group">
                    <label for="">Contract</label>
                    <input type="file" name="contract" accept="image/gif,image/jpeg, image/png, application/pdf">
                </div>
            </div>
        </div>
    </form>	
</div>
<div class="modal-footer">
    <button type="submit" form="form-documents" class="btn btn-success btn-elevate btn-icon-sm">
        <i class="la la-save"></i>
        Create 
    </button>
</div>