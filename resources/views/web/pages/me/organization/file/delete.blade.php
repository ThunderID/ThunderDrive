@section('organization.content')
	<div class='container'>
		<div class="row">
			<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
			</div>
			<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-center">
				<h3>DELETE FILE</h3>
				
				<div class="row">
					<div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-md-offset-3">
						@include('web.alerts')
						<div class="well text-left">
							<div class='row'>
								<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
									{!! HTML::image($file->fullurl, '', ['class' => 'img-responsive']) !!}
								</div>

								<p><div class="clearfix"></div></p>

								<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
									<span class=''><i class='fa fa-user'></i> {{$file->user->name}}</span>
								</div>
								<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
									@if (str_is('image/*', $file->mime))
										<span class=''><i class='fa fa-file-image-o'></i> {{$file->mime}}</span>
									@endif
								</div>
								<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
									<span class=''><i class='fa fa-dashboard'></i> {{$file->sizeStr}}</span>
								</div>
								<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
									<span class=''><i class='fa fa-calendar'></i> {{\Carbon\Carbon::parse($file->created_at)->format('d-M-Y [H:i]')}} </span>
								</div>

								<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-center mt-lg">
									{!! Form::open(['url' => route('web.me.organization.file.delete.post', ['org_id' => $organization->id, 'file_id' => $file->id]), 'method' => 'post']) !!}
									<button type='submit' class='btn btn-default'>CONFIRM DELETE</button>
									{!! Form::close() !!}
								</div>

							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
@stop