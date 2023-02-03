@extends('karyawan.account.index',[
	'pages'=>'time-management',
	'subpages'=>'timeoff'
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

  .el-none1, .el-none2{
    display: none;
  }
</style>            
@endpush
@section('content-account')
<div class="kt-portlet">
    <div class="kt-portlet__head">
        <div class="kt-portlet__head-label">
            <h3 class="kt-portlet__head-title">
							Time Off Information
            </h3>
        </div>
        <div class="kt-portlet__head-toolbar">
            <button data-toggle="modal" data-target="#kt_modal_2" class="btn btn-sm btn-outline-brand btn-elevate mx-3 btn-icon-sm">
                Request Time Off
            </button>
            <button data-toggle="modal" data-target="#kt_modal_3" class="btn btn-sm btn-outline-brand btn-elevate btn-icon-sm">
                Request Delegation
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
                            <a class="nav-link p-0 active" data-toggle="tab" href="#kt_portlet_tab_3_1" role="tab">Time Off Request</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link p-0" data-toggle="tab" href="#kt_portlet_tab_3_2" role="tab">Delegation</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link p-0" data-toggle="tab" href="#kt_portlet_tab_3_3" role="tab">Time Off Taken</a>
                        </li>
                    </ul>
                </div>
                <div class="kt-portlet__head-label">
                    <h3 class="kt-portlet__head-title">
                        <div class="text-center text-primary">6 days</div> <small>Cuti Tahunan</small>
                    </h3>
                </div>
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
                                            <select class="form-control kt-select2">
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
                                        <th>Create Date</th>
                                        <th>Code Time Off</th>
                                        <th>Start Date</th>
                                        <th>End Date</th>
                                        <th>Notes</th>
                                        <th>Status</th>
                                        <th>Taken</th>
                                        <th>Cancel</th>
                                        <th>Approval</th>
                                        <th>File</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>2022-12-23</td>
                                        <td>CT</td>
                                        <td>2022-12-23</td>
                                        <td>2022-12-26</td>
                                        <td><div class="text-wrap">Liburan</div></td>
                                        <td>0</td>
                                        <td>-</td>
                                        <td>-</td>
                                        <td class="text-center"><a href="#" class="kt-link" data-toggle="modal" data-target="#kt_modal_1">View</a></td>
                                        <td class="text-center"><a href="#" class="kt-link" data-toggle="modal" data-target="#kt_modal_4"><i class="la la-file"></i> File</a></td>
                                        <td>
                                            <a type="button" href="javascript:;" class="btn-cancel btn btn-sm btn-clean btn-icon btn-icon-md" title="Cancel">
                                                <i class="la la-ban fa-lg text-danger"></i>
                                            </a>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>2022-12-23</td>
                                        <td>CT</td>
                                        <td>2022-12-23</td>
                                        <td>2022-12-26</td>
                                        <td><div class="text-wrap">Menghabiskan jatah cuti</div></td>
                                        <td>2</td>
                                        <td>1</td>
                                        <td>-</td>
                                        <td class="text-center"><a href="#" class="kt-link" data-toggle="modal" data-target="#kt_modal_1">View</a></td>
                                        <td class="text-center"><a href="#" class="kt-link" data-toggle="modal" data-target="#kt_modal_4"><i class="la la-file"></i> File</a></td>
                                        <td>
                                            <a type="button" href="javascript:;" class="btn-cancel btn btn-sm btn-clean btn-icon btn-icon-md disabled" title="Cancel">
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
                                    <label for="status" class="col-lg-auto col-form-label">Select Status</label>
                                    <div class="col-lg-3">
                                        <select class="form-control kt-select2" id="status" name="status">
                                            <option></option>
                                            <option>Pending</option>
                                            <option>Rejected</option>
                                            <option>Approved</option>
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
                                        <th>To User</th>
                                        <th>Create Date</th>
                                        <th>Start Date</th>
                                        <th>End Date</th>
                                        <th>Notes</th>
                                        <th>Status</th>
                                        <th>Detail</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>Dummy</td>
                                        <td>2022-12-23</td>
                                        <td>2022-12-23</td>
                                        <td>2022-12-26</td>
                                        <td><div class="text-wrap">Kecelakaan</div></td>
                                        <td>0</td>
                                        <td><a href="#" class="kt-link" data-toggle="modal" data-target="#kt_modal_1">View</a></td>
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
                <div class="tab-pane" id="kt_portlet_tab_3_3">
                    <div class="row">
                        <div class="col-lg-12">
                            <!--begin: Datatable -->
                            <table class="table table-striped- table-bordered table-hover table-checkable kt_table_2 w-100 nowrap">
                                <thead>
                                    <tr>
                                        <th>Time Of Code</th>
                                        <th>Effective Date</th>
                                        <th>Type</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>I</td>
                                        <td>Wednesday, 7 Dec 2022</td>
                                        <td>Full Day</td>
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

<!-- Modal Time Off -->
<div class="modal fade" id="kt_modal_2" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Request Time Off</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                </button>
            </div>
            <form class="kt-form" action="">
              <div class="modal-body">
								<div class="form-group">
									<label for="type">Time Off Type<span class="text-danger">*</span></label>
									<select class="form-control kt-select2 w-100" onchange="toType(this)">
											<option></option>
                      <option value="ct">Cuti Tahunan</option>
                      <option value="izin">Izin</option>
                      <option value="sd">Sakit Dengan Surat Doktor</option>
                      <option value="dinas">Dinas Luar Kota</option>
                      <option value="gathering">Gathering Divisi</option>
									</select>
                </div>
                <div class="el-none1">
                  <div class="form-group">
                      <label for="reqtype">Request Type</label>
                      <select class="form-control kt-select2 w-100" id="reqtype" onchange="reqType(this)">
                          <option value="fd" selected>Full Day</option>
                          <option value="hd-before">Half Day - Before Break</option>
                          <option value="hd-after">Half Day - After Break</option>
                      </select>
                  </div>
                </div>
                <div class="el-none2">
                  <div class="form-group row">
                    <div class="col-lg-6">
                      <label>Schedule In</label>
                      <div class="row">
                        <div class="col-lg-6">
                          <div class="input-group input-group-sm">
                            <input type="text" class="form-control" maxlength="2" placeholder="Hour">
                          </div>
                        </div>
                        <div class="col-lg-6">
                          <div class="input-group input-group-sm">
                            <input type="text" class="form-control" maxlength="2" placeholder="Minutes">
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="col-lg-6">
                      <label>Schedule Out</label>
                      <div class="row">
                        <div class="col-lg-6">
                          <div class="input-group input-group-sm">
                            <input type="text" class="form-control" maxlength="2" placeholder="Hour">
                          </div>
                        </div>
                        <div class="col-lg-6">
                          <div class="input-group input-group-sm">
                            <input type="text" class="form-control" maxlength="2" placeholder="Minutes">
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="form-group row">
                  <div class="col-lg-6">
                    <label>Start Date<span class="text-danger">*</span></label>
                    <div class="input-group date">
                        <input type="text" class="form-control datepicker" value="{{date('d/m/Y')}}">
                        <div class="input-group-append">
                            <span class="input-group-text">
                                <i class="la la-calendar"></i>
                            </span>
                        </div>
                    </div>
                  </div>
                  <div class="col-lg-6">
                    <label>End Date<span class="text-danger">*</span></label>
                    <div class="input-group date">
                        <input type="text" class="form-control datepicker" value="{{date('d/m/Y')}}">
                        <div class="input-group-append">
                            <span class="input-group-text">
                                <i class="la la-calendar"></i>
                            </span>
                        </div>
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
                <div class="form-group">
                    <div class="kt-checkbox-inline">
                        <label class="kt-checkbox kt-checkbox--success">
                            <input type="checkbox" class="delegateTO"> Delegate To
                            <span></span>
                        </label>
                    </div>
                </div>
                <div class="form-group" id="delegateTO">
                    <select class="form-control kt-select2 w-100" id="delegate" name="delegate">
                        <option></option>
                        <option>DMY001 - Sintia</option>
                        <option>DMY002 - Andi</option>
                        <option>DMY003 - Nana</option>
                    </select>
                </div>
                <div class="form-group m-0">
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

<!-- Modal Delegation -->
<div class="modal fade" id="kt_modal_3" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Request Delegation</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                </button>
            </div>
            <form class="kt-form" action="">
              <div class="modal-body">
				        <div class="form-group">
                  <label for="compensation">Delegate From</label>
                  <input type="text" disabled value="DMY003 - {{Auth::guard('emp')->user()->full_name}}" class="form-control">
                </div>
                <div class="form-group">
                  <label for="delegate1">Delegate To<span class="text-danger">*</span></label>
                  <select class="form-control kt-select2 w-100" id="delegate1" name="delegate1">
                    <option></option>
                    <option>DMY001 - Sintia</option>
                    <option>DMY002 - Andi</option>
                    <option>DMY003 - Nana</option>
                  </select>
                </div>
                <div class="form-group">
                    <label>Start Date <span class="text-danger">*</span></label>
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
                    <label>End Date <span class="text-danger">*</span></label>
                    <div class="input-group date">
                        <input type="text" class="form-control" readonly="" value="05/20/2017" id="kt_datepicker_3">
                        <div class="input-group-append">
                            <span class="input-group-text">
                                <i class="la la-calendar"></i>
                            </span>
                        </div>
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
                <h5 class="modal-title" id="exampleModalLabel">Time Off Request File</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                </button>
            </div>
            <div class="modal-body">
              <!--begin: Datatable -->
              <table class="table table-striped- table-bordered table-hover m-0">
                  <thead>
                      <tr>
                          <th>Time Off Type</th>
                          <th>Start Date</th>
                          <th>End Date</th>
                          <th>File Name</th>
                          <th>Action</th>
                      </tr>
                  </thead>
                  <tbody>
                      <tr>
                        <td>Cuti Tahunan</td>
                        <td>2022-12-23</td>
                        <td>2022-12-23</td>
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
              targets: 5,
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

  if(document.querySelector('.delegateTO').checked ? $("#delegateTO").show() : $("#delegateTO").hide())
  $('.delegateTO').click(function() { $("#delegateTO").toggle(this.checked); });

  function reqType(el){
      $(".el-none2").css("display", el.value == "hd-before" || el.value == "hd-after"  ? "block" : "none")
  }

  function toType(e){
      $(".el-none1").css("display", e.value == "izin"  ? "block" : "none")
      $(".el-none2").css("display", e.value !== "izin" || $("#reqtype :selected").val() == 'fd'  ? "none" : "block")
  }
</script>
@endpush