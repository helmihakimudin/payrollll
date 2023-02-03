@extends('admin.karyawan.account.base',[
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
            <input type="hidden" id="empId" name="empId" value="{{Auth::user()->employee->id}}">
        </div>
        <div class="kt-portlet__head-toolbar">
            <button data-toggle="modal" data-target="#kt_modal_2" class="btn btn-sm btn-outline-brand btn-elevate mx-3 btn-icon-sm">
                Request Time Off
            </button>
            <button data-toggle="modal" id="request_delegation_btn" data-target="#kt_modal_3" class="btn btn-sm btn-outline-brand btn-elevate btn-icon-sm">
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
                        <div class="text-center text-primary">
                            @if($cuti) {{$cuti->ending_balance}} 
                            @else 0
                            @endif 
                            days</div> <small>Cuti Tahunan</small>
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
                                      <select class="form-control kt-select2" name="statusTimeoff" id="statusTimeoff">
                                          <option></option>
                                          <option value=" ">Select Option</option>
                                          <option value="PENDING">Pending</option>
                                          <option value="CANCELED">Canceled</option>
                                          <option value="REJECTED">Rejected</option>
                                          <option value="APPROVED">Approved</option>
                                      </select>
                                    </div>
                                    <label for="period" class="col-lg-auto col-form-label">Select Month & Years</label>
                                    <div class="col-lg">
                                        <div class="input-group date">
                                            <input type="text" name="month" class="form-control kt_datetimepicker_3" id="month" value="{{date('m/Y')}}" />
                                            <div class="input-group-append">
                                                <span class="input-group-text">
                                                    <i class="la la-calendar glyphicon-th"></i>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-auto">
                                        <button type="button" class="btn btn-outline-warning btn-elevate btn-icon-sm" onclick="filterTimeOffRequest()"><i class="la la-filter"></i>Filter</button>
                                    </div>
                                </div>
                            </form>
                            <!--end: Filter -->
                        </div>
                        <div class="col-lg-12">
                            <!--begin: Datatable -->
                            <table class="table table-striped- table-bordered table-hover table-checkable kt_table_1 w-100 nowrap" id="timeoffTable">
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
                                        <td colspan="11">
                                            <div class="text-center">Loading Data..</div>
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
                                        <select class="form-control kt-select2" id="statusDelegation" name="statusDelegation">
                                            <option></option>
                                            <option value=" ">Select Option</option>
                                            <option value="PENDING">Pending</option>
                                            <option value="CANCELED">Canceled</option>
                                            <option value="REJECTED">Rejected</option>
                                            <option value="APPROVED">Approved</option>
                                        </select>
                                    </div>
                                    <div class="col-lg-auto">
                                        <button type="button" onclick="filterDelegation()" class="btn btn-outline-warning btn-elevate btn-icon-sm"><i class="la la-filter"></i>Filter</button>
                                    </div>
                                </div>
                            </form>
                            <!--end: Filter -->
                        </div>
                        <div class="col-lg-12">
                            <!--begin: Datatable -->
                            <table class="table table-bordered table-hover table-checkable kt_table_1 w-100 nowrap" id="delegationTable">
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
                                        <td colspan="8">
                                            <div class="text-center">Loading Data..</div>
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
                            <table class="table table-striped- table-bordered table-hover table-checkable kt_table_2 w-100 nowrap" id="timeofftakenTable">
                                <thead>
                                    <tr>
                                        <th>Time Off Code</th>
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
            <form class="kt-form" action="{{route('employee.account.timeoff.post')}}" method="post" enctype="multipart/form-data">
            @csrf
              <div class="modal-body">
                <div class="form-group">
                    <label for="type">Time Off Type<span class="text-danger">*</span></label>
                    <select class="form-control kt-select2 w-100" onchange="toType(this)" name="timeoff_id">
                        <option></option>
                        @foreach ($timeoff as $item)
                            <option value="{{$item->id}}">{{$item->name}}</option>
                        @endforeach
                    </select>
                    @error('timeoff_id')
                            <div class="alert alert-danger alert-sm">{{ $message }}</div>
                      @enderror
                </div>
                <div class="el-none1">
                  <div class="form-group">
                      <label for="reqtype">Request Type</label>
                      <select class="form-control kt-select2 w-100" id="reqtype" onchange="reqType(this)" name="request_type"> 
                          <option value="FULL_DAY" selected>Full Day</option>
                          <option value="HALF_DAY_BEFORE_BREAK">Half Day - Before Break</option>
                          <option value="HALF_DAY_AFTER_BREAK">Half Day - After Break</option>
                      </select>
                      @error('request_type')
                            <div class="alert alert-danger alert-sm">{{ $message }}</div>
                      @enderror
                  </div>
                </div>
                <div class="el-none2">
                  <div class="form-group row">
                    <div class="col-lg-6">
                      <label>Schedule In</label>
                      <div class="row">
                        <div class="col-lg-6">
                          <div class="input-group input-group-sm">
                            <input type="time" class="form-control" placeholder="Hour" name="schedule_in">
                            @error('schedule_in')
                                <div class="alert alert-danger alert-sm">{{ $message }}</div>
                            @enderror
                          </div>
                        </div>
                        {{-- <div class="col-lg-6">
                          <div class="input-group input-group-sm">
                            <input type="time" class="form-control" maxlength="2" placeholder="Minutes" name="minute">
                          </div>
                        </div> --}}
                      </div>
                    </div>
                    <div class="col-lg-6">
                      <label>Schedule Out</label>
                      <div class="row">
                        <div class="col-lg-6">
                          <div class="input-group input-group-sm">
                            <input type="time" class="form-control" placeholder="Hour" name="schedule_out">
                            @error('schedule_out')
                                <div class="alert alert-danger alert-sm">{{ $message }}</div>
                             @enderror
                          </div>
                        </div>
                        {{-- <div class="col-lg-6">
                          <div class="input-group input-group-sm">
                            <input type="time" class="form-control" maxlength="2" placeholder="Minutes" name="minute2">
                          </div>
                        </div> --}}
                      </div>
                    </div>
                  </div>
                </div>
                <div class="form-group row">
                  <div class="col-lg-6">
                    <label>Start Date<span class="text-danger">*</span></label>
                    <div class="input-group date">
                        <input type="text" class="form-control datepicker" name="start_date">
                        @error('start_date')
                            <div class="alert alert-danger alert-sm">{{ $message }}</div>
                        @enderror
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
                        <input type="text" class="form-control datepicker" name="end_date">
                        @error('end_date')
                            <div class="alert alert-danger alert-sm">{{ $message }}</div>
                        @enderror
                        <div class="input-group-append">
                            <span class="input-group-text">
                                <i class="la la-calendar"></i>
                            </span>
                        </div>
                    </div>
                  </div>
                </div>

                <div class="form-group mt-3">
                    <label for="importExportTemplate" class="form-group-label">Image</label>
                    <input id="importExportTemplate" name="images[]" multiple id="images" type="file" class="form-control  @error('images') is-invalid @enderror" value="{{old('images')}}">
                    @error('images')
                    <div class="alert alert-danger">{{$message}}</div>
                    @enderror
                  </div>
                {{-- <div class="form-group">
                    <label for="importExportTemplate" class="form-group-label">Attach File</label>
                    <div class="custom-file">
                        <input id="importExportTemplate" name="images[]" id="images" multiple="multiple" type="file" accept=".pdf,.jpg,.png,.jpeg" class="custom-file-input">
                        <label for="importExportTemplate" class="custom-file-label is-ellipsis">No file selected</label>
                    </div>
                </div> --}}
                <div class="form-group">
                    <div class="kt-checkbox-inline">
                        <label class="kt-checkbox kt-checkbox--success">
                            <input type="checkbox" class="delegateTO"> Delegate To
                            <span></span>
                        </label>
                    </div>
                </div>
                <div class="form-group" id="delegateTO">
                    <select class="form-control kt-select2" id="select-employee" name="delegate" data-tags="true" style="width:100%" @error('delegate_to') is-invalid @enderror>
                        <option value="">Delegate To</option>
                    </select>
                    @error('delegate')
                        <div class="alert alert-danger alert-sm">{{ $message }}</div>
                    @enderror
                </div>
                <div class="form-group m-0">
                    <label for="notes">Notes<span class="text-danger">*</span></label>
                    <textarea class="form-control" id="notes" rows="3" name="notes"></textarea>
                    @error('notes')
                        <div class="alert alert-danger alert-sm">{{ $message }}</div>
                    @enderror
                </div>
              </div>
              <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                  <button type="submit" class="btn btn-primary" id="btnSubmits">Submit</button>
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
            <form class="kt-form" id="delegationStore" action="" method="post">
                @csrf
              <div class="modal-body">
				<div class="form-group">
                    <label for="compensation">Delegate From</label>
                    {{-- <input type="text" value="{{$karyawan->id}}" class="form-control"> --}}
                    <select class="form-control kt-select2 w-100" readonly id="delegateFrom" name="delegateFrom">
                        <option readonly value="{{$karyawan->id}}">{{$karyawan->employee_id}} - {{$karyawan->full_name}}</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="delegate1">Delegate To<span class="text-danger">*</span></label>
                    <select class="form-control kt-select2" id="select-employee2" name="employee_id" data-tags="true" style="width:100%" @error('employee_id') is-invalid @enderror>
                        <option value="">Delegate To</option>
                    </select>
                </div>
                
                <div class="form-group">
                    <label>Start Date <span class="text-danger">*</span></label>
                    <div class="input-group date">
                        <input type="text" class="form-control datepicker" name="start_date">
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
                        <input type="text" class="form-control datepicker" name="end_date">
                        <div class="input-group-append">
                            <span class="input-group-text">
                                <i class="la la-calendar"></i>
                            </span>
                        </div>
                    </div>
                </div>
                <div class="form-group m-0">
                    <label for="notes">Notes <span class="text-danger">*</span></label>
                    <textarea class="form-control" id="notes" name="notes" rows="3"></textarea>
                </div>
              </div>
              <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                  <button type="submit" class="btn btn-primary" id="btnSubmit">Submit</button>
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
            <div class="modal-body" id="delegationBody">
              <!--begin: Datatable -->

              <!--end: Datatable -->
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal Approval -->
<div class="modal fade" id="kt_modal_8" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Request Detail</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                </button>
            </div>
            <div class="modal-body" id="timeoffBody">
              <!--begin: Datatable -->

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
            <div class="modal-body" id="timeoffBodyImage">
              <!--begin: Datatable -->
              
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
                                <input type="hidden" name="idtime" id="idtime" value="">
						</div>
						<div class="modal-footer">
                            <form method="post" id="cancelTimeoff">
                                @csrf
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
								<button type="submit" id="btnCancel" class="btn btn-danger">Cancel</button>
                            </form>
								
						</div>
				</div>
		</div>
</div>

<div class="modal fade" id="kt_modal_100" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
            <div class="modal-content">
                    <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Warning !</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            </button>
                    </div>
                    <div class="modal-body">
                            <p class="text">Are you sure Cancel this Timeoff ?</p>
                            <input type="hidden" name="idtimeDelegation" id="idtimeDelegation" value="">
                    </div>
                    <div class="modal-footer">
                        <form method="post" id="cancelTimeoffDelegation">
                            @csrf
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" id="btnCancelDelegation" class="btn btn-danger">Cancel</button>
                        </form>
                            
                    </div>
            </div>
    </div>
</div>
@endsection
@push('scriptjs')
<script src='https://cdn.firebase.com/js/client/2.2.1/firebase.js'></script>
<script>
    

    $(document).ready(function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            
            filterTimeOffRequest();
            filterDelegation();
            igniteDelegation();
            igniteTimeOffRequest();
            igniteTaken();

            $('#kt_modal_1').on('show.bs.modal', event => {
                var delegation = $(event.relatedTarget).data('delegation');
                modalBody = $(this).find('#delegationBody');
                // show loading spinner while waiting for ajax to be done
                modalBody.html(`
                    <div class="text-center">
                    <div class="spinner-border" role="status">
                        <span class="sr-only">Loading...</span>
                    </div>
                    </div>
                `);

                $.ajax({
                    url: `/delegation-modal/${delegation}`, // the url for your show method
                    method: 'get'
                })
                .done(view => modalBody.html(view));
                // .fail(error => console.error(error));
            });

            $('#kt_modal_8').on('show.bs.modal', event => {
                var timeoff = $(event.relatedTarget).data('timeoff');
                modalBody = $(this).find('#timeoffBody');
                // show loading spinner while waiting for ajax to be done
                modalBody.html(`
                    <div class="text-center">
                    <div class="spinner-border" role="status">
                        <span class="sr-only">Loading...</span>
                    </div>
                    </div>
                `);

                $.ajax({
                    url: `/timeoff-modal/${timeoff}`, // the url for your show method
                    method: 'get'
                })
                .done(view => modalBody.html(view));
                // .fail(error => console.error(error));
            });

            $('#kt_modal_4').on('show.bs.modal', event => {
                var timeoff = $(event.relatedTarget).data('timeoff');
                modalBody = $(this).find('#timeoffBodyImage');
                // show loading spinner while waiting for ajax to be done
                modalBody.html(`
                    <div class="text-center">
                    <div class="spinner-border" role="status">
                        <span class="sr-only">Loading...</span>
                    </div>
                    </div>
                `);

                $.ajax({
                    url: `/timeoff-img-modal/${timeoff}`, // the url for your show method
                    method: 'get'
                })
                .done(view => modalBody.html(view));
                // .fail(error => console.error(error));
            });
            
        });

    $('a[data-toggle="tab"]').on('shown.bs.tab', function(e){
        $($.fn.dataTable.tables(true)).DataTable()
            .columns.adjust();
    });

    // $(document).on("click", '#btnSubmit', function(e) {
    //     e.preventDefault();

    //     let storageRef = firebase.storage().ref('attendanceImages');
    //     let fileUpload = document.getElementById("images");

    //     fileUpload.addEventListener('change', function(evt) {
    //         let firstFile = evt.target.files[0]; // upload the first file only
    //         let uploadTask = storageRef.put(firstFile);
    //     });
    // });
    var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');

    $(document).ready(function(){

        $('[data-toggle="tooltip"]').tooltip();

        $( "#select-employee" ).select2({
            templateResult: function(a) {
                var span = $("<span value="+a.id+" style='font-weight:bold'>"+a.text+"<br><small>"+a.employee_id + ' - ' + a.jp_name+"</small></span>");
                return span;
            },
            ajax: {
            url: "{{route('getEmployees')}}",
            type: "post",
            dataType: 'json',
            delay: 250,
            data: function (params) {
                return {
                id: params.id,
                _token: CSRF_TOKEN,
                search: params.term // search term
                };
            },
            processResults: function (response) {
                return {
                results: response
                };
            },
            cache: true
            }

        });

    });

    $(document).ready(function(){

    $('[data-toggle="tooltip"]').tooltip();

    $( "#select-employee2" ).select2({
        templateResult: function(a) {
            var span = $("<span value="+a.id+" style='font-weight:bold'>"+a.text+"<br><small>"+a.employee_id + ' - ' + a.jp_name+"</small></span>");
            return span;
        },
        ajax: {
        url: "{{route('getEmployees')}}",
        type: "post",
        dataType: 'json',
        delay: 250,
        data: function (params) {
            return {
            id: params.id,
            _token: CSRF_TOKEN,
            search: params.term // search term
            };
        },
        processResults: function (response) {
            return {
            results: response
            };
        },
        cache: true
        }

        });

    });

    function filterDelegation(){
            if($('#statusDelegation').val().length === 0){
                console.log("gagal");
            }
            else{                

                $('#delegationTable').DataTable().clear();
                $('#delegationTable').DataTable().destroy();

                let status = $('#statusDelegation').val();
                // console.log(status);

                igniteDelegationFilter(status);
            }
        }

    function igniteDelegationFilter(status) {
            // console.log(status);
            var table = $("#delegationTable");
            // begin first table
            table.DataTable({
                
                drawCallback:function(){$(".dataTables_paginate > .pagination").addClass("pagination-rounded")},
                // drawCallback: function() {
                //     $('[data-toggle="popover"]').popover();
                // },
                scrollX: true,
                bStateSave: true,
                selectedRow: true,
                serverSide:true,
                processing: true,
                paging:true,
                serverSide: true,
                language: {
					lengthMenu: "Display _MENU_",
				},
                
                // Order settings
               
                ajax: {
                    url: "{{ route('delegation.ajax') }}",
                    type: "POST",
                    data: {
                        "_token": "{{ csrf_token() }}",
                        "status": status
                    }
                },
                columns: [
                    {
                        data: 'full_name',
                        // orderable: false
                    },
                    {
                        data: 'crea',
                        // orderable: false
                    },
                    {
                        data: 'start_date',
                        // orderable: false
                    },
                    {
                        data: 'end_date',
                        // orderable: false
                    },
                    {
                        data: 'notes',
                        orderable: false
                    },
                    {
                        data: 'status',
                        // orderable: false
                    },
                    {
                        data: 'detail',
                        orderable: false
                    },
                    {
                        data: 'action',
                        orderable: false
                    }

                ],
            });
        }

    function igniteDelegation() {
            
            var table = $("#delegationTable");
            // begin first table
            table.DataTable({
                
                drawCallback:function(){$(".dataTables_paginate > .pagination").addClass("pagination-rounded")},
                // drawCallback: function() {
                //     $('[data-toggle="popover"]').popover();
                // },
                scrollX: true,
                bStateSave: true,
                selectedRow: true,
                serverSide:true,
                processing: true,
                paging:true,
                serverSide: true,
                language: {
					lengthMenu: "Display _MENU_",
				},
                
                // Order settings
               
                ajax: {
                    url: "{{ route('delegation.ajax') }}",
                    type: "POST",
                    data: {
                        "_token": "{{ csrf_token() }}",
                    }
                },
                columns: [
                    {
                        data: 'full_name',
                        // orderable: false
                    },
                    {
                        data: 'crea',
                        // orderable: false
                    },
                    {
                        data: 'start_date',
                        // orderable: false
                    },
                    {
                        data: 'end_date',
                        // orderable: false
                    },
                    {
                        data: 'notes',
                        orderable: false
                    },
                    {
                        data: 'status',
                        // orderable: false
                    },
                    {
                        data: 'detail',
                        orderable: false
                    },
                    {
                        data: 'action',
                        orderable: false
                    }

                ],
            });
        }

        function igniteTaken() {
            
            var table = $("#timeofftakenTable");
            // begin first table
            table.DataTable({
                
                drawCallback:function(){$(".dataTables_paginate > .pagination").addClass("pagination-rounded")},
                // drawCallback: function() {
                //     $('[data-toggle="popover"]').popover();
                // },
                scrollX: true,
                bStateSave: true,
                selectedRow: true,
                serverSide:true,
                processing: true,
                paging:true,
                serverSide: true,
                language: {
					lengthMenu: "Display _MENU_",
				},
                
                // Order settings
               
                ajax: {
                    url: "{{ route('timeoffTaken.ajax') }}",
                    type: "POST",
                    data: {
                        "_token": "{{ csrf_token() }}",
                    }
                },
                columns: [
                    {
                        data: 'code',
                        // orderable: false
                    },
                    {
                        data: 'start_date',
                        // orderable: false
                    },
                    {
                        data: 'request_type',
                        // orderable: false
                    }
                   
                ],
            });
        }

        function filterTimeOffRequest(){
            if($('#statusTimeoff').val().length === 0){
                console.log("gagal");
            }
            else{                

                $('#timeoffTable').DataTable().clear();
                $('#timeoffTable').DataTable().destroy();

                let status = $('#statusTimeoff').val();
                let month = $('#month').val();
                // console.log(status);

                igniteTimeOffRequestFilter(status, month);
            }
        }

        function igniteTimeOffRequestFilter(status, month) {
            
            var table = $("#timeoffTable");
            // begin first table
            table.DataTable({
                
                drawCallback:function(){$(".dataTables_paginate > .pagination").addClass("pagination-rounded")},
                // drawCallback: function() {
                //     $('[data-toggle="popover"]').popover();
                // },
                scrollX: true,
                bStateSave: true,
                selectedRow: true,
                serverSide:true,
                processing: true,
                paging:true,
                serverSide: true,
                language: {
					lengthMenu: "Display _MENU_",
				},
                
                // Order settings
               
                ajax: {
                    url: "{{ route('timeoffrequest') }}",
                    type: "POST",
                    data: {
                        "_token": "{{ csrf_token() }}",
                        "status": status,
                        "month": month
                    }
                },
                columns: [
                    {
                        data: 'created_at',
                        // orderable: false
                    },
                    {
                        data: 'code',
                        // orderable: false
                    },
                    {
                        data: 'start_date',
                        // orderable: false
                    },
                    {
                        data: 'end_date',
                        // orderable: false
                    },
                    {
                        data: 'note',
                        orderable: false
                    },
                    {
                        data: 'status',
                        orderable: false
                    },
                    {
                        data: 'taken',
                        orderable: false
                    },
                    {
                        data: 'cancel',
                        orderable: false
                    },
                    {
                        data: 'approval',
                        orderable: false
                    },
                    {
                        data: 'detail',
                        orderable: false
                    },
                    {
                        data: 'action',
                        orderable: false
                    }
                ],
            });
        }

        function igniteTimeOffRequest() {
            
            var table = $("#timeoffTable");
            // begin first table
            table.DataTable({
                
                drawCallback:function(){$(".dataTables_paginate > .pagination").addClass("pagination-rounded")},
                // drawCallback: function() {
                //     $('[data-toggle="popover"]').popover();
                // },
                scrollX: true,
                bStateSave: true,
                selectedRow: true,
                serverSide:true,
                processing: true,
                paging:true,
                serverSide: true,
                language: {
					lengthMenu: "Display _MENU_",
				},
                
                // Order settings
               
                ajax: {
                    url: "{{ route('timeoffrequest') }}",
                    type: "POST",
                    data: {
                        "_token": "{{ csrf_token() }}",
                    }
                },
                columns: [
                    {
                        data: 'created_at',
                        // orderable: false
                    },
                    {
                        data: 'code',
                        // orderable: false
                    },
                    {
                        data: 'start_date',
                        // orderable: false
                    },
                    {
                        data: 'end_date',
                        // orderable: false
                    },
                    {
                        data: 'note',
                        orderable: false
                    },
                    {
                        data: 'status',
                        orderable: false
                    },
                    {
                        data: 'taken',
                        orderable: false
                    },
                    {
                        data: 'cancel',
                        orderable: false
                    },
                    {
                        data: 'approval',
                        orderable: false
                    },
                    {
                        data: 'detail',
                        orderable: false
                    },
                    {
                        data: 'action',
                        orderable: false
                    }
                ],
            });
        }

        // cancel timeoff
        $(document).on("click", "#cancelButton", function(e){
            let id = $(this).data("id") ;
            // let id = $('#empId').val();
            var url = '{{ route("employee.account.timeoff.cancel", ":id") }}';
            url = url.replace(':id', id);
            $('#idtime').attr('value', id);
            $('#kt_modal_0 form').attr('action', url);
        });

        $(document).on("click", "#btnCancel", function(e) {
            e.preventDefault(); 
            e.stopPropagation(); 
            // var dataForms = new FormData($('#delegationStore')[0]); 
            let id = $('#idtime').val();;
            console.log(id);

            $.ajax({
                url: `/employee/account/timeoff/canceled/${id}`,
                type: "post",
                data: {"id": id},
                dataType: "json",
                processData: false,
                contentType: false,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(data) {
                    
                    $("#kt_modal_0").modal('hide');

                    Swal.fire(
                    'Sukses!',
                    'Delegation berhasil dibuat!',
                    'success'
                    );
                    
                    $('#timeoffTable').DataTable().draw();
                    $("#kt_modal_0")[0].reset();
                },
                error: function(data, xhr) {
                    Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Something went wrong!'
                    })
                }
            });
        });

        // cancel delegation
        $(document).on("click", "#cancelButtonDelegation", function(e){
            let id = $(this).data("id") ;
            // let id = $('#empId').val();
            var url = '{{ route("employee.account.timeoff.delegation.cancel", ":id") }}';
            url = url.replace(':id', id);
            $('#idtimeDelegation').attr('value', id);
            $('#kt_modal_100 form').attr('action', url);
        });

        $(document).on("click", "#btnCancelDelegation", function(e) {
            e.preventDefault(); 
            e.stopPropagation(); 
            // var dataForms = new FormData($('#delegationStore')[0]); 
            let id = $('#idtimeDelegation').val();;
            console.log(id);

            $.ajax({
                url: `/employee/account/timeoff/delegation/canceled/${id}`,
                type: "post",
                data: {"id": id},
                dataType: "json",
                processData: false,
                contentType: false,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(data) {
                    
                    $("#kt_modal_100").modal('hide');

                    Swal.fire(
                    'Sukses!',
                    'Delegation berhasil dibuat!',
                    'success'
                    );
                    
                    $('#delegationTable').DataTable().draw();
                    $("#kt_modal_100")[0].reset();
                },
                error: function(data, xhr) {
                    Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Something went wrong!'
                    })
                }
            });
        });

        $(document).on("click", "#request_delegation_btn", function(e){
            let id = $('#empId').val();
            var url = '{{ route("employee.account.timeoff.delegation", ":id") }}';
            url = url.replace(':id', id);
            $('#kt_modal_3 form').attr('action', url);
        });

        $(document).on("click", "#btnSubmit", function(e) {
            e.preventDefault(); 
            e.stopPropagation(); 
            var dataForms = new FormData($('#delegationStore')[0]); 
            let id = $('#empId').val();
           
            $.ajax({
                url: `/employee/account/timeoff/delegation/${id}`,
                type: "post",
                data: dataForms,
                dataType: "json",
                processData: false,
                contentType: false,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(data) {
                    
                    $("#kt_modal_3").modal('hide');

                    Swal.fire(
                    'Sukses!',
                    'Delegation berhasil dibuat!',
                    'success'
                    );
                    
                    $('#delegationTable').DataTable().draw();
                    $("#kt_modal_3")[0].reset();
                },
                error: function(data, xhr) {
                    Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Something went wrong!'
                    })
                }
            });
        });


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
      $(".el-none2").css("display", el.value == "HALF_DAY_BEFORE_BREAK" || el.value == "HALF_DAY_AFTER_BREAK"  ? "block" : "none")
  }

  function toType(e){
      $(".el-none1").css("display", e.value == 2  ? "block" : "none")
      $(".el-none2").css("display", e.value !== 2 || $("#reqtype :selected").val() == 'fd'  ? "none" : "block")
  }
</script>
@endpush