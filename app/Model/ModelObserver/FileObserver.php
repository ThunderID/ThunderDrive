<?php namespace App;

use Illuminate\Support\MessageBag;
use Validator, Hash;
use Image;

class FileObserver {

	
	function saving($model)
	{
		if (!$model->key)
		{
			$model->file_key = str_random(50);
		}

		// 
		$rules['url']				= ['required'];
		$rules['title']				= ['required'];
		$rules['mime']				= ['required', 'in:image/jpg,image/jpeg,image/bmp,image/png,image/gif,application/pdf'];
		$rules['size']				= ['required', 'numeric'];
		$rules['width']				= ['numeric'];
		$rules['height']			= ['numeric'];
		$rules['is_public']			= ['boolean'];
		$rules['organization_id'] 	= ['required', 'integer', 'exists:categories,id'];
		$rules['user_id'] 			= ['required', 'integer', 'exists:users,id'];
		$rules['category_id'] 		= ['required', 'integer', 'exists:categories,id'];
		$rules['file_key'] 			= ['required', 'min:40', 'unique:' . $model->getTable() . ',file_key'];
		$rules['original_id'] 		= ['integer', 'exists:' . $model->getTable() . ',id'];


		$validator = Validator::make($model->toArray(), $rules);

		if ($validator->fails())
		{
			$model->setErrors($validator->messages());
			return false;
		}

	}

	function updated($model)
	{
		if (!str_is($model->url, $model->getOriginal('url')))
		{
			unlink($model->getOriginal('url'));
		}
	}

	function deleted($model)
	{
		unlink($model->url);
	}
}