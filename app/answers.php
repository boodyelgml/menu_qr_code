<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class answers extends Model
{
    protected $table = 'answers';

    // ============================================================
    // =========== questions has many answers relation==============
    // ============================================================

    public function questions()
    {
        return $this->belongsTo('\App\questions', 'question_id');
    }


    public function restaurant()
    {
        return $this->belongsTo('\App\restaurant', 'restaurant_id');
    }
}
