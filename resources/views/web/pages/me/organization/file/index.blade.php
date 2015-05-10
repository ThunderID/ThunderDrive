@section('organization.content')
	<div class="row">
		<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
			@include('web.alerts')
		</div>
		<div class="col-xs-12 col-sm-12 col-md-4 col-lg-3">
			@include('web.pages.me.organization.file.index.category_filter')
			@include('web.pages.me.organization.file.index.user_filter')
		</div>
		<div class="col-xs-12 col-sm-12 col-md-8 col-lg-9">
			<a href='{{route("web.me.organization.file.create", ["org_id" => $organization->id])}}' class='btn btn-default pull-right'><i class='fa fa-plus-circle'></i></a>
			<h3>FILES
				<small>
					@if ($filters['category'])
						<a href='{{route("web.me.organization.file.index", array_merge(["org" => $organization->id], array_only($filters, ["user"])))}}' class='label label-default mr-sm'>
							<i class='fa fa-close'></i>
							Category: {{$organization->categories->find($filters['category'])->title}}
						</a>
					@endif

					@if ($filters['user'])
						<a href='{{route("web.me.organization.file.index", array_merge(["org" => $organization->id], array_only($filters, ["category"])))}}' class='label label-default'>
							<i class='fa fa-close'></i>
							User: {{$organization->users->find($filters['user'])->name}}
						</a>
					@endif
				</small>
			</h3>

			<div class="row text-left">
				@forelse ($files as $file)
					<div class="col-xs-12 col-sm-6 col-md-6 col-lg-4 ">
						<div class="panel panel-default">
							<div class="panel-body">
								<div class="thumbnail col-xs-12 col-sm-12 col-md-12 col-lg-12">
									@if (str_is('image/*', $file->mime))
										<img data-src="#" class='' src="{{asset($file->fullurl)}}">
									@elseif (str_is('application/pdf', $file->mime))
										<img data-src="#" class='' src="{{asset($file->fullurl)}}">
									@endif
								</div>
							</div>
							<div class="panel-footer">
								@if ($file->width)
									<span class="label label-primary text-light">
										{{$file->width}}<small></small> x {{$file->height}} </span>
									</span>
								@endif
								<br/><strong>{{$file->title}}</strong>

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
												@if ($file->user_id == Auth::id())
													<li><a href="{{ route('web.me.organization.file.delete', ['org_id' => $organization->id, 'id' => $file->id]) }}" >Delete</a></li>
													<li><a href="{{ route('web.me.organization.file.edit', ['org_id' => $organization->id, 'id' => $file->id]) }}" >Edit</a></li>
												@endif
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
					</div>
				@empty
					<div class='text-center alert alert-default col-xs-12'>
						NO FILES
					</div>
				@endforelse
			</div>


			<div class='text-center'>
				{!! $files->appends($filters)->render() !!}
			</div>
		</div>
	</div>

	<div class="modal fade" id="file_url_modal" tabindex="-1">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
					<h4 class="modal-title">FILE URL</h4>
				</div>
				<div class="modal-body">
					<img src='' class='modal_thumbnail img-responsive'>
					<p>Please use Ctrl+C to copy the URL of this image</p>
					{!! Form::text('file_url', '', ['class' => 'form-control']) !!}
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
				</div>
			</div><!-- /.modal-content -->
		</div><!-- /.modal-dialog -->
	</div><!-- /.modal -->
@stop

@section('js')
	<script src="{{asset('assets/plugins/ZeroClipboard/ZeroClipboard.min.js')}}"></script>
	<script src="{{asset('assets/plugins/toastmessage/javascript/jquery.toastmessage.js')}}"></script>
	{!! HTML::style(asset('assets/plugins/toastmessage/resources/css/jquery.toastmessage.css')) !!}
	<script>
		var client = new ZeroClipboard($('.zeroclipboard'));
		client.on( "ready", function( readyEvent ) {
			client.on( "aftercopy", function( event ) {
				$().toastmessage('showSuccessToast', "File URL Copied");
			} );
		});

		$("div#file_url_modal").on('show.bs.modal',function(event) {
			var modal = $(this);
			var btn = event.relatedTarget;
			modal.find('img.modal_thumbnail').attr('src', btn.getAttribute('data-thumbnail-url'));
			modal.find('input[name=file_url]').val(btn.getAttribute('data-url'));
			modal.find('input[name=file_url]').focus();
		});

		$('div#file_url_modal input[name=file_url]').on('focus', function() {
			$(this).select();
		});	

		$("div#file_url_modal").on('shown.bs.modal',function(event) {
			$(this).find('input[name=file_url]').focus();
		});
	</script>
@stop