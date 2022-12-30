@extends('layout-admin.base',[
	'pages'=>'payroll',
	'subpages'=>'slipgaji'
])
@section('content')
@include('admin.slipgaji.modal')
<div class="kt-content  kt-grid__item kt-grid__item--fluid kt-grid kt-grid--hor" id="kt_content">
	<!-- begin:: Content Head -->
	<div class="kt-subheader  kt-grid__item" id="kt_subheader">
		<div class="kt-container  kt-container--fluid ">
			<div class="kt-subheader__main">
				<h3 class="kt-subheader__title">Slip Gaji</h3>
				<span class="kt-subheader__separator kt-subheader__separator--v"></span>
				<div class="kt-input-icon kt-input-icon--right kt-subheader__search kt-hidden">
					<input type="text" class="form-control" placeholder="Search order..." id="generalSearch">
					<span class="kt-input-icon__icon kt-input-icon__icon--right">
						<span><i class="flaticon2-search-1"></i></span>
					</span>
				</div>
			</div>
			<div class="kt-subheader__toolbar">
				<div class="kt-subheader__wrapper">
                    @can('Pembayaran Massal')
                
                    @endcan
                    @can('Pembayaran Massal')
                    <button id="paidall" class="btn btn-brand btn-elevate">
                        <i class="flaticon-coins"></i>
                         Bayar Massal
                    </button>
                    @endcan
                    @can('Export Slipgaji')
                    <button form="slip-form" formaction="{{route('slipgaji.export')}}" class="btn btn-success btn-elevate btn-icon-sm">
                        <i class="fa fa-file-export"></i>
                        Export
                    </button>
                    @endcan
                    @can('Hapus Slipgaji')
                    <button form="slip-form" formaction="{{route('slipgaji.destroy')}}" class="btn btn-danger btn-elevate btn-icon-sm">
                        <i class="flaticon-delete"></i>
                        Hapus
                    </button>
                    @endcan
				</div>
			</div>
		</div>
	</div>
	<!-- end:: Content Head -->

	<!-- begin:: Content -->
	<div class="kt-container  kt-container--fluid  kt-grid__item kt-grid__item--fluid">
        @can('Generate Slipgaji')
        <div class="row">
            <div class="col-lg-6">
                <form  method="POST" id="slip-form" class="kt-form">
                    {{ csrf_field() }}
                    
                    <div class="kt-portlet__body">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label for="">Month To : </label>
                                    <input type="text" name="salary_month" onchange="filterMonth()" class="form-control" id="salary_month" placeholder="Masukkan Bulan" autocomplete="off">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="kt-portlet__foot">
               
                        <button type="submit" class="btn btn-primary btn-sm" form="slip-form" formaction="{{route('slipgaji.store')}}">
                            <i class="flaticon2-layers-2"></i>
                            Generate Pay Slip
                        </button>
                    </div>
                </form>
            </div>
            <div class="col-lg-6">
                <form  method="POST" id="slip-announcement" class="kt-form" action="{{route('slipgaji.annoucement.email')}}">
                    {{ csrf_field() }}
                    <div class="kt-portlet__body">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <input type="hidden" name="month_email" class="form-control"  placeholder="Masukkan Bulan" autocomplete="off">
                                    <label for="">Announcement By Email</label>
                                    <textarea name="announcement" class="form-control" cols="30" rows="1">Harap hubungi Hrd jika terjadi kesalahan penginputan. Terimakasih</textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="kt-portlet__foot">
                        <button type="submit" class="btn btn-primary btn-sm">
                            <i class="flaticon-email"></i>
                            Generate announcement
                        </button>
                        {{-- <button type="submit" class="btn btn-primary btn-sm" form="slip-form" formaction="{{route('slipgaji.store')}}">Generate</button> --}}
                    </div>
                </form>
            </div>
        </div>
       
        @endcan 
        <div>
            &nbsp;
        </div>
        <div class="kt-portlet kt-portlet--mobile">
            <div class="kt-portlet__head kt-portlet__head--lg">
                <div class="kt-portlet__head-label">
                    <span class="kt-portlet__head-icon">
                        <i class="kt-font-brand flaticon flaticon-user"></i>
                    </span>
                    <h3 class="kt-portlet__head-title">
                        Daftar Slip Gaji 
                    </h3>
                </div>
                <div class="kt-portlet__head-toolbar">
                    <div class="kt-portlet__head-toolbar">
                        <div class="kt-portlet__head-wrapper">
                            <div class="kt-portlet__head-actions">
                               
                            </div>
                        </div>
                    </div>
                   
                </div>
            </div>
            @include('message')
            <div class="kt-portlet__body">
                <!--begin: Datatable -->
                <div class="row">
                    <div class="col-lg-12">
                        <table class="table table-striped- table-bordered table-hover table-checkable dataTable no-footer dtr-inline" id="slipgaji-table">
                            <thead>
                                <tr role="row">
                                    <th width="30%">Nama</th>
                                    <th width="8%">Tipe Gaji</th>
                                    <th width="10%">Gaji Pokok</th>
                                    <th width="10%">Gaji Bersih</th>
                                    <th width="10%">Status</th>
                                    <th width="20%">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td colspan="6"></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
    
                <!--end: Datatable -->
            </div>
        </div>					
	</div>
	<!-- end:: Content -->
