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
</style>            
@endpush
@section('content')
    <div class="kt-portlet">
        <div class="kt-portlet__head">
            <div class="kt-portlet__head-label">
                <h3 class="kt-portlet__head-title">Edit Attendance Location</h3>
            </div>
            <div class="kt-portlet__head-toolbar">
                <a href="{{ route('location')}}" class="btn btn-outline-brand btn-elevate btn-icon-sm">
                    <i class="la la-arrow-left"></i>
                    Back
                </a>
            </div>
        </div>
        <div class="kt-portlet__body">
            <form class="kt-form">
                <div class="row">
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label>Clock In/out GPS Location</label>
                            <div class="kt-radio-inline">
                                <label class="kt-radio kt-radio--bold kt-radio--success">
                                    <input type="radio" name="example_2" value="0"> WFO
                                    <span></span>
                                </label>
                                <label class="kt-radio kt-radio--bold kt-radio--success">
                                    <input type="radio" name="example_2" checked value="1"> WFH
                                    <span></span>
                                </label>
                            </div>
                            <span class="form-text text-muted">Please select GPS Location</span>
                        </div>
                        <div class="form-group">
                        <label for="exampleInputEmail1">Assigned employee</label>
                            <div class="float-right d-flex position-relative">
                                <a href="javascript:void(0)" onclick="selectAllEmployee()">Select ALL</a> <span class="ml-2 mr-2">|</span>
                                <div class="dropleft">
                                    <a href="javascript:void(0)" id="dropdownFilterAgenShift" id="dropdownFilter2" data-toggle="dropdown" aria-haspopup="true"
                                    aria-expanded="false">Filter</a>
                                    <div class="dropdown-menu" id="filter-employee-shift" aria-labelledby="dropdownFilter2">
                                        <div style="min-width:262px;padding:16px" id="main-item-shift">
                                            <div class="list-group">
                                                <a href="javascript:void(0)" onclick="showSubItemShift('sub-item-branch-modal')" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">Branch <i class="flaticon2-right-arrow"></i> </a>
                                                <a href="javascript:void(0)" onclick="showSubItemShift('sub-item-department-modal')" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">Department <i class="flaticon2-right-arrow"></i> </a>
                                                <a href="javascript:void(0)" onclick="showSubItemShift('sub-item-position-modal')" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">Position <i class="flaticon2-right-arrow"></i> </a>
                                            </div>
                                        </div>

                                        <div style="min-width:262px;padding:16px;display:none" id="sub-item-branch-modal">
                                            <div class="list-group" style="margin-left:-16px;margin-right:-16px">
                                                <a href="javascript:void(0)" onclick="hideSubItemShift('sub-item-branch-modal')" class="list-group-item list-group-item-action list-group-item-light d-flex align-items-center">
                                                    <i class="flaticon2-left-arrow mr-3"></i> Branch
                                                </a>
                                            </div>

                                            <div class="input-group mt-3 mb-3">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text" id="basic-addon1"> <i class="flaticon-search"></i> </span>
                                                </div>
                                                <input type="text" class="form-control" placeholder="Search" aria-label="Search" aria-describedby="basic-addon1">
                                            </div>

                                            <div class="d-flex flex-column">
                                                <div class="form-check form-check-inline mb-2">
                                                    <input class="form-check-input" type="checkbox" onclick="checkAllSubItem('chk-branch', this)" id="chk-all-subitem-branch-modal" value="">
                                                    <label class="form-check-label" for="chk-all-subitem-branch-modal">ALL</label>
                                                </div>
                                                <div class="form-check form-check-inline mb-2">
                                                    <input class="form-check-input chk-branch" type="checkbox" id="subitem-branch-modal-1">
                                                    <label class="form-check-label" for="subitem-branch-modal-1">branch 1</label>
                                                </div>
                                                <div class="form-check form-check-inline mb-2">
                                                    <input class="form-check-input chk-branch" type="checkbox" id="subitem-branch-modal-2">
                                                    <label class="form-check-label" for="subitem-branch-modal-2">branch 2</label>
                                                </div>
                                            </div>
                                        </div>

                                        <div style="min-width:262px;padding:16px;display:none" id="sub-item-department-modal">
                                            <div class="list-group" style="margin-left:-16px;margin-right:-16px">
                                                <a href="javascript:void(0)" onclick="hideSubItemShift('sub-item-department-modal')" class="list-group-item list-group-item-action list-group-item-light d-flex align-items-center">
                                                    <i class="flaticon2-left-arrow mr-3"></i> Department
                                                </a>
                                            </div>

                                            <div class="input-group mt-3 mb-3">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text" id="basic-addon1"> <i class="flaticon-search"></i> </span>
                                                </div>
                                                <input type="text" class="form-control" placeholder="Search" aria-label="Search" aria-describedby="basic-addon1">
                                            </div>

                                            <div class="d-flex flex-column">
                                                <div class="form-check form-check-inline mb-2">
                                                    <input class="form-check-input" type="checkbox" onclick="checkAllSubItem('chk-department', this)" id="chk-all-subitem-department-modal" value="">
                                                    <label class="form-check-label" for="chk-all-subitem-department-modal">ALL</label>
                                                </div>
                                                <div class="form-check form-check-inline mb-2">
                                                    <input class="form-check-input chk-department" type="checkbox" id="subitem-department-modal-1">
                                                    <label class="form-check-label" for="subitem-department-modal-1">department 1</label>
                                                </div>
                                                <div class="form-check form-check-inline mb-2">
                                                    <input class="form-check-input chk-department" type="checkbox" id="subitem-department-modal-2">
                                                    <label class="form-check-label" for="subitem-department-modal-2">department 2</label>
                                                </div>
                                            </div>
                                        </div>

                                        <div style="min-width:262px;padding:16px;display:none" id="sub-item-position-modal">
                                            <div class="list-group" style="margin-left:-16px;margin-right:-16px">
                                                <a href="javascript:void(0)" onclick="hideSubItemShift('sub-item-position-modal')" class="list-group-item list-group-item-action list-group-item-light d-flex align-items-center">
                                                    <i class="flaticon2-left-arrow mr-3"></i> position
                                                </a>
                                            </div>

                                            <div class="input-group mt-3 mb-3">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text" id="basic-addon1"> <i class="flaticon-search"></i> </span>
                                                </div>
                                                <input type="text" class="form-control" placeholder="Search" aria-label="Search" aria-describedby="basic-addon1">
                                            </div>

                                            <div class="d-flex flex-column">
                                                <div class="form-check form-check-inline mb-2">
                                                    <input class="form-check-input" type="checkbox" onclick="checkAllSubItem('chk-position', this)" id="chk-all-subitem-position-modal" value="">
                                                    <label class="form-check-label" for="chk-all-subitem-position-modal">ALL</label>
                                                </div>
                                                <div class="form-check form-check-inline mb-2">
                                                    <input class="form-check-input chk-position" type="checkbox" id="subitem-position-modal-1">
                                                    <label class="form-check-label" for="subitem-position-modal-1">position 1</label>
                                                </div>
                                                <div class="form-check form-check-inline mb-2">
                                                    <input class="form-check-input chk-position" type="checkbox" id="subitem-position-modal-2">
                                                    <label class="form-check-label" for="subitem-position-modal-2">position 2</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="d-flex justify-content-end" style="padding:16px;padding-right:32px;">
                                            <button type="button" class="btn btn-outline-primary">Apply</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <select class="form-control kt-select2" id="select-employee" data-tags="true" multiple="multiple" style="width:100%"></select>
                        </div>
                    </div>
                    <div class="col-lg-6 location">
                        <div class="form-group">
                            <label>Search Location</label>
                            <input type="text" class="form-control" placeholder="Golf Lake">
                        </div>
                        <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d8714.792026985662!2d106.72763291693215!3d-6.130307786325219!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e6a1d7e63d6e14d%3A0xc09d2b16b2679b68!2sGolf%20Lake%20Residence%20Cengkareng!5e0!3m2!1sen!2ssg!4v1670558953240!5m2!1sen!2ssg" width="100%" height="350" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                    </div>
                    <div class="col-lg-12 text-right">
                        <hr>
                        <div class="kt-form__actions">
                            <button type="submit" class="btn btn-success">Submit</button>
                            <button type="reset" class="btn btn-secondary">Cancel</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
