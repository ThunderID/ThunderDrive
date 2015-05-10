<?php namespace App;

class Category extends BaseModel {

	protected $table 		= 'categories';
	protected $fillable 	= ['title'];

	static function boot()
	{
		parent::boot();
		Static::observe( new CategoryObserver );
	}

	// ------------------------------------------------------------------
	// Relationship
	// ------------------------------------------------------------------
	public function organization()
	{
		return $this->belongsTo(__NAMESPACE__ . '\Organization');
	}

	public function files()
	{
		return $this->hasMany(__NAMESPACE__ . '\File')->latest();
	}

	public function latest_files()
	{
		return $this->hasMany(__NAMESPACE__ . '\File')->latest();
	}

	public function user()
	{
		return $this->belongsTo(__NAMESPACE__ . '\User');
	}

	// ------------------------------------------------------------------
	// Accessor
	// ------------------------------------------------------------------
	function getTotalFilesAttribute()
	{
		return $this->files()->count();
	}

	function getTotalFileSizeAttribute()
	{
		return $this->files()->sum('size');
	}

	function getTotalFileSizeHumanAttribute()
	{
		$size = $this->total_file_size;

		if ($size >= pow(1024, 4))
		{
			$result['size'] = $size/pow(1024,4);
			$result['unit']	= "TB";
		}
		elseif ($size >= pow(1024, 3))
		{
			$result['size'] = $size/pow(1024,3);
			$result['unit']	= "GB";
		}
		elseif ($size >= pow(1024, 2))
		{
			$result['size'] = $size/pow(1024,2);
			$result['unit']	= "MB";
		}
		elseif ($size >= pow(1024, 1))
		{
			$result['size'] = $size/pow(1024,1);
			$result['unit']	= "KB";
		}
		else
		{
			$result['size'] = $size;
			$result['unit']	= "B";
		}

		return $result;
	}

}
