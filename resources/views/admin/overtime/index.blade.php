@extends('layout-admin.base', [
    'pages' => 'Setting Time Off',
    'subpages' => 'Setting Time Off',
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
    }

		.kt-font-secondary{
			color: #cbcbcb !important;
		}

		.kt-timeline-v2:before {
			left: 0.85rem;
		}

		.kt-timeline-v2 .kt-timeline-v2__items .kt-timeline-v2__item .kt-timeline-v2__item-cricle {
			left: 0.12rem;
		}
</style>            
@endpush
@section('content')
    <div class="kt-portlet">
        <div class="kt-portlet__head">
            <div class="kt-portlet__head-label">
                <h3 class="kt-portlet__head-title">Overtime</h3>
            </div>
            <div class="kt-portlet__head-toolbar">
                <button data-toggle="modal" data-target="#kt_modal_2" class="btn btn-sm btn-brand btn-elevate mx-3 btn-icon-sm">
                    <i class="la la-plus"></i>
                    Request Overtime
                </button>
                <button type="button" data-toggle="modal" data-target="#kt_modal_3" class="btn btn-sm btn-secondary btn-elevate btn-icon-sm">
                    <i class="la la-upload"></i>
                    Import Overtime
                </button>
            </div>
        </div>
        <div class="kt-portlet__body">
            <div class="row">
							<div class="col-lg-12">
								<!--begin: Datatable -->
								<table class="table table-striped- table-bordered table-hover table-checkable kt_table_1 mt-0">
										<thead>
												<tr>
														<th>Request date</th>
														<th>Overtime date</th>
														<th>Employee ID</th>
														<th>Employee</th>
														<th>Compensation</th>
														<th>Duration</th>
														<th>Status</th>
														<th>View</th>
												</tr>
										</thead>
										<tbody>
												<tr>
														<td>19 Dec 2022</td>
														<td>16 Dec 2022</td>
														<td>DMY006</td>
														<td>Dummy</td>
														<td>Paid Overtime</td>
														<td>2h</td>
														<td>0</td>
														<td><a href="#" class="kt-link" data-toggle="modal" data-target="#kt_modal_1">Detail</a></td>
												</tr>
										</tbody>
								</table>
								<!--end: Datatable -->
							</div>
            </div>
        </div>
    </div>

		<!-- Modal Create -->
    <div class="modal fade" id="kt_modal_2" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
				<div class="modal-dialog modal-lg" role="document">
						<div class="modal-content">
								<div class="modal-header">
										<h5 class="modal-title" id="exampleModalLabel">Overtime Request</h5>
										<button type="button" class="close" data-dismiss="modal" aria-label="Close">
										</button>
								</div>
								<form class="kt-form" action="">
									<div class="modal-body">
										<div class="form-group">
											 	<label for="employee">Employee<span class="text-danger">*</span></label>
												<select class="form-control kt-select2" id="employee" name="employee">
														<option></option>
														<option>DMY001 - Sintia</option>
														<option>DMY002 - Dela</option>
														<option>DMY003 - Arif</option>
												</select>
										</div>
										<div class="form-group">
												<label>Date<span class="text-danger">*</span></label>
												<div class="input-group date">
														<input type="text" class="form-control" readonly="" value="05/20/2017" id="kt_datepicker_3">
														<div class="input-group-append">
																<span class="input-group-text">
																		<i class="la la-calendar"></i>
																</span>
														</div>
												</div>
										</div>
										<div class="form-group">
												<label for="compensation">Compensation<span class="text-danger">*</span></label>
												<select class="form-control" disabled id="compensation" name="compensation">
														<option>Paid Overtime</option>
														<option>Overtime Leave</option>
												</select>
										</div>
										<div class="form-group row">
											<div class="col-lg-4">
												<label for="type">Type<span class="text-danger">*</span></label>
												<select class="form-control kt-select2" id="type" name="type">
														<option selected disabled>Pilih Salah Satu</option>
														<option>Before Shift</option>
														<option>After Shift</option>
												</select>
											</div>
											<div class="col-lg-4">
												<label>Duration<span class="text-danger">*</span></label>
												<div class="input-group">
													<input type="text" class="form-control kt_timepicker" placeholder="00:00">
													<div class="input-group-append">
														<span class="input-group-text">
															<i class="la la-clock-o"></i>
														</span>
													</div>
												</div>
											</div>
											<div class="col-lg-4">
												<label>Break (minutes)<span class="text-danger">*</span></label>
												<div class="input-group">
													<input type="text" class="form-control" placeholder="1">
												</div>
											</div>
										</div>
										<div class="form-group">
												<label for="notes">Notes<span class="text-danger">*</span></label>
												<textarea class="form-control" id="notes" rows="3"></textarea>
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
									<div class="row justify-content-between align-items-center">
										<div class="col-lg-auto">
											<div class="kt-widget3">
                        <div class="kt-widget3__item m-0">
													<div class="kt-widget3__header justify-content-start p-0">
														<div class="kt-widget3__user-img">
																<div class="kt-media kt-media--circle kt-media--primary">
																		<span>M</span>
																</div>
														</div>
														<div class="kt-widget3__info">
																<div class="kt-widget3__username">
																		Melania Trump
																</div>
																<span class="kt-widget3__time">
																		DMY004 - Direktur
																</span>
														</div>
													</div>
                        </div>
											</div>
										</div>
										<div class="col-lg-auto">
											<div>
												<span class="kt-badge kt-badge--warning kt-badge--dot"></span>&nbsp;<span class="kt-font-bold kt-font-warning">Pending</span>
												<span class="d-none kt-badge kt-badge--danger kt-badge--dot"></span>&nbsp;<span class="d-none kt-font-bold kt-font-danger">Rejected</span>
												<span class="d-none kt-badge kt-badge--success kt-badge--dot"></span>&nbsp;<span class="d-none kt-font-bold kt-font-success">Approved</span>
												<span class="d-none kt-badge kt-badge--dark kt-badge--dot"></span>&nbsp;<span class="d-none kt-font-bold kt-font-dark">Canceled</span>
											</div>
										</div>
									</div>
									<hr>
									<div class="row justify-content-between align-items-center">
										<div class="col-lg-4">
											<p class="mb-1">Request date</p>
											<p class="mb-1">Overtime date</p>
											<p class="m-0">Duration</p>
										</div>
										<div class="col-lg-8 text-right">
											<p class="kt-font-bold mb-1">2022-12-19 13:34:55</p>
											<p class="kt-font-bold mb-1">2022-12-16</p>
											<p class="kt-font-bold m-0">2h</p>
										</div>
									</div>
									<hr>
									<!--begin::Accordion-->
									<div class="accordion accordion-light accordion-toggle-arrow" id="accordionExample5">
										<div class="card">
											<div class="card-header" id="headingThree5">
												<div class="card-title collapsed kt-font-bold" data-toggle="collapse" data-target="#collapseThree5" aria-expanded="false" aria-controls="collapseThree5">
														Detail
												</div>
											</div>
											<div id="collapseThree5" class="collapse" aria-labelledby="headingThree5" data-parent="#accordionExample5">
												<div class="card-body">
													<div class="row justify-content-between align-items-center">
														<div class="col-lg-4">
															<p class="mb-1">Shift</p>
															<p class="mb-1">Overtime before shift</p>
															<p class="mb-1">Overtime after shift</p>
															<p class="m-0">Notes</p>
														</div>
														<div class="col-lg-8 text-right">
															<p class="kt-font-bold mb-1">10:00-20:00 P</p>
															<p class="kt-font-bold mb-1">1h</p>
															<p class="kt-font-bold mb-1">1h</p>
															<p class="kt-font-bold m-0">Test Dummy</p>
														</div>
													</div>
												</div>
											</div>
										</div>
										<div class="card m-0">
											<div class="card-header" id="headingTwo5">
												<div class="card-title collapsed kt-font-bold" data-toggle="collapse" data-target="#collapseTwo5" aria-expanded="false" aria-controls="collapseTwo5">
														Request History
												</div>
											</div>
											<div id="collapseTwo5" class="collapse" aria-labelledby="headingTwo5" data-parent="#accordionExample5">
												<div class="card-body pb-4">
													<!--Begin::Timeline 3 -->
													<div class="kt-timeline-v2">
														<div class="kt-timeline-v2__items  kt-padding-top-25 kt-padding-bottom-30">
															<div class="kt-timeline-v2__item">
																<div class="kt-timeline-v2__item-cricle">
																	<i class="fa fa-genderless kt-font-success"></i>
																</div>
																<div class="kt-timeline-v2__item-text pl-1 kt-padding-top-5">
																	<p class="m-0 kt-font-bold">Approval by Akbar Syaputra</p>
																	<small>22 Dec 2022 11:34 AM</small>
																</div>
															</div>
															<div class="kt-timeline-v2__item">
																<div class="kt-timeline-v2__item-cricle">
																	<i class="fa fa-genderless kt-font-dark"></i>
																</div>
																<div class="kt-timeline-v2__item-text pl-1 kt-padding-top-5">
																	<p class="m-0 kt-font-bold">Canceled by Dummy</p>
																	<small>22 Dec 2022 9:49 AM</small>
																</div>
															</div>
															<div class="kt-timeline-v2__item">
																<div class="kt-timeline-v2__item-cricle">
																	<i class="fa fa-genderless kt-font-danger"></i>
																</div>
																<div class="kt-timeline-v2__item-text pl-1 kt-padding-top-5">
																	<p class="m-0 kt-font-bold">Rejected by Akbar Syaputra</p>
																	<small>22 Dec 2022 7:09 AM</small>
																</div>
															</div>
															<div class="kt-timeline-v2__item">
																<div class="kt-timeline-v2__item-cricle">
																	<i class="fa fa-genderless kt-font-warning"></i>
																</div>
																<div class="kt-timeline-v2__item-text pl-1 kt-padding-top-5 kt-font-bold">
																	Need approval from Akbar Syaputra
																</div>
															</div>
															<div class="kt-timeline-v2__item">
																<div class="kt-timeline-v2__item-cricle">
																	<i class="fa fa-genderless kt-font-secondary"></i>
																</div>
																<div class="kt-timeline-v2__item-text pl-1">
																	<p class="m-0">Requested by Dummy</p>
																	<small>19 Dec 2022 13:34 AM</small>
																</div>
															</div>
														</div>
													</div>
													<!--End::Timeline 3 -->
												</div>
											</div>
										</div>
									</div>
									<!--end::Accordion-->
								</div>
								<div class="modal-footer">
										<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
								</div>
						</div>
				</div>
		</div>

		<!-- Modal Import -->
    <div class="modal fade" id="kt_modal_3" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
				<div class="modal-dialog modal-md" role="document">
						<div class="modal-content">
								<div class="modal-header">
										<h5 class="modal-title" id="exampleModalLabel">Import</h5>
										<button type="button" class="close" data-dismiss="modal" aria-label="Close">
										</button>
								</div>
								<div class="modal-body">
									<h5>Download and complete the template</h5>
									<p>Download template below and write your data.</p>

									<a href="#" class="bg-secondary w-100 d-flex rounded justify-content-between p-3 align-items-center">
										<h6 class="m-0 d-flex align-items-center"><i class="fa fa-file-alt mr-3"></i>Template_Overtime_Request.xlsx</h6>
										<div><i class="fa fa-download"></i></div>
									</a>

									<p class="mb-0 mt-3 kt-font-bold">Few tips:</p>
									<ul>
										<li>Make sure employee ID is correct</li>
										<li>Click column header on spreadsheet to read instruction</li>
									</ul>
									<form action="">
										<div class="form-group m-0">
											<label for="importExportTemplate" class="form-group-label">Upload spreadsheet</label>
											<div class="custom-file">
												<input id="importExportTemplate" type="file" accept=".xls,.xlsx" class="custom-file-input">
												<label for="importExportTemplate" class="custom-file-label is-ellipsis">No file selected</label>
											</div>
										</div>
									</form>
								</div>
								<div class="modal-footer">
										<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
										<button type="submit" class="btn btn-success">Submit</button>
								</div>
						</div>
				</div>
		</div>
@endsection
@push('scriptjs')
<script src="{{ asset('demo10/assets/js/pages/crud/forms/widgets/bootstrap-datepicker.js')}}" type="text/javascript"></script>
<script>
		var initTable1 = function () {
				var table = $(".kt_table_1");
				// begin first table
				table.DataTable({
						scrollX: true,
						scrollCollapse: true,
						lengthMenu: [10, 25, 50],
						pageLength: 10,
						ordering: false,
						language: {
								lengthMenu: "Display _MENU_",
						},
						// Order settings
						order: [[1, "asc"]],
						columnDefs: [
							{
								targets: 6,
								render: function(data, type, full, meta) {
									var status = {
										0: {'title': 'Pending', 'state': 'warning'},
										1: {'title': 'Rejected', 'state': 'danger'},
										2: {'title': 'Approved', 'state': 'success'},
										3: {'title': 'Canceled', 'state': 'dark'},
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
		}();

		$('.kt-select2').select2({
				placeholder: "Select on option",
		});

		$('.kt_timepicker').datetimepicker({
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

</script>
@endpush
