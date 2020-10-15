<?php

namespace App\Quiz;

use App\User;
use Illuminate\Database\Eloquent\Model;

class QuizResult extends Model
{
    public function users()
    {
        return $this->belongsToMany(User::class);
    }
}
