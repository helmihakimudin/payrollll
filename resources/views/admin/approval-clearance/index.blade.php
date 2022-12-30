@extends('layout-admin.base',[
	'pages'=>'approval',
	'subpages'=>'clearance'
])
@section('content')
<!--begin::Modal-->
<div class="modal fade" id="kt_modal_1" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="modaltitles"></h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				</button>
			</div>
			<div class="modal-body">
				<p id="remark"></p>
				<img src="" alt="" class="img-fluid">
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
			</div>
		</div>
	</div>
</div>
<div class="modal fade" id="kt_modal_1_declined" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="tolakkasbon">Alasan Ditolak</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				</button>
			</div>
			<div class="modal-body">
				<form action="{{route('clearance.dec')}}" method="get" id="form-dec">
					<div class="form-group">
						<label for="">Alasan Ditolak</label>
						<input type="hidden" id="id_tolak" name="id">
						<textarea name="notes" id="" cols="30" class="form-control" rows="5" required></textarea>
					</div>
				</form>
			</div>
			<div class="modal-footer">
				<button type="submit" form="form-dec" class="btn btn-danger" >Tolak</button>
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
								Daftar  Izin
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
													<th>Nama</th>
													<th>Divisi</th>
													<th>Jenis Izin</th>
													<th>Alasan Izin</th>
													<th>Dari</th>
													<th>Sampai</th>
													<th>Persetujuan</th>
												</tr>
											</thead>
											<tbody>
												<tr>
													<td colspan="7"></td>
												</tr>
											</tbody>
										</table>
									</div>
									<div class="tab-pane fade" id="kt_tab_pane_2_2" role="tabpanel">
										<table class="table table-striped- table-bordered table-hover table-checkable dataTable no-footer dtr-inline cuti-table" id="clearance-accepted-table" >
											<thead>
												<tr role="row">
													<th>Nama</th>
													<th>Divisi</th>
													<th>Jenis Izin</th>
													<th>Alasan Izin</th>
													<th>Dari</th>
													<th>Sampai</th>
													<th>Persetujuan</th>
													<th>Disutujui Oleh</th>
												</tr>
											</thead>
											<tbody>
												<tr>
													<td colspan="8"></td>
												</tr>
											</tbody>
										</table>
									</div>
									<div class="tab-pane fade" id="kt_tab_pane_3_2" role="tabpanel">
										<table class="table table-striped- table-bordered table-hover table-checkable dataTable no-footer dtr-inline cuti-table" id="clearance-rejected-table" >
											<thead>
												<tr role="row">
													<th>Nama</th>
													<th>Divisi</th>
													<th>Jenis Izin</th>
													<th>Alasan Izin</th>
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
$('#month-izin').val();
var datatable1 = $("#clearance-accepted-table").DataTable({
	drawCallback:function(){$(".dataTables_paginate > .pagination").addClass("pagination-rounded")},
	responsive:true,
	"bFilter": true,
	bStateSave: true,
	"bJQueryUI": true,
	paging:true,
	select:true,
	serverSide:true,
	ajax:{
		url:'{{ route('clearance.accepted.ajax') }}',
		type:'post',
		data:{"_token": "{{ csrf_token() }}"},
	},
	columns:[
		{ data:'name'},
		{ data:'department'},
		{ data:'type_leave'},
		{ data:'remark'},
		{ data:'start_at'},
		{ data:'end_at'},
		{ data:'approval_check'},
		{ data:'created_by'},
	],
});

var datatable2 = $("#clearance-rejected-table").DataTable({
	drawCallback:function(){$(".dataTables_paginate > .pagination").addClass("pagination-rounded")},
	responsive:true,
	"bFilter": true,
	bStateSave: true,
	"bJQueryUI": true,
	paging:true,
	select:true,
	serverSide:true,
	ajax:{
		url:'{{ route('clearance.rejected.ajax') }}',
		type:'post',
		data:{"_token": "{{ csrf_token() }}"},
	},
	columns:[
		{ data:'name'},
		{ data:'department'},
		{ data:'type_leave'},
		{ data:'remark'},
		{ data:'notes'},
		{ data:'start_at'},
		{ data:'end_at'},
		{ data:'approval_check'},
		{ data:'created_by'},
	],
});

var datatable3 = $("#clearance-request-table").DataTable({
	drawCallback:function(){$(".dataTables_paginate > .pagination").addClass("pagination-rounded")},
	responsive:true,
	"bFilter": true,
	bStateSave: true,
	"bJQueryUI": true,
	paging:true,
	select:true,
	serverSide:true,
	ajax:{
		url:'{{ route('clearance.request.ajax') }}',
		type:'post',
		data:{"_token": "{{ csrf_token() }}"},
	},
	columns:[
		{ data:'name'},
		{ data:'department'},
		{ data:'type_leave'},
		{ data:'remark'},
		{ data:'start_at'},
		{ data:'end_at'},
		{ data:'approval_check'},
	
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
    $.get('/approval/clearance/show/'+id, function(data){
        var image_path="{{URL::asset('storage/surat-sakit/')}}/";
		$('#remark').html(data.remark);
		$('#modaltitles').html('Cek Alasan');
		if(data.image!=null){
			$('#kt_modal_1 img').attr('src', image_path+data.image);
        	$('#kt_modal_1 img').attr('alt', data.image);
		}
        $('#kt_modal_1').modal('show');
    });
}
function showmodaldeclined(id){
	var id = $(id).data("id");
    $.get('/approval/clearance/show/'+id, function(data){
		$('#modaltitles').html('Alasan Ditolak');
		$('#remark').html(data.notes);
        $('#kt_modal_1').modal('show');
    });
}
function modaldeclined(id){
	var id = $(id).data("id");
	$('#id_tolak').val(id);
    $.get('/approval/clearance/show/'+id, function(data){
		$('#kt_modal_1_declined').modal('show');
    });
}
</script>
@endpush