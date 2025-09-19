<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Shop extends Model
{
    protected $fillable = ['code', 'name', 'owner', 'latitude', 'longitude', 'address'];
     // week9
    function products(): BelongsToMany {
return $this->belongsToMany(Product::class)->withTimestamps();
}
}