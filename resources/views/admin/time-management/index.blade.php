@extends('layout-admin.base', [
    'pages' => 'Time Management',
    'subpages' => 'Time Management',
])

@push('css')
	<style>
		.select2-container {
        display: block;
    }
	</style>
@endpush

@section('content')
    {{-- Body Datatables --}}

<div id="App">
    <div class="kt-body kt-grid__item kt-grid__item--fluid kt-grid kt-grid--hor kt-grid--stretch" id="kt_body">
        <div class="kt-content  kt-grid__item kt-grid__item--fluid kt-grid kt-grid--hor" id="kt_content">
            <div class="kt-subheader   kt-grid__item mt-0" id="kt_subheader">
                <div class="kt-container bg-primary py-4">
                    <div class="d-flex justify-content-between w-100 align-items-center">
                        <h3 class="kt-subheader__title m-0 text-light">
                            Attendance
                        </h3>
                        <div class="d-flex" id="kt_subheader_search">
                            <span class="kt-subheader__desc" id="kt_subheader_total">
                                <div class="dropdown">
                                    <button class="btn btn-outline-light dropdown-toggle" type="button"
                                        id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true"
                                        aria-expanded="false">
                                        More
                                    </button>
                                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                        <a class="dropdown-item" href="{{route('attendance')}}">Setting</a>
                                        <a class="dropdown-item" href="{{route('location')}}">Location</a>
                                    </div>
                                </div>
                            </span>
                            <span><a href="" class="btn btn-outline-light rounded-fill">Activity</a></span>
                            <span><a href="" class="btn btn-light rounded-fill">Attend Report</a></span>
                        </div>
                    </div>
                </div>
            </div>
            {{-- Date --}}
            <div class="kt-subheader   kt-grid__item mt-0 px-4" id="kt_subheader">
                <div class="kt-container border py-5 my-4">
                    <div class="kt-subheader__main d-flex justify-content-between w-100 align-items-center">
                        <div>
                            <span>This shows daily data in realtime</span>
                            <h2 class="kt-subheader__title m-0">
                                Today, <span class="ml-2" v-text="today"></span>
                            </h2>
                        </div>
                        <div class="d-flex align-items-center" id="kt_subheader_search">
                            <div class="pr-5">
                                <span>Employee</span>
                                <h2 class="kt-subheader__title m-0 text-primary" v-text="total_employee"></h2>
                            </div>
                            <span class="kt-subheader__separator kt-subheader__separator--v"></span>
                            <div class="pr-5">
                                <span>On Time</span>
                                <h2 class="kt-subheader__title m-0 text-primary" v-text="total_on_time"></h2>
                            </div>
                            <span class="kt-subheader__separator kt-subheader__separator--v"></span>
                            <div class="pr-5">
                                <span>Late In</span>
                                <h2 class="kt-subheader__title m-0 text-primary" v-text="total_late_in"></h2>
                            </div>
                            <span class="kt-subheader__separator kt-subheader__separator--v"></span>
                            <div class="pr-5">
                                <span>Absent</span>
                                <h2 class="kt-subheader__title m-0 text-primary" v-text="total_absent"></h2>
                            </div>
                            <span class="kt-subheader__separator kt-subheader__separator--v"></span>
                            <div class="pr-5">
                                <span>Time Off</span>
                                <h2 class="kt-subheader__title m-0 text-primary" v-text="total_time_off"></h2>
                            </div>
                            <span class="kt-subheader__separator kt-subheader__separator--v"></span>
                            <div class="pr-5">
                                <span>Day Off</span>
                                <h2 class="kt-subheader__title m-0 text-primary" v-text="total_day_off"></h2>
                            </div>
                            <span class="kt-subheader__separator kt-subheader__separator--v"></span>
                            <div class="pr-5">
                                <span>No Check In</span>
                                <h2 class="kt-subheader__title m-0 text-primary" v-text="total_no_clock_in"></h2>
                            </div>
                            <!-- <span class="kt-subheader__separator kt-subheader__separator--v"></span> -->
                            <!-- <div class="pr-5">
                                <a href="http://" class="font-weight-bold">See All ></a>
                            </div> -->
                        </div>
                    </div>
                </div>
            </div>
            {{-- Table --}}
            <div class="kt-container  kt-grid__item kt-grid__item--fluid">
                <div class="row">
                    <div class="col-lg-12">
                        <table
                            class="table table-striped table-bordered table-hover table-checkable kt_table_11"
                            style="font-size:11px;" id="attend-table">
                            <thead>
                                <tr role="row">
                                    <th>Employee Name</th>
                                    <th>Emp ID</th>
                                    <th>Date</th>
                                    <th>Shift</th>
                                    <th>Schedule in</th>
                                    <th>Schedule out</th>
                                    <th>Clock in</th>
                                    <th>Clock out</th>
                                    <th>Attendance Code</th>
                                    <th>Time Off Code</th>
                                    <th>Overtime</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td colspan="14"></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>



    <!--begin::Modal-->
    <div class="modal fade" id="kt_modal_1" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Edit attendance - <span v-text="edit_full_name"></span></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    </button>
                </div>
                <div class="modal-body">
                   <form action="">
                        <div class="form-group">
                            <label>Date<span class="text-danger">*</span></label>
                            <div class="input-group date">
                                <input id="edit-date" type="text" class="form-control" disabled value="{{ Carbon\Carbon::now()->locale('en')->isoFormat('D/M/YYYY') }}">
                                <div class="input-group-append">
                                    <span class="input-group-text">
                                        <i class="la la-calendar"></i>
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="shfit">Shift<span class="text-danger">*</span></label>
                            <select class="form-control kt-select2" id="select-shift" name="shfit">
                            </select>
                        </div>
                        <div class="form-group row">
                            <div class="col-lg-6">
                                <label for="employee">Clock In</label>
                                <div class="input-group date">
                                    <input type="text" class="form-control kt_datetimepicker_7" id="edit-clock-in" placeholder="clock in" />
                                    <div class="input-group-append">
                                        <span class="input-group-text">
                                            <i class="la la-calendar glyphicon-th"></i>
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <label for="employee">Clock Out</label>
                                <div class="input-group date">
                                    <input type="text" class="form-control kt_datetimepicker_7" id="edit-clock-out" placeholder="clock out" />
                                    <div class="input-group-append">
                                        <span class="input-group-text">
                                            <i class="la la-calendar glyphicon-th"></i>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-lg-12 mb-3">
                                <div class="kt-checkbox-inline">
                                    <label class="kt-checkbox kt-checkbox--success">
                                        <input type="checkbox" class="timeoff" id="show-time-off"> Time Off
                                        <span></span>
                                    </label>
                                </div>
                            </div>
                            <div class="col-lg-12" id="timeoff">
                                <label for="select_to">Select Time Off<span class="text-danger">*</span></label>
                                <select class="form-control kt-select2" id="select-time-off" name="select_to">
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="kt-checkbox-inline">
                                <label class="kt-checkbox kt-checkbox--success">
                                    <input type="checkbox" class="overtime" id="show-overtime"> Overtime
                                    <span></span>
                                </label>
                            </div>
                        </div>
                        <div class="form-group row overtime1">
                            <div class="col-lg-6">
                                <label>Before shift</label>
                                <div class="input-group input-group-sm">
                                    <div class="input-group-prepend"><span class="input-group-text">Duration</span></div>
                                    <input type="text" class="form-control kt_datetimepicker_7" id="edit-overtime-before">
                                    <div class="input-group-append">
                                        <span class="input-group-text">
                                            <i class="la la-clock-o glyphicon-th"></i>
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <label>After shift</label>
                                <div class="input-group input-group-sm">
                                    <div class="input-group-prepend"><span class="input-group-text">Duration</span></div>
                                    <input type="text" class="form-control kt_datetimepicker_7" id="edit-overtime-after">
                                    <div class="input-group-append">
                                        <span class="input-group-text">
                                            <i class="la la-clock-o glyphicon-th"></i>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row overtime1">
                            <div class="col-lg-6">
                                <label>Before break</label>
                                <div class="input-group input-group-sm">
                                    <div class="input-group-prepend"><span class="input-group-text">Duration</span></div>
                                    <input type="text" class="form-control kt_datetimepicker_7" id="edit-break-before">
                                    <div class="input-group-append">
                                        <span class="input-group-text">
                                            <i class="la la-clock-o glyphicon-th"></i>
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <label>After break</label>
                                <div class="input-group input-group-sm">
                                    <div class="input-group-prepend"><span class="input-group-text">Duration</span></div>
                                    <input type="text" class="form-control kt_datetimepicker_7" id="edit-break-after">
                                    <div class="input-group-append">
                                        <span class="input-group-text">
                                            <i class="la la-clock-o glyphicon-th"></i>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                   </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" @click="editSave" :class="edit_loading?'kt-spinner kt-spinner--sm kt-spinner--danger':''">Save</button>
                </div>
            </div>
        </div>
    </div>
    <!--end::Modal-->

    <!-- change modal -->
    <div class="modal fade" tabindex="-1" role="dialog" id="modal-confirm-delete">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Confirmation Delete</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                You will delete 1 attendance. Are you sure?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" @click="deleteAttendance" :class="delete_loading?'kt-spinner kt-spinner--sm kt-spinner--danger':''">Continue</button>
                </div>
            </div>
        </div>
    </div>
    <!-- end -->
    
