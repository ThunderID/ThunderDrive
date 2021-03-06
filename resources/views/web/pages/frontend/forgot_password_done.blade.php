@section('html.title')
	Thunder Drive - Organization Cloud Drive
@show

@section('nav')
<!-- Navigation -->
	<nav class="navbar navbar-custom navbar-fixed-top" role="navigation">
		<div class="container">
			<div class="navbar-header">
				<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-main-collapse">
					<i class="fa fa-bars"></i>
				</button>
				<a class="navbar-brand page-scroll" href="#page-top">
					<i class="fa fa-bolt"></i>  <span class="light">Thunder</span> Drive
				</a>
			</div>

			<!-- Collect the nav links, forms, and other content for toggling -->
			<div class="collapse navbar-collapse navbar-right navbar-main-collapse">
				<ul class="nav navbar-nav">
					<!-- Hidden li included to remove active class from about link when scrolled up past about section -->
					<li class="hidden"><a href="#page-top"></a></li>
					<li><a class="page-scroll" href="{{route('web.home')}}">Home</a></li>
					<li><a class="page-scroll" href="{{route('web.signin.get')}}">Sign In</a></li>
					<li><a class="page-scroll" href="{{route('web.register.get')}}">Register</a></li>
				</ul>
			</div>
			<!-- /.navbar-collapse -->
		</div>
		<!-- /.container -->
	</nav>
@show

@section('content')
	<!-- Intro Header -->
	<header class="intro nobg">
		<div class="intro-body">
			<div class="container">
				<div class="row">
					<div class="col-md-8 col-md-offset-2">
						<h1 class="brand-heading">Hi, {{$user->name}}</h1>

						<p>We have sent a reset password link to your email. Please follow that link to reset your password</p>

						{{-- <a href='{{route("web.reset_password.get", ["id" => $user->id, "key" => Hash::make($user->key)])}}'>reset</a> --}}

						<p><a href="{{route('web.signin.get')}}" class='btn btn-default btn-lg'>Sign In</a></p>

					</div>
				</div>
			</div>
		</div>
	</header>
@show