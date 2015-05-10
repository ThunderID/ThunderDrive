@section('html.title')
	ThunderDrive - Me
@stop

@section('nav')
	@include('web.pages.me.components.nav')
@stop

@section('content')
	<div class="jumbotron vcenter text-center">
		<div class="container">
			@if ($organization->id)
				<h4>Please update your organization detail below</h4>
			@else
				@if (!Auth::user()->organizations->count())
					<h4>Please create your first organization here</h4>
				@else
					<h4>Create new organization</h4>
					<p>Please enter your organization detail below</p>
				@endif
			@endif


			<form class='form' action='{{route("web.me.organization.store")}}' method='post'>
				<input type='hidden' name='_token' value="{{csrf_token()}}">
				<div class="row">
					<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 col-xs-offset-3">
						@include('web.alerts')

						<p><input type='text' name='name' value='' class='form-control' autofocus></p>
						<br/>
						<p><button type='submit' class="btn btn-default btn-lg">Submit</button></p>
					</div>
				</div>
			</form>
		</div>
	</div>

@stop