@extends('admin.gajikaryawan.app-edit',[
	'pages'=>'payroll',
	'subpages'=>'gaji',
	'menuaside'=>'tunjangan'
])

@section('content-gaji')
<!--begin::Modal-->
<div class="modal fade" id="ktmodal-edittunjangan" tabindex="-1" role="dialog" data-backdrop="static" data-keyboard="false" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalLabel">Edit Pendapatan</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				</button>
			</div>
			<div class="modal-body">
				<form action="{{route('gaji.tunjangan.update')}}" method="POST" class="form" id="form-potongan" enctype="multipart/form-data">
					{{ csrf_field() }}
					@method('PUT')
					<input type="hidden" name="id" id="id" autocomplete="off" class="form-control" required>
					<div class="form-group">
						<label>Jenis Pendapatan</label>
						<input type="text" name="name"  id="name" autocomplete="off" class="form-control" readonly required>
					</div>
					<div class="form-group">
						<label>Jumlah</label>
						<input type="text" name="amount"  id="amount" autocomplete="off" class="form-control"  required>
					</div>
				</form>
			</div>
			<div class="modal-footer">
				<button type="submit" form="form-potongan" class="btn btn-primary">Ubah</button>
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
			</div>
		</div>
	</div>
</div>
<!--end::Modal-->
<div class="kt-portlet__head">
	<div class="kt-portlet__head-label">
		<h3 class="kt-portlet__head-title">Pendapatan Karyawan</h3>
	</div>

	<div class="kt-portlet__head-toolbar">
		<div class="kt-portlet__head-wrapper">
			<div class="kt-portlet__head-actions">
				<div class="dropdown dropdown-inline">
					<div class="input-group">
						<div class="input-group-prepend"><span class="input-group-text"><i class="flaticon-calendar"></i></span></div>
						<input type="text" name="month" id="monthid" class="form-control month" placeholder="Bulan">
					</div>
				</div>
				&nbsp;
				@can('Save Pendapatan Karyawan')
				<button type="submit" form="form-tunjangan" class="btn btn-success btn-sm"><i class="la la-save"></i>Simpan</button>
				@endcan
			</div>
		</div>
	</div>
</div>
<div class="kt-portlet__body">
	<form action="{{route('gaji.tunjangan.store')}}" id="form-tunjangan" method="POST">
		{{ csrf_field() }}
		<div class="row">
			<input type="hidden" name="employee_id" id="karyawan_id" value="{{$karyawan->id}}">
			<div class="col-lg-6">
				<div class="form-group">
					<label>jenis Pendapatan</label>
					<select name="allowance_option" class="form-control select2" id="allowance_option">
						<option value="" selected></option>
						@foreach(DB::table('allowance_options')->get() as $row)
						<option value="{{$row->id}}">{{$row->name}}</option>
						@endforeach
					</select>
				</div>
			</div>
			<div class="col-lg-6">
				<div class="form-group">
					<label>Jumlah</label>
					<input type="number" name="amount" id="amount" class="form-control" required>
				</div>
			</div>
		</div>
	
	</form>
	<div class="row">
		<div class="col-lg-12">
			<div class="col-lg-12">
				<table class="table table-striped- table-bordered table-hover table-checkable dataTable no-footer dtr-inline gaji-table" id="tunjangan-table" >
					<thead>
						<tr role="row">
							<th>Jenis Tunjangan</th>
							<th>Total</th>
							<th>Aksi</th>
						</tr>
					</thead>
					<tbody>
						<tr>
							<td colspan="3"></td>
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

let month;
let employee_id; 
employee_id= $('#karyawan_id').val();


function edittunjangan(id){
    var id = $(id).data("id");
	$.get('/gaji/tunjangan/edit/'+id, function(data){
		$('#id').val(data.id);
		$('#name').val(data.name);
		$('#amount').val(data.amount);
        $('#ktmodal-edittunjangan').modal('show');
    });
}

$("[name='month']").change(function(){
	month = $(this).val();
	if(month != null){
		$('#tunjangan-table').DataTable().clear();
		$('#tunjangan-table').DataTable().destroy();
		getdtatatbletunjangan(month);
		$("[name='month']").val(month);
		localStorage.setItem('months',month);
	}

});

var months = localStorage.getItem('months');
month = $("[name='month']").val(months);

function getdtatatbletunjangan(months){
	var tunjangan = $("#tunjangan-table").DataTable({
		drawCallback:function(){$(".dataTables_paginate > .pagination").addClass("pagination-rounded")},
		responsive:true,
		"bFilter": true,
		bStateSave: true,
		"bJQueryUI": true,
		paging:true,
		select:true,
		serverSide:true,
		ajax:{
			url:'{{ route('gaji.ajax.tunjangan') }}',
			type:'post',
			data:{"_token": "{{ csrf_token() }}","employee_id":employee_id,"month":months},
		},
		columns:[
			{ data:'name'},
			{ data:'amount'},
			{ data:'actions'},
		],
	});
}
getdtatatbletunjangan(months);
</script>
@endpush
