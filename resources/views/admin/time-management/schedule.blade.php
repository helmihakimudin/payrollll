@extends('layout-admin.base', [
    'pages' => 'Time Management',
    'subpages' => 'Time Management',
])
@section('content')
    {{-- Sub Header --}}

    <style>
        .form-check-input-schedule{
            margin-top: 0px !important;
        }

        .bulk-action-schedule{
            position:absolute;background:white; width:100%; height:43.5px; top:50px; right:0px; z-index:1; margin-left:100px;
        }

        .select2-selection__rendered{
            max-height:200px;
            overflow-y:auto !important;
        }

        .col-shift-area{
            position: relative;
        }

        .col-shift{
            /* display:none; */
        }

        .btn-shift-option{
            border-width:0px !important;
        }

        .col-shift-area:hover .col-shift{
            /* display:block; */
        }
    </style>

    {{-- Body Datatables --}}
<div id="App">
    <div class="kt-body kt-grid__item kt-grid__item--fluid kt-grid kt-grid--hor kt-grid--stretch" id="kt_body">
        <div class="kt-content  kt-grid__item kt-grid__item--fluid kt-grid kt-grid--hor" id="kt_content">
            <div class="kt-subheader   kt-grid__item mt-0" id="kt_subheader">
                <div class="kt-container bg-primary py-4">
                    <div class="d-flex justify-content-between w-100 align-items-center">
                        <h3 class="kt-subheader__title m-0 text-light">
                            Schedule
                        </h3>
                        <div class="d-flex" id="kt_subheader_search">
                            <span class="kt-subheader__desc" id="kt_subheader_total">
                                <div class="dropdown">
                                    <button class="btn btn-light dropdown-toggle" type="button"
                                        id="dropdownFilter" data-toggle="dropdown" aria-haspopup="true"
                                        aria-expanded="false">
                                        Filter <span style="margin-left:4px" v-show="totalFilter != 0 && totalFilter != '(0)'" v-text="totalFilter"></span>
                                    </button>
                                    <div class="dropdown-menu" aria-labelledby="dropdownFilter" id="filter-employee">
                                        <div style="min-width:262px;overflow-y:scroll;padding:16px" id="main-item">
                                            <div class="list-group">
                                                <a href="javascript:void(0)" onclick="showSubItem('sub-item-branch')" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">Branch <i class="flaticon2-right-arrow"></i> </a>
                                                <a href="javascript:void(0)" onclick="showSubItem('sub-item-department')" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">Department <i class="flaticon2-right-arrow"></i> </a>
                                                <a href="javascript:void(0)" onclick="showSubItem('sub-item-position')" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">Position <i class="flaticon2-right-arrow"></i> </a>
                                            </div>
                                        </div>

                                        <div style="min-width:262px;overflow-y:scroll;padding:16px;display:none;max-height:600px" id="sub-item-branch">
                                            <div class="list-group" style="margin-left:-16px;margin-right:-16px">
                                                <a href="javascript:void(0)" onclick="hideSubItem('sub-item-branch')" class="list-group-item list-group-item-action list-group-item-light d-flex align-items-center">
                                                    <i class="flaticon2-left-arrow mr-3"></i> Branch
                                                </a>
                                            </div>

                                            <div class="input-group mt-3 mb-3">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text" id="basic-addon1"> <i class="flaticon-search"></i> </span>
                                                </div>
                                                <input type="text" class="form-control" placeholder="Search" aria-label="Search" aria-describedby="basic-addon1" v-on:input="searchBranch">
                                            </div>

                                            <div class="d-flex flex-column">
                                                <div class="form-check form-check-inline mb-2">
                                                    <input class="form-check-input" type="checkbox" @click="checkAllBranchFilter($event, 0)" id="chk-all-subitem-branch" value="">
                                                    <label class="form-check-label" for="chk-all-subitem-branch">ALL</label>
                                                </div>
                                                <div class="form-check form-check-inline mb-2" v-for="(branch, index) in filterBranch">
                                                    <input @click="onItemFilterClick" class="form-check-input chk-branch" :id="'subitem-branch-'+index" type="checkbox" v-model="branch.checked_a" :checked="branch.checked_a || false">
                                                    <label class="form-check-label" :for="'subitem-branch-'+index" v-text="branch.name"></label>
                                                </div>
                                            </div>
                                        </div>

                                        <div style="min-width:262px;overflow-y:scroll;padding:16px;display:none;max-height:600px" id="sub-item-department">
                                            <div class="list-group" style="margin-left:-16px;margin-right:-16px">
                                                <a href="javascript:void(0)" onclick="hideSubItem('sub-item-department')" class="list-group-item list-group-item-action list-group-item-light d-flex align-items-center">
                                                    <i class="flaticon2-left-arrow mr-3"></i> Department
                                                </a>
                                            </div>

                                            <div class="input-group mt-3 mb-3">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text" id="basic-addon1"> <i class="flaticon-search"></i> </span>
                                                </div>
                                                <input type="text" class="form-control" placeholder="Search" aria-label="Search" aria-describedby="basic-addon1" v-on:input="searchDepartment">
                                            </div>

                                            <div class="d-flex flex-column">
                                                <div class="form-check form-check-inline mb-2">
                                                    <input class="form-check-input" type="checkbox" @click="checkAllDepartmentFilter($event, 0)" id="chk-all-subitem-department" value="">
                                                    <label class="form-check-label" for="chk-all-subitem-department">ALL</label>
                                                </div>
                                                <div class="form-check form-check-inline mb-2" v-for="(department, index) in filterDepartment">
                                                    <input @click="onItemFilterClick" class="form-check-input chk-department" type="checkbox" :id="'subitem-department-'+index" v-model="department.checked_a" :checked="department.checked_a || false">
                                                    <label class="form-check-label" :for="'subitem-department-'+index" v-text="department.name"></label>
                                                </div>
                                            </div>
                                        </div>

                                        <div style="min-width:262px;overflow-y:scroll;padding:16px;display:none;max-height:600px" id="sub-item-position">
                                            <div class="list-group" style="margin-left:-16px;margin-right:-16px">
                                                <a href="javascript:void(0)" onclick="hideSubItem('sub-item-position')" class="list-group-item list-group-item-action list-group-item-light d-flex align-items-center">
                                                    <i class="flaticon2-left-arrow mr-3"></i> Position
                                                </a>
                                            </div>

                                            <div class="input-group mt-3 mb-3">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text" id="basic-addon1"> <i class="flaticon-search"></i> </span>
                                                </div>
                                                <input type="text" class="form-control" placeholder="Search" aria-label="Search" aria-describedby="basic-addon1" v-on:input="searchPosition">
                                            </div>

                                            <div class="d-flex flex-column">
                                                <div class="form-check form-check-inline mb-2">
                                                    <input class="form-check-input" type="checkbox" @click="checkAllPositionFilter($event, 0)" id="chk-all-subitem-position" value="">
                                                    <label class="form-check-label" for="chk-all-subitem-position">ALL</label>
                                                </div>
                                                <div class="form-check form-check-inline mb-2" v-for="(position, index) in filterPosition">
                                                    <input @click="onItemFilterClick" class="form-check-input chk-position" type="checkbox" :id="'subitem-position-'+index" v-model="position.checked_a" :checked="position.checked_a || false">
                                                    <label class="form-check-label" :for="'subitem-position-'+index" v-text="position.name"></label>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="d-flex justify-content-end" style="padding-right:32px">
                                            <button type="button" class="btn btn-outline-primary" @click="applyFilter">Apply</button>
                                        </div>
                                    </div>
                                </div>
                            </span>
                            <span class="kt-subheader__desc" id="kt_subheader_total">
                                <div class="dropdown">
                                    <button class="btn btn-light dropdown-toggle" type="button"
                                        id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true"
                                        aria-expanded="false">
                                        More
                                    </button>
                                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                        <a class="dropdown-item" href="#">Export</a>
                                        <a class="dropdown-item" href="{{route('attendance')}}">Setting</a>
                                        <a class="dropdown-item" href="#">Help</a>
                                    </div>
                                </div>
                            </span>
                            <span><a href="#" class="btn btn-light rounded-fill" data-toggle="modal" data-target="#assignModal" @click="showModalAssign">Assign Shift</a></span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="kt-container  kt-grid__item kt-grid__item--fluid">
                <div class="row">
                    <div class="col-lg-12">
                        <div id="bulk-action" class="d-none bulk-action-schedule align-items-center">
                            <div class="dropdown">
                                <button class="btn btn-secondary dropdown-toggle mr-2" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    Bulk Action
                                </button>
                                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                    <a class="dropdown-item" href="#">Assign Shift</a>
                                    <a class="dropdown-item" href="#">Remove Shift</a>
                                </div>
                            </div>

                            <button onclick="cancelBulkSchedule()" class="btn btn-light">Cancel</button>
                        </div>
                        <table
                            class="table table-sm table-striped table-bordered table-hover table-checkable kt_table_11"
                            style="font-size:11px;" id="schedule-table">
                            <thead>
                                <tr role="row">
                                    <th>Nama Employee</th>
                                    @foreach($weeks as $row)
                                        <th>{{ucwords($row['day_name']).', '.date('d M Y', strtotime($row['date']))}}</th>
                                    @endforeach
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td colspan="14"></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- change modal -->
        <div class="modal fade" tabindex="-1" role="dialog" id="changeShiftModal">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" v-text="isAddShift?'Add Shift':'Change Shift'"></h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form>

                            <div class="form-group">
                                <label for="exampleInputPassword1">Shift <span class="text-danger">*</span></label> <br>
                                <vue-select :key="componentKey" name="" class="form-control kt-select2" :class="shiftSelectedErr?'is-invalid':''" id="select-shift2" style="width:100%" v-model="shiftSelected" v-bind:options="shifts" v-bind:selected="shiftSelected">    
                                </vue-select>
                                <div v-text="shiftSelectedErr" class="invalid-feedback"></div>
                            </div>

                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary" @click="changeShiftSave" :class="changeShiftLoading?'kt-spinner kt-spinner--sm kt-spinner--danger':''">Save</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- end -->

        <!-- change modal -->
        <div class="modal fade" tabindex="-1" role="dialog" id="confirmDeleteShiftModal">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Confirmation Delete</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <span>You will delete 1 employee (<span v-text="dateSelectedLocalStr"></span>). Please note that the shift with attendance data recorded in it will not be deleted.</span>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-danger"  @click="deleteShiftRun" :class="deleteShiftLoading?'kt-spinner kt-spinner--sm kt-spinner--danger':''">Delete</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- end -->

        <!-- assign modal -->
        <div class="modal fade" tabindex="-1" role="dialog" id="assignModal">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Assign Shift</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Employee <span class="text-danger">*</span></label>
                                <div class="float-right d-flex position-relative">
                                    <div>
                                        <a href="javascript:void(0)" id="dropdownFilterAgenShift" data-toggle="dropdown" aria-haspopup="true"
                                        aria-expanded="false"><i class="fa fa-filter"></i> Filter <span v-show="totalFilterInModal != 0 && totalFilterInModal != '(0)'" v-text="totalFilterInModal"></span></a>
                                        <div class="dropdown-menu" id="filter-employee-shift" aria-labelledby="dropdownFilter2">
                                            <div style="min-width:262px;overflow-y:scroll;padding:16px" id="main-item-shift">
                                                <div class="list-group">
                                                    <a href="javascript:void(0)" onclick="showSubItemShift('sub-item-branch-modal')" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">Branch <i class="flaticon2-right-arrow"></i> </a>
                                                    <a href="javascript:void(0)" onclick="showSubItemShift('sub-item-department-modal')" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">Department <i class="flaticon2-right-arrow"></i> </a>
                                                    <a href="javascript:void(0)" onclick="showSubItemShift('sub-item-position-modal')" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">Position <i class="flaticon2-right-arrow"></i> </a>
                                                </div>
                                            </div>

                                            <div style="min-width:262px;overflow-y:scroll;padding:16px;display:none;max-height:600px" id="sub-item-branch-modal">
                                                <div class="list-group" style="margin-left:-16px;margin-right:-16px">
                                                    <a href="javascript:void(0)" onclick="hideSubItemShift('sub-item-branch-modal')" class="list-group-item list-group-item-action list-group-item-light d-flex align-items-center">
                                                        <i class="flaticon2-left-arrow mr-3"></i> Branch
                                                    </a>
                                                </div>

                                                <div class="input-group mt-3 mb-3">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text" id="basic-addon1"> <i class="flaticon-search"></i> </span>
                                                    </div>
                                                    <input type="text" class="form-control" placeholder="Search" aria-label="Search" aria-describedby="basic-addon1" v-on:input="searchBranch">
                                                </div>

                                                <div class="d-flex flex-column">
                                                    <div class="form-check form-check-inline mb-2">
                                                        <input class="form-check-input" type="checkbox" @click="checkAllBranchFilter($event, 1)" id="chk-all-subitem-branch-modal" value="">
                                                        <label class="form-check-label" for="chk-all-subitem-branch-modal">ALL</label>
                                                    </div>
                                                    <div class="form-check form-check-inline mb-2" v-for="(branch, index) in filterBranch">
                                                        <input @click="onItemFilterClick" class="form-check-input chk-branch" :id="'subitem-branch-modal-'+index" type="checkbox" v-model="branch.checked_b" :checked="branch.checked_b || false">
                                                        <label class="form-check-label" :for="'subitem-branch-modal-'+index" v-text="branch.name"></label>
                                                    </div>
                                                </div>
                                            </div>

                                            <div style="min-width:262px;overflow-y:scroll;padding:16px;display:none;max-height:600px" id="sub-item-department-modal">
                                                <div class="list-group" style="margin-left:-16px;margin-right:-16px">
                                                    <a href="javascript:void(0)" onclick="hideSubItemShift('sub-item-department-modal')" class="list-group-item list-group-item-action list-group-item-light d-flex align-items-center">
                                                        <i class="flaticon2-left-arrow mr-3"></i> Department
                                                    </a>
                                                </div>

                                                <div class="input-group mt-3 mb-3">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text" id="basic-addon1"> <i class="flaticon-search"></i> </span>
                                                    </div>
                                                    <input type="text" class="form-control" placeholder="Search" aria-label="Search" aria-describedby="basic-addon1" v-on:input="searchDepartment">
                                                </div>

                                                <div class="d-flex flex-column">
                                                    <div class="form-check form-check-inline mb-2">
                                                        <input class="form-check-input" type="checkbox" @click="checkAllDepartmentFilter($event, 1)" id="chk-all-subitem-department-modal" value="">
                                                        <label class="form-check-label" for="chk-all-subitem-department-modal">ALL</label>
                                                    </div>
                                                    <div class="form-check form-check-inline mb-2" v-for="(department, index) in filterDepartment">
                                                        <input @click="onItemFilterClick" class="form-check-input chk-department" type="checkbox" :id="'subitem-department-modal-'+index" v-model="department.checked_b" :checked="department.checked_b || false">
                                                        <label class="form-check-label" :for="'subitem-department-modal-'+index" v-text="department.name"></label>
                                                    </div>
                                                </div>
                                            </div>

                                            <div style="min-width:262px;overflow-y:scroll;padding:16px;display:none;max-height:600px" id="sub-item-position-modal">
                                                <div class="list-group" style="margin-left:-16px;margin-right:-16px">
                                                    <a href="javascript:void(0)" onclick="hideSubItemShift('sub-item-position-modal')" class="list-group-item list-group-item-action list-group-item-light d-flex align-items-center">
                                                        <i class="flaticon2-left-arrow mr-3"></i> Position
                                                    </a>
                                                </div>

                                                <div class="input-group mt-3 mb-3">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text" id="basic-addon1"> <i class="flaticon-search"></i> </span>
                                                    </div>
                                                    <input type="text" class="form-control" placeholder="Search" aria-label="Search" aria-describedby="basic-addon1" v-on:input="searchPosition">
                                                </div>

                                                <div class="d-flex flex-column">
                                                    <div class="form-check form-check-inline mb-2">
                                                        <input class="form-check-input" type="checkbox" @click="checkAllPositionFilter($event, 1)" id="chk-all-subitem-position-modal" value="">
                                                        <label class="form-check-label" for="chk-all-subitem-position-modal">ALL</label>
                                                    </div>
                                                    <div class="form-check form-check-inline mb-2" v-for="(position, index) in filterPosition">
                                                        <input @click="onItemFilterClick" class="form-check-input chk-position" type="checkbox" :id="'subitem-position-modal-'+index" v-model="position.checked_b" :checked="position.checked_b || false">
                                                        <label class="form-check-label" :for="'subitem-position-modal-'+index" v-text="position.name"></label>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="d-flex justify-content-end" style="padding:16px;padding-right:32px;">
                                                <button type="button" class="btn btn-outline-primary" onclick="$('#dropdownFilterAgenShift').dropdown('toggle');">Close</button>
                                            </div>
                                            
                                        </div>
                                    </div>

                                    <span class="ml-2 mr-2 text-secondary">|</span>
                                    <label class="kt-checkbox">
                                        <input id="select-all" type="checkbox"> Select All Employee
                                        <span></span>
                                    </label>

                                </div>
                                <select class="form-control kt-select2" id="select-employee" data-tags="true" multiple="multiple" style="width:100%"></select>
                                <div v-text="selectEmployeeErr" class="text-danger"></div>
                            </div>

                            <div class="form-group">
                                <label for="exampleInputPassword1">Shift <span class="text-danger">*</span></label> <br>
                                <select class="form-control kt-select2" id="select-shift" style="width:100%">
                                    <option value=""></option>    
                                </select>
                                <div v-text="shiftErr" class="text-danger"></div>
                            </div>

                            <div class="form-group">
                                <label for="exampleInputEmail1">Days <span class="text-danger">*</span></label>
                                <div class="kt-checkbox-inline d-flex justify-content-between" :class="shiftErr?'is-invalid':''">
                                    <label class="kt-checkbox">
                                        <input class="days" name="days[]" value="mon" type="checkbox" checked> Mon
                                        <span></span>
                                    </label>
                                    <label class="kt-checkbox">
                                        <input class="days" name="days[]" value="tue" type="checkbox" checked> Tue
                                        <span></span>
                                    </label>
                                    <label class="kt-checkbox">
                                        <input class="days" name="days[]" value="wed" type="checkbox" checked> Wed
                                        <span></span>
                                    </label>
                                    <label class="kt-checkbox">
                                        <input class="days" name="days[]" value="thu" type="checkbox" checked> Thu
                                        <span></span>
                                    </label>
                                    <label class="kt-checkbox">
                                        <input class="days" name="days[]" value="fri" type="checkbox" checked> Fri
                                        <span></span>
                                    </label>
                                    <label class="kt-checkbox">
                                        <input class="days" name="days[]" value="sat" type="checkbox" checked> Sat
                                        <span></span>
                                    </label>
                                    <label class="kt-checkbox">
                                        <input class="days" name="days[]" value="sun" type="checkbox" checked> Sun
                                        <span></span>
                                    </label>
                                </div>
                                <div v-text="daysErr" class="text-danger"></div>
                            </div>
                            
                            <div class="form-group">
                                <label for="exampleInputEmail1">Start Date <span class="text-danger">*</span></label> <br>
                                <input type="date" id="start-date" class="form-control">
                                <div v-text="startDateErr" class="text-danger"></div>
                            </div>

                            <div class="form-group">
                                <label for="exampleInputEmail1">End Date <span class="text-secondary">(optional)</span></label> <br>
                                <input type="date" id="end-date" class="form-control">
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary" :disabled="assignNowLoading" :class="assignNowLoading?'kt-spinner kt-spinner--sm kt-spinner--danger':''" @click="assignNow">Assign Now</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- end -->
    </div>
