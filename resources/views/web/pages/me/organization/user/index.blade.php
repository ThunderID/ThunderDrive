@section('organization.content')
	<div class="row">
		<div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-md-offset-3 text-center">
			@include('web.alerts')
			<form action="{{route('web.me.organization.user.store', ['org_id' => $organization->id])}}" method="POST">
				<input type="hidden" name="_token" value="{{csrf_token()}}">
				<p>
					Add/Invite user by email
					<input type='email' name='emails' value='' class='form-control text-center' autofocus placeholder='email'>
				</p>
			</form>
		</div>
	</div>

	<div class='row'>
		<div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-md-offset-3">

			<table class="table table-hover">
				<thead>
					<tr>
						<th>Name</th>
						<th class='text-right'># of Files</th>
						<th class='text-right'>File Size</th>
						<th></th>
					</tr>
				</thead>
				<tbody>
					@foreach ($users as $user)	
						<tr>
							<td> {{$user->name}} ({{$user->email}})</td>
							<td class='text-right'>{{number_format($user->files->count())}} files</td>
							<?php 
								$file_size = $user->FileSizeInOrganization($organization->id);
							?>
							<td class='text-right'>{{number_format($file_size['size'],2)}} {{$file_size['unit']}} </td>
							<td width='3'><a href='{{route("web.me.organization.user.remove", ['org_id' => $organization->id, 'user_id' => $user->id])}}' alt='remove' class='text-danger'><i class='fa fa-close'></i></a> </td>
						</tr>
					@endforeach
				</tbody>
			</table>

			</div>
		</div>
	</div>
@stop