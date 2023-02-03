<div class="kt-portlet">
    <div class="kt-portlet__body">
        <div class="row">
            <div class="col-lg-4">
                <span class="font-weight-bold"> Personal Data </span><br>
                <span style="font-size:11px;">Your email address is your identity on Talenta is used to log in.</span>
            </div>
            <div class="col-lg-6">
                 <form action="{{route("emp.account.personal.request.update",$karyawan->id)}}" id="form-personal" method="POST">
                    @csrf
                    @method('PUT')
                    <ul class="list-unstyled mb-0">
                        <li>
                            <div class="row py-2">
                                    <div class="col-sm-4 d-flex align-items-center">
                                        <span class="font-weight-bold"> First Name </span>
                                    </div>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control" name="first_name" value="{{$karyawan->first_name}}">
                                </div>
                            </div>
                        </li>
                        <li>
                            <div class="row py-2">
                                <div class="col-sm-4 d-flex align-items-center">
                                    <span class="font-weight-bold"> Last Name </span>
                                </div>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control" name="last_name" value="{{$karyawan->last_name}}">
                                </div>
                            </div>
                        </li>
                        <li>
                            <div class="row py-2">
                                <div class="col-sm-4 d-flex align-items-center">
                                    <span class="font-weight-bold"> Mobile phone </span>
                                </div>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control" name="mobile_phone" value="{{$karyawan->mobile_phone}}">
                                </div>
                            </div>
                        </li>
                        <li>
                            <div class="row py-2">
                                <div class="col-sm-4 d-flex align-items-center">
                                    <span class="font-weight-bold"> Phone number (Home) </span>
                                </div>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control" name="phone" value="{{$karyawan->phone}}">
                                </div>
                            </div>
                        </li>
                        <li>
                            <div class="row py-2">
                                <div class="col-sm-4 d-flex align-items-center">
                                    <span class="font-weight-bold"> Email </span>
                                </div>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control" name="email" value="{{$karyawan->email}}">
                                </div>
                            </div>
                        </li>
                        <li>
                            <div class="row py-2">
                                <div class="col-sm-4 d-flex align-items-center">
                                    <span class="font-weight-bold">Place Of Birth</span>
                                </div>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control" name="place_of_birth" value="{{$karyawan->place_of_birth}}">
                                </div>
                            </div>
                        </li>
                        <li>
                            <div class="row py-2">
                                <div class="col-sm-4 d-flex align-items-center">
                                    <span class="font-weight-bold">Date of Birth</span>
                                </div>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control datepicker-modal" name="date_of_birth" value="{{date("m/d/Y",strtotime($karyawan->date_of_birth))}}">
                                </div>
                            </div>
                        </li>
                        <li>
                            <div class="row py-2">
                                <div class="col-sm-4 d-flex align-items-center">
                                    <span class="font-weight-bold">Blood of type</span>
                                </div>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control " name="blood_of_type" value="{{$karyawan->blood_type}}">
                                </div>
                            </div>
                        </li>
                        <li>
                            <div class="row py-2">
                                <div class="col-sm-4 d-flex align-items-center">
                                    <span class="font-weight-bold">Merriage status</span>
                                </div>
                                <div class="col-sm-8">
                                    <select name="marital_status" id="marital_status" class="form-control select-custom" required>
                                        @if($karyawan->marital_status == 'Married')
                                            <option value="Married" selected>Married</option>
                                            <option value="Not married yet">Not Married Yet</option>
                                        @elseif($karyawan->marital_status == 'Not married yet')
                                            <option value="Not married yet" selected >Not Married Yet</option>
                                            <option value="Married">Married</option>
                                        @else
                                            <option value="" selected>Select</option>
                                            <option value="Married">Married</option>
                                            <option value="Not married yet">Not Married Yet</option>
                                        @endif
                                    </select>
                                </div>
                            </div>
                        </li>
                        <li>
                            <div class="row py-2">
                                <div class="col-sm-4 d-flex align-items-center">
                                    <span class="font-weight-bold">Religion</span>
                                </div>
                                <div class="col-sm-8">
                                    <select name="religion" id="religion" class="form-control select-custom" required>
                                        @if($karyawan->religion == 'Islam')
                                            <option value="Islam" selected>Islam</option>
                                            <option value="Buddha" >Buddha</option>
                                            <option value="Confucius">Confucius</option>
                                            <option value="Catholic">Catholic</option>
                                            <option value="Christian">Christian</option>
                                            <option value="Hindu">Hindu</option>
                                        @elseif($karyawan->religion == 'Catholic')
                                            <option value="Catholic" selected>Catholic</option>
                                            <option value="Buddha" >Buddha</option>
                                            <option value="Confucius">Confucius</option>
                                            <option value="Islam">Islam</option>
                                            <option value="Christian">Christian</option>
                                            <option value="Hindu">Hindu</option>
                                        @elseif($karyawan->religion == 'Christian')
                                            <option value="Christian" selected>Christian</option>
                                            <option value="Buddha" >Buddha</option>
                                            <option value="Confucius">Confucius</option>
                                            <option value="Islam">Islam</option>
                                            <option value="Catholic">Catholic</option>
                                            <option value="Hindu">Hindu</option>
                                        @elseif($karyawan->religion == 'Buddha')
                                            <option value="Buddha" selected>Buddha</option>
                                            <option value="Confucius">Confucius</option>
                                            <option value="Islam">Islam</option>
                                            <option value="Catholic">Catholic</option>
                                            <option value="Christian">Christian</option>
                                            <option value="Hindu">Hindu</option>
                                        @elseif($karyawan->religion == 'Confucius')
                                            <option value="Confucius" selected>Confucius</option>
                                            <option value="Islam">Islam</option>
                                            <option value="Catholic">Catholic</option>
                                            <option value="Christian">Christian</option>
                                            <option value="Buddha">Buddha</option>
                                            <option value="Hindu">Hindu</option>
                                        @elseif($karyawan->religion == 'Hindu')
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
                        </li>
                    </ul>
                </form>

            </div>
        </div>
    </div>
    <div class="kt-portlet__foot">
        <div class="row">
            <div class="col-lg-2">
                &nbsp;
            </div>
            <div class="col-lg-2">
                &nbsp;
            </div>
            <div class="col-lg-2">
                &nbsp;
            </div>
            <div class="col-lg-2">
                &nbsp;
            </div>
            <div class="col-lg-2">
                <a href="javascript::" class="btn btn-outline-danger mx-3 btn-sm btn-rounded-fill btn-cancel-personal">Cancel</a>
                <button type="submit" form="form-personal"  class="btn btn-primary btn-sm btn-rounded-fill">Request</button>
            </div>
        </div>
    </div>
</div>
