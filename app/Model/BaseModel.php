<?php namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\MessageBag;

class BaseModel extends Model {

	var $errors;

	function setErrors(MessageBag $errors)
	{
		$this->errors = $errors;
	}

	function setError(MessageBag $errors)
	{
		$this->errors = $errors;
	}

	function getError()
	{
		return $this->errors;
	}

	function getErrors()
	{
		return $this->errors;
	}
}
