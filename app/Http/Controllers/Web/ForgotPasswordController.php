<?php namespace App\Http\Controllers\Web;

use Input, Auth, Session, Validator, Mail, Hash, App;
use \App\User;

class ForgotPasswordController extends Controller {

	// ---------------------------------------------
	// HANDLE LOGIN
	// ---------------------------------------------
	public function index()
	{
		$this->layout->page = view('web.pages.frontend.forgot_password');
		return $this->layout;
	}

	
	public function post()
	{
		$input = Input::all();

		$validation = Validator::make($input, ['email' => 'required|email']);
		
		if ($validation->fails())
		{
			return redirect()->back()->withErrors($validation->messages());
		}
		else
		{
			$user = User::email($input['email'])->first();

			if (!$user)
			{
				return redirect()->back()->withErrors(new MessageBag(['user' => $input['email'] . ' has not been registered to our service']));
			}
			else
			{
				// set reset password
				$key = str_random(10);
				$user->reset_password = $key;
				$user->save();

				// email
				Mail::send('mail.reset_password', ['user' => $user], function($message) use ($user){
					$message->to($user->email, $user->name)->subject('[ThunderDrive] Your reset password link');
				});

				// success
				return redirect()->route('web.forgot-password.done')->with('user', $user);
			}
		}
	}

	public function done()
	{
		if (!Session::has('user'))
		{
			return redirect()->route('web.signin.get');
		}
		else
		{
			$this->layout->page = view('web.pages.frontend.forgot_password_done')->with('user', Session::get('user'));
			return $this->layout;
		}
	}

	public function reset()
	{
		$id 	= Input::get('id');
		$key	= Input::get('key');

		$user = User::findorfail($id);
		if (Hash::check($user->key, $key))
		{
			$this->layout->page = view('web.pages.frontend.reset_password')->with('user', $user)->with('key', $key);
			return $this->layout;
		}
		else
		{
			return App::abort(404);
		}
	}

	public function reset_post()
	{
		$id 	= Input::get('id');
		$key	= Input::get('key');
		
		$user = User::findorfail($id);
		if (Hash::check($user->key, $key))
		{
			$validation = Validator::make(Input::only('password', 'password_confirmation'), ['password' => 'required|confirmed']);
			if ($validation->fails())
			{
				return redirect()->back()->withErrors($validation);
			}
			else
			{
				$user->reset_password = '';
				$user->password = Input::get('password');
				if (!$user->save())
				{
					return redirect()->back()->withErrors($user->getErrors());
				}
				else
				{
					return redirect()->route('web.reset_password.done')->with('user', $user);
				}
			}
		}
		else
		{
			return App::abort(404);
		}
	}

	public function reset_done()
	{
		if (!Session::has('user'))
		{
			return redirect()->route('web.signin.get');
		}
		else
		{
			$this->layout->page = view('web.pages.frontend.reset_password_done')->with('user', Session::get('user'));
			return $this->layout;
		}		
	}

}
