@extends('layout-admin.base',[
	'pages'=>'staff',
	'subpages'=>'payslip-type'
])
@section('content')
@include('admin.peran.view')
@include('admin.peran.modal')
<div class="kt-body kt-grid__item kt-grid__item--fluid kt-grid kt-grid--hor kt-grid--stretch" id="kt_body">
    <div class="kt-content  kt-grid__item kt-grid__item--fluid kt-grid kt-grid--hor" id="kt_content">
        <div class="kt-subheader   kt-grid__item" id="kt_subheader">
            <div class="kt-container pt-3">
                <div class="kt-subheader__main">
                    <h3 class="kt-subheader__title">
                        Rules List
                    </h3>
                    <span class="kt-subheader__separator kt-subheader__separator--v"></span>
                    <div class="kt-subheader__group" id="kt_subheader_search">
                        <span class="kt-subheader__desc" id="kt_subheader_total">
                            <a href="javascript:;" data-attr="{{route('peran.create')}}" class="btn btn-primary rounded-fill btn-add">Add Rules</a></span>
                    </div>
                </div>
            </div>
        </div>
        <div class="kt-container  kt-grid__item kt-grid__item--fluid">
            <div class="row">
                <div class="col-lg-12">
                    <table class="table kt-datatable__tabletable-checkable dataTable no-footer dtr-inline karyawan-table" style="font-size:11px;"id="peran-table">
                        <thead>
                            <tr role="row">
                                <th width="20%">Name</th>
                                <th width="70%">Access Permission</th>
                                <th width="10%">Action</th>
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
</div>
@endsection
@push('scriptjs')
<script>
var datatable1 = $("#peran-table").DataTable({
    drawCallback:function(){$(".dataTables_paginate > .pagination").addClass("pagination-rounded")},
    responsive:true,
    "bFilter": true,
    bStateSave: true,
    "bJQueryUI": true,
    paging:true,
    select:true,
    serverSide:true,
    ajax:{
        url:'{{ route('peran.ajax') }}',
        type:'post',
        data:{"_token": "{{ csrf_token() }}"},
    },
    columns:[
        { data:'name'},
        { data:'permission'},
        { data:'actions'},
    ],
});

$(document).on('click','.btn-add',function(e){
    e.preventDefault();
    var create = $(this).attr('data-attr');
    $.ajax({
        url: create,
        success: function(result) {
            $('.view-data').removeClass('d-none');
            $('.view-data').html(result)
            $('.select-custom').select2({
				placeholder: "Select a choose"
			});
            $(document).on('click','.btn-close',function(e){
                e.preventDefault();
                $('.view-data').addClass('d-none');
            });	
        },
        timeout: 8000
    });
});

$(document).on('click','.btn-edit',function(e){
    e.preventDefault();
    var create = $(this).attr('data-attr');
    $.ajax({
        url: create,
        success: function(result) {
            $('.view-data').removeClass('d-none');
            $('.view-data').html(result)
            $('.select-custom').select2({
				placeholder: "Select a choose"
			});
            $(document).on('click','.btn-close',function(e){
                e.preventDefault();
                $('.view-data').addClass('d-none');
            });	
        },
        timeout: 8000
    });
});


$(document).on('click','.btn-show',function(e){
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