@section('html.title')
	ThunderDrive - Me
@stop

@section('nav')
	@include('web.pages.me.components.nav')
@stop

@section('content')
	@if (!Auth::user()->name)
		<div class="jumbotron vcenter text-center">
			<div class="container">
				<h4>Please fill in your name to proceed</h4>
				<form class='form' action='{{route("web.me.register.post")}}' method='post'>
					<input type='hidden' name='_token' value="{{csrf_token()}}">
					<div class="row">
						<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 col-xs-offset-3">
							<p><input type='text' name='name' value='' class='form-control' autofocus></p>
							<br/>
							<p ><button type='submit' class="btn btn-default btn-lg">Submit</button></p>
						</div>
					</div>
				</form>
			</div>
		</div>
	@endif
@stop