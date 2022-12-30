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

    .el-none, .el-none2{
        display: none;
    }

</style>            
@endpush
@section('content')
    <div class="kt-portlet">
        <div class="kt-portlet__head">
            <div class="kt-portlet__head-label">
                <h3 class="kt-portlet__head-title">Transaction Time Off Detail</h3>
            </div>
            <div class="kt-portlet__head-toolbar">
                <a href="#" class="btn btn-sm btn-outline-brand btn-elevate btn-icon-sm">
                    <i class="la la-upload"></i>
                    Import
                </a>
                <a href="#" class="btn mx-4 btn-sm btn-outline-brand btn-elevate btn-icon-sm">
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
            <form class="kt-form" action="{{route('timeoff.assign.store')}}" method="POST">
                @csrf
                <div class="row">
                    <div class="col-lg-3">
                        <div class="form-group">
                            <label for="timeoff">Time Off </label>
                            <select class="form-control" id="timeoff_id" name="timeoff_id" @error('timeoff_id') is-invalid @enderror>
                                <option value="" disabled selected>Select your option</option>
                                @foreach ($timeoff as $item)
                                     <option value="{{$item->id}}">{{$item->code}} | {{$item->name}}</option>
                                @endforeach                                
                            </select>
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <div class="form-group">
                            <label for="type">Type </label>
                            <select class="form-control" id="type" name="type" @error('type') is-invalid @enderror>
                                <option value="" disabled selected>Select your option</option>
                                <option value="assign_update">Assign or Update</option>
                                <option value="expired">Expired</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <div class="form-group">
                            <label>Description</label>
                            <input type="text" class="form-control" id="description" name="description" @error('description') is-invalid @enderror>
                        </div>
                    </div>
                    {{-- <div class="col-lg-3 el-none2">
                        <div class="form-group">
                            <label>Effective Expired Date</label>
                            <div class="input-group date">
                                <input type="text" class="form-control" readonly="" id="kt_datepicker_3" name="start_date">
                                <div class="input-group-append">
                                    <span class="input-group-text">
                                        <i class="la la-calendar"></i>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div> --}}
                    <div class="col-lg-3">
                        <div class="form-group">
                            <label>Select Employee <span class="text-danger">*</span></label>
                            <div class="float-right d-flex position-relative">
                                <a href="javascript:void(0)" onclick="selectAllEmployee()">Select ALL</a>
                            </div>
                            {{-- <select class="form-control kt-select2" id="select-employee" name="employee_id[]" data-tags="true" multiple="multiple" style="width:100%" @error('employee_id') is-invalid @enderror>
                                @foreach ($employee as $item)
                                    <option value="{{$item->id}}">{{$item->full_name}}<option>                                    
                                @endforeach
                            </select> --}}
                            <select class="form-control kt-select2" id="select-employee" name="employee_id[]" data-tags="true" multiple="multiple" style="width:100%" @error('employee_id') is-invalid @enderror>
                               
                            </select>
                        </div>
                    </div>
                    <div class="col-lg-3 el-none1">
                        <div class="form-group">
                            <label>Input balance</label>
                            <input type="number" class="form-control" maxlength="2" placeholder="1" id="input_balance" name="input_balance" @error('input_balance') is-invalid @enderror>
                        </div>
                    </div>
                    <div class="col-lg-3 el-none1">
                        <div class="form-group">
                            <label>Start Date</label>
                            <div class="input-group date">
                                <input type="text" class="form-control" readonly="" id="kt_datepicker_3" name="start_date" @error('start_date') is-invalid @enderror>
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
                                <input type="text" class="form-control" readonly="" id="kt_datepicker_3" name="end_date" @error('end_date') is-invalid @enderror>
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

var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
        $(document).ready(function(){

            $('[data-toggle="tooltip"]').tooltip();

            $( "#select-employee" ).select2({
                templateResult: function(a) {
                    var span = $("<span value="+a.id+" style='font-weight:bold'>"+a.text+"<br><small>"+a.employee_id + ' - ' + a.jp_name+"</small></span>");
                    return span;
                },
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


// $(document).ready(function() {
    
//     $("#select-emsployee").select2({
        
//         templateResult: function(idioma) {
//             var span = $("<span>"+idioma.text+"</span>");
//             return span;
//         }
//     });
// });

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












// function selectAllEmployee() {
//     $("#select-employee > option").prop("selected", true);
//     $("#select-employee").trigger("change");
// }

// function deselectAll() {
//     $("#select-employee > option").prop("selected", false);
//     $("#select-employee").trigger("change");
// }

    // var selectAll = true;
    // function checkAllSubItem(classDom, obj){
    //     console.log(obj.checked)
    //     if(obj.checked){
    //         $('.'+classDom).each(function(i, obj) {
    //             obj.checked = true;
    //         });
    //     }else{
    //         $('.'+classDom).each(function(i, obj) {
    //             obj.checked = false;
    //         });
    //     }
    // }
    // function setTemplate(title, description){
    //     return `<div class="mb-1">${title}</div><small>${description}</small>`;
    // }
    // function selectAllEmployee() {
    //     if(selectAll){
    //         $("#select-employee > option").prop("selected", true);
    //         $("#select-employee").trigger("change"); 
    //         selectAll = false;
    //     }else{
    //         $("#select-employee > option").prop("selected", false);
    //         $("#select-employee").trigger("change"); 
    //         selectAll = true;
    //     }
    // }
    

    // jQuery(document).ready(function() {

    //     //Enable tooltips
    //     $('[data-toggle="tooltip"]').tooltip();

    //     var data = [
    //         { id: 1, title: 'Anang', description: 'DSS001-Fullstack Dev-Green lake city'},
    //         { id: 1, title: 'Anang', description: 'DSS001-Fullstack Dev-Green lake city'},
    //         { id: 1, title: 'Anang', description: 'DSS001-Fullstack Dev-Green lake city'},
    //         { id: 1, title: 'Anang', description: 'DSS001-Fullstack Dev-Green lake city'},
    //         { id: 1, title: 'Anang', description: 'DSS001-Fullstack Dev-Green lake city'},
    //         { id: 1, title: 'Anang', description: 'DSS001-Fullstack Dev-Green lake city'},
    //         { id: 1, title: 'Anang', description: 'DSS001-Fullstack Dev-Green lake city'},
    //         { id: 1, title: 'Anang', description: 'DSS001-Fullstack Dev-Green lake city'},
    //     ];

        // $('#select-employee').select2({
        //     allowClear: true,
        //     placeholder: "Select an Employee",
        //     data:data,
        //     templateResult: function (d) { return $(setTemplate(d.title, d.description)); },
        //     templateSelection: function (d) { return d.title },
        // }).on('change', function() {
            
        // }).trigger('change'); 

        // $("#clear").on("click", function () {
        //     $example.select2("destroy");
        // });
    // });
</script>
@endpush