</div>
@endsection
@push('scriptjs')

    <script>

        var VueSelect = {
            template: `<select v-change> <option value="" :selected="selected == null">Select Shift</option> <option :value="shift.id" v-for="shift in options" v-text="shift.name+' ('+shift.working_hour_start.substr(0,5)+'-'+shift.working_hour_end.substr(0,5)+')'" :selected="selected == shift.id"></option> </select>`,
            directives: {
                change: {
                    inserted (el, binding, vNode) {
                        setTimeout(() => {
                            $(el).select2().on('change',function(e){
                                vNode.context.$emit('input', e.target.value)
                            });
                        }, 0);
                    }
                }
            },
            props: ['options','selected'],
            methods: {
                change (v){
                    console.log('OKE');
                    this.$emit('input', v)
                }
            }
        };

        const vm = new Vue({
            el : '#App',
            data : {
                filterBranch : [],
                filterDepartment : [],
                filterPosition : [],
                tempFilterList : null,
                shifts : [],
                shiftSelected : '',
                shiftSelectedErr : '',
                dateSelected : '',
                dateSelectedLocalStr : '',
                employeeSelected : '',
                changeShiftLoading : false,
                deleteShiftLoading : false,
                assignNowLoading : false,
                isAddShift : null,
                componentKey : 0,
                totalFilterInModal : 0,
                totalFilter : 0,
                selectEmployeeErr : '',
                shiftErr : '',
                daysErr : '',
                startDateErr : ''
            },
            components : {
                'vue-select': VueSelect,
            },
            methods : {
                getFilterList(){
                    fetch(`{{route('time.schedule.filter-list')}}`, {
                    method: 'get',
                        headers: {
                            'Content-Type' : 'application/json',
                            'X-CSRF-Token' : $('meta[name="csrf-token"]').attr('content')
                        }
                    }).then(async (responseTxt) => {

                        const response = await responseTxt.json(responseTxt);
                        if(response.status == 200){
                            this.filterBranch = response.data.branches;
                            this.filterDepartment = response.data.department;
                            this.filterPosition = response.data.position;
                            
                            this.tempFilterList = response.data;
                        }
                        
                    }).catch(async (error) => {
                        //error respons
                        this.showAlert('Failed', 'When get filer list', 'danger');
                    })
                },
                getShifts(callback){
                    fetch(`{{route('time.schedule.shift-list')}}`, {
                    method: 'get',
                        headers: {
                            'Content-Type' : 'application/json',
                            'X-CSRF-Token' : $('meta[name="csrf-token"]').attr('content')
                        }
                    }).then(async (responseTxt) => {

                        const response = await responseTxt.json(responseTxt);
                        if(response.status == 200){
                            this.shifts = response.data;
                        }

                        callback && callback();
                        
                    }).catch(async (error) => {
                        //error response
                        this.showAlert('Failed', 'When get shift list', 'danger');

                        callback && callback();
                    })
                },
                searchBranch(e){
                    this.filterBranch = this.tempFilterList.branches.filter((item)=>{
                        return item.name.toLowerCase().includes(e.target.value.toLowerCase())
                    })
                },
                searchDepartment(e){
                    this.filterDepartment = this.tempFilterList.department.filter((item)=>{
                        return item.name.toLowerCase().includes(e.target.value.toLowerCase())
                    })
                },
                searchPosition(e){
                    this.filterPosition = this.tempFilterList.position.filter((item)=>{
                        return item.name.toLowerCase().includes(e.target.value.toLowerCase())
                    })
                },
                checkAllBranchFilter(e, isFromModal){
                    let i = 0;
                    for (const item of this.filterBranch) {
                        if(isFromModal == 1){
                            item.checked_b = e.target.checked;
                        }else{
                            item.checked_a = e.target.checked;
                        }
                        this.$set(this.filterBranch, i, item);
                        i++;
                    }
                    setTimeout(() => {
                        this.countTotalFilterInModal();
                        this.countTotalFilter();
                    }, 0);
                },
                checkAllDepartmentFilter(e, isFromModal){
                    let i = 0;
                    for (const item of this.filterDepartment) {
                        if(isFromModal == 1){
                            item.checked_b = e.target.checked;
                        }else{
                            item.checked_a = e.target.checked;
                        }
                        this.$set(this.filterDepartment, i, item);
                        i++;
                    }

                    setTimeout(() => {
                        this.countTotalFilterInModal();
                        this.countTotalFilter();
                    }, 0);
                },
                checkAllPositionFilter(e, isFromModal){
                    let i = 0;
                    for (const item of this.filterPosition) {
                        if(isFromModal == 1){
                            item.checked_b = e.target.checked;
                        }else{
                            item.checked_a = e.target.checked;
                        }
                        this.$set(this.filterPosition, i, item);
                        i++;
                    }

                    setTimeout(() => {
                        this.countTotalFilterInModal();
                        this.countTotalFilter();
                    }, 0);
                },
                countTotalFilterInModal(){
                    let totalFilterBranch = this.filterBranch.filter((item)=> item.checked_b);
                    let totalFilterDepartment = this.filterDepartment.filter((item)=> item.checked_b);
                    let totalFilterPosition = this.filterPosition.filter((item)=> item.checked_b);

                    this.totalFilterInModal = '('+ (totalFilterBranch.length + totalFilterDepartment.length + totalFilterPosition.length) + ')';
                },
                countTotalFilter(){
                    let totalFilterBranch = this.filterBranch.filter((item)=> item.checked_a);
                    let totalFilterDepartment = this.filterDepartment.filter((item)=> item.checked_a);
                    let totalFilterPosition = this.filterPosition.filter((item)=> item.checked_a);

                    this.totalFilter = '('+ (totalFilterBranch.length + totalFilterDepartment.length + totalFilterPosition.length) + ')';
                },
                onItemFilterClick(){
                    setTimeout(() => {
                        this.countTotalFilterInModal();
                        this.countTotalFilter();
                    }, 0);
                },
                applyFilter(){
                    window.loadData(this.filterBranch, this.filterDepartment, this.filterPosition);
                },
                showAlert(title="", message="", type="success"){
                    var content = {};

                    content.message = message;
                    content.title = title;

                    if (type == 'success') {
                        content.icon = 'icon ' + 'flaticon2-check-mark';
                    }else if(type == 'error'){
                        content.icon = 'icon ' + 'flaticon-exclamation-2';
                    }

                    $.notify(content, { 
                        type: type,
                        allow_dismiss: true,
                        newest_on_top: true,
                        mouse_over:  true,
                        showProgressbar:  false,
                        spacing: 10,                    
                        timer: 3000,
                        placement: {
                            from: 'top', 
                            align: 'right'
                        },
                        offset: {
                            x: 30, 
                            y: 30
                        },
                        delay: 1000,
                        z_index: 10000,
                        animate: {
                            enter: 'animated slideInLeft',
                            exit: 'animated slideInLeft'
                        }
                    });
                },
                changeShift(shiftId, date, employeeId){
                    this.getShifts(()=>{
                        
                    });

                    this.shiftSelectedErr = '';

                    this.shiftSelected = shiftId;
                    this.isAddShift = this.shiftSelected == null?true:false;
                    this.dateSelected = date;
                    this.employeeSelected = employeeId;

                    this.componentKey += 1;
                    
                },
                deleteShift(shiftId, date, employeeId){
                    this.shiftSelected = shiftId;
                    this.dateSelected = date;
                    this.employeeSelected = employeeId;

                    const d = new Date(date);
                    let text = d.toLocaleDateString();
                    this.dateSelectedLocalStr = text;
                },
                changeShiftSave(callback){

                    if(this.shiftSelected == null || this.shiftSelected == ''){
                        this.shiftSelectedErr = 'Please choose shift first';
                        setTimeout(() => {
                            $('#select-shift2').select2({placeholder: "Select Shift"});
                        }, 0);
                        return;
                    }
                    
                    //loading
                    this.changeShiftLoading = true;

                    fetch(`{{route('time.schedule.shift-change')}}`, {
                    method: 'post',
                        headers: {
                            'Content-Type' : 'application/json',
                            'X-CSRF-Token' : $('meta[name="csrf-token"]').attr('content')
                        },
                        body : JSON.stringify({
                            shift_id : this.shiftSelected,
                            date : this.dateSelected,
                            employee_id : this.employeeSelected
                        })
                    }).then(async (responseTxt) => {

                        //stop loading
                        this.changeShiftLoading = false;

                        const response = await responseTxt.json(responseTxt);
                        if(response.status == 200){
                            this.showAlert('Success', response.message, 'success');
                            $('#changeShiftModal').modal('toggle');

                            //reload data
                            window.loadData(this.filterBranch, this.filterDepartment, this.filterPosition);
                        }else{
                            this.showAlert('Failed', response.message, 'danger');
                        }
                        
                    }).catch(async (error) => {
                        //error response

                        //stop loading
                        this.changeShiftLoading = false;

                        this.showAlert('Failed', 'When change shift', 'danger');
                    })
                },
                deleteShiftRun(callback){

                    //loading
                    this.deleteShiftLoading = true;

                    fetch(`{{route('time.schedule.shift-delete')}}`, {
                    method: 'post',
                        headers: {
                            'Content-Type' : 'application/json',
                            'X-CSRF-Token' : $('meta[name="csrf-token"]').attr('content')
                        },
                        body : JSON.stringify({
                            shift_id : this.shiftSelected,
                            date : this.dateSelected,
                            employee_id : this.employeeSelected
                        })
                    }).then(async (responseTxt) => {

                        //stop loading
                        this.deleteShiftLoading = false;

                        const response = await responseTxt.json(responseTxt);
                        if(response.status == 200){
                            this.showAlert('Success', response.message, 'success');
                            $('#confirmDeleteShiftModal').modal('toggle');

                            //reload data
                            window.loadData(this.filterBranch, this.filterDepartment, this.filterPosition);
                        }else{
                            this.showAlert('Failed', response.message, 'danger');
                        }
                        
                    }).catch(async (error) => {
                        //error response

                        //stop loading
                        this.deleteShiftLoading = false;

                        this.showAlert('Failed', 'When change shift', 'danger');
                    })
                },
                assignNow(){

                    //get checked days
                    var days = [];
                    $('.days:checked').each(function(i){
                        days[i] = $(this).val();
                    });

                    //clear err
                    this.selectEmployeeErr = '';
                    this.shiftErr = '';
                    this.daysErr = '';
                    this.startDateErr = '';

                    //validation
                    if( $('#select-employee').val() == ''){
                        this.selectEmployeeErr = 'Please select employee first.';
                        return;
                    }
                    if($('#select-shift').val() == ''){
                        this.shiftErr = 'Shift is required.';
                        return;
                    }
                    if(days.length == 0){
                        this.daysErr = 'Please select day first.';
                        return;
                    }
                    if($('#start-date').val() == ''){
                        this.startDateErr = 'Start Date is required.';
                        return;
                    }
                    
                    //loading
                    this.assignNowLoading = true;

                    fetch(`{{route('time.schedule.assign-bulk')}}`, {
                    method: 'post',
                        headers: {
                            'Content-Type' : 'application/json',
                            'X-CSRF-Token' : $('meta[name="csrf-token"]').attr('content')
                        },
                        body : JSON.stringify({
                            employees : $('#select-employee').val(),
                            start_date : $('#start-date').val(),
                            end_date : $('#end-date').val(),
                            shift_id : $('#select-shift').val(),
                            days : days
                        })
                    }).then(async (responseTxt) => {

                        //stop loading
                        this.assignNowLoading = false;

                        const response = await responseTxt.json(responseTxt);
                        if(response.status == 200){
                            this.showAlert('Success', response.message, 'success');

                            //reload data
                            window.loadData(this.filterBranch, this.filterDepartment, this.filterPosition);

                            //close modal
                            $('#assignModal').modal('toggle');
                        }else{
                            this.showAlert('Failed', response.message, 'danger');
                        }
                        
                    }).catch(async (error) => {
                        //error response

                        //stop loading
                        this.assignNowLoading = false;

                        this.showAlert('Failed', 'When assign bulk shift', 'danger');
                    })

                },
                showModalAssign(){
                    this.selectEmployeeErr = '';
                    this.shiftErr = '';
                    this.daysErr = '';
                    this.startDateErr = '';
                    this.endDateErr = '';
                    
                    $('#select-employee').empty().trigger("change");
                    $('#start-date').val('')
                    $('#end-date').val('')
                    $('#select-shift').empty().trigger("change");
                }
            },
            mounted(){
                this.getFilterList();
            }
        });
    </script>
    <script>
        var selectAll = true;
        var filterBranch = "";
        var filterDepartment = "";
        var filterPosition = "";

        function changeShift(shiftId, date, employeeId){
            vm.changeShift(shiftId, date, employeeId)
        }

        function deleteShift(shiftId, date, employeeId){
            vm.deleteShift(shiftId, date, employeeId)
        }

        var scheduleTable = $('#schedule-table').DataTable({
            drawCallback: function() {
                $(".dataTables_paginate > .pagination").addClass("pagination-rounded");
                $("#btn-prev-week").remove();
                $("#btn-next-week").remove();
                $('#schedule-table_filter').append(`<a href="{{route('time.schedule').'?date='.$prev_week}}" id="btn-prev-week" class="ml-2 btn btn-light rounded-fill"><i class="la la-angle-left"></i> Prev Week</a> <a href="{{route('time.schedule').'?date='.$next_week}}" id="btn-next-week" class="ml-2 btn btn-light rounded-fill">Next Week <i class="la la-angle-right"></i></a>`)
            },
            scrollX: true,
            bStateSave: true,
            select: false,
            serverSide: true,
            processing: true,
            ordering:false,
            paging: true,
            ajax: {
                url: '{{ route("time.schedule.ajax.employee") }}',
                type: 'post',
                data: function(d){
                    d._token = "{{ csrf_token() }}";
                    d._filter_branch = filterBranch;
                    d._filter_department = filterDepartment;
                    d._filter_position = filterPosition;
                    d._date = "{{ request()->get('date') }}"
                }
            },
            columns: [{
                    data: 'full_name',
                },{
                    data: 'mon'
                },{
                    data: 'tue'
                },{
                    data: 'wed'
                },{
                    data: 'thu'
                },{
                    data: 'fri'
                },{
                    data: 'sat'
                },{
                    data: 'sun'
                }
            ],
        });

        function loadData(branch, department, position){

            filterBranch = JSON.stringify(branch.filter((item)=>item.checked_a).map((item)=>item.id));
            filterDepartment = JSON.stringify(department.filter((item)=>item.checked_a).map((item)=>item.id));
            filterPosition = JSON.stringify(position.filter((item)=>item.checked_a).map((item)=>item.id));

            scheduleTable.ajax.reload();
            
        }

        function checkAllSubItem(classDom, obj){
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

        function setTemplateLoad(){
            return `<div class="kt-spinner kt-spinner--md kt-spinner--info" style="padding:20px"></div>`;
        }

        function getEmployee(callback){
            $.ajax({
                url: "{{route('time.schedule.employees')}}",
                headers: {
                    'Content-Type' : 'application/json',
                    'X-CSRF-Token' : $('meta[name="csrf-token"]').attr('content')
                },
                type: "GET",
                dataType: "json",
                data: {
                    q: '',
                    _filter_branch : JSON.stringify(vm.filterBranch.filter((item)=>item.checked_b==true).map((item)=>item.id)),
                    _filter_department : JSON.stringify(vm.filterDepartment.filter((item)=>item.checked_b==true).map((item)=>item.id)),
                    _filter_position : JSON.stringify(vm.filterPosition.filter((item)=>item.checked_b==true).map((item)=>item.id))
                },
                success: function (data) {
                    callback(data.data);
                }
            })
        }

        function initSelectAllEmployee(){
            $('#select-employee').select2({
                allowClear: false,
                disabled: false,
                placeholder: "Select Shift",
                templateResult: function (d) { 
                    if(d.loading == true){
                        return $(setTemplateLoad());
                    }else{
                        if(d.description != undefined){
                            return $(setTemplate(d.text, d.description));
                        }else{
                            return null;
                        }
                    }
                },
                templateSelection: function (d) { return d.text },
                ajax: {
                    url: "{{route('time.schedule.employees')}}",
                    headers: {
                        'Content-Type' : 'application/json',
                        'X-CSRF-Token' : $('meta[name="csrf-token"]').attr('content')
                    },
                    dataType: 'json',
                    type: "GET",
                    quietMillis: 50,
                    data: function (term) {
                        return {
                            q: term.term,
                            _filter_branch : JSON.stringify(vm.filterBranch.filter((item)=>item.checked_b==true).map((item)=>item.id)),
                            _filter_department : JSON.stringify(vm.filterDepartment.filter((item)=>item.checked_b==true).map((item)=>item.id)),
                            _filter_position : JSON.stringify(vm.filterPosition.filter((item)=>item.checked_b==true).map((item)=>item.id))
                        };
                    },
                    processResults: function (data) {
                        return {
                            results: $.map(data.data, function (item) {
                                return {
                                    text: item.full_name,
                                    id: item.id,
                                    description : item.job_position_name + ' - ' + item.job_position_name + (item.department_name != null? (' - ' + item.department_name):'' ) + (item.branch_name != null? (' - ' + item.branch_name) : '')
                                }
                            })
                        };
                    }
                }
            }).on('change', function(e) {

            }).trigger('change'); 
        }

        // Initialization
        jQuery(document).ready(function() {

            //Enable tooltips
            $('[data-toggle="tooltip"]').tooltip();

            $('#select-shift').select2({
                allowClear: false,
                placeholder: "Select shift",
                templateResult: function (d) { 
                    if(d.loading == true){
                        return $(setTemplateLoad());
                    }else{
                        if(d.description != undefined){
                            return $(setTemplate(d.text, d.description));
                        }else{
                            return null;
                        }
                    }
                },
                templateSelection: function (d) { return d.text },
                ajax: {
                    url: "{{route('time.schedule.shift-list')}}",
                    headers: {
                        'Content-Type' : 'application/json',
                        'X-CSRF-Token' : $('meta[name="csrf-token"]').attr('content')
                    },
                    dataType: 'json',
                    type: "GET",
                    quietMillis: 50,
                    data: function (term) {
                        return {
                            q: term.term
                        };
                    },
                    processResults: function (data) {
                        return {
                            results: $.map(data.data, function (item) {
                                return {
                                    text: item.name,
                                    id: item.id,
                                    description : item.working_hour_start.substr(0,5) + ' - ' + item.working_hour_end.substr(0,5)
                                }
                            })
                        };
                    }
                }
            }).on('change', function() {
                
            }).trigger('change');

            initSelectAllEmployee(); 

            $('#select-all').on('change', function(e) {

                if(e.target.checked){ 
                    
                    getEmployee((data)=>{
                        $("#select-employee").empty().trigger("change");
                        
                        $("#select-employee").select2({
                            allowClear : true,
                            destroy : true,
                            data: $.map(
                                data
                                , function (item) {
                                return {
                                    text: item.full_name,
                                    id: item.id,
                                    description : item.job_position_name + ' - ' + item.job_position_name + (item.department_name != null? (' - ' + item.department_name):'' ) + (item.branch_name != null? (' - ' + item.branch_name) : '')
                                }
                            })
                        })

                        $("#select-employee > option").prop("selected", true);
                        $("#select-employee").trigger("change");

                        $('#select-employee').select2({ disabled: true });
                    });

                    $('#dropdownFilterAgenShift').addClass('disabled text-secondary');

                }else{

                    $("#select-employee").val(null).trigger("change"); 
                    initSelectAllEmployee();

                    $('#dropdownFilterAgenShift').removeClass('disabled text-secondary');

                }

            }).trigger('change');

            $("#clear").on("click", function () {
                $example.select2("destroy");
            });

            $('#select-shift2').select2({
                placeholder: "Select shift"
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
