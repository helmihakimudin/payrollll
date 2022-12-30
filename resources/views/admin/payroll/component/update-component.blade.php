@extends('layout-admin.base',[
	'pages'=>'payroll',
	'subpages'=>'component'
])
@section('content')
@include('admin.payroll.settings.modal')
<div class="kt-body kt-grid__item kt-grid__item--fluid kt-grid kt-grid--hor kt-grid--stretch" id="kt_body">
    <div class="kt-content  kt-grid__item kt-grid__item--fluid kt-grid kt-grid--hor" id="kt_content">
        <div class="kt-subheader   kt-grid__item" id="kt_subheader">
            <div class="kt-container pt-3">
                <div class="kt-subheader__main">
                    <h1 class="kt-subheader__title">
                         payroll E- Smart
                    </h1>
                    <span class="kt-subheader__separator kt-subheader__separator--v"></span>
                    <div class="kt-subheader__group" id="kt_subheader_search">
                        <h3 class="kt-subheader__desc">
                          PT DUAISI SEJAHTERA
                        </h3>
                    </div>
                    <span class="kt-subheader__separator kt-subheader__separator--v"></span>
                    <div class="kt-subheader__group" id="kt_subheader_search">
                        <h3 class="kt-subheader__desc">
                            <a href="{{route('payroll.component')}}" class="kt-nav__link">Component</a>
                        </h3>
                    </div>
                    <span class="kt-subheader__separator kt-subheader__separator--v"></span>
                    <div class="kt-subheader__group" id="kt_subheader_search">
                        <h3 class="kt-subheader__desc">
                          Update Component 
                        </h3>
                    </div>
                </div>
                <div class="kt-subheader__toolbar">
                    
                </div>
            </div>
        </div>
        <div class="kt-container  kt-grid__item kt-grid__item--fluid pt-5">
            <div class="kt-portlet">
                <div class="kt-portlet__head">
                    <div class="kt-portlet__head-label">
                        <span class="kt-portlet__head-icon kt-hide">
                            <i class="la la-gear"></i>
                        </span>
                        <h3 class="kt-portlet__head-title">
                           Update Component
                        </h3>
                    </div>
                </div>
                <div class="kt-portlet__body">
                    <div class="row">
                        <div class="col-lg-3">
                            <div class="form-group">
                                <div class="input-group">
                                    <span><i class="flaticon-file"></i></span> <b class="ml-2"> Set Information</b>
                                </div>
                            </div>
                            <form action="{{route("payroll.component.store")}}" method="POST" id="form-payrollc-component">
                                @csrf
                                <div class="form-group">
                                    <div class="form-group form-group-marginless">
                                        <label>Choose Type</label>
                                      
                                        <div class="row">
                                            <div class="col-lg-6">
                                                <label class="kt-option">
                                                    <span class="kt-option__control">
                                                        <span class="kt-radio">
                                                            <input type="radio" name="type_adjustment" value="Adjustment">
                                                            <span></span>
                                                        </span>
                                                    </span>
                                                    <span class="kt-option__label">
                                                        <span class="kt-option__head">
                                                            <span class="kt-option__title">
                                                                Adjustment
                                                            </span>
                                                        </span>
                                                    </span>
                                                </label>
                                            </div>
                                            <div class="col-lg-6">
                                                <label class="kt-option">
                                                    <span class="kt-option__control">
                                                        <span class="kt-radio">
                                                            <input type="radio" name="type_adjustment" value="Expired">
                                                            <span></span>
                                                        </span>
                                                    </span>
                                                    <span class="kt-option__label">
                                                        <span class="kt-option__head">
                                                            <span class="kt-option__title">
                                                            Expired
                                                            </span>
                                                        </span>
                                                    </span>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>                         
                                <div class="form-group">
                                    <label for="">Effective Date</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend"><span class="input-group-text"><i class="fa fa-calendar"></i></span></div>
                                        <input class="form-control datepicker" type="text" name="effective_date"  placeholder="Effective Date" readonly required>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="">Description</label>
                                    <textarea name="description" id="description" class="form-control" cols="30" rows="3"></textarea>
                                </div>
                                <div class="form-group">
                                    <div class="kt-checkbox-inline">
                                        <label class="kt-checkbox">
                                            <input type="checkbox" name="end_date_checkbox" value="End Date"> End Date
                                            <span></span>
                                        </label>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div id="end-date" >
                                        <label for="">End Date</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend"><span class="input-group-text"><i class="fa fa-calendar"></i></span></div>
                                            <input class="form-control datepicker" type="text" name="end_date"  placeholder="End Date"  readonly>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="kt-separator kt-separator--border-dashed kt-separator--space-lg"></div>
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="form-group">
                                <div class="input-group">
                                    <span><i class="flaticon-users"></i></span> <b class="ml-2"> Manage Employee Component</b>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-2">
                           <button data-attr="{{route("payroll.compennt.update.from.add.employee")}}" class="btn btn-secondary btn-block btn-add-employee">Add / Delete Employee </button>
                        </div>
                        <div class="col-2">
                            <button data-attr="{{route("payroll.compennt.update.from.add.component")}}"  class="btn btn-secondary btn-block btn-add-component">Add / Employee Component </button>
                         </div>
                         <div class="col-2">
                           &nbsp;
                         </div>
                         <div class="col-2">
                            &nbsp;
                          </div>
                         <div class="col-2 text-right">
                            <div class="form-group">
                                <div class="input-group">
                                    <form action="{{route('payroll.component.employee.search')}}" method="POST" id="search-from">
                                        <input type="text" class="form-control" name="searchemployee" placeholder="Search Employee">
                                        @csrf
                                    </form>
                                     &nbsp;
                                    <button type="submit" form="search-from" class="btn  btn-icon btn-default"><i class="flaticon-search"></i></button>
                                </div>
                            </div>
                         </div>
                         <div class="col-2 text-right">
                             <a href="{{route('payroll.component.export')}}" class="btn btn-secondary">Export </a>
                             <a href="javascript:;" data-attr="{{route('payroll.component.show.import')}}" class="btn btn-secondary btn-show-import">Import</a>
                          </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-12">
                            <table class="table"  style="font-size:1rem;" width="100%" >
                                <thead class="thead-light theads text-left">
                                    <tr class="trs">
                                        <th>Emp ID</th>
                                        <th>Employee</th>
                                        <th>Component</th>
                                        <th>Type</th>
                                        <th width="20%">Amount</th>
                                    </tr>
                                </thead>
                       
                                <tbody class="tbodys text-left">
                                    @foreach($employee as $row)
                                        @php
                                            $json = json_decode($row->component);  
                                        @endphp
                                        <tr class="trs">
                                            <td>
                                                <div class="pt-4">
                                                    {{$row->employee_id}}
                                                </div> 
                                            </td>
                                            <td>
                                                <div class="pt-4">
                                                    {{$row->full_name }}
                                                </div>
                                            </td>
                                            <td>
                                                @if(isset($json))
                                                    @foreach($json as $rows)
                                                    <div class="pt-4">
                                                        {{$rows->component }}
                                                    </div>
                                                    @endforeach
                                                @endif
                                            </td>
                                            <td>
                                                @if(isset($json))
                                                    @foreach($json as $rows)
                                                    <div class="pt-4">
                                                        {{$rows->type }}
                                                    </div>
                                                    @endforeach
                                                @endif
                                            </td>
                                            <td>
                                                @if(isset($json))
                                                    @foreach($json as $rows)
                                                        <div class="pt-0">
                                                            <div class="input-group input-group-sm pt-2" style="padding-top:0.6rem !important">
                                                                <div class="input-group-prepend"><span class="input-group-text">Rp.</span></div>
                                                                <input type="text" class="form-control amount form-control-sm" value="{{number_format($rows->amount,0,',',',')}}" name="amount[]" style="size:5px">
                                                            </div> 
                                                        </div>
                                                    @endforeach
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                       
                    </div>
                </div>
                <div class="kt-portlet__foot text-right kt_footer-fixed">
                    <div class="kt-form__actions">
                        <button type="cancel" class="btn btn-secondary">Cancel</button>
                        <button type="submit" form="form-payrollc-component" class="btn btn-primary">Submit</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@include('admin.payroll.component.modal')
