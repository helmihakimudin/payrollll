<div class="modal-header">
    <h5 class="modal-title" id="exampleModalLabel">Request Edit Personal</h5>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
    </button>
</div>
<div class="modal-body">
    <div class="row">
        <div class="col-lg-4">
            <span class="font-weight-bold"> Personal Data </span><br>
            <span style="font-size:11px;">Your email address is your identity on Talenta is used to log in.</span>
        </div>
        <div class="col-lg-6">
            <form id="form-personal" method="POST">
                @csrf
                @method('PUT')
                <ul class="list-unstyled mb-0">
                    <li>
                        <div class="row py-2">
                                <div class="col-sm-4 d-flex align-items-center">
                                    <span class="font-weight-bold"> First Name </span>
                                </div>
                            <div class="col-sm-8"><p><input type="text" class="form-control" name="req_first_name" value="{{$karyawan->req_first_name}}" readonly></p></div>
                        </div>
                    </li>
                    <li>
                        <div class="row py-2">
                                <div class="col-sm-4 d-flex align-items-center">
                                    <span class="font-weight-bold"> Last Name </span>
                                </div>
                            <div class="col-sm-8"><p><input type="text" class="form-control" name="req_last_name" value="{{$karyawan->req_last_name}}" readonly></p></div>
                        </div>
                    </li>
                    <li>
                        <div class="row py-2">
                            <div class="col-sm-4 d-flex align-items-center">
                                <span class="font-weight-bold"> Mobile phone </span>
                            </div>
                            <div class="col-sm-8"><p><input type="text" class="form-control" name="req_mobile_phone" value="{{$karyawan->req_mobile_phone}}" readonly></p></div>
                        </div>
                    </li>
                    <li>
                        <div class="row py-2">
                            <div class="col-sm-4 d-flex align-items-center">
                                <span class="font-weight-bold"> Mobile phone </span>
                            </div>
                            <div class="col-sm-8"><p><input type="text" class="form-control" name="req_phone" value="{{$karyawan->req_phone}}" readonly></p></div>
                        </div>
                    </li>
                    <li>
                        <div class="row py-2">
                            <div class="col-sm-4 d-flex align-items-center">
                                <span class="font-weight-bold"> Email </span>
                            </div>
                            <div class="col-sm-8"><p><input type="text" class="form-control" name="req_email" value="{{$karyawan->req_email}}" readonly></p></div>
                        </div>
                    </li>
                    <li>
                        <div class="row py-2">
                            <div class="col-sm-4 d-flex align-items-center">
                                <span class="font-weight-bold">Place Of Birth</span>
                            </div>
                            <div class="col-sm-8"><p><input type="text" class="form-control" name="req_place_of_birth" value="{{$karyawan->req_place_of_birth}}" readonly></p></div>
                        </div>
                    </li>
                    <li>
                        <div class="row py-2">
                            <div class="col-sm-4 d-flex align-items-center">
                                <span class="font-weight-bold">Date of Birth</span>
                            </div>
                            <div class="col-sm-8"><p><input type="text" class="form-control datepicker-modal" name="req_date_of_birth" value="{{date("m/d/Y",strtotime($karyawan->req_date_of_birth))}}" readonly></p></div>
                        </div>
                    </li>
                    <li>
                        <div class="row py-2">
                            <div class="col-sm-4 d-flex align-items-center">
                                <span class="font-weight-bold">Blood Type</span>
                            </div>
                            <div class="col-sm-8"><p><input type="text" class="form-control " name="req_blood_type" value="{{$karyawan->req_blood_type}}" readonly></p></div>
                        </div>
                    </li>
                    <li>
                        <div class="row py-2">
                            <div class="col-sm-4 d-flex align-items-center">
                                <span class="font-weight-bold">Merriage status</span>
                            </div>
                            <div class="col-sm-8">
                                <p>
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
                                </p>
                            </div>
                        </div>
                    </li>
                    <li>
                        <div class="row py-2">
                            <div class="col-sm-4 d-flex align-items-center">
                                <span class="font-weight-bold">Religion</span>
                            </div>
                            <div class="col-sm-8">
                                <p>
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
                                </p>
                            </div>
                        </div>
                    </li>
                </ul>
            </form>
        </div>
    </div>
</div>
<div class="modal-footer">
    <button type="submit"   class="btn btn-danger btn-sm btn-rounded-fill">Reject</button>
    <button type="submit"   form="form-personal" formaction="{{route("employee.account.personal.request.update",$karyawan->id)}}" class="btn btn-primary btn-sm btn-rounded-fill">Accept</button>
</div>