</div>
@endsection
@push('scriptjs')
<script src="{{ asset('demo10/assets/js/pages/crud/forms/widgets/bootstrap-datepicker.js')}}" type="text/javascript"></script>
    <script>
			const vm = new Vue({
                el : '#App',
                data : {
                        today : '10 Agustus 2022',
                        total_employee : 0,
                        total_on_time : 0,
                        total_late_in : 0,
                        total_absent : 0,
                        total_time_off : 0,
                        total_day_off : 0,
                        total_no_clock_in : 0,
                        delete_loading : false,
                        attendance_id : '',
                        edit_full_name : '',
                        edit_loading : false
                },
                methods : {
                    getDailyData(){
                        //send
                        fetch(`{{route('attend.daily_data')}}`, {
                            method: 'post',
                            headers: {
                                    'Content-Type' : 'application/json',
                                    'X-CSRF-Token' : $('meta[name="csrf-token"]').attr('content')
                            }
                        }).then(async (responseTxt) => {
                                
                            const response = await responseTxt.json(responseTxt);
                            
                            if(response.status == '200'){
                                    //success response
                                    this.today = response.data.today;
                                    this.total_employee = response.data.total_employee;
                                    this.total_on_time = response.data.total_on_time;
                                    this.total_late_in = response.data.total_late_in;
                                    this.total_absent = response.data.total_absent;
                                    this.total_time_off = response.data.total_time_off;
                                    this.total_day_off = response.data.total_day_off;
                                    this.total_no_clock_in = response.data.total_no_clock_in;
                            }else{
                                    //error response
                            }

                        }).catch((error) => {
                            //error response
                            this.showAlert('Gagal', error.message, 'danger');
                        })
                    },
                    deleteAttendance(){

                        //send
                        fetch(`{{route('attendance-delete')}}`, {
                            method: 'post',
                            headers: {
                                    'Content-Type' : 'application/json',
                                    'X-CSRF-Token' : $('meta[name="csrf-token"]').attr('content')
                            },
                            body : JSON.stringify({
                                    id : this.attendance_id
                            })
                        }).then(async (responseTxt) => {
                                
                            const response = await responseTxt.json(responseTxt);
                            
                            if(response.status == '200'){
                                    //success response
                                    this.showAlert('Success', response.message);
                                    $('#modal-confirm-delete').modal('toggle');

                                    //refresh
                                    this.getDailyData();
                                    $('#attend-table').DataTable().ajax.reload();

                            }else{
                                    //error response
                                    this.showAlert('Gagal', response.message, 'danger');
                            }
                            
                        }).catch((error)=>{
                                //error response
                                this.showAlert('Gagal', error.message, 'danger');
                        })
                    },
                    attendanceDetail(id){

                        //set attendance id
                        this.attendance_id = id;
                        
                        //init shift
                        $('#select-shift').select2({
                            allowClear: false,
                            disabled: false,
                            placeholder: "Select Shift",
                            templateSelection: function (d) { return d.text },
                            ajax: {
                                url: "{{route('time.schedule.shift-list')}}",
                                headers: {
                                    'Content-Type' : 'application/json',
                                    'X-CSRF-Token' : $('meta[name="csrf-token"]').attr('content')
                                },
                                dataType: 'json',
                                type: "GET",
                                quietMillis: 50,
                                data: function (term) {
                                    return {
                                        q: term.term,
                                    };
                                },
                                processResults: function (data) {
                                    return {
                                        results: $.map(data.data, function (item) {
                                            return {
                                                text: item.name + ` (${item.working_hour_start.substr(0,5)} - ${item.working_hour_end.substr(0,5)})`,
                                                id: item.id,
                                            }
                                        })
                                    };
                                },
                            }
                        }).on('change', function(e) {

                        }).trigger('change'); 

                        $('#select-time-off').select2({
                            allowClear: false,
                            disabled: false,
                            placeholder: "Select Time Off",
                            templateSelection: function (d) { return d.text },
                            ajax: {
                                url: "{{route('time-off-list')}}",
                                headers: {
                                    'Content-Type' : 'application/json',
                                    'X-CSRF-Token' : $('meta[name="csrf-token"]').attr('content')
                                },
                                dataType: 'json',
                                type: "GET",
                                quietMillis: 50,
                                data: function (term) {
                                    return {
                                        q: term.term,
                                    };
                                },
                                processResults: function (data) {
                                    return {
                                        results: $.map(data.data, function (item) {
                                            return {
                                                text: item.name + ` (${item.code.substr(0,5)})`,
                                                id: item.id,
                                            }
                                        })
                                    };
                                },
                            }
                        }).on('change', function(e) {

                        }).trigger('change'); 

                        //send
                        fetch(`{{route('attendance-detail')}}`, {
                                method: 'post',
                                headers: {
                                        'Content-Type' : 'application/json',
                                        'X-CSRF-Token' : $('meta[name="csrf-token"]').attr('content')
                                },
                                body : JSON.stringify({
                                        id : id
                                })
                        }).then(async (responseTxt) => {
                                
                                const response = await responseTxt.json(responseTxt);
                                
                                if(response.status == '200'){
                                    //success response
                                    this.edit_full_name = response.data.full_name;
                                    this.shift_id = response.data.shift_id;
                                    $('#edit-date').val(response.data.date);

                                    $("#select-shift").val(response.data.shift_id).trigger('change');

                                    var $newOptionShift = $("<option selected='selected'></option>").val(response.data.shift_id).text(response.data.shift_name)
                                    $("#select-shift").append($newOptionShift).trigger('change');

                                    $('#edit-clock-in').val(response.data.clock_in.replace('-',''));
                                    $('#edit-clock-out').val(response.data.clock_out.replace('-',''));

                                    if(response.data.time_off_code != ''){
                                        
                                        $('#show-time-off').trigger('click');

                                        var $newOptionTimeOff = $("<option selected='selected'></option>").val(response.data.time_off_id).text(response.data.time_off_name)
                                        $("#select-time-off").append($newOptionTimeOff).trigger('change');
                                    }

                                    if(
                                        response.data.overtime_before != '' || response.data.break_before != '' ||
                                        response.data.overtime_after != '' || response.data.break_after != ''){

                                        $('#show-overtime').trigger('click');
                                    }

                                    $('#edit-overtime-before').val(response.data.overtime_before);
                                    $('#edit-break-before').val(response.data.break_before);
                                    $('#edit-overtime-after').val(response.data.overtime_after);
                                    $('#edit-break-after').val(response.data.break_after);

                                }else{
                                    //error response
                                    this.showAlert('Gagal', response.message, 'danger');
                                }

                        }).catch((error)=>{
                                //error response
                                this.showAlert('Gagal', error.message, 'danger');
                        });

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
                    setIdForDelete(id){
                        this.attendance_id = id;
                    },
                    editSave(){

                        this.edit_loading = true;

                        var isCheckedTimeOff = $('#show-time-off').is(':checked');
                        var isCheckedOvertime = $('#show-overtime').is(':checked');

                        let body = {
                            id : this.attendance_id,
                            shift_id : $('#select-shift').val(),
                            clock_in : $('#edit-clock-in').val(),
                            clock_out : $('#edit-clock-out').val(),
                            time_off_id : $('#select-time-off').val(),
                            overtime_before : $('#edit-overtime-before').val(),
                            break_before : $('#edit-break-before').val(),
                            overtime_after : $('#edit-overtime-after').val(),
                            break_after : $('#edit-break-after').val(),
                            show_time_off : isCheckedTimeOff,
                            show_overtime : isCheckedOvertime
                        }

                        //send
                        fetch(`{{route('attendance-edit-save')}}`, {
                                method: 'post',
                                headers: {
                                        'Content-Type' : 'application/json',
                                        'X-CSRF-Token' : $('meta[name="csrf-token"]').attr('content')
                                },
                                body : JSON.stringify(body)
                        }).then(async (responseTxt) => {
                            
                            this.edit_loading = false;
                                
                            const response = await responseTxt.json(responseTxt);
                            
                            if(response.status == '200'){
                                //success response
                                this.showAlert('Success', response.message, 'success');
                                $('#attend-table').DataTable().ajax.reload();
                            }else{
                                //error response
                                this.showAlert('Failed', response.message, 'danger');
                            }

                        }).catch((error)=>{
                            this.edit_loading = false;
                            //error response
                            this.showAlert('Failed', error.message, 'danger');
                        });
                    },
                },
                mounted(){
                        this.getDailyData()
                }
			});
    </script>
    <script>
            $('#kt_modal_1').on('hidden.bs.modal', function () {
                var isCheckedTimeOff = $('#show-time-off').is(':checked');
                var isCheckedOvertime = $('#show-overtime').is(':checked');

                $('#select-time-off').val('');

                $('#edit-overtime-after').val('');
                $('#edit-break-after').val('');
                $('#edit-overtime-before').val('');
                $('#edit-break-before').val('');

                if(isCheckedTimeOff){
                    $('#show-time-off').trigger('click');
                }
                if(isCheckedOvertime){
                    $('#show-overtime').trigger('click');
                }
            })

			$('#attend-table').DataTable({
                drawCallback: function() {
                        $(".dataTables_paginate > .pagination").addClass("pagination-rounded")
                },
                scrollX: true,
                bStateSave: true,
                select: false,
                serverSide: true,
                processing: true,
                paging: true,
                ajax: {
                        url: '{{ route("attend.ajax") }}',
                        type: 'post',
                        data: {
                                "_token": "{{ csrf_token() }}"
                        },
                },
                columns: [{
                        data: 'full_name'
                    },
                    {
                        data: 'employee_id'
                    },
                    {
                        data: 'date'
                    },
                    {
                        data: 'shift_name',
                        sortable: false
                    },
                    {
                        data: 'schedule_in',
                        sortable: false
                    },
                    {
                        data: 'schedule_out',
                        sortable: false
                    },
                    {
                        data: 'clock_in'
                    },
                    {
                        data: 'clock_out'
                    },
                    {
                        data: 'attendance_code'
                    },
                    {
                        data: 'time_off_code',
                        sortable: false
                    },
                    {
                        data: 'overtime',
                        sortable: false
                    },
                    {
                        data: 'actions',
                        sortable: false
                    },
                ],
			});

			$('.kt-select2').select2({
				placeholder: "Select on option",
			});

			$(".kt_datetimepicker_7").datetimepicker({
					format: 'hh:ii',
					todayHighlight: true,
					autoclose: true,
					startView: 1,
					minView: 0,
					forceParse: 0,
					pickerPosition: "top-left",
					language: moment.locale("en"),
					minuteStep: 1,
                    pickDate:false
			});

			if(document.querySelector('.timeoff').checked ? $("#timeoff").show() : $("#timeoff").hide())
  		$('.timeoff').click(function() { $("#timeoff").toggle(this.checked); });
			if(document.querySelector('.overtime').checked ? $(".overtime1").show() : $(".overtime1").hide())
  		$('.overtime').click(function() { $(".overtime1").toggle(this.checked); });
		</script>
@endpush
