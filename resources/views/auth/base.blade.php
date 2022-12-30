<!DOCTYPE html>
<html lang="en" >
    <!--begin::Head-->
    <head><base href="../../../../">
        <meta charset="utf-8"/>
        <title>E-Smart | Login</title>
        <meta name="description" content="Login page example"/>
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no"/>
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <link href="{{ asset('demo10/assets/css/pages/login/login-3.css')}}" rel="stylesheet" type="text/css" />
		@include("layout-css-scriptjs.css")

        <link rel="shortcut icon" href="{{ asset('/favicon/favicon.ico')}}"/>
    </head>
    <!--end::Head-->
   	<!-- begin::Body -->
	<body class="kt-page-content-white kt-quick-panel--right kt-demo-panel--right kt-offcanvas-panel--right kt-header--fixed kt-header-mobile--fixed kt-subheader--enabled kt-subheader--transparent kt-page--loading">
        @yield("content")
		
		<!-- begin::Global Config(global config for global JS sciprts) -->
		@include('layout-css-scriptjs.script')
		<!-- end::Global Config(global config for global JS sciprts) -->
        
		<!--begin::Page Scripts(used by this page) -->
		<script src="{{ asset('demo10/assets/js/pages/custom/login/login-general.js')}}" type="text/javascript"></script>
		<!--end::Page Scripts -->
	</body>
	<!-- end::Body -->
</html>