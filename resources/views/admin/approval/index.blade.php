@extends('layout-admin.base', [
    'pages' => 'Setting Approval List',
    'subpages' => 'Setting Approval List',
])

@push('css')
<style>
    .dt-right{
        width: 1% !important;
    }

    .btn:focus, .btn.focus {
        outline: 0;
        -webkit-box-shadow: none !important;
        box-shadow: none !important;
    }

    .table th, .table td {
        vertical-align: middle;
    }
    .select2-container {
        display: block;
				width: 100%;
    }

		.kt-font-secondary{
			color: #cbcbcb !important;
		}
</style>            
@endpush
@section('content')
    <div class="kt-portlet">
        <div class="kt-portlet__head">
            <div class="kt-portlet__head-label">
                <h3 class="kt-portlet__head-title">Approval List</h3>
            </div>
            <div class="kt-portlet__head-toolbar">
                <a href="#" class="btn btn-sm btn-secondary btn-elevate btn-icon-sm">
                    <i class="la la-download"></i>
                    Export Approve List
                </a>
            </div>
        </div>
		<div class="kt-portlet__body">
            <div class="row">
							<div class="col-lg-5 align-self-center">
								<div class="d-flex">
									<button class="btn btn-outline-success btn-elevate mr-3 btn-icon-sm">
											<i class="la la-check-circle"></i>
											Approve All Checked
									</button>
									<button class="btn btn-outline-danger btn-elevate btn-icon-sm">
											<i class="la la-times-circle"></i>
											Reject All Checked
									</button>
								</div>
							</div>
							<div class="col-lg">
								<!--begin: Filter -->
								<form action="">
									<div class="form-group row m-0 align-items-end">
										<label for="example-text-input" class="col-lg-auto col-form-label">Select Type</label>
										<div class="col-lg">
												<select class="form-control kt-select2" id="type" name="type">
													<option></option>
													<option>Attendance</option>
													<option>TimeOff</option>
													<option>Overtime</option>
													<option>Change Shift</option>
													<option>Payroll</option>
													<option>Delegation</option>
													<option>Reimbursement</option>
													{{-- <option>Change Data</option>
													<option>Cash Advance Request</option>
													<option>Cash Advance Settlement</option>
													<option>Add Employee</option>
													<option>Employee Transfer</option>
													<option>Goals</option> --}}
												</select>
										</div>
										<label for="example-text-input" class="col-lg-auto col-form-label">Select Month & Years</label>
										<div class="col-lg">
											<div class="input-group date">
												<input type="text" class="form-control" readonly value="{{date('m/Y')}}" id="kt_datetimepicker_3" />
												<div class="input-group-append">
													<span class="input-group-text">
														<i class="la la-calendar glyphicon-th"></i>
													</span>
												</div>
											</div>
										</div>
										<div class="col-lg-auto">
											<button type="submit" class="btn btn-outline-warning btn-elevate btn-icon-sm"><i class="la la-filter"></i>Filter</button>
										</div>
									</div>
								</form>
								<!--end: Filter -->
							</div>

							<div class="col-lg-12 mt-4">
								<!--begin: Datatable -->
								<table class="table table-striped- table-bordered table-hover table-checkable kt_table_1 nowrap">
										<thead>
											<tr>
												<th style="width: 1%">No</th>
												<th>Employee Id</th>
												<th>Employee Name</th>
												<th>Branch</th>
												<th>Organization</th>
												<th width="100">Job Level</th>
												<th>Job Position</th>
												<th>Type</th>
												<th>Status</th>
												<th width="100">Notes</th>
												<th>Description</th>
											</tr>
										</thead>
										<tbody>
											@if(!empty($employeeRequestAttendance))
												@foreach($employeeRequestAttendance as $dataRequestAttendance)
													@foreach($dataRequestAttendance->employeeRequestAttendance as $listRequestAttendance)
														@foreach($statusRequestAttendance as $valueStatusRequestAttendance)
															@if($valueStatusRequestAttendance->employee_request_attendance_id == $listRequestAttendance->id)
																<tr>
																	<td></td>
																	<td>{{@$dataRequestAttendance->employee_id}}</td>
																	<td><a href="#" class="kt-link" data-toggle="modal" data-target="#kt_modal_1">{{@$dataRequestAttendance->full_name}}</a></td>
																	<td>{{@$dataRequestAttendance->branch->name}}</td>
																	<td>{{@$dataRequestAttendance->organization->name}}</td>
																	<td>{{@$dataRequestAttendance->jobLevel->name}}</td>
																	<td>{{@$dataRequestAttendance->jobPosition->name}}</td>
																	<td>Attendance</td>
																	<td>{{$valueStatusRequestAttendance->status}}</td>
																	<td>{{$listRequestAttendance->note}}</td>
																	<td><div class="text-wrap">{{@$dataRequestAttendance->employee_id}} - {{@$dataRequestAttendance->full_name}}<br/> Requesting Attendance @if(!empty($listRequestAttendance->clock_in))<br/> Clock In : {{$listRequestAttendance->clock_in}} @endif @if(!empty($listRequestAttendance->clock_out)) <br/>Clock Out: {{$listRequestAttendance->clock_out}} @endif  <br>on {{\Carbon\carbon::parse($listRequestAttendance->date)->format('d F Y')}}</div></td>
																</tr>
															@else
															@endif
														@endforeach
													@endforeach
												@endforeach
											@endif
											@if(!empty($employeeRequestShift))
												@foreach($employeeRequestShift as $dataRequestShift)
													@foreach($dataRequestShift->employeeRequestShift as $valueStatusRequestShift)
													<tr>
														<td></td>
														<td>{{@$dataRequestShift->employee_id}}</td>
														<td><a href="#" class="kt-link" data-toggle="modal" data-target="#kt_modal_1">{{@$dataRequestShift->full_name}}</a></td>
														<td>{{@$dataRequestShift->branch->name}}</td>
														<td>{{@$dataRequestShift->organization->name}}</td>
														<td>{{@$dataRequestShift->jobLevel->name}}</td>
														<td>{{@$dataRequestShift->jobPosition->name}}</td>
														<td>Change Shift</td>
														<td>{{$valueStatusRequestShift->status}}</td>
														<td>{{$valueStatusRequestShift->notes}}</td>
														<td><div class="text-wrap">{{@$dataRequestShift->employee_id}} - {{@$dataRequestShift->full_name}}<br/> Requesting Shift @if(!empty($valueStatusRequestShift->effective_date)) <br/>Current Shift : {{$valueStatusRequestShift->current_shift}} @endif @if(!empty($valueStatusRequestShift->shift->name))<br/> New Shift: {{$valueStatusRequestShift->shift->name}} (in:{{$valueStatusRequestShift->shift->working_hour_start}} | out:{{$valueStatusRequestShift->shift->working_hour_end}}) @endif <br/> on {{\Carbon\carbon::parse($valueStatusRequestShift->effective_date)->format('d F Y')}}</div></td>
													</tr>
													@endforeach	
												@endforeach
											@endif
											@if(!empty($employeeRequestOvertime))
												@foreach($employeeRequestOvertime as $dataRequestOvertime)
													@foreach($dataRequestOvertime->employeeRequestOvertime as $listRequestOvertime)
														@foreach($statusRequestOvertime as $valueStatusRequestOvertime)
														@if($valueStatusRequestOvertime->overtime_request_id == $listRequestOvertime->id)
															<tr>
																<td></td>
																<td>{{@$dataRequestOvertime->employee_id}}</td>
																<td><a href="#" class="kt-link" data-toggle="modal" data-target="#kt_modal_1">{{@$dataRequestOvertime->full_name}}</a></td>
																<td>{{@$dataRequestOvertime->branch->name}}</td>
																<td>{{@$dataRequestOvertime->organization->name}}</td>
																<td>{{@$dataRequestOvertime->jobLevel->name}}</td>
																<td>{{@$dataRequestOvertime->jobPosition->name}}</td>
																<td>Overtime</td>
																<td>{{$valueStatusRequestOvertime->status}}</td>
																<td>{{$listRequestOvertime->notes}}</td>
																<td><div class="text-wrap">{{@$dataRequestOvertime->employee_id}} - {{@$dataRequestOvertime->full_name}}<br/> Requesting Overtime
																on {{\Carbon\carbon::parse($valueStatusRequestOvertime->date_request)->format('d F Y')}}</div></td>
															</tr>
															@else
															@endif
														@endforeach
													@endforeach
												@endforeach
											@endif
										</tbody>
								</table>
								<!--end: Datatable -->
							</div>
            </div>
        </div>
    </div>

		<!-- Modal Detail -->
    <div class="modal fade" id="kt_modal_1" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
				<div class="modal-dialog modal-lg" role="document">
						<div class="modal-content">
								<div class="modal-header">
										<h5 class="modal-title" id="exampleModalLabel">Request Detail</h5>
										<button type="button" class="close" data-dismiss="modal" aria-label="Close">
										</button>
								</div>
								<div class="modal-body">
									<!--begin: Datatable -->
									<table class="table table-striped- table-bordered table-hover kt_table_2 mt-0">
											<thead>
													<tr>
															<th>Approval</th>
															<th>Employee ID</th>
															<th>PIC</th>
															<th>Status</th>
															<th>Comment</th>
															<th>Decision By</th>
															<th>Updated Date</th>
													</tr>
											</thead>
											<tbody>
													<tr>
															<td>1</td>
															<td>DMY001</td>
															<td>Sintia</td>
															<td><span class="kt-badge kt-badge--success kt-badge--dot"></span>&nbsp;<span class="kt-font-bold kt-font-success">Approved</span></td>
															<td>-</td>
															<td>-</td>
															<td>2022-12-23 14:25:11</td>
													</tr>
													<tr>
															<td>2</td>
															<td>BOD009</td>
															<td>Akbar Syaputra</td>
															<td><span class="kt-badge kt-badge--warning kt-badge--dot"></span>&nbsp;<span class="kt-font-bold kt-font-warning">Pending</span></td>
															<td>-</td>
															<td>-</td>
															<td>2022-12-23 14:25:11</td>
													</tr>
											</tbody>
									</table>
									<!--end: Datatable -->
								</div>
								<div class="modal-footer">
										<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
								</div>
						</div>
				</div>
		</div>
