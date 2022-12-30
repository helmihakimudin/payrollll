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
								<div class="kt-widget__media">
									<img class="w-50" src="{{ asset('logo/e-smart-logo.png')}}" alt="image">
								</div>
							</div>
							<div class="kt-widget__body">
								<form>
									<div class="form-group">
										<label>Password :</label>
										<input type="password" name="password" class="form-control" placeholder="Masukkan password">
										<span class="form-text text-muted">Silahkan masukkan password anda</span>
									</div>
									<div class="form-group">
										<label>Ulangi Password :</label>
										<input type="password" name="ulangi-password" class="form-control" placeholder="Konfirmasi password">
										<span class="form-text text-muted">Silahkan ulangi password anda</span>
									</div>
								</form>

								<a href="{{route('aktivasi.success')}}" type="submit" class="btn btn-success mb-4">Aktivasi Sekarang</a>
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