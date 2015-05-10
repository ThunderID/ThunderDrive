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
					<i class="fa fa-bolt"></i>  <span class="light">Thunder</span> Drive <sup class='light small' style='color:#aaa'>beta</sup>
				</a>
			</div>

			<!-- Collect the nav links, forms, and other content for toggling -->
			<div class="collapse navbar-collapse navbar-right navbar-main-collapse">
				<ul class="nav navbar-nav">
					<!-- Hidden li included to remove active class from about link when scrolled up past about section -->
					<li class="hidden"><a href="#page-top"></a></li>
					<li><a class="page-scroll" href="#about">About</a></li>
					<li><a class="page-scroll" href="#features">Features</a></li>
					<li><a class="page-scroll" href="#contact">Contact</a></li>
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
		<header class="intro">
			<div class="intro-body">
				<div class="container">
					<div class="row">
						<div class="col-md-8 col-md-offset-2">
							<h1 class="brand-heading">Thunder <br/>Drive</h1>
							<p class="intro-text">Collaborative Cloud Drive</p>
							<a href="#about" class="btn btn-circle page-scroll">
								<i class="fa fa-bolt animated"></i>
							</a>
						</div>
					</div>
				</div>
			</div>
		</header>

		<!-- About Section -->
		<section id="about" class="container content-section text-center">
			<div class="row">
				<div class="col-lg-8 col-lg-offset-2">
					<h2>About ThunderDrive</h2>
					<p>ThunderDrive is created to provide a file cloud service. Not just an ordinary cloud service, we provide <a href='javascript:;'>Collaborative Cloud Service</a></p>
					<p>Everyone can start their organization and invite users to that organization and collaboratively using the cloud drive</p>
					<p>This service is provided by <a href='http://thunderlab.id'>ThunderLab</a></p>
					<a href="#features" class="btn btn-circle page-scroll">
						<i class="fa fa-bolt animated"></i>
					</a>
				</div>
			</div>
		</section>

		<!-- Contact Section -->
		<section id="features" class="container content-section text-center">
			<div class="row">
				<div class="col-lg-8 col-lg-offset-2">
					<h2>Features</h2>

					{{-- <p>
						<h4 style='margin-bottom:0px !important'>Private or Public File</h4>
						<span style='font-weight:400 !important;font-family:Montserrat'>files can be set as private/public to outside world</span>
					</p> --}}

					<p>
						<h4 style='margin-bottom:0px !important'>Any media file</h4>
						<span style='font-weight:400 !important;font-family:Montserrat'>image, video, music, pdf</span>
					</p>

					<p>
						<h4 style='margin-bottom:0px !important'>Unlimited team member</h4>
						<span style='font-weight:400 !important;font-family:Montserrat'>you are in a full control of your team members</span>
					</p>

					<a href="#contact" class="btn btn-circle page-scroll">
						<i class="fa fa-bolt animated"></i>
					</a>
				</div>
			</div>
		</section>

		<section id="contact" class="container content-section text-center">
			<div class="row">
				<div class="col-lg-8 col-lg-offset-2">
					<h2>Contact Us</h2>

					<p>
						For more information please send us an email 
						<br/><a href="mailto:drive@thunderlab.id" rel='nofollow'>drive@thunderlab.id</a>
					</p>
				</div>
			</div>
		</section>

		<!-- Footer -->
		<footer>
			<div class="container text-center">
				<p>Copyright &copy; ThunderLab.id</p>
			</div>
		</footer>
@show