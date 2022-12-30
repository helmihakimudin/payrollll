@extends('karyawan-layout.base',[
	'pages'=>'profil',
	'subpages'=>''
])
@section('content')
<div class="kt-body kt-grid__item kt-grid__item--fluid kt-grid kt-grid--hor kt-grid--stretch" id="kt_body">
    <div class="kt-content  kt-grid__item kt-grid__item--fluid kt-grid kt-grid--hor" id="kt_content">
     
        <div class="kt-container  kt-grid__item kt-grid__item--fluid">
			
            <div class="row pt-3">
				<div class="col-lg-3">
						<!--begin:: Portlet-->
						<div class="kt-portlet">
							<div class="kt-portlet__body">
								<!--begin::Widget -->
								<div class="kt-widget kt-widget--user-profile-4">
									<div class="kt-widget__head">
										<div class="kt-widget__media">
											<img class="kt-widget__img kt-hidden" src="assets/media/users/300_21.jpg" alt="image">
											<div class="kt-widget__pic kt-widget__pic--success kt-font-success kt-font-boldest kt-font-light kt-hidden-">
												MP
											</div>
										</div>
										<div class="kt-widget__content">
											<div class="kt-widget__section">
												<a href="#" class="kt-widget__username">
													{{Auth::guard('karyawan')->user()->name}}
												</a>
												<div class="kt-widget__button">
													<button type="button" class="btn btn-label-warning btn-sm">Active</button>
												</div>
												<div class="kt-widget__action">
													<a href="#" class="btn btn-icon btn-circle btn-label-facebook">
														<i class="socicon-facebook"></i>
													</a>
													<a href="#" class="btn btn-icon btn-circle btn-label-twitter">
														<i class="socicon-twitter"></i>
													</a>
													<a href="#" class="btn btn-icon btn-circle btn-label-google">
														<i class="socicon-google"></i>
													</a>
												</div>
											</div>
										</div>
									</div>
									<div class="kt-widget__body">
										<!-- begin:: Aside Menu -->
									
										<!-- end:: Aside Menu -->
									</div>
								</div>
								<!--end::Widget -->
							</div>
						</div>
						<!--end:: Portlet-->
				</div>
				<div class="col-lg-9">
					<div class="kt-portlet">
						<div class="kt-portlet__head">
							<div class="kt-portlet__head-label">
								<h3 class="kt-portlet__head-title">
									Personal
								</h3>
							</div>
						</div>
						<div class="kt-portlet__body">
							<div class="row">
								<div class="col-lg-5">
									<span class="font-weight-bold"> Personal Data </span><br>
									<span>Your email address is your identity on Talenta is used to log in.</span>
								</div>
								<div class="col-lg-7">
									<ul class="list-unstyled mb-0"><li><div class="row py-2"><div class="col-sm-4 d-flex align-items-center"><span class="font-weight-bold"> Full name </span></div> <div class="col-sm-8"><p>
										{{Auth::guard('karyawan')->user()->name}}
									  </p></div></div></li><li><div class="row py-2"><div class="col-sm-4 d-flex align-items-center"><span class="font-weight-bold"> Mobile phone </span></div> <div class="col-sm-8"><p>
										{{Auth::guard('karyawan')->user()->phone}}
									  </p></div></div></li><li><div class="row py-2"><div class="col-sm-4 d-flex align-items-center"><span class="font-weight-bold"> Email </span></div> <div class="col-sm-8"><p>
										{{Auth::guard('karyawan')->user()->email}}
									  </p></div></div></li><li><div class="row py-2"><div class="col-sm-4 d-flex align-items-center"><span class="font-weight-bold"> Phone </span></div> <div class="col-sm-8"><p>
										{{Auth::guard('karyawan')->user()->no_telp}}
									  </p></div></div></li><li><div class="row py-2"><div class="col-sm-4 d-flex align-items-center"><span class="font-weight-bold"> Place of birth </span></div> <div class="col-sm-8"><p>
										{{Auth::guard('karyawan')->user()->pob}}
									  </p></div></div></li><li><div class="row py-2"><div class="col-sm-4 d-flex align-items-center"><span class="font-weight-bold"> Birthdate </span></div> <div class="col-sm-8"><p class="d-flex">
										{{Auth::guard('karyawan')->user()->dob}}
										  <div data-v-8cd30f96="" class="ml-2 py-0 align-self-center badge badge-smoke"><div data-v-8cd30f96="" class="d-flex"><!----><span data-v-8cd30f96="" class="">29 years old</span><!----></div></div></p></div></div></li><li><div class="row py-2"><div class="col-sm-4 d-flex align-items-center"><span class="font-weight-bold"> Gender </span></div> <div class="col-sm-8"><p>
										{{Auth::guard('karyawan')->user()->gender}}
									  </p></div></div></li><li><div class="row py-2"><div class="col-sm-4 d-flex align-items-center"><span class="font-weight-bold"> Marital status </span></div> <div class="col-sm-8"><p>
										{{Auth::guard('karyawan')->user()->merriage_status}}
									  </p></div></div></li><li><div class="row py-2"><div class="col-sm-4 d-flex align-items-center"><span class="font-weight-bold"> Blood type </span></div> <div class="col-sm-8"><p>
										 - 
									  </p></div></div></li><li><div class="row py-2"><div class="col-sm-4 d-flex align-items-center"><span class="font-weight-bold"> Religion </span></div> <div class="col-sm-8"><p>
										Catholic
									  </p></div></div></li></ul>
								</div>
							</div>
							
							<div class="kt-separator kt-separator--border-dashed kt-separator--space-lg"></div>
							 Identity & Address
							<div class="kt-separator kt-separator--border-dashed kt-separator--space-lg"></div>
						</div>
						<!--end::Form-->
					</div>
				</div>
			</div>
        </div>
    </div>
</div>

@endsection
@push('script')
<script src="{{ asset('demo1/assets/js/pages/custom/user/add-user.js')}}" type="text/javascript"></script>
@endpush
