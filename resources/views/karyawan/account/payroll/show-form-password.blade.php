<div class="modal-header">
    <h5 class="modal-title" id="exampleModalLabel" style="font-size:12px;">Enter Your Password to continue !</h5>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
    </button>
</div>
<div class="modal-body">
    <form action="{{route("emp.payroll.payslip.show.password.store",$payslip->id)}}" id="form-password" method="POST">
        @csrf
        <div class="form-group">
            <label>Password</label>
            <input type="password" name="password" class="form-control" autocomplete="off">
        </div>
    </form>
</div>
<div class="modal-footer">
    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
    <button type="submit" form="form-password" class="btn btn-primary">Submit</button>
</div>