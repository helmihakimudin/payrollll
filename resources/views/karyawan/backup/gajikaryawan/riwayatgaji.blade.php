@extends('karyawan.gajikaryawan.app-edit',[
	'pages'=>'payroll',
	'subpages'=>'gaji',
	'menuaside'=>'riwayat-gaji'
])

@section('content-gaji')
<div class="kt-portlet__head">
	<div class="kt-portlet__head-label">
		<h3 class="kt-portlet__head-title">Riyawat Gaji Karyawan</h3>
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
	   <!--begin: Datatable -->
	   <div class="row">
		<div class="col-lg-12">
			<table class="table table-striped- table-bordered table-hover table-checkable dataTable no-footer dtr-inline" id="slipgaji-table">
				<thead>
					<tr role="row">
						<th width="15%">Gaji Bulan</th>
						<th width="15%">Tipe Gaji</th>
						<th width="20%">Gaji Pokok</th>
						<th width="20%">Gaji Bersih</th>
						<th width="10%">Status</th>
						<th width="20%">Aksi</th>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td colspan="6"></td>
					</tr>
				</tbody>
			</table>
		</div>
	</div>

	<!--end: Datatable -->
</div>
@endsection
@push('script')
<script>
var datatable1 = $("#slipgaji-table").DataTable({
	drawCallback:function(){$(".dataTables_paginate > .pagination").addClass("pagination-rounded")},
	"bFilter": true,
	responsive:true,
	paging:true,
	select:true,
	serverSide:true,
	"bInfo" : false,
	ajax:{
		url:'{{ route('karyawan.gaji.ajax.riwayatgaji') }}',
		type:'post',
		data:{"_token": "{{ csrf_token() }}"},
	},
	columns:[
		{ data:'salary_month'},
		{ data:'salary_type'},
		{ data:'basic_salary'},
		{ data:'net_payble'},
		{ data:'status'},
		{ data:'actions'},
	],
});

setInterval(() => {
	datatable1.ajax.reload();
}, 3000);
</script>
@endpush
