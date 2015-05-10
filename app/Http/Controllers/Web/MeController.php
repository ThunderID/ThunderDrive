<?php namespace App\Http\Controllers\Web;

use Input, Auth, Validator, Hash;

class MeController extends Controller {

	public function getIndex()
	{
		if (Auth::user()->organizations->count())
		{
			$this->layout->page = view('web.pages.me.home');
		}
		else
		{
			$this->layout->page = view('web.pages.me.organization.create');
		}
		return $this->layout;		
	}

	public function change_password()
	{
		$this->layout->page = view('web.pages.me.change_password');

		return $this->layout;
	}

	public function post_change_password()
	{
		$input = Input::all();

		// rules
		$rules['old_password'] = 'required';
		$rules['password'] = 'required|confirmed';

		// validation
		$validator = Validator::make($input, $rules);
		if ($validator->fails())
		{
			return redirect()->back()->withErrors($validator);
		}
		else
		{
			// check old password
			if (Hash::check($input['old_password'], Auth::user()->password))
			{
				$user = Auth::user();
				$user->password = $input['password'];

				if ($user->save())
				{
					return redirect()->back()->with('alert_success', 'Your password has been updated');
				}
				else
				{
					return redirect()->back()->with($user->getErrors());
				}
			}
			else
			{
				return redirect()->back()->withErrors('Invalid password');
			}
		}
	}
}
