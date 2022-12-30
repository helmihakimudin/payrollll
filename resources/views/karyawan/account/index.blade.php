@extends('layout-karyawan.base',[
	'pages'=>'my info',
	'subpages'=>'my info',
])
@section('content')
<div class="kt-body kt-grid__item kt-grid__item--fluid kt-grid kt-grid--hor kt-grid--stretch" id="kt_body">
    <div class="kt-content  kt-grid__item kt-grid__item--fluid kt-grid kt-grid--hor" id="kt_content">
        <div class="kt-container  kt-grid__item kt-grid__item--fluid">
            <div class="row pt-3">
				<div class="col-lg-3 col-aside">
                    <!--begin:: Portlet-->
                    <div class="kt-portlet">
                        <div class="kt-portlet__body">
                            <!--begin::Widget -->
                            <div class="kt-widget kt-widget--user-profile-4">
                                <div class="kt-widget__head">
                                    <div class="kt-widget__media">
                                        <img class="kt-widget__img kt-hidden" src="{{ asset('demo10/assets/media/users/300_21.jpg')}}" alt="image">
                                        <div class="kt-widget__pic kt-widget__pic--success kt-font-success kt-font-boldest kt-font-light kt-hidden-">
                                            {{$initial}}
                                        </div>
                                    </div>
                                    <div class="kt-widget__content">
                                        <div class="kt-widget__section">
                                            <a href="#" class="kt-widget__username">
                                                {{Auth::guard('emp')->user()->full_name}}
                                            </a>
                                            <div class="kt-widget__button">
                                                @if(Auth::guard("emp")->user()->is_active ==1)
                                                <button type="button" class="btn btn-label-success btn-sm">Active</button>
                                                @else
                                                <button type="button" class="btn btn-label-warning btn-sm">Non Active</button> 
                                                @endif
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
                                    @include('karyawan.account.partial.aside')
                                    <!-- end:: Aside Menu -->
                                </div>
                            </div>
                            <!--end::Widget -->
                        </div>
                    </div>
                    <!--end:: Portlet-->
				</div>
				<div class="col-lg-9 col-card-content">
					@yield('content-account')
				</div>
			</div>
        </div>
    </div>
</div>

@endsection
@push('scriptjs')

@endpush
