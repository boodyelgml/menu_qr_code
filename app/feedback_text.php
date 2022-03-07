<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class feedback_text extends Model
{
    protected $table = 'feedback_text';

    // ============================================================
    // =========== feedback_text belongto restaurant relation =====
    // ============================================================
    public function restaurant()
    {
        return $this->belongsTo('\App\restaurant', 'restaurant_id');
    }
}
