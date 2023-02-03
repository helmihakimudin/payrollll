@extends('karyawan.account.index',[
	'pages'=>'time-management',
	'subpages'=>'overtime'
])

@push('css')
<style>
  .select2-container {
    display: block;
    width: 100%;
  }
  .disabled{
    cursor: not-allowed !important;
    pointer-events: auto !important;
    opacity: .3 !important;
  } 
</style>            
@endpush
@section('content-account')
<div class="kt-portlet">
    <div class="kt-portlet__head">
        <div class="kt-portlet__head-label">
            <h3 class="kt-portlet__head-title">
							Overtime Information
            </h3>
        </div>
        <div class="kt-portlet__head-toolbar">
            <button data-toggle="modal" data-target="#kt_modal_2" class="btn btn-sm btn-outline-brand btn-elevate btn-icon-sm">
                Request Overtime
            </button>
        </div>
    </div>
    <div class="kt-portlet__body">
      <div class="row">
          <div class="col-lg px-lg-0 mb-4">
              <!--begin: Filter -->
              <form action="">
                  <div class="form-group row m-0 align-items-end">
                      <label for="status" class="col-lg-auto col-form-label">Select Status</label>
                      <div class="col-lg-3">
                          <select class="form-control kt-select2" id="status" name="status">
                              <option></option>
                              <option>Pending</option>
                              <option>Rejected</option>
                              <option>Approved</option>
                              <option>Canceled</option>
                          </select>
                      </div>
                      <div class="col-lg-auto">
                          <button type="submit" class="btn btn-outline-warning btn-elevate btn-icon-sm"><i class="la la-filter"></i>Filter</button>
                      </div>
                  </div>
              </form>
              <!--end: Filter -->
          </div>
          <div class="col-lg-12">
              <!--begin: Datatable -->
              <table class="table table-striped- table-bordered table-hover table-checkable kt_table_1 w-100 nowrap">
                  <thead>
                      <tr>
                        <th>Create Date</th>
                        <th>Overtime Date</th>
                        <th>Status</th>
                        <th>Compensation Type</th>
                        <th>Approval</th>
                        <th>Detail</th>
                        <th>Action</th>
                      </tr>
                  </thead>
                  <tbody>
                      <tr>
                        <td>2022-12-23</td>
                        <td>2023-01-05</td>
                        <td>0</td>
                        <td>Paid Overtime	</td>
                        <td><a href="#" class="kt-link" data-toggle="modal" data-target="#kt_modal_1">View</a></td>
                        <td>
                            <a type="button" data-toggle="modal" data-target="#kt_modal_3" href="javascript:;" class="btn btn-sm btn-clean btn-icon btn-icon-md" title="Detail">
                                <i class="la la-eye fa-lg"></i>
                            </a>
                        </td>
                        <td>
                          <a type="button" href="javascript:;" class="btn-cancel btn btn-sm btn-clean btn-icon btn-icon-md" title="Cancel">
                              <i class="la la-ban fa-lg text-danger"></i>
                          </a>
                        </td>
                      </tr>
                  </tbody>
              </table>
              <!--end: Datatable -->
          </div>
      </div>
    </div>
    <!--end::Form-->
</div>