@include('admin.payroll.component.modal-sm')
@push('scriptjs')
<script>

$("[name='description']").keyup(function(){
    localStorage.setItem("description",$(this).val());
});
var description = localStorage.getItem("description");
$("[name='description']").html(description);

$('input[name="type_adjustment"]').change(function() {
    if($(this).is(':checked')){
        let id = $(this).attr('name');
        let value = $(this).val();
        localStorage.setItem(id, value);    
    }
});
let type;
$('input[name="type_adjustment"]').each(function() {
    let id = $(this).attr('name');
    var radios = document.getElementsByName(id); 
    type = localStorage.getItem(id); 
    for(var i=0;i<radios.length;i++){
        if(radios[i].value == type){
            radios[i].checked = true; 
        }
    }
});
$("input[name='end_date_checkbox']").click(function () {
    if ($(this).is(":checked")) {
        $("#end-date").removeClass('d-none');
        localStorage.setItem("end_date",$(this).val());
    } else {
        $("#end-date").addClass('d-none');
        localStorage.removeItem("end_date");
        $("[name='end_date']").val('');
    }
});
var end_date = localStorage.getItem("end_date");


$("[name='end_date']").change(function(){
    localStorage.setItem("end_dates",$(this).val());
});
var end_dates = localStorage.getItem("end_dates");
$("[name='end_date']").val(end_dates);


