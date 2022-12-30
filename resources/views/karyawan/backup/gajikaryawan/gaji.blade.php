@extends('karyawan.gajikaryawan.app-edit',[
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
			</div>
		</div>
	</div>
</div>
<div class="kt-portlet__body">
	<div class="row">
		<input type="hidden" name="employee_id" id="karyawan_id" value="{{$karyawan->id}}">
		<div class="col-lg-6">
			<div class="form-group">
				<label>Jenis Penggajian</label>
				@php $jenisgaji = DB::table('payslip_types')->where('id',$karyawan->salary_type)->first() @endphp 
				@if(isset($jenisgaji->name))
				<input type="text" value="{{$jenisgaji->name}}" class="form-control" disabled readonly>
				@else 
				<input type="text" class="form-control"  placeholder="Jenis penggajian" disabled readonly>
				@endif
			</div>
		</div>
		<div class="col-lg-6">
			<div class="form-group">
				<label>Gaji Pokok</label>
				<input type="text" readonly disabled value="{{"Rp.".number_format($karyawan->salary,2,',','.')}}" class="form-control" >
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-lg-2">
			<label>Hadir </label>
			<div class="input-group">
				<div class="input-group-prepend"><span class="input-group-text"><i class="flaticon-calendar"></i></span></div>
				<input type="number" name="calculate_work" id="calculate_work" value="{{$karyawan->calculate_work}}" class="form-control" readonly disabled >
			</div>
		</div>
		<div class="col-lg-2">
			<label>Jumlah Hari Kerja</label>
			<div class="input-group">
				<div class="input-group-prepend"><span class="input-group-text"><i class="flaticon-calendar"></i></span></div>
				<input type="number" name="amount_work" id="amount_work" class="form-control" value="{{$karyawan->calculate_work}}" readonly disabled>
			</div>
		</div>
		<div class="col-lg-8">
			<div class="form-group">
				<label>Gaji Bersih</label>
				<input type="text" readonly disabled value="{{"Rp.".number_format($karyawan->net_salary,2,',','.')}}" class="form-control" >
			</div>
		</div>
	</div>
</div>
@endsection
@push('script')
<script>
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
</script>
@endpush

