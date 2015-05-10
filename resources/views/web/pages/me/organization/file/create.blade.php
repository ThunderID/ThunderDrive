@section('organization.content')
	<div class='container'>
		<div class="row">
			<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
			</div>
			<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-center">
				<h3>UPLOAD FILE</h3>
				
				{!! Form::open(['url' => route('web.me.organization.file.store', ['org_id' => $organization->id, 'file_id' => $file->id]), 'method' => 'post', 'files' => true ]) !!}
				<div class="row">
					<div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-md-offset-3">
						@include('web.alerts')
						<div class="well text-left">
							@if ($file->id)
								<strong>Current File</strong>
								<p>{!! HTML::image($file->fullurl, $file->title, ['class' => 'img-responsive img-thumbnail'])!!}</p>
							@else
								<strong>Select file below</strong>
								{{-- {!! Form::text('MAX_FILE_SIZE', ini_get('upload_max_filesize') * 1024) !!} --}}
								{!! Form::file('file') !!}
								<br/>
							@endif


							<p>
								<strong>Enter file title</strong>
								{!! Form::text('title', $file->title, ['class' => 'form-control', 'placeholder' => "Enter title"]) !!}
							</p>

							<p>
								<strong>Select Category</strong>
								{!! Form::select('category', $organization->categories->lists('title', 'id'), $file->category->id, ['class' => 'form-control', 'placeholder' => "Enter title"]) !!}
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