@extends('layout-admin.base', [
    'pages' => 'Setting Attemdance',
    'subpages' => 'Setting Attemdance',
])

@push('css')
	<style>
		.table th, .table td {
			vertical-align: middle;
		}
	</style>
@endpush

@section('content')

<div id="App">
	<form action="{{route('setting.attendance.store')}}" method="POST" @submit="onSubmit">
		@csrf
		<div class="card mb-4">
			<div class="card-header">
				<h4 class="kt-font-bolder m-0">Create Schedule</h4>
			</div>
			<div class="card-body">

				<div class="form-group row">
					<div class="col-lg-6">
						<label>Name <span class="text-danger">*</span></label>
						<input v-model="schedule_name" type="text" class="form-control" :class="schedule_name_error?'is-invalid':''" placeholder="Enter name" @change="schedule_name_error=''">
						<div v-show="schedule_name_error" class="invalid-feedback" v-text="schedule_name_error"></div>
					</div>
					<div class="col-lg-6">
						<label>Start Date <span class="text-danger">*</span></label>
						<div>
							<div class="input-group date">
								<date-picker v-model="start_date" :class="start_date_error?'is-invalid':''" @change="start_date_error = ''"></date-picker>
								<div class="input-group-append">
									<span class="input-group-text">
										<i class="la la-calendar"></i>
									</span>
								</div>
								<div v-show="start_date_error" class="invalid-feedback" v-text="start_date_error"></div>
							</div>
						</div>
					</div>
				</div>

				<div class="form-group row">
					<label class="col-lg-auto col-form-label">Settings :</label>
					<div class="col-lg-auto">
						<div class="kt-checkbox-inline">
							<label class="kt-checkbox kt-checkbox--success">
								<input name="is_overide_national_holiday" type="checkbox"> Overide national holiday
								<span></span>
							</label>
							<label class="kt-checkbox kt-checkbox--success">
								<input name="is_overide_company_holiday" type="checkbox"> Overide company holiday
								<span></span>
							</label>
							<label class="kt-checkbox kt-checkbox--success">
								<input name="is_flexible" type="checkbox"> Flexible
								<span></span>
							</label>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="kt-portlet">
			<div class="kt-portlet__head p-4">
				<div class="kt-portlet__head-label d-block">
					<h5 class="m-0">Set shift</h5>
					<small class="m-0">Set your shift combination for this schedule</small>
				</div>
				<div class="kt-portlet__head-toolbar">
					<div class="kt-portlet__head-actions">
						<a href="javascript:;" class="btn btn-outline-brand btn-bold btn-sm" @click="add_shift_success_alert = ''; add_shift_error_alert = ''" data-toggle="modal" data-target="#modalNewShift">
							New Shift
						</a>
					</div>
				</div>
			</div>
			<div class="kt-portlet__body p-3">
				<table class="table table-striped- table-hover kt_table_11">
					<thead>
						<tr>
							<th style="width:20%">Shift name <span class="text-danger">*</span></th>
							<th>Working hour</th>
							<th>Break</th>
							<th>OT before</th>
							<th>OT after</th>
							<!-- <th>Additional break</th> -->
							<!-- <th>Initial shift</th> -->
							<th></th>
						</tr>
					</thead>
					<tbody>
						<tr v-for="(shift, index) in shifts">
							<td>
								<select class="form-control shift kt-select2" :id="'shift-' + index" v-model="shift.id">
									<option value="" selected>--Select--</option>
									<option v-for="shift2 in shiftOption" :value="shift2.id">@{{shift2.name}}</option>
								</select>

								<div v-show="shift.error" class="invalid-feedback d-block" v-text="shift.error"></div>
							</td>
							<td v-text="shift.working_hour"></td>
							<td v-text="shift.break"></td>
							<td v-text="shift.overtime_before"></td>
							<td v-text="shift.overtime_after"></td>
							<!-- <td></td>
							<td>
								<span class="kt-switch kt-switch--outline kt-switch--icon kt-switch--success kt-switch--sm">
									<label class="m-0">
											<input type="checkbox" name="">
											<span class="m-0"></span>
									</label>
								</span>
							</td> -->
							<td>
								<a href="javascript:void(0);" @click="removeRowShift(index)" class="btn btn-remove btn-sm btn-label-google btn-icon btn-icon-md" title="Remove">
									<i class="la la-trash"></i>
								</a>
							</td>
						</tr>
					</tbody>
				</table>
				<div>
					<a href="javascript:void(0);" @click="addRowShift" class="btn-add btn btn-bold btn-sm btn-label-brand">
						<i class="la la-plus"></i> Add
					</a>
				</div>
			</div>
		</div>
		<button class="btn btn-primary float-right">Submit</button>
	</form>

	{{-- Modal New Shift --}}
	<div class="modal fade" id="modalNewShift" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" style="display: none;" aria-hidden="true">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="exampleModalLabel">Add Shift</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					</button>
				</div>
				<form class="kt-form" action="" @submit="createNewShift">
					<div class="modal-body">
						
						<div class="alert alert-success" role="alert" v-show="add_shift_success_alert">
							<div class="alert-icon"><i class="flaticon2-check-mark"></i></div>
							<div class="alert-text" v-text="add_shift_success_alert"></div>
						</div>

						<div class="alert alert-danger" role="alert" v-show="add_shift_error_alert">
							<div class="alert-icon"><i class="flaticon-warning"></i></div>
							<div class="alert-text" v-text="add_shift_error_alert"></div>
						</div>

						<div class="form-group">
							<label>Name <span class="text-danger">*</span></label>
							<input type="text" v-model="shift_name" class="form-control" :class="shift_name_error?'is-invalid':''" placeholder="Enter name">
							<div  v-text="shift_name_error" class="invalid-feedback"></div>
						</div>
						<div class="form-group">
							<div class="kt-checkbox-inline">
								<label class="kt-checkbox kt-checkbox--success">
									<input v-model="show_in_request" type="checkbox"> Show in request
									<span></span>
								</label>
							</div>
						</div>
						<div class="form-group row">
							<div class="col-lg-6">
								<label>Schedule in <span class="text-danger">*</span></label>
								<div class="input-group timepicker">
									<time-picker type="text" v-model="schedule_in" class="form-control kt_timepicker" :class="schedule_in_error?'is-invalid':''" placeholder="00:00"></time-picker>
									<div class="input-group-append">
										<span class="input-group-text">
											<i class="la la-clock-o"></i>
										</span>
									</div>
								</div>
								<div v-text="schedule_in_error" class="invalid-feedback d-block"></div>
							</div>
							<div class="col-lg-6">
								<label>Schedule out <span class="text-danger">*</span></label>
								<div class="input-group">
									<time-picker type="text" v-model="schedule_out" class="form-control kt_timepicker" :class="schedule_out_error?'is-invalid':''" placeholder="00:00"></time-picker>
									<div class="input-group-append">
										<span class="input-group-text">
											<i class="la la-clock-o"></i>
										</span>
									</div>
								</div>
								<div v-text="schedule_out_error" class="invalid-feedback d-block"></div>
							</div>
						</div>
						<div class="form-group">
							<div class="kt-checkbox-inline">
								<label class="kt-checkbox kt-checkbox--success">
									<input type="checkbox" class="grace"> Add grace period
									<span></span>
								</label>
							</div>
						</div>
						<div class="form-group row" id="grace" style="display:none">
							<div class="col-lg-6">
								<label>Clock in dispensation</label>
								<div class="input-group timepicker">
									<input v-model="clock_in_dispensation" type="number" class="form-control" maxlength="5" placeholder="Duration" aria-describedby="basic-addon2">
									<div class="input-group-append"><span class="input-group-text" id="basic-addon2">Minutes</span></div>
								</div>
							</div>
							<div class="col-lg-6">
								<label>Clock out dispensation</label>
								<div class="input-group timepicker">
									<input v-model="clock_out_dispensation" type="number" class="form-control" maxlength="5" placeholder="Duration" aria-describedby="basic-addon2">
									<div class="input-group-append"><span class="input-group-text" id="basic-addon2">Minutes</span></div>
								</div>
							</div>
						</div>
						<div class="form-group row">
							<div class="col-lg-6">
								<label>Break start <span class="text-danger">*</span></label>
								<div class="input-group timepicker">
									<time-picker v-model="break_start" class="form-control kt_timepicker" :class="break_start_error?'is-invalid':''" placeholder="00:00"></time-picker>
									<div class="input-group-append">
										<span class="input-group-text">
											<i class="la la-clock-o"></i>
										</span>
									</div>
								</div>
								<div v-text="break_start_error" class="invalid-feedback d-block"></div>
							</div>
							<div class="col-lg-6">
								<label>Break end <span class="text-danger">*</span></label>
								<div class="input-group timepicker">
									<time-picker v-model="break_end" class="form-control kt_timepicker" :class="break_end_error?'is-invalid':''" placeholder="00:00"></time-picker>
									<div class="input-group-append">
										<span class="input-group-text">
											<i class="la la-clock-o"></i>
										</span>
									</div>
								</div>
								<div v-text="break_end_error" class="invalid-feedback d-block"></div>
							</div>
						</div>
						<div class="form-group">
							<div class="kt-checkbox-inline">
								<label class="kt-checkbox kt-checkbox--success">
									<input type="checkbox" class="overtime"> Enable auto overtime
									<span></span>
								</label>
							</div>
						</div>
						<div class="form-group row" id="overtime" style="display:none">
							<div class="col-lg-6">
								<label>Overtime before</label>
								<div class="input-group timepicker">
									<time-picker v-model="overtime_before" class="form-control kt_timepicker" placeholder="00:00"></time-picker>
									<div class="input-group-append">
										<span class="input-group-text">
											<i class="la la-clock-o"></i>
										</span>
									</div>
								</div>
							</div>
							<div class="col-lg-6">
								<label>Overtime after</label>
								<div class="input-group timepicker">
								<time-picker v-model="overtime_after" class="form-control kt_timepicker" placeholder="00:00"></time-picker>
									<div class="input-group-append">
										<span class="input-group-text">
											<i class="la la-clock-o"></i>
										</span>
									</div>
								</div>
							</div>
						</div>
						<!-- <div class="form-group">
							<div class="kt-checkbox-inline">
								<label class="kt-checkbox kt-checkbox--success">
									<input type="checkbox" class="break"> Add break time
									<span></span>
								</label>
							</div>
						</div> -->
						<!-- <div class="form-group" id="break" style="display:none">
							<label>Additional break*</label>
							<div class="form-group">
								<select class="form-control kt-select2" >
									<option value="1">dayoff</option>
									<option value="2">CRM2</option>
									<option value="3">PROGRAMMER</option>
								</select>
							</div>
						</div> -->
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
						<button type="submit" class="btn btn-primary" :class="is_loading_add_shift?'kt-spinner kt-spinner--sm kt-spinner--danger':''">Submit</button>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>
