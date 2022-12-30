@extends('layout-admin.base', [
    'pages' => 'Setting Time Off',
    'subpages' => 'Setting Time Off',
])

@push('css')
<style>
    /* .disabled{
        cursor: not-allowed !important;
        pointer-events: auto !important;
        opacity: .3 !important;
    }  */

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
</style>            
@endpush
@section('content')
    <div class="kt-portlet">
        <div class="kt-portlet__head">
            <div class="kt-portlet__head-label">
                <h3 class="kt-portlet__head-title">Setting Time Off</h3>
            </div>
            <div class="kt-portlet__head-toolbar">
                <a href="{{ route('timeoff')}}" class="btn btn-sm btn-secondary btn-elevate mx-3 btn-icon-sm">
                    <i class="la la-arrow-left"></i>
                    Back
                </a>
            </div>
        </div>
        <div class="kt-portlet__body">
            <div class="row">
				<form action="{{route('timeoff.setting.update')}}" method="post" multiple="multiple">
					@csrf
					@method('put')
                <div class="col-lg-12">
                    <!--begin: Datatable -->
                    <table class="table table-striped- table-bordered table-hover table-checkable kt_table_1 mt-0">
                        <thead>
                            <tr>
                                <th width="10px">No</th>
                                <th>Code</th>
                                <th>Name</th>
                                <th>Duration</th>
                                <th>Include Day Off</th>
                                <th>Allow Half Day</th>
                                <th>Set Schedule (half day)</th>
                                <th>Set Default</th>
                                <th>Emerge at Join (Default Only)</th>
                                <th>Show</th>
                                <th>Max Request (in a row)</th>
                                <th>Allow Minus</th>
                                <th>Minus Amount</th>
                                <th>Carry Forward</th>
                                <th>Carry Amount</th>
                                <th>Carry Expired (month)</th>
                                <th>Time Off Compensation</th>
                                <th>Attachment Mandatory</th>
                            </tr>
                        </thead>
                        <tbody>
								@foreach ($setting as $key => $item)
							@php
								$timeoff = App\Timeoff::where('id', $item->timeoff_id)->first();
							@endphp
							<tr class="text-center">
                                <td>{{$loop->index+1}}<input id="id" name="id[]" type="text" hidden value="{{$item->id}}" class="id form-control form-control-sm text-center " ></td>
                                <td>{{$timeoff->code}}
                                    <input id="timeoff_id" name="timeoff_id[]" type="text" value="{{$item->timeoff_id}}" class="form-control form-control-sm text-center" hidden>
                                </td>
                                <td>{{$timeoff->name}}</td>
                                <td><input maxlength="3" type="text" id="duration" name="duration[]" value="{{old('duration', $item->duration)}}" class="form-control form-control-sm text-center"></td>
								<td>
									<label class="kt-checkbox kt-checkbox--single kt-checkbox--brand">
                                        <input type="checkbox" id="include_day_off_cb_{{$item->id}}" name="include_day_off_cb[]" class="kt-group-checkable" {{$item->include_day_off == 1 ? 'checked' : ''}}>
                                        
										<span></span>
									</label>
                                    <input type="text" id="include_day_off_{{$item->id}}" name="include_day_off[]" value="{{old('include_day_off', $item->include_day_off)}}" class="form-control form-control-sm text-center" hidden>
								</td>
								<td>
									<label class="kt-checkbox kt-checkbox--single kt-checkbox--brand">
                                        <input type="checkbox" id="allow_half_day_cb_{{$item->id}}" name="allow_half_day_cb[]" class="kt-group-checkable" {{$item->allow_half_day == 1 ? 'checked' : ''}}>
                                        <span></span>
									</label>
                                    <input type="text" id="allow_half_day_{{$item->id}}" value="{{old('allow_half_day', $item->allow_half_day)}}" name="allow_half_day[]" class="form-control form-control-sm text-center" hidden>
								</td>
									<td>
										<label class="kt-checkbox kt-checkbox--single kt-checkbox--brand">
												<input type="checkbox" id="set_schedule_half_day_cb_{{$item->id}}" name="set_schedule_half_day_cb[]"  class="kt-group-checkable" {{$item->set_schedule_half_day == 1 ? 'checked' : ''}}>
												<span></span>
										</label>
                                        <input type="text" id="set_schedule_half_day_{{$item->id}}" name="set_schedule_half_day[]" class="form-control form-control-sm text-center" value="{{old('set_schedule_half_day', $item->set_schedule_half_day)}}" hidden>

									</td>
									<td>
										<label class="kt-checkbox kt-checkbox--single kt-checkbox--brand">
												<input type="checkbox" id="set_default_cb_{{$item->id}}" name="set_default_cb[]"  class="kt-group-checkable" {{$item->set_default == 1 ? 'checked' : ''}}>
												<span></span>
										</label>
                                        <input type="text" id="set_default_{{$item->id}}" name="set_default[]" class="form-control form-control-sm text-center" value="{{old('set_default', $item->set_default)}}" hidden>

									</td>
									<td>
										<label class="kt-checkbox kt-checkbox--single kt-checkbox--brand">
												<input type="checkbox" id="emerge_at_join_cb_{{$item->id}}" name="emerge_at_join_cb[]" class="kt-group-checkable" {{$item->emerge_at_join == 1 ? 'checked' : ''}}>
												<span></span>
										</label>
                                        <input type="text" id="emerge_at_join_{{$item->id}}" name="emerge_at_join[]" class="form-control form-control-sm text-center" value="{{old('emerge_at_join', $item->emerge_at_join)}}" hidden>
									</td>
									<td>
										<label class="kt-checkbox kt-checkbox--single kt-checkbox--brand">
                                            <input type="checkbox" id="show_cb_{{$item->id}}" name="show_cb[]"  class="kt-group-checkable" {{$item->show == 1 ? 'checked' : ''}}>
                                            <span></span>
										</label>
                                        <input type="text" id="show_{{$item->id}}" name="show[]" class="form-control form-control-sm text-center" value="{{old('show', $item->show)}}" hidden>

									</td>
									<td><input maxlength="3" type="text" id="max_request" name="max_request[]" value="{{old('max_request', $item->max_request)}}" class="form-control form-control-sm text-center"></td>
									<td>
										<label class="kt-checkbox kt-checkbox--single kt-checkbox--brand">
												<input type="checkbox" id="allow_minus_cb_{{$item->id}}" name="allow_minus_cb[]" class="kt-group-checkable" {{$item->allow_minus == 1 ? 'checked' : ''}}>
												<span></span>
										</label>
                                        <input type="text" id="allow_minus_{{$item->id}}" name="allow_minus[]" class="form-control form-control-sm text-center" value="{{old('allow_minus', $item->allow_minus)}}" hidden>

									</td>
									<td><input maxlength="3" type="text" id="minus_amount" name="minus_amount[]" value="{{old('minus_amount', $item->minus_amount)}}" class="form-control form-control-sm text-center"></td>
									<td>
										<label class="kt-checkbox kt-checkbox--single kt-checkbox--brand">
												<input type="checkbox" id="carry_forward_cb_{{$item->id}}" name="carry_forward_cb[]" {{$item->carry_forward == 1 ? 'checked' : ''}} class="kt-group-checkable">
												<span></span>
										</label>
                                        <input type="text" id="carry_forward_{{$item->id}}" name="carry_forward[]" value="{{old('carry_forward', $item->carry_forward)}}" class="form-control form-control-sm text-center" hidden>

									</td>
									<td><input maxlength="3" type="text" id="carry_amount" name="carry_amount[]" value="{{old('carry_amount', $item->carry_amount)}}" class="form-control form-control-sm text-center"></td>
									<td><input maxlength="3" type="text" id="carry_expired" name="carry_expired[]" value="{{old('carry_expired', $item->carry_expired)}}" class="form-control form-control-sm text-center"></td>
									<td>
										<label class="kt-checkbox kt-checkbox--single kt-checkbox--brand">
												<input type="checkbox" id="time_off_compensation_cb_{{$item->id}}" name="time_off_compensation_cb[]"  class="kt-group-checkable" {{$item->time_off_compensation == 1 ? 'checked' : ''}}>
												<span></span>
										</label>
                                        <input type="text" id="time_off_compensation_{{$item->id}}" name="time_off_compensation[]" value="{{old('time_off_compensation', $item->time_off_compensation)}}" class="form-control form-control-sm text-center" hidden>

									</td>
									<td>
										<label class="kt-checkbox kt-checkbox--single kt-checkbox--brand">
												<input type="checkbox" id="attachment_mandatory_cb_{{$item->id}}" name="attachment_mandatory_cb[]"  class="kt-group-checkable" {{$item->attachment_mandatory == 1 ? 'checked' : ''}}>
												<span></span>
										</label>
                                        <input type="text" id="attachment_mandatory_{{$item->id}}" name="attachment_mandatory[]" value="{{old('attachment_mandatory', $item->attachment_mandatory)}}" class="form-control form-control-sm text-center" hidden>

									</td>
                            </tr>
							@endforeach
							
							
                            
                        </tbody>
                    </table>
                    <!--end: Datatable -->
                </div>
								<div class="col-lg-12 text-right">
										<hr>
										<div class="kt-form__actions">
												<button type="submit" class="btn btn-primary">Submit</button>
										</div>
								</div>
							</form>
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
            });
        }();

 
        $(document).ready(function(){
            $('.id').each(function(){
                // console.log($(this).val());
                let id = $(this).val();
                // console.log(id);
                    $('#include_day_off_cb_'+id).click(function() {
                        if($('#include_day_off_cb_'+id).prop("checked") == true) {
                        $('#include_day_off_'+id).attr("value", 1);
                        // console.log($(this).attr('id'));
                        // console.log($('#include_day_off_'+id).val());
                        }
                        else if($('#include_day_off_cb_'+id).prop("checked") == false) {
                        $('#include_day_off_'+id).attr("value", 0);
                        // console.log("Checkbox is unchecked.");
                        // console.log($('#include_day_off_'+id).val());
                        }
                     });

                     $('#allow_half_day_cb_'+id).click(function() {
                        if($('#allow_half_day_cb_'+id).prop("checked") == true) {
                        $('#allow_half_day_'+id).attr("value", 1);
                        // console.log($(this).attr('id'));
                        // console.log($('#allow_half_day_'+id).val());
                        }
                        else if($('#allow_half_day_cb_'+id).prop("checked") == false) {
                        $('#allow_half_day_'+id).attr("value", 0);
                        // console.log("Checkbox is unchecked.");
                        // console.log($('#allow_half_day_'+id).val());
                        }
                     });

                     $('#set_schedule_half_day_cb_'+id).click(function() {
                        if($('#set_schedule_half_day_cb_'+id).prop("checked") == true) {
                        $('#set_schedule_half_day_'+id).attr("value", 1);
                        // console.log($(this).attr('id'));
                        // console.log($('#set_schedule_half_day_'+id).val());
                        }
                        else if($('#set_schedule_half_day_cb_'+id).prop("checked") == false) {
                        $('#set_schedule_half_day_'+id).attr("value", 0);
                        // console.log("Checkbox is unchecked.");
                        // console.log($('#set_schedule_half_day_'+id).val());
                        }
                     });

                     $('#set_default_cb_'+id).click(function() {
                        if($('#set_default_cb_'+id).prop("checked") == true) {
                        $('#set_default_'+id).attr("value", 1);
                        // console.log($(this).attr('id'));
                        // console.log($('#set_default_'+id).val());
                        }
                        else if($('#set_default_cb_'+id).prop("checked") == false) {
                        $('#set_default_'+id).attr("value", 0);
                        // console.log("Checkbox is unchecked.");
                        // console.log($('#set_default_'+id).val());
                        }
                     });

                     $('#emerge_at_join_cb_'+id).click(function() {
                        if($('#emerge_at_join_cb_'+id).prop("checked") == true) {
                        $('#emerge_at_join_'+id).attr("value", 1);
                        // console.log($(this).attr('id'));
                        // console.log($('#emerge_at_join_'+id).val());
                        }
                        else if($('#emerge_at_join_cb_'+id).prop("checked") == false) {
                        $('#emerge_at_join_'+id).attr("value", 0);
                        // console.log("Checkbox is unchecked.");
                        // console.log($('#emerge_at_join_'+id).val());
                        }
                     });

                     $('#show_cb_'+id).click(function() {
                        if($('#show_cb_'+id).prop("checked") == true) {
                        $('#show_'+id).attr("value", 1);
                        // console.log($(this).attr('id'));
                        // console.log($('#show_'+id).val());
                        }
                        else if($('#show_cb_'+id).prop("checked") == false) {
                        $('#show_'+id).attr("value", 0);
                        // console.log("Checkbox is unchecked.");
                        // console.log($('#show_'+id).val());
                        }
                     });

                     $('#allow_minus_cb_'+id).click(function() {
                        if($('#allow_minus_cb_'+id).prop("checked") == true) {
                        $('#allow_minus_'+id).attr("value", 1);
                        // console.log($(this).attr('id'));
                        // console.log($('#allow_minus_'+id).val());
                        }
                        else if($('#allow_minus_cb_'+id).prop("checked") == false) {
                        $('#allow_minus_'+id).attr("value", 0);
                        // console.log("Checkbox is unchecked.");
                        // console.log($('#allow_minus_'+id).val());
                        }
                     });

                     $('#carry_forward_cb_'+id).click(function() {
                        if($('#carry_forward_cb_'+id).prop("checked") == true) {
                        $('#carry_forward_'+id).attr("value", 1);
                        // console.log($(this).attr('id'));
                        // console.log($('#carry_forward_'+id).val());
                        }
                        else if($('#carry_forward_cb_'+id).prop("checked") == false) {
                        $('#carry_forward_'+id).attr("value", 0);
                        // console.log("Checkbox is unchecked.");
                        // console.log($('#carry_forward_'+id).val());
                        }
                     });

                     $('#time_off_compensation_cb_'+id).click(function() {
                        if($('#time_off_compensation_cb_'+id).prop("checked") == true) {
                        $('#time_off_compensation_'+id).attr("value", 1);
                        // console.log($(this).attr('id'));
                        // console.log($('#time_off_compensation_'+id).val());
                        }
                        else if($('#time_off_compensation_cb_'+id).prop("checked") == false) {
                        $('#time_off_compensation_'+id).attr("value", 0);
                        // console.log("Checkbox is unchecked.");
                        // console.log($('#time_off_compensation_'+id).val());
                        }
                     });

                     $('#attachment_mandatory_cb_'+id).click(function() {
                        if($('#attachment_mandatory_cb_'+id).prop("checked") == true) {
                        $('#attachment_mandatory_'+id).attr("value", 1);
                        // console.log($(this).attr('id'));
                        // console.log($('#attachment_mandatory_'+id).val());
                        }
                        else if($('#attachment_mandatory_cb_'+id).prop("checked") == false) {
                        $('#attachment_mandatory_'+id).attr("value", 0);
                        // console.log("Checkbox is unchecked.");
                        // console.log($('#attachment_mandatory_'+id).val());
                        }
                     });


                    

            });
        });
                       
  

    </script>
@endpush
