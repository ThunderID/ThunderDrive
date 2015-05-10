<?php namespace App\Http\Controllers\Web;

use Input, Auth, Illuminate\Support\MessageBag;
use \App\User;

class LoginController extends Controller {

	// ---------------------------------------------
	// HANDLE LOGIN
	// ---------------------------------------------
	public function index()
	{
		$this->layout->page = view('web.pages.frontend.login');
		return $this->layout;
	}

	
	public function signin()
	{
		$credentials = Input::only('email', 'password');
		if (Auth::attempt($credentials))
		{
			return redirect()->route('web.me');
		}
		else
		{
			return redirect()->back()->withErrors(new MessageBag(['login' => 'Invalid Username & Password']));
		}
	}


	public function signout()
	{
		Auth::logout();
		return redirect()->route('web.home');
	}
}