<!-- Modal OverTime -->
<div class="modal fade" id="kt_modal_2" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Request Overtime</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                </button>
            </div>
            <form class="kt-form" action="">
              <div class="modal-body">
                <div class="form-group row">
                  <div class="col-lg-6">
                    <label>Request Date<span class="text-danger">*</span></label>
                    <div class="input-group date">
                        <input type="text" class="form-control" readonly="" value="05/20/2017" id="kt_datepicker_3">
                        <div class="input-group-append">
                            <span class="input-group-text">
                                <i class="la la-calendar"></i>
                            </span>
                        </div>
                    </div>
                  </div>
                  <div class="col-lg-6">
                    <label for="type">Compensation Type<span class="text-danger">*</span></label>
                    <div class="kt-radio-inline">
                        <label class="kt-radio kt-radio--bold kt-radio--success">
                            <input type="radio" value="0" name="radio2" checked> Paid Overtime
                            <span></span>
                        </label>
                        <label class="kt-radio kt-radio--bold kt-radio--success">
                            <input type="radio" value="1" name="radio2"> Overtime Leave
                            <span></span>
                        </label>
                    </div>
                  </div>
                </div>
                <div class="form-group row">
                  <div class="col-lg-4">
                    <label>Shift</label>
                    <input type="text" class="form-control" disabled value="SOSMED2">
                  </div>
                  <div class="col-lg-4">
                    <label>Schedule In</label>
                    <input type="text" class="form-control" disabled value="09:00:00">
                  </div>
                  <div class="col-lg-4">
                    <label>Schedule Out</label>
                    <input type="text" class="form-control" disabled value="09:00:00">
                  </div>
                </div>
                <div class="form-group row">
                  <div class="col-lg-6">
                    <label>Overtime before duration</label>
                    <div class="row">
                      <div class="col-lg-6">
                        <div class="input-group input-group-sm">
                          <div class="input-group-prepend"><span class="input-group-text">Hour</span></div>
                          <input type="text" class="form-control" maxlength="2">
                        </div>
                      </div>
                      <div class="col-lg-6">
                        <div class="input-group input-group-sm">
                          <div class="input-group-prepend"><span class="input-group-text">Minutes</span></div>
                          <input type="text" class="form-control" maxlength="2">
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="col-lg-6">
                    <label>Break before duration</label>
                    <div class="row">
                      <div class="col-lg-6">
                        <div class="input-group input-group-sm">
                          <div class="input-group-prepend"><span class="input-group-text">Hour</span></div>
                          <input type="text" class="form-control" maxlength="2">
                        </div>
                      </div>
                      <div class="col-lg-6">
                        <div class="input-group input-group-sm">
                          <div class="input-group-prepend"><span class="input-group-text">Minutes</span></div>
                          <input type="text" class="form-control" maxlength="2">
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="form-group row">
                  <div class="col-lg-6">
                    <label>Overtime after duration</label>
                    <div class="row">
                      <div class="col-lg-6">
                        <div class="input-group input-group-sm">
                          <div class="input-group-prepend"><span class="input-group-text">Hour</span></div>
                          <input type="text" class="form-control" maxlength="2">
                        </div>
                      </div>
                      <div class="col-lg-6">
                        <div class="input-group input-group-sm">
                          <div class="input-group-prepend"><span class="input-group-text">Minutes</span></div>
                          <input type="text" class="form-control" maxlength="2">
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="col-lg-6">
                    <label>Break after duration</label>
                    <div class="row">
                      <div class="col-lg-6">
                        <div class="input-group input-group-sm">
                          <div class="input-group-prepend"><span class="input-group-text">Hour</span></div>
                          <input type="text" class="form-control" maxlength="2">
                        </div>
                      </div>
                      <div class="col-lg-6">
                        <div class="input-group input-group-sm">
                          <div class="input-group-prepend"><span class="input-group-text">Minutes</span></div>
                          <input type="text" class="form-control" maxlength="2">
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="form-group m-0">
                    <label for="description">Description</label>
                    <textarea class="form-control" id="description" rows="3"></textarea>
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
<div class="modal fade" id="kt_modal_3" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Overtime Request Detail</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                </button>
            </div>
            <form class="kt-form" action="">
              <div class="modal-body">
                <div class="row">
                  <div class="col-lg-3">
                    <p class="m-0">Request Date</p>
                    <p class="kt-font-bold">05 Jan, 2023</p>
                  </div>
                  <div class="col-lg-3">
                    <p class="m-0">Employee ID</p>
                    <p class="kt-font-bold">DMY004</p>
                  </div>
                  <div class="col-lg-3">
                    <p class="m-0">Employee Name</p>
                    <p class="kt-font-bold">Adam Aldiansyah</p>
                  </div>
                  <div class="col-lg-3">
                    <p class="m-0">Compensation Type</p>
                    <p class="kt-font-bold">Paid Overtime</p>
                  </div>
                  <div class="col-lg-3">
                    <p class="m-0">Shift</p>
                    <p class="kt-font-bold">SOSMED2</p>
                  </div>
                  <div class="col-lg-3">
                    <p class="m-0">Work Schedule</p>
                    <p class="kt-font-bold">09:00:00 - 19:00:00</p>
                  </div>
                  <div class="col-lg-3">
                    <p class="m-0">Status</p>
                    <p class="kt-font-bold">
                      <span class="kt-badge kt-badge--warning kt-badge--dot"></span><span class="kt-font-bold kt-font-warning"> Pending</span>
                    </p>
                  </div>
                </div>
                <div class="row">
                  <div class="col-lg-3">
                    <p class="m-0">OT Before Duration</p>
                    <p class="kt-font-bold">1 hours</p>
                  </div>
                  <div class="col-lg-3">
                    <p class="m-0">Break Before Duration</p>
                    <p class="kt-font-bold">3 hours</p>
                  </div>
                  <div class="col-lg-3">
                    <p class="m-0">OT After Duration</p>
                    <p class="kt-font-bold">2 hours</p>
                  </div>
                  <div class="col-lg-3">
                    <p class="m-0">Break After Duration</p>
                    <p class="kt-font-bold">4 hours</p>
                  </div>
                  <div class="col-lg-12">
                    <p class="m-0 kt-font-bold">Overtime Notes</p>
                    <p>Lorem ipsum dolor, sit amet consectetur adipisicing elit. Pariatur, voluptates harum nihil provident magnam sed delectus fugit ab ex in excepturi asperiores quas, laboriosam explicabo veniam quae porro perspiciatis officia.</p>
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

