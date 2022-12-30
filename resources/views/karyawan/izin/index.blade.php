@extends('karyawan-layout.base',[
	'pages'=>'Approval',
	'subpages'=>'izin'
])
@section('content')
<!--begin::Modal-->
<div class="modal fade" id="kt_modal1" tabindex="-1" role="dialog" data-backdrop="static" data-keyboard="false" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalLabel">Pengajuan Izin</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				</button>
			</div>
			<div class="modal-body">
				<form action="{{route('karyawan.izin.simpan')}}" method="POST" class="form" id="form-cuti" enctype="multipart/form-data">
					{{ csrf_field() }}
					<div class="form-group">
						<label>Izin</label>
						<select name="type_leave" id="typeleave" onchange="myFunction1()" class="form-control form-control-lg">
                            <option value="Izin Lainnya">Izin Lainnya</option>
							<option value="Sakit">Sakit</option>  
                        </select>
					</div>
					<div id="surat-sakit">
					<p id="demo"></p>
						
					</div>
					<div class="form-group">
						<label>Alasan izin</label>
						<textarea name="remark" id="remark" cols="30" rows="5"  autocomplete="off" class="form-control" required></textarea>
					</div>
					<div class="form-group">
						<label>Tanggal Izin</label>
						<div class="input-group">
							<div class="input-group-prepend"><span class="input-group-text"><i class="flaticon-calendar"></i></span></div>
							<input type="text" name="start_at" autocomplete="off" id="start_at" class="form-control datepicker"  required>
						</div>
					</div>
					<div class="form-group">
						<label>Sampai </label>
						<div class="input-group">
							<div class="input-group-prepend"><span class="input-group-text"><i class="flaticon-calendar"></i></span></div>
							<input type="text" name="end_at" autocomplete="off" id="end_at" class="form-control datepicker"  required>
						</div>
					</div>
				</form>
			</div>
			<div class="modal-footer">
				<button type="submit" form="form-cuti" class="btn btn-primary">Ajukan</button>
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
			</div>
		</div>
	</div>
</div>
<div class="modal fade" id="kt_modal_1_edit" tabindex="-1" role="dialog" data-backdrop="static" data-keyboard="false" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="modaltitles"></h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				</button>
			</div>
			<div class="modal-body">
				<p class="remark"></p>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
			</div>
		</div>
	</div>
</div>

<!--end::Modal-->

<div class="kt-content  kt-grid__item kt-grid__item--fluid kt-grid kt-grid--hor" id="kt_content">
<!-- begin:: Content Head -->
<div class="kt-subheader  kt-grid__item" id="kt_subheader">
	<div class="kt-container  kt-container--fluid ">
		<div class="kt-subheader__main">
			<h3 class="kt-subheader__title">Izin</h3>
			<span class="kt-subheader__separator kt-subheader__separator--v"></span>
			
	
			<div class="kt-input-icon kt-input-icon--right kt-subheader__search kt-hidden">
				<input type="text" class="form-control" placeholder="Search order..." id="generalSearch">
				<span class="kt-input-icon__icon kt-input-icon__icon--right">
					<span><i class="flaticon2-search-1"></i></span>
				</span>
			</div>
		</div>
		<div class="kt-subheader__toolbar">
			<div class="kt-subheader__wrapper">
				<button type="button" data-toggle="modal" data-target="#kt_modal1" class="btn btn-success btn-sm"><i class="flaticon-event-calendar-symbol"></i>Ajukan Izin</button>
			</div>
		</div>
	</div>
</div>
<!-- end:: Content Head -->
	<!-- begin:: Content -->
	<div class="kt-container  kt-container--fluid  kt-grid__item kt-grid__item--fluid">
		@include('message')
		<div class="row">
			<div class="col-lg-12">
				<div class="kt-portlet kt-portlet--mobile">
					<div class="kt-portlet__head kt-portlet__head--lg">
						<div class="kt-portlet__head-label">
							<span class="kt-portlet__head-icon">
								<i class="kt-font-brand flaticon flaticon-user"></i>
							</span>
							<h3 class="kt-portlet__head-title">
								Daftar Pengajuan Izin
							</h3>
						</div>
						<div class="kt-portlet__head-toolbar">
							<div class="kt-portlet__head-toolbar">
								<div class="kt-portlet__head-wrapper">
									<div class="kt-portlet__head-actions">
										<div class="dropdown dropdown-inline">
											<div class="input-group">
												<div class="input-group-prepend"><span class="input-group-text"><i class="flaticon-calendar"></i></span></div>
												<input type="text" name="month" value="{{date('Y-m')}}"  id="month-izin" class="form-control month" placeholder="Bulan">
											</div>
										</div>
									</div>
									&nbsp;
									<ul class="nav nav-tabs nav-bold nav-tabs-line">
										<li class="nav-item">
											<a class="nav-link active" data-toggle="tab" href="#kt_tab_pane_1_2">Pengajuan</a>
										</li>
										<li class="nav-item">
											<a class="nav-link" data-toggle="tab" href="#kt_tab_pane_2_2">Disetujui</a>
										</li>
										<li class="nav-item">
											<a class="nav-link" data-toggle="tab" href="#kt_tab_pane_3_2">Ditolak</a>
										</li>
									</ul>
								</div>
							</div>
						   
						</div>
					</div>

					<div class="kt-portlet__body">
						<!--begin: Datatable -->
						<div class="row">
							<div class="col-lg-12">
								<div class="tab-content">
									<div class="tab-pane fade show active" id="kt_tab_pane_1_2" role="tabpanel">
										<table class="table table-striped- table-bordered table-hover table-checkable dataTable no-footer dtr-inline cuti-table" id="clearance-request-table" >
											<thead>
												<tr role="row">
													<th>Tanggal</th>
													<th>Izin</th>
													<th>Alasan Izin</th>
													<th>Dari</th>
													<th>Sampai</th>
													<th>Persetujuan</th>
												</tr>
											</thead>
											<tbody>
												<tr>
													<td colspan="6"></td>
												</tr>
											</tbody>
										</table>
									</div>
									<div class="tab-pane fade" id="kt_tab_pane_2_2" role="tabpanel">
										<table class="table table-striped- table-bordered table-hover table-checkable dataTable no-footer dtr-inline cuti-table" id="clearance-accepted-table" >
											<thead>
												<tr role="row">
													<th>Tanggal</th>
													<th>Izin</th>
													<th>Alasan Cuti</th>
													<th>Dari</th>
													<th>Sampai</th>
													<th>Persetujuan</th>
													<th>Disutujui Oleh</th>
												</tr>
											</thead>
											<tbody>
												<tr>
													<td colspan="7"></td>
												</tr>
											</tbody>
										</table>
									</div>
									<div class="tab-pane fade" id="kt_tab_pane_3_2" role="tabpanel">
										<table class="table table-striped- table-bordered table-hover table-checkable dataTable no-footer dtr-inline cuti-table" id="clearance-rejected-table" >
											<thead>
												<tr role="row">
													<th>Tanggal</th>
													<th>Izin</th>
													<th>Alasan Cuti</th>
													<th>Alasan Ditolak</th>
													<th>Dari</th>
													<th>Sampai</th>
													<th>Persetujuan</th>
													<th>Ditolak Oleh</th>
												</tr>
											</thead>
											<tbody>
												<tr>
													<td colspan="8"></td>
												</tr>
											</tbody>
										</table>
									</div>
								</div>
							</div>
						</div>
						<!--end: Datatable -->
					</div>
				
				</div>
			</div>
		</div>			
	</div>
	<!-- end:: Content -->