@endsection

@push('scriptjs')

	<script>

	//create tag html
	Vue.component('date-picker',{
		template: `<input type="date" v-datepicker class="form-control" readonly :value="value" @input="update($event.target.value);">`,
		directives: {
			datepicker: {
				inserted (el, binding, vNode) {
					$(el).datepicker({
						autoclose: true,
						format: 'yyyy-mm-dd'
					}).on('changeDate',function(e){
						vNode.context.$emit('input', e.format(0))
						vNode.context.$emit('change', e.format(0))
					})
				}
			}
		},
		props: ['value'],
		methods: {
			update (v){
				this.$emit('input', v)
			}
		}
	});

	Vue.component('time-picker',{
		template: `<input type="text" v-timepicker readonly :value="value" @input="update($event.target.value);">`,
		directives: {
			timepicker: {
				inserted (el, binding, vNode) {
					setTimeout(() => {
						$(el).timepicker({
							timeFormat : 'HH:mm',
							minuteStep: 1,
							defaultTime: '',
							showSeconds: false,
							showMeridian: false,
							snapToStep: false,
							dynamic : true
						}).on('change',function(e){
							vNode.context.$emit('input', e.target.value)
							vNode.context.$emit('change', e.target.value)
						});
					}, 0);
				}
			}
		},
		props: ['value'],
		methods: {
			update (v){
				this.$emit('input', v)
			}
		}
	});

	const vm = new Vue({
		el: '#App',
		data:{
			schedule_name : '',
			schedule_name_error : '',
			start_date : '',
			start_date_error : '',
			shifts : [{
				id : '',
				working_hour : '',
				break : '',
				overtime_before : '',
				overtime_after : '',
				error : ''
			}],
			shiftOption : [],
			shift_name : '',
			shift_name_error : '',
			schedule_in : '',
			schedule_in_error : '',
			schedule_out : '',
			schedule_out_error : '',
			break_start : '',
			break_start_error : '',
			break_end : '',
			break_end_error : '',
			overtime_before : '',
			overtime_before_error : '',
			overtime_after : '',
			overtime_after_error : '',
			clock_in_dispensation : '',
			clock_in_dispensation_error : '',
			clock_out_dispensation : '',
			clock_out_dispensation_error : '',
			show_in_request : false,
			add_shift_success_alert : null,
			add_shift_error_alert : null,
			is_loading_add_shift : false
		},
		methods : {
			addRowShift() {
				this.shifts.push({
					id : '',
					working_hour : '',
					break : '',
					overtime_before : '',
					overtime_after : '',
					error : ''
				});

				setTimeout(() => {
					$('.kt-select2').select2().on('change', this.onChangeShift);
				}, 0);
			},
			removeRowShift(index) {
				this.shifts.splice(index,1);
			},
			onChangeShift(e){
				let index = parseInt(e.target.id.replace('shift-',''));
				let indexOption = this.shiftOption.findIndex((item)=>{return item.id==e.target.value});
				if(-1 == indexOption) {
					this.shifts[index].id = '';
					return;
				};

				this.shifts[index].error = '';

				this.shifts[index].id = this.shiftOption[indexOption].id;
				this.shifts[index].working_hour = this.shiftOption[indexOption].working_hour_start + '-' + this.shiftOption[indexOption].working_hour_end;
				this.shifts[index].break = (this.shiftOption[indexOption].break_start || '') + '-' + (this.shiftOption[indexOption].break_end || '');
				this.shifts[index].overtime_before = this.shiftOption[indexOption].overtime_before;
				this.shifts[index].overtime_after = this.shiftOption[indexOption].overtime_after;
			},
			onSubmit(e){
				console.log('onSubmit');

				if(!this.schedule_name)
					this.schedule_name_error = 'Name is required';

				if(!this.start_date)
					this.start_date_error = 'Start Date is required';

				for (const index in this.shifts) {
					if(this.shifts[index].id == ''){
						this.shifts[index].error = 'This field is required';
					}
				}

				e.preventDefault();
			},
			createNewShift(e){
				e.preventDefault();

				if(this.is_loading_add_shift){
					//hold execution
					return;
				}

				console.log('createNewShift');

				//init
				var isErr = false;

				//clean error
				this.shift_name_error = '';
				this.schedule_in_error = '';
				this.schedule_out_error = '';
				this.break_start_error = '';
				this.break_end_error = '';

				//validation
				if(!this.shift_name){
					this.shift_name_error = 'Shift Name is required';
					isErr = true;
				}

				if(!this.schedule_in){
					this.schedule_in_error = 'Schedule In is required';
					isErr = true;
				}

				if(!this.schedule_out){
					this.schedule_out_error = 'Schedule Out is required';
					isErr = true;
				}

				if(!this.break_start){
					this.break_start_error = 'Break Start is required';
					isErr = true;
				}

				if(!this.break_end){
					this.break_end_error = 'Break End is required';
					isErr = true;
				}

				if(isErr){
					//stop
					return;
				}

				//loading
				this.is_loading_add_shift = true;

				let body = {
						name : this.shift_name,
						schedule_in : this.schedule_in,
						schedule_out : this.schedule_out,
						break_start : this.break_start,
						break_end : this.break_end,
						overtime_before : this.overtime_before,
						overtime_after : this.overtime_after,
						show_in_request : this.show_in_request?1:0,
						clock_in_dispensation : this.clock_in_dispensation,
						clock_out_dispensation : this.clock_out_dispensation
					};

				//send
				fetch(`{{route('setting.attendance.storeshift')}}`, {
					method: 'post',
					headers: {
						'Content-Type' : 'application/json',
						'X-CSRF-Token' : $('meta[name="csrf-token"]').attr('content')
					},
					body: JSON.stringify(body)
				}).then(async (responseTxt) => {
					
					const response = await responseTxt.json(responseTxt);
					//stop loading
					this.is_loading_add_shift = false;
					
					if(response.status == '200'){
						//success response
						this.add_shift_success_alert = response.message;

						//clear form
					 	this.shift_name = '';
					 	this.schedule_in = '';
					 	this.schedule_out = '';
					 	this.break_start = '';
					 	this.break_end = '';
					 	this.overtime_before = '';
					 	this.overtime_after = '';
					 	this.show_in_request = false;
					 	this.clock_in_dispensation = '';
					 	this.clock_out_dispensation = '';
						$('.kt_timepicker').timepicker('setTime', '')

						//add to shift option
						this.getShifts()
					}else{
						//error response
						this.add_shift_error_alert = response.message;
					}
				}).catch(function (error){
					//stop loading
					this.is_loading_add_shift = false;
					//error response
					this.add_shift_error_alert = error.message;
				})
			},
			getShifts(){
				//send
				fetch(`{{route('setting.attendance.getshifts')}}`, {
					method: 'get',
					headers: {
						'Content-Type' : 'application/json',
						'X-CSRF-Token' : $('meta[name="csrf-token"]').attr('content')
					}
				}).then(async (responseTxt) => {
					
					const response = await responseTxt.json(responseTxt);
					
					if(response.status == '200'){
						//success response
						this.shiftOption = response.data;
					}else{
						//error response
						this.add_shift_error_alert = response.message;
					}
				}).catch(function (error){
					//error response
					alert('Error when get shifts : '+error.message);
				})
			}
		},
		mounted() {
			$('.kt-select2').select2().on('change', this.onChangeShift);

			//load shifts
			this.getShifts()
		}
	});
	</script>

	<script>
		if(document.querySelector('.grace').checked ? $("#grace").show() : $("#grace").hide())
		$('.grace').click(function() {
				$("#grace").toggle(this.checked);
		});
		// if(document.querySelector('.break').checked ? $("#break").show() : $("#break").hide())
		// $('.break').click(function() {
		// 		$("#break").toggle(this.checked);
		// });
		if(document.querySelector('.overtime').checked ? $("#overtime").show() : $("#overtime").hide())
		$('.overtime').click(function() {
				$("#overtime").toggle(this.checked);
		});

		$(document).on('show.bs.modal', '.modal', function (event) {
			const zIndex = 1045 + (10 * $('.modal:visible').length);
			// this zIndex can be assigned to the time-picker
			$(this).css('z-index', zIndex);
			setTimeout(function () {
				$('.modal-backdrop').not('.modal-stack').css('z-index', zIndex - 1).addClass('modal-stack');
			}, 0);
		});

	</script>
@endpush