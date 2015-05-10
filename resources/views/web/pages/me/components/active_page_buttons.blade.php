<div class="btn-group">
	<button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
		Select Organization to Manage <span class="caret"></span>
	</button>
	<ul class="dropdown-menu" role="menu">
		<li><a href="{{route('web.me')}}">My Dashboard</a></li>
		<li class="divider"></li>
		@foreach (Auth::user()->organizations as $org)
			<li><a href="{{route('web.me.organization.show', ['org_id' => $org->id])}}">{{$org->name}}</a></li>
		@endforeach
		<li class="divider"></li>
		<li><a href="{{route('web.me.organization.create')}}">Create New Organization</a></li>
	</ul>
</div>