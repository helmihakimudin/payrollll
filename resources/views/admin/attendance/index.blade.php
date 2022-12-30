@extends('layout-admin.base', [
    'pages' => 'Setting Attemdance',
    'subpages' => 'Setting Attemdance',
])

@push('css')
<style>
    .disabled{
        cursor: not-allowed !important;
        pointer-events: auto !important;
        opacity: .3 !important;
    } 

    .dt-right{
        width: 1% !important;
    }

    .btn:focus, .btn.focus {
        outline: 0;
        -webkit-box-shadow: none !important;
        box-shadow: none !important;
    }
</style>            
@endpush
@section('content')
<div id="App">
    <div class="kt-portlet">
        <div class="kt-portlet__head">
            <div class="kt-portlet__head-label">
                <h3 class="kt-portlet__head-title">Settings Attendance</h3>
            </div>
            <div class="kt-portlet__head-toolbar">
                <ul class="nav nav-tabs nav-tabs-bold nav-tabs-line nav-tabs-line-right nav-tabs-line-brand" role="tablist">
                    <!-- <li class="nav-item">
                        <a class="nav-link active" data-toggle="tab" href="#kt_tabs_4_1" role="tab">
                            Schedule
                        </a>
                    </li> -->
                    <!-- <li class="nav-item">
                        <a class="nav-link active" data-toggle="tab" href="#kt_tabs_4_2" role="tab">
                            Shift
                        </a>
                    </li> -->
                    <!-- <li class="nav-item">
                        <a class="nav-link" data-toggle="tab" href="#kt_tabs_4_3" role="tab">
                            Break
                        </a>
                    </li> -->
                </ul>
            </div>
        </div>
        <div class="kt-portlet__body p-0">
            <div class="tab-content">
                <div class="tab-pane" id="kt_tabs_4_1" role="tabpanel">
                    <div class="kt-portlet kt-portlet--mobile box-shadow-none bg-transparent m-0">
                        <div class="kt-portlet__head bg-transparent box-shadow-none kt-portlet__head--lg border-0">
                            <div class="kt-portlet__head-label">
                                <span class="kt-portlet__head-icon">
                                    <i class="kt-font-brand flaticon2-line-chart"></i>
                                </span>
                                <h3 class="kt-portlet__head-title">
                                    Schedule
                                </h3>
                            </div>
                            <div class="kt-portlet__head-toolbar">
                                <div class="kt-portlet__head-wrapper">
                                    <div class="kt-portlet__head-actions">
                                        <a href="{{ route('attendance.create')}}" class="btn btn-brand btn-elevate btn-icon-sm">
                                            <i class="la la-plus"></i>
                                            Add Schedule
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="kt-portlet__body pt-0">
                            <!--begin: Datatable -->
                            <table class="table table-sm table-striped table-bordered table-checkable kt_table_11">
                                <thead>
                                    <tr>
                                        <th></th>
                                        <th>Name</th>
                                        <th>Effective date</th>
                                        <th>Shift</th>
                                        <th>Default</th>
                                        <th>Assigned to</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td></td>
                                        <td><a href="#" class="kt-link kt-font-bold" data-toggle="modal" data-target="#kt_modal_1a">CAFE 4</a></td>
                                        <td>1 Jan 2021</td>
                                        <td>7 shift(s)</td>
                                        <td>
                                            <span class="kt-switch kt-switch--outline kt-switch--icon kt-switch--success kt-switch--sm">
                                                <label>
                                                    <input type="checkbox" checked="checked" name="">
                                                    <span></span>
                                                </label>
                                            </span>
                                        </td>
                                        <td>
                                            <a href="#" class="kt-link kt-font-bold" data-toggle="modal" data-target="#kt_modal_1">53 employee(s)</a>
                                        </td>
                                        <td>
                                            <a href="#" class="btn btn-sm btn-linkedin btn-icon btn-icon-md" data-toggle="kt-tooltip" data-placement="top" title="sasa" data-original-title="cannot edit, shift already used in other schedule/already used for live attendance">
                                                <i class="la la-edit"></i>
                                            </a>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td></td>
                                        <td>
                                            <a href="#" class="kt-link kt-font-bold" data-toggle="modal" data-target="#kt_modal_1a">CAFE 5</a>
                                        </td>
                                        <td>1 Jan 2021</td>
                                        <td>7 shift(s)</td>
                                        <td>
                                            <span class="kt-switch kt-switch--outline kt-switch--icon kt-switch--success kt-switch--sm">
                                                <label>
                                                    <input type="checkbox" name="">
                                                    <span></span>
                                                </label>
                                            </span>
                                        </td>
                                        <td>
                                            <a href="#" class="kt-link kt-font-bold" data-toggle="modal" data-target="#kt_modal_1">5 employee(s)</a>
                                        </td>
                                        <td>
                                            <a href="#" class="btn btn-sm btn-linkedin btn-icon btn-icon-md" title="View">
                                                <i class="la la-edit"></i>
                                            </a>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                            <!--end: Datatable -->
                        </div>
                    </div>
                </div>
                <div class="tab-pane active" id="kt_tabs_4_2" role="tabpanel">
                    <div class="kt-portlet kt-portlet--mobile box-shadow-none bg-transparent m-0">
                        <div class="kt-portlet__head bg-transparent box-shadow-none kt-portlet__head--lg border-0">
                            <div class="kt-portlet__head-label">
                                <span class="kt-portlet__head-icon">
                                    <i class="kt-font-brand flaticon2-line-chart"></i>
                                </span>
                                <h3 class="kt-portlet__head-title">
                                    Shift
                                </h3>
                            </div>
                            <div class="kt-portlet__head-toolbar">
                                <div class="kt-portlet__head-wrapper">
                                    <div class="kt-portlet__head-actions">
                                        <a href="javascript:;" data-toggle="modal" @click="clearForm" data-target="#modal-add-shift" class="btn btn-brand btn-elevate btn-icon-sm">
                                            <i class="la la-plus"></i>
                                            Add Shift
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="kt-portlet__body pt-0">
                            <!--begin: Datatable -->
                            <table class="table table-sm table-striped table-bordered table-hover table-checkable" id="table-shift">
                                <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>Working hour</th>
                                        <th>Break hour</th>
                                        <th>Overtime before</th>
                                        <th>Overtime after</th>
                                        <th>Show in request</th>
                                        <th>Assigned</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="(shift, index) in shifts">
                                        <td v-text="shift.name"></td>
                                        <td v-text="shift.working_hour"></td>
                                        <td v-text="shift.break_hour"></td>
                                        <td v-text="shift.overtime_before"></td>
                                        <td v-text="shift.overtime_after"></td>
                                        <td>
                                            <span class="kt-switch kt-switch--outline kt-switch--icon kt-switch--success kt-switch--sm">
                                                <label>
                                                    <input v-model="shift.show_in_request" @click="onSwitchButton(index, shift.show_in_request)" type="checkbox">
                                                    <span></span>
                                                </label>
                                            </span>
                                        </td>
                                        <td>
                                            <a href="#" class="kt-link kt-font-bold" data-toggle="modal" data-target="#assignEmployee" @click="assignEmployee(shift.id)" v-text="shift.assigned + (shift.assigned <= 1?' Employee':' Employees')"></a>
                                        </td>
                                        <td>
                                            <button :data-toggle="shift.assigned>0?'kt-tooltip':'modal'" data-target="#modal-add-shift" @click="editShift(index)" class="btn btn-sm btn-linkedin btn-icon btn-icon-md mr-2" :class="shift.assigned>0?'tooltip-edit disabled':''" :class="shift.assigned>0?'disabled':''" data-placement="left" title="" data-original-title="You can't edit, this shift already assigned">
                                                <i class="la la-edit"></i>
                                            </button>
                                            <button :data-toggle="shift.assigned>0?'kt-tooltip':'modal'" data-target="#modal-delete-shift" @click="id = shift.id" class="btn btn-sm btn-danger btn-icon btn-icon-md" :class="shift.assigned>0?'tooltip-edit disabled':''" :class="shift.assigned>0?'disabled':''" data-placement="left" title="" data-original-title="You can't delete, this shift already assigned">
                                                <i class="la la-trash"></i>
                                            </button>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                            <!--end: Datatable -->
                        </div>
                    </div>
                </div>
                <div class="tab-pane" id="kt_tabs_4_3" role="tabpanel">
                    <div class="kt-portlet kt-portlet--mobile box-shadow-none bg-transparent m-0">
                        <div class="kt-portlet__head bg-transparent box-shadow-none kt-portlet__head--lg border-0">
                            <div class="kt-portlet__head-label">
                                <span class="kt-portlet__head-icon">
                                    <i class="kt-font-brand flaticon2-line-chart"></i>
                                </span>
                                <h3 class="kt-portlet__head-title">
                                    Break
                                </h3>
                            </div>
                            <div class="kt-portlet__head-toolbar">
                                <div class="kt-portlet__head-wrapper">
                                    <div class="kt-portlet__head-actions">
                                        <a href="javascript:;" data-toggle="modal" data-target="#kt_modal_4" class="btn btn-brand btn-elevate btn-icon-sm">
                                            <i class="la la-plus"></i>
                                            Add Break
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="kt-portlet__body pt-0">
                            <!--begin: Datatable -->
                            <table class="table table-sm table-striped- table-bordered table-hover table-checkable kt_table_11">
                                <thead>
                                    <tr>
                                        <th></th>
                                        <th>Name</th>
                                        <th>Created date</th>
                                        <th>Break</th>
                                        <th>Assigned to</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                            <!--end: Datatable -->
                        </div>
                    </div>
                    
                </div>
            </div>
        </div>
    </div>

    {{-- Modal Assigned employee --}}
    <div class="modal fade" id="assignEmployee" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Assigned employee(s)</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    </button>
                </div>
                <div class="modal-body pt-2">
                    <table class="table table-striped- table-bordered m-0 kt_table_1" >
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Job position</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="employee in assigned_employees">
                                <td v-text="employee.id"></td>
                                <td v-text="employee.full_name"></td>
                                <td v-text="employee.job_position_name"></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
    {{-- Modal Schedule preview --}}
    <div class="modal fade" id="kt_modal_1a" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Employee Preview</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row mb-3">
                        <div class="col-lg-3">
                            <h6>Nama</h6>
                        </div>
                        <div class="col-lg-9 mb-3 mb-lg-0">
                            <h6 class="font-weight-light kt-font-transform-u">PROGRAMMER</h6>
                        </div>
                        <div class="col-lg-3">
                            <h6>Effective date</h6>
                        </div>
                        <div class="col-lg-9 mb-3 mb-lg-0">
                            <h6 class="font-weight-light">1 Jan 2022</h6>
                        </div>
                        <div class="col-lg-3">
                            <h6>Settings</h6>
                        </div>
                        <div class="col-lg-9">
                            <ul class="m-0 pl-4">
                                <li>Override national holiday</li>
                                <li>Override company holiday</li>
                                <li>Include late in</li>
                                <li>Flexible</li>
                            </ul>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-sm table-striped- table-bordered m-0" >
                            <thead>
                                <tr>
                                    <th>Shift</th>
                                    <th>Working hour</th>
                                    <th>Break</th>
                                    <th>OT before</th>
                                    <th>OT after</th>
                                    <th>Additional break</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>P</td>
                                    <td>10:00-20:00</td>
                                    <td>12:00-13:00</td>
                                    <td>00:00</td>
                                    <td>00:00</td>
                                    <td>-</td>
                                </tr>
                                <tr>
                                    <td>dayoff</td>
                                    <td>-</td>
                                    <td>-</td>
                                    <td>00:00</td>
                                    <td>00:00</td>
                                    <td>-</td>
                                </tr>
                                <tr>
                                    <td>dayoff</td>
                                    <td>-</td>
                                    <td>-</td>
                                    <td>00:00</td>
                                    <td>00:00</td>
                                    <td>-</td>
                                </tr>
                                <tr>
                                    <td>P</td>
                                    <td>10:00-20:00</td>
                                    <td>12:00-13:00</td>
                                    <td>00:00</td>
                                    <td>00:00</td>
                                    <td>-</td>
                                </tr>
                                <tr>
                                    <td>P</td>
                                    <td>10:00-20:00</td>
                                    <td>12:00-13:00</td>
                                    <td>00:00</td>
                                    <td>00:00</td>
                                    <td>-</td>
                                </tr>
                                <tr>
                                    <td>P</td>
                                    <td>10:00-20:00</td>
                                    <td>12:00-13:00</td>
                                    <td>00:00</td>
                                    <td>00:00</td>
                                    <td>-</td>
                                </tr>
                                <tr>
                                    <td>P</td>
                                    <td>10:00-20:00</td>
                                    <td>12:00-13:00</td>
                                    <td>00:00</td>
                                    <td>00:00</td>
                                    <td>-</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary">Save changes</button>
                </div>
            </div>
        </div>
    </div>
    {{-- Modal Shift preview --}}
    <div class="modal fade" id="kt_modal_2" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Schedule preview</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    </button>
                </div>
                <div class="modal-body pt-0">
                    <table class="table table-striped- table-bordered m-0 kt_table_1" >
                        <thead>
                            {{-- <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Job position</th>
                            </tr> --}}
                            <tr>
                                <th>Schedule name</th>
                                <th>Effective date</th>
                                <th>Shift(s)</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>AUDIT 3</td>
                                <td>1 Jan 2021</td>
                                <td>7 shifts</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary">Save changes</button>
                </div>
            </div>
        </div>
    </div>

    {{-- Modal New Shift --}}
	<div class="modal fade" id="modal-add-shift" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel" v-text="id==''?'Add shift':'Edit shift'"></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    </button>
                </div>
                <form class="kt-form" action="" @submit="storeShift">
					<div class="modal-body">

						<div class="form-group">
							<label>Name <span class="text-danger">*</span></label>
							<input type="text" v-model="shift_name" class="form-control" :class="shift_name_error?'is-invalid':''" placeholder="Enter name">
							<div  v-text="shift_name_error" class="invalid-feedback"></div>
						</div>
						<div class="form-group">
							<div class="kt-checkbox-inline">
								<label class="kt-checkbox kt-checkbox--success">
									<input v-model="show_in_request" type="checkbox"> Show in request
									<span></span>
								</label>
							</div>
						</div>
						<div class="form-group row">
							<div class="col-lg-6">
								<label>Schedule in <span class="text-danger">*</span></label>
								<div class="input-group timepicker">
									<time-picker type="text" v-model="schedule_in" class="form-control kt_timepicker" :class="schedule_in_error?'is-invalid':''" placeholder="00:00"></time-picker>
									<div class="input-group-append">
										<span class="input-group-text">
											<i class="la la-clock-o"></i>
										</span>
									</div>
								</div>
								<div v-text="schedule_in_error" class="invalid-feedback d-block"></div>
							</div>
							<div class="col-lg-6">
								<label>Schedule out <span class="text-danger">*</span></label>
								<div class="input-group">
									<time-picker type="text" v-model="schedule_out" class="form-control kt_timepicker" :class="schedule_out_error?'is-invalid':''" placeholder="00:00"></time-picker>
									<div class="input-group-append">
										<span class="input-group-text">
											<i class="la la-clock-o"></i>
										</span>
									</div>
								</div>
								<div v-text="schedule_out_error" class="invalid-feedback d-block"></div>
							</div>
						</div>
						<div class="form-group">
							<div class="kt-checkbox-inline">
								<label class="kt-checkbox kt-checkbox--success">
									<input v-model="grace" type="checkbox" class="grace"> Add grace period
									<span></span>
								</label>
							</div>
						</div>
						<div class="form-group row" id="grace" style="display:none">
							<div class="col-lg-6">
								<label>Clock in dispensation</label>
								<div class="input-group timepicker">
									<input v-model="clock_in_dispensation" type="number" class="form-control" maxlength="5" placeholder="Duration" aria-describedby="basic-addon2">
									<div class="input-group-append"><span class="input-group-text" id="basic-addon2">Minutes</span></div>
								</div>
							</div>
							<div class="col-lg-6">
								<label>Clock out dispensation</label>
								<div class="input-group timepicker">
									<input v-model="clock_out_dispensation" type="number" class="form-control" maxlength="5" placeholder="Duration" aria-describedby="basic-addon2">
									<div class="input-group-append"><span class="input-group-text" id="basic-addon2">Minutes</span></div>
								</div>
							</div>
						</div>
						<div class="form-group row">
							<div class="col-lg-6">
								<label>Break start <span class="text-danger">*</span></label>
								<div class="input-group timepicker">
									<time-picker v-model="break_start" class="form-control kt_timepicker" :class="break_start_error?'is-invalid':''" placeholder="00:00"></time-picker>
									<div class="input-group-append">
										<span class="input-group-text">
											<i class="la la-clock-o"></i>
										</span>
									</div>
								</div>
								<div v-text="break_start_error" class="invalid-feedback d-block"></div>
							</div>
							<div class="col-lg-6">
								<label>Break end <span class="text-danger">*</span></label>
								<div class="input-group timepicker">
									<time-picker v-model="break_end" class="form-control kt_timepicker" :class="break_end_error?'is-invalid':''" placeholder="00:00"></time-picker>
									<div class="input-group-append">
										<span class="input-group-text">
											<i class="la la-clock-o"></i>
										</span>
									</div>
								</div>
								<div v-text="break_end_error" class="invalid-feedback d-block"></div>
							</div>
						</div>
						<div class="form-group">
							<div class="kt-checkbox-inline">
								<label class="kt-checkbox kt-checkbox--success">
									<input v-model="enable_overtime" type="checkbox" class="overtime"> Enable auto overtime
									<span></span>
								</label>
							</div>
						</div>
						<div class="form-group row" id="overtime" style="display:none">
							<div class="col-lg-6">
								<label>Overtime before</label>
								<div class="input-group timepicker">
									<time-picker v-model="overtime_before" class="form-control kt_timepicker" placeholder="00:00"></time-picker>
									<div class="input-group-append">
										<span class="input-group-text">
											<i class="la la-clock-o"></i>
										</span>
									</div>
								</div>
							</div>
							<div class="col-lg-6">
								<label>Overtime after</label>
								<div class="input-group timepicker">
								<time-picker v-model="overtime_after" class="form-control kt_timepicker" placeholder="00:00"></time-picker>
									<div class="input-group-append">
										<span class="input-group-text">
											<i class="la la-clock-o"></i>
										</span>
									</div>
								</div>
							</div>
						</div>
						<!-- <div class="form-group">
							<div class="kt-checkbox-inline">
								<label class="kt-checkbox kt-checkbox--success">
									<input type="checkbox" class="break"> Add break time
									<span></span>
								</label>
							</div>
						</div> -->
						<!-- <div class="form-group" id="break" style="display:none">
							<label>Additional break*</label>
							<div class="form-group">
								<select class="form-control kt-select2" >
									<option value="1">dayoff</option>
									<option value="2">CRM2</option>
									<option value="3">PROGRAMMER</option>
								</select>
							</div>
						</div> -->
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
						<button type="submit" class="btn btn-primary" :class="is_loading_add_shift?'kt-spinner kt-spinner--sm kt-spinner--danger':''">Submit</button>
					</div>
				</form>    
            </div>
        </div>
	</div>

    {{-- Modal Delete Shift --}}
	<div class="modal fade" id="modal-delete-shift" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Confirmation</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    </button>
                </div>
                <div class="modal-body">
                    Shift will be deleted. Are you sure?    
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary" :class="is_loading_delete_shift?'kt-spinner kt-spinner--sm kt-spinner--danger':''" @click="deleteShift">Yes, Delete now</button>
                </div>    
            </div>
        </div>
	</div>

    {{-- Modal New Break --}}
	<div class="modal fade" id="kt_modal_4" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Add break</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    </button>
                </div>
                <form action="">
                    <div class="modal-body">
                        <div class="form-group">
                            <label>Name*</label>
                            <input type="text" class="form-control" placeholder="Enter name">
                        </div>
                        <div class="d-flex align-items-center">
                            <div class="col-lg-6 p-0">
                                <label class="m-0">Schedule break start</label>
                            </div>
                            <div class="col-lg-6 p-0">
                                <label class="m-0">Schedule break end</label>
                            </div>
                        </div>
                        <div class="d-flex align-items-center mb-2">
                            <div class="input-group date">
                                <input type="text" class="form-control form-control-sm kt_datetimepicker_7" placeholder="00:00" />
                                <div class="input-group-append">
                                    <span class="input-group-text">
                                        <i class="la la-clock-o"></i>
                                    </span>
                                </div>
                            </div>
                            <div class="px-2">
                                -
                            </div>
                            <div class="input-group date pr-2">
                                <input type="text" class="form-control form-control-sm kt_datetimepicker_7" placeholder="00:00" />
                                <div class="input-group-append">
                                    <span class="input-group-text">
                                        <i class="la la-clock-o"></i>
                                    </span>
                                </div>
                            </div>
                            <div class="invisible">
                                <a href="javascript:void(0);" class="btn btn-remove btn-sm btn-label-google btn-icon btn-icon-md" title="Remove">
                                    <i class="la la-trash"></i>
                                </a>
                            </div>
                        </div>
                        <div class="dynamic-form">

                        </div>
                        <a href="javascript:;" class="border-0 px-0 btn-add btn btn-sm btn-outline-hover-brand btn-elevate btn-icon-sm">
                            <i class="la la-plus"></i>
                            Add Break
                        </a>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save changes</button>
                    </div>
                </form>
            </div>
        </div>
	</div>
