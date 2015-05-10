<?php namespace App\Http\Controllers\Web;

use Route, Auth;

class Controller extends \App\Http\Controllers\Controller {

	protected $layout;

	public function __construct()
	{
		if (!str_is('web.me*', Route::getCurrentRoute()->getName()))
		{
			$this->layout = view('web.template');
		}
		else
		{
			$this->layout = view('web.template_me');
		}
	}

}
