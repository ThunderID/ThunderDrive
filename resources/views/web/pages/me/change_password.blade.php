@section('html.title')
	ThunderDrive - Me
@stop

@section('nav')
	@include('web.pages.me.components.nav')
@stop

@section('content')
	<div class="jumbotron vcenter text-center">
		<div class="container">
			<h4>Update Password</h4>


			<form class='form' action='{{route("web.me.change_password.post")}}' method='post'>
				<input type='hidden' name='_token' value="{{csrf_token()}}">
				<div class="row">
					<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 col-xs-offset-3">
						@include('web.alerts')

						<p>Please enter your old password<input type='password' name='old_password' value='' class='form-control' placeholder='old password' autofocus></p>
						<p>Please enter your new password (min:8)<input type='password' name='password' value='' class='form-control' placeholder='new password' ></p>
						<p>Please confirm your new password<input type='password' name='password_confirmation' value='' class='form-control' placeholder='new password confirmation' ></p>
						<br/>
						<p><button type='submit' class="btn btn-default btn-lg">Submit</button></p>
					</div>
				</div>
			</form>
		</div>
	</div>

@stop