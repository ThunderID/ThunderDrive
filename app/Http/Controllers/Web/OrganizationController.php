<?php namespace App\Http\Controllers\Web;

use Input, Auth, App, Illuminate\Support\MessageBag, Mail, Route, Session, Image, Exception;
use \App\Organization;
use \App\User;
use \App\File;
use \App\Category;
use App\Commands\UploadMedia;
use App\Commands\ImageProcessing;

class OrganizationController extends Controller {

	var $org_id;
	var $organization;

	public function __construct()
	{
		parent::__construct();

		$route_param = Route::current()->parameters();
		$this->org_id = $route_param['org_id'];

		// get organizations
		$this->organization = Auth::user()->organizations->find($this->org_id);
		
		$this->layout->page = view('web.pages.me.organization.index')
												->with('organization', $this->organization);
	}

	// ------------------------------------------------------------------------------------------
	// ORGANIZATION
	// ------------------------------------------------------------------------------------------
	public function show()
	{
		$this->layout->page->organization_content = view('web.pages.me.organization.index.dashboard')->with('organization', $this->organization);

		return $this->layout;
	}

	public function create()
	{
		
		$this->layout->page = view('web.pages.me.organization.create')->with('organization', $this->organization);

		return $this->layout;		
	}

	public function edit()
	{
		$org = Organization::findorfail($this->org_id);

		$this->layout->page->mode = 'edit';

		$this->layout->page->organization_content = view('web.pages.me.organization.edit')->with('organization', $this->organization);

		return $this->layout;		
	}

	public function store($org = null)
	{
		if (!$org)
		{
			$org = new Organization;
		}

		$org->fill(Input::only('name'));
		$org->owner()->associate(Auth::user());

		if (!$org->save())
		{
			return redirect()->back()->withInput()->withErrors($org->getErrors());
		}
		else
		{
			foreach ($org->users as $x)
			{
				$users[] = $x->id;
			}
			$users[] = Auth::id();
			$org->users()->sync($users);

			return redirect()->route('web.me.organization.show', ['org_id' => $org->id]);
		}
	}

	public function update()
	{
		$org = Organization::findorfail($this->org_id);

		return $this->store($org);
	}

	// ------------------------------------------------------------------------------------------
	// MANAGE USERS
	// ------------------------------------------------------------------------------------------
	public function user_index()
	{
		$organization = $this->organization;
		$users = $this->organization->users()->orderBy('name')->get();
		$users->load(['files' => function($query) use ($organization) {
						$query->inOrganization($this->organization->id);
					}]);

		$this->layout->page->mode = 'users';
		$this->layout->page->organization_content = view('web.pages.me.organization.user.index')->with('organization', $this->organization)
																								->with('users', $users);

		return $this->layout;
	}

	public function user_store()
	{
		if (!$this->org_id)
		{
			App::abort(404);
		}

		// get org
		$org = Organization::findorfail($this->org_id);

		// validate if org is mine
		if ($org->owner->id != Auth::id())
		{
			return App::abort(404);
		}


		// post user
		if (Input::get('emails'))
		{
			$emails = explode(',',Input::get('emails'));
			foreach ($emails as $email)
			{
				$user = User::email($email)->first();

				if (!$user)
				{
					$user = new User;
					$user->fill(['name' => $email, 'email' => $email, 'password' => str_random(8)]);
					if (!$user->save())
					{
						return redirect()->back()->withErrors($user->getErrors());
					}
				}

				if (!$user->organizations->contains($org->id))
				{
					Mail::send('mail.invite', ['invited' => $user, 'from' => Auth::user(), 'org' => $org], function($message) use ($user) {
						$message->to($user->email, $user->email);
					});
					$user->organizations()->attach($org->id);
				}
				else
				{
					return redirect()->back()->withErrors(new MessageBag(['alreadyAdded' => 'User ' . $user->email . ' is already in the organization']));
				}
			}
		}

		// generate view
		return redirect()->back();
	}

	public function user_remove()
	{
		// get org
		$org = Organization::findorfail($this->org_id);

		// get user
		$user_id = Input::get('user_id');
		$user = User::findorfail($user_id);

		// validate auth
		if (!$org->users->contains('id', $user_id))
		{
			return redirect()->back()->withErrors('User ' . $user->email . ' is not part of this team');
		}		
		else
		{
			if ($org->owner->id == $user_id)
			{
				return redirect()->back()->withErrors('User ' . $user->email . ' cannot be deleted as this user is the owner of the organization');
			}
			elseif ($user_id == Auth::id())
			{
				return redirect()->back()->withErrors('You cannot delete yourself from the organization');
			}
			else
			{
				$org->users()->detach($user_id);
				return redirect()->back()->with('alert_success', 'User ' . $user->email . ' has been removed from ' . $org->name . ' organization');
			}
		}
	}

