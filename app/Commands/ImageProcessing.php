<?php namespace App\Commands;

use App\Commands\Command;
use Image, Exception, Input, File;

use Illuminate\Contracts\Bus\SelfHandling;


class ImageProcessing extends Command implements SelfHandling {

	/**
	 * Create a new command instance.
	 *
	 * @return void
	 */
	public function __construct($original_file_path, $destination_path, $filename = null, $new_width = null, $new_height = null, $is_proportion = true)
	{
		//
		$this->original_file_path 	= $original_file_path;
		$this->destination_path 	= str_finish($destination_path, '/');
		$this->filename				= $filename;
		$this->new_height 			= $new_height;
		$this->new_width 			= $new_width;

		if ($new_width)
		{
			if (!is_numeric($new_width))
			{
				throw new Exception("Width must be integer");
			}
		}

		if ($new_height)
		{
			if (!is_numeric($new_height))
			{
				throw new Exception("Height must be integer");
			}
		}

		if ($is_proportion)
		{
			$this->is_proportion = true;
		}
		else
		{
			$this->is_proportion = false;
		}
	}

	/**
	 * Execute the command.
	 *
	 * @return void
	 */
	public function handle()
	{
		//
		if (file_exists($this->original_file_path))
		{
			$image = Image::make($this->original_file_path);

			$is_proportion = $this->is_proportion;


			// resize image
			if ($this->new_height & $this->new_width)
			{
				$image = $image->resize($this->new_width, $this->new_height, function($constraint) use ($is_proportion) {
															if ($is_proportion)
															{
																$constraint->aspectRatio();
															}
														});
			}
			elseif ($this->new_width)
			{
				$image = $image->widen($this->new_width, function($constraint) use ($is_proportion) {
															if ($is_proportion)
															{
																$constraint->aspectRatio();
															}
														});
			}
			elseif ($this->new_height)
			{
				$image = $image->heighten($this->new_height, function($constraint) use ($is_proportion) {
															if ($is_proportion)
															{
																$constraint->aspectRatio();
															}
														});
			}

			// prepare directory
			File::makeDirectory($this->destination_path, 0755, true, true);

			// prepare filename
			if (!$this->filename)
			{
				$this->filename = basename($this->original_file_path);
			}

			$i = 0;
			$filename = $this->filename;
			while (file_exists($this->destination_path . $filename)) {
				$i++;
				$filename = $i . '-' . $this->filename;
			}
			$this->filename = $filename;

			// save image
			if ($image->save($this->destination_path . $this->filename))
			{
				// preepare return value
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

}
