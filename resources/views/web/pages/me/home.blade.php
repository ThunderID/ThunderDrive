@section('html.title')
	ThunderDrive - Me
@stop

@section('nav')
	@include('web.pages.me.components.nav')
@stop

@section('content')
	<div class="row">
		<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-center">
			<h1>My Dashboard</h1>
		</div>
	</div>

	<div class="row">
		@foreach (Auth::user()->organizations as $organization)
			<div class="col-xs-12 col-sm-6 col-md-4 col-lg-3">
				<div class="panel panel-default">
					<div class="panel-heading">
						<h3 class="panel-title">{{$organization->name}}</h3>
					</div>
					<div class="panel-body">
						<div class='row'>
							<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 mb-lg">
								<div class='text-xxl pull-right'>
									{{number_format($organization->total_users)}}
									<small class='text-md no-margin'>Users</small>
								</div>
								<i class='fa fa-users text-huge text-muted'></i>
							</div>

							<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 mb-lg">
								<div class='text-xxl pull-right'>
									{{number_format($organization->total_files)}}
									<small class='text-md no-margin'>FILES</small>
								</div>
								<i class='fa fa-file text-huge text-muted'></i>
							</div>

							<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 mb-lg">
								<div class='text-xxl pull-right'>
									{{number_format($organization->total_file_size_human['size'])}}
									<small class='text-md no-margin'>{{$organization->total_file_size_human['unit']}}</small>
								</div>
								<i class='fa fa-dashboard text-huge text-muted'></i>
							</div>

							<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
								<div class='text-xxl pull-right'>
									{{number_format($organization->total_categories)}}
									<small class='text-md no-margin'>CATEGORIES</small>
								</div>
								<i class='fa fa-folder text-huge text-muted'></i>
							</div>
						</div>
					</div>
					<div class="panel-footer">
						<a href="{{route('web.me.organization.show', ['org_id' =>$organization->id])}}" class='btn btn-default-inverse btn-block'>OPEN</a>
					</div>
				</div>
			</div>
		@endforeach
	</div>

@stop