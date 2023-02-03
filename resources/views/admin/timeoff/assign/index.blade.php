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
    #success-title {
        visibility: hidden;
    }
</style>            
@endpush
@section('content')
    <div class="kt-portlet">
        <div class="kt-portlet__head">
            <div class="kt-portlet__head-label">
                <h3 class="kt-portlet__head-title">Transaction Time Off</h3>
            </div>
            <div class="kt-portlet__head-toolbar">
                <a href="{{ route('timeoff')}}" class="btn btn-sm btn-secondary btn-elevate mx-4 btn-icon-sm">
                    <i class="la la-arrow-left"></i>
                    Back
                </a>
                <a href="#" class="btn btn-sm btn-outline-brand btn-elevate btn-icon-sm">
                    <i class="la la-download"></i>
                    Import
                </a>
                <a href="#" class="btn mx-4 btn-sm btn-outline-brand btn-elevate btn-icon-sm">
                    <i class="la la-upload"></i>
                    Export
                </a>
                <a href="{{ route('timeoff.assign.create')}}" class="btn btn-sm btn-brand btn-elevate btn-icon-sm">
                    <i class="la la-plus"></i>
                    Create
                </a>
            </div>
        </div>
        <div class="kt-portlet__body">
            <div class="row">
                <div class="col-lg-12">
                    <!--begin: Datatable -->
                    <table class="table table-striped- table-bordered table-hover table-checkable kt_table_1 mt-0" id="timeoffassignTable">
                        <thead>
                            <tr>
                                <th>Time Off Type</th>
                                <th>Type</th>
                                <th>Transaction ID</th>
                                <th>Description</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr >                                
                                <td colspan="5">Loading Data..</td>
                            </tr>
                        </tbody>
                    </table>
                    <!--end: Datatable -->
                </div>
            </div>
        </div>
    </div>

    <!--begin::Modal Delete -->
    <div class="modal fade" id="kt_modal_1" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Warning !</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    </button>
                </div>
                <div class="modal-body">
                    <p class="text">Are you sure want to delete?</p>
                </div>
                <div class="modal-footer">
                    <form method="post" multiple="multiple">
                        @csrf
                        @method('delete')
                        
                        <button type="button" class="btn btn-secondary " data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-danger deleteRecord">Delete</button>
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

        $(document).on('click', '#btn-delete', function(){
            // console.log("masuk");
            var url = '{{ route("timeoff.assign.delete", ":id") }}';
            url = url.replace(':id', $(this).data('transaction_id'));
            $('#kt_modal_1 form').attr('action', url);        
            $('#kt_modal_1 #id').val($(this).data('transaction_id'));

            $('#kt_modal_1').modal('toggle');
        });

        $(".deleteRecord").click(function(){
            var transaction_id = $(this).data("transaction_id");
            console.log(transaction_id);
            var token = $("meta[name='csrf-token']").attr("content");
        
            $.ajax(
            {
                url: "timeoff/assign/"+transaction_id,
                type: 'DELETE',
                data: {
                    "id": transaction_id,
                    "_token": token,
                },
                success: function (){
                    console.log("it Works");
                }
            });
        
        });

        function igniteTable() {
            var table = $("#timeoffassignTable");
            // begin first table
            table.DataTable({
                drawCallback:function(){$(".dataTables_paginate > .pagination").addClass("pagination-rounded")},
                scrollX: true,
                bStateSave: true,
                selectedRows: true,
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
                    url: "{{ route('timeoff.assign.ajax') }}",
                    type: "POST",
                    data: {
                        "_token": "{{ csrf_token() }}",
                    }
                },
                columns: [
                    
                    {
                        data: 'timeoff_type'
                    },
                    {
                        data: 'type'
                    },
                    {
                        data: 'transaction_id'
                    },
                    {
                        data: 'description'
                    },
                    {
                        data: 'action'
                    }
                ],
            });
        };

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

        $(document).on('click', '#btn-edit', function(){

        });
        
        // var initTable1 = function () {
        //     var table = $(".kt_table_1");
        //     // begin first table
        //     table.DataTable({
        //         responsive: true,
        //         lengthMenu: [10, 25, 50],
        //         pageLength: 10,
        //         language: {
        //             lengthMenu: "Display _MENU_",
        //         },
        //         // Order settings
        //         order: [[1, "asc"]],
        //     });
        // }();
    </script>
@endpush
