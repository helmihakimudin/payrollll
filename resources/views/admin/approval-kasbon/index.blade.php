@extends('layout-admin.base',[
	'pages'=>'approval',
	'subpages'=>'kas-bon'
])
@section('content')
<!--begin::Modal-->
<div class="modal fade" id="kt_modal1acc" tabindex="-1" role="dialog" data-backdrop="static" data-keyboard="false" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalLabel">Approval Kasbon</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				</button>
			</div>
			<div class="modal-body">
				<form action="{{route('admin.kasbon.update')}}" method="POST" class="form" id="form-kasbon-acc" enctype="multipart/form-data">
					{{ csrf_field() }}
					<input type="hidden" name="id" id="id" class="form-control "  required>
					<input type="hidden" name="uid" id="uid" class="form-control "  required>
					<input type="hidden" name="amount" id="amount" class="form-control "  required>
					
					<div class="form-group">
						<label>Kasbon Diajukan</label>
						<input type="text" name="kasbon" id="kasbon" class="form-control "  disabled>
					</div>
					<div class="form-group">
						<label>Type penerimaan kasbon</label>
						<select name="typeacc" id="typeacc" onchange="myFunction1()" class="form-control form-control-lg">
                            <option value="Full">Terima Seluruhnya</option>
							<option value="Sebagian">Terima Sebagian</option>  
                        </select>
					</div>
					<div id="kasbon-sebagian">
						
					</div>
					<div class="form-group">
						<label>Notes</label>
						<textarea name="notes" id="notes" cols="30" rows="5"  autocomplete="off" class="form-control" required></textarea>
					</div>
				</form>
			</div>
			<div class="modal-footer">
				<button type="submit" form="form-kasbon-acc" class="btn btn-primary">Kirim</button>
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
			</div>
		</div>
	</div>
</div>
<div class="modal fade" id="kt_modal_1" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="titlekasbon"></h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				</button>
			</div>
			<div class="modal-body">
				<p id="remark"></p>
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
				<form action="{{route('kas-bon.dec')}}" method="get" id="form-dec">
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
				<h3 class="kt-subheader__title">Kasbon</h3>
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
								Daftar  Kasbon
							</h3>
						</div>
						<div class="kt-portlet__head-toolbar">
							<div class="kt-portlet__head-toolbar">
								<div class="kt-portlet__head-wrapper">
									
									<div class="kt-portlet__head-actions">
										<div class="dropdown dropdown-inline">
											<div class="input-group">
												<div class="input-group-prepend"><span class="input-group-text"><i class="flaticon-calendar"></i></span></div>
												<input type="text" name="month" value="{{date('Y-m')}}"  id="month-kasbon" class="form-control month" placeholder="Bulan">
											</div>
										</div>
									</div>
									&nbsp;
									<ul class="nav nav-tabs nav-bold nav-tabs-line">
										<li class="nav-item">
											<a class="nav-link active" data-toggle="tab" href="#kt_tab_pane_1_2">Pengajuan</a>
										</li>
										<li class="nav-item">
											<a class="nav-link"  data-toggle="tab" href="#kt_tab_pane_2_2">Disetujui</a>
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
										<table class="table table-striped- table-bordered table-hover table-checkable dataTable no-footer dtr-inline cuti-table" id="kasbon-request-table" >
											<thead>
												<tr role="row">
													<th>Nama</th>
													<th>Divisi</th>
													<th>Jumlah Pinjaman</th>
													<th>Keperluan</th>
													<th>Tanggal Peminjaman</th>
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
										<table class="table table-striped- table-bordered table-hover table-checkable dataTable no-footer dtr-inline cuti-table" id="kasbon-accepted-table" >
											<thead>
												<tr role="row">
													<th>Nama</th>
													<th>Divisi</th>
													<th>Jumlah Pinjaman</th>
													<th>Jumlah Disetujui</th>
													<th>Keperluan</th>
													<th>Tanggal Peminjaman</th>
													<th>Persetujuan</th>
													<th>Disetujui Oleh</th>
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
										<table class="table table-striped- table-bordered table-hover table-checkable dataTable no-footer dtr-inline cuti-table" id="kasbon-rejected-table" >
											<thead>
												<tr>
													<th>Nama</th>
													<th>Divisi</th>
													<th>Jumlah Pinjaman</th>
													<th>Keperluan</th>
													<th>Alasan Ditolak</th>
													<th>Tanggal Peminjaman</th>
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
	var x = document.getElementById("typeacc").value;
	if(x == 'Sebagian'){
		$('#kasbon-sebagian').empty();
		$('#kasbon-sebagian').append('<div class="form-group"><label>Jumlah Kasbon diubah menjadi</label><input type="number" name="amount_of_leave" id="amount_of_leave" class="form-control"  required></div></div>');
	}
	else{
		$('#kasbon-sebagian').empty();
	}
}
</script>

