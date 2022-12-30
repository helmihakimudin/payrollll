@extends('auth.base',[

])
@section('content')
<!-- begin:: Page -->
<div class="kt-grid kt-grid--ver kt-grid--root kt-page">
	<div class="kt-grid kt-grid--hor kt-grid--root  kt-login kt-login--v3 kt-login--signin" id="kt_login">
		<div class="kt-grid__item kt-grid__item--fluid kt-grid kt-grid--hor" style="background-image: url({{asset('demo10/assets/media/bg/bg-3.jpg')}});">
			<div class="kt-grid__item kt-grid__item--fluid kt-login__wrapper">
				<div class="kt-login__container">
					<div class="kt-login__logo">
						<a href="#">
							<img src="{{ asset('logo/e-smart.png')}}" width="100%">
						</a>
					</div>
					<div class="kt-login__signin">
						<div class="kt-login__head">
							<h3 class="kt-login__title">Sign In To Admin</h3>
						</div>
						<form method="POST" class="kt-form" action="{{ route('emp.login') }}">
							@csrf
							<div class="input-group">
								<input class="form-control" type="text" placeholder="Email" name="email" autocomplete="off">
							</div>
							<div class="input-group">
								<input class="form-control" type="password" placeholder="Password" name="password">
							</div>
							<div class="row kt-login__extra">
								<div class="col">
									<label class="kt-checkbox">
										<input type="checkbox" name="remember"> Remember me
										<span></span>
									</label>
								</div>
								<div class="col kt-align-right">
									<a href="javascript:;" id="kt_login_forgot" class="kt-login__link">Forget Password ?</a>
								</div>
							</div>
							<div class="kt-login__actions">
								<button type="submit" class="btn btn-brand btn-elevate kt-login__btn-primary btn-sm btn-block">Sign In</button>
							</div>
						</form>
					</div>
					
					<div class="kt-login__account">
						<span class="kt-login__account-msg">
							Don't have an account yet ?
						</span>
						&nbsp;&nbsp;
						<a href="javascript:;" id="kt_login_signup" class="kt-login__account-link">Sign Up!</a>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<!-- end:: Page -->
@endsection