</div>
@endsection
@push('script')
<script>
    let salary_month;
    let month_email;
    function filterMonth(){
        salary_month = document.getElementById('salary_month').value;
    
        if(salary_month != null){
            $('#slipgaji-table').DataTable().clear();
            $('#slipgaji-table').DataTable().destroy();
            showDatatable(salary_month);
            $("[name='month']").val(salary_month);
        }
        localStorage.setItem('salary_month',salary_month);
        localStorage.setItem('month_email',salary_month);
    }

    var salary_months = localStorage.getItem('salary_month');
    var month_emails = localStorage.getItem('month_email');

    salary_month = $("[name='salary_month']").val(salary_months);
    month_email = $("[name='month_email']").val(month_emails);
    

    $('#salary_month').datepicker({
        format: "yyyy-mm",
        startView: "months", 
        minViewMode: "months",
        orientation: "bottom left"				
    });

    function showDatatable(salary_months){
        var datatable1 = $("#slipgaji-table").DataTable({
            drawCallback:function(){$(".dataTables_paginate > .pagination").addClass("pagination-rounded")},
            "bFilter": true,
            responsive:true,
            paging:true,
            select:true,
            serverSide:true,
            "bInfo" : false,
            ajax:{
                url:'{{ route('slipgaji.ajax') }}',
                type:'post',
                data:{"_token": "{{ csrf_token() }}","salary_month":salary_months},
            },
            columns:[
                { data:'employee'},
                { data:'salary_type'},
                { data:'basic_salary'},
                { data:'net_payble'},
                { data:'status'},
                { data:'actions'},
            ],
        }); 
    }
    showDatatable(salary_months);

    function clickAll(){
    }

    clickAll();
    $(document).on('click','.btn-send-email',function(){
 
        var id = $(this).attr('data-id');
        var url = "{{ route('slipgaji.byemail', ":id") }}";
        url = url.replace(':id', id);
        $.ajax({
            type: 'GET',
            url: url,
            success: function (data) {
               
                $("#slipgaji-table").DataTable().ajax.reload(false,null);
            },
            error: function(data) { 
               
            }
        });
    });

    $(document).on('click','.btn-send-back',function(){
        
        var id = $(this).attr('data-id');
        var url = "{{ route('slipgaji.byemail.back', ":id") }}";
        url = url.replace(':id', id);
        $.ajax({
            type: 'GET',
            url: url,
            success: function (data) {
                
                $("#slipgaji-table").DataTable().ajax.reload(false,null);
            },
            error: function(data) { 
                conhsole.log(data);
            }
        });
    });

    $(document).on('click','.btn-edit-slip',function(){
        
        var url = $(this).attr('data-href');
        $.ajax({
            type: 'GET',
            url: url,
            success: function(result) {
                $('#modalform .modal-title').html('Edit Akses izin');
                $('#modalform').modal("show");
                $('#modalcontent').html(result).show();
                $(".nominal").on('keyup', function() {
                    var n = parseInt($(this).val().replace(/\D/g, ''), 10) || '';
                    $(this).val(n.toLocaleString());
                });  
            },
            timeout: 8000,
            error: function(data) { 
                console.log(data);
            }
        });
    });

    $(document).on('click','.btn-announcement-email',function(){
        var url = $(this).attr('data-href');
        $.ajax({
            type: 'GET',
            url: url,
            success: function(result) {
                $('#modalform .modal-title').html('Edit Akses izin');
                $('#modalform').modal("show");
                $('#modalcontent').html(result).show();
                $(".nominal").on('keyup', function() {
                    var n = parseInt($(this).val().replace(/\D/g, ''), 10) || '';
                    $(this).val(n.toLocaleString());
                });  
            },
            timeout: 8000,
            error: function(data) { 
                console.log(data);
            }
        });
    });
</script>
@endpush