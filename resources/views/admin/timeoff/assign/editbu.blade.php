@extends('layout-admin.base', [
    'pages' => 'Setting Attemdance',
    'subpages' => 'Setting Attemdance',
])

@push('css')
<style>
    .btn:focus, .btn.focus {
        outline: 0;
        -webkit-box-shadow: none !important;
        box-shadow: none !important;
    }

    .el-none, .el-none1, .el-none2{
        display: none;
    }
</style>            
@endpush
@section('content')
    <div class="kt-portlet">
        <div class="kt-portlet__head">
            <div class="kt-portlet__head-label">
                <h3 class="kt-portlet__head-title">Edit Transaction Time Off Detail</h3>
            </div>
            <div class="kt-portlet__head-toolbar">
                <a href="#" class="btn mr-4 btn-sm btn-outline-brand btn-elevate btn-icon-sm">
                    <i class="la la-download"></i>
                    Export
                </a>
                <a href="{{ route('timeoff.assign')}}" class="btn btn-sm btn-outline-secondary btn-elevate btn-icon-sm">
                    <i class="la la-arrow-left"></i>
                    Back
                </a>
            </div>
        </div>
        <div class="kt-portlet__body">
            <form class="kt-form">
                <div class="row">
                    <div class="col-lg-3">
                        <div class="form-group">
                            <label for="timeoff">Time Off </label>
                            <select class="form-control" id="timeoff" name="timeoff">
                                <option value="0" selected>Cuti Tahunan</option>
                                <option value="1">Izin</option>
                                <option value="2">Sakit Dengan Surat Doktor</option>
                                <option value="3">Dinas Luar Kota</option>
                                <option value="4">Gathering Divisi</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <div class="form-group">
                            <label for="type">Type </label>
                            <select class="form-control" id="type" name="type" onchange="showDiv(this)">
                                <option value="assign">Assign</option>
                                <option value="update" selected>Update</option>
                                <option value="expired">Expired</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <div class="form-group">
                            <label>Description</label>
                            <input type="text" class="form-control" value="Update Employee">
                        </div>
                    </div>
                    <div class="col-lg-3 el-none2">
                        <div class="form-group">
                            <label>Effective Expired Date</label>
                            <div class="input-group date">
                                <input type="text" class="form-control" readonly="" value="05/20/2017" id="kt_datepicker_3">
                                <div class="input-group-append">
                                    <span class="input-group-text">
                                        <i class="la la-calendar"></i>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <div class="form-group">
                            <label>Select Employee <span class="text-danger">*</span></label>
                            <div class="float-right d-flex position-relative">
                                <a href="javascript:void(0)" onclick="selectAllEmployee()">Select ALL</a>
                            </div>
                            <select class="form-control kt-select2" id="select-employee" data-tags="true" multiple="multiple" style="width:100%"></select>
                        </div>
                    </div>
                    <div class="col-lg-3 el-none1">
                        <div class="form-group">
                            <label>Input balance</label>
                            <input type="text" class="form-control" maxlength="2" value="12">
                        </div>
                    </div>
                    <div class="col-lg-3 el-none1">
                        <div class="form-group">
                            <label>Start Date</label>
                            <div class="input-group date">
                                <input type="text" class="form-control" readonly="" value="05/20/2017" id="kt_datepicker_3">
                                <div class="input-group-append">
                                    <span class="input-group-text">
                                        <i class="la la-calendar"></i>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 el-none1">
                        <div class="form-group">
                            <label>End Date</label>
                            <div class="input-group date">
                                <input type="text" class="form-control" readonly="" value="05/10/2030" id="kt_datepicker_3">
                                <div class="input-group-append">
                                    <span class="input-group-text">
                                        <i class="la la-calendar"></i>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-lg-12 text-right">
                        <hr>
                        <div class="kt-form__actions">
                            <button type="submit" class="btn btn-success">Save</button>
                            <button type="reset" class="btn btn-secondary">Cancel</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
@push('scriptjs')
<script src="{{ asset('demo10/assets/js/pages/crud/forms/widgets/bootstrap-datepicker.js')}}" type="text/javascript"></script>
<script>

    if ($('#type option:selected').val() === 'update') {
        $(".el-none1").css("display", "block");
    } else if ($('#type option:selected').val() === 'expired'){
        $(".el-none2").css("display", "block");
    }

    function showDiv(element){
        $(".el-none1").css("display", element.value == 'update' ? "block" : "none")
        $(".el-none2").css("display", element.value == 'expired' ? "block" : "none")
    }
        
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
            { id: 1, title: 'Anang', description: 'DSS001-Fullstack Dev-Green lake city'},
            { id: 1, title: 'Anang', description: 'DSS001-Fullstack Dev-Green lake city'},
            { id: 1, title: 'Anang', description: 'DSS001-Fullstack Dev-Green lake city'},
            { id: 1, title: 'Anang', description: 'DSS001-Fullstack Dev-Green lake city'},
            { id: 1, title: 'Anang', description: 'DSS001-Fullstack Dev-Green lake city'},
            { id: 1, title: 'Anang', description: 'DSS001-Fullstack Dev-Green lake city'},
            { id: 1, title: 'Anang', description: 'DSS001-Fullstack Dev-Green lake city'},
            { id: 1, title: 'Anang', description: 'DSS001-Fullstack Dev-Green lake city'},
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
    });
</script>
@endpush
