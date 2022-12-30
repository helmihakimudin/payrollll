@extends('layout-admin.base', [
    'pages' => 'Setting Log History',
    'subpages' => 'Setting Log History',
])

@push('css')
<style>
    .disabled{
        cursor: not-allowed !important;
        pointer-events: auto !important;
        opacity: .3 !important;
    } 

    .dt-right{
        width: 1% !important;
    }

    .btn:focus, .btn.focus {
        outline: 0;
        -webkit-box-shadow: none !important;
        box-shadow: none !important;
    }

    .kt-svg-icon{
        width: 50px;
        height: 50px;
    }

    .select2 {
        width: 100% !important;
    }
</style>            
@endpush
@section('content')
    <div class="kt-portlet">
        <div class="kt-portlet__head">
            <div class="kt-portlet__head-label">
                <a href="{{ route('timeoff')}}" class="btn btn-sm border-0 btn-secondary btn-elevate mr-3 btn-icon-sm">
                    <i class="la la-arrow-left"></i>
                    Back
                </a>
                <h3 class="kt-portlet__head-title">Balance History</h3>
            </div>
            <div class="kt-portlet__head-toolbar">
                <ul class="nav nav-tabs nav-tabs-bold nav-tabs-line nav-tabs-line-right nav-tabs-line-brand" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" data-toggle="tab" href="#kt_tabs_4_1" role="tab">
                            Overview Balance
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="tab" href="#kt_tabs_4_2" role="tab">
                            Log Balance
                        </a>
                    </li>
                </ul>
            </div>
        </div>
        <div class="kt-portlet__body p-0">
            <div class="tab-content">
                <div class="tab-pane active" id="kt_tabs_4_1" role="tabpanel">
                    <div class="kt-portlet kt-portlet--mobile box-shadow-none bg-transparent m-0">
                        <div class="kt-portlet__head bg-transparent box-shadow-none kt-portlet__head--lg border-0 mt-3">
                            <div class="col p-0">
                                <div class="kt-portlet__head-label row">
                                    <div class="col-lg-3">
                                        <div class="form-group w-100 m-0">
                                            <div class='input-group' id='kt_daterangepicker_2'>
                                                <input type="text" class="form-control" readonly placeholder="Select date range" />
                                                <div class="input-group-append">
                                                    <span class="input-group-text"><i class="la la-calendar-check-o"></i></span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-3">
                                        <div class="form-group m-0 w-100">
                                            <select class="form-control kt-select2">
                                                <option>Cuti Tahunan</option>
                                                <option>Cuti Tahunan - MKT</option>
                                                <option>Overtime Leave</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-auto">
                                        <div class="dropdown">
                                            <button class="btn btn-outline-secondary dropdown-toggle" type="button"
                                                id="dropdownFilter" data-toggle="dropdown" aria-haspopup="true"
                                                aria-expanded="false">
                                                Filter
                                            </button>
                                            <div class="dropdown-menu" aria-labelledby="dropdownFilter" id="filter-employee">
                                                <div style="min-width:262px;overflow-y:scroll;padding:16px" id="main-item">
                                                    <div class="list-group">
                                                        <a href="javascript:void(0)" onclick="showSubItem('sub-item-status')" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">Status <i class="flaticon2-right-arrow"></i> </a>
                                                        <a href="javascript:void(0)" onclick="showSubItem('sub-item-branch')" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">Branch <i class="flaticon2-right-arrow"></i> </a>
                                                        <a href="javascript:void(0)" onclick="showSubItem('sub-item-department')" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">Department <i class="flaticon2-right-arrow"></i> </a>
                                                        <a href="javascript:void(0)" onclick="showSubItem('sub-item-position')" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">Position <i class="flaticon2-right-arrow"></i> </a>
                                                        <a href="javascript:void(0)" onclick="showSubItem('sub-item-level')" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">Job Level <i class="flaticon2-right-arrow"></i> </a>
                                                    </div>
                                                </div>
    
                                                <div style="min-width:262px;overflow-y:scroll;padding:16px;display:none" id="sub-item-status">
                                                    <div class="list-group" style="margin-left:-16px;margin-right:-16px">
                                                        <a href="javascript:void(0)" onclick="hideSubItem('sub-item-status')" class="list-group-item list-group-item-action list-group-item-light d-flex align-items-center">
                                                            <i class="flaticon2-left-arrow mr-3"></i> Status
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
                                                            <input class="form-check-input" type="checkbox" onclick="checkAllSubItem('chk-status', this)" id="chk-all-subitem-status" value="">
                                                            <label class="form-check-label" for="chk-all-subitem-status">ALL</label>
                                                        </div>
                                                        <div class="form-check form-check-inline mb-2">
                                                            <input class="form-check-input chk-status" type="checkbox" id="subitem-status-1">
                                                            <label class="form-check-label" for="subitem-status-1">Active</label>
                                                        </div>
                                                        <div class="form-check form-check-inline mb-2">
                                                            <input class="form-check-input chk-status" type="checkbox" id="subitem-status-2">
                                                            <label class="form-check-label" for="subitem-status-2">Resign</label>
                                                        </div>
                                                    </div>
                                                </div>
    
                                                <div style="min-width:262px;overflow-y:scroll;padding:16px;display:none" id="sub-item-branch">
                                                    <div class="list-group" style="margin-left:-16px;margin-right:-16px">
                                                        <a href="javascript:void(0)" onclick="hideSubItem('sub-item-branch')" class="list-group-item list-group-item-action list-group-item-light d-flex align-items-center">
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
                                                            <input class="form-check-input" type="checkbox" onclick="checkAllSubItem('chk-branch', this)" id="chk-all-subitem-branch" value="">
                                                            <label class="form-check-label" for="chk-all-subitem-branch">ALL</label>
                                                        </div>
                                                        <div class="form-check form-check-inline mb-2">
                                                            <input class="form-check-input chk-branch" type="checkbox" id="subitem-branch-1">
                                                            <label class="form-check-label" for="subitem-branch-1">branch 1</label>
                                                        </div>
                                                        <div class="form-check form-check-inline mb-2">
                                                            <input class="form-check-input chk-branch" type="checkbox" id="subitem-branch-2">
                                                            <label class="form-check-label" for="subitem-branch-2">branch 2</label>
                                                        </div>
                                                    </div>
                                                </div>
    
                                                <div style="min-width:262px;overflow-y:scroll;padding:16px;display:none" id="sub-item-department">
                                                    <div class="list-group" style="margin-left:-16px;margin-right:-16px">
                                                        <a href="javascript:void(0)" onclick="hideSubItem('sub-item-department')" class="list-group-item list-group-item-action list-group-item-light d-flex align-items-center">
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
                                                            <input class="form-check-input" type="checkbox" onclick="checkAllSubItem('chk-department', this)" id="chk-all-subitem-department" value="">
                                                            <label class="form-check-label" for="chk-all-subitem-department">ALL</label>
                                                        </div>
                                                        <div class="form-check form-check-inline mb-2">
                                                            <input class="form-check-input chk-department" type="checkbox" id="subitem-department-1">
                                                            <label class="form-check-label" for="subitem-department-1">department 1</label>
                                                        </div>
                                                        <div class="form-check form-check-inline mb-2">
                                                            <input class="form-check-input chk-department" type="checkbox" id="subitem-department-2">
                                                            <label class="form-check-label" for="subitem-department-2">department 2</label>
                                                        </div>
                                                    </div>
                                                </div>
    
                                                <div style="min-width:262px;overflow-y:scroll;padding:16px;display:none" id="sub-item-position">
                                                    <div class="list-group" style="margin-left:-16px;margin-right:-16px">
                                                        <a href="javascript:void(0)" onclick="hideSubItem('sub-item-position')" class="list-group-item list-group-item-action list-group-item-light d-flex align-items-center">
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
                                                            <input class="form-check-input" type="checkbox" onclick="checkAllSubItem('chk-position', this)" id="chk-all-subitem-position" value="">
                                                            <label class="form-check-label" for="chk-all-subitem-position">ALL</label>
                                                        </div>
                                                        <div class="form-check form-check-inline mb-2">
                                                            <input class="form-check-input chk-position" type="checkbox" id="subitem-position-1">
                                                            <label class="form-check-label" for="subitem-position-1">position 1</label>
                                                        </div>
                                                        <div class="form-check form-check-inline mb-2">
                                                            <input class="form-check-input chk-position" type="checkbox" id="subitem-position-2">
                                                            <label class="form-check-label" for="subitem-position-2">position 2</label>
                                                        </div>
                                                    </div>
                                                </div>
    
                                                <div style="min-width:262px;overflow-y:scroll;padding:16px;display:none" id="sub-item-level">
                                                    <div class="list-group" style="margin-left:-16px;margin-right:-16px">
                                                        <a href="javascript:void(0)" onclick="hideSubItem('sub-item-level')" class="list-group-item list-group-item-action list-group-item-light d-flex align-items-center">
                                                            <i class="flaticon2-left-arrow mr-3"></i> Job Level
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
                                                            <input class="form-check-input" type="checkbox" onclick="checkAllSubItem('chk-level', this)" id="chk-all-subitem-level" value="">
                                                            <label class="form-check-label" for="chk-all-subitem-level">ALL</label>
                                                        </div>
                                                        <div class="form-check form-check-inline mb-2">
                                                            <input class="form-check-input chk-level" type="checkbox" id="subitem-level-1">
                                                            <label class="form-check-label" for="subitem-level-1">Head</label>
                                                        </div>
                                                        <div class="form-check form-check-inline mb-2">
                                                            <input class="form-check-input chk-level" type="checkbox" id="subitem-level-2">
                                                            <label class="form-check-label" for="subitem-level-2">Staff</label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-auto">
                                        <button type="button" class="btn btn-outline-warning">Apply Filter</button>
                                    </div>
                                </div>
                            </div>
                            <div class="col-auto p-0">
                                <div class="kt-portlet__head-toolbar">
                                    <div class="kt-portlet__head-wrapper">
                                        <div class="kt-portlet__head-actions">
                                            <a href="javascript:;" data-toggle="modal" data-target="#kt_modal_4" class="btn btn-sm btn-outline-secondary btn-elevate btn-icon-sm">
                                                <i class="la la-download"></i>
                                                Export
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="kt-portlet__body pt-0">
                            <!--begin: Datatable -->
                            <table class="table table-sm table-striped- table-bordered table-hover table-checkable kt_table_11">
                                <thead>
                                    <tr>
                                        <th>Employee</th>
                                        <th>Job Position</th>
                                        <th>Branch</th>
                                        <th>Beginning balance</th>
                                        <th>Time off taken</th>
                                        <th>Adjustment</th>
                                        <th>Expired</th>
                                        <th>Carry forward</th>
                                        <th>Ending balance</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>
                                            <div>
                                                <p class="m-0">Della</p> 
                                                <div>
                                                    <small>DMY004</small>
                                                </div>
                                            </div>
                                        </td>
                                        <td>Content Creator</td>
                                        <td>Cabang Golf Lake</td>
                                        <td>0</td>
                                        <td><a href="#" class="kt-link text-danger" data-toggle="modal" data-target="#kt_modal_1">-3</a></td>
                                        <td><a href="#" class="kt-link kt-font-bold text-success" data-toggle="modal" data-target="#kt_modal_2">+6</a></td>
                                        <td><a href="#" class="kt-link kt-font-bold text-danger" data-toggle="modal" data-target="#kt_modal_3">-6</a></td>
                                        <td><a href="#" class="kt-link text-dark" data-toggle="modal" data-target="#kt_modal_4">0</a></td>
                                        <td>0</td>
                                    </tr>
                                </tbody>
                            </table>
                            <!--end: Datatable -->
                        </div>
                    </div>
                </div>
                <div class="tab-pane" id="kt_tabs_4_2" role="tabpanel">
                    <div class="kt-portlet kt-portlet--mobile box-shadow-none bg-transparent m-0">
                        <div class="kt-portlet__head bg-transparent box-shadow-none kt-portlet__head--lg border-0 mt-3">
                            <div class="col p-0">
                                <div class="kt-portlet__head-label row align-items-start">
                                    <div class="col-lg-3">
                                        <div class="form-group w-100 m-0">
                                            <div class='input-group' id='kt_daterangepicker_2'>
                                                <input type="text" class="form-control" readonly placeholder="Select date range" />
                                                <div class="input-group-append">
                                                    <span class="input-group-text"><i class="la la-calendar-check-o"></i></span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-2">
                                        <div class="form-group m-0 w-100">
                                            <select class="form-control kt-select2">
                                                <option>Cuti Tahunan</option>
                                                <option>Cuti Tahunan - MKT</option>
                                                <option>Overtime Leave</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="form-group m-0 w-100">
                                            <select class="form-control kt-select2" id="select-employee" data-tags="true" multiple="multiple" style="width:100%"></select>
                                        </div>
                                    </div>
                                    <div class="col-auto">
                                        <button type="button" class="btn btn-outline-warning">Apply Filter</button>
                                    </div>
                                </div>
                            </div>
                            <div class="col-auto p-0">
                                <div class="kt-portlet__head-toolbar">
                                    <div class="kt-portlet__head-wrapper">
                                        <div class="kt-portlet__head-actions">
                                            <a href="javascript:;" data-toggle="modal" data-target="#kt_modal_4" class="btn btn-sm btn-outline-secondary btn-elevate btn-icon-sm">
                                                <i class="la la-download"></i>
                                                Export
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="kt-portlet__body pt-0">
                            <!--begin: Datatable -->
                            <table class="table table-sm table-striped- table-bordered table-hover table-checkable kt_table_11">
                                <thead>
                                    <tr>
                                        <th>Transaction time</th>
                                        <th>Emp ID</th>
                                        <th>Employee</th>
                                        <th>Job Position</th>
                                        <th>Branch</th>
                                        <th>Policy</th>
                                        <th>Action</th>
                                        <th>Adjustment balance (days)</th>
                                        <th>Detail</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>1 Jan 2022</td>
                                        <td>BOD005</td>
                                        <td>Sintia</td>
                                        <td>Direktur</td>
                                        <td>Cabang Golf Lake</td>
                                        <td>Cuti Tahunan</td>
                                        <td>Transaction</td>
                                        <td class="text-success">+12</td>
                                        <td><a href="#" class="kt-link" data-toggle="kt-popover" title="Transaction ID: 202206002" data-html="true" data-content="Akbar Syaputra updated +12 Cuti Tahunan to Sintia on 1 Jan 2022. <br> Expired Date: 31 Dec 2022">View</a></td>
                                    </tr>
                                </tbody>
                            </table>
                            <!--end: Datatable -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Modal Time Off --}}
    <div class="modal fade" id="kt_modal_1" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Time off taken balance: Cuti Tahunan</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    </button>
                </div>
                <div class="modal-body">
                    <table class="table table-striped- table-bordered m-0 kt_table_1" >
                        <thead>
                            <tr>
                                <th>Transaction time</th>
                                <th>Action</th>
                                <th>Adjustment balance (days)</th>
                                <th>Detail</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>16 Dec 2022</td>
                                <td>Time Off Request</td>
                                <td class="text-danger">-3</td>
                                <td><a href="#" class="kt-link" data-toggle="kt-popover" data-html="true" data-content="<b>Della</b> takes 3 days of Cuti Tahunan for 12 - 14 Des 2022">View</a></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    {{-- Modal Adjustment --}}
    <div class="modal fade" id="kt_modal_2" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Adjustment balance: Cuti Tahunan</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    </button>
                </div>
                <div class="modal-body">
                    <table class="table table-striped- table-bordered m-0 kt_table_1" >
                        <thead>
                            <tr>
                                <th>Transaction time</th>
                                <th>Action</th>
                                <th>Adjustment balance (days)</th>
                                <th>Detail</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>1 Jan 2022</td>
                                <td>Transaction</td>
                                <td class="text-success">+6</td>
                                <td><a href="#" class="kt-link" data-toggle="kt-popover" title="Transaction ID: 202212005" data-html="true" data-content="Dummy updated +6 Cuti Tahunan to Della on 1 Jan 2022.<br>Expired Date: 31 Dec 2022">View</a></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    {{-- Modal Expired --}}
    <div class="modal fade" id="kt_modal_3" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Expired balance: Cuti Tahunan</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    </button>
                </div>
                <div class="modal-body">
                    <table class="table table-striped- table-bordered m-0 kt_table_1" >
                        <thead>
                            <tr>
                                <th>Transaction time</th>
                                <th>Action</th>
                                <th>Adjustment balance (days)</th>
                                <th>Detail</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>25 Dec 2022</td>
                                <td>Transaction</td>
                                <td class="text-danger">-6</td>
                                <td><a href="#" class="kt-link" data-toggle="kt-popover" title="Transaction ID: 202212006" data-html="true" data-content="Della remaining Cuti Tahunan balance is expired on 25 Dec 2022 by Dummy.">View</a></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    {{-- Modal Carry Forward --}}
    <div class="modal fade" id="kt_modal_4" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Carry forward balance: Cuti Tahunan</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    </button>
                </div>
                <div class="modal-body">
                    <table class="table table-striped- table-bordered m-0 kt_table_1" >
                        <thead>
                            <tr>
                                <th>Transaction time</th>
                                <th>Action</th>
                                <th>Adjustment balance (days)</th>
                                <th>Detail</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td colspan="4" class="text-center">
                                    <div>
                                        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1" class="kt-svg-icon mb-3">
                                            <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                <rect x="0" y="0" width="24" height="24"/>
                                                <path d="M4,4 L11.6314229,2.5691082 C11.8750185,2.52343403 12.1249815,2.52343403 12.3685771,2.5691082 L20,4 L20,13.2830094 C20,16.2173861 18.4883464,18.9447835 16,20.5 L12.5299989,22.6687507 C12.2057287,22.8714196 11.7942713,22.8714196 11.4700011,22.6687507 L8,20.5 C5.51165358,18.9447835 4,16.2173861 4,13.2830094 L4,4 Z" fill="#000000" opacity="0.1"/>
                                                <path d="M10.5857864,12 L9.17157288,10.5857864 C8.78104858,10.1952621 8.78104858,9.56209717 9.17157288,9.17157288 C9.56209717,8.78104858 10.1952621,8.78104858 10.5857864,9.17157288 L12,10.5857864 L13.4142136,9.17157288 C13.8047379,8.78104858 14.4379028,8.78104858 14.8284271,9.17157288 C15.2189514,9.56209717 15.2189514,10.1952621 14.8284271,10.5857864 L13.4142136,12 L14.8284271,13.4142136 C15.2189514,13.8047379 15.2189514,14.4379028 14.8284271,14.8284271 C14.4379028,15.2189514 13.8047379,15.2189514 13.4142136,14.8284271 L12,13.4142136 L10.5857864,14.8284271 C10.1952621,15.2189514 9.56209717,15.2189514 9.17157288,14.8284271 C8.78104858,14.4379028 8.78104858,13.8047379 9.17157288,13.4142136 L10.5857864,12 Z" fill="#000000" opacity="0.3"/>
                                            </g>
                                        </svg>
                                        <p class="m-0">No Data</p>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('scriptjs')
    <script src="{{ asset('demo10/assets/js/pages/crud/forms/widgets/bootstrap-daterangepicker.js')}}" type="text/javascript"></script>
    <script>;
        var KTDatatablesBasicBasic1 = (function () {
            var initTable1 = function () {
                var table = $(".kt_table_11");
                // begin first table
                table.DataTable({
                    responsive: true,
                    lengthMenu: [5, 10, 25, 50],
                    pageLength: 5,
                    language: {
                        lengthMenu: "Display _MENU_",
                    },
                    autoWidth: true,
                    // Order settings
                    order: [[1, "desc"]],
                });
            };
            return {
                //main function to initiate the module
                init: function () {
                    initTable1();
                },
            };
        })();
        jQuery(document).ready(function () {
            KTDatatablesBasicBasic1.init();
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

        function showSubItem(subitem){
            $('#main-item').hide(100);
            $('#'+subitem).show(100);
        }

        function hideSubItem(subitem){
            $('#main-item').show(100);
            $('#'+subitem).hide(100);
        }
        
        $('.kt-select2').select2();
        // Initialization
        jQuery(document).ready(function() {

            //Enable tooltips
            $('[data-toggle="tooltip"]').tooltip();

            var data = [
                { id: 0, title: 'Anang', description: 'DSS001-Fullstack Dev-Green lake city'},
                { id: 1, title: 'Anang', description: 'DSS001-Fullstack Dev-Green lake city'},
                { id: 2, title: 'Anang', description: 'DSS001-Fullstack Dev-Green lake city'},
                { id: 3, title: 'Anang', description: 'DSS001-Fullstack Dev-Green lake city'},
                { id: 4, title: 'Anang', description: 'DSS001-Fullstack Dev-Green lake city'},
                { id: 5, title: 'Anang', description: 'DSS001-Fullstack Dev-Green lake city'},
                { id: 6, title: 'Anang', description: 'DSS001-Fullstack Dev-Green lake city'},
                { id: 7, title: 'Anang', description: 'DSS001-Fullstack Dev-Green lake city'},
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

            $("#filter-employee").on("click", function (e) {
                e.stopPropagation();
            });
            
        });

        
    </script>
@endpush