$("[name='effective_date']").change(function(){
    localStorage.setItem("effective_date",$(this).val());
});
var effective_date = localStorage.getItem("effective_date");
$("[name='effective_date']").val(effective_date);

if (end_date == "End Date") {
    $("#end-date").removeClass('d-none');
    $("input[name='end_date_checkbox']").attr("checked", "checked");
}else{
    $("#end-date").addClass('d-none');
}

$('.datepicker').datepicker({
    todayHighlight: true,
    orientation: "bottom left",
});

let amount;
$(document).on('keyup','.amount',function(){
    amount = $(this).val();
    localStorage.setItem('amount',amount);
});

amount = localStorage.getItem('amount');
$("[name=amount]").val(amount)

$(document).on('click','.btn-add-employee',function(e){
 
    e.preventDefault();
    var create = $(this).attr('data-attr');
    $.ajax({
        url: create,
        success: function(results) {
            $('#modal_component_form .modal-title').html('');
            $('#modal_component_form').modal("show");
            $('#modal_component_content').html(results).show();
          
            let getvalue;
            $("select[name='organization_id']").change(function(){
                getvalue = $(this).val();
                get_employee(getvalue);
                localStorage.setItem("organization_id",$(this).val());
            });
            getvalue  = localStorage.getItem("organization_id");
            $("select[name='organization_id']").val(getvalue);
            $('.select2').select2();

            $("[name='searchemployee']").keyup(function(){
                getvalue = $(this).val();
                get_employee(getvalue);
            });
            // var data = localStorage.getItem("showning");
            // if (data !== null) {
            //     $("[name='select-all']").attr("checked", "checked");
            // }
            $("[name='select-all']").click(function(){
                $('input:checkbox').not(this).prop('checked', this.checked);
                // if ($(this).is(":checked")) {
                //     localStorage.setItem("showning", $(this).val());
                // } else {
                //     localStorage.removeItem("showning");
                // }
            });

            var arr = JSON.parse(localStorage.getItem('getheck')) || [];
            arr.forEach(function(checked, i) {
                $('.box').eq(i).prop('checked', checked);
            });
            $(document).on('click','.box',function(e){
                // alert('box');
                var arr = $('.box').map((i, el) => el.checked).get();
                localStorage.setItem("getheck", JSON.stringify(arr));
            });
            get_employee(getvalue);
            function get_employee(getvalue){
                $.ajax({        
                    type: "POST",   
                    url:'{{ route('payroll.component.employee.ajax') }}',
                    data:{"_token": "{{ csrf_token() }}","getvalue":getvalue},
                    success: function(result){
                        temp = `<div class="kt-widget__items" id="items"></div>`;
                        $.each(result, function(index, value){
                           temp += `<div class="kt-widget__item">
                                        <div class="kt-widget__info">
                                            <div class="kt-widget__section">
                                                <a href="#" class="kt-widget__username">`+value.full_name+`</a>
                                            </div>
                                            <span class="kt-widget__desc">
                                                `+value.name+`
                                            </span>
                                        </div>
                                        <label class="kt-checkbox">
                                                <input type="checkbox" name="employee_id[]" value="`+value.id+`" class="box">
                                            <span></span>
                                        </label>
                                    </div>`;
                        });
                        $('#items').html(temp);  
                    },
                });
            } 
        },
        timeout: 8000
    });
});


