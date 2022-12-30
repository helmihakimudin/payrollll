@extends('layout-admin.base',[
	'pages'=>'staff',
	'subpages'=>'permission'
])
@section('content')
<div class="kt-content  kt-grid__item kt-grid__item--fluid kt-grid kt-grid--hor" id="kt_content">
	<!-- begin:: Content Head -->
	<div class="kt-subheader  kt-grid__item" id="kt_subheader">
		<div class="kt-container  kt-container--fluid ">
			<div class="kt-subheader__main">
				<h3 class="kt-subheader__title">Permission</h3>
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
        <div class="kt-portlet kt-portlet--mobile">
            <div class="kt-portlet__head kt-portlet__head--lg">
                <div class="kt-portlet__head-label">
                    <span class="kt-portlet__head-icon">
                        <i class="kt-font-brand flaticon flaticon-user"></i>
                    </span>
                    <h3 class="kt-portlet__head-title">
                        Daftar Permission 
                    </h3>
                </div>
                <div class="kt-portlet__head-toolbar">
                    <div class="kt-portlet__head-toolbar">
                        <div class="kt-portlet__head-wrapper">
                            <div class="kt-portlet__head-actions">
                                <a href="{{route('permission.buat')}}" class="btn btn-brand btn-elevate btn-icon-sm">
                                    <i class="la la-plus"></i>
                                    Buat 
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @include('message')
            <div class="kt-portlet__body">
                <!--begin: Datatable -->
                <div class="row">
                    <div class="col-lg-12">
                        <table class="table table-striped- table-bordered table-hover table-checkable dataTable no-footer dtr-inline karyawan-table" id="permission-table" >
                            <thead>
                                <tr role="row">
                                    <th>Nama</th>
                                    <th>Guard Name</th>
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
                <!--end: Datatable -->
            </div>
        </div>					
	</div>
	<!-- end:: Content -->
</div>
@endsection
@push('script')
<script>
var datatable1 = $("#permission-table").DataTable({
    drawCallback:function(){$(".dataTables_paginate > .pagination").addClass("pagination-rounded")},
    responsive:true,
    "bFilter": true,
    bStateSave: true,
    "bJQueryUI": true,
    paging:true,
    select:true,
    serverSide:true,
    ajax:{
        url:'{{ route('permission.ajax') }}',
        type:'post',
        data:{"_token": "{{ csrf_token() }}"},
    },
    columns:[
        { data:'name'},
        { data:'guard_name'},
        { data:'actions'},
    ],
});
</script>
@endpush