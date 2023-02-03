<div class="modal-header">
    <h5 class="modal-title" id="exampleModalLabel">Request Edit Personal</h5>
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
                        <label>First Name</label>
                        <input type="text" class="form-control" name="req_first_name" value="{{$karyawan->req_first_name}}" readonly>
                    </div>
                    <div class="col-lg-6">
                        <label>Last Name</label>
                        <input type="text" class="form-control" name="req_last_name" value="{{$karyawan->req_last_name}}" readonly>
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-lg-6">
                        <label>Phone Number (Home)</label>
                        <input type="text" class="form-control" name="req_mobile_phone" value="{{$karyawan->req_mobile_phone}}" readonly>
                    </div>
                    <div class="col-lg-6">
                        <label>Mobile phone</label>
                        <input type="text" class="form-control" name="req_phone" value="{{$karyawan->req_phone}}" readonly>
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-lg-6">
                        <label>Email</label>
                        <input type="text" class="form-control" name="req_email" value="{{$karyawan->req_email}}" readonly>
                    </div>
                    <div class="col-lg-6">
                        <label>Place Of Birth</label>
                        <input type="text" class="form-control" name="req_place_of_birth" value="{{$karyawan->req_place_of_birth}}" readonly>
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-lg-6">
                        <label>Date of Birth</label>
                        <input type="text" class="form-control datepicker-modal" name="req_date_of_birth" value="{{date("m/d/Y",strtotime($karyawan->req_date_of_birth))}}" readonly>
                    </div>
                    <div class="col-lg-6">
                        <label>Blood Type</label>
                        <input type="text" class="form-control " name="req_blood_type" value="{{$karyawan->req_blood_type}}" readonly>
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-lg-6">
                        <label>Merriage status</label>
                        <select name="req_marital_status" id="marital_status" class="form-control select-custom" required readonly>
                            @if($karyawan->req_marital_status == 'Married')
                                <option value="Married" selected>Married</option>
                                <option value="Not married yet">Not Married Yet</option>
                            @elseif($karyawan->req_marital_status == 'Not married yet')
                                <option value="Not married yet" selected >Not Married Yet</option>
                                <option value="Married">Married</option>
                            @else
                                <option value="" selected>Select</option>
                                <option value="Married">Married</option>
                                <option value="Not married yet">Not Married Yet</option>
                            @endif
                        </select>
                    </div>
                    <div class="col-lg-6">
                      <label>Religion</label>
                      <select name="req_religion" id="religion" class="form-control select-custom" required readonly>
                          @if($karyawan->req_religion == 'Islam')
                              <option value="Islam" selected>Islam</option>
                              <option value="Buddha" >Buddha</option>
                              <option value="Confucius">Confucius</option>
                              <option value="Catholic">Catholic</option>
                              <option value="Christian">Christian</option>
                              <option value="Hindu">Hindu</option>
                          @elseif($karyawan->req_religion == 'Catholic')
                              <option value="Catholic" selected>Catholic</option>
                              <option value="Buddha" >Buddha</option>
                              <option value="Confucius">Confucius</option>
                              <option value="Islam">Islam</option>
                              <option value="Christian">Christian</option>
                              <option value="Hindu">Hindu</option>
                          @elseif($karyawan->req_religion == 'Christian')
                              <option value="Christian" selected>Christian</option>
                              <option value="Buddha" >Buddha</option>
                              <option value="Confucius">Confucius</option>
                              <option value="Islam">Islam</option>
                              <option value="Catholic">Catholic</option>
                              <option value="Hindu">Hindu</option>
                          @elseif($karyawan->req_religion == 'Buddha')
                              <option value="Buddha" selected>Buddha</option>
                              <option value="Confucius">Confucius</option>
                              <option value="Islam">Islam</option>
                              <option value="Catholic">Catholic</option>
                              <option value="Christian">Christian</option>
                              <option value="Hindu">Hindu</option>
                          @elseif($karyawan->req_religion == 'Confucius')
                              <option value="Confucius" selected>Confucius</option>
                              <option value="Islam">Islam</option>
                              <option value="Catholic">Catholic</option>
                              <option value="Christian">Christian</option>
                              <option value="Buddha">Buddha</option>
                              <option value="Hindu">Hindu</option>
                          @elseif($karyawan->req_religion == 'Hindu')
                          @else
                              <option value="" selected>Select</option>
                              <option value="Islam">Islam</option>
                              <option value="Catholic">Catholic</option>
                              <option value="Christian">Christian</option>
                              <option value="Buddha">Buddha</option>
                              <option value="Confucius">Confucius</option>
                              <option value="Hindu">Hindu</option>
                          @endif
                      </select>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<div class="modal-footer">
    <button type="button" data-dismiss="modal" id="reject-request" class="btn btn-outline-danger btn-rounded-fill">Reject</button>
    <button type="submit" form="form-personal" formaction="{{route("employee.account.personal.request.update",$karyawan->id)}}" class="btn btn-primary btn-rounded-fill">Accept</button>
</div>
