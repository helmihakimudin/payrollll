@extends('layout-admin.base', [
    'pages' => 'Setting Attemdance',
    'subpages' => 'Setting Attemdance',
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

    .table th, .table td {
        vertical-align: middle;
    }

    .select2-container {
        display: block;
    }
</style>            
@endpush
@section('content')

    <div class="kt-portlet">
        <div class="kt-portlet__head">
            <div class="kt-portlet__head-label">
                <h3 class="kt-portlet__head-title">Settings Time Off</h3>
            </div>
            <div class="kt-portlet__head-toolbar">
                <a href="{{ route('timeoff.create')}}" class="btn btn-sm btn-brand btn-elevate btn-icon-sm">
                    <i class="la la-plus"></i>
                    Create Time Off
                </a>
                <a href="{{route('timeoff.setting')}}" class="btn btn-sm btn-secondary btn-elevate mx-3 btn-icon-sm">
                    <i class="la la-info-circle"></i>
                    View Setting
                </a>
                <a href="{{ route('location.create')}}" class="btn btn-sm btn-secondary btn-elevate btn-icon-sm" data-toggle="modal" data-target="#kt_modal_1">
                    <i class="la la-lightbulb-o"></i>
                    Time Off Simulation
                </a>
            </div>
        </div>
        
        <div class="kt-portlet__body">
            <div class="row">
                <div class="col-lg-3">
                    <div class="kt-portlet kt-callout kt-callout--success kt-callout--diagonal-bg">
                        <div class="kt-portlet__body p-0">
                            <div class="kt-callout__body">
                                <div class="kt-callout__content">
                                    <h5 class="mb-3">ASSIGN OR UPDATE TIME OFF</h5>
                                    <p class="kt-callout__desc">
                                        <a href="{{ route('timeoff.assign') }}" class="btn btn-outline-dark btn-sm" id="ExportAssignEmployee">Assign or Update</a>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="kt-portlet kt-callout kt-callout--success kt-callout--diagonal-bg">
                        <div class="kt-portlet__body p-0">
                            <div class="kt-callout__body">
                                <div class="kt-callout__content">
                                    <h5 class="mb-3">UPDATE TIME OFF BALANCE VIA EXCEL</h5>
                                    <p class="kt-callout__desc">
                                        <div class="d-flex my-3">
                                            <a href="{{ route('exportTimeoffassign') }}" target="_blank" class="btn btn-outline-dark btn-sm" id="ExportAssignEmployee">Export Template</a>
                                            {{-- <a href="{{ asset('public\download\format-employee.xlsx')}}" target="_blank" class="btn btn-outline-dark btn-sm" id="ExportAssignEmployee">Export Template</a> --}}
                                            <div class="dropzone-panel">
                                                <a href="javascript:void(0);" class="dropzone-select px-5 btn ml-3 btn btn-outline-dark btn-sm" >Import</a>
                                            </div>
                                        </div>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-9">
                    <!--begin: Datatable -->
                    <table class="table table-striped- table-bordered table-hover table-checkable kt_table_1 mt-0" id="timeoffIndexTable">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Code</th>
                                <th>Effective Date</th>
                                <th>Expired Date</th>
                                <th>Log</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>Loading..</td>
                                {{-- <td>Cuti Tahunan</td>
                                <td>
                                    <span class="btn btn-bold btn-sm btn-font-sm btn-label-brand">CT</span>
                                </td>
                                <td>2021-01-01</td>
                                <td>-</td>
                                <td>
                                    <a href="{{route('timeoff.log')}}" class="kt-link kt-font-bold">Log History</a>
                                </td>
                                <td>
                                    <button data-toggle="modal" data-target="#kt_modal_2" class="btn btn-sm btn-clean btn-icon btn-icon-md" title="Delete">
                                        <i class="la flaticon-cancel text-danger"></i>
                                    </button>
                                </td> --}}
                            </tr>
                        </tbody>
                    </table>
                    <!--end: Datatable -->
                </div>
            </div>
        </div>
    </div>

    {{-- Time Off Simulation --}}
    <div class="modal fade" id="kt_modal_1" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Time Off Simulation</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    </button>
                </div>
                <form action="">
                    <div class="modal-body">
                        <div class="form-group row">
                            <div class="col-lg-6">
                                <label for="kt_select2_1">Time Off</label>
                                <select class="form-control kt-select2" id="select_timeoff" name="timeoff">
                                    <option selected disabled>Select Time Off</option>
                                    @foreach ($timeoff as $item)
                                         <option value="{{$item->id}}">{{$item->code}} - {{$item->name}}</option>                                  
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-lg-6">
                                <label>Current Date</label>
                                <div class="input-group date">
                                    <input type="text" class="form-control datepicker" readonly="" id="current_date" id="kt_datepicker_3">
                                    <div class="input-group-append">
                                        <span class="input-group-text">
                                            <i class="la la-calendar"></i>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="form-group row align-items-center">
                            <div class="col-lg-6">
                                <div style="" class="join" hidden>
                                    <label>Join Date</label>
                                    <div class="input-group date col-lg-6">
                                        <input type="text" class="form-control" readonly="" id="jd">
                                        <div class="input-group-append">
                                            <span class="input-group-text">
                                                <i class="la la-calendar"></i>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="kt-radio-inline">
                                    <label class="kt-radio kt-radio--bold kt-radio--success">
                                        <input type="radio" value="0" name="radio2" checked> Employee
                                        <span></span>
                                    </label>
                                    <label class="kt-radio kt-radio--bold kt-radio--success">
                                        <input type="radio" value="1" name="radio2"> Join Date
                                        <span></span>
                                    </label>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="emp">
                                    <label for="kt_select2_2">Employee</label>
                                    <select class="form-control kt-select2" style="width:100%" id="select-employee" name="employee" placeholder="select employee">  
                                    </select>
                                </div>
                                <div style="display:none" class="join">
                                    <label>Join Date</label>
                                    <div class="input-group date">
                                        <input type="text" class="form-control datepicker" readonly="" id="kt_datepicker_3">
                                        <div class="input-group-append">
                                            <span class="input-group-text">
                                                <i class="la la-calendar"></i>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        

                        <div class="simulate-wrap" id="display-text" style="display: none">
                            <div class="text-center bg-secondary p-2 my-3">
                                <p class="m-0" >Active balance for <b id="namaEmp">{Employee Name}</b> in <b id="currentDate">{Current Date}</b> is <b id="diffyear">{0}</b> days</p>
                            </div>
                            <table class="table table-striped- table-bordered m-0 kt_table_1" id="tbsimulate" style="display: none">
                                <thead>
                                    <tr>
                                        <th>Effective Date</th>
                                        <th>Expired Date</th>
                                        <th>Balance</th>
                                    </tr>
                                </thead>
                                <tbody >
                                    
                                </tbody>
                            </table>
                        </div>
                            
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary " data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary btn-simulate" id="btn-simulate">Simulate</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!--begin::Modal Edit -->
    <div class="modal fade" id="modalEditTimeOff" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Edit Data</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    </button>
                </div>
                <div class="modal-body">
                    <form class="kt-form" id="form-update" method="POST">
                        @csrf
                        @method('put')
                        <div class="row">
                            <input type="text" id="id" name="id" class="form-control hidden">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label>Name Time Off</label>
                                    <input type="text" id="name" name="name" class="form-control">
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label>Code Time Off</label>
                                    <input type="text" id="code" name="code" class="form-control">
                                </div>
                            </div>
                           
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label>Effective as off</label>
                                    <div class="input-group date">
                                        <input type="text" id="effective_date" name="effective_date" class="form-control datepicker" readonly="" id="kt_datepicker_3">
                                        <div class="input-group-append">
                                            <span class="input-group-text">
                                                <i class="la la-calendar"></i>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label>Expired Date</label>
                                    <div class="input-group date">
                                        <input type="text" id="expired_date" name="expired_date" class="form-control datepicker" readonly="" id="kt_datepicker_3">
                                        <div class="input-group-append">
                                            <span class="input-group-text">
                                                <i class="la la-calendar"></i>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label>Description Time Off <small>(optional)</small></label>
                                    <input type="text" id="description" name="description" class="form-control">
                                </div>
                            </div>
                                                       
                            <div class="col-lg-12 text-right">
                                <hr>
                                <div class="kt-form__actions">
                                    <button type="submit" id="btnUpdate" class="btn btn-success">Update</button>
                                    <button type="button" class="btn btn-secondary" id="btn-cancel">Cancel</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('scriptjs')
<script src="{{ asset('demo10/assets/js/pages/crud/forms/widgets/bootstrap-datepicker.js')}}" type="text/javascript"></script>
    <script>

        $(document).ready(function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            igniteTable();
            
        });



        var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
        $(document).ready(function(){

            // $('[data-toggle="tooltip"]').tooltip();

            $( "#select-employee" ).select2({
                templateResult: function(a) {
                    var span = $("<span id='#employ' data-jd="+a.join_date+" style='font-weight:bold'>"+a.text+"<br><small>"+a.employee_id + ' - ' + a.jp_name+"</small></span>");
                    return span;
                },
                placeholder: "Select Employee",
                ajax: { 
                url: "{{route('getEmployees')}}",
                type: "post",
                dataType: 'json',
                delay: 250,
                
                data: function (params) {
                    return {
                    id: params.id,
                    _token: CSRF_TOKEN,
                    search: params.term // search term
                    };
                },
                processResults: function (response) {
                    return {
                    results: response
                    };
                },
                cache: true
                }

            });

        });

        function formatDate(date) {
            var d = new Date(date),
                month = '' + (d.getMonth() + 1),
                day = '' + d.getDate(),
                year = d.getFullYear();

            if (month.length < 2) month = '0' + month;
            if (day.length < 2) day = '0' + day;

            return [month, day, year].join('/');
            }

        
            function formatDateCalculate(date) {
            var d = new Date(date),
                month = '' + (d.getMonth() + 1),
                day = '' + d.getDate(),
                year = d.getFullYear();

            if (month.length < 2) month = '0' + month;
            if (day.length < 2) day = '0' + day;

            return [year, month, day].join('-');
            }

            function formatDateCalculateModal(date) {
            var d = new Date(date),
                month = '' + (d.getMonth() + 1),
                day = '' + d.getDate(),
                year = d.getFullYear();

            if (month.length < 2) month = '0' + month;
            if (day.length < 2) day = '0' + day;

            return [day, month, year].join('-');
            }

            function formatDayMonth(date) {
            var d = new Date(date),
                month = '' + (d.getMonth() + 1),
                day = '' + d.getDate();

            if (month.length < 2) month = '0' + month;
            if (day.length < 2) day = '0' + day;

            return [day, month].join('-');
            }

            function formatYear(date) {
            var d = new Date(date),          
                year = d.getFullYear();
            return [year];
            }


            

        $('#current_date').val(formatDate(new Date()));

        $(document).ready(function() {
            $('#select-employee').on('change', function() {
               var empId = $(this).val();
               if(empId) {
                   $.ajax({
                       url: '/timeoff/simulation/'+empId,
                       type: "GET",
                       data : {"_token":"{{ csrf_token() }}"},
                       dataType: "json",
                       success:function(data)
                       {
                         if(data){
                            let value = JSON.parse(JSON.stringify(data));
                            // console.log(value);
                            // var namaEmp = $('#select-employee').text();
                            var currentDate2 = $('#current_date').val();
                            var currentDate = formatDateCalculateModal(currentDate2);
                            
                            $('#jd').empty();
                            $('#jd').val(formatDate(value.join_date));
                            
                            
                            $('#currentDate').text(currentDate);

                            console.log('masuk');
                           
                        }else{
                            $('#jd').empty();
                            console.log('kosong1');
                        }
                     }
                   });
               }else{
                 $('#jd').empty();
                 console.log('kosong2');
               }
            });
        });

        $('#current_date').on('change', function() {
            var currentDate2 = $('#current_date').val();
            var currentDate = formatDateCalculateModal(currentDate2);

            $('#currentDate').text(currentDate);
        });

        var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
        $(document).ready(function() {
            $('#btn-simulate').on('click', function() {
               var ct = $('#select_timeoff').val();
               var jd = $('#jd').val();
               var cd = $('#current_date').val();
               var cd2 = formatDateCalculate(cd);
               var jd2 = formatDateCalculate(jd);
               $("#tbsimulate").show();
               
               console.log(jd+' '+cd+' '+cd2+' '+jd2);
               if(ct && jd) {
                
                // if ($('#namaEmp').text()) {
                //     $('#namaEmp').val('');
                //     $('#namaEmp').text($('#select-employee selected').text());
                // } else {
                //     $('#namaEmp').val('');
                //     $('#namaEmp').text($('#select-employee selected').text());
                // }
                $('#namaEmp').text($('#select-employee option:selected').text());
                var diffYear = new Date(new Date(Date.parse(cd2)) - new Date(Date.parse(jd2))).getFullYear() - 1970;
                var cutiTahunan = diffYear*12;
                $('#diffyear').text(cutiTahunan);
                $("#display-text").show(); 

                
               }else{
                 $('#jd').empty();
                 console.log('kosong2');
                 $("#display-text").hide(); 

               }

               var yearSimulate = formatYear(jd);
               var dayMonthSimulate = formatDayMonth(jd);
               var toYear = parseInt(yearSimulate) + 1;
               $("#tbsimulate").html('');
                for(i=1; i<diffYear; i++)
                    {
                        $("#tbsimulate").append("<tr><td>"+ yearSimulate++ +"-"+ dayMonthSimulate +"</td><td>"+ toYear++ +"-"+ dayMonthSimulate +"</td><td>12</td></tr>");   
                    } 
                });
                      
            });
        


        $(document).on('click', '#btn-edit', function(){
            // console.log("masuk");
            var url = '{{ route("timeoff.update", ":id") }}';
            url = url.replace(':id', $(this).data('id'));
            $('#modalEdit form').attr('action', url);
           
            $('#modalEditTimeOff #id').val($(this).data('id'));
            $('#modalEditTimeOff #name').val($(this).data('name'));
            $('#modalEditTimeOff #code').val($(this).data('code'));
            $('#modalEditTimeOff #description').val($(this).data('description'));
            $('#modalEditTimeOff #effective_date').val($(this).data('effective_date'));
            if ($(this).data('expired_date') == '2000-01-01') {
                $('#modalEditTimeOff #expired_date').val('');

            } else {
                $('#modalEditTimeOff #expired_date').val($(this).data('expired_date'));
            }

            $('#modalEditTimeOff').modal('toggle');
        });

        $(document).on("click", "#btnUpdate", function(e) {
            e.preventDefault(); 
            e.stopPropagation(); 
            var dataForms = new FormData($('#form-update')[0]); 
            let id = $('#id').val();
           
            $.ajax({
                url: `/timeoff/edit/${id}`,
                type: "post",
                data: dataForms,
                dataType: "json",
                processData: false,
                contentType: false,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(data) {
                    $("#modalEditTimeOff").modal('hide');
                    alert('Success');
                    $('#timeoffIndexTable').DataTable().draw();
                },
                error: function(data, xhr) {
                    alert('Oops!')
                }
            });
        });


        $(document).on("click", "#btn-cancel", function(){
            $("#modalEditTimeOff").modal('hide');
        });

        const el = document.querySelector('.kt-radio-inline')
        const join = document.querySelector('.join')
        const emp = document.querySelector('.emp')
        el.addEventListener('change', function handle(event){
            if (event.target.value == 1) {
                join.style.display = 'block';
                emp.style.display = 'none';
            } else {
                join.style.display = 'none';
                emp.style.display = 'block';
            }
        })

        function igniteTable() {
            var table = $("#timeoffIndexTable");
            // begin first table
            table.DataTable({
                drawCallback:function(){$(".dataTables_paginate > .pagination").addClass("pagination-rounded")},
                scrollX: true,
                bStateSave: true,
                selectedRow: true,
                serverSide:true,
                processing: true,
                paging:true,
                serverSide: true,
                language: {
					lengthMenu: "Display _MENU_",
				},
                
                // Order settings
                order: [[1, "asc"]],
                ajax: {
                    url: "{{ route('timeoff.ajax') }}",
                    type: "POST",
                    data: {
                        "_token": "{{ csrf_token() }}",
                    }
                },
                columns: [{
                        data: 'name'
                    },
                    {
                        data: 'code'
                    },
                    {
                        data: 'effective_date'
                    },
                    {
                        data: 'expired_date'
                    },
                    {
                        data: 'log'
                    },
                    {
                        data: 'action'
                    }
                ],
            });
        };

       

        $('.kt-select2').select2({
            placeholder: "Select on option",
        });

        // $('.btn-simulate').click(function() {
        //     $('.simulate-wrap').toggleClass("d-none");
        // });
        
        // var demo2 = function () {
        //     // set the dropzone container id
        //     var id = '.kt_dropzone_5';
        //     // set the preview element template
        //     var previewNode = $(id + " .dropzone-item");
        //     previewNode.id = "";
        //     var previewTemplate = previewNode.parent('.dropzone-items').html();
        //     previewNode.remove();
        //     var myDropzone5 = new Dropzone(id, { // Make the whole body a dropzone
        //         url: "https://keenthemes.com/scripts/void.php", // Set the url for your upload script location
        //         parallelUploads: 20,
        //         maxFilesize: 1, // Max filesize in MB
        //         previewTemplate: previewTemplate,
        //         previewsContainer: id + " .dropzone-items", // Define the container to display the previews
        //         clickable: id + " .dropzone-select" // Define the element that should be used as click trigger to select files.
        //     });
        //     myDropzone5.on("addedfile", function(file) {
        //         // Hookup the start button
        //         $(document).find( id + ' .dropzone-item').css('display', '');
        //     });
        //     // Update the total progress bar
        //     myDropzone5.on("totaluploadprogress", function(progress) {
        //         $( id + " .progress-bar").css('width', progress + "%");
        //     });
        //     myDropzone5.on("sending", function(file) {
        //         // Show the total progress bar when upload starts
        //         $( id + " .progress-bar").css('opacity', "1");
        //     });
        //     // Hide the total progress bar when nothing's uploading anymore
        //     myDropzone5.on("complete", function(progress) {
        //         var thisProgressBar = id + " .dz-complete";
        //         setTimeout(function(){
        //             $( thisProgressBar + " .progress-bar, " + thisProgressBar + " .progress").css('opacity', '0');
        //         }, 300)
        //     });
        // }()

        
    </script>
@endpush
