@extends('admin.gajikaryawan.app-edit',[
	'pages'=>'payroll',
	'subpages'=>'gaji',
	'menuaside'=>'gaji'
])

@section('content-gaji')
<div class="kt-portlet__head">
	<div class="kt-portlet__head-label">
		<h3 class="kt-portlet__head-title">Gaji Karyawan</h3>
	</div>
	<div class="kt-portlet__head-toolbar">
		<div class="kt-portlet__head-wrapper">
			<div class="dropdown dropdown-inline">
			{{--  --}}
				@can('Save Gaji Karyawan')
					<button type="submit" form="form-gaji" class="btn btn-success btn-sm"><i class="la la-save"></i>Simpan</button>
				@endcan
			</div>
		</div>
	</div>
</div>
<div class="kt-portlet__body">
	<form action="{{route('gaji.simpan')}}" id="form-gaji" method="POST">
		{{ csrf_field() }}
		<div class="row">
			<input type="hidden" name="employee_id" id="karyawan_id" value="{{$karyawan->id}}">
			<div class="col-lg-6">
				<div class="form-group">
					<label>Jenis Penggajian</label>
					<select name="salary_type" class="form-control select2" id="salary_type" width="100%">
						@if($karyawan->salary_type != null)
						<option value="" selected></option>
						@foreach(DB::table('payslip_types')->get() as $row)
						<option @if($karyawan->salary_type == $row->id) {{"selected"}} @endif value="{{$row->id}}">{{$row->name}}</option>
						@endforeach
						@else 
						<option value="" selected></option>
						@foreach(DB::table('payslip_types')->get() as $row)
						<option value="{{$row->id}}">{{$row->name}}</option>
						@endforeach
						@endif
					</select>
				</div>
			</div>
			<div class="col-lg-6">
				<div class="form-group">
					<label>Gaji Pokok</label>
					<input type="number" name="salary" id="salary" value="{{$karyawan->salary}}" class="form-control" >
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-lg-2">
				<label>Hari Kerja (1 Bulan)</label>
				<div class="input-group">
					<div class="input-group-prepend"><span class="input-group-text"><i class="flaticon-calendar"></i></span></div>
					<input type="number" name="amount_work" value="{{$karyawan->amount_work}}" id="amount_work" class="form-control" value="20">
				</div>
			</div>
			<div class="col-lg-2">
				<label>Kehadiran </label>
				<div class="input-group">
					<div class="input-group-prepend"><span class="input-group-text"><i class="flaticon-calendar"></i></span></div>
					<input type="number" name="calculate_work"  value="{{$karyawan->calculate_work}}" id="calculate_work" class="form-control" >
				</div>
			</div>
			<div class="col-lg-8">
				<div class="form-group">
					<label>Gaji Prorate</label>
					<input type="number" name="net_salary" id="net_salary" value="{{$karyawan->net_salary}}" class="form-control" >
				</div>
			</div>
		</div>
	
	</form>

</div>
@endsection
@push('script')
{{-- <script>
$('#calculate_work').keyup(function(){
	var calculate = $(this).val();
    var result = calculate / $('#amount_work').val() * $('#salary').val();
	$('#net_salary').val(Math.ceil(result));
});

$('#amount_work').keyup(function(){
	var amount = $(this).val();
	var result = $("#amount_work").val() / amount * $('#salary').val();
	$('#net_salary').val(Math.ceil(result));
});
</script> --}}
@endpush

