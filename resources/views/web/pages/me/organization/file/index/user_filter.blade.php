<div class="panel panel-default">
	<div class="panel-heading">
		@if ($organization->owner->id == Auth::id())
			<a href='{{route("web.me.organization.user.index", ['org_id' => $organization->id])}}' class='pull-right text-primary'><i class='fa fa-plus'></i></a>
		@endif
		<h3 class="panel-title">USERS</h3>
	</div>
	<div class="panel-body">
		<div class="panel-max500 panel-scroll">
			<?php $initial = ''; ?>

			@forelse ($organization->users as $x)
				@if (!str_is(strtolower($initial), strtolower(substr($x->name, 0, 1))))
					<?php $initial = strtoupper(substr($x->name, 0, 1)); ?>
					<div class='initial text-center'>{{$initial}}</div>
				@endif
				<li class='menu {{$filters["user"] == $x->id ? "active" : ""}}'>
					<a href='{{route("web.me.organization.file.index", array_merge(["org_id" => $organization->id], (array) $filters, ["user" => $x->id] ))}}' class='text-default'>{{$x->name}}</a>
				</li>
			@empty
				No User
			@endforelse
		</div>
	</div>
	<div class="panel-footer">
		<div class='text-center'>
			{{$organization->users->count()}} users
		</div>
	</div>
</div>

