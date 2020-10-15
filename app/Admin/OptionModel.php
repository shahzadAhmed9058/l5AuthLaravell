<?php

namespace App\Admin;

use Illuminate\Database\Eloquent\Model;

class OptionModel extends Model
{
    public function quizModel()
    {
        return $this->belongsTo(QuizModel::class);
    }
}
