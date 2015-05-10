@section('organization.content')
	<div class="container">
		<div class="row">
			<div class="col-xs-8 col-sm-8 col-md-8 col-lg-8 col-xs-offset-2 text-center">
				<h4 class='text-center'>DELETE CATEGORY</h4>

				@include('web.alerts')
				
				<p>Are you sure to delete this category</p>

				{!! Form::open(['url' => route('web.me.organization.category.delete_post', ['org_id' => $organization->id, 'cat_id' => $category->id]), 'method' => 'post']) !!}

					<a class='btn btn-default' href="{{route('web.me.organization.file.index', ['org_id' => $organization->id])}}">Cancel</a>
					{!! Form::submit('Yes', ['class' => 'btn btn-default']) !!}

				{!! Form::close() !!}
			</div>
		</div>
	</div>
@stop