<div class="panel panel-default">
	<div class="panel-heading">
		<a href='{{route("web.me.organization.category.form", ['org_id' => $organization->id])}}' class='pull-right text-primary'><i class='fa fa-plus'></i></a>
		<h3 class="panel-title">Categories</h3>
	</div>
	<div class="panel-body">
		<div class="panel-max500 panel-scroll">
			<?php $initial = ''; ?>

			@forelse ($organization->categories as $x)
				@if (!str_is(strtolower($initial), strtolower(substr($x->title, 0, 1))))
					<?php $initial = strtoupper(substr($x->title, 0, 1)); ?>
					<div class='alert-default text-center'>{{$initial}}</div>
				@endif

				<li class='menu {{$filters["category"] == $x->id ? "active" : ""}}'>
					@if ($x->user_id == Auth::id())
						<a href='{{route("web.me.organization.category.form", ["org_id" => $organization->id, "cat_id" => $x->id])}}' class='pull-right text-default'><i class='fa fa-edit'></i></a>
					@endif
					<a href='{{route("web.me.organization.file.index", array_merge(["org_id" => $organization->id], (array) $filters, ["category" => $x->id] ))}}' class='text-default'>{{$x->title}}</a>
				</li>
			@empty
				No Category
			@endforelse
		</div>
	</div>
	<div class="panel-footer">
		<div class='text-center'>
			{{$organization->categories->count()}} categories
		</div>
	</div>
</div>