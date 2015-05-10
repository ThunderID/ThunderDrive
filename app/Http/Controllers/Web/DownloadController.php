<?php namespace App\Http\Controllers\Web;

use Input, Auth, App, Response;
use \App\Organization;
use \App\File;

class DownloadController extends Controller {

	var $org_id;
	var $organization;

	public function __construct()
	{

	}

	// ------------------------------------------------------------------------------------------
	// DOWNLOAD
	// ------------------------------------------------------------------------------------------
	public function download($file_id, $file_key)
	{
		$file = File::findorfail($file_id);

		if (!$file->is_public)
		{
			App::abort(404);
		}
		else
		{
			if (str_is($file->file_key, $file_key))
			{
				return Response::download($file->relativeurl, $file->title);
			}
			else
			{
				App::abort(404);
			}
		}
	}
}