@push('scriptjs')
<script>
    const el = document.querySelector('.kt-radio-inline')
    const loc = document.querySelector('.location')
    el.addEventListener('change', function handle(event){
        if (event.target.value == 1) {
            loc.style.display = 'block';
        } else {
            loc.style.display = 'none';
        }
    })

    var initTable1 = function () {
        var table = $(".kt_table_11");
        // begin first table
        table.DataTable({
            responsive: true,
            lengthMenu: [10, 25, 50],
            pageLength: 10,
            language: {
                lengthMenu: "Display _MENU_",
            },
            autoWidth: true,
            // Order settings
            order: [[1, "asc"]],
        });
    }();

    var selectAll = true;
    
    function showSubItem(subitem){
        $('#main-item').hide(100);
        $('#'+subitem).show(100);
    }

    function hideSubItem(subitem){
        $('#main-item').show(100);
        $('#'+subitem).hide(100);
    }

    function showSubItemShift(subitem){
        $('#main-item-shift').hide(100);
        $('#'+subitem).show(100);
    }

    function hideSubItemShift(subitem){
        $('#main-item-shift').show(100);
        $('#'+subitem).hide(100);
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
            { id: 1, title: 'Anang', description: 'DSS001-Fullstack Dev-Green lake city'},
            { id: 1, title: 'Anang', description: 'DSS001-Fullstack Dev-Green lake city'},
            { id: 1, title: 'Anang', description: 'DSS001-Fullstack Dev-Green lake city'},
            { id: 1, title: 'Anang', description: 'DSS001-Fullstack Dev-Green lake city'},
            { id: 1, title: 'Anang', description: 'DSS001-Fullstack Dev-Green lake city'},
            { id: 1, title: 'Anang', description: 'DSS001-Fullstack Dev-Green lake city'},
            { id: 1, title: 'Anang', description: 'DSS001-Fullstack Dev-Green lake city'},
            { id: 1, title: 'Anang', description: 'DSS001-Fullstack Dev-Green lake city'},
            { id: 1, title: 'Anang', description: 'DSS001-Fullstack Dev-Green lake city'},
            { id: 1, title: 'Anang', description: 'DSS001-Fullstack Dev-Green lake city'},
            { id: 1, title: 'Anang', description: 'DSS001-Fullstack Dev-Green lake city'},
            { id: 1, title: 'Anang', description: 'DSS001-Fullstack Dev-Green lake city'},
            { id: 1, title: 'Anang', description: 'DSS001-Fullstack Dev-Green lake city'},
            { id: 1, title: 'Anang', description: 'DSS001-Fullstack Dev-Green lake city'},
            { id: 1, title: 'Anang', description: 'DSS001-Fullstack Dev-Green lake city'},
            { id: 1, title: 'Anang', description: 'DSS001-Fullstack Dev-Green lake city'},
            { id: 1, title: 'Anang', description: 'DSS001-Fullstack Dev-Green lake city'},
            { id: 1, title: 'Anang', description: 'DSS001-Fullstack Dev-Green lake city'},
            { id: 1, title: 'Anang', description: 'DSS001-Fullstack Dev-Green lake city'},
            { id: 1, title: 'Anang', description: 'DSS001-Fullstack Dev-Green lake city'},
            { id: 1, title: 'Anang', description: 'DSS001-Fullstack Dev-Green lake city'},
            { id: 1, title: 'Anang', description: 'DSS001-Fullstack Dev-Green lake city'},
            { id: 1, title: 'Anang', description: 'DSS001-Fullstack Dev-Green lake city'},
            { id: 1, title: 'Anang', description: 'DSS001-Fullstack Dev-Green lake city'},
            { id: 1, title: 'Anang', description: 'DSS001-Fullstack Dev-Green lake city'},
            { id: 1, title: 'Anang', description: 'DSS001-Fullstack Dev-Green lake city'},
            { id: 1, title: 'Anang', description: 'DSS001-Fullstack Dev-Green lake city'},
            { id: 1, title: 'Anang', description: 'DSS001-Fullstack Dev-Green lake city'},
            { id: 1, title: 'Anang', description: 'DSS001-Fullstack Dev-Green lake city'},
            { id: 1, title: 'Anang', description: 'DSS001-Fullstack Dev-Green lake city'},
            { id: 1, title: 'Anang', description: 'DSS001-Fullstack Dev-Green lake city'},
            { id: 1, title: 'Anang', description: 'DSS001-Fullstack Dev-Green lake city'},
            { id: 1, title: 'Anang', description: 'DSS001-Fullstack Dev-Green lake city'},
            { id: 1, title: 'Anang', description: 'DSS001-Fullstack Dev-Green lake city'},
            { id: 1, title: 'Anang', description: 'DSS001-Fullstack Dev-Green lake city'},
            { id: 1, title: 'Anang', description: 'DSS001-Fullstack Dev-Green lake city'},
            { id: 1, title: 'Anang', description: 'DSS001-Fullstack Dev-Green lake city'},
            { id: 1, title: 'Anang', description: 'DSS001-Fullstack Dev-Green lake city'},
            { id: 1, title: 'Anang', description: 'DSS001-Fullstack Dev-Green lake city'},
            { id: 1, title: 'Anang', description: 'DSS001-Fullstack Dev-Green lake city'},
            { id: 1, title: 'Anang', description: 'DSS001-Fullstack Dev-Green lake city'},
            { id: 1, title: 'Anang', description: 'DSS001-Fullstack Dev-Green lake city'},
            { id: 1, title: 'Anang', description: 'DSS001-Fullstack Dev-Green lake city'},
            { id: 1, title: 'Anang', description: 'DSS001-Fullstack Dev-Green lake city'},
            { id: 1, title: 'Anang', description: 'DSS001-Fullstack Dev-Green lake city'},
            { id: 1, title: 'Anang', description: 'DSS001-Fullstack Dev-Green lake city'},
            { id: 1, title: 'Anang', description: 'DSS001-Fullstack Dev-Green lake city'},
            { id: 1, title: 'Anang', description: 'DSS001-Fullstack Dev-Green lake city'},
            { id: 1, title: 'Anang', description: 'DSS001-Fullstack Dev-Green lake city'},
            { id: 1, title: 'Anang', description: 'DSS001-Fullstack Dev-Green lake city'},
            { id: 1, title: 'Anang', description: 'DSS001-Fullstack Dev-Green lake city'},
            { id: 1, title: 'Anang', description: 'DSS001-Fullstack Dev-Green lake city'},
            { id: 1, title: 'Anang', description: 'DSS001-Fullstack Dev-Green lake city'},
            { id: 1, title: 'Anang', description: 'DSS001-Fullstack Dev-Green lake city'},
            { id: 1, title: 'Anang', description: 'DSS001-Fullstack Dev-Green lake city'},
            { id: 1, title: 'Anang', description: 'DSS001-Fullstack Dev-Green lake city'},
            { id: 1, title: 'Anang', description: 'DSS001-Fullstack Dev-Green lake city'},
            { id: 1, title: 'Anang', description: 'DSS001-Fullstack Dev-Green lake city'},
            { id: 1, title: 'Anang', description: 'DSS001-Fullstack Dev-Green lake city'},
            { id: 1, title: 'Anang', description: 'DSS001-Fullstack Dev-Green lake city'},
            { id: 1, title: 'Anang', description: 'DSS001-Fullstack Dev-Green lake city'},
            { id: 1, title: 'Anang', description: 'DSS001-Fullstack Dev-Green lake city'},
            { id: 1, title: 'Anang', description: 'DSS001-Fullstack Dev-Green lake city'},
            { id: 1, title: 'Anang', description: 'DSS001-Fullstack Dev-Green lake city'},
            { id: 1, title: 'Anang', description: 'DSS001-Fullstack Dev-Green lake city'},
            { id: 1, title: 'Anang', description: 'DSS001-Fullstack Dev-Green lake city'},
            { id: 1, title: 'Anang', description: 'DSS001-Fullstack Dev-Green lake city'},
            { id: 1, title: 'Anang', description: 'DSS001-Fullstack Dev-Green lake city'},
            { id: 1, title: 'Anang', description: 'DSS001-Fullstack Dev-Green lake city'},
            { id: 1, title: 'Anang', description: 'DSS001-Fullstack Dev-Green lake city'},
            { id: 1, title: 'Anang', description: 'DSS001-Fullstack Dev-Green lake city'},
            { id: 1, title: 'Anang', description: 'DSS001-Fullstack Dev-Green lake city'},
            { id: 1, title: 'Anang', description: 'DSS001-Fullstack Dev-Green lake city'},
            { id: 1, title: 'Anang', description: 'DSS001-Fullstack Dev-Green lake city'},
            { id: 1, title: 'Anang', description: 'DSS001-Fullstack Dev-Green lake city'},
            { id: 1, title: 'Anang', description: 'DSS001-Fullstack Dev-Green lake city'},
            { id: 1, title: 'Anang', description: 'DSS001-Fullstack Dev-Green lake city'},
            { id: 1, title: 'Anang', description: 'DSS001-Fullstack Dev-Green lake city'},
            { id: 1, title: 'Anang', description: 'DSS001-Fullstack Dev-Green lake city'},
            { id: 1, title: 'Anang', description: 'DSS001-Fullstack Dev-Green lake city'},
            { id: 1, title: 'Anang', description: 'DSS001-Fullstack Dev-Green lake city'},
            { id: 1, title: 'Anang', description: 'DSS001-Fullstack Dev-Green lake city'},
            { id: 1, title: 'Anang', description: 'DSS001-Fullstack Dev-Green lake city'},
            { id: 1, title: 'Anang', description: 'DSS001-Fullstack Dev-Green lake city'},
            { id: 1, title: 'Anang', description: 'DSS001-Fullstack Dev-Green lake city'},
            { id: 1, title: 'Anang', description: 'DSS001-Fullstack Dev-Green lake city'},
            { id: 1, title: 'Anang', description: 'DSS001-Fullstack Dev-Green lake city'},
            { id: 1, title: 'Anang', description: 'DSS001-Fullstack Dev-Green lake city'},
            { id: 1, title: 'Anang', description: 'DSS001-Fullstack Dev-Green lake city'},
            { id: 1, title: 'Anang', description: 'DSS001-Fullstack Dev-Green lake city'},
            { id: 1, title: 'Anang', description: 'DSS001-Fullstack Dev-Green lake city'},
            { id: 1, title: 'Anang', description: 'DSS001-Fullstack Dev-Green lake city'},
            { id: 1, title: 'Anang', description: 'DSS001-Fullstack Dev-Green lake city'},
            { id: 1, title: 'Anang', description: 'DSS001-Fullstack Dev-Green lake city'},
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
