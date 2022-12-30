<div class="modal-header">
    <h5 class="modal-title" id="exampleModalLabel">Add Working Exprerience</h5>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
    </button>
</div>
<div class="modal-body">
    <form action="{{route('emp.account.education.working.store',Auth::guard('emp')->user()->id)}}" method="POST" class="form" id="form-working" enctype="multipart/form-data">
        {{ csrf_field() }}
        <div class="row">
            <div class="col-lg-12">
                <div class="form-group">
                    <label for="company">Company</label>
                    <input type="text" class="form-control" name="company">
                </div>
                <div class="form-group">
                    <label for="position">Job Postition</label>
                    <input type="text" class="form-control" name="position">
                </div>
                <div class="form-group">
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label for="">From</label>
                                <input type="text" name="froms" class="form-control monthpicker" placeholder="From">
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label for="">To</label>
                                <input type="text" name="tos" class="form-control monthpicker" placeholder="To">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>	
</div>
<div class="modal-footer">
    <button type="submit" form="form-working" class="btn btn-success btn-elevate btn-icon-sm">
        <i class="la la-save"></i>
        Save 
    </button>
</div>