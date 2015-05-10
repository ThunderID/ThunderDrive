<?php namespace App\Commands;

use App\Commands\Command;
use Input, File, Validator;

use Illuminate\Contracts\Bus\SelfHandling;

class UploadMedia extends Command implements SelfHandling {

	protected $input_name;
	protected $destination_path;
	protected $filename;

	/**
	 * Create a new command instance.
	 *
	 * @return void
	 */
	public function __construct($input_name, $destination_path, $filename = null)
	{
		//
		$this->input_name = $input_name;
		$this->destination_path = str_finish($destination_path, '/');
		$this->filename = $filename;
	}

	/**
	 * Execute the command.
	 *
	 * @return void
	 */
	public function handle()
	{
		if ($_FILES[$this->input_name]['error'] === UPLOAD_ERR_OK) 
		{ 
			$rules[$this->input_name] 	= ['required', 'max:2000000'];
			$input[$this->input_name]	= Input::file($this->input_name);

			$validation = Validator::make($input, $rules);
			if ($validation->fails())
			{
				dd($validation->messages());
			}

			if (Input::hasFile($this->input_name))
			{
				if (!$this->filename)
				{
					$this->filename = Input::file($this->input_name)->getClientOriginalName();
				} 

				File::makeDirectory($this->destination_path, 0777, true, true);

				if (Input::file($this->input_name)->move($this->destination_path, $this->filename))
				{
					return $this->destination_path . $this->filename;
				}
				else
				{
					return false;
				}
			}
			else
			{
				return false;
			}
		}
		else
		{
			return $_FILES[$this->input_name]['error'];
		}
	}

}
