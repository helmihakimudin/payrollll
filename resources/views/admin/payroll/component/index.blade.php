@extends('layout-admin.base',[
	'pages'=>'payroll',
	'subpages'=>'component'
])
@section('content')
@include('admin.payroll.settings.modal')
<div class="kt-body kt-grid__item kt-grid__item--fluid kt-grid kt-grid--hor kt-grid--stretch" id="kt_body">
    <div class="kt-content  kt-grid__item kt-grid__item--fluid kt-grid kt-grid--hor" id="kt_content">
        <div class="kt-subheader   kt-grid__item" id="kt_subheader">
            <div class="kt-container pt-3">
                <div class="kt-subheader__main">
                    <h1 class="kt-subheader__title">
                        payroll E- Smart
                    </h1>
                    <span class="kt-subheader__separator kt-subheader__separator--v"></span>
                    <div class="kt-subheader__group" id="kt_subheader_search">
                        <h3 class="kt-subheader__desc">
                          PT DUAISI SEJAHTERA
                        </h3>
                    </div>
                    <span class="kt-subheader__separator kt-subheader__separator--v"></span>
                    <div class="kt-subheader__group" id="kt_subheader_search">
                        <h3 class="kt-subheader__desc">
                          Component
                        </h3>
                    </div>
                </div>
                <div class="kt-subheader__toolbar">
                    <div class="kt-subheader__wrapper">
                        <a href="#" class="btn kt-subheader__btn-primary btn-icon" title="Export">
                            <i class="flaticon2-file"></i>
                        </a>
                        <a href="#" class="btn kt-subheader__btn-primary btn-icon" title="Import">
                            <i class="flaticon-download-1"></i>
                        </a>
                        <div class="dropdown dropdown-inline" data-toggle="kt-tooltip" title="" data-placement="left" data-original-title="Quick actions">
                            <a href="#" class="btn btn-icon" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1" class="kt-svg-icon kt-svg-icon--success kt-svg-icon--md">
                                    <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                        <polygon points="0 0 24 0 24 24 0 24"></polygon>
                                        <path d="M5.85714286,2 L13.7364114,2 C14.0910962,2 14.4343066,2.12568431 14.7051108,2.35473959 L19.4686994,6.3839416 C19.8056532,6.66894833 20,7.08787823 20,7.52920201 L20,20.0833333 C20,21.8738751 19.9795521,22 18.1428571,22 L5.85714286,22 C4.02044787,22 4,21.8738751 4,20.0833333 L4,3.91666667 C4,2.12612489 4.02044787,2 5.85714286,2 Z" fill="#000000" fill-rule="nonzero" opacity="0.3"></path>
                                        <path d="M11,14 L9,14 C8.44771525,14 8,13.5522847 8,13 C8,12.4477153 8.44771525,12 9,12 L11,12 L11,10 C11,9.44771525 11.4477153,9 12,9 C12.5522847,9 13,9.44771525 13,10 L13,12 L15,12 C15.5522847,12 16,12.4477153 16,13 C16,13.5522847 15.5522847,14 15,14 L13,14 L13,16 C13,16.5522847 12.5522847,17 12,17 C11.4477153,17 11,16.5522847 11,16 L11,14 Z" fill="#000000"></path>
                                    </g>
                                </svg>
                                <!--<i class="flaticon2-plus"></i>-->
                            </a>
                            <div class="dropdown-menu dropdown-menu-fit dropdown-menu-md dropdown-menu-right">
                                <!--begin::Nav-->
                                <ul class="kt-nav">
                                    <li class="kt-nav__head">
                                        Choose Actions:
                                        <i class="flaticon2-correct kt-font-warning" data-toggle="kt-tooltip" data-placement="right" title="" data-original-title="Click to learn more..."></i>
                                    </li>
                                    <li class="kt-nav__separator"></li>
                                    <li class="kt-nav__item">
                                        <a href="{{route('payroll.component.update.form')}}" class="kt-nav__link btn-clearform">
                                            <i class="kt-nav__link-icon flaticon-settings-1"></i>
                                            <span class="kt-nav__link-text">Update Component</span>
                                        </a>
                                    </li>
                                </ul>
                                <!--end::Nav-->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="kt-container  kt-grid__item kt-grid__item--fluid pt-5">
            <!--begin: Datatable -->
            <div class="row">
                <div class="col-lg-12">
                    <table class="table table-striped- table-hover table-checkable dataTable no-footer dtr-inline gaji-table" id="component-table" >
                        <thead>
                            <tr role="row">
                                <th>Transaksi ID </th>
                                <th>Type Adjusment </th>
                                <th>Effective Date </th>
                                <th>End Date</th>
                                <th>Created By </th>
                                <th>Description </th>
                                <th>Emplooyees   </th>
                                <th>Component Name</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td colspan="9"></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <!--end: Datatable -->
        </div>
    </div>
</div>
@endsection
@push('scriptjs')
<script>
 var datatable1 = $("#component-table").DataTable({
    drawCallback:function(){$(".dataTables_paginate > .pagination").addClass("pagination-rounded")},
    responsive:true,
    "bFilter": true,
    bStateSave: true,
    "bJQueryUI": true,
    paging:true,
    select:true,
    serverSide:true,
    ajax:{
        url:'{{ route('payroll.component.ajax') }}',
        type:'post',
        data:{"_token": "{{ csrf_token() }}"},
    },
    columns:[

        { data:'transaksi_id'},
        { data:'type_adjustment'},
        { data:'effective_date'},
        { data:'end_date'},
        { data:'created_by'},
        { data:'description'},
        { data:'employees'},
        { data:'component'},
        { data:'actions'},
    ],
});



$(document).on('click','.btn-edit-benefit',function(e){
    e.preventDefault();
    var edit = $(this).attr('data-attr');
    $.ajax({
        url: edit,
        success: function(result) {
            $('#modalform .modal-title').html('Edit Akses izin');
            $('#modalform').modal("show");
            $('#modalcontent').html(result).show();
        },
        timeout: 8000
    });
});

</script>
@endpush
