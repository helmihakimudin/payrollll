@extends('layout-admin.base',[
	'pages'=>'staff',
	'subpages'=>'payslip-type'
])
@push('css')
    <style>

    .dt-right{
        width: 2% !important;
    }

    </style>
@endpush
@section('content')
@include('admin.payroll.settings.modal')

<div class="kt-portlet kt-portlet--mobile m-0">
    <div class="kt-portlet__head bg-transparent box-shadow-none kt-portlet__head--lg border-0">
        <div class="kt-portlet__head-label">
            <h3 class="kt-portlet__head-title">
                Welcome to payroll E- Smart<small class="kt-subheader__desc">| PT DUA SISI SEJAHTERA</small><small class="kt-subheader__desc">| Component</small>
            </h3>
        </div>
        <div class="kt-portlet__head-toolbar">
            <div class="kt-portlet__head-wrapper">
                <div class="kt-portlet__head-actions">
                    <a href="javascript:;" data-toggle="modal" data-target="#kt_modal_1" class="btn btn-brand btn-elevate btn-icon-sm">
                        Add/delete component
                    </a>
                </div>
            </div>
        </div>
    </div>
    <div class="kt-portlet__body">
        <table class="table table-sm table-striped- table-bordered table-hover table-checkable gaji-table" id="gaji-table" >
            <thead>
                <tr role="row">
                    <th></th>
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
                    <td colspan="7"></td>
                </tr>
            </tbody>
        </table>
    </div>
</div>


{{-- Modal Assigned employee --}}
<div class="modal fade" id="kt_modal_1" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Select payroll component</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                </button>
            </div>
            <form action="">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="exampleInputEmail1">Payroll Component <span class="text-danger">*</span></label>
                        <div class="float-right d-flex position-relative">
                            <a href="javascript:void(0)" onclick="selectAllEmployee()">Select ALL</a>
                        </div>
                        <select class="form-control kt-select2" id="select-employee" data-tags="true" multiple="multiple" style="width:100%"></select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-success">Save changes</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
@push('scriptjs')
<script>
 var datatable1 = $("#gaji-table").DataTable({
    drawCallback:function(){$(".dataTables_paginate > .pagination").addClass("pagination-rounded")},
    responsive:true,
    "bFilter": true,
    bStateSave: true,
    "bJQueryUI": true,
    paging:true,
    autoWidth: true,
    select:true,
    lengthMenu: [10, 25, 50],
    pageLength: 10,
    language: {
        lengthMenu: "Display _MENU_",
    },
    orderable: true,
    serverSide:true,
    headerCallback: function (thead, data, start, end, display) {
        thead.getElementsByTagName("th")[0].innerHTML = `
            <label class="kt-checkbox kt-checkbox--single kt-checkbox--solid">
                <input type="checkbox" value="" class="kt-group-checkable">
                <span></span>
            </label>`;
    },
    columnDefs: [
        {
            targets: 0,
            autoWidth: true,
            width: '30px',
            className: 'dt-right',
            orderable: false,
            render: function(data, type, full, meta) {
                return `
                <label class="kt-checkbox kt-checkbox--single kt-checkbox--solid">
                    <input type="checkbox" value="" class="kt-checkable">
                    <span></span>
                </label>`;
            },
        },
    ],
    ajax:{
        url:'{{ route('payroll.component.ajax') }}',
        type:'post',
        data:{"_token": "{{ csrf_token() }}"},
    },
    columns:[
        { data:'0',orderable:false},
        { data:'name'},
        { data:'email'},
        { data:'salary_type'},
        { data:'salary'},
        { data:'net_salary'},
        { data:'actions'},
    ],
});
datatable1.on("change", ".kt-group-checkable", function () {
    var set = $(this)
        .closest("table")
        .find("td:first-child .kt-checkable");
    var checked = $(this).is(":checked");

    $(set).each(function () {
        if (checked) {
            $(this).prop("checked", true);
            $(this).closest("tr").addClass("active");
        } else {
            $(this).prop("checked", false);
            $(this).closest("tr").removeClass("active");
        }
    });
});
datatable1.on("change", "tbody tr .kt-checkbox", function () {
    $(this).parents("tr").toggleClass("active");
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
var selectAll = true;
function checkAllSubItem(classDom, obj){
    console.log(obj.checked)
    if(obj.checked){
        $('.'+classDom).each(function(i, obj) {
            obj.checked = true;
        });
    }else{
        $('.'+classDom).each(function(i, obj) {
            obj.checked = false;
        });
    }
}

function setTemplate(title, description){
            return `<div class="mb-1">${title}</div><small>${description}</small>`;
        }

function selectAllEmployee() {
    if(selectAll){
        $("#select-employee > option").prop("selected", true);
        $("#select-employee").trigger("change"); 
        selectAll = false;
    }else{
        $("#select-employee > option").prop("selected", false);
        $("#select-employee").trigger("change"); 
        selectAll = true;
    }
}

// Initialization
jQuery(document).ready(function() {

    //Enable tooltips
    $('[data-toggle="tooltip"]').tooltip();

    var data = [
        { id: 1, title: 'Basic Salary', description: 'Salary - Monthly'},
        { id: 1, title: 'Lembur (NonTax)', description: 'Allowance - Monthly'},
        { id: 1, title: 'Lembur (Tax)', description: 'Allowance - Monthly'},
        { id: 1, title: 'Rapel (NonTax)', description: 'Allowance - Monthly'},
        { id: 1, title: 'Rapel (Tax)', description: 'Allowance - Monthly'},
        { id: 1, title: 'Komisi (Tax)', description: 'Allowance - Monthly'},
        { id: 1, title: 'Komisi (NonTax)', description: 'Allowance - Monthly'},
    ];

    $('#select-employee').select2({
        allowClear: true,
        placeholder: "Select an Employee",
        data:data,
        templateResult: function (d) { return $(setTemplate(d.title, d.description)); },
        templateSelection: function (d) { return d.title },
    }).on('change', function() {
        
    }).trigger('change'); 

    $("#clear").on("click", function () {
        $example.select2("destroy");
    });

    $('#select-shift,#select-shift2').select2({
        placeholder: "Select Shift"
    });

    $("#filter-employee").on("click", function (e) {
        e.stopPropagation();
    });

    $("#filter-employee-shift").on("click", function (e) {
        e.stopPropagation();
    });
    
});
</script>
@endpush