</div>
@endsection
@push('script')
<script>
function myFunction1() {
  var x = document.getElementById("typeleave").value;
  if(x == 'Sakit'){
		$('#surat-sakit').empty();
		$('#surat-sakit').append('<div class="form-group"><label>Upload Surat Sakit</label><input type="file" name="image"  class="form-control form-control-lg" /><span class="form-text text-muted">Please input Surat Sakit</span></div>');
  }
  else{
	$('#surat-sakit').empty();
  }
}
$('#month-izin').val();
var datatable1 = $("#clearance-request-table").DataTable({
	drawCallback:function(){$(".dataTables_paginate > .pagination").addClass("pagination-rounded")},
	responsive:true,
	"bFilter": true,
	bStateSave: true,
	"bJQueryUI": true,
	paging:true,
	select:true,
	serverSide:true,
	ajax:{
		url:'{{ route('karyawan.izin.ajax') }}',
		type:'post',
		data:{"_token": "{{ csrf_token() }}"},
	},
	columns:[
		{ data:'created_at'},
		{ data:'type_leave'},
		{ data:'remark'},
		{ data:'start_at'},
		{ data:'end_at'},
		{ data:'approval_check'},
	],
});

var datatable2 = $("#clearance-accepted-table").DataTable({
	drawCallback:function(){$(".dataTables_paginate > .pagination").addClass("pagination-rounded")},
	responsive:true,
	"bFilter": true,
	bStateSave: true,
	"bJQueryUI": true,
	paging:true,
	select:true,
	serverSide:true,
	ajax:{
		url:'{{ route('karyawan.izin.accepted') }}',
		type:'post',
		data:{"_token": "{{ csrf_token() }}"},
	},
	columns:[
		{ data:'created_at'},
		{ data:'type_leave'},
		{ data:'remark'},
		{ data:'start_at'},
		{ data:'end_at'},
		{ data:'approval_check'},
		{ data:'created_by'},
	],
});

var datatable3 = $("#clearance-rejected-table").DataTable({
	drawCallback:function(){$(".dataTables_paginate > .pagination").addClass("pagination-rounded")},
	responsive:true,
	"bFilter": true,
	bStateSave: true,
	"bJQueryUI": true,
	paging:true,
	select:true,
	serverSide:true,
	ajax:{
		url:'{{ route('karyawan.izin.rejected') }}',
		type:'post',
		data:{"_token": "{{ csrf_token() }}"},
	},
	columns:[
		{ data:'created_at'},
		{ data:'type_leave'},
		{ data:'remark'},
		{ data:'notes'},
		{ data:'start_at'},
		{ data:'end_at'},
		{ data:'approval_check'},
		{ data:'created_by'},
	],
});
$('#month-izin').val(function(){
	datatable1.search($(this).val()).draw();
	datatable2.search($(this).val()).draw();
	datatable3.search($(this).val()).draw();
});

$('#month-izin').change(function(){
	datatable1.search($(this).val()).draw();
	datatable2.search($(this).val()).draw();
	datatable3.search($(this).val()).draw();
});

function show(id){
    var id = $(id).data("id");
    $.get('/karyawan/izin/show/'+id, function(data){
        $('.remark').html(data.remark);
		$('#modaltitles').html('Alasan Izin');
        $('#kt_modal_1_edit').modal('show');
    });
}
function showmodaldeclined(id){
	var id = $(id).data("id");
    $.get('/karyawan/izin/show/'+id, function(data){
        $('.remark').html(data.notes);
		$('#modaltitles').html('Alasan Ditolak');
        $('#kt_modal_1_edit').modal('show');
    });
}

$('.nav-link').click(function(){
	datatable3.ajax.reload();
	datatable2.ajax.reload();
	datatable1.ajax.reload();
});
</script>
@endpush