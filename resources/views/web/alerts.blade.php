@if ($errors->count())
	<div class="alert alert-danger">
		<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
		@foreach ($errors->all() as $error)
			{{$error}}
		@endforeach
	</div>
@endif

<?php $alert_type = ['alert_success', 'alert_danger', 'alert_info', 'alert_warning']; ?>

@foreach ($alert_type as $x)
	@if (Session::has($x))
		<div class="alert {{str_replace('_','-',$x)}}">
			<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
			{{Session::get($x)}}
		</div>
	@endif
@endforeach