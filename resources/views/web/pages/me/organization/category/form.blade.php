@section('organization.content')
	<div class="container">
		<div class="row">
			<div class="col-xs-8 col-sm-8 col-md-8 col-lg-8 col-xs-offset-2 text-center">
				@if ($category->id)
					<h4 class='text-center'>EDIT CATEGORY</h4>
				@else
					<h4 class='text-center'>CREATE CATEGORY</h4>
				@endif

				@include('web.alerts')
				
				Please enter category detail below
				<br>

				@if ($category->id)
					{!! Form::open(['url' => route('web.me.organization.category.store', ['org_id' => $organization->id, 'cat_id' => $category->id]), 'method' => 'post']) !!}
				@else
					{!! Form::open(['url' => route('web.me.organization.category.store', ['org_id' => $organization->id]), 'method' => 'post']) !!}
				@endif

					{!! Form::text('title', $category->title, ['class' => 'form-control text-center', 'autofocus' => 'autofocus']) !!}

					<br/>
					{!! Form::submit('Submit', ['class' => 'btn btn-default']) !!}

					@if ($category->id)
						<a class='btn btn-default' href="{{route('web.me.organization.category.delete', ['org_id' => $organization->id, 'cat_id' => $category->id])}}">Delete</a>
					@endif

				{!! Form::close() !!}
			</div>
		</div>
	</div>
@stop