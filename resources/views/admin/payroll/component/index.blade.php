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
                        <h3 class="kt-subheader__desc m-0">
                          PT DUASISI SEJAHTERA
                        </h3>
                    </div>
                    <span class="kt-subheader__separator kt-subheader__separator--v"></span>
                    <div class="kt-subheader__group" id="kt_subheader_search">
                        <h3 class="kt-subheader__desc m-0">
                          Component
                        </h3>
                    </div>
                </div>
                <div class="kt-subheader__toolbar">
                    <div class="kt-subheader__wrapper">
                        <a href="{{route('payroll.component.update.form')}}" class="btn btn-brand btn-elevate btn-icon-sm">
                            <i class="la la-plus"></i>
                            Update Component
                        </a>
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



// $(document).on('click','.btn-edit-benefit',function(e){
//     e.preventDefault();
//     var edit = $(this).attr('data-attr');
//     $.ajax({
//         url: edit,
//         success: function(result) {
//             $('#modalform .modal-title').html('Edit Akses izin');
//             $('#modalform').modal("show");
//             $('#modalcontent').html(result).show();
//         },
//         timeout: 8000
//     });
// });

</script>
@endpush
