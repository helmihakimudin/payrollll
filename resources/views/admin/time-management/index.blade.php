@extends('layout-admin.base', [
    'pages' => 'Time Management',
    'subpages' => 'Time Management',
])
@section('content')
    {{-- Body Datatables --}}
    <div class="kt-body kt-grid__item kt-grid__item--fluid kt-grid kt-grid--hor kt-grid--stretch" id="kt_body">
        <div class="kt-content  kt-grid__item kt-grid__item--fluid kt-grid kt-grid--hor" id="kt_content">
            <div class="kt-subheader   kt-grid__item mt-0" id="kt_subheader">
                <div class="kt-container bg-primary py-4">
                    <div class="d-flex justify-content-between w-100 align-items-center">
                        <h3 class="kt-subheader__title m-0 text-light">
                            Attendance
                        </h3>
                        <div class="d-flex" id="kt_subheader_search">
                            <span class="kt-subheader__desc" id="kt_subheader_total">
                                <div class="dropdown">
                                    <button class="btn btn-outline-light dropdown-toggle" type="button"
                                        id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true"
                                        aria-expanded="false">
                                        More
                                    </button>
                                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                        <a class="dropdown-item" href="{{route('attendance')}}">Setting</a>
                                        <a class="dropdown-item" href="{{route('location')}}">Location</a>
                                    </div>
                                </div>
                            </span>
                            <span><a href="" class="btn btn-outline-light rounded-fill">Activity</a></span>
                            <span><a href="" class="btn btn-light rounded-fill">Attend Report</a></span>
                        </div>
                    </div>
                </div>
            </div>
            {{-- Date --}}
            <div class="kt-subheader   kt-grid__item mt-0 px-4" id="kt_subheader">
                <div class="kt-container border py-5 my-4">
                    <div class="kt-subheader__main d-flex justify-content-between w-100 align-items-center">
                        <div>
                            <span>This shows daily data in realtime</span>
                            <h2 class="kt-subheader__title m-0">
                                Today, 10 Agustus 2022
                            </h2>
                        </div>
                        <div class="d-flex align-items-center" id="kt_subheader_search">
                            <div class="pr-5">
                                <span>Employee</span>
                                <h2 class="kt-subheader__title m-0">
                                    347
                                </h2>
                            </div>
                            <span class="kt-subheader__separator kt-subheader__separator--v"></span>
                            <div class="pr-5">
                                <span>On Time</span>
                                <h2 class="kt-subheader__title m-0 text-primary">
                                    70
                                </h2>
                            </div>
                            <span class="kt-subheader__separator kt-subheader__separator--v"></span>
                            <div class="pr-5">
                                <span>Late In</span>
                                <h2 class="kt-subheader__title m-0 text-primary">
                                    11
                                </h2>
                            </div>
                            <span class="kt-subheader__separator kt-subheader__separator--v"></span>
                            <div class="pr-5">
                                <span>Absent</span>
                                <h2 class="kt-subheader__title m-0 text-primary">
                                    255
                                </h2>
                            </div>
                            <span class="kt-subheader__separator kt-subheader__separator--v"></span>
                            <div class="pr-5">
                                <span>Time Off</span>
                                <h2 class="kt-subheader__title m-0 text-primary">
                                    0
                                </h2>
                            </div>
                            <span class="kt-subheader__separator kt-subheader__separator--v"></span>
                            <div class="pr-5">
                                <span>Day Off</span>
                                <h2 class="kt-subheader__title m-0 text-primary">
                                    6
                                </h2>
                            </div>
                            <span class="kt-subheader__separator kt-subheader__separator--v"></span>
                            <div class="pr-5">
                                <span>No Check In</span>
                                <h2 class="kt-subheader__title m-0 text-primary">
                                    5
                                </h2>
                            </div>
                            <span class="kt-subheader__separator kt-subheader__separator--v"></span>
                            <div class="pr-5">
                                <a href="http://" class="font-weight-bold">See All ></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            {{-- Table --}}
            <div class="kt-container  kt-grid__item kt-grid__item--fluid">
                <div class="row">
                    <div class="col-lg-12">
                        <table
                            class="table kt-datatable__tabletable-checkable dataTable no-footer dtr-inline karyawan-table"
                            style="font-size:11px;" id="attend-table">
                            <thead>
                                <tr role="row">
                                    <th>Employee Name</th>
                                    <th>Emp ID</th>
                                    <th>Date</th>
                                    <th>Schedule in</th>
                                    <th>Schedule out</th>
                                    <th>Clock in</th>
                                    <th>Clock out</th>
                                    <th>Attendance Code</th>
                                    <th>Time Off Code</th>
                                    <th>Overtime</th>
                                    <th>Action</th>
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
@endsection
@push('scriptjs')
    <script>
        $('#attend-table').DataTable({
            drawCallback: function() {
                $(".dataTables_paginate > .pagination").addClass("pagination-rounded")
            },
            scrollX: true,
            bStateSave: true,
            select: true,
            serverSide: true,
            processing: true,
            paging: true,
            ajax: {
                url: '{{ route("attend.ajax") }}',
                type: 'post',
                data: {
                    "_token": "{{ csrf_token() }}"
                },
            },
            columns: [{
                    data: 'fullname'
                },
                {
                    data: 'employee_id'
                },
                {
                    data: 'date'
                },
                {
                    data: 'schedule_in'
                },
                {
                    data: 'schedule_out'
                },
                {
                    data: 'clock_in'
                },
                {
                    data: 'clock_out'
                },
                {
                    data: 'attendance_code'
                },
                {
                    data: 'time_off_code'
                },
                {
                    data: 'overtime'
                },
                {
                    data: 'actions'
                },
            ],
        });
    </script>
@endpush
