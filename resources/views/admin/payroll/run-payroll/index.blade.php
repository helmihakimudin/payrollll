<div class="modal-header">
    <h5 class="modal-title" id="exampleModalLabel">Run Payroll </h5>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
    </button>
</div>
<div class="modal-body">
    <form action="{{route('payroll.continue.run')}}" id="form-show-run">
        <div class="row">
            <div class="col-lg-12">
                <div class="form-group">
                    <label for="">Select Transaksi</label>
                    <div class="input-group">
                        <div class="input-group-prepend"><span class="input-group-text"><i class="fa fa-calendar"></i></span></div>
                        <input class="form-control monthpicker" type="text" name="transaksi_id"  placeholder="" required>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
<div class="modal-footer">
    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
    <button type="submit" form="form-show-run" class="btn btn-primary">Continue</button>
</div>