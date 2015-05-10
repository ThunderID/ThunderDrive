<?php namespace App\Http\Middleware;

use Closure, Route, App, \App\Organization;
use Illuminate\Contracts\Auth\Guard;

class MyOrg {

	/**
	 * The Guard implementation.
	 *
	 * @var Guard
	 */
	protected $auth;
	protected $organization_id;

	/**
	 * Create a new filter instance.
	 *
	 * @param  Guard  $auth
	 * @return void
	 */
	public function __construct(Guard $auth, Route $route)
	{
		$this->auth = $auth;

		// get org_id
		$route_params = Route::current()->parameters();
		$this->organization_id = $route_params['org_id'];
	}

	/**
	 * Handle an incoming request.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \Closure  $next
	 * @return mixed
	 */
	public function handle($request, Closure $next)
	{
		if (!$this->organization_id)
		{
			App::abort(401);
		}

		$org = Organization::find($this->organization_id);
		if ($this->auth->user()->id != $org->owner->id)
		{
			App::abort(401);
		}

		return $next($request);
	}

}
