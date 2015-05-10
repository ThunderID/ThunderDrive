<?php namespace App\Http\Controllers\Web;

use Input, Auth;
use \App\User;

class HomeController extends Controller {

	public function index()
	{
		$this->layout->page = view('web.pages.frontend.home');
		return $this->layout;
	}
}
