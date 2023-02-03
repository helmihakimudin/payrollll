@extends('layout-admin.base', [
    'pages' => 'Salary Tax Calculator',
    'subpages' => 'Salary Tax Calculator',
])
@section('content')
<div class="row justify-content-center">
	<div class="col-lg-8">
		<div class="kt-portlet">
				<div class="kt-portlet__head">
						<div class="kt-portlet__head-label">
								<h3 class="kt-portlet__head-title">Salary Tax Calculator</h3>
						</div>
						<div class="kt-portlet__head-toolbar">
								<a href="{{ route('payroll')}}" class="btn btn-sm btn-secondary btn-elevate btn-icon-sm">
										<i class="la la-arrow-left"></i>
										Back
								</a>
						</div>
				</div>
				<div class="kt-portlet__body">
					<form action="">
						<div class="form-group row">
							<div class="col-lg-4">
								<label for="join_date">Join Date<span class="text-danger">*</span></label>
								<select class="form-control kt-select2" id="join_date" name="join_date">
										<option></option>
										<option value='1'>January</option>
										<option value='2'>February</option>
										<option value='3'>March</option>
										<option value='4'>April</option>
										<option value='5'>May</option>
										<option value='6'>June</option>
										<option value='7'>July</option>
										<option value='8'>August</option>
										<option value='9'>September</option>
										<option value='10'>October</option>
										<option value='11'>November</option>
										<option value='12'>December</option>
								</select>
							</div>
							<div class="col-lg-4">
								<label for="ptkp">PTKP<span class="text-danger">*</span></label>
								<select class="form-control kt-select2" id="ptkp" name="ptkp">
									<option></option>
									<option>TK/0 (54000000)</option>
									<option>TK/1 (58500000)</option>
									<option>TK/2 (63000000)</option>
									<option>TK/3 (67500000)</option>
									<option>K/0 (58500000)</option>
									<option>K/1 (63000000)</option>
									<option>K/2 (67500000)</option>
									<option>K/3 (72000000)</option>
								</select>
							</div>
							<div class="col-lg-4">
								<label for="tax_configration">Tax Configuration<span class="text-danger">*</span></label>
								<select class="form-control kt-select2" id="tax_configration" name="tax_configration">
									<option></option>
									<option>Default</option>
									<option>Gross</option>
									<option>Gross Up</option>
									<option>Netto</option>
								</select>
							</div>
						</div>
						<hr>
						{{-- Has NPWP --}}
						<div class="form-group">
							<div class="kt-checkbox-inline">
								<label class="kt-checkbox kt-checkbox--primary kt-checkbox--bold ">
									<input type="checkbox"> Has NPWP
									<span></span>
								</label>
							</div>
						</div>
						<div class="form-group row">
							<div class="col-lg-4 mb-3">
								<label>Basic Salary</label>
								<input type="text" class="form-control" placeholder="0">
							</div>
							<div class="col-lg-4 mb-3">
								<label>Total Allowance Taxable</label>
								<input type="text" class="form-control" placeholder="0">
							</div>
							<div class="col-lg-4 mb-3">
								<label>Total Deduction Taxable</label>
								<input type="text" class="form-control" placeholder="0">
							</div>
							<div class="col-lg-4 mb-3">
								<label>Total Allowance Non Taxable</label>
								<input type="text" class="form-control" placeholder="0">
							</div>
							<div class="col-lg-4 mb-3">
								<label>Total Deduction Non Taxable</label>
								<input type="text" class="form-control" placeholder="0">
							</div>
							<div class="col-lg-4 mb-3">
								<label>THR</label>
								<input type="text" class="form-control" placeholder="0">
							</div>
							<div class="col-lg-4">
								<label>Bonus</label>
								<input type="text" class="form-control" placeholder="0">
							</div>
						</div>
						<hr>
						{{-- BPJS TK --}}
						<div class="form-group">
							<div class="kt-checkbox-inline">
								<label class="kt-checkbox kt-checkbox--primary kt-checkbox--bold ">
									<input type="checkbox" class="bpjs-tk"> Has BPJS TK
									<span></span>
								</label>
							</div>
						</div>
						<div class="form-group row" id="bpjs-tk">
							<div class="col-lg-6 mb-3">
								<label>BPJS TK Rate</label>
								<input type="text" class="form-control" placeholder="0">
							</div>
							<div class="col-lg-6 mb-3">
								<div class="card bg-secondary">
									<div class="card-body">
										<h6>JHT : 3,7% by Company & 2% by Employee</h6>
										<h6 class="m-0">JKM : 0,3%</h6>
									</div>
								</div>
							</div>
							<div class="col-lg-6 mb-3">
								<label>JKK</label>
								<div class="kt-radio-inline">
									<label class="kt-radio kt-radio--success">
										<input type="radio" name="radio4"> 0,24%
										<span></span>
									</label>
									<label class="kt-radio kt-radio--success">
										<input type="radio" name="radio4"> 0,54%
										<span></span>
									</label>
									<label class="kt-radio kt-radio--success">
										<input type="radio" name="radio4"> 0,89%
										<span></span>
									</label>
									<label class="kt-radio kt-radio--success">
										<input type="radio" name="radio4"> 1,27%
										<span></span>
									</label>
									<label class="kt-radio kt-radio--success">
										<input type="radio" name="radio4"> 1,72%
										<span></span>
									</label>
								</div>
							</div>
							<div class="col-lg-6 mb-3">
								<div class="kt-checkbox-inline">
									<label class="kt-checkbox kt-checkbox--success">
										<input type="checkbox"> 2% by Company & 1% by Employee
										<span></span>
									</label>
								</div>
								<small>*Max for JP Rate 9.077.600</small>
							</div>
							<div class="col-lg-6 ">
								<div class="kt-checkbox-inline">
									<label class="kt-checkbox kt-checkbox--success">
										<input type="checkbox"> JHT By Company
										<span></span>
									</label>
								</div>
							</div>
							<div class="col-lg-6 ">
								<div class="kt-checkbox-inline">
									<label class="kt-checkbox kt-checkbox--success">
										<input type="checkbox"> JP By Company
										<span></span>
									</label>
								</div>
							</div>
						</div>
						<hr>
						{{-- BPJS Kes --}}
						<div class="form-group">
							<div class="kt-checkbox-inline">
								<label class="kt-checkbox kt-checkbox--primary kt-checkbox--bold ">
									<input type="checkbox" class="bpjs"> Has BPJS KESEHATAN
									<span></span>
								</label>
							</div>
						</div>
						<div class="form-group row" id="bpjs">
							<div class="col-lg-6 mb-3">
								<label>BPJS Kesehatan Rate</label>
								<input type="text" class="form-control" placeholder="0">
							</div>
							<div class="col-lg-6 mb-3">
								<div class="card bg-secondary">
									<div class="card-body">
										<h6 class="m-0">BPJS Kesehatan : 4% by Company & 1% by Employee</h6>
									</div>
								</div>
								<small>*Max for BPJS Kesehatan Rate 12,000,000</small>
							</div>
							<div class="col-lg-6">
								<div class="kt-checkbox-inline">
									<label class="kt-checkbox kt-checkbox--success">
										<input type="checkbox"> BPJS KESEHATAN By Company
										<span></span>
									</label>
								</div>
							</div>
						</div>
						<hr>
						<div class="col-lg-12 text-right">
								<div class="kt-form__actions">
										<button type="submit" class="btn btn-secondary mr-4">Reset</button>
										<button type="reset" class="btn btn-primary">Calculate</button>
								</div>
						</div>
					</form>
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

@endsection
@push('scriptjs')
<script src="{{ asset('demo10/assets/js/pages/crud/forms/widgets/bootstrap-datepicker.js')}}" type="text/javascript"></script>
<script>
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


		if(document.querySelector('.bpjs-tk').checked ? $("#bpjs-tk").show() : $("#bpjs-tk").hide())
		$('.bpjs-tk').click(function() {
				$("#bpjs-tk").toggle(this.checked);
		});
		
		if(document.querySelector('.bpjs').checked ? $("#bpjs").show() : $("#bpjs").hide())
		$('.bpjs').click(function() {
				$("#bpjs").toggle(this.checked);
		});
</script>
@endpush
