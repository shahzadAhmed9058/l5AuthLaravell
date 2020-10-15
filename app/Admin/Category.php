<?php

namespace App\Admin;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = ['title'];

    public function subCategories()
    {
        return $this->hasMany(SubCategory::class);
    }

}