	// ------------------------------------------------------------------------------------------
	// MANAGE CATEGORIES
	// ------------------------------------------------------------------------------------------
	public function category_form($org_id, $cat_id = null)
	{
		if (!is_null($cat_id))
		{
			$category = $this->organization->categories->find($cat_id);
			if (!$category)
			{
				App::abort(404);
			}

			// check if the user is the owner of the category or the admin
			if ($category->user_id != Auth::id() && $category->organization->user_id != Auth::id())
			{
				App::abort(404);
			}
		}


		// 
		$this->layout->page->mode = 'files';
		$this->layout->page->organization_content = view('web.pages.me.organization.category.form')
														->with('organization', $this->organization)
														->with('category', $category);
		return $this->layout;		
	}

	public function category_store($org_id, $cat_id = null)
	{
		if ($cat_id)
		{
			$category = $this->organization->categories->find($cat_id);
			if (!$category)
			{
				App::abort(404);
			}
		}
		else
		{
			$category = new Category;
		}

		$category->fill(Input::only('title'));
		$category->user_id = Auth::id();
		$category->organization_id = $this->organization->id;

		if ($category->save())
		{
			return redirect()->route('web.me.organization.file.index',['org_id' => $this->organization->id])->with('alert_success', 'Category ' . $category->title . ' has been stored');
		}
		else
		{
			return redirect()->back()->withInput()->withErrors($category->getErrors());
		}
	}

	public function category_delete($org_id, $cat_id)
	{
		$category = $this->organization->categories->find($cat_id);
		if (!$category)
		{
			App::abort(404);
		}

		// 
		$this->layout->page->mode = 'files';
		$this->layout->page->organization_content = view('web.pages.me.organization.category.delete')
														->with('organization', $this->organization)
														->with('category', $category);
		return $this->layout;		
	}

	public function category_delete_post($org_id, $cat_id)
	{
		$category = $this->organization->categories->find($cat_id);
		if (!$category)
		{
			App::abort(404);
		}

		if ($category->delete())
		{
			return redirect()->route('web.me.organization.file.index',['org_id' => $this->organization->id])->with('alert_success', 'Category ' . $category->title . ' has been deleted');
		}
		else
		{
			return redirect()->back()->withInput()->withErrors($category->getErrors());
		}
	}


	// ------------------------------------------------------------------------------------------
	// MANAGE FILES
	// ------------------------------------------------------------------------------------------
	public function file_index()
	{
		// handle filters
		$filters = Input::only('category', 'user');

		$files = File::inOrganization($this->organization->id)
						->byUser($filters['user'])
						->inCategory($filters['category'])
						->latest()
						->with('user', 'category')
						->paginate();

		
		$this->layout->page->mode = 'files';
		
		$this->layout->page->organization_content = view('web.pages.me.organization.file.index')->with('organization', $this->organization)
																		->with('filters', $filters)
																		->with('files', $files);
		return $this->layout;
	}

	public function file_create(File $file = null)
	{
		// if there is not category -> force create category
		if (!$this->organization->categories->count())
		{
			return redirect()->route('web.me.organization.category.form', ['org_id' => $this->organization->id])->withErrors('Please create a category before start uploading files');
		}

		$this->layout->page->mode = 'files';
		
		$this->layout->page->organization_content = view('web.pages.me.organization.file.create')->with('organization', $this->organization)
																		->with('file', $file);
		
		return $this->layout;
	}

	public function file_edit()
	{
		$route_param = Route::current()->parameters();
		$file_id = $route_param['id'];
		$file = $this->organization->files->find($file_id);
		if (!$file)
		{
			App::abort(404);
		}

		// only can edit own file
		if ($file->user_id != Auth::id())
		{
			App::abort(404);
		}

		$this->layout->page->mode = 'files';
		
		$this->layout->page->organization_content = view('web.pages.me.organization.file.create')->with('organization', $this->organization)
																		->with('file', $file);
		
		return $this->layout;
	}

