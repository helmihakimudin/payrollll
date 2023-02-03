@extends('layout-admin.base',[
	'pages'=>'employee',
	'subpages'=>'create'
])
@section('content')
<div class="kt-body kt-grid__item kt-grid__item--fluid kt-grid kt-grid--hor kt-grid--stretch" id="kt_body">
    <div class="kt-content  kt-grid__item kt-grid__item--fluid kt-grid kt-grid--hor" id="kt_content">
        <!-- begin:: Content Head -->
        <div class="kt-subheader   kt-grid__item" id="kt_subheader">
            <div class="kt-container pt-3">
                <div class="kt-subheader__main">
                    <h3 class="kt-subheader__title">
                        Add Employee
                    </h3>
                    <span class="kt-subheader__separator kt-subheader__separator--v"></span>
                    <div class="kt-subheader__group" id="kt_subheader_search">
                        <span class="kt-subheader__desc" id="kt_subheader_total">
                            Enter Employee details and submit </span>
                    </div>
                </div>
                <div class="kt-subheader__toolbar">
                    <a href="{{route('employee')}}" class="btn btn-default btn-bold">Back </a>
                </div>
            </div>
        </div>
        <!-- End:: Content Head -->
        <!-- Begin:: Content -->
        <div class="kt-container  kt-grid__item kt-grid__item--fluid">
            <div class="kt-wizard-v4" id="kt_user_add_user" data-ktwizard-state="step-first">
                <!--begin: Form Wizard Nav -->
                <div class="kt-wizard-v4__nav">
                    <div class="kt-wizard-v4__nav-items nav">
                        <div class="kt-wizard-v4__nav-item nav-item" data-ktwizard-type="step" data-ktwizard-state="current">
                            <div class="kt-wizard-v4__nav-body">
                                <div class="kt-wizard-v4__nav-number">
                                    1
                                </div>
                                <div class="kt-wizard-v4__nav-label">
                                    <div class="kt-wizard-v4__nav-label-title">
                                         personal Data
                                    </div>
                                    <div class="kt-wizard-v4__nav-label-desc">
                                        Employee's Personal Information
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="kt-wizard-v4__nav-item nav-item" data-ktwizard-type="step">
                            <div class="kt-wizard-v4__nav-body">
                                <div class="kt-wizard-v4__nav-number">
                                    2
                                </div>
                                <div class="kt-wizard-v4__nav-label">
                                    <div class="kt-wizard-v4__nav-label-title">
                                        Employeement Data
                                    </div>
                                    <div class="kt-wizard-v4__nav-label-desc">
                                        Employeement Data Information
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="kt-wizard-v4__nav-item nav-item" data-ktwizard-type="step">
                            <div class="kt-wizard-v4__nav-body">
                                <div class="kt-wizard-v4__nav-number">
                                    3
                                </div>
                                <div class="kt-wizard-v4__nav-label">
                                    <div class="kt-wizard-v4__nav-label-title">
                                       Payroll
                                    </div>
                                    <div class="kt-wizard-v4__nav-label-desc">
                                        Employee Payroll Information
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="kt-wizard-v4__nav-item nav-item" data-ktwizard-type="step" onclick="reviewData()">
                            <div class="kt-wizard-v4__nav-body">
                                <div class="kt-wizard-v4__nav-number">
                                    4
                                </div>
                                <div class="kt-wizard-v4__nav-label">
                                    <div class="kt-wizard-v4__nav-label-title">
                                        Invite Employee
                                    </div>
                                    <div class="kt-wizard-v4__nav-label-desc">
                                        Do You want join this employee ?
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!--end: Form Wizard Nav -->
                <div class="kt-portlet">
                    <div class="kt-portlet__body kt-portlet__body--fit">
                        <div class="kt-grid">
                            <div class="kt-grid__item kt-grid__item--fluid kt-wizard-v4__wrapper">
                                <!--begin: Form Wizard Form-->

                                <form action="{{route("employee.store")}}" method="POST" class="kt-form" id="kt_user_add_form" >
                                    @csrf
                                    <!-- Begin::Wizard Step 1-->
                                    <div class="kt-wizard-v4__content" data-ktwizard-type="step-content" data-ktwizard-state="current">
                                        <div class="kt-heading kt-heading--md">Personal Data </div>
                                        <div class="alert alert-secondary" role="alert">
                                            <div class="alert-text">
                                               Fill all employee personal basic information data
                                            </div>
                                        </div>
                                        <div class="kt-section kt-section--first">
                                            <div class="kt-wizard-v4__form">
                                                <div class="row">
                                                    <div class="col-xl-12">
                                                        <div class="kt-section__body">
                                                            <div class="form-group">
                                                                <div class="row">
                                                                    <div class="col-lg-6 col-xl-6">
                                                                        <label><span style="color:red">*</span> Full Name</label>
                                                                        <div class="input-group">
                                                                            <div class="input-group-prepend"><span class="input-group-text"><i class="fa fa-user"></i></span></div>
                                                                            <input class="form-control" type="text" name="first_name"  placeholder="First Name" required>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-lg-6 col-xl-6">
                                                                        <label><span style="color:red"></span>&nbsp;</label>
                                                                        <div class="input-group">
                                                                            <div class="input-group-prepend"><span class="input-group-text"><i class="fa fa-user"></i></span></div>
                                                                            <input class="form-control" type="text" name="last_name"  placeholder="Last Name" required>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="form-group">
                                                                <label><span style="color:red">*</span> Email</label>
                                                                <div class="input-group">
                                                                    <div class="input-group-prepend"><span class="input-group-text"><i class="fa fa-mail-bulk"></i></span></div>
                                                                    <input class="form-control" type="email" name="email" placeholder="Email" required>
                                                                </div>
                                                            </div>
                                                            <div class="form-group">
                                                                <div class="row">
                                                                    <div class="col-lg-6 col-xl-6">
                                                                        <label><span style="color:red">*</span> Mobile Phone</label>
                                                                        <div class="input-group">
                                                                            <div class="input-group-prepend"><span class="input-group-text"><i class="fa fa-phone-alt"></i></span></div>
                                                                            <input class="form-control" type="number" name="mobile_phone" placeholder="Mobile Phone" required>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-lg-6 col-xl-6">
                                                                        <label><span style="color:red">*</span> Phone</label>
                                                                        <div class="input-group">
                                                                            <div class="input-group-prepend"><span class="input-group-text"><i class="fa fa-phone-alt"></i></span></div>
                                                                            <input class="form-control" type="number" name="phone" placeholder="Phone" required>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="form-group">
                                                                <div class="row">
                                                                    <div class="col-lg-6 col-xl-6">
                                                                        <label><span style="color:red">*</span> Place of birth</label>
                                                                        <div class="input-group">
                                                                            <div class="input-group-prepend"><span class="input-group-text"><i class="fa fa-home"></i></span></div>
                                                                            <input class="form-control" type="text" name="place_of_birth"  placeholder="Place of Birth" required>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-lg-6 col-xl-6">
                                                                        <label><span style="color:red">*</span> Birthday </label>
                                                                        <div class="input-group">
                                                                            <div class="input-group-prepend"><span class="input-group-text"><i class="fa fa-birthday-cake"></i></span></div>
                                                                            <input class="form-control datepicker" type="text" name="date_of_birth"  placeholder="Birthday" required>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="form-group">
                                                                <div class="row">
                                                                    <div class="col-lg-6 col-xl-6">
                                                                        <label><span style="color:red">*</span> Select Gender </label>
                                                                        <select name="gender" id="gender" class="form-control select2_add_employee" required>
                                                                            <option value="" selected>Select</option>
                                                                            <option value="Male">Male</option>
                                                                            <option value="Female">Female</option>
                                                                        </select>
                                                                    </div>
                                                                    <div class="col-lg-6 col-xl-6">
                                                                        <label><span style="color:red">*</span> Select Marital Status</label>
                                                                        <select name="marital_status" id="marital_status" class="form-control select2_add_employee" required>
                                                                            <option value="" selected>Select</option>
                                                                            <option value="Married">Married</option>
                                                                            <option value="Not married yet">Not Married Yet</option>
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="form-group">
                                                                <div class="row">
                                                                    <div class="col-lg-6 col-xl-6">
                                                                        <label>Blood Type </label>
                                                                        <select name="blood_type" id="blood_type" class="form-control select2_add_employee">
                                                                            <option value="" selected>Select Blood Type</option>
                                                                            <option value="A">A</option>
                                                                            <option value="B">B</option>
                                                                            <option value="AB">AB</option>
                                                                            <option value="O">O</option>
                                                                        </select>
                                                                    </div>
                                                                    <div class="col-lg-6 col-xl-6">
                                                                        <label>Religion</label>
                                                                        <select name="religion" id="religion" class="form-control select2_add_employee">
                                                                            <option value="" selected>Select</option>
                                                                            <option value="Islam">Islam</option>
                                                                            <option value="Catholic">Catholic</option>
                                                                            <option value="Christian">Christian</option>
                                                                            <option value="Buddha">Buddha</option>
                                                                            <option value="Confucius">Confucius</option>
                                                                            <option value="Hindu">Hindu</option>
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="kt-separator kt-separator--border-dashed kt-separator--space-lg"></div>
                                                            <div class="kt-heading kt-heading--md">Identity & address</div>
                                                            <div class="alert alert-secondary" role="alert">
                                                                <div class="alert-text">
                                                                   Employee Identity Address Information
                                                                </div>
                                                            </div>
                                                            <div class="form-group">
                                                                <div class="row">
                                                                    <div class="col-lg-6 col-xl-6">
                                                                        <label><span style="color:red">*</span> KTP</label>
                                                                        <div class="input-group">
                                                                            <div class="input-group-prepend"><span class="input-group-text"><i class="fa fa-address-card"></i></span></div>
                                                                            <input class="form-control" type="number"  placeholder="Number KTP" required>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-lg-6 col-xl-6">
                                                                        <label>Passport</label>
                                                                        <div class="input-group">
                                                                            <div class="input-group-prepend"><span class="input-group-text"><i class="fa fa-id-card-alt"></i></span></div>
                                                                            <input class="form-control" type="number"  placeholder="Number Passport">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="form-group">
                                                                <div class="row">
                                                                    <div class="col-lg-6 col-xl-6">
                                                                        <label><span style="color:red">*</span> Identity Expired Date KTP </label>
                                                                        <div class="input-group">
                                                                            <div class="input-group-prepend"><span class="input-group-text"><i class="flaticon-calendar-with-a-clock-time-tools"></i></span></div>
                                                                            <input class="form-control datepicker" type="text" name="expired_identity"  placeholder="Identity Expired Date">
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-lg-6 col-xl-6">
                                                                        <label>Postal Code </label>
                                                                        <div class="input-group">
                                                                            <div class="input-group-prepend"><span class="input-group-text"><i class="flaticon2-location"></i></span></div>
                                                                            <input class="form-control" type="number" name="postal_code"  placeholder="Postal Code">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="kt-checkbox-inline pt-3">
                                                                    <label class="kt-checkbox">
                                                                        <input type="checkbox" name="permanent" id="permanent" value="permanent"> Permanent
                                                                        <span></span>
                                                                    </label>
                                                                </div>
                                                            </div>
                                                            <div class="form-group">
                                                                <label>Citizien ID Address</label>
                                                                <div class="input-group">
                                                                    <div class="input-group-prepend"><span class="input-group-text"><i class="fa fa-address-card"></i></span></div>
                                                                    <textarea name="citizien_id_address" id="citizien_id_address" cols="30" rows="3" class="form-control" placeholder="Please Enter Address ID Card" required></textarea>
                                                                </div>
                                                                <div class="kt-checkbox-inline pt-3">
                                                                    <label class="kt-checkbox">
                                                                        <input type="checkbox" name="checkbox_residential_address"> use as residential address
                                                                        <span></span>
                                                                    </label>
                                                                </div>
                                                            </div>
                                                            <div class="form-group">
                                                                <label>Residential address</label>
                                                                <div class="input-group">
                                                                    <div class="input-group-prepend"><span class="input-group-text"><i class="fa fa-map-marked-alt"></i></span></div>
                                                                    <textarea name="residential_address" id="residential_address" cols="30" rows="3" class="form-control" placeholder="Please Enter Residence address" required></textarea>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                     <!--End:: Wizard Step 1-->

                                     <!--begin: Form Wizard Step 2-->
                                     <div class="kt-wizard-v4__content" data-ktwizard-type="step-content" data-ktwizard-state="current">
                                        <div class="kt-heading kt-heading--md">Employement Data </div>
                                        <div class="alert alert-secondary" role="alert">
                                            <div class="alert-text">
                                                Fill all employee data information related to company
                                            </div>
                                        </div>
                                        <div class="kt-section kt-section--first">
                                            <div class="kt-wizard-v4__form">
                                                <div class="row">
                                                    <div class="col-xl-12">
                                                        <div class="kt-section__body">
                                                            <div class="form-group">
                                                                <div class="row">
                                                                    <div class="col-lg-6 col-xl-6">
                                                                        <label><span style="color:red">*</span>Organization</label>
                                                                        <select name="organization_id" id="organization_id" class="form-control select2_add_employee" required>
                                                                            <option value="" selected>Select</option>
                                                                            @foreach(DB::table('organization')->get() as $row)
                                                                            <option value="{{$row->id}}" name="{{$row->name}}">{{$row->name}}</option>
                                                                            @endforeach
                                                                        </select>
                                                                    </div>
                                                                    <div class="col-lg-6 col-xl-6">
                                                                        <label><span style="color:red">*</span>Barcode</label>
                                                                        <div class="input-group">
                                                                            <div class="input-group-prepend"><span class="input-group-text"><i class="fa fa-barcode"></i></span></div>
                                                                            <input class="form-control" type="text" name="barcode"  placeholder="Barcode" required>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="form-group">
                                                                <div class="row">
                                                                    <div class="col-lg-6 col-xl-6">
                                                                        <label><span style="color:red">*</span>Employee ID</label>
                                                                        <div class="input-group">
                                                                            <div class="input-group-prepend"><span class="input-group-text"><i class="flaticon2-user"></i></span></div>
                                                                            <input class="form-control" type="text" name="employee_id" readonly  placeholder="Employee ID" required>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-lg-6 col-xl-6">
                                                                        <label><span style="color:red">*</span>Employement Status</label>
                                                                        <select name="employee_status" id="employee_status" class="form-control select2_add_employee" required>
                                                                            <option value="" selected>Select</option>
                                                                            <option value="Active">Active</option>
                                                                            <option value="Non Active">Non Active</option>
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
                                                                            <option value="{{$row->id}}" name="{{$row->name}}" selected>{{$row->name}}</option>
                                                                            @endforeach
                                                                        </select>
                                                                    </div>
                                                                    <div class="col-lg-6 col-xl-6">
                                                                        <label><span style="color:red">*</span>Department</label>
                                                                        <select name="department_id" id="department_id" class="form-control select2_add_employee" required style="width:100%">
                                                                            <option value="" selected>Select</option>
                                                                            @foreach(DB::table('departments')->get() as $row)
                                                                            <option value="{{$row->id}}" class="{{$row->branch_id}}" name="{{$row->name}}" {{old('id')==$row->id ? "selected" : ""}}>{{$row->name}}</option>
                                                                            @endforeach
                                                                        </select>
                                                                        <div id="department-options" class="hidden">
                                                                            @foreach(DB::table('departments')->get() as $row)
                                                                            <option value="{{$row->id}}" class="{{$row->branch_id}}" name="{{$row->name}}">{{$row->name}}</option>
                                                                            @endforeach
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="form-group">
                                                                <div class="row">
                                                                    <div class="col-lg-6 col-xl-6">
                                                                        <label><span style="color:red">*</span> Join Date </label>
                                                                        <div class="input-group">
                                                                            <div class="input-group-prepend"><span class="input-group-text"><i class="flaticon2-calendar-9"></i></span></div>
                                                                            <input class="form-control datepicker" type="text" name="join_date"  placeholder="Join Date" required>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-lg-6 col-xl-6">
                                                                        <label><span style="color:red">*</span> End Date </label>
                                                                        <div class="input-group">
                                                                            <div class="input-group-prepend"><span class="input-group-text"><i class="flaticon2-calendar-9"></i></span></div>
                                                                            <input class="form-control datepicker" type="text" name="end_date"  placeholder="End Date" required>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="form-group">
                                                                <div class="row">
                                                                    <div class="col-lg-6 col-xl-6">
                                                                        <label><span style="color:red">*</span> Job Position</label>
                                                                        <select name="job_position_id" id="job_position_id" class="form-control select2_add_employee" required>
                                                                            <option value="" selected>Select</option>
                                                                            @foreach(DB::table('job_position')->get() as $row)
                                                                            <option value="{{$row->id}}" name="{{$row->name}}">{{$row->name}}</option>
                                                                            @endforeach
                                                                        </select>
                                                                    </div>
                                                                    <div class="col-lg-6 col-xl-6">
                                                                        <label><span style="color:red">*</span> Job Level</label>
                                                                        <select name="job_level_id" id="job_level_id" class="form-control select2_add_employee" required>
                                                                            <option value="" selected>Select</option>
                                                                            @foreach(DB::table('job_level')->get() as $row)
                                                                            <option value="{{$row->id}}" name="{{$row->name}}">{{$row->name}}</option>
                                                                            @endforeach
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="form-group">
                                                                <div class="row">
                                                                    <div class="col-lg-6 col-xl-6">
                                                                        <label><span style="color:red">*</span>Approval Line</label>
                                                                        <select name="approval_line_id" id="approval_line_id" class="form-control select2_add_employee" required>
                                                                            <option value="" selected>Select</option>
                                                                            @foreach(DB::table('employees')->get() as $row)
                                                                            <option value="{{$row->id}}" name="{{$row->full_name}}" >{{$row->full_name}}</option>
                                                                            @endforeach
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                     <!--end: Form Wizard Step 2-->
                                      <!--begin: Form Wizard Step 3-->
                                      <div class="kt-wizard-v4__content" data-ktwizard-type="step-content" data-ktwizard-state="current">
                                        <div class="kt-heading kt-heading--md">Salary </div>
                                        <div class="alert alert-secondary" role="alert">
                                            <div class="alert-text">
                                              Input employee salary info
                                            </div>
                                        </div>
                                        <div class="kt-section kt-section--first">
                                            <div class="kt-wizard-v4__form">
                                                <div class="row">
                                                    <div class="col-xl-12">
                                                        <div class="kt-section__body">
                                                           <div class="form-group">
                                                                <div class="row">
                                                                    <div class="col-lg-6 col-xl-6">
                                                                        <label><span style="color:red">*</span>Basic Salary</label>
                                                                        <div class="input-group">
                                                                            <div class="input-group-prepend"><span class="input-group-text">Rp</span></div>
                                                                            <input class="form-control" type="text" name="basic_salary"  placeholder="Basic Salary" required>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-lg-6 col-xl-6">
                                                                        <label><span style="color:red">*</span>Salary Type</label>
                                                                        <div class="kt-radio-inline">
                                                                            <label class="kt-radio">
                                                                                <input type="radio" name="salary_type" id="salary_type1" value="Monthly">Monthly
                                                                                <span></span>
                                                                            </label>
                                                                            <label class="kt-radio">
                                                                                <input type="radio" name="salary_type" id="salary_type2" value="Daily">Daily
                                                                                <span></span>
                                                                            </label>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                           </div>
                                                           <div class="form-group">
                                                                <div class="row">
                                                                    <div class="col-lg-6 col-xl-6">
                                                                        <label><span style="color:red">*</span><span>Payment Schedule</span></label>
                                                                        <select name="payment_schedule" id="payment_schedule" class="form-control select2_add_employee" required>
                                                                            <option value="" selected>Select</option>
                                                                            <option value="Default" selected>Default</option>
                                                                            <option value="Bonus" >Bonus</option>
                                                                        </select>
                                                                    </div>
                                                                    <div class="col-lg-6 col-xl-6">
                                                                        <label><span style="color:red">* </span><span>Preorate setting</span></label>
                                                                        <select name="preorate_setting" id="preorate_setting" class="form-control select2_add_employee" required>
                                                                            <option value="" selected>Select</option>
                                                                            @foreach(DB::table("preorate_setting")->get() as $row)
                                                                            <option value="{{$row->name}}">{{$row->name}}</option>
                                                                            @endforeach
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                           </div>
                                                           <div class="form-group">
                                                                <div class="row">
                                                                    <div class="col-lg-6 col-xl-6">
                                                                        <label><span style="color:red">*</span><span> Cost Center Category</span></label>
                                                                        <select name="cost_center_category" id="cost_center_category" class="form-control select2_add_employee" required>
                                                                            <option value="" selected>Select</option>
                                                                            <option value="Direct">Direct</option>
                                                                            <option value="In-Direct">In Direct</option>
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="form-group">
                                                                <label><span style="color:red">*</span>Allowance For Overtime</label>
                                                                <div class="kt-radio-inline">
                                                                    <label class="kt-radio">
                                                                        <input type="radio" name="allowance_overtime" value="Yes">Yes
                                                                        <span></span>
                                                                    </label>
                                                                    <label class="kt-radio">
                                                                        <input type="radio" name="allowance_overtime" value="No">No
                                                                        <span></span>
                                                                    </label>
                                                                </div>
                                                            </div>
                                                            <div class="kt-separator kt-separator--border-dashed kt-separator--space-lg"></div>
                                                            <div class="kt-heading kt-heading--md">Bank Account</div>
                                                            <div class="alert alert-secondary" role="alert">
                                                                <div class="alert-text">
                                                                   the employee's bank account is used for payroll
                                                                </div>
                                                            </div>
                                                            <div class="form-group">
                                                                <div class="row">
                                                                    <div class="col-lg-12 col-xl-12">
                                                                        <label><span style="color:red">*</span> Bank Name </label>
                                                                        <div class="input-group">
                                                                            <div class="input-group-prepend"><span class="input-group-text"><i class="la la-bank"></i></span></div>
                                                                            <input class="form-control" type="text" name="bank_name"  placeholder="Bank Name"  required>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="form-group">
                                                                <div class="row">
                                                                    <div class="col-lg-6 col-xl-6">
                                                                        <label><span style="color:red">*</span> Account Name </label>
                                                                        <div class="input-group">
                                                                            <div class="input-group-prepend"><span class="input-group-text"><i class="fa fa-address-card"></i></span></div>
                                                                            <input class="form-control" type="text" name="account_holder_name"  placeholder="Account Name"  required>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-lg-6 col-xl-6">
                                                                        <label><span style="color:red">*</span> Account Number </label>
                                                                        <div class="input-group">
                                                                            <div class="input-group-prepend"><span class="input-group-text"><i class="fa fa-credit-card"></i></span></div>
                                                                            <input class="form-control" type="text" name="account_number"  placeholder="Account Number"  required>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="kt-separator kt-separator--border-dashed kt-separator--space-lg"></div>
                                                            <div class="kt-heading kt-heading--md">Tax Configuration</div>
                                                            <div class="alert alert-secondary" role="alert">
                                                                <div class="alert-text">
                                                                   Select the Tax calculation type relevant to your company
                                                                </div>
                                                            </div>
                                                            <div class="form-group">
                                                                <div class="row">
                                                                    <div class="col-lg-6 col-xl-6">
                                                                        <label><span style="color:red">*</span> NPWP </label>
                                                                        <div class="input-group">
                                                                            <div class="input-group-prepend"><span class="input-group-text"><i class="flaticon-notes"></i></span></div>
                                                                            <input class="form-control" type="text" name="npwp"  placeholder="00.000.000.0-000.000"  required>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-lg-6 col-xl-6">
                                                                        <label><span style="color:red">*</span><span>PTKP Status</span></label>
                                                                        <select name="ptkp_status" id="ptkp_status" class="form-control select2_add_employee" required>
                                                                            <option value="" selected>Select</option>
                                                                            @foreach(DB::table('ptkp')->get() as $row)
                                                                                <option value="{{$row->name}}">{{$row->name}}</option>
                                                                            @endforeach
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="form-group">
                                                                <div class="row">
                                                                    <div class="col-lg-6 col-xl-6">
                                                                        <label><span style="color:red">*</span><span>Tax Method</span></label>
                                                                        <select name="tax_method" id="tax_method" class="form-control select2_add_e  mployee" required>
                                                                            <option value="" selected>Select</option>
                                                                            <option value="Gross">Gross</option>
                                                                            <option value="Gross up">Gross up</option>
                                                                            <option value="Netto">Netto</option>
                                                                        </select>
                                                                    </div>
                                                                    <div class="col-lg-6 col-xl-6">
                                                                        <label><span style="color:red">*</span><span>Tax Salary</span></label>
                                                                        <select name="tax_salary" id="tax_salary" class="form-control select2_add_employee" required>
                                                                            <option value="" selected>Select</option>
                                                                            <option value="Taxable">Tax Salary</option>
                                                                            <option value="Non-taxbale">Non-taxable</option>
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="form-group">
                                                                <div class="row">
                                                                    <div class="col-lg-6 col-xl-6">
                                                                        <label><span style="color:red">*</span> Taxable Date </label>
                                                                        <div class="input-group">
                                                                            <div class="input-group-prepend"><span class="input-group-text"><i class="flaticon2-calendar-9"></i></span></div>
                                                                            <input class="form-control datepicker" type="text" name="taxable_date"  placeholder="Date" required>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-lg-6 col-xl-6">
                                                                        <label><span style="color:red">*</span><span>Employement Tax Status</span></label>
                                                                        <select name="employeement_tax_status" id="employeement_tax_status" class="form-control select2_add_employee" required>
                                                                            <option value="" selected>Select</option>
                                                                            @foreach(DB::table('employement_tax_status')->get() as $row)
                                                                            <option value="{{$row->name}}">{{$row->name}}</option>
                                                                            @endforeach
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="form-group">
                                                                <div class="row">
                                                                    <div class="col-lg-6 col-xl-6">
                                                                        <label><span style="color:red">*</span> Begining Netto </label>
                                                                        <div class="input-group">
                                                                            <div class="input-group-prepend"><span class="input-group-text">Rp.</span></div>
                                                                            <input class="form-control" type="text" name="netto"  placeholder="Netto"  required>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-lg-6 col-xl-6">
                                                                        <label><span style="color:red">*</span> PPH21 </label>
                                                                        <div class="input-group">
                                                                            <div class="input-group-prepend"><span class="input-group-text">Rp.</span></div>
                                                                            <input class="form-control" type="text" name="pph21"  placeholder="PPH12"  required>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="kt-separator kt-separator--border-dashed kt-separator--space-lg"></div>
                                                            <div class="kt-heading kt-heading--md">Bpjs Configuration</div>
                                                            <div class="alert alert-secondary" role="alert">
                                                                <div class="alert-text">
                                                                   Employee Bpjs Payment Arrangement
                                                                </div>
                                                            </div>
                                                            <div class="form-group">
                                                                <div class="row">
                                                                    <div class="col-lg-6 col-xl-6">
                                                                        <label><span style="color:red">*</span> Bpjs ketenagakerjaan Number</label>
                                                                        <div class="input-group">
                                                                            <div class="input-group-prepend"><span class="input-group-text"><i class="flaticon-notes"></i></span></div>
                                                                            <input class="form-control" type="text" name="bpjs_kerja_number"  placeholder="BPJS Number"  required>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-lg-6 col-xl-6">
                                                                        <label><span style="color:red">*</span> BPJS Ketenagakerjaan Date </label>
                                                                        <div class="input-group">
                                                                            <div class="input-group-prepend"><span class="input-group-text"><i class="flaticon2-calendar-9"></i></span></div>
                                                                            <input class="form-control datepicker" type="text" name="bpjs_kerja_date"  placeholder="Date" required>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="form-group">
                                                                <div class="row">
                                                                    <div class="col-lg-6 col-xl-6">
                                                                        <label><span style="color:red">*</span> Bpjs Kesehatan Number</label>
                                                                        <div class="input-group">
                                                                            <div class="input-group-prepend"><span class="input-group-text"><i class="flaticon-notes"></i></span></div>
                                                                            <input class="form-control" type="text" name="bpjs_kesehatan_number"  placeholder="BPJS Number"  required>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-lg-6 col-xl-6">
                                                                        <label><span style="color:red">*</span><span>Bpjs Kesehatan Family</span></label>
                                                                        <div class="input-group">
                                                                            <div class="input-group-prepend"><span class="input-group-text"><i class="flaticon-notes"></i></span></div>
                                                                            <input class="form-control" type="text" name="bpjs_kesehatan_family"  placeholder="BPJS Family"  required>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="form-group">
                                                                <div class="row">
                                                                    <div class="col-lg-6 col-xl-6">
                                                                        <label><span style="color:red">*</span> BPJS Kesehatan Date </label>
                                                                        <div class="input-group">
                                                                            <div class="input-group-prepend"><span class="input-group-text"><i class="flaticon2-calendar-9"></i></span></div>
                                                                            <input class="form-control datepicker" type="text" name="bpjs_kesehatan_date"  placeholder="Date" required>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-lg-6 col-xl-6">
                                                                        <label><span style="color:red">*</span><span>Bpjs Kesehatan Cost</span></label>
                                                                        <select name="bpjs_kesehatan_cost" id="bpjs_kesehatan_cost" class="form-control select2_add_employee" required>
                                                                            <option value="Default" selected>Default</option>
                                                                            <option value="By Company">By Company</option>
                                                                            <option value="By Employee">By Employee</option>
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="form-group">
                                                                <div class="row">
                                                                    <div class="col-lg-12 col-xl-12">
                                                                        <label><span style="color:red">*</span><span>JHT Cost</span></label>
                                                                        <select name="bpjs_jht_cost" id="bpjs_jht_cost" class="form-control select2_add_employee" required>
                                                                            <option value="Default" selected>Default</option>
                                                                            <option value="Not paid">Not Paid</option>
                                                                            <option value="By Company">By Company</option>
                                                                            <option value="By Employee">By Employee</option>
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="form-group">
                                                                <div class="row">
                                                                    <div class="col-lg-6 col-xl-6">
                                                                        <label><span style="color:red">*</span><span>Jaminan Pensiun Cost</span></label>
                                                                        <select name="jaminan_pensiun_cost" id="jaminan_pensiun_cost" class="form-control select2_add_employee" required>
                                                                            <option value="Default" selected>Default</option>
                                                                            <option value="Not paid">Not Paid</option>
                                                                            <option value="By Company">By Company</option>
                                                                            <option value="By Employee">By Employee</option>
                                                                        </select>
                                                                    </div>
                                                                    <div class="col-lg-6 col-xl-6">
                                                                        <label><span style="color:red">*</span> Jaminan Pensiun Date </label>
                                                                        <div class="input-group">
                                                                            <div class="input-group-prepend"><span class="input-group-text"><i class="flaticon2-calendar-9"></i></span></div>
                                                                            <input class="form-control datepicker" type="text" name="jaminan_pensiun_date"  placeholder="Date" required>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!--end: Form Wizard Step 3-->
                                    <!--begin: Form Wizard Step 4-->
                                    <div class="kt-wizard-v4__content" data-ktwizard-type="step-content" data-ktwizard-state="current">
                                        <div class="kt-heading kt-heading--md">Review your Details and Invite Employees</div>
                                        <div class="kt-section kt-section--first">
                                            <div class="kt-wizard-v4__form" >
                                                <div class="row">
                                                    <div class="col-xl-6">
                                                        <div class="kt-section__body">
                                                            <div class="kt-wizard-v4__review">
                                                                <div class="kt-wizard-v4__review-item">
                                                                    <div class="kt-wizard-v4__review-title">
                                                                       Personal Data
                                                                    </div>
                                                                    <div class="kt-wizard-v4__review-content">
                                                                         Fullname <span id="fullname_view"  style="color:blue;"></span>
                                                                        <br>Email  <span id="email_view" style="color:blue;"></span>
                                                                        <br>Mobile Phone  <span id="mobile_phone_view" style="color:blue;"></span>
                                                                        <br>Phone  <span id="phone_view" style="color:blue;"></span>
                                                                        <br>Place Of Birth  <span id="place_birth_view" style="color:blue;"></span>
                                                                        <br>Birthday  <span id="birthday_view" style="color:blue;"></span>
                                                                        <br>Gender  <span id="gender_view" style="color:blue;"></span>
                                                                        <br>Martial Status  <span id="get_merried_status_view" style="color:blue;"></span>
                                                                        <br>Blood Type  <span id="get_blood_type_view" style="color:blue;"></span>
                                                                        <br>Religion  <span id="get_religion_view" style="color:blue;"></span>
                                                                    </div>
                                                                </div>
                                                                <div class="kt-wizard-v4__review-item">
                                                                    <div class="kt-wizard-v4__review-title">
                                                                        Identity &  Address
                                                                    </div>
                                                                    <div class="kt-wizard-v4__review-content">
                                                                         Identity Type <span id="get_identity_tipe_view"  style="color:blue;"></span>
                                                                        <br>Identity Number <span id="get_identity_number_view"  style="color:blue;"></span>
                                                                        <br>Identity Expired Date <span id="get_expired_identity_view"  style="color:blue;"></span>
                                                                        <br>Postal Code <span id="get_postal_code_view"  style="color:blue;"></span>
                                                                        <br>Citizien ID Address <span id="get_citizien_id_address_view"  style="color:blue;"></span>
                                                                        <br>Residence Address <span id="get_residential_address_view"  style="color:blue;"></span>
                                                                    </div>
                                                                </div>
                                                                <div class="kt-wizard-v4__review-item">
                                                                    <div class="kt-wizard-v4__review-title">
                                                                        Employeement Data
                                                                    </div>
                                                                    <div class="kt-wizard-v4__review-content">
                                                                        Employee ID <span id="get_employe_id_view"  style="color:blue;"></span>
                                                                        <br>Barcode <span id="get_barcode_view"  style="color:blue;"></span>
                                                                        <br>Employeement status <span id="get_employee_status_view"  style="color:blue;"></span>
                                                                        <br>Join Date <span id="get_join_date_view"  style="color:blue;"></span>
                                                                        <br>End Date <span id="get_end_date_view"  style="color:blue;"></span>
                                                                        <br>Organization <span id="get_organization_id_view"  style="color:blue;"></span>
                                                                        <br>Branch <span id="get_branch_id_view"  style="color:blue;"></span>
                                                                        <br>Department <span id="get_department_id_view"  style="color:blue;"></span>
                                                                        <br>Job Position <span id="get_organization_id_view"  style="color:blue;"></span>
                                                                        <br>Job Level <span id="get_job_level_id_view"  style="color:blue;"></span>
                                                                        <br>Schedule <span id="get_schedule_id_view"  style="color:blue;"></span>
                                                                        <br>Approval Line <span id="get_approval_id_view"  style="color:blue;"></span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-xl-6">
                                                        <div class="kt-section__body">
                                                            <div class="kt-wizard-v4__review">
                                                                <div class="kt-wizard-v4__review-item">
                                                                    <div class="kt-wizard-v4__review-title">
                                                                       Salary
                                                                    </div>
                                                                    <div class="kt-wizard-v4__review-content">
                                                                         Basic Salary <span id="get_basic_salary_view"  style="color:blue;"></span>
                                                                        <br>Salary Type  <span id="get_salary_type_view" style="color:blue;"></span>
                                                                        <br>Payment Schedule  <span id="get_payment_schedule_view" style="color:blue;"></span>
                                                                        <br>Preorate Setting  <span id="get_preorate_setting_view" style="color:blue;"></span>
                                                                        <br>Cost Center Category  <span id="get_cost_center_category_view" style="color:blue;"></span>
                                                                        <br>Allowance For Overtime  <span id="get_allowance_overtime_view" style="color:blue;"></span>
                                                                    </div>
                                                                </div>
                                                                <div class="kt-wizard-v4__review-item">
                                                                    <div class="kt-wizard-v4__review-title">
                                                                        Bank Account
                                                                    </div>
                                                                    <div class="kt-wizard-v4__review-content">
                                                                         Bank Name <span id="get_bank_name_view"  style="color:blue;"></span>
                                                                        <br>Account Name <span id="get_account_holder_name_view"  style="color:blue;"></span>
                                                                        <br>Account Number <span id="get_account_number_view"  style="color:blue;"></span>
                                                                    </div>
                                                                </div>
                                                                <div class="kt-wizard-v4__review-item">
                                                                    <div class="kt-wizard-v4__review-title">
                                                                        Tax Configuration
                                                                    </div>
                                                                    <div class="kt-wizard-v4__review-content">
                                                                        NPWP <span id="get_npwp_view"  style="color:blue;"></span>
                                                                        <br>PTKP Status<span id="get_ptkp_status_view"  style="color:blue;"></span>
                                                                        <br>Tax Method <span id="get_tax_method_view"  style="color:blue;"></span>
                                                                        <br>Tax Salary <span id="get_tax_salary_view"  style="color:blue;"></span>
                                                                        <br>Taxable Date <span id="get_taxable_date_view"  style="color:blue;"></span>
                                                                        <br>Employement Tax Status <span id="get_employeement_tax_status_view"  style="color:blue;"></span>
                                                                        <br>Begining Netto <span id="get_netto_view"  style="color:blue;"></span>
                                                                        <br>PPH21 <span id="get_pp21_view"  style="color:blue;"></span>
                                                                    </div>
                                                                </div>
                                                                <div class="kt-wizard-v4__review-item">
                                                                    <div class="kt-wizard-v4__review-title">
                                                                        Bpjs Configuration
                                                                    </div>
                                                                    <div class="kt-wizard-v4__review-content">
                                                                         Bpjs ketenagakerjaan Number <span id="get_bpjs_kerja_number_view"  style="color:blue;"></span>
                                                                        <br>BPJS Ketenagakerjaan Date <span id="get_bpjs_kerja_date_view"  style="color:blue;"></span>
                                                                        <br>Bpjs Kesehatan Number <span id="get_bpjs_kesehatan_number_view"  style="color:blue;"></span>
                                                                        <br>Bpjs Kesehatan Family <span id="get_bpjs_kesehatan_family_view"  style="color:blue;"></span>
                                                                        <br>BPJS Kesehatan Date <span id="get_bpjs_kesehatan_date_view"  style="color:blue;"></span>
                                                                        <br>Bpjs Kesehatan Cost <span id="get_bpjs_kesehatan_cost_view"  style="color:blue;"></span>
                                                                        <br>JHT Cost <span id="get_bpjs_jht_cost_view"  style="color:blue;"></span>
                                                                        <br>Jaminan Pensiun Cost <span id="get_jaminan_pensiun_cost_view"  style="color:blue;"></span>
                                                                        <br>Jaminan Pensiun Date <span id="get_jaminan_pensiun_date_view"  style="color:blue;"></span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <hr>
                                        <div class="kt-heading kt-heading--md text-center">Invite the employee to access E-Smart</div>
                                        <div class="kt-section kt-section--first">
                                            <div class="kt-wizard-v4__form" >
                                                <div class="row justify-content-center">
                                                    <div class="col-xl-6">
                                                        <div class="text-center">
                                                            <i class="flaticon-users-1 fa-4x"></i>
                                                            <p>You Have successfully added employee data. To continue the process, you can invite employess to access E-Smart</p>
                                                        </div>

                                                        <div class="card border border-3 ">
                                                            <div class="card-body">
                                                                <div class="form-group mb-3">
                                                                    <div class="kt-checkbox-list">
                                                                        <label class="kt-checkbox kt-checkbox--success">
                                                                            <input type="checkbox" name="email_invitation"> Invite to E-Smart
                                                                            <span></span>
                                                                        </label>
                                                                    </div>
                                                                </div>
                                                                <p class="m-0">Invite to give them access to platform using Employee Self Service feature. You can do this later at settings page</p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!--end: Form Wizard Step 4-->
                                    <!--begin: Form Actions -->
                                    <div class="kt-form__actions">
                                        <div class="btn btn-secondary btn-md btn-tall btn-wide kt-font-bold kt-font-transform-u" data-ktwizard-type="action-prev">
                                            Previous
                                        </div>
                                        <button type="submit"  class="btn btn-success btn-md btn-tall btn-wide kt-font-bold kt-font-transform-u" data-ktwizard-type="action-submit">
                                            Invite Employee
                                        </button>
                                        <div class="btn btn-brand btn-md btn-tall btn-wide kt-font-bold kt-font-transform-u" data-ktwizard-type="action-next">
                                            Next Step
                                        </div>
                                    </div>
                                    <!--end: Form Actions -->
                                </form>
                                 <!--end: Form Wizard Form-->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- End:: Content -->
    </div>
