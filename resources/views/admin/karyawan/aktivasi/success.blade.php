@extends('layout-admin.base2',[
	'pages'=>'aktivasi-success',
	'subpages'=>''
])

@push('css')
		<link href="{{ asset('demo10/assets/css/pages/pricing/pricing-1.css')}}" rel="stylesheet" type="text/css" />
@endpush

@section('content')
	<div class="container">
		<div class="kt-pricing-1 mb-3">
			<div class="kt-pricing-1__items row justify-content-center bg-transparent p-0">
				<div class="kt-pricing-1__item col-lg-5">
					<div class="card">
						<div class="card-body px-lg-5 pb-lg-5">

							<div class="kt-pricing-1__visual">
								<div class="kt-pricing-1__hexagon1 successhexagon1"></div>
								<div class="kt-pricing-1__hexagon2 successhexagon2"></div>
								<span class="kt-pricing-1__icon kt-font-success"><i class="fa flaticon-multimedia-3"></i></span>
							</div>
							<span class="kt-pricing-1__price">Aktivasi berhasil</span>
							<h2 class="kt-pricing-1__subtitle lh-base">Selamat aplikasi E-Smart sudah dapat digunakan. Silahkan login melalui Aplikasi atau melalui Website  </h2>
							<div class="kt-pricing-1__btn mb-4">
								<button type="button" class="btn btn-brand btn-custom btn-pill btn-wide btn-uppercase btn-bolder btn-sm">Unduh Aplikasi</button>
							</div>
		
							<a href="#" class="kt-font-brand kt-link kt-font-bolder">Login melalui website</a>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="row justify-content-center">
			<div class="col-xl-12 text-center">
				<div class="kt-footer__copyright">
						2022&nbsp;&copy;&nbsp; E-Smart All rights reserved.
				</div>
			</div>
		</div>

	</div>
@endsection