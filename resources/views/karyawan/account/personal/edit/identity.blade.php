@section('content-account')
<div class="kt-portlet">
    <div class="kt-portlet__body">
        <div class="row">
            <div class="col-lg-4">
                <span class="font-weight-bold"> Identity & Address </span><br>
                <span style="font-size:11px;">&nbsp;</span>
            </div>
            <div class="col-lg-6">
                <form action="{{route("emp.account.personal.identity.request.update",$karyawan->id)}}" id="form-personal-identity" method="POST">
                    <input type="hidden" name="residential_address_hidden" value="{{$karyawan->residential_address}}">
                    @csrf
                    @method('PUT')
                    <ul class="list-unstyled mb-0">
                        <li>
                            <div class="row py-2">
                                <div class="col-sm-4 d-flex align-items-center">
                                    <span class="font-weight-bold"> ID Type </span>
                                </div>
                                <div class="col-sm-8">
                                <select name="identity_type" id="identity_type" class="form-control select2_add_employee" required>
                                    <option value="">Select</option>
                                    <option value="SIM" @if($karyawan->identity_type=="SIM") selected @endif>SIM</option>
                                    <option value="KTP" @if($karyawan->identity_type=="KTP") selected @endif>KTP</option>
                                    <option value="passport" @if($karyawan->identity_type=="passport") selected @endif>Passport</option>
                                </select>
                                </div>
                            </div>
                        </li>
                        <li>
                            <div class="row py-2">
                                    <div class="col-sm-4 d-flex align-items-center">
                                        <span class="font-weight-bold">ID Number</span>
                                    </div>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control" name="identity_number" value="{{$karyawan->identity_number}}">
                                </div>
                            </div>
                        </li>
                        <li>
                            <div class="row py-2">
                                <div class="col-sm-4 d-flex align-items-center">
                                    <span class="font-weight-bold">Postal Code </span>
                                </div>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control" name="postal_code" value="{{$karyawan->postal_code}}">
                                </div>
                            </div>
                        </li>
                        <li>
                            <div class="row py-2">
                                <div class="col-sm-4 d-flex align-items-center">
                                    <span class="font-weight-bold"> Citizen ID address </span>
                                </div>
                                <div class="col-sm-8">
                                    <textarea name="citizien_id_address" id="citizien_id_address" cols="30" rows="3" class="form-control" placeholder="Please Enter Address ID Card" required>{{$karyawan->citizien_id_address}}</textarea>
                                </div>
                            </div>
                            <div class="kt-checkbox-inline pt-3">
                                <label class="kt-checkbox">
                                    <input type="checkbox" name="checkbox_residential_address" id="copas-address"> use as residential address
                                    <span></span>
                                </label>
                            </div>
                        </li>
                        <li>
                            <div class="row py-2">
                                <div class="col-sm-4 d-flex align-items-center">
                                    <span class="font-weight-bold">Residential address</span>
                                </div>
                                <div class="col-sm-8">
                                    <textarea name="residential_address" id="residential_address" cols="30" rows="3" class="form-control" placeholder="Please Enter Residence address" required>{{$karyawan->residential_address}}</textarea>
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
                <a href="javascript::" class="btn btn-outline-danger mx-3 btn-sm btn-rounded-fill btn-cancel-identity">Cancel</a>
                <button type="submit" form="form-personal-identity"  class="btn btn-primary btn-sm btn-rounded-fill">Request</button>
            </div>
        </div>
    </div>
</div>
