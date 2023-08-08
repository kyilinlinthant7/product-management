<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Category;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
	protected $table = 'products';

    protected $fillable = [
        'name', 'description', 'category_id', 'price', 'image', 'received_date',
    ];

	public function category()
    {
        return $this->belongsTo(Category::class);
    }

	use softDeletes;
}