</div>
@endsection
@push('scriptjs')
<script>

	//create tag html
	Vue.component('date-picker',{
		template: `<input type="date" v-datepicker class="form-control" readonly :value="value" @input="update($event.target.value);">`,
		directives: {
			datepicker: {
				inserted (el, binding, vNode) {
					$(el).datepicker({
						autoclose: true,
						format: 'yyyy-mm-dd'
					}).on('changeDate',function(e){
						vNode.context.$emit('input', e.format(0))
						vNode.context.$emit('change', e.format(0))
					})
				}
			}
		},
		props: ['value'],
		methods: {
			update (v){
				this.$emit('input', v)
			}
		}
	});

	Vue.component('time-picker',{
		template: `<input type="text" v-timepicker readonly :value="value" @input="update($event.target.value);">`,
		directives: {
			timepicker: {
				inserted (el, binding, vNode) {
					setTimeout(() => {
						$(el).timepicker({
							timeFormat : 'HH:mm',
							minuteStep: 1,
							defaultTime: '',
							showSeconds: false,
							showMeridian: false,
							snapToStep: false,
							dynamic : true
						}).on('change',function(e){
							vNode.context.$emit('input', e.target.value)
							vNode.context.$emit('change', e.target.value)
						});
					}, 0);
				}
			}
		},
		props: ['value'],
		methods: {
			update (v){
				this.$emit('input', v)
			}
		}
	});

	const vm = new Vue({
		el: '#App',
		data:{
			shifts : [],
			shiftOption : [],
            grace : false,
            enable_overtime : false,
            id : '',
			shift_name : '',
			shift_name_error : '',
			schedule_in : '',
			schedule_in_error : '',
			schedule_out : '',
			schedule_out_error : '',
			break_start : '',
			break_start_error : '',
			break_end : '',
			break_end_error : '',
			overtime_before : null,
			overtime_before_error : '',
			overtime_after : null,
			overtime_after_error : '',
			clock_in_dispensation : null,
			clock_in_dispensation_error : '',
			clock_out_dispensation : null,
			clock_out_dispensation_error : '',
			show_in_request : false,
			is_loading_add_shift : false,
            is_loading_delete_shift : false,
            assigned_employees : []
		},
		methods : {
			storeShift(e){
				e.preventDefault();

				if(this.is_loading_add_shift){
					//hold execution
					return;
				}

				//init
				var isErr = false;

				//clean error
				this.shift_name_error = '';
				this.schedule_in_error = '';
				this.schedule_out_error = '';
				this.break_start_error = '';
				this.break_end_error = '';

				//validation
				if(!this.shift_name){
					this.shift_name_error = 'Shift Name is required';
					isErr = true;
				}

				if(!this.schedule_in){
					this.schedule_in_error = 'Schedule In is required';
					isErr = true;
				}

				if(!this.schedule_out){
					this.schedule_out_error = 'Schedule Out is required';
					isErr = true;
				}

				if(!this.break_start){
					this.break_start_error = 'Break Start is required';
					isErr = true;
				}

				if(!this.break_end){
					this.break_end_error = 'Break End is required';
					isErr = true;
				}

				if(isErr){
					//stop
					return;
				}

				//loading
				this.is_loading_add_shift = true;

				let body = {
                    id : this.id,
                    name : this.shift_name,
                    schedule_in : this.schedule_in,
                    schedule_out : this.schedule_out,
                    break_start : this.break_start,
                    break_end : this.break_end,
                    overtime_before : this.overtime_before,
                    overtime_after : this.overtime_after,
                    show_in_request : this.show_in_request?1:0,
                    clock_in_dispensation : this.clock_in_dispensation,
                    clock_out_dispensation : this.clock_out_dispensation
                };

				//send
				fetch(`{{route('setting.attendance.store-shift')}}`, {
					method: 'post',
					headers: {
						'Content-Type' : 'application/json',
						'X-CSRF-Token' : $('meta[name="csrf-token"]').attr('content')
					},
					body: JSON.stringify(body)
				}).then(async (responseTxt) => {
					
					const response = await responseTxt.json(responseTxt);
					//stop loading
					this.is_loading_add_shift = false;
					
					if(response.status == '200'){
						//success response

                        this.showAlert('Success', response.message, 'success');

                        if(this.id == ''){
                            //clear form
                            this.clearForm();
                        }

						//refresh shift data
						this.getShifts();
					}else{
						//error response
						this.showAlert('Failed', response.message, 'danger')
					}
				}).catch(async (error) => {
					//stop loading
					this.is_loading_add_shift = false;
					//error response
					this.showAlert('Failed', error.message, 'danger')
				})
			},
            clearForm(){

                this.id = '';
                this.shift_name = '';
                this.schedule_in = '';
                this.schedule_out = '';
                this.break_start = '';
                this.break_end = '';
                this.overtime_before = '';
                this.overtime_after = '';
                this.show_in_request = false;
                this.clock_in_dispensation = '';
                this.clock_out_dispensation = '';
                this.grace = false;
                this.enable_overtime = false;
                $('.kt_timepicker').timepicker('setTime', '');
                $("#grace").toggle(false);
                $("#overtime").toggle(false);

            },
			getShifts(callback){

				//send
				fetch(`{{route('setting.attendance.getshifts')}}`, {
					method: 'post',
					headers: {
						'Content-Type' : 'application/json',
						'X-CSRF-Token' : $('meta[name="csrf-token"]').attr('content')
					}
				}).then(async (responseTxt) => {
					
					const response = await responseTxt.json(responseTxt);
					
					if(response.status == '200'){
						//success response
                        this.shifts = response.data;
					}else{
						//error response
						this.add_shift_error_alert = response.message;
					}

                    callback && callback()
				}).catch(async (error) => {
					//error response
                    callback && callback()
				})

			},
            onSwitchButton(i, show_in_request_old){

                let show_in_request;

                if(!(this.shifts[i].show_in_request == 1 || this.shifts[i].show_in_request == true)){
                    show_in_request = 1;
                }else{
                    show_in_request = 0;
                }

                //send
				fetch(`{{route('setting.attendance.set-show-in-request')}}`, {
					method: 'post',
					headers: {
						'Content-Type' : 'application/json',
						'X-CSRF-Token' : $('meta[name="csrf-token"]').attr('content')
					},
					body: JSON.stringify({
                        show_in_request : show_in_request,
                        shift_id : this.shifts[i].id
                    })
				}).then(async (responseTxt) => {
					
					const response = await responseTxt.json(responseTxt);
					
					if(response.status == 200){
						//success response
                        this.showAlert('Success', response.message, 'success');
					}else{
						//error response

                        //rollback to old value
                        this.shifts[i].show_in_request = show_in_request_old;
                        this.showAlert('Failed', response.message, 'danger');
					}
                    
				}).catch(async (error) => {
					//error response

                    //rollback to old value
                    this.shifts[i].show_in_request = show_in_request_old;

                    this.showAlert('Failed', error.message, 'danger');

				})
            },
            showAlert(title="", message="", type="success"){
                var content = {};

                content.message = message;
                content.title = title;

                if (type == 'success') {
                    content.icon = 'icon ' + 'flaticon2-check-mark';
                }else if(type == 'error'){
                    content.icon = 'icon ' + 'flaticon-exclamation-2';
                }

                $.notify(content, { 
                    type: type,
                    allow_dismiss: true,
                    newest_on_top: true,
                    mouse_over:  true,
                    showProgressbar:  false,
                    spacing: 10,                    
                    timer: 3000,
                    placement: {
                        from: 'top', 
                        align: 'right'
                    },
                    offset: {
                        x: 30, 
                        y: 30
                    },
                    delay: 1000,
                    z_index: 10000,
                    animate: {
                        enter: 'animated slideInLeft',
                        exit: 'animated slideInLeft'
                    }
                });
            },
            assignEmployee(shift_id){
                //send
				fetch(`{{route('setting.attendance.assign-employee')}}`, {
					method: 'post',
					headers: {
						'Content-Type' : 'application/json',
						'X-CSRF-Token' : $('meta[name="csrf-token"]').attr('content')
					},
					body: JSON.stringify({
                        shift_id : shift_id
                    })
				}).then(async (responseTxt) => {
					
					const response = await responseTxt.json(responseTxt);
					
					if(response.status == 200){
						//success response
                        this.assigned_employees = response.data;

                        setTimeout(() => {
                            $('.kt_table_1').DataTable()
                        }, 0);
					}else{
						//error response
                        this.showAlert('Failed', 'When get assigned employee', 'danger');
					}
                    
				}).catch(async (error) => {
					//error response
                    this.showAlert('Failed', 'When get assigned employee', 'danger');
				})
            },
            editShift(index){

                this.clearForm();

                setTimeout(() => {
                    this.id = this.shifts[index].id;
                    this.shift_name = this.shifts[index].name; 
                    this.schedule_in = this.shifts[index].working_hour_start; 
                    this.schedule_out = this.shifts[index].working_hour_end; 
                    this.break_start = this.shifts[index].break_start; 
                    this.break_end = this.shifts[index].break_end; 
                    this.overtime_before = this.shifts[index].overtime_before; 
                    this.overtime_after = this.shifts[index].overtime_after; 
                    this.clock_in_dispensation = this.shifts[index].clock_in_dispensation; 
                    this.clock_out_dispensation = this.shifts[index].clock_out_dispensation; 
                    this.show_in_request = this.shifts[index].show_in_request; 

                    if(this.shifts[index].clock_in_dispensation != null || this.shifts[index].clock_out_dispensation != null){
                        this.grace = true;
                        $("#grace").toggle();
                    }

                    if(this.shifts[index].overtime_before != null || this.shifts[index].overtime_after != null){
                        this.enable_overtime = true;
                        $("#overtime").toggle();
                    }
                }, 0);

            },
            deleteShift(){

                //start loading
                this.is_loading_delete_shift = true;

                //send
				fetch(`{{route('setting.attendance.delete-shift')}}`, {
					method: 'post',
					headers: {
						'Content-Type' : 'application/json',
						'X-CSRF-Token' : $('meta[name="csrf-token"]').attr('content')
					},
					body: JSON.stringify({
                        id : this.id
                    })
				}).then(async (responseTxt) => {
                    
                    //stop loading
					this.is_loading_delete_shift = false;

					const response = await responseTxt.json(responseTxt);
					
					if(response.status == 200){
						//success response
                        this.showAlert('Success', response.message, 'success');

                        //refresh shift data
                        this.getShifts();

                        //hide modal
                        $('#modal-delete-shift').modal('hide');
					}else{
						//error response
                        this.showAlert('Failed', 'When delete shift', 'danger');
					}
                    
				}).catch(async (error) => {
					//error response
                    
                    //stop loading
					this.is_loading_delete_shift = false;

                    this.showAlert('Failed', 'When delete shift', 'danger');
				})
            },
            initJquery(){
                this.table = $('#table-shift').DataTable({
                    drawCallback: function() {
                        $(".dataTables_paginate > .pagination").addClass("pagination-rounded");  
                    },
                    scrollX: true,
                    bStateSave: true,
                    select: false,
                    serverSide: false,
                    processing: false,
                    paging: true,
                    pagingType: 'simple_numbers',
                })

                $('.tooltip-edit').tooltip();
            },
		},
        watch: {
            // whenever question changes, this function will run
            shifts(shiftsNew, shiftsOld) {

                if(this.table != null){
                    this.table.destroy();

                    setTimeout(() => {
                        this.initJquery();
                    }, 0);
                }

            }
        },
		mounted(){
			$('.kt-select2').select2().on('change', this.onChangeShift);

            //load shifts
			this.getShifts(()=>{
                setTimeout(() => {
                    this.initJquery();
                }, 0);
            });
		}
	});
	</script>
    <script>
        $('.btn-add').click(function(){
            $('.dynamic-form').append(`<div class="d-flex align-items-center mb-2">
                            <div class="input-group date">
                                <input type="text" class="form-control form-control-sm kt_datetimepicker_7" placeholder="00:00" />
                                <div class="input-group-append">
                                    <span class="input-group-text">
                                        <i class="la la-clock-o"></i>
                                    </span>
                                </div>
                            </div>
                            <div class="px-2">
                                -
                            </div>
                            <div class="input-group date pr-2">
                                <input type="text" class="form-control form-control-sm kt_datetimepicker_7" placeholder="00:00" />
                                <div class="input-group-append">
                                    <span class="input-group-text">
                                        <i class="la la-clock-o"></i>
                                    </span>
                                </div>
                            </div>
                            <div>
                                <a href="javascript:void(0);" class="btn btn-remove btn-sm btn-label-google btn-icon btn-icon-md" title="Remove">
                                    <i class="la la-trash"></i>
                                </a>
                            </div>
                        </div>`)

            $('.kt_datetimepicker_7').datetimepicker({
                format: "hh:ii",
                todayHighlight: true,
                autoclose: true,
                startView: 1,
                minView: 0,
                maxView: 1,
                forceParse: 0,
                pickerPosition: 'bottom-left',
                language: moment.locale('id')
            });
        });

        $('.dynamic-form').on('click', '.btn-remove', function () {
            $(this).parent().parent().remove()
        });

        var KTDatatablesBasicBasic1 = (function () {
            var initTable1 = function () {
                var table = $(".kt_table_11");
                // begin first table
                table.DataTable({
                    responsive: true,
                    lengthMenu: [5, 10, 25, 50],
                    pageLength: 5,
                    language: {
                        lengthMenu: "Display _MENU_",
                    },
                    autoWidth: true,
                    // Order settings
                    order: [[1, "desc"]],
                    headerCallback: function (thead, data, start, end, display) {
                        thead.getElementsByTagName("th")[0].innerHTML = `
                            <label class="kt-checkbox kt-checkbox--single kt-checkbox--solid">
                                <input type="checkbox" value="" class="kt-group-checkable">
                                <span></span>
                            </label>`;
                    },
                    columnDefs: [
                        {
                            targets: 0,
                            autoWidth: true,
                            width: '30px',
                            className: 'dt-right',
                            orderable: false,
                            render: function(data, type, full, meta) {
                                return `
                                <label class="kt-checkbox kt-checkbox--single kt-checkbox--solid">
                                    <input type="checkbox" value="" class="kt-checkable">
                                    <span></span>
                                </label>`;
                            },
                        },
                    ],
                });
                table.on("change", ".kt-group-checkable", function () {
                    var set = $(this)
                        .closest("table")
                        .find("td:first-child .kt-checkable");
                    var checked = $(this).is(":checked");

                    $(set).each(function () {
                        if (checked) {
                            $(this).prop("checked", true);
                            $(this).closest("tr").addClass("active");
                        } else {
                            $(this).prop("checked", false);
                            $(this).closest("tr").removeClass("active");
                        }
                    });
                });
                table.on("change", "tbody tr .kt-checkbox", function () {
                    $(this).parents("tr").toggleClass("active");
                });
            };

            return {
                //main function to initiate the module
                init: function () {
                    initTable1();
                },
            };
        })();
        jQuery(document).ready(function () {
            KTDatatablesBasicBasic1.init();
        });

        var KTDatatablesBasicBasic = function() {
            var initTable1 = function() {
                
            };
            return {
                //main function to initiate the module
                init: function() {
                    initTable1();
                },

            };
        }();
        jQuery(document).ready(function() {
            KTDatatablesBasicBasic.init();
        });

        $( document ).ready(function() {
            $('.kt-select2').select2();
        });

        $('.kt_datetimepicker_7').datetimepicker({
            format: "hh:ii",
            todayHighlight: true,
            autoclose: true,
            startView: 1,
            minView: 0,
            maxView: 1,
            forceParse: 0,
            pickerPosition: 'bottom-left',
            language: moment.locale('id')
        });

        if(document.querySelector('.grace').checked ? $("#grace").show() : $("#grace").hide())
        $('.grace').click(function() { $("#grace").toggle(this.checked); });
        // if(document.querySelector('.break').checked ? $("#break").show() : $("#break").hide())
        // $('.break').click(function() { $("#break").toggle(this.checked); });
        if(document.querySelector('.overtime').checked ? $("#overtime").show() : $("#overtime").hide())
        $('.overtime').click(function() { $("#overtime").toggle(this.checked);});
    </script>
@endpush
