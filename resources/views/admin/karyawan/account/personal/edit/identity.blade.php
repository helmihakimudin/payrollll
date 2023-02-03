<div class="modal-header">
    <h5 class="modal-title" id="exampleModalLabel">Request Edit Personal Identity</h5>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
    </button>
</div>
<div class="modal-body">
    <div class="row">
        <div class="col-lg-12 mb-4">
            <span class="font-weight-bold"> Personal Data </span><br>
            <span style="font-size:11px;">Your email address is your identity on eSmart is used to log in.</span>
        </div>
        <div class="col-lg-12">
            <form id="form-personal" method="POST">
                @csrf
                @method('PUT')
                 <div class="form-group row">
                    <div class="col-lg-6">
                        <label>ID Type </label>
                        <input type="text" class="form-control" name="req_identity_type" value="{{$karyawan->req_identity_type}}" readonly>
                    </div>
                    <div class="col-lg-6">
                        <label>ID Number</label>
                        <input type="text" class="form-control" name="req_identity_number" value="{{$karyawan->req_identity_number}}" readonly>
                    </div>
                </div>
                 <div class="form-group row">
                    <div class="col-lg-6">
                        <label>Postal Code</label>
                        <input type="text" class="form-control" name="req_postal_code" value="{{$karyawan->req_postal_code}}" readonly>
                    </div>
                    <div class="col-lg-6">
                        <label>Citizen ID address</label>
                        <input type="text" class="form-control" name="req_citizien_id_address" value="{{$karyawan->req_citizien_id_address}}" readonly>
                    </div>
                </div>
                 <div class="form-group row">
                    <div class="col-lg-6">
                        <label>Residential address</label>
                        <input type="text" class="form-control" name="req_residential_address" value="{{$karyawan->req_residential_address}}" readonly>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<div class="modal-footer">
     <button type="button" data-dismiss="modal" id="reject-request" class="btn btn-sm btn-outline-danger btn-rounded-fill">Reject</button>
    <button type="submit" form="form-personal" formaction="{{route("employee.account.identity.request.update",$karyawan->id)}}" class="btn btn-primary btn-sm btn-rounded-fill">Accept</button>
</div>
