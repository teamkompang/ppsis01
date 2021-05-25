<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>
    <script src="https://code.jquery.com/jquery-1.12.4.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>  
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.js"></script>
    <script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js"></script>

    <!-- switchery css -->
    <link rel="stylesheet" type="text/css" href="{{ asset('src/plugins/switchery/switchery.min.css') }}">
	<!-- bootstrap-tagsinput css -->
	<link rel="stylesheet" type="text/css" href="{{ asset('src/plugins/bootstrap-tagsinput/bootstrap-tagsinput.css') }}">
	<!-- bootstrap-touchspin css -->
	<link rel="stylesheet" type="text/css" href="{{ asset('src/plugins/bootstrap-touchspin/jquery.bootstrap-touchspin.css') }}">

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    
    
	<!-- CSS -->
	<link rel="stylesheet" type="text/css" href="{{ asset('vendors/styles/core.css') }}">
	<link rel="stylesheet" type="text/css" href="{{ asset('vendors/styles/icon-font.min.css') }}">
	<link rel="stylesheet" type="text/css" href="{{ asset('src/plugins/datatables/css/dataTables.bootstrap4.min.css') }}">
	<link rel="stylesheet" type="text/css" href="{{ asset('src/plugins/datatables/css/responsive.bootstrap4.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('vendors/styles/style.css') }}">
    
    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-119386393-1"></script>


    
    <style>
        .footer {
        position: fixed;
        left: 0;
        bottom: 0;
        width: 100%;
        background-color: white;
        color: white;
        text-align: center;
        }
    </style>


    <script>
		window.dataLayer = window.dataLayer || [];
		function gtag(){dataLayer.push(arguments);}
		gtag('js', new Date());

		gtag('config', 'UA-119386393-1');
	</script>
</head>
<body>
    <!-- <div class="pre-loader">
		<div class="pre-loader-box">
			<div class="loader-logo"><img src="{{ asset('img/logo1.png') }}" alt=""></div>
			<div class='loader-progress' id="progress_div">
				<div class='bar' id='bar1'></div>
			</div>
			<div class='percent' id='percent1'>0%</div>
			<div class="loading-text">
				Loading...
			</div>
		</div>
    </div> -->
    
    @include('layouts.topbar')

    @include('layouts.sidebar')
  
            @yield('content')

    <!-- @include('layouts.footer') -->

   
    <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <script src="{{ asset('vendors/scripts/core.js') }}" defer></script>
	<script src="{{ asset('vendors/scripts/script.min.js') }}" defer></script>
    <!-- <script src="{{ asset('vendors/scripts/dashboard.js') }}"defer></script> -->
    <script src="{{ asset('vendors/scripts/process.js') }}"defer></script>
	<script src="{{ asset('vendors/scripts/layout-settings.js') }}"defer></script>
	<!-- <script src="{{ asset('src/plugins/apexcharts/apexcharts.min.js') }}"defer></script> -->
	<script src="{{ asset('src/plugins/datatables/js/jquery.dataTables.min.js') }}"defer></script>
	<script src="{{ asset('src/plugins/datatables/js/dataTables.bootstrap4.min.js') }}"defer></script>
	<script src="{{ asset('src/plugins/datatables/js/dataTables.responsive.min.js') }}"defer></script>
	<script src="{{ asset('src/plugins/datatables/js/responsive.bootstrap4.min.js') }}"defer></script>
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>

    <!-- switchery js -->
	<script src="{{ asset('src/plugins/switchery/switchery.min.js') }}"defer></script>
	<!-- bootstrap-tagsinput js -->
	<script src="{{ asset('src/plugins/bootstrap-tagsinput/bootstrap-tagsinput.js') }}"defer></script>
	<!-- bootstrap-touchspin js -->
	<script src="{{ asset('src/plugins/bootstrap-touchspin/jquery.bootstrap-touchspin.js') }}"defer></script>
	<script src="{{ asset('vendors/scripts/advanced-components.js') }}"defer></script>

    <script>
   function toggleZoomScreen() {
       document.body.style.zoom = "10%";
   } 
</script>
	
    @stack('scripts')
</body>
</html>
