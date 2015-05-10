<?php namespace App;

use Illuminate\Support\MessageBag;
use Validator, Hash;

class UserObserver {
	
	function saving($model)
	{
		$rules['name']		= ['required'];
		$rules['email']		= ['required', 'unique:' . $model->getTable() . ',email,' . $model->id, 'email'];
		$rules['password']	= ['required', 'min:8'];
		$rules['reset_password'] = [];
		$rules['is_registered'] = ['boolean'];

		$user = $model->toArray();
		$user['password'] = $model->password;
		$validator = Validator::make($user, $rules);

		if ($validator->fails())
		{
			$model->setErrors($validator->messages());
			return false;
		}
		else
		{
			if (Hash::needsRehash($model->password))
			{
				$model->password = Hash::make($model->password);
			}
		}
	}

	function deleting($model)
	{
		if ($model->owns->count())
		{
			$model->setErrors(new MessageBag(['deleting' => 'Cannot delete user. User has organizations']));
		}

		if ($model->files->count())
		{
			$model->setErrors(new MessageBag(['deleting' => 'Cannot delete user. User has files']));
		}
	}
}