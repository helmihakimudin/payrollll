@extends('layout-admin.base',[
	'pages'=>'payroll',
	'subpages'=>'payroll',
])
@section('content')
<style>
    .swal2-popup .swal2-icon {
        margin : auto !important;
    }
</style>
<div class="kt-body kt-grid__item kt-grid__item--fluid kt-grid kt-grid--hor kt-grid--stretch" id="kt_body">
    <div class="kt-content  kt-grid__item kt-grid__item--fluid kt-grid kt-grid--hor" id="kt_content">
        <div class="kt-subheader   kt-grid__item" id="kt_subheader">
            <div class="kt-container pt-3">
                <div class="kt-subheader__main">
                    <h3 class="kt-subheader__title">
                        Run THR {{date("F Y")}}
                    </h3>
                    <span class="kt-subheader__separator kt-subheader__separator--v"></span>
                </div>
            </div>
        </div>
        <div class="kt-container  kt-grid__item kt-grid__item--fluid">
            <div class="row">
                <div class="col-lg-12">
                   <form action="{{route('payroll.run.thr')}}" method="POST" id="run-thr">
                        <table class="table kt-datatable__tabletable-checkable dataTable no-footer dtr-inline karyawan-table" style="font-size:11px;" id="run-thr-table">
                            <thead>
                                <tr role="row">
                                    <th><input type="checkbox" id="checkAll" name="check-all" class="form-controll"></th>
                                    <th>Employee ID</th>
                                    <th>Employee</th>
                                    <th>Organization</th>
                                    <th>Branch</th>
                                    <th>Join Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if(!empty($employees))
                                @foreach ($employees as $row)
                                <tr>
                                    <td><input type="checkbox" data-id="{{$row->id}}" id="{{$row->employee_id}}" class="chkbox" name="employee_id[]" value="{{$row->id}}"></td>
                                    <td>{{@$row->employee_id}}</td>
                                    <td>{{@$row->full_name}}</td>
                                    <td>{{@$row->organization->name}}</td>
                                    <td>{{@$row->branch->name}}</td>
                                    <td>{{@$row->join_date}}</td>
                                </tr>
                                @endforeach
                                @endif
                            </tbody>
                        </table>
                    </form>
                </div>
            </div>
            <div class="row pt-5">
                <div class="col-2">
                    &nbsp;
                </div>
                <div class="col-2">
                    &nbsp;
                </div>
                <div class="col-2">
                    <button type="submit" id="running-thr" form="run-thr" class="btn btn-secondary btn-block btn-add-employee">Save And Run THR</button>
                </div>
                <div class="col-2">
                    <a href="{{route('payroll')}}" class="btn btn-secondary btn-block btn-add-employee">Back to menu </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@include('admin.employetransfer.modal')
@push('scriptjs')
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
$( document ).ready(function() {
    var table = $('#run-thr-table').DataTable();

    $('#checkAll').click(function() {

        var checked = this.checked;
        var selected = [];
        table.rows().nodes().to$().each(function() {
            if (checked == true) {
                $(this).find('.chkbox').attr('checked', 'checked');
                $(this).toggleClass('selected');

                var id = $(this).closest("tr").find('input').attr('data-id');
                selected.push(id);

            } else {
                $(this).removeClass('selected');
                $(this).find('.chkbox').removeAttr('checked', 'checked');
                localStorage.removeItem("dataThr");
            }
        });

        table.draw();

        //convert array to json
        json = Object.assign({}, selected);
        localStorage.setItem('dataThr', JSON.stringify(json));
    });


    var selected = [];
    $('#run-thr-table tbody').on('click', 'tr', function (i) {
        $(this).toggleClass('selected');

        var id = $(this).closest("tr").find('input').attr('data-id');
        var checked = $(this).hasClass('selected');

        if(checked==true){
            $(this).find('.chkbox').attr('checked', 'checked');
            var id = $(this).closest("tr").find('input').attr('data-id');
            selected.push(id.toString());
        }else {
            $(this).removeClass('selected');
            $(this).find('.chkbox').removeAttr('checked', 'checked');
            selected = selected.filter(item => item !== id)
        }

        //convert array to json
        json = Object.assign({}, selected);
        localStorage.setItem('dataThr', JSON.stringify(json));
    });

    $('#running-thr').click(function(event) {

        event.preventDefault();
        let getDataThr = JSON.parse(localStorage.getItem('dataThr'));

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $.ajax({
            url: '{{route('payroll.run.thr')}}',
            data: getDataThr,
            method: "POST",
            dataType:"json",
            success: function(response){
                Swal.fire(
                    'Good job!',
                    'Run THR has been success!',
                    'success'
                ).then(function() {
                    window.location.href = response.redirect_url
                });
            },
            error: function( jqXhr, textStatus, errorThrown ){
                Swal.fire({
                    icon: 'error',
                    title: 'Run THR cannot run',
                    text: 'Because there are some employees join date still empty!',
                }).then(function() {
                    window.location.href = response.redirect_url
                });
            }
        });
    });
});
</script>
@endpush
