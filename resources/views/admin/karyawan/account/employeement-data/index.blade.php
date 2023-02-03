@extends('admin.karyawan.account.base',[
	'pages'=>'general',
	'subpages'=>'employement'
])
@section('content-account')
<div class="kt-portlet">
    <div class="kt-portlet__head">
        <div class="kt-portlet__head-label">
            <h3 class="kt-portlet__head-title">
                Employment
            </h3>
        </div>
        <div class="kt-portlet__head-toolbar">
             <button type="button" class="btn px-4 btn-sm btn-outline-dark rounded" data-toggle="modal" data-target="#kt_modal_1"><i class="la la-edit"></i>Edit</button>
        </div>
    </div>
    <div class="kt-portlet__body">
        <div class="row">
            <div class="col-lg-4">
                <span class="font-weight-bold"> Employment data </span><br>
                <span style="font-size:11px;">Your data information related to company..</span>
            </div>
            <div class="col-lg-8">
                <ul class="list-unstyled mb-0">
                    <li>
                        <div class="row py-2">
                                <div class="col-sm-4 d-flex align-items-center">
                                    <span class="font-weight-bold"> Employee ID </span>
                                </div>
                            <div class="col-sm-8"><p class="m-0">{{$karyawan->employee_id}}</p></div>
                        </div>
                    </li>
                    <li>
                        <div class="row py-2">
                                <div class="col-sm-4 d-flex align-items-center">
                                    <span class="font-weight-bold"> Barcode</span>
                                </div>
                                <div class="col-sm-8"><p class="m-0">{{$karyawan->barcode}}</p></div>
                        </div>
                    </li>
                    <li>
                        <div class="row py-2">
                                <div class="col-sm-4 d-flex align-items-center">
                                    <span class="font-weight-bold"> Job position </span>
                                </div>
                                
                            <div class="col-sm-8">
                                <p class="m-0">
                                    @if(isset($karyawan->jobPosition->name))
                                        {{$karyawan->jobPosition->name}}
                                    @else
                                        -
                                    @endif
                                </p>
                            </div>
                        </div>
                    </li>
                    <li>
                        <div class="row py-2">
                                <div class="col-sm-4 d-flex align-items-center">
                                    <span class="font-weight-bold"> Organization </span>
                                </div>
                            <div class="col-sm-8"><p class="m-0">{{$karyawan->organization->name}}</p></div>
                        </div>
                    </li>
                    <li>
                        <div class="row py-2">
                                <div class="col-sm-4 d-flex align-items-center">
                                    <span class="font-weight-bold"> Job level </span>
                                </div>
                            <div class="col-sm-8"><p class="m-0">{{$karyawan->jobLevel->name}}</p></div>
                        </div>
                    </li>
                    <li>
                        <div class="row py-2">
                                <div class="col-sm-4 d-flex align-items-center">
                                    <span class="font-weight-bold">Employeement Status</span>
                                </div>
                            <div class="col-sm-8"><p class="m-0">{{$karyawan->employeement_status}}</p></div>
                        </div>
                    </li>
                    <li>
                        <div class="row py-2">
                                <div class="col-sm-4 d-flex align-items-center">
                                    <span class="font-weight-bold">Branch Location</span>
                                </div>
                            <div class="col-sm-8"><p class="m-0">{{$karyawan->branch->name}}</p></div>
                        </div>
                    </li>
                    <li>
                        <div class="row py-2">
                                <div class="col-sm-4 d-flex align-items-center">
                                    <span class="font-weight-bold">Department</span>
                                </div>
                            <div class="col-sm-8">
                                <p class="m-0">
                                    @if(isset($karyawan->department->name))
                                        {{$karyawan->department->name}}
                                    @else
                                        -
                                    @endif
                                </p>
                            </div>
                        </div>
                    </li>
                    <li>
                        <div class="row py-2">
                                <div class="col-sm-4 d-flex align-items-center">
                                    <span class="font-weight-bold"> Join Date</span>
                                </div>
                            <div class="col-sm-8"><p class="m-0">{{date('d M Y',strtotime($karyawan->join_date))}}</p></div>
                        </div>
                    </li>
                    <li>
                        <div class="row py-2">
                                <div class="col-sm-4 d-flex align-items-center">
                                    <span class="font-weight-bold"> End date</span>
                                </div>
                            <div class="col-sm-8"><p class="m-0">{{date("d F Y",strtotime($karyawan->end_date))}}</p></div>
                        </div>
                    </li>
                    <li>
                        <div class="row py-2">
                                <div class="col-sm-4 d-flex align-items-center">
                                    <span class="font-weight-bold">Approval line</span>
                                </div>
                            <div class="col-sm-8"><p class="m-0">{{@$karyawan->employeeApprovalLine->employee_id}} - {{@$karyawan->employeeApprovalLine->full_name}}</p></div>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
        <div class="kt-separator kt-separator--border-dashed kt-separator--space-lg"></div>
        <div class="row">
            <div class="col-lg-6 pt-3">
                <div class="kt-widget4">
                    @foreach($relatebranch as $row)
                    @php 
                        $name = $row->full_name;
                        $parts = explode(" ", $name);
                        if(count($parts) > 1) {
                            $lastname = array_pop($parts);
                            $firstname = implode(" ", $parts);
                        }
                        else
                        {
                            $firstname = $name;
                            $lastname = " ";
                        }
                        $initals = substr($firstname,0,1)."".substr($lastname,0,1);
                    @endphp 
                    <div class="kt-widget4__item" style="border-bottom: 1px dashed blue;">
                        @if($row->avatar != null)
                        <div class="kt-widget4__pic kt-widget4__pic--pic">
                            <img src="{{ asset("demo10/assets/media/users/100_4.jpg")}}" alt="">
                        </div>
                        @else 
                        <div class="kt-widget4__pic kt-widget4__pic--pic">
                            <div class="kt-widget__pic kt-widget__pic--success kt-font-success kt-font-boldest kt-font-light kt-hidden-">
                                {{$initals}}
                            </div>
                        </div>
                        @endif
                        <div class="kt-widget4__info">
                            <a href="#" class="kt-widget4__username">
                              {{$row->full_name}}
                            </a>
                            <p class="kt-widget4__text">
                               {{$row->branch}} - {{$row->jobposition}}
                            </p>
                        </div>
                        <a href="#" Title="Email">
                            <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="54px" height="54px" viewBox="0 0 24 24" version="1.1" class="kt-svg-icon">
                                <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                    <rect x="0" y="0" width="54" height="54"/>
                                    <path d="M5,9 L19,9 C20.1045695,9 21,9.8954305 21,11 L21,20 C21,21.1045695 20.1045695,22 19,22 L5,22 C3.8954305,22 3,21.1045695 3,20 L3,11 C3,9.8954305 3.8954305,9 5,9 Z M18.1444251,10.8396467 L12,14.1481833 L5.85557487,10.8396467 C5.4908718,10.6432681 5.03602525,10.7797221 4.83964668,11.1444251 C4.6432681,11.5091282 4.77972206,11.9639747 5.14442513,12.1603533 L11.6444251,15.6603533 C11.8664074,15.7798822 12.1335926,15.7798822 12.3555749,15.6603533 L18.8555749,12.1603533 C19.2202779,11.9639747 19.3567319,11.5091282 19.1603533,11.1444251 C18.9639747,10.7797221 18.5091282,10.6432681 18.1444251,10.8396467 Z" fill="#000000"/>
                                    <path d="M11.1288761,0.733697713 L11.1288761,2.69017121 L9.12120481,2.69017121 C8.84506244,2.69017121 8.62120481,2.91402884 8.62120481,3.19017121 L8.62120481,4.21346991 C8.62120481,4.48961229 8.84506244,4.71346991 9.12120481,4.71346991 L11.1288761,4.71346991 L11.1288761,6.66994341 C11.1288761,6.94608579 11.3527337,7.16994341 11.6288761,7.16994341 C11.7471877,7.16994341 11.8616664,7.12798964 11.951961,7.05154023 L15.4576222,4.08341738 C15.6683723,3.90498251 15.6945689,3.58948575 15.5161341,3.37873564 C15.4982803,3.35764848 15.4787093,3.33807751 15.4576222,3.32022374 L11.951961,0.352100892 C11.7412109,0.173666017 11.4257142,0.199862688 11.2472793,0.410612793 C11.1708299,0.500907473 11.1288761,0.615386087 11.1288761,0.733697713 Z" fill="#000000" fill-rule="nonzero" opacity="0.3" transform="translate(11.959697, 3.661508) rotate(-90.000000) translate(-11.959697, -3.661508) "/>
                                </g>
                            </svg>
                        </a>
                        &nbsp;
                        <a href="" title="Phone">
                            <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1" class="kt-svg-icon">
                                <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                    <rect x="0" y="0" width="24" height="24"/>
                                    <path d="M11.914857,14.1427403 L14.1188827,11.9387145 C14.7276032,11.329994 14.8785122,10.4000511 14.4935235,9.63007378 L14.3686433,9.38031323 C13.9836546,8.61033591 14.1345636,7.680393 14.7432841,7.07167248 L17.4760882,4.33886839 C17.6713503,4.14360624 17.9879328,4.14360624 18.183195,4.33886839 C18.2211956,4.37686904 18.2528214,4.42074752 18.2768552,4.46881498 L19.3808309,6.67676638 C20.2253855,8.3658756 19.8943345,10.4059034 18.5589765,11.7412615 L12.560151,17.740087 C11.1066115,19.1936265 8.95659008,19.7011777 7.00646221,19.0511351 L4.5919826,18.2463085 C4.33001094,18.1589846 4.18843095,17.8758246 4.27575484,17.613853 C4.30030124,17.5402138 4.34165566,17.4733009 4.39654309,17.4184135 L7.04781491,14.7671417 C7.65653544,14.1584211 8.58647835,14.0075122 9.35645567,14.3925008 L9.60621621,14.5173811 C10.3761935,14.9023698 11.3061364,14.7514608 11.914857,14.1427403 Z" fill="#000000"/>
                                </g>
                            </svg>
                        </a>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
    <!--end::Form-->
