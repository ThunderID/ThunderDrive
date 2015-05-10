@section('organization.content')
	<div class='container'>
		<div class="row">
			<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
				<div class="panel panel-default">
					<div class="panel-body">
						<div class='text-xxl pull-right'>
							{{number_format($organization->total_users)}}
							<small class='text-md no-margin'>Users</small>
						</div>
						<i class='fa fa-users text-huge text-muted'></i>
					</div>
				</div>
			</div>

			<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
				<div class="panel panel-default">
					<div class="panel-body">
						<div class='text-xxl pull-right'>
							{{number_format($organization->total_files)}}
							<small class='text-md no-margin'>FILES</small>
						</div>
						<i class='fa fa-file text-huge text-muted'></i>
					</div>
				</div>
			</div>

			<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
				<div class="panel panel-default">
					<div class="panel-body">
						<div class='text-xxl pull-right'>
							{{number_format($organization->total_file_size_human['size'], 2)}}
							<small class='text-md no-margin'>{{$organization->total_file_size_human['unit']}}</small>
						</div>
						<i class='fa fa-dashboard text-huge text-muted'></i>
					</div>
				</div>
			</div>

			<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
				<div class="panel panel-default">
					<div class="panel-body">
						<div class='text-xxl pull-right'>
							{{number_format($organization->categories->count())}}
							<small class='text-md no-margin'>CATEGORIES</small>
						</div>
						<i class='fa fa-folder text-huge text-muted'></i>
					</div>
				</div>
			</div>
		</div>

		<div class="row">
			<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
				<div class="panel panel-default">
					<!-- Default panel contents -->
					<div class="panel-body">
						<h4>LATEST FILE</h4>
					</div>

					<!-- Table -->
					<table class="table">
						<thead>
							<tr>
								<th>File</th>
								<th>By</th>
								<th>Category</th>
								<th class='text-right'>Type</th>
								<th class='text-right'>Size</th>
							</tr>
						</thead>
						<tbody>
							@foreach ($organization->latest_files()->with('user', 'category')->take(25)->get() as $file)
								<tr>
									<td>{{$file->title}}</td>
									<td>{{$file->user->name}}</td>
									<td>{{$file->category->title}}</td>
									<td class='text-right'>
										{{$file->mime}}
									</td>
									<td class='text-right'>
										{{number_format($file->size_human['size'], 2)}}
										{{$file->size_human['unit']}}
									</td>
								</tr>
							@endforeach
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
@stop