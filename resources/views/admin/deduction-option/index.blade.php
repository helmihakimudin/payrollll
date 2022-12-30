@extends('layout-admin.base',[
	'pages'=>'staff',
	'subpages'=>'deduction-option'
])
@section('content')

@include('admin.deduction-option.view')
@include('admin.deduction-option.modal')
<div class="kt-body kt-grid__item kt-grid__item--fluid kt-grid kt-grid--hor kt-grid--stretch" id="kt_body">
    <div class="kt-content  kt-grid__item kt-grid__item--fluid kt-grid kt-grid--hor" id="kt_content">
        <div class="kt-subheader   kt-grid__item" id="kt_subheader">
            <div class="kt-container pt-3">
                <div class="kt-subheader__main">
                    <h3 class="kt-subheader__title">
                        Deduction List
                    </h3>
                    <span class="kt-subheader__separator kt-subheader__separator--v"></span>
                    <div class="kt-subheader__group" id="kt_subheader_search">
                        <span class="kt-subheader__desc" id="kt_subheader_total">
                            <a href="javascript:;" data-attr="{{route('deduction-option.create')}}" class="btn btn-primary rounded-fill btn-add">Add Deduction</a></span>
                    </div>
                </div>
            </div>
        </div>
        <div class="kt-container  kt-grid__item kt-grid__item--fluid">
            <div class="row">
                <div class="col-lg-12">
                    <table class="table kt-datatable__tabletable-checkable dataTable no-footer dtr-inline karyawan-table" style="font-size:11px;" id="deduction-option-table">
                        <thead>
                            <tr role="row">
                                <th>Deduction</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td colspan="12"></td>
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
$(document).ready(function(){
    var datatable1 = $("#deduction-option-table").DataTable({
        drawCallback:function(){$(".dataTables_paginate > .pagination").addClass("pagination-rounded")},
        responsive:true,
        "bFilter": true,
        bStateSave: true,
        "bJQueryUI": true,
        paging:true,
        select:true,
        serverSide:true,
        ajax:{
            url:'{{ route('deduction-option.ajax') }}',
            type:'post',
            data:{"_token": "{{ csrf_token() }}"},
        },
        columns:[
            { data:'name'},
            { data:'actions'},
        ],
    });
});

$(document).on('click','.btn-add',function(e){
    e.preventDefault();
    var create = $(this).attr('data-attr');
    $.ajax({
        url: create,
        success: function(result) {
            $('.view-data').removeClass('d-none');
            $('.view-data').html(result)
            $('input').on('keypress', function (event) {
                var regex = new RegExp("^[a-zA-Z0-9 ]+$");
                var key = String.fromCharCode(!event.charCode ? event.which : event.charCode);
                if (!regex.test(key)) {
                event.preventDefault();
                return false;
                }
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
            $('input').on('keypress', function (event) {
                var regex = new RegExp("^[a-zA-Z0-9 ]+$");
                var key = String.fromCharCode(!event.charCode ? event.which : event.charCode);
                if (!regex.test(key)) {
                event.preventDefault();
                return false;
                }
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