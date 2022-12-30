@extends('layout-admin.base',[
	'pages'=>'setting',
	'subpages'=>'currency'
])
@section('content')
<!--modal-->
<!--end modal-->
<div class="kt-content  kt-grid__item kt-grid__item--fluid kt-grid kt-grid--hor" id="kt_content">
	<!-- begin:: Content Head -->
	<div class="kt-subheader  kt-grid__item" id="kt_subheader">
		<div class="kt-container  kt-container--fluid ">
			<div class="kt-subheader__main">
				<h3 class="kt-subheader__title">Konversi Mata Uang</h3>
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
				
				</div>
			</div>
		</div>
	</div>
	<!-- end:: Content Head -->

	<!-- begin:: Content -->
	<div class="kt-container  kt-container--fluid  kt-grid__item kt-grid__item--fluid">
		
		<div class="kt-portlet kt-portlet--mobile">
			<div class="kt-portlet__head kt-portlet__head--lg">
				<div class="kt-portlet__head-label">
					<span class="kt-portlet__head-icon">
						<i class="kt-font-brand flaticon flaticon-user"></i>
					</span>
					<h3 class="kt-portlet__head-title">
					Konversi Mata Uang
					</h3>
				</div>
				<div class="kt-portlet__head-toolbar">
                    <div class="kt-portlet__head-toolbar">
                        <div class="kt-portlet__head-wrapper">
                            <div class="kt-portlet__head-actions">
								@can('Edit Mata Uang')
                                <a href="{{route('currency.setting')}}" class="btn btn-brand btn-elevate btn-icon-sm">
                                    <i class="la flaticon-edit"></i>
                                    Ubah
                                </a>
								@endcan
                            </div>
                        </div>
                    </div>
                   
                </div>
			</div>
			@include('message')
			<div class="kt-portlet__body">
				<!-- begin:: Content -->
					<div class="kt-container  kt-container--fluid  kt-grid__item kt-grid__item--fluid">
						
						<div class="row">
							<div class="col-xl-12">

								<!--begin:: Widgets/Personal Income-->
								<div class="kt-portlet kt-portlet--fit kt-portlet--head-lg kt-portlet--head-overlay kt-portlet--height-fluid">
									<div class="kt-portlet__head kt-portlet__space-x">
										<div class="kt-portlet__head-label">
											<h3 class="kt-portlet__head-title">
												Konversi Saat Ini
											</h3>
										</div>
										<div class="kt-portlet__head-toolbar">
											{{--  --}}
										</div>
									</div>
									<div class="kt-portlet__body">
										<div class="kt-widget27">
											<div class="kt-widget27__visual">
												<img src="{{ asset('demo1/assets/media/bg/bg-9.jpg')}}" alt="">
												<h3 class="kt-widget27__title pb-5 text-dark">
													1 US Dollar = {{$currencyidr->rupiah}} IDR
												</h3>
												<h3 class="kt-widget27__title pt-5 text-dark">
													1 IDR = {{$currencyidr->dollar}} US Dollar
												</h3>
											</div>
										</div>
									</div>
								</div>
								<!--end:: Widgets/Personal Income-->
							</div>
						</div>
					</div>
				<!-- end:: Content -->

				<!-- begin:: Content -->
				<div class="kt-container  kt-container--fluid  kt-grid__item kt-grid__item--fluid">
					
			
				<h3 class="kt-portlet__head-title">
					Kalkulator Konversi
				</h3>
				<form action="" method="" class="form" id="form_calc" enctype="multipart/form-data">
						{{ csrf_field() }}
						@method('PUT')
						<div class="row">
						<input type="hidden" id="idr" name="idr" value="{{$currencyidr->idr}}" >
						<input type="hidden" id="usd" name="usd" value="{{$currencyidr->usd}}" >
							<div class="col-lg-6">
								<div class="form-group">
									<label>IDR</label>
									<input type="text" class="form-control" id="inputidr" value="{{$currencyidr->idr}}" name="inputidr"  placeholder="Enter Branch">
								</div>
							</div>
							<div class="col-lg-6">
								<div class="form-group">
									<label>USD</label>
									<input type="text" class="form-control" id="inputusd" value="{{$currencyidr->usd}}" name="inputusd" placeholder="Enter Branch">
								</div>
							</div>
						</div>	
					</form>			
				</div>
				<!-- end:: Content -->
			</div>
		</div>					
	</div>
<!-- end:: Content -->

	
</div>
@endsection
@push('script')
<script>
			var idrx = parseFloat(document.getElementById("idr").value);
			var usdx = parseFloat(document.getElementById("usd").value);
			var idrxx = 0;
			var usdxx = 0;
			var subidr = 0;
			var subusd = 0;

$("#inputidr").on("change keyup paste", function(){
    
			idrxx = parseFloat($(this).val());
			subidr = idrxx / idrx;
			$("input[name=inputusd]").val(subidr.toFixed(6));	
})

$("#inputusd").on("change keyup paste", function(){
    
	usdxx = parseFloat($(this).val());
	subusd = usdxx * idrx;
	$("input[name=inputidr]").val(subusd.toFixed(2));	
})
</script>
@endpush