<script>
$('#month-kasbon').val();
var datatable1 = $("#kasbon-accepted-table").DataTable({
	drawCallback:function(){$(".dataTables_paginate > .pagination").addClass("pagination-rounded")},
	responsive:true,
	"bFilter": true,
	bStateSave: true,
	"bJQueryUI": true,
	paging:true,
	select:true,
	serverSide:true,
	ajax:{
		url:'{{ route('kas-bon.accepted.ajax') }}',
		type:'post',
		data:{"_token": "{{ csrf_token() }}"},
	},
	columns:[
		{ data:'name'},
		{ data:'department'},
		{ data:'amount'},
		{ data:'amount_accepted'},
		{ data:'remark'},
		{ data:'date_kasbon'},
		{ data:'approval_check'},
		{ data:'created_by'},
	],
});

var datatable2 = $("#kasbon-rejected-table").DataTable({
	drawCallback:function(){$(".dataTables_paginate > .pagination").addClass("pagination-rounded")},
	responsive:true,
	"bFilter": true,
	bStateSave: true,
	"bJQueryUI": true,
	paging:true,
	select:true,
	serverSide:true,
	ajax:{
		url:'{{ route('kas-bon.rejected.ajax') }}',
		type:'post',
		data:{"_token": "{{ csrf_token() }}"},
	},
	columns:[
		{ data:'name'},
		{ data:'department'},
		{ data:'amount'},
		{ data:'remark'},
		{ data:'notes'},
		{ data:'date_kasbon'},
		{ data:'approval_check'},
		{ data:'created_by'},
	],
});
$('.nav-link').click(function(){
	datatable3.ajax.reload();
	datatable2.ajax.reload();
	datatable1.ajax.reload();
})

var datatable3 = $("#kasbon-request-table").DataTable({
	drawCallback:function(){$(".dataTables_paginate > .pagination").addClass("pagination-rounded")},
	responsive:true,
	"bFilter": true,
	bStateSave: true,
	"bJQueryUI": true,
	paging:true,
	select:true,
	serverSide:true,
	ajax:{
		url:'{{ route('kas-bon.request.ajax') }}',
		type:'post',
		data:{"_token": "{{ csrf_token() }}"},
	},
	columns:[
		{ data:'name'},
		{ data:'department'},
		{ data:'amount'},
		{ data:'remark'},
		{ data:'date_kasbon'},
		{ data:'approval_check'},
	],
});
$('#month-kasbon').val(function(){
	datatable1.search($(this).val()).draw();
	datatable2.search($(this).val()).draw();
	datatable3.search($(this).val()).draw();
});

$('#month-kasbon').change(function(){
	datatable1.search($(this).val()).draw();
	datatable2.search($(this).val()).draw();
	datatable3.search($(this).val()).draw();
});
function show(id){
	var id = $(id).data("id");
	$.get('/approval/kasbon/show/'+id, function(data){
		$('#remark').html(data.remark);
		$('#titlekasbon').html('Keperluan Kasbon');
		$('#kt_modal_1').modal('show');
	});
}
function showDeclined(id){
	var id = $(id).data("id");
	$.get('/approval/kasbon/show/'+id, function(data){
		$('#remark').html(data.notes);
		$('#titlekasbon').html('Alasan Ditolak');
		$('#kt_modal_1').modal('show');
	});
}

function modaldeclined(id){
	var id = $(id).data("id");
	$('#id_tolak').val(id);
	$('#kt_modal_1_declined').modal('show');
}
function openacc(id){
    var id = $(id).data("id");
    $.get('/approval/kasbon/show/'+id, function(data){
		$('#kt_modal1acc input[name=id]').val(data.id);
		$('#kt_modal1acc input[name=uid]').val(data.employee_id);
		$('#kt_modal1acc input[name=amount]').val(data.amount);
		$('#kt_modal1acc input[name=kasbon]').val(data.amount);
        $('#kt_modal1acc').modal('show');
    });}

</script>
@endpush