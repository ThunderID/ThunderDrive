@section('organization.content')
	<div class='container'>
		<div class="row">
			<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
			</div>
			<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-center">
				<h3>CLONE &amp; MODIFY</h3>
				
				@include('web.alerts')
				
				{!! Form::open(['url' => route('web.me.organization.file.clone.post', ['org_id' => $organization->id, 'file_id' => $file->id]), 'method' => 'post', 'files' => true ]) !!}
				<div class="row">
					<div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
						<div class="well text-left">
							@if ($file->id)
								<strong>ORIGINAL</strong>
								<p>{!! HTML::image($file->fullurl, $file->title, ['class' => 'img-responsive img-thumbnail'])!!}</p>
							@endif

							<h4>
								{{$file->title}}
								<br/><small>{{$file->category->title}}</small>
							</h4>

							<div class="row">
									<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
										<span class='text-sm'><i class='fa fa-user'></i> {{$file->user->name}} </span>
									</div>
									<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
										@if (str_is('image/*', $file->mime))
											<span class='text-sm'><i class='fa fa-file-image-o'></i> {{$file->mime}}</span>
										@elseif (str_is('application/pdf', $file->mime))
											<span class='text-sm'><i class='fa fa-file-pdf-o'></i> {{$file->mime}}</span>
										@endif
									</div>
									<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
										<span class='text-sm'><i class='fa fa-dashboard'></i> {{number_format($file->size_human['size'], 2)}} {{$file->size_human['unit']}}</span>
									</div>
									<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
										<span class='text-sm'><i class='fa fa-calendar'></i> {{\Carbon\Carbon::parse($file->created_at)->format('d-M-Y [H:i]')}} </span>
									</div>


									<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-center mb-md">
										<br/>

										<div class="btn-group">
											<button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
												Action <span class="caret"></span>
											</button>
											<ul class="dropdown-menu" role="menu">
												<li><a href="{{ route('web.me.organization.file.delete', ['org_id' => $organization->id, 'id' => $file->id]) }}" >Delete</a></li>
												<li><a href="{{ route('web.me.organization.file.edit', ['org_id' => $organization->id, 'id' => $file->id]) }}" >Edit</a></li>
												@if (str_is('image/*', $file->mime))
													<li><a href="{{ route('web.me.organization.file.clone', ['org_id' => $organization->id, 'file_id' => $file->id]) }}" >Clone</a></li>
												@else
													<li><a href="javascript:;" class="text-mute disabled">Clone</a></li>
												@endif
												<li class='divider'></li>
												<li class=''><a href='javascript:;' class='zeroclipboard' data-clipboard-text="{{$file->fullurl}}">Copy URL</a></li>
												<li class=''><a data-toggle="modal" href='#file_url_modal' class='show_url' data-thumbnail-url="{{$file->fullurl}}" data-url="{{$file->fullurl}}">Show URL</a></li>
												<li class='divider'></li>
												<li class=''><a href="{{route('web.file.download', ['file_id' => $file->id, 'file_key' => $file->file_key])}}">Download</a></li>
												<li class=''><a href='javascript:;' class='zeroclipboard' data-clipboard-text="{{route('web.file.download', ['file_id' => $file->id, 'file_key' => $file->file_key])}}">Copy Download URL</a></li>
												<li class=''><a data-toggle="modal" href='#file_url_modal' class='show_url' data-thumbnail-url="{{$file->fullurl}}" data-url="{{route('web.file.download', ['file_id' => $file->id, 'file_key' => $file->file_key])}}">Show Download URL</a></li>
											</ul>
										</div>
									</div>
								</div>
						</div>
					</div>
					<div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
						<div class="well text-left">
							<h3>MODIFY</h3>
							<p>
								<div class="row">
									<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
										<strong>New Image Size (previous size: {{$file->width}} x {{$file->height}} px)</strong>
										<div class="input-group">
											{!! Form::text('width', null, ['class' => 'form-control col-xs-4', 'placeholder' => "Width (px)"]) !!}
											<span class="input-group-addon">x</span>
											{!! Form::text('height', null, ['class' => 'form-control col-xs-4', 'placeholder' => "Height (px)"]) !!}
										</div>
									</div>
								</div>
							</p>

							<p>
								<strong>Title</strong>
								{!! Form::text('title', null, ['class' => 'form-control', 'placeholder' => "title"]) !!}
							</p>

							<p>
								<strong>Select Category</strong>
								{!! Form::select('category', $organization->categories->lists('title', 'id'), $file->category->id, ['class' => 'form-control', 'placeholder' => "Enter title"]) !!}
							</p>

							<p>
								<strong>Keep proportion</strong>
								{!! Form::select('proportion', [1 => "Yes", 2 => "No"], null, ['class' => 'form-control', 'placeholder' => "proportion"]) !!}
							</p>

							{{-- <br/>{!! Form::checkbox('is_public', $file->is_public, ['class' => 'form-control', 'placeholder' => "Enter title"]) !!} Set as public file (can be accessed by everyone - outside world) --}}

							<p class='text-center mt-lg'>
								{!! Form::submit('Submit', ['class' => 'btn btn-default']) !!}
							</p>
						</div>
					</div>
				</div>
				{!! Form::close() !!}
			</div>
		</div>
	</div>
@stop