</div>

<!-- Modal Edit -->
<div class="modal fade" id="kt_modal_1" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Edit Employment</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                </button>
            </div>
            <form class="kt-form" action="{{route('employee.account.employeement-data.update', $karyawan->id)}}" method="post">
                @csrf
              <div class="modal-body">
                <div class="form-group">
                    <div class="row">
                        <div class="col-lg-6 col-xl-6">
                            <label><span style="color:red">*</span>Employee ID</label>
                            <div class="input-group">
                                <div class="input-group-prepend"><span class="input-group-text"><i class="flaticon2-user"></i></span></div>
                                <input class="form-control" type="text" name="employee_id"  placeholder="Employee ID" value="{{$karyawan->employee_id}}" required>
                            </div>
                        </div>
                        <div class="col-lg-6 col-xl-6">
                            <label><span style="color:red">*</span>Barcode</label>
                            <div class="input-group">
                                <div class="input-group-prepend"><span class="input-group-text"><i class="fa fa-barcode"></i></span></div>
                                <input class="form-control" type="text" name="barcode"  placeholder="Barcode" value="{{$karyawan->barcode}}" required>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="row">
                        <div class="col-lg-6 col-xl-6">
                            <label><span style="color:red">*</span>Employement Status</label>
                            <select name="employeement_status" id="employee_status" class="form-control select2_add_employee" required>
                                <option value="">Select</option>
                                <option value="Contract" @if($karyawan->employeement_status == "Contract") selected @endif>Contract</option>
                                <option value="Permanent" @if($karyawan->employeement_status == "Permanent") selected @endif>Permanent</option>
                            </select>
                        </div>
                        <div class="col-lg-6 col-xl-6">
                            <label><span style="color:red">*</span>Organization</label>
                            <select name="organization_id" id="organization_id" class="form-control select2_add_employee" required>
                                <option value="" selected>Select</option>
                                @foreach(DB::table('organization')->get() as $row)
                                <option value="{{$row->id}}" @if($row->id==$karyawan->organization_id) selected @endif>{{$row->name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="row select">
                        <div class="col-lg-6 col-xl-6">
                            <label><span style="color:red">*</span>Branch</label>
                            <select name="branch_id" id="branch_id" class="form-control select2_add_employee" required style="width:100%">
                                <option value="test" selected>Select</option>
                                @foreach(DB::table('branches')->get() as $row)
                                <option value="{{$row->id}}" @if($row->id==$karyawan->branch_id) selected @endif>{{$row->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-lg-6 col-xl-6">
                            <label><span style="color:red">*</span>Department</label>
                            <select name="department_id" id="department_id" class="form-control select2_add_employee" required style="width:100%">
                                <option value="" selected>Select</option>
                                @foreach(DB::table('departments')->get() as $row)
                                <option value="{{$row->id}}" class="{{$row->branch_id}}" @if($row->id==$karyawan->department_id) selected @endif>{{$row->name}}</option>
                                @endforeach
                            </select>
                            <div id="department-options" class="hidden">
                                @foreach(DB::table('departments')->get() as $row)
                                <option value="{{$row->id}}" class="{{$row->branch_id}}">{{$row->name}}</option>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="row">
                        <div class="col-lg-6 col-xl-6">
                            <label><span style="color:red">*</span>Join Date </label>
                            <div class="input-group">
                                <div class="input-group-prepend"><span class="input-group-text"><i class="flaticon2-calendar-9"></i></span></div>
                                <input class="form-control datepicker" type="text" name="join_date"  placeholder="Join Date" value="{{\Carbon\Carbon::parse($karyawan->join_date)->format('d/m/Y')}}" required>
                            </div>
                        </div>
                        <div class="col-lg-6 col-xl-6">
                            <label><span style="color:red">*</span>End Date </label>
                            <div class="input-group">
                                <div class="input-group-prepend"><span class="input-group-text"><i class="flaticon2-calendar-9"></i></span></div>
                                <input class="form-control datepicker" type="text" name="end_date"  placeholder="End Date" value="{{\Carbon\Carbon::parse($karyawan->end_date)->format('d/m/Y')}}" required>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="row">
                        <div class="col-lg-6 col-xl-6">
                            <label><span style="color:red">*</span>Job Position</label>
                            <select name="job_position_id" id="job_position_id" class="form-control select2_add_employee" required>
                                <option value="" selected>Select</option>
                                @foreach(DB::table('job_position')->get() as $row)
                                <option value="{{$row->id}}" name="{{$row->name}}" @if($row->id==$karyawan->job_position_id) selected @endif>{{$row->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-lg-6 col-xl-6">
                            <label><span style="color:red">*</span>Job Level</label>
                            <select name="job_level_id" id="job_level_id" class="form-control select2_add_employee" required>
                                <option value="" selected>Select</option>
                                @foreach(DB::table('job_level')->get() as $row)
                                <option value="{{$row->id}}" name="{{$row->name}}" @if($row->id==$karyawan->job_level_id) selected @endif>{{$row->name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="row">
                        <div class="col-lg-6 col-xl-6">
                            <label><span style="color:red">*</span>Approval Line</label>
                            <br/>
                            <select name="approval_line_id" id="approval_line_id" class="form-control select2_add_employee" required>
                                <option value="" selected>Select</option>
                                @foreach(DB::table('employees')->get() as $row)
                                <option value="{{$row->id}}" name="{{$row->full_name}}" @if($row->id==$karyawan->approval_line_id) selected @endif>{{$row->full_name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
              </div>
              <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                  <button type="submit" class="btn btn-primary">Submit</button>
              </div>
            </form>
        </div>
    </div>
</div>
@endsection