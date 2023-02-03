<!DOCTYPE html>
<html lang="en">

	<!-- begin::Head -->
	<head>
		<base href="">
		<meta charset="utf-8" />
		<title>E-Smart | Dashboard</title>
		@include("layout-css-scriptjs.css")
		@stack('css')
	</head>
	<!-- end::Head -->

	<!-- begin::Body -->
	<body class="kt-page-content-white kt-quick-panel--right kt-demo-panel--right kt-offcanvas-panel--right kt-header--fixed kt-header-mobile--fixed kt-subheader--enabled kt-subheader--transparent kt-page--loading">
		<style>
            .page-item.active .page-link{
                z-index: 1;
            }
        </style>
		<!-- begin:: Header Mobile -->
		@include('layout-karyawan.header-mobile')
		<!-- end:: Header Mobile -->

		<!-- begin::Page -->
		<div class="kt-grid kt-grid--hor kt-grid--root">
			<div class="kt-grid__item kt-grid__item--fluid kt-grid kt-grid--ver kt-page">
				<div class="kt-grid__item kt-grid__item--fluid kt-grid kt-grid--hor kt-wrapper" id="kt_wrapper">

					<!-- begin:: Header -->
					@include('layout-karyawan.header')
					<!-- End:: Header -->

					<div class="kt-container  kt-grid__item kt-grid__item--fluid kt-grid kt-grid--hor kt-grid--stretch position-relative pt-3">
						@yield('content')
					</div>

					<!-- begin:: Footer -->
					@include('layout-karyawan.footer')
					<!-- end:: Footer -->

				</div>
			</div>
		</div>
		<!-- End::Page -->

		<!-- begin::Scrolltop -->
		<div id="kt_scrolltop" class="kt-scrolltop">
			<i class="fa fa-arrow-up"></i>
		</div>
		<!-- end::Scrolltop -->

		<!-- begin::Global Config(global config for global JS sciprts) -->
		@include('layout-css-scriptjs.script')
		<!-- end::Global Config(global config for global JS sciprts) -->

		@stack('scriptjs')
	</body>
	<!-- end::Body -->
</html>
