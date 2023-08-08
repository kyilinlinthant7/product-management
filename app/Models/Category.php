<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Category;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    protected $table = 'categories';

    protected $fillable = [
        'name', 'image',
    ];

	public function products()
	{
		return $this->hasMany(Product::class);
	}

	use softDeletes;
}
