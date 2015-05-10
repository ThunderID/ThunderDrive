<?php namespace App;

use Illuminate\Support\MessageBag;
use Validator, Hash;

class CategoryObserver {
	
	function saving($model)
	{
		// validation
		$rules['title']				= ['required', 'unique:' . $model->getTable() . ',title,'.($model->id ? $model->id : "NULL"). ',id,organization_id,' . $model->organization_id];
		$rules['organization_id'] 	= ['required'];

		$validator = Validator::make($model->toArray(), $rules);

		if ($validator->fails())
		{
			$model->setErrors($validator->messages());
			return false;
		}
	}

	function deleting($model)
	{
		// has files
		if ($model->files->count())
		{
			$model->setErrors(new MessageBag(['deleting' => 'Unable to delete category. It has files']));
			return false;
		}
	}
}