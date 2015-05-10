@section('html.title')
	ThunderDrive - Me
@stop

@section('nav')
	@include('web.pages.me.components.nav')
@stop

@section('content')

	<div class="row">
		<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-center">
			<h1>
				{{$organization->name}}
				<p>
					<div class="btn-group">
						<a href="{{route('web.me.organization.show', 			['org_id' => $organization->id])}}" class="btn btn-default {{$mode == 'dashboard' || $mode == '' ? 'active' : ''}}">Dashboard</a>
						<a href="{{route('web.me.organization.file.index', 		['org_id' => $organization->id])}}" class="btn btn-default {{$mode == 'files' ? 'active' : ''}}">FILES</a>
						@if ($organization->owner->id == Auth::user()->id)
							<a href="{{route('web.me.organization.user.index', 	['org_id' => $organization->id])}}" class="btn btn-default {{$mode == 'users' ? 'active' : ''}}">USERS</a>
							<a href="{{route('web.me.organization.edit', 		['org_id' => $organization->id])}}" class="btn btn-default {{$mode == 'edit' ? 'active' : ''}}">EDIT</a>
						@endif
					</div>
				</p>
			</h1>
		</div>
	</div>

	@yield('organization.content', '[organization.content]')
@stop