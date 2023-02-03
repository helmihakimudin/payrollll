<!DOCTYPE html>
<html lang="en" ng-app="DSSApp">
	<!-- begin::Head -->
	<head>
		<base href="">
		<meta charset="utf-8" />
		<meta name="description" content="E-Smart. Think for innovation">
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
		<meta name="csrf-token" content="{{ csrf_token() }}">
		<title>E-Smart | Dashboard</title>
		@include("layout-css-scriptjs.css")
		@stack('css')
	</head>
	<!-- end::Head -->

	<!-- begin::Body -->
	<body class="kt-page-content-white kt-quick-panel--right kt-demo-panel--right kt-offcanvas-panel--right kt-header--fixed kt-header-mobile--fixed kt-subheader--enabled kt-subheader--transparent kt-page--loading">

		<!-- begin:: Header Mobile -->
		@include('layout-admin.header-mobile')
		<!-- end:: Header Mobile -->

		<!-- begin:: Page -->
		<div class="kt-grid kt-grid--hor kt-grid--root">
			<div class="kt-grid__item kt-grid__item--fluid kt-grid kt-grid--ver kt-page">
				<div class="kt-grid__item kt-grid__item--fluid kt-grid kt-grid--hor kt-wrapper  " id="kt_wrapper">

					<!-- begin:: Header -->
					@include('layout-admin.header')
					<!-- End:: Header -->

					<div class="kt-container  kt-grid__item kt-grid__item--fluid kt-grid kt-grid--hor kt-grid--stretch position-relative pt-3">
						@yield('content')
					</div>

					<!-- begin:: Footer -->
					@include('layout-admin.footer')
					<!-- end:: Footer -->

				</div>
			</div>
		</div>
		<!-- end:: Page -->

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