$(document).on('click','.btn-add-component',function(e){
    e.preventDefault();
    var create = $(this).attr('data-attr');
    $.ajax({
        url: create,
        success: function(results) {
            $('#modal_component_form .modal-title').html('');
            $('#modal_component_form').modal("show");
            $('#modal_component_content').html(results).show();

            let getvalue;
            $("[name='searchemployee']").keyup(function(){
                getvalue = $(this).val();
                get_employee(getvalue);
            });
            $("[name='select-all']").click(function(){
                $('input:checkbox').not(this).prop('checked', this.checked);
            });
            get_employee(getvalue)

            function get_employee(gevalue){
                $.ajax({        
                    type: "POST",   
                    url:'{{ route('payroll.component.component.ajax') }}',
                    data:{"_token": "{{ csrf_token() }}","getvalue":getvalue},
                    success: function(result){
                        temp = `<div class="kt-widget__items" id="items"></div>`;
                        $.each(result, function(index, value){
                            temp += `<div class="kt-widget__item">
                                        <div class="kt-widget__info">
                                            <div class="kt-widget__section">
                                                <a href="#" class="kt-widget__username">`+value.name+`</a>
                                            </div>
                                            <span class="kt-widget__desc">
                                                `+value.type+`
                                            </span>
                                        </div>
                                        <label class="kt-checkbox">
                                                <input type="checkbox" name="getcomponent[]" id="box-component" value="`+value.id+`" class="box-component">
                                            <span></span>
                                        </label>
                                    </div>`;
                        });
                        $('#component').html(temp);  
                    },
                });
            }

            let getvaluecomponent;
            $(document).on('click','.box-component',function(){
                getvaluecomponent = $("#component input:checkbox:checked").map(function(){
                return $(this).val();
                }).get()
                localStorage.setItem('boxcomponent',getvaluecomponent);
                getComponent(getvaluecomponent);
            });

            getvaluecomponent = localStorage.getItem('boxcomponent');

            getComponent(getvaluecomponent)
            function getComponent(getvaluecomponent){
                $.ajax({        
                    type: "POST",   
                    url:'{{ route('payroll.component.get.filter') }}',
                    data:{"_token": "{{ csrf_token() }}","getvaluecomponent":getvaluecomponent},
                    success: function(result){
                        console.log(result);
                        temp = `<div class="kt-widget__items" id="items"></div>`;
                        $.each(result, function(index, value){
                            temp += `<div class="kt-widget__item">
                                        <div class="kt-widget__info">
                                            <div class="kt-widget__section">
                                                <a href="#" class="kt-widget__username">`+value.name+`</a>
                                            </div>
                                            <span class="kt-widget__desc">
                                                `+value.type+`
                                            </span>
                                            <input type="hidden" name="component_id[]" value="`+value.id+`" >
                                        </div>
                                    </div>`;
                        });
                        $('#component-items').html(temp);  
                    },
                });
            }
        },
    });
});

$(".amount").keyup(function() {
    var n = parseInt($(this).val().replace(/\D/g, ''), 10) || '';
    $(this).val(n.toLocaleString());
});


$(document).on('click','.btn-show-import',function(e){
    e.preventDefault();
    var show = $(this).attr('data-attr');
    $.ajax({
        url: show,
        success: function(results) {
            $('#modal_component_modal .modal-title').html('');
            $('#modal_component_modal').modal("show");
            $('#modal_component_modal_content').html(results).show();
        }
    });
});



</script>
@endpush