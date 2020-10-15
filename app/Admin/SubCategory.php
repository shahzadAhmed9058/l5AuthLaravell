<?php

namespace App\Admin;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Input;

class SubCategory extends Model
{
    protected $fillable = ['category_id','title'];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
    public function quizModels()
    {
        return $this->hasMany(QuizModel::class);
    }
}
