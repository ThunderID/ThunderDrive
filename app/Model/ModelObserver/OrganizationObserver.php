<?php namespace App;

use Illuminate\Support\MessageBag;
use Validator, Hash;

class OrganizationObserver {
	
	function saving($model)
	{
		$rules['name']			= ['required', 'unique:' . $model->getTable() . ',name,' . ($model->id ? $model->id : "NULL") . ',id,user_id,' . $model->user_id];
		$rules['user_id']		= ['required'];
		$rules['package']		= [''];

		$validator = Validator::make($model->toArray(), $rules);

		if ($validator->fails())
		{
			$model->setErrors($validator->messages());
			return false;
		}
	}
}