@endsection
@push('scriptjs')
{{-- <script src="{{ asset('demo10/assets/js/pages/crud/forms/widgets/bootstrap-datepicker.js')}}" type="text/javascript"></script> --}}
<script>
		var initTable1 = function () {
				var table = $(".kt_table_1").DataTable({
						responsive: true,
						ordering: false,
						select: {
							style: 'multi',
							selector: 'td:nth-child(2) .kt-checkable',
						},
						headerCallback: function(thead, data, start, end, display) {
							thead.getElementsByTagName('th')[1].innerHTML = `
							<label class="kt-checkbox kt-checkbox--single kt-checkbox--solid">
									<input type="checkbox" value="" class="kt-group-checkable">
									<span></span>
							</label>`;
						},
						columnDefs: [
							{
									targets: 0,
									render: function (data, type, row, meta) {
											return meta.row + meta.settings._iDisplayStart + 1;
									}
							},
							{
								targets: 1,
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
							{
								targets: 8,
								render: function(data, type, full, meta) {
									var status = {
										PENDING: {'title': 'PENDING', 'state': 'warning'},
										REJECTED: {'title': 'REJECTED', 'state': 'danger'},
										APPROVED: {'title': 'APPROVED', 'state': 'success'},
										CANCELED: {'title': 'CANCELED', 'state': 'dark'},
									};
									if (typeof status[data] === 'undefined') {
										return data;
									}
									return '<span class="kt-badge kt-badge--' + status[data].state + ' kt-badge--dot"></span>&nbsp;' +
										'<span class="kt-font-bold kt-font-' + status[data].state + '">' + status[data].title + '</span>';
								},
							},
						],
				});
				table.on('change', '.kt-group-checkable', function() {
					var set = $(this).closest('table').find('td:nth-child(2) .kt-checkable');
					var checked = $(this).is(':checked');

					$(set).each(function() {
						if (checked) {
							$(this).prop('checked', true);
							table.rows($(this).closest('tr')).select();
						}
						else {
							$(this).prop('checked', false);
							table.rows($(this).closest('tr')).deselect();
						}
					});
				});
		}();

		$('.kt-select2').select2({
				placeholder: "Select on option",
		});

		$('#kt_datetimepicker_3').datetimepicker({
				todayHighlight: true,
				autoclose: true,
				pickerPosition: 'bottom-left',
				todayBtn: true,
				startView: 3,
				minView: 3,
				forceParse: 0,
				format: 'mm/yyyy'
		});
</script>
@endpush
