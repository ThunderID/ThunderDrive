<?php namespace App;

use Illuminate\Auth\Authenticatable;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;

class User extends BaseModel implements AuthenticatableContract, CanResetPasswordContract {

	use Authenticatable, CanResetPassword;

	protected $table 		= 'users';
	protected $fillable 	= ['name', 'email', 'password', 'reset_password', 'is_registered'];
	protected $hidden 		= ['password', 'remember_token'];

	static function boot()
	{
		parent::boot();
		Static::observe( new UserObserver );
	}

	// ------------------------------------------------------------------
	// Relationship
	// ------------------------------------------------------------------
	public function files()
	{
		return $this->hasMany(__NAMESPACE__ . '\File')->latest();
	}

	public function organizations()
	{
		return $this->belongsToMany(__NAMESPACE__ . '\Organization')->orderBy('name');
	}

	public function owns()
	{
		return $this->hasMany(__NAMESPACE__ . '\Organization');
	}

	public function categories()
	{
		return $this->hasMany(__NAMESPACE__ . '\Category');
	}

	// ------------------------------------------------------------------
	// Search
	// ------------------------------------------------------------------
	function scopeEmail($q, $v = null)
	{
		if (!$v)
		{
			return $q;
		}
		else
		{
			return $q->where('email','like',$v);
		}
	}

	function scopeUnregistered($q)
	{
		return $q->where('is_registered',false);
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
		return $this->humanize_file_size($size);
	}

	function FilesizeInOrganization($org_id)
	{
		$size = $this->files()->where('organization_id', '=', $org_id)->sum('size');
		return $this->humanize_file_size($size);
	}

	function humanize_file_size($size)
	{
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
