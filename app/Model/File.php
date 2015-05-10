<?php namespace App;

use \Illuminate\Filesystem\Filesystem, Image, Exception;

class File extends BaseModel {

	protected $table 		= 'files';
	protected $fillable 	= ['url', 'title', 'is_public'];

	static function boot()
	{
		parent::boot();
		Static::observe( new FileObserver );
	}

	// ------------------------------------------------------------------
	// Relationship
	// ------------------------------------------------------------------
	public function user()
	{
		return $this->belongsTo(__NAMESPACE__ . '\User');
	}

	public function organization()
	{
		return $this->belongsTo(__NAMESPACE__ . '\Organization');
	}

	public function category()
	{
		return $this->belongsTo(__NAMESPACE__ . '\Category');
	}

	public function original()
	{
		return $this->belongsTo(__NAMESPACE__ . '\File', 'original_id');
	}

	public function clones()
	{
		return $this->hasMany(__NAMESPACE__ . '\File', 'original_id');
	}

	// ------------------------------------------------------------------
	// Organization
	// ------------------------------------------------------------------
	public function scopeInOrganization($q, $org_id = null)
	{
		if (!$org_id)
		{
			return $q;
		}
		else
		{
			return $q->where('organization_id', '=', $org_id);
		}
	}

	public function scopeInCategory($q, $category_id = null)
	{
		if (!$category_id)
		{
			return $q;
		}
		else
		{
			return $q->where('category_id', '=', $category_id);
		}
	}

	public function scopeByUser($q, $user_id = null)
	{
		if (!$user_id)
		{
			return $q;
		}
		else
		{
			return $q->where('user_id', '=', $user_id);
		}
	}

	// ------------------------------------------------------------------
	// MUTATOR
	// ------------------------------------------------------------------
	function setUrlAttribute($value)
	{
		if (!file_exists($value))
		{
			throw new Exception("File does not exist", 1);
		}

		if (!str_is($this->url, $value))
		{
			$this->attributes['url'] = $value;
			$this->attributes['mime'] = Filesystem::mimeType($this->attributes['url']);
			$this->attributes['size'] = Filesystem::size($this->attributes['url']);

			if (str_is('image/*', strtolower($this->attributes['mime'])))
			{
				$tmp_img = Image::make($this->attributes['url']);
				$this->attributes['width'] = $tmp_img->width();
				$this->attributes['height'] = $tmp_img->height();
			}
		}
	}

	// ------------------------------------------------------------------
	// Acccessor
	// ------------------------------------------------------------------
	function getSizeHumanAttribute()
	{
		$size = $this->size;
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

	function getFullurlAttribute()
	{
		return asset($this->url);
	}

	function getRelativeurlAttribute()
	{
		return $this->url;
	}
}