@section('organization.content')
	<div class='text-center'>
		@if ($organization->id)
			<form class='form' action='{{route("web.me.organization.update", ['org_id' => $organization->id])}}' method='post'>
		@else
			<form class='form' action='{{route("web.me.organization.create")}}' method='post'>
		@endif

			<input type='hidden' name='_token' value="{{csrf_token()}}">
			<div class="row">
				<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 col-xs-offset-3">

					@include('web.alerts')

					<p>
						Organization name:
						<input type='text' name='name' value='{{Input::old('name', $organization->name)}}' class='form-control' autofocus>
					</p>
					<br/>
					<p><button type='submit' class="btn btn-default btn-lg">Submit</button></p>
				</div>
			</div>
		</form>
	</div>
@stop