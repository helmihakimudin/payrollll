@extends('layout-admin.base',[
	'pages'=>'payroll',
	'subpages'=>'gaji'
])
@section('content')
<!--begin::Modal-->
<div class="modal fade" id="importmodal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Import karyawan baru</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                </button>
            </div>
            <form method="POST" action="{{ route('karyawan.import') }}" id="form-import" enctype="multipart/form-data">
                {{ csrf_field() }}
                <div class="modal-body">
                <input type="file" name="import" class="form-control">
                </div>
            </form>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" form="form-import" class="btn btn-primary">Import</button>
            </div>
        </div>
    </div>
</div>


<div class="modal fade" id="importgaji" tabindex="-1" role="dialog" data-backdrop="static" aria-labelledby="exampleModalSizeLg" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Import Data</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <i aria-hidden="true" class="ki ki-close"></i>
                </button>
            </div>
            <form action="{{route('gaji.import')}}" method="POST" enctype="multipart/form-data">
                {{ csrf_field() }}
                <div class="modal-body">
                    <div class="group">
                        <div class="form-group text-center">
                            <label>Import Data</label><br>
                            <input type="file" name="import" id="upload" class="form-control" style="display:none">
                            <svg style="cursor: pointer;" onclick="functionUpload()"  xmlns="http://www.w3.org/2000/svg" width="60" height="60" fill="green" class="bi bi-cloud-upload-fill" viewBox="0 0 16 16">
                                <path fill-rule="evenodd" d="M8 0a5.53 5.53 0 0 0-3.594 1.342c-.766.66-1.321 1.52-1.464 2.383C1.266 4.095 0 5.555 0 7.318 0 9.366 1.708 11 3.781 11H7.5V5.707L5.354 7.854a.5.5 0 1 1-.708-.708l3-3a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1-.708.708L8.5 5.707V11h4.188C14.502 11 16 9.57 16 7.773c0-1.636-1.242-2.969-2.834-3.194C12.923 1.999 10.69 0 8 0zm-.5 14.5V11h1v3.5a.5.5 0 0 1-1 0z"/>
                              </svg>
                            <span id="namafile" style="font-size:16px;" class="form-text text-muted">Please Import File (Xls)</span>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light-primary font-weight-bold" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary font-weight-bold">Import</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!--end::Modal-->

<div class="kt-content  kt-grid__item kt-grid__item--fluid kt-grid kt-grid--hor" id="kt_content">
	<!-- begin:: Content Head -->
	<div class="kt-subheader  kt-grid__item" id="kt_subheader">
		<div class="kt-container  kt-container--fluid ">
			<div class="kt-subheader__main">
				<h3 class="kt-subheader__title">Gaji Karyawan</h3>
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
                        Daftar Gaji Karyawan
                    </h3>
                </div>
                <div class="kt-portlet__head-toolbar">
                    <div class="kt-portlet__head-toolbar">
                        <div class="kt-portlet__head-wrapper">
                            <div class="kt-portlet__head-actions">
                                @can('Import Gaji')
                                <button  data-toggle="modal" data-target="#importgaji" class="btn btn-brand btn-elevate btn-icon-sm">
                                    <i class="fa fa-file-import"></i>
                                    Import
                                </button>
                                @endcan
                                @can('Export Gaji')
                                <a href="{{ route('gaji.exportgaji') }}" class="btn btn-success btn-elevate btn-icon-sm">
                                    <i class="fa fa-file-export"></i>
                                    Download Template
                                </a>
                                @endcan
                                @can('Add Gaji')
                                <a href="{{route('gaji.buat')}}" class="btn btn-brand btn-elevate btn-icon-sm">
                                    <i class="la la-plus"></i>
                                    Buat
                                </a>
                                @endcan
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
                        <table class="table table-striped- table-bordered table-hover table-checkable dataTable no-footer dtr-inline gaji-table" id="gaji-table" >
                            <thead>
                                <tr role="row">
                                    <th>Nama</th>
                                    <th>Email</th>
                                    <th>Jenis Gaji</th>
                                    <th>Gaji Pokok</th>
                                    <th>Gaji Prorate</th>
                                    <th>Aksi</th>
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
        </div>
	</div>
	<!-- end:: Content -->
</div>
@endsection
@push('script')
<script>
$(document).ready(function(){
    var datatable1 = $("#gaji-table").DataTable({
        drawCallback:function(){$(".dataTables_paginate > .pagination").addClass("pagination-rounded")},
        responsive:true,
        "bFilter": true,
        bStateSave: true,
        "bJQueryUI": true,
        paging:true,
        select:true,
        serverSide:true,
        ajax:{
            url:'{{ route('gaji.ajax') }}',
            type:'post',
            data:{"_token": "{{ csrf_token() }}"},
        },
        columns:[
            { data:'name'},
            { data:'email'},
            { data:'salary_type'},
            { data:'salary'},
            { data:'net_salary'},
            { data:'actions'},
        ],
    });

    $("#branch_id").change(function(){
        var branch_id = $(this).val()
        var datatable1 = $("#karyawan-table").DataTable({
            drawCallback:function(){$(".dataTables_paginate > .pagination").addClass("pagination-rounded")},

            "bFilter": true,
            bStateSave: true,
            "bDestroy": true,
            paging:true,
            select:true,
            serverSide:true,
            "bInfo" : false,
            ajax:{
                url:'{{ route('karyawan.ajax') }}',
                type:'post',
                data:{
                    "_token": "{{ csrf_token() }}",
                    branch_id:branch_id
                },
            },
            columns:[
                { data:'name'},
                { data:'email'},
                { data:'branch'},
                { data:'department'},
                { data:'designation'},
                { data:'contract_status'},
                { data:'company_doj'},
                { data:'actions'},
            ],
        });
        datatable1.ajax.reload();
    });
});
function functionUpload(){
    $('#upload').click();
}
$('#upload').on('change', function(){
    $('#namafile').html(document.getElementById('upload').value.substring(12));

});
</script>
@endpush
