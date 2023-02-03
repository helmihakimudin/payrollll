@extends('layout-admin.base2',[
	'pages'=>'aktivasi',
	'subpages'=>''
])

@section('content')
	<div class="container">
		<div class="row justify-content-center">
			<div class="col-xl-5">
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
								<form action="{{route('aktivasi.changepwd')}}" method="post">
									@csrf
									<div class="form-group">
										<label>Password :</label>
										<input type="password" name="password"  class="form-control @error('password') is-invalid @enderror" id="Password" placeholder="Masukkan password" required>
										@error('password')
											<span class="invalid-feedback" role="alert">
												<strong>{{ $message }}</strong>
											</span>
										@enderror
									</div>
									<div class="form-group">
										<label>Ulangi Password :</label>
										<input type="password" name="ulangi-password" class="form-control @error('password') is-invalid @enderror" id="ConfirmPassword" placeholder="Konfirmasi password" required>
										<div id="msg"></div>
									</div>
									<input type="hidden" name="employee_id" value="{{$id}}"/>
									<button type="submit" class="btn btn-success mb-4">Aktivasi Sekarang</button>
								</form>
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
@push('scriptjs')
<script>
    $(document).ready(function(){
        $("#ConfirmPassword").keyup(function(){
             if ($("#Password").val() != $("#ConfirmPassword").val()) {
                 $("#msg").html("Password do not match").css("color","red");
             }else{
                 $("#msg").html("Password matched").css("color","green");
            }
      });
});
</script> 
@endpush