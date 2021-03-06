<nav class="navbar navbar-default" role="navigation">
	<!-- Brand and toggle get grouped for better mobile display -->
	<div class="navbar-header">
		<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
			<span class="sr-only">Toggle navigation</span>
			<span class="icon-bar"></span>
			<span class="icon-bar"></span>
			<span class="icon-bar"></span>
		</button>
		<a class="navbar-brand" href="{{route('web.me')}}">
			<h4><i class='fa fa-bolt'></i> <span class='light'>Thunder</span><strong>Drive</strong><sup class='light small'>beta</sup></h4>
		</a>
	</div>

	<!-- Collect the nav links, forms, and other content for toggling -->
	<div class="collapse navbar-collapse navbar-ex1-collapse">
		<ul class="nav navbar-nav navbar-right">
			<li class="dropdown">
				<a href="#" class="dropdown-toggle" data-toggle="dropdown">Hi, {{Auth::user()->name}} <b class="caret"></b></a>
				<ul class="dropdown-menu">
					<li><a href="{{route('web.me.change_password')}}">Change Password</a></li>
					<li><a href="{{route('web.signout')}}">Sign Out</a></li>
				</ul>
			</li>
		</ul>
	</div><!-- /.navbar-collapse -->
</nav>