</div>
@endsection
@push('scriptjs')
<script src="{{ asset('demo10/assets/js/pages/custom/user/add-user.js')}}" type="text/javascript"></script>
<script>
    /* Wizazd 1 */
    $("[name='first_name']").keyup(function(){
        localStorage.setItem("first_name",$(this).val());
    });
    $("[name='last_name']").keyup(function(){
        localStorage.setItem("last_name",$(this).val());
    });
    $("[name='email']").change(function(){
        localStorage.setItem("email",$(this).val());
    });
    $("[name='mobile_phone']").change(function(){
        localStorage.setItem("mobile_phone",$(this).val());
    });
    $("[name='phone']").change(function(){
        localStorage.setItem("phone",$(this).val());
    });
    $("[name='place_of_birth']").keyup(function(){
        localStorage.setItem("place_of_birth",$(this).val());
    });
    $("[name='date_of_birth']").change(function(){
        localStorage.setItem("date_of_birth",$(this).val());
    });
    $("select[name='gender']").change(function(){
        localStorage.setItem("gender",$(this).val());
    });
    $("select[name='marital_status']").change(function(){
        localStorage.setItem("marital_status",$(this).val());
    });
    $("select[name='blood_type']").change(function(){
        localStorage.setItem("blood_type",$(this).val());
    });
    $("select[name='religion']").change(function(){
        localStorage.setItem("religion",$(this).val());
    });
    $("select[name='identity_type']").change(function(){
        localStorage.setItem("identity_type",$(this).val());
    });
    $("[name='identity_number']").keyup(function(){
        localStorage.setItem("identity_number",$(this).val());
    });
    $("[name='expired_identity']").change(function(){
        localStorage.setItem("expired_identity",$(this).val());
        localStorage.setItem("expired_identity_copy",$(this).val());
    });
    let get_expired_identity_copy = localStorage.getItem("expired_identity_copy");
    $("input[name='permanent']").click(function () {
        if ($(this).is(":checked")) {
            $("[name='expired_identity']").val($(this).val());
            localStorage.setItem("permanent",$(this).val());
        } else {
            $("[name='expired_identity']").val(get_expired_identity_copy);
            localStorage.removeItem("permanent");
        }
    });
    $("[name='postal_code']").keyup(function(){
        localStorage.setItem("postal_code",$(this).val());
    });
    $("[name='residential_address']").keyup(function(){
        localStorage.setItem("residential_address",$(this).val());
        localStorage.setItem("residential_address_copy",$(this).val());
    });
    $("[name='citizien_id_address']").keyup(function(){
        localStorage.setItem("citizien_id_address",$(this).val());
        localStorage.setItem("citizien_id_address_copy",$(this).val());
    });
    let get_residential_address_copy = localStorage.getItem("residential_address_copy");
    let get_citizien_id_address_copy = localStorage.getItem("citizien_id_address_copy");

    $("input[name='checkbox_residential_address']").click(function () {
        if ($(this).is(":checked")){
            localStorage.setItem("checkbox_residential_address", 1);
            // $("#residential_address").val($("[name='citizien_id_address']").val());
            // $("#residential_address").text($("[name='citizien_id_address']").val());
            let get_citizien_id_address_copy = localStorage.getItem("citizien_id_address_copy");
            $("#residential_address").val(get_citizien_id_address_copy)
        } else {
            localStorage.removeItem("checkbox_residential_address");
            let residential_address_back = localStorage.getItem("residential_address");
            // $("[name='residential_address']").html(residential_address_back);
            $("#residential_address").val(residential_address_back)
        }
    });

    $("[name='employee_id']").keyup(function(reviewData){
        localStorage.setItem("employee_id",$(this).val());
    });
    $("[name='barcode']").keyup(function(){
        localStorage.setItem("barcode",$(this).val());
    });
    $("select[name='employee_status']").change(function(){
        localStorage.setItem("employee_status",$(this).val());
    });
    $("[name='join_date']").change(function(){
        localStorage.setItem("join_date",$(this).val());
    });
    $("[name='end_date']").change(function(){
        localStorage.setItem("end_date",$(this).val());
    });
    $("select[name='branch_id']").change(function(){
        localStorage.setItem("branch_id",$(this).val());
        localStorage.setItem("branch_name",$(this).find('option:selected').attr("name"));
    });
    $("select[name='department_id']").change(function(){
        localStorage.setItem("department_id",$(this).val());
        localStorage.setItem("department_name",$(this).find('option:selected').attr("name"));
    });

    $("#branch_id").on('select2:select', function(event) {
        let branch = event.params.data
        let data = branch.id

        $('#department_id').html('<option value="">Select</option');
        $('#department-options option').each(function() {
            if ($(this).hasClass(data)) {
                let option = $(this).clone();
                $('#department_id').append(option[0]);
            }
        })
    });

    $("select[name='organization_id']").change(function(){
        localStorage.setItem("organization_id",$(this).val());
        localStorage.setItem("organization_name",$(this).find('option:selected').attr("name"));
    });
    $("select[name='job_position_id']").change(function(){
        localStorage.setItem("job_position_id",$(this).val());
        localStorage.setItem("job_position_name",$(this).find('option:selected').attr("name"));
    });
    $("select[name='job_level_id']").change(function(){
        localStorage.setItem("job_level_id",$(this).val());
        localStorage.setItem("job_level_name",$(this).find('option:selected').attr("name"));
    });
    $("select[name='schedule_id']").change(function(){
        localStorage.setItem("schedule_id",$(this).val());
        localStorage.setItem("schedule_name",$(this).find('option:selected').attr("name"));
    });
    $("select[name='approval_line_id']").change(function(){
        localStorage.setItem("approval_line_id",$(this).val());
        localStorage.setItem("approval_name",$(this).find('option:selected').attr("name"));
    });
    $("[name='basic_salary']").keyup(function() {
        var n = parseInt($(this).val().replace(/\D/g, ''), 10) || '';
        $(this).val(n.toLocaleString());
        localStorage.setItem("basic_salary",n);
    });
   $('input[name="salary_type"]').change(function() {
        if($(this).is(':checked')){
            let id = $(this).attr('name');
            let value = $(this).val();
            localStorage.setItem(id, value);
        }
    });
    $('input[name="allowance_overtime"]').change(function() {
        if($(this).is(':checked')){
            let id = $(this).attr('name');
            let value = $(this).val();
            localStorage.setItem(id, value);
        }
    });
    $("select[name='payment_schedule']").change(function(){
        localStorage.setItem("payment_schedule",$(this).val());
    });
    $("select[name='preorate_setting']").change(function(){
        localStorage.setItem("preorate_setting",$(this).val());
    });
    $("select[name='cost_center_category']").change(function(){
        localStorage.setItem("cost_center_category",$(this).val());
    });
    $("[name='bank_name']").change(function(){
        localStorage.setItem("bank_name",$(this).val());
    });
    $("[name='account_holder_name']").change(function(){
        localStorage.setItem("account_holder_name",$(this).val());
    });
    $("[name='account_number']").change(function(){
        localStorage.setItem("account_number",$(this).val());
    });
    $("[name='npwp']").keyup(function(){
        localStorage.setItem("npwp",$(this).val());
    });
    $("select[name='ptkp_status']").change(function(){
        localStorage.setItem("ptkp_status",$(this).val());
    });
    $("select[name='tax_method']").change(function(){
        localStorage.setItem("tax_method",$(this).val());
    });
    $("select[name='tax_salary']").change(function(){
        localStorage.setItem("tax_salary",$(this).val());
    });
    $("[name='taxable_date']").change(function(){
        localStorage.setItem("taxable_date",$(this).val());
    });
    $("select[name='employeement_tax_status']").change(function(){
        localStorage.setItem("employeement_tax_status",$(this).val());
    });
    $("[name='netto']").keyup(function() {
        var n = parseInt($(this).val().replace(/\D/g, ''), 10) || '';
        $(this).val(n.toLocaleString());
        localStorage.setItem("netto",n);
    });
    $("[name='pph21']").keyup(function() {
        var n = parseInt($(this).val().replace(/\D/g, ''), 10) || '';
        $(this).val(n.toLocaleString());
        localStorage.setItem("pph21",n);
    });
    $("[name='bpjs_kerja_number']").keyup(function(){
        localStorage.setItem("bpjs_kerja_number",$(this).val());
    });
    $("[name='bpjs_kerja_date']").change(function(){
        localStorage.setItem("bpjs_kerja_date",$(this).val());
    });
    $("[name='bpjs_kesehatan_number']").keyup(function(){
        localStorage.setItem("bpjs_kesehatan_number",$(this).val());
    });
    $("[name='bpjs_kesehatan_family']").keyup(function(){
        localStorage.setItem("bpjs_kesehatan_family",$(this).val());
    });
    $("[name='bpjs_kesehatan_date']").change(function(){
        localStorage.setItem("bpjs_kesehatan_date",$(this).val());
    });
    $("select[name='bpjs_kesehatan_cost']").change(function(){
        localStorage.setItem("bpjs_kesehatan_cost",$(this).val());
    });
    $("select[name='bpjs_jht_cost']").change(function(){
        localStorage.setItem("bpjs_jht_cost",$(this).val());
    });
    $("select[name='jaminan_pensiun_cost']").change(function(){
        localStorage.setItem("jaminan_pensiun_cost",$(this).val());
    });
    $("[name='jaminan_pensiun_date']").change(function(){
        localStorage.setItem("jaminan_pensiun_date",$(this).val());
    });

    function reviewData(){
        var get_first_name                   = localStorage.getItem("first_name");
        var get_last_name                    = localStorage.getItem("last_name");
        var get_email                        = localStorage.getItem("email");
        var get_mobile_phone                 = localStorage.getItem("mobile_phone");
        var get_phone                        = localStorage.getItem("phone");
        var get_place_of_birth               = localStorage.getItem("place_of_birth");
        var get_date_of_birth                = localStorage.getItem("date_of_birth");
        var get_gender                       = localStorage.getItem("gender");
        var get_marital_status               = localStorage.getItem("marital_status");
        var get_blood_type                   = localStorage.getItem("blood_type");
        var get_religion                     = localStorage.getItem("religion");
        var get_identity_type                = localStorage.getItem("identity_type");
        var get_identity_number              = localStorage.getItem("identity_number");
        var get_expired_identity             = localStorage.getItem("expired_identity");
        var get_permanent                    = localStorage.getItem("permanent");
        var get_postal_code                  = localStorage.getItem("postal_code");
        var get_checkbox_residential_address = localStorage.getItem("checkbox_residential_address");
        var get_citizien_id_address          = localStorage.getItem("citizien_id_address");
        var get_residential_address          = localStorage.getItem("residential_address");
        var get_employee_id                   = localStorage.getItem("employee_id");
        var get_barcode                      = localStorage.getItem("barcode");
        var get_employee_status              = localStorage.getItem("employee_status");
        var get_join_date                    = localStorage.getItem("join_date");
        var get_end_date                     = localStorage.getItem("end_date");
        var get_branch_id                    = localStorage.getItem("branch_id");
        var get_branch_name                  = localStorage.getItem("branch_name");
        var get_department_id                = localStorage.getItem("department_id");
        var get_department_name              = localStorage.getItem("department_name");
        var get_organization_id              = localStorage.getItem("organization_id");
        var get_organization_name            = localStorage.getItem("organization_name");
        var get_job_position_id              = localStorage.getItem("job_position_id");
        var get_job_position_name            = localStorage.getItem("job_position_name");
        var get_job_level_id                 = localStorage.getItem("job_level_id");
        var get_job_level_name               = localStorage.getItem("job_level_name");
        var get_schedule_id                  = localStorage.getItem("schedule_id");
        var get_schedule_name                = localStorage.getItem("schedule_name");
        var get_approval_line_id             = localStorage.getItem("approval_line_id");
        var get_approval_name                = localStorage.getItem("approval_name");
        var get_basic_salary                 = localStorage.getItem("basic_salary");
        let get_SalaryType;
        $('input[name="salary_type"]').each(function() {
            let id = $(this).attr('name');
            var radios = document.getElementsByName(id);
            get_SalaryType = localStorage.getItem(id);
            for(var i=0;i<radios.length;i++){
                if(radios[i].value == get_SalaryType){
                    radios[i].checked = true;
                }
            }
        });
        let get_allowance_overtime;
        $('input[name="allowance_overtime"]').each(function() {
            let id = $(this).attr('name');
            var radios = document.getElementsByName(id);
            get_allowance_overtime = localStorage.getItem(id);
            for(var i=0;i<radios.length;i++){
                if(radios[i].value == get_allowance_overtime){
                    radios[i].checked = true;
                }
            }
        });
        var get_payment_schedule             = localStorage.getItem("payment_schedule");
        var get_preorate_setting             = localStorage.getItem("preorate_setting");
        var get_cost_center_category         = localStorage.getItem("cost_center_category");
        var get_bank_name                    = localStorage.getItem("bank_name");
        var get_account_holder_name          = localStorage.getItem("account_holder_name");
        var get_account_number               = localStorage.getItem("account_number");
        var get_npwp                         = localStorage.getItem("npwp");
        var get_ptkp_status                  = localStorage.getItem("ptkp_status");
        var get_tax_method                   = localStorage.getItem("tax_method");
        var get_tax_salary                   = localStorage.getItem("tax_salary");
        var get_taxable_date                 = localStorage.getItem("taxable_date");
        var get_employeement_tax_status      = localStorage.getItem("employeement_tax_status");
        var get_employeement_tax_status      = localStorage.getItem("employeement_tax_status");
        var get_netto                        = localStorage.getItem("netto");
        var get_pph21                        = localStorage.getItem("pph21");
        var get_bpjs_kerja_number            = localStorage.getItem("bpjs_kerja_number");
        var get_bpjs_kerja_date              = localStorage.getItem("bpjs_kerja_date");
        var get_bpjs_kesehatan_number        = localStorage.getItem("bpjs_kesehatan_number");
        var get_bpjs_kesehatan_family        = localStorage.getItem("bpjs_kesehatan_family");
        var get_bpjs_kesehatan_date          = localStorage.getItem("bpjs_kesehatan_date");
        var get_bpjs_kesehatan_cost          = localStorage.getItem("bpjs_kesehatan_cost");
        var get_bpjs_jht_cost                = localStorage.getItem("bpjs_jht_cost");
        var get_jaminan_pensiun_cost         = localStorage.getItem("jaminan_pensiun_cost");
        var get_jaminan_pensiun_date         = localStorage.getItem("jaminan_pensiun_date");
        var get_first_name                   = localStorage.getItem("first_name");
        $("[name='first_name']").val(get_first_name);
        $("[name='last_name']").val(get_last_name);
        $("[name='email']").val(get_email);
        $("[name='mobile_phone']").val(get_mobile_phone);
        $("[name='phone']").val(get_phone);
        $("[name='place_of_birth']").val(get_place_of_birth);
        $("[name='date_of_birth']").val(get_date_of_birth);
        $("[name='gender']").val(get_gender);
        $("[name='marital_status']").val(get_marital_status);
        $("[name='blood_type']").val(get_blood_type);
        $("[name='religion']").val(get_religion);
        $("[name='identity_type']").val(get_identity_type);
        $("[name='identity_number']").val(get_identity_number);
        $("[name='expired_identity']").val(get_expired_identity);
        if (get_permanent == "permanent") {
            $("[name='expired_identity']").val(get_permanent);
            $("input[name='permanent']").attr("checked", "checked");
        }else{
            $("[name='expired_identity']").val(get_expired_identity);
        }
        $("[name='postal_code']").val(get_postal_code);
        // $("[name='residential_address']").html(get_residential_address);
        if (get_checkbox_residential_address !== null) {
            $("[name='residential_address']").html(get_citizien_id_address);
            $("input[name='checkbox_residential_address']").attr("checked", "checked");
        }else{
            var get_residential_address          = localStorage.getItem("residential_address");
            $("[name='residential_address']").html(get_residential_address);
        }
        $("[name='citizien_id_address']").html(get_citizien_id_address);
        $("[name='employee_id']").val(get_employee_id);
        $("[name='barcode']").val(get_barcode);
        $("[name='employee_status']").val(get_employee_status);
        $("[name='join_date']").val(get_join_date);
        $("[name='end_date']").val(get_end_date);
        $("select[name='branch_id']").val(get_branch_id);
        $("select[name='department_id']").val(get_department_id);
        $("select[name='organization_id']").val(get_organization_id);
        $("select[name='job_position_id']").val(get_job_position_id);
        $("select[name='job_level_id']").val(get_job_level_id);
        $("select[name='schedule_id']").val(get_schedule_id);
        $("select[name='approval_line_id']").val(get_approval_line_id);
        var n1 = parseInt(get_basic_salary.replace(/\D/g, ''), 10) || '';
        $("[name='basic_salary']").val(n1.toLocaleString());
        $("[name='payment_schedule']").val(get_payment_schedule);
        $("[name='preorate_setting']").val(get_preorate_setting);
        $("[name='cost_center_category']").val(get_cost_center_category);
        $("[name='bank_name']").val(get_bank_name);
        $("[name='account_holder_name']").val(get_account_holder_name);
        $("[name='account_number']").val(get_account_number);
        $("[name='npwp']").val(get_npwp);
        $("[name='ptkp_status']").val(get_ptkp_status);
        $("[name='tax_method']").val(get_tax_method);
        $("[name='tax_salary']").val(get_tax_salary);
        $("[name='taxable_date']").val(get_taxable_date);
        $("[name='employeement_tax_status']").val(get_employeement_tax_status);
        var n2 = parseInt(get_netto.replace(/\D/g, ''), 10) || '';
        $("[name='netto']").val(n2.toLocaleString());
        var n3 = parseInt(get_pph21.replace(/\D/g, ''), 10) || '';
        $("[name='pph21']").val(n3.toLocaleString());
        $("[name='bpjs_kerja_number']").val(get_bpjs_kerja_number);
        $("[name='bpjs_kerja_date']").val(get_bpjs_kerja_date);
        $("[name='bpjs_kesehatan_number']").val(get_bpjs_kesehatan_number);
        $("[name='bpjs_kesehatan_family']").val(get_bpjs_kesehatan_family);
        $("[name='bpjs_kesehatan_date']").val(get_bpjs_kesehatan_date);
        $("[name='bpjs_kesehatan_cost']").val(get_bpjs_kesehatan_cost);
        $("[name='bpjs_jht_cost']").val(get_bpjs_jht_cost);
        $("[name='jaminan_pensiun_cost']").val(get_jaminan_pensiun_cost);
        $("[name='jaminan_pensiun_date']").val(get_jaminan_pensiun_date);
        $("#fullname_view").html(get_first_name+" "+get_last_name);
        $("#email_view").html(get_email);
        $("#mobile_phone_view").html(get_mobile_phone);
        $("#phone_view").html(get_phone);
        $("#place_birth_view").html(get_place_of_birth);
        $("#birthday_view").html(get_date_of_birth);
        $("#gender_view").html(get_gender);
        $("#get_merried_status_view").html(get_marital_status);
        $("#get_blood_type_view").html(get_blood_type);
        $("#get_religion_view").html(get_religion);
        $("#get_identity_tipe_view").html(get_identity_type);
        $("#get_identity_number_view").html(get_identity_number);
        if (get_permanent == "permanent") {
            $("#get_expired_identity_view").html(get_permanent);
        }else{
            $("#get_expired_identity_view").html(get_expired_identity);
        }
        $("#get_postal_code_view").html(get_postal_code);

        // $("#get_residential_address_view").html(get_residential_address);
        if(get_checkbox_residential_address ==1){
            $("#get_residential_address_view").html(get_citizien_id_address);
        }else{
            $("#get_residential_address_view").html(get_residential_address);
        }
        $("#get_citizien_id_address_view").html(get_citizien_id_address);
        $("#get_employe_id_view").html(get_employee_id);
        $("#get_barcode_view").html(get_barcode);
        $("#get_employee_status_view").html(get_employee_status);
        $("#get_join_date_view").html(get_join_date);
        $("#get_end_date_view").html(get_end_date);
        $("#get_branch_id_view").html(get_branch_name);
        $("#get_department_id_view").html(get_department_name);
        $("#get_organization_id_view").html(get_organization_name);
        $("#get_job_position_id_view").html(get_job_position_name);
        $("#get_job_level_id_view").html(get_job_level_name);
        $("#get_schedule_id_view").html(get_schedule_name);
        $("#get_approval_id_view").html(get_approval_name);
        $("#get_basic_salary_view").html(n1.toLocaleString());
        $("#get_salary_type_view").html(get_SalaryType);
        $("#get_allowance_overtime_view").html(get_allowance_overtime);
        $("#get_payment_schedule_view").html(get_payment_schedule);
        $("#get_preorate_setting_view").html(get_preorate_setting);
        $("#get_cost_center_category_view").html(get_cost_center_category);
        $("#get_bank_name_view").html(get_bank_name);
        $("#get_account_holder_name_view").html(get_account_holder_name);
        $("#get_account_number_view").html(get_account_number);
        $("#get_npwp_view").html(get_npwp);
        $("#get_ptkp_status_view").html(get_ptkp_status);
        $("#get_tax_method_view").html(get_tax_method);
        $("#get_tax_salary_view").html(get_tax_salary);
        $("#get_taxable_date_view").html(get_taxable_date);
        $("#get_employeement_tax_status_view").html(get_employeement_tax_status);
        $("#get_netto_view").html(n2.toLocaleString());
        $("#get_pp21_view").html(n3.toLocaleString());
        $("#get_bpjs_kerja_number_view").html(get_bpjs_kerja_number);
        $("#get_bpjs_kerja_date_view").html(get_bpjs_kerja_date);
        $("#get_bpjs_kesehatan_number_view").html(get_bpjs_kesehatan_number);
        $("#get_bpjs_kesehatan_family_view").html(get_bpjs_kesehatan_family);
        $("#get_bpjs_kesehatan_date_view").html(get_bpjs_kesehatan_date);
        $("#get_bpjs_kesehatan_cost_view").html(get_bpjs_kesehatan_cost);
        $("#get_bpjs_jht_cost_view").html(get_bpjs_jht_cost);
        $("#get_jaminan_pensiun_cost_view").html(get_jaminan_pensiun_cost);
        $("#get_jaminan_pensiun_date_view").html(get_jaminan_pensiun_date);
    }
    reviewData();
    $('.select2_add_employee').select2();
</script>
@endpush
