@section('html.title')
	ThunderDrive - Me
@stop

@section('nav')
	@include('web.pages.me.components.nav')
@stop

@section('content')
	<div class="jumbotron vcenter text-center">
		<div class="container">
			<h2>{{$org->name}}</h2>

			@if ($org->users)
				<p>Current team members</p>
				<p>
				@foreach ($org->users as $user)
					<a href="{{route('web.me.organization.users.remove.get', ['id' => $org->id, 'user_id' => $user->id])}}" class='btn btn-default' title='click to delete'><i class='fa fa-times-circle'></i> {{$user->email}}</a>
				@endforeach
				</p>
			@endif


			<br/>
			<p>Please add emails to be included in this organization (separate with commas)</p>


			<form class='form' action='{{route("web.me.organization.users.form.post", ['org_id' => $org->id])}}' method='post'>
				<input type='hidden' name='_token' value="{{csrf_token()}}">
				<div class="row">
					<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 col-xs-offset-3">
						<p><input type='text' name='emails' value='' class='form-control' autofocus></p>
						<br/>
						<p><button type='submit' class="btn btn-default btn-lg">Submit</button></p>
					</div>
				</div>
			</form>


			<p>
				@if ($org->users->count() > 1)
					<a class='small light' href="{{route('web.me')}}">Done <i class='fa fa-angle-right'></i></a>
				@else
					<a class='small light' href="{{route('web.me')}}">Skip <i class='fa fa-angle-right'></i></a>
				@endif
			</p>
		</div>
	</div>

@stop