	public function file_store($org_id, $file_id = null)
	{
		if (!is_null($file_id))
		{
			$file = $this->organization->files->find($file_id);

			if (!$file)
			{
				App::abort(403, 'Unauthorized user');
			}

			// only can edit own file
			if ($file->user_id != Auth::id())
			{
				App::abort(404);
			}
		}
		else
		{
			$file = new File;
		}

		if (Input::get('is_public'))
		{
			$destination_path = 'file/public/' . $this->organization->id . '/' . Auth::id() . '/' . date("Y/m/d/H/");
		}
		else
		{
			$destination_path = 'file/public/' . $this->organization->id . '/' . Auth::id() . '/' . date("Y/m/d/H/");
		}

		$uploaded_file = $this->dispatch(new UploadMedia('file', $destination_path));

		if ($uploaded_file == UPLOAD_ERR_INI_SIZE)
		{
			return redirect()->back()->withErrors('File size exceed max size, max file size is ' . ini_get('upload_max_filesize'));
		}
		elseif ($uploaded_file == UPLOAD_ERR_FORM_SIZE)
		{
			return redirect()->back()->withErrors('File size exceed max size, max file size is ' . Input::get('MAX_FILE_SZE'));
		}
		elseif ($uploaded_file == UPLOAD_ERR_PARTIAL)
		{
			return redirect()->back()->withErrors('Fail to uploade the file (partially uploaded)');
		}
		elseif ($uploaded_file == UPLOAD_ERR_NO_FILE)
		{
			return redirect()->back()->withErrors('Please select the file');
		}
		elseif ($uploaded_file == UPLOAD_ERR_NO_TMP_DIR)
		{
			return redirect()->back()->withErrors('Invalid server configurtion');
		}
		elseif ($uploaded_file == UPLOAD_ERR_CANT_WRITE)
		{
			return redirect()->back()->withErrors('File permission problem');
		}
		elseif ($uploaded_file == UPLOAD_ERR_EXTENSION)
		{
			return redirect()->back()->withErrors('Invalid extension');
		}
		elseif ($uploaded_file !== false)
		{
			if (!is_null($uploaded_file))
			{
				$file->url	= $uploaded_file;
			}
		}
		elseif (!$file->url)
		{
			return redirect()->back()->withInput()->withErrors('File is required');
		}

		$file->title			= Input::get('title');
		$file->is_public 		= true; #Input::get('is_public') ? true : false;
		$file->user_id 			= Auth::id();
		$file->organization_id 	= $this->organization->id;
		$file->category_id 		= Input::get('category');

		if ($file->save())
		{
			return redirect()->route('web.me.organization.file.index', ['org_id' => $this->organization->id])->with('alert_success', 'File ' . $file->title . ' has been stored successfully');
		}
		else
		{
			return redirect()->back()->withInput()->withErrors($file->getErrors());
		}
	}

	public function file_delete($org_id, $file_id)
	{
		$file = $this->organization->files->find($file_id);
		if (!$file)
		{
			App::abort(404);
		}

		// only can delete own file
		if ($file->user_id != Auth::id())
		{
			App::abort(404);
		}

		$this->layout->page->mode = 'files';
		
		$this->layout->page->organization_content = view('web.pages.me.organization.file.delete')
																->with('organization', $this->organization)
																->with('file', $file);
		return $this->layout;
	}

	public function file_delete_post($org_id, $file_id)
	{
		$file = $this->organization->files->find($file_id);
		if (!$file)
		{
			App::abort(404);
		}

		// only can edit own file
		if ($file->user_id != Auth::id())
		{
			App::abort(404);
		}

		if ($file->delete())
		{
			return redirect()->route('web.me.organization.file.index', ['org_id' => $this->organization->id])->with('alert_success', 'File ' . $file->title . ' has been deleted successfully');
		}
		else
		{
			return redirect()->back()->with($file->getErrors());
		}
	}

	public function file_clone($org_id, $file_id)
	{
		$file = $this->organization->files->find($file_id);
		if (!$file)
		{
			App::abort(404);
		}

		if (!str_is('image/*', $file->mime))
		{
			return redirect()->route('web.me.organization.file.index', ['org_id' => $this->organization->id])->withErrors('Unable to clone non image file');
		}

		$this->layout->page->mode = 'files';
		
		$this->layout->page->organization_content = view('web.pages.me.organization.file.clone')->with('organization', $this->organization)
																		->with('file', $file);
		
		return $this->layout;
	}

	public function file_clone_post($org_id, $file_id)
	{
		$file = $this->organization->files->find($file_id);
		if (!$file)
		{
			App::abort(404);
		}

		if (!str_is('image/*', $file->mime))
		{
			return redirect()->route('web.me.organization.file.index', ['org_id' => $this->organization->id])->withErrors('Unable to clone non image file');
		}

		// handle uploaded file
		if (Input::get('is_public'))
		{
			$destination_path = 'file/public/' . $this->organization->id . '/' . Auth::id() . '/' . date("Y/m/d/H/");
			@mkdir($destination_path);
		}
		else
		{
			$destination_path = 'file/public/' . $this->organization->id . '/' . Auth::id() . '/' . date("Y/m/d/H/");
			@mkdir($destination_path);
		}

		$img = $this->dispatch(new ImageProcessing($file->url, $destination_path, null, Input::get('width'), Input::get('height'), Input::get('proportion')));
		if ($img !== false)
		{
			$cloned_file = new File;
			$cloned_file->fill(array_except($file->toArray(), ['id']));
			$cloned_file->organization_id 		= $file->organization_id;
			$cloned_file->title 				= Input::get('title');
			$cloned_file->user_id 				= Auth::id();
			$cloned_file->category_id 			= Input::get('category');
			$cloned_file->is_public 			= true; #(Input::get('is_public') ? true : false);
			$cloned_file->url 					= $img;
			$cloned_file->original_id 			= $file->id;
			if (!$cloned_file->save())
			{
				return redirect()->back()->withInput()->withErrors($cloned_file->getErrors());
			}
			else
			{
				return redirect()->route('web.me.organization.file.index', ['org_id' => $org_id])->with('alert_success', 'File ' . $cloned_file->title . ' has been cloned and modified');
			}
		}
		else
		{
			return redirect()->back()->withInput()->withErrors("Invalid file size");
		}
	}
}
