<!DOCTYPE html>
<html lang="">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<meta name="description" content="">
		<meta name="author" content="">

		<title>@yield('html.title', '[html.title]')</title>

		<link href="{{elixir('assets/css/web_me.min.css')}}" rel="stylesheet">

		<!-- Custom Fonts -->
		<link href="{{asset('assets/font-awesome/css/font-awesome.min.css')}}" rel="stylesheet" type="text/css">
		<link href='http://fonts.googleapis.com/css?family=Raleway:400,200|Montserrat' rel='stylesheet' type='text/css'>

		<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
		<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
		<!--[if lt IE 9]>
			<script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
			<script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
		<![endif]-->

	</head>
	<body>

		@yield('nav', '[nav]')


		<div class='wrapper'>
			<div class="container-fluid">
				<div class="row mb-lg">
					<div class="hidden-xs hidden-sm col-md-12 col-lg-12">
						@include('web.pages.me.components.active_page_buttons')
					</div>
					<div class="col-xs-12 hidden-md hidden-lg text-center">
						@include('web.pages.me.components.active_page_buttons')
					</div>
				</div>
				
				<div class="row">
					<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
						@yield('content', '[content]')
					</div>
				</div>
			</div>
		</div>
		
		<footer class='text-center'>
			<p class='text-center'>Copyright @ <a href="http://thunderlab.id">ThunderLab</a> - Version 0.1.0</p>
		</footer>
		<!-- jQuery -->
		<script src="{{elixir('assets/js/web_me.min.js')}}"></script>

		@yield('js')
	</body>
</html>
