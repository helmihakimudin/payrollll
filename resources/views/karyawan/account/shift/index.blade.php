@extends('karyawan.account.index',[
	'pages'=>'time-management',
	'subpages'=>'shift'
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
                Shift Information
            </h3>
        </div>
        <div class="kt-portlet__head-toolbar">
            <button data-toggle="modal" data-target="#kt_modal_2" class="btn btn-sm btn-outline-brand btn-elevate mx-3 btn-icon-sm">
                Request Shift
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
                        <th>Effective Date</th>
                        <th>Current Shift</th>
                        <th>New Shift</th>
                        <th>Status</th>
                        <th>Detail</th>
                        <th>Approval</th>
                        <th>Action</th>
                      </tr>
                    </thead>
                    <tbody>
                    @foreach($requestShiftByEmployee as $data)
                      <tr>
                        <td>{{ \Carbon\Carbon::parse($data->effective_date)->format('d F Y')}}</td>
                        <td>{{$data->current_shift}}</td>
                        <td>{{$data->shift->name}}</td>
                        <td>{{$data->status}}</td>
                        <td>{{$data->notes}}</td>
                        <td><a href="#" class="kt-link" data-toggle="modal" data-target="#kt_modal_1">View</a></td>
                        <td>
                          <a href="javascript:;" class="btn btn-sm btn-clean btn-icon btn-icon-md" title="Cancel">
                              <i class="la la-ban fa-lg text-danger" data-toggle="modal" data-target="#kt_modal_0"></i>
                          </a>
                        </td>
                      </tr>
                    @endforeach
                    </tbody>
                </table>
                <!--end: Datatable -->
            </div>
        </div>
    </div>
    <!--end::Form-->
</div>

<!-- Modal Shift -->
<div class="modal fade" id="kt_modal_2" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Request Shift</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                </button>
            </div>
            <form class="kt-form" action="{{route('emp.account.request.shift')}}" method="post">
              @csrf
              @if ($errors->any())
              <div class="alert alert-danger">
                  <ul>
                      @foreach ($errors->all() as $error)
                      <li>{{ $error }}</li>
                      @endforeach
                  </ul>
              </div>
              @endif
              <div class="modal-body">
                <div class="form-group">
                    <label>Effective Date <span class="text-danger">*</span></label>
                    <div class="input-group date">
                        <input type="text" name="effective_date" class="form-control kt_datetimepicker_4" value="{{date('d/m/Y')}}" id="edate_shift" required>

                        <div class="input-group-append">
                            <span class="input-group-text">
                                <i class="la la-calendar"></i>
                            </span>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label for="compensation">Current Shift</label>
                    <input type="text" name="current_shift" class="form-control" id="current-shift" readonly required>
                </div>
                <div class="form-group">
                    <label for="new-shift">New Shift<span class="text-danger">*</span></label>
                    <select class="form-control kt-select2 w-100" id="new-shift" name="new_shift" required>
                        <option>Select Shift</option>
                        <option value="0">dayoff (in: 00:00:00 | out: 00:00:00 )</option>
                        @foreach($getShiftByEmployee as $value)
                          <option value="{{$value->shift->id}}">{{$value->shift->name}} (in: {{$value->shift->working_hour_start}} | out: {{$value->shift->working_hour_end}} )</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group m-0">
                    <label for="notes">Notes<span class="text-danger">*</span></label>
                    <textarea class="form-control" id="notes" rows="3" name="notes" requestShift></textarea>
                </div>
              </div>
              <div class="modal-footer">
                  <input type="hidden" name="employee_id" value="{{$karyawan->id}}"/>
                  <input type="hidden" name="job_level_id" value="{{$karyawan->job_level_id}}"/>
                  <input type="hidden" name="job_position_id" value="{{$karyawan->job_position_id}}"/>
                  <input type="hidden" name="organization_id" value="{{$karyawan->organization_id}}"/>
                  <input type="hidden" name="department_id" value="{{$karyawan->department_id}}"/>
                  <input type="hidden" name="branch_id" value="{{$karyawan->branch_id}}"/>
                  <input type="hidden" name="approval_line_id" value="{{$karyawan->approval_line_id}}"/>
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
                  
                    @foreach($requestShiftByEmployee as $value)
                      <tr>
                          <td>1</td>
                          <td>DMY001</td>
                          <td>Sintia</td>
                          <td><span class="kt-badge kt-badge--success kt-badge--dot"></span>&nbsp;<span class="kt-font-bold kt-font-success">Approved</span></td>
                          <td>-</td>
                          <td>-</td>
                          <td>2022-12-23 14:25:11</td>
                      </tr>
                    @endforeach
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
              targets: 3,
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
  }();

  $('.kt-select2').select2({
      placeholder: "Select on option",
  });

  $('#edate_shift').on('change', function(event) {
    event.preventDefault();
    let employeeId = "{{$karyawan->id}}";
    $.ajax({
        type: "POST",
        url: "{{route('emp.request.shift')}}",
        data: {
            "_token": "{{ csrf_token() }}",
            "effective_date": this.value,
            "employee" : employeeId
        },
        success: function(response){
            $("#current-shift").val(response);
        }
    });
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

  $('#edate_shift').on('change', function(event) {
    event.preventDefault();
    let employeeId = "{{$karyawan->id}}";
    $.ajax({
        type: "POST",
        url: "{{route('emp.request.shift')}}",
        data: {
            "_token": "{{ csrf_token() }}",
            "effective_date": this.value,
            "employee" : employeeId
        },
        success: function(response){
            $("#current-shift").val(response);
        }
    });
  });

  $(".kt_datetimepicker_7").datetimepicker({
      format: "hh:ii",
      autoclose: true,
      startView: 1,
      minView: 0,
      forceParse: 0,
      pickerPosition: "bottom-left",
  });

  @if ($errors->any())
      $('#kt_modal_2').modal('show');
  @endif
</script>
@endpush
