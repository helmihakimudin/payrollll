@extends('layout-admin.base',[
	'pages'=>'setting',
	'subpages'=>'branch'
])
@section('content')
<div class="kt-content  kt-grid__item kt-grid__item--fluid kt-grid kt-grid--hor" id="kt_content">

	<!-- begin:: Content Head -->
	<div class="kt-subheader  kt-grid__item" id="kt_subheader">
		<div class="kt-container  kt-container--fluid ">
			<div class="kt-subheader__main">
				<h3 class="kt-subheader__title">Konversi Mata Uang</h3>
				<span class="kt-subheader__separator kt-subheader__separator--v"></span>
				
				{{--  --}}
				<div class="kt-input-icon kt-input-icon--right kt-subheader__search kt-hidden">
					<input type="text" class="form-control" placeholder="Search order..." id="generalSearch">
					<span class="kt-input-icon__icon kt-input-icon__icon--right">
						<span><i class="flaticon2-search-1"></i></span>
					</span>
				</div>
			</div>
			<div class="kt-subheader__toolbar">
				<div class="kt-subheader__wrapper">
					<a href="{{route('currency.converter')}}" class="btn btn-brand btn-elevate btn-icon-sm">
                        <i class="la la-minus"></i>
                        Kembali 
                    </a>
                    <button type="submit" form="form-curr" class="btn btn-success btn-elevate btn-icon-sm">
                        <i class="la la-save"></i>
                        Ubah 
                    </button>
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
						Ubah Nilai Konversi
						</h3>
					</div>
					
				</div>
				@include('message')
				<div class="kt-portlet__body">
					<!-- begin:: Content -->
					<div class="kt-container  kt-container--fluid  kt-grid__item kt-grid__item--fluid">
						<form action="{{route('currency.store',$currencyidr->id)}}" method="POST" class="form" id="form-curr" enctype="multipart/form-data">
						{{ csrf_field() }}
						@method('PUT')
							<div class="row">
								<div class="col-lg-12">
									<div class="form-group">
										<label>US Dollar</label>
										<input type="text" class="form-control" value="1" disabled>
									</div>
								</div>			
								<div class="col-lg-12">
									<div class="form-group">
										<label>IDR</label>
										<input type="text" class="form-control" name="idr" value="{{$currencyidr->idr}}"  placeholder="Enter IDR">
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

@endpush