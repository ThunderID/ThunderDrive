<?php namespace App;

class Organization extends BaseModel {

	protected $table 		= 'organizations';
	protected $fillable 	= ['name', 'package'];

	static function boot()
	{
		parent::boot();
		Static::observe( new OrganizationObserver );

	}

	// ------------------------------------------------------------------
	// Relationship
	// ------------------------------------------------------------------
	public function users()
	{
		return $this->belongsToMany(__NAMESPACE__ . '\User')->orderBy('name');
	}

	public function owner()
	{
		return $this->belongsTo(__NAMESPACE__ . '\User', 'user_id');
	}

	public function categories()
	{
		return $this->hasMany(__NAMESPACE__ . '\Category')->orderBy('title');
	}

	public function files()
	{
		return $this->hasMany(__NAMESPACE__ . '\File')->orderBy('title');
	}

	public function latest_files()
	{
		return $this->hasMany(__NAMESPACE__ . '\File')->latest();
	}

	// ------------------------------------------------------------------
	// ACCESSOR
	// ------------------------------------------------------------------
	function getTotalUsersAttribute()
	{
		return $this->users()->count();
	}

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

	function getTotalCategoriesAttribute()
	{
		return $this->categories()->count();
	}
}
