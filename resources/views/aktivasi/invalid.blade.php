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
								<div class="kt-pricing-1__hexagon1 dangerhexagon1"></div>
								<div class="kt-pricing-1__hexagon2 dangerhexagon2"></div>
								<span class="kt-pricing-1__icon kt-font-danger"><i class="fa flaticon-close"></i></span>
							</div>
							<span class="kt-pricing-1__price">Undangan tidak valid</span>
							<h2 class="kt-pricing-1__subtitle lh-base">Undangan Anda untuk aktivasi E-Smart tidak valid. Silakan periksa email terbaru Anda untuk undangan baru.</h2>
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