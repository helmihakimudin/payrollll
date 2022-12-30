@extends('karyawan.gajikaryawan.app-edit',[
	'pages'=>'payroll',
	'subpages'=>'gaji',
	'menuaside'=>'tunjangan'
])
@section('content-gaji')
<div class="kt-portlet__head">
	<div class="kt-portlet__head-label">
		<h3 class="kt-portlet__head-title">Pendapatan Karyawan</h3>
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
		<div class="col-lg-12">
			<div class="col-lg-12">
				<table class="table table-striped- table-bordered table-hover table-checkable dataTable no-footer dtr-inline gaji-table" id="tunjangan-table" >
					<thead>
						<tr role="row">
							<th>Jenis Pendapatan</th>
							<th>Total</th>
						</tr>
					</thead>
					<tbody>
						<tr>
							<td colspan="2"></td>
						</tr>
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>
@endsection
@push('script')
<script>
var datatable1 = $("#tunjangan-table").DataTable({
        drawCallback:function(){$(".dataTables_paginate > .pagination").addClass("pagination-rounded")},
        responsive:true,
        "bFilter": true,
        bStateSave: true,
        "bJQueryUI": true,
        paging:true,
        select:true,
        serverSide:true,
        ajax:{
            url:'{{ route('karyawan.gaji.ajax.tunjangan') }}',
            type:'post',
            data:{"_token": "{{ csrf_token() }}"},
        },
        columns:[
            { data:'name'},
            { data:'amount'},
        ],
    });
</script>
@endpush
