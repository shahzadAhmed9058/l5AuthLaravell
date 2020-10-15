<?php

namespace App\Admin;

use Illuminate\Database\Eloquent\Model;

class QuizModel extends Model
{
    protected $fillable = ['sub_category_id','type','description','question','points'];

    public function optionModels()
    {
        return $this->hasMany(OptionModel::class);
    }
    public function answerModels()
    {
        return $this->hasMany(AnswerModel::class);
    }
    public function subCategory()
    {
        return $this->belongsTo(SubCategory::class);
    }
}
