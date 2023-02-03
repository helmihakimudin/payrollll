@extends('layout-admin.base',[
	'pages'=>'employee',
	'subpages'=>'employee'
])

@push('css')
	<style>
		.select2-container {
        display: block;
    }

    th, td {
        white-space: nowrap;
        text-align: left;
    }
    .dataTables_scrollBody{overflow-y: scroll !important; }
	</style>
@endpush
@section('content')
<div class="card mb-3">
  <div class="card-body">
    <form id="employee_filter" method="post">
      @csrf
      <div class="form-group d-flex flex-lg-nowrap flex-wrap mb-0">
          <div class="col">
              <label for="">Organization</label>
              <select name="organization_id" class="form-control select" id="organization_id">
                  <option value="" selected>Select Organization</option>
                  @foreach(DB::table("organization")->get() as $row)
                  <option value="{{$row->id}}" >{{$row->name}}</option>
                  @endforeach
              </select>
          </div>
          <div class="col">
              <label for="">Branch</label>
              <select name="branch_id" class="form-control select" id="branch_id">
                  <option value="" selected>Select Branch</option>
                  @foreach(DB::table("branches")->get() as $row)
                  <option value="{{$row->id}}" >{{$row->name}}</option>
                  @endforeach
              </select>
          </div>
          <div class="col">
              <label for="">Job Position</label>
              <select name="job_position_id" class="form-control select" id="job_position_id">
                  <option value="" selected>Select Job Position</option>
                  @foreach(DB::table("job_position")->get() as $row)
                  <option value="{{$row->id}}" >{{$row->name}}</option>
                  @endforeach
              </select>
          </div>
          <div class="col">
              <label for="">Job level</label>
              <select name="job_level_id" class="form-control select" id="job_level_id">
                  <option value="" selected>Select Job Level</option>
                  @foreach(DB::table("job_level")->get() as $row)
                  <option value="{{$row->id}}" >{{$row->name}}</option>
                  @endforeach
              </select>
          </div>
          <div class="col-auto align-self-end">
              <button type="submit" class="px-5 btn btn-outline-warning rounded-fill"><i class="la la-filter"></i>Filter</button>
          </div>
      </div>
    </form>
  </div>
</div>

<div class="kt-body kt-grid__item kt-grid__item--fluid kt-grid kt-grid--hor kt-grid--stretch" id="kt_body">
    <div class="kt-content  kt-grid__item kt-grid__item--fluid kt-grid kt-grid--hor" id="kt_content">
        <div class="kt-subheader  kt-grid__item" id="kt_subheader">
            <div class="kt-container pt-3">
                <div class="kt-subheader__main">
                    <h3 class="kt-subheader__title">
                        Employee List
                    </h3>
                    <span class="kt-subheader__separator kt-subheader__separator--v"></span>
                    <div class="kt-subheader__group" id="kt_subheader_search">
                        <span class="kt-subheader__desc" id="kt_subheader_total">
                            <a href="{{route('employee.create')}}" class="btn btn-sm btn-primary rounded-fill">Add Employee</a>
                            <a href="{{route('employee.export')}}" class="btn btn-secondary btn-elevate btn-sm "></i>Export</a>
                            <a href="#" class="btn btn-secondary btn-elevate btn-sm" data-toggle="modal" data-target="#kt_modal_1"></i>Import</a>
                        </span>
                    </div>
                </div>
            </div>
        </div>
        <div class="kt-container  kt-grid__item kt-grid__item--fluid">
            <div class="row">
                <div class="col-lg-12">
                    <table class="table table-striped-  table-hover table-checkable dataTable no-footer dtr-inline" id="karyawan-table" >
                        <thead class="bg-secondary">
                            <tr>
                                <th>Full name</th>
                                <th>Employee ID</th>
                                <th>Branch</th>
                                <th>Job Position</th>
                                <th>Job Level</th>
                                <th>Employement Status</th>
                                <th>Join Date</th>
                                <th>End Date</th>
                                <th>Email</th>
                                <th>Birth Date</th>
                                <th>Birth Place</th>
                                <th>Citiztion ID Address</th>
                                <th>Residential Address</th>
                                <th>Aksi</th>
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
</div>

<!-- Modal Import -->
<div class="modal fade" id="kt_modal_1" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-md" role="document">
    <div class="modal-content">
      <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel">Import</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              </button>
      </div>
      <div class="modal-body">
          <p>Download template below and write your data.</p>
          <p class="mb-0 mt-3 kt-font-bold">Few tips:</p>
          <ul>
              <li>Make sure employee ID is correct</li>
              <li>Click column header on spreadsheet to read instruction</li>
          </ul>
          <form action="{{route('employee.import')}}" id="employee-import">
              <div class="form-group m-0">
                  <label for="importExportTemplate" class="form-group-label">Upload spreadsheet</label>
                  <div class="custom-file">
                      <input id="importExportTemplate" type="file" accept=".xls,.xlsx" class="custom-file-input">
                      <label for="importExportTemplate" class="custom-file-label is-ellipsis">No file selected</label>
                  </div>
              </div>
          </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-success" form="employee-import">Submit</button>
      </div>
    </div>
  </div>
</div>
@endsection
@push('scriptjs')
<script>
$(document).ready(function(){
    var datatable1 = $("#karyawan-table").DataTable({
        drawCallback:function(){$(".dataTables_paginate > .pagination").addClass("pagination-rounded")},
        scrollX: true,
        bStateSave: true,
        select:true,
        serverSide:true,
        processing: true,
        paging:true,
        ajax:{
            url:'{{ route('employee.ajax') }}',
            type:'post',
            data:{"_token": "{{ csrf_token() }}"},
        },
        columns:[
            { data:'fullname'},
            { data:'employee_id'},
            { data:'branch'},
            { data:'job_position'},
            { data:'job_level'},
            { data:'employeement_status'},
            { data:'join_date'},
            { data:'end_date'},
            { data:'email'},
            { data:'date_of_birth'},
            { data:'place_of_birth'},
            { data:'residential_address'},
            { data:'citizien_id_address'},
            { data:'actions'},
        ],
    });


    $('#employee_filter').on('submit',function(e){
        e.preventDefault();
        $('#karyawan-table').DataTable().clear();
        $('#karyawan-table').DataTable().destroy();
        let organization = $('#organization_id').val();
        let branch = $('#branch_id').val();
        let jobPosition = $('#job_position_id').val();
        let jobLevel = $('#job_level_id').val();

        filterByEmployee(organization, branch, jobPosition,jobLevel);
    });

    function filterByEmployee(organization, branch, jobPosition,jobLevel) {
        $("#karyawan-table").DataTable({
        drawCallback:function(){$(".dataTables_paginate > .pagination").addClass("pagination-rounded")},
        scrollX: true,
        bStateSave: true,
        select:true,
        serverSide:true,
        processing: true,
        paging:true,
        ajax:{
            url:'{{ route('employee.ajax') }}',
            type:'post',
            data:{"_token": "{{ csrf_token() }}",
                    'organization': organization,
                    'branch': branch,
                    'job_position': jobPosition,
                    'job_level':jobLevel,
                },

        },
        columns:[
            { data:'fullname'},
            { data:'employee_id'},
            { data:'branch'},
            { data:'job_position'},
            { data:'job_level'},
            { data:'employeement_status'},
            { data:'join_date'},
            { data:'end_date'},
            { data:'email'},
            { data:'date_of_birth'},
            { data:'place_of_birth'},
            { data:'residential_address'},
            { data:'citizien_id_address'},
            { data:'actions'},
        ],
    });
    }
});
</script>
@endpush
