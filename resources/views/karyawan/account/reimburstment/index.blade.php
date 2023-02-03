@extends('karyawan.account.index',[
	'pages'=>'finance',
	'subpages'=>'reimburstment'
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
                Reimbursement information
            </h3>
        </div>
        <div class="kt-portlet__head-toolbar">
            <button data-toggle="modal" data-target="#kt_modal_2" class="btn btn-sm btn-outline-brand btn-elevate btn-icon-sm">
                Request Reimburstment
            </button>
        </div>
    </div>
    <div class="kt-portlet__body pt-0">
        <!--begin::Portlet-->
        <div class="kt-portlet kt-portlet--tabs" style="box-shadow: none;">
            <div class="kt-portlet__head p-0">
                <div class="kt-portlet__head-toolbar">
                    <ul class="nav nav-tabs nav-tabs-bold nav-tabs-line nav-tabs-line-3x nav-tabs-line-brand" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link p-0 active" data-toggle="tab" href="#kt_portlet_tab_3_1" role="tab">Reimbursement Request</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link p-0" data-toggle="tab" href="#kt_portlet_tab_3_2" role="tab">Reimbursement Taken</a>
                        </li>
                    </ul>
                </div>
                {{-- <div class="kt-portlet__head-label">
                    <h3 class="kt-portlet__head-title">
                        <div class="text-center text-primary">6 days</div> <small>Cuti Tahunan</small>
                    </h3>
                </div> --}}
            </div>
            <div class="tab-content pt-3">
              <div class="tab-pane active" id="kt_portlet_tab_3_1">
                  <div class="row">
                      <div class="col-lg px-lg-0 mb-4">
                        <!--begin: Filter -->
                        <form action="">
                          <div class="form-group row m-0 align-items-end">
                              <label for="status" class="col-lg-auto col-form-label">Select Status</label>
                              <div class="col-lg">
                                              <select class="form-control kt-select2" id="status" name="status">
                                                              <option></option>
                                                              <option>Pending</option>
                                                              <option>Rejected</option>
                                                              <option>Approved</option>
                                                              <option>Canceled</option>
                                              </select>
                              </div>
                              <label for="period" class="col-lg-auto col-form-label">Select Month & Years</label>
                              <div class="col-lg">
                                <div class="input-group date">
                                  <input type="text" class="form-control kt_datetimepicker_3" id="period" readonly value="{{date('m/Y')}}" />
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
                      <div class="col-lg-12">
                          <!--begin: Datatable -->
                          <table class="table table-striped- table-bordered table-hover table-checkable kt_table_1 w-100 nowrap">
                              <thead>
                                  <tr>
                                      <th>Transaction ID</th>
                                      <th>Reimbursement</th>
                                      <th>Craated Date</th>
                                      <th>Effective Date</th>
                                      <th>Detail</th>
                                      <th>Total</th>
                                      <th>Status</th>
                                      <th>Approval</th>
                                      <th>File</th>
                                      <th>Action</th>
                                  </tr>
                              </thead>
                              <tbody>
                                  <tr>
                                      <td>20230100001</td>
                                      <td>Operational Reimbursement</td>
                                      <td>2023-01-09</td>
                                      <td>2023-01-09</td>
                                      <td class="text-center"><a href="#" class="kt-link" data-toggle="modal" data-target="#kt_modal_3">View</a></td>
                                      <td>3,000</td>
                                      <td>0</td>
                                      <td class="text-center"><a href="#" class="kt-link" data-toggle="modal" data-target="#kt_modal_1">View</a></td>
                                      <td class="text-center"><a href="#" class="kt-link" data-toggle="modal" data-target="#kt_modal_4"><i class="la la-file"></i> File</a></td>
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
              <div class="tab-pane" id="kt_portlet_tab_3_2">
                <div class="row">
                  <div class="col-lg px-lg-0 mb-4">
                    <!--begin: Filter -->
                    <form action="">
                      <div class="form-group row m-0 align-items-end">
                          <label for="period" class="col-lg-auto col-form-label">Select Month & Years</label>
                          <div class="col-lg-3">
                            <div class="input-group date">
                              <input type="text" class="form-control kt_datetimepicker_3" id="period" readonly value="{{date('m/Y')}}" />
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
                  <div class="col-lg-12">
                    <!--begin: Datatable -->
                    <table class="table table-striped- table-bordered table-hover table-checkable kt_table_2 w-100 nowrap">
                      <thead>
                        <tr>
                          <th>Reimbursement Name</th>
                          <th>Detail</th>
                          <th>Total</th>
                          <th>Effective Date</th>
                        </tr>
                      </thead>
                      <tbody>
                        <tr>
                          <td>Operational Reimbursement</td>
                          <td><a href="#" class="kt-link" data-toggle="modal" data-target="#kt_modal_1">View</a></td>
                          <td>3.000</td>
                          <td>2022-12-26</td>
                        </tr>
                      </tbody>
                    </table>
                    <!--end: Datatable -->
                  </div>
                </div>
              </div>
            </div>
        </div>
    </div>
    <!--end::Form-->
</div>

<!-- Modal Reimburstment -->
<div class="modal fade" id="kt_modal_2" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Reimbursement Request</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                </button>
            </div>
            <form class="kt-form" action="">
              <div class="modal-body">
                <div class="form-group">
                  <label>Transaction ID</label>
                  <input type="text" class="form-control" disabled value="20230100001">
                </div>
                <div class="form-group">
                    <label for="type">Reimbursement Name <span class="text-danger">*</span></label>
                    <select class="form-control kt-select2 w-100" id="type" name="type">
                      <option></option>
                      <option value="0">Operational Reimbursement</option>
                    </select>
                </div>
                <div class="form-group">
                    <label>Effective Date <span class="text-danger">*</span></label>
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
                    <label for="importExportTemplate" class="form-group-label">Attach File</label>
                    <div class="custom-file">
                        <input id="importExportTemplate" type="file" accept=".pdf,.jpg,.png,.jpeg" class="custom-file-input">
                        <label for="importExportTemplate" class="custom-file-label is-ellipsis">No file selected</label>
                    </div>
                </div>
                <div class="form-group m-0">
                    <label for="notes">Notes <span class="text-danger">*</span></label>
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
<div class="modal fade" id="kt_modal_3" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Request Detail</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                </button>
            </div>
            <form class="kt-form" action="">
              <div class="modal-body">
                <div class="row">
                  <div class="col-lg-3">
                    <p class="m-0">Transaction ID</p>
                    <p class="kt-font-bold">20230100001</p>
                  </div>
                  <div class="col-lg-2">
                    <p class="m-0">Request Date</p>
                    <p class="kt-font-bold">05 Jan, 2023</p>
                  </div>
                  <div class="col-lg-3">
                    <p class="m-0">Effective Date :</p>
                    <p class="kt-font-bold">09 January, 2023</p>
                  </div>
                  <div class="col-lg-4">
                    <p class="m-0">Employee Name</p>
                    <p class="kt-font-bold">Adam Aldiansyah</p>
                  </div>
                  <div class="col-lg-3">
                    <p class="m-0">Approval Date</p>
                    <p class="kt-font-bold">-</p>
                  </div>
                  <div class="col-lg-2">
                    <p class="m-0">Payment Date :</p>
                    <p class="kt-font-bold">-</p>
                  </div>
                  <div class="col-lg-3">
                    <p class="m-0">Status</p>
                    <p class="kt-font-bold">
                      <span class="kt-badge kt-badge--warning kt-badge--dot"></span><span class="kt-font-bold kt-font-warning"> Pending</span>
                    </p>
                  </div>
                  <div class="col-lg-4">
                    <p class="m-0">Reimbursement Name</p>
                    <p class="kt-font-bold">Operational Reimbursement</p>
                  </div>
                  <div class="col-lg-6">
                    <p class="m-0 kt-font-bold">Overtime Notes</p>
                    <p>Lorem ipsum dolor, sit amet consectetur adipisicing elit. Pariatur</p>
                  </div>
                  <div class="col-lg-6">
                    <p class="m-0">File Attached :</p>
                    <p><a href="#" target="_blank" class="kt-link">dZ82yM4EHL-PWpGijaoY3CvJA8Yiz77T.png</a></p>
                  </div>
                </div>
                <div class="row">
                  <div class="col-lg-auto">
                    <h5 class="kt-font-bold kt-font-brand">Total Paid : 3,000</h5>
                  </div>
                </div>
                <!--begin: Datatable -->
              <table class="table table-striped- table-bordered table-hover m-0">
                  <thead>
                      <tr>
                          <th>No</th>
                          <th>Benefit Name</th>
                          <th>Request Amount</th>
                          <th>Paid Amount</th>
                          <th>Min.Next Clain (Months)</th>
                      </tr>
                  </thead>
                  <tbody>
                      <tr>
                          <td>1</td>
                          <td>Parking</td>
                          <td>2,000</td>
                          <td>2,000</td>
                          <td>0</td>
                      </tr>
                      <tr>
                          <td>2</td>
                          <td>Online Transportation</td>
                          <td>1,000</td>
                          <td>1,000</td>
                          <td>0</td>
                      </tr>
                  </tbody>
              </table>
              <!--end: Datatable -->
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
                          <td>DMY004</td>
                          <td>Arif</td>
                          <td><span class="kt-badge kt-badge--warning kt-badge--dot"></span>&nbsp;<span class="kt-font-bold kt-font-warning">Pending</span></td>
                          <td>-</td>
                          <td>-</td>
                          <td>2022-12-23 14:25:11</td>
                      </tr>
                      <tr>
                          <td>3</td>
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

<!-- Modal File -->
<div class="modal fade" id="kt_modal_4" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Reimbursement Request File</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                </button>
            </div>
            <div class="modal-body">
              <div class="row">
                <div class="col-lg-2">
                  <p class="m-0">Transaction ID</p>
                  <p class="kt-font-bold m-0">20230100001</p>
                </div>
                <div class="col-lg-4">
                  <p class="m-0">Reimbursement</p>
                  <p class="kt-font-bold m-0">Operational Reimbursement</p>
                </div>
                <div class="col-lg-2">
                  <p class="m-0">Effective Date</p>
                  <p class="kt-font-bold m-0">2023-01-09</p>
                </div>
                <div class="col-lg-4">
                  <p class="m-0">Amount</p>
                  <p class="kt-font-bold m-0">3000</p>
                </div>
              </div>
              <hr>
              <!--begin: Datatable -->
              <table class="table table-striped- table-bordered table-hover m-0">
                  <thead>
                      <tr>
                          <th>File Name</th>
                          <th>Action</th>
                      </tr>
                  </thead>
                  <tbody>
                      <tr>
                        <td><div class="text-wrap">tPasnqcnXWWZfuvSMXXkAzfD4r2J_I98.png</div></td>
                        <td class="text-center"><a href="#"><i class="fa fa-download"></i></a></td>
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
							<p class="text">Are you sure Cancel this Timeoff ?</p>
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

  $(".kt_table_2").DataTable({responsive: true,})

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

  $('.kt_datetimepicker_3').datetimepicker({
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