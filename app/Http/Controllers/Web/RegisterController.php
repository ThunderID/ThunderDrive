<?php namespace App\Http\Controllers\Web;

use Input, Auth, Session, Validator;
use \App\User;

class RegisterController extends Controller {

	// ---------------------------------------------
	// HANDLE LOGIN
	// ---------------------------------------------
	public function index()
	{
		$this->layout->page = view('web.pages.frontend.register');
		return $this->layout;
	}

	
	public function post()
	{
		$input = Input::all();

		$validation = Validator::make($input, ['password' => 'confirmed']);
		
		if ($validation->fails())
		{
			return redirect()->back()->withErrors($validation->messages());
		}
		else
		{
			$user = User::email(Input::get('email'))->unregistered()->first();
			if (!$user)
			{
				$user = new User;
			}
			$user->fill($input);
			$user->is_registered = true;
			if (!$user->save())
			{
				return redirect()->back()->withErrors($user->getErrors());
			}
			else
			{
				return redirect()->route('web.register.done')->with('user', $user);
			}
		}
	}

	function registered()
	{
		if (!Session::has('user'))
		{
			return redirect()->route('web.register.get');
		}
		else
		{
			$this->layout->page = view('web.pages.frontend.registered')->with('user', Session::get('user'));
			return $this->layout;
		}
	}

}
