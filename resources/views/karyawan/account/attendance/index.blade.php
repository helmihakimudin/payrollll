@extends('karyawan.account.index',[
	'pages'=>'time-management',
	'subpages'=>'attendance'
])

@push('css')
<style>
  .select2-container {
      display: block;
      width: 100%;
  }
</style>
@endpush
@section('content-account')
<div class="kt-portlet">
    <div class="kt-portlet__head">
        <div class="kt-portlet__head-label">
            <h3 class="kt-portlet__head-title">
                Attendance Information
            </h3>
        </div>
        <div class="kt-portlet__head-toolbar">
            <button data-toggle="modal" data-target="#kt_modal_3" class="btn btn-sm btn-outline-brand btn-elevate btn-icon-sm">
                Request Attendance
            </button>
        </div>
    </div>
    <div class="kt-portlet__body">
        <div class="row">
            <div class="col-lg px-lg-0 mb-4">
              <!--begin: Filter -->
              <form action="">
                <div class="form-group row m-0 align-items-end">
                  <label for="period" class="col-lg-auto col-form-label">Select Month & Years</label>
                  <div class="col-lg">
                    <div class="input-group date">
                      <input type="text" class="form-control kt_datetimepicker_3" id="period" value="{{date('m/Y')}}" />
                      <div class="input-group-append">
                        <span class="input-group-text">
                          <i class="la la-calendar glyphicon-th"></i>
                        </span>
                      </div>
                    </div>
                  </div>
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
                        <th>Start Date</th>
                        <th>Status</th>
                        <th>Detail</th>
                        <th>Approval</th>
                        <th>Action</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr>
                        <td>2022-12-26</td>
                        <td>2022-12-26</td>
                        <td>0</td>
                        <td><div class="text-wrap">DMY005 - Della requesting Attendance check in 09:00:00 on 2022-12-26 Notes: TEST DUMMY</div></td>
                        <td class="text-center"><a href="#" class="kt-link" data-toggle="modal" data-target="#kt_modal_1">View</a></td>
                        <td>
                          <a href="javascript:;" class="btn btn-sm btn-clean btn-icon btn-icon-md" title="Cancel">
                              <i class="la la-ban fa-lg text-danger" data-toggle="modal" data-target="#kt_modal_0"></i>
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

<!-- Modal Attendance -->
<div class="modal fade" id="kt_modal_3" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Request Attendance</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                </button>
            </div>
            <form class="kt-form" action="">
              <div class="modal-body">
                <div class="form-group">
                    <label>Effective Date <span class="text-danger">*</span></label>
                    <div class="input-group date">
                        <input type="text" class="form-control datepicker" value="{{date('d/m/Y')}}">
                        <div class="input-group-append">
                            <span class="input-group-text">
                                <i class="la la-calendar"></i>
                            </span>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label for="compensation">Shift</label>
                    <input type="text" disabled value="SPV-TM1 (in: 10:30:00 | out: 19:00:00 )" class="form-control" placeholder="1">
                </div>
                <div class="form-group row">
                  <div class="col-lg-6">
                    <div>
                      <div class="kt-checkbox-inline">
                        <label class="kt-checkbox kt-checkbox--success">
                          <input type="checkbox" class="checkIn"> Check In
                          <span></span>
                        </label>
                      </div>
                    </div>
                    <div class="mt-2" id="checkIn">
                      <div class="input-group date">
                        <input type="text" class="form-control kt_datetimepicker_7" placeholder="Select date" />
                        <div class="input-group-append">
                          <span class="input-group-text">
                            <i class="la la-calendar glyphicon-th"></i>
                          </span>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="col-lg-6">
                    <div>
                      <div class="kt-checkbox-inline">
                        <label class="kt-checkbox kt-checkbox--success">
                          <input type="checkbox" class="checkOut"> Check Out
                          <span></span>
                        </label>
                      </div>
                    </div>
                    <div class="mt-2" id="checkOut">
                      <div class="input-group date">
                        <input type="text" class="form-control kt_datetimepicker_7" placeholder="Select date" />
                        <div class="input-group-append">
                          <span class="input-group-text">
                            <i class="la la-calendar glyphicon-th"></i>
                          </span>
                        </div>
                      </div>
                    </div>
                  </div>
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
                <p class="text">Are you sure Cancel this Attemdance ? DMY005 - Della</p>
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


  $('.kt_datetimepicker_4').datepicker({
      locale: 'id',
      todayHighlight: true,
      autoclose: true,
      pickerPosition: 'bottom-left',
      todayBtn: true,
      format: "dd/mm/yyyy",
  });

  $(".kt_datetimepicker_7").datetimepicker({
      format: "hh:ii",
      autoclose: true,
      startView: 1,
      minView: 0,
      forceParse: 0,
      pickerPosition: "bottom-left",
  });

  if(document.querySelector('.checkIn').checked ? $("#checkIn").show() : $("#checkIn").hide())
  $('.checkIn').click(function() { $("#checkIn").toggle(this.checked); });

  if(document.querySelector('.checkOut').checked ? $("#checkOut").show() : $("#checkOut").hide())
  $('.checkOut').click(function() { $("#checkOut").toggle(this.checked); });
</script>
@endpush
