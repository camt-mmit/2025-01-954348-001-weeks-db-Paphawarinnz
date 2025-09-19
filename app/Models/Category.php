<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Category extends Model
{
    protected $fillable = ['code', 'name','description'];
     // week9
    function products (): Hasmany {
return $this->hasMany(Product::class);
}
}