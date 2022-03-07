<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class popup_ad extends Model
{
    protected $table = 'popup_ad';


    // ============================================================
    // =========== popup_ad belongs to restaurant relation =============
    // ============================================================

    public function restaurant()
    {
        return $this->belongsTo('\App\restaurant', 'restaurant_id');
    }
}
