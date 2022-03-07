<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class top_ad extends Model
{
    protected $table = 'top_ad';


    // ============================================================
    // =========== top_ad belongs to restaurant relation =============
    // ============================================================

    public function restaurant()
    {
        return $this->belongsTo('\App\restaurant', 'restaurant_id');
    }
}
