@extends('layout-admin.base2',[
	'pages'=>'aktivasi',
	'subpages'=>''
])

@section('content')
	<div class="container">
		<div class="row justify-content-center">
			<div class="col-xl-6">
				<!--begin:: Widgets/Applications/User/Profile4-->
				<div class="kt-portlet kt-portlet--height-fluid">
					<div class="kt-portlet__body p-lg-5">

						<!--begin::Widget -->
						<div class="kt-widget kt-widget--user-profile-4">
							<div class="kt-widget__head m-0">
								<div class="kt-widget__media mb-2">
									<img class="kt-widget__img kt-hidden-" src="{{ asset('logo/ic-esmart.png')}}" alt="image">
								</div>
								<div class="kt-widget__content">
									<div class="kt-widget__section">
										<div class="kt-widget__username text-uppercase kt-font-boldest">
											E-Smart
										</div>
									</div>
								</div>
							</div>
							<hr>
							<div class="kt-widget__body">
								<h6 class="kt-font-bolder">Dear Satya,</h6>

								<p class="lh-lg">PT Dua Sisi Sejahtera has started using E-Smart as their HR Management Software</p>

								<p class="m-0">The administrator has invited you to join.</p>

								<a href="{{route('aktivasi.create')}}" class="btn btn-success my-4">Active your account</a>

								<p>Your log in email is <span class="kt-font-bold text-primary">Satya@gmail.com</span></p>
								<p class="m-0">Happy Monday!</p>
							</div>
						</div>
						<!--end::Widget -->
					</div>
				</div>
				<!--end:: Widgets/Applications/User/Profile4-->
			</div>

			<div class="col-xl-12 text-center">
				<div class="kt-footer__copyright">
						2022&nbsp;&copy;&nbsp; E-Smart All rights reserved.
				</div>
			</div>
		</div>

	</div>
@endsection