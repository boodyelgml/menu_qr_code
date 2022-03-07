<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class questions extends Model
{
    protected $table = 'questions';
    // ============================================================
    // =========== questions has many restaurants relation ==============
    // ============================================================

    public function restaurants()
    {
        return $this->belongsToMany('\App\restaurant', 'restaurant_questions', 'question_id', 'restaurant_id');
    }

    // ============================================================
    // =========== questions has many answers relation==============
    // ============================================================

    public function answers()
    {
        return $this->hasMany('\App\answers', 'question_id');
    }
}
