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
						<h1 class="brand-heading">REGISTER</h1>

						@include('web.alerts')

						<form method='post' action='{{route("web.register.post")}}'>
							<input type='hidden' name="_token" value="{{csrf_token()}}">
							<div class="row">

								<div class="col-xs-8 col-sm-8 col-md-8 col-lg-8 col-xs-offset-2" style='margin-bottom:15px;'>
									<input type='text' name='name' class='form-control text-center' placeholder='name' style='font-family:Montserrat;'>
								</div>

								<div class="col-xs-8 col-sm-8 col-md-8 col-lg-8 col-xs-offset-2" style='margin-bottom:15px;'>
									<input type='text' name='email' class='form-control text-center' placeholder='email' style='font-family:Montserrat;'>
								</div>

								<div class="col-xs-8 col-sm-8 col-md-8 col-lg-8  col-xs-offset-2">
									<input type='password' name='password' class='form-control  text-center' placeholder='password' style='font-family:Montserrat;'>
								</div>

								<div class="col-xs-8 col-sm-8 col-md-8 col-lg-8  col-xs-offset-2" style='margin-top:15px;'>
									<input type='password' name='password_confirmation' class='form-control  text-center' placeholder='password confirmation' style='font-family:Montserrat;'>
								</div>
							</div>
							<br/>
							<div class="row">
								<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
									<button type='submit' class='btn btn-lg btn-default'></i> REGISTER </button>
								</div>
							</div>
						</form>

					</div>
				</div>
			</div>
		</div>
	</header>
@show