<!-- Modal Approval -->
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
              <table class="table table-striped- table-bordered table-hover m-0">
                  <thead>
                      <tr>
                          <th>Approval</th>
                          <th>Employee ID</th>
                          <th>PIC</th>
                          <th>Status</th>
                          <th>Comment</th>
                          <th>Decision By</th>
                          <th>Detail</th>
                      </tr>
                  </thead>
                  <tbody>
                      <tr>
                          <td>1</td>
                          <td>BOD009</td>
                          <td>Akbar Syaputra</td>
                          <td><span class="kt-badge kt-badge--warning kt-badge--dot"></span>&nbsp;<span class="kt-font-bold kt-font-warning">Pending</span></td>
                          <td>-</td>
                          <td>Dummy</td>
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

<!--begin::Modal Cancel -->
<div class="modal fade" id="kt_modal_0" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
		<div class="modal-dialog" role="document">
				<div class="modal-content">
						<div class="modal-header">
								<h5 class="modal-title" id="exampleModalLabel">Warning !</h5>
								<button type="button" class="close" data-dismiss="modal" aria-label="Close">
								</button>
						</div>
						<div class="modal-body">
								<p class="text">Are you sure Cancel this Overtime ?</p>
						</div>
						<div class="modal-footer">
								<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
								<button type="button" class="btn btn-danger">Delete</button>
						</div>
				</div>
		</div>
</div>
@endsection
@push('scriptjs')
<script src="{{ asset('demo10/assets/js/pages/crud/forms/widgets/bootstrap-datepicker.js')}}" type="text/javascript"></script>
<script>
  var initTable1 = function () {
      var table = $(".kt_table_1").DataTable({
          responsive: true,
          ordering: false,
          columnDefs: [
            {
              targets: 2,
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

  $(".kt_table_2").DataTable()

  $(document).on("click", ".btn-cancel", function(){
    if ($(this).hasClass('disabled')) {
      $("#kt_modal_0").modal("hide");
    } else{
      $("#kt_modal_0").modal("show");
    }
  })

  $('.kt-select2').select2({
      placeholder: "Select on option",
  });
</script>
@endpush