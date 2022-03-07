<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class items extends Model
{
    protected $table = 'items';


    // ============================================================
    // =========== item belong to many category relation ==========
    // ============================================================

    public function categories()
    {
        return $this->belongsToMany('\App\categories', 'item_category', 'item_id', 'category_id');
    }


    // ============================================================
    // =========== item belong to one restaurant ==============
    // ============================================================

    public function restaurant()
    {
        return $this->belongsTo('\App\restaurant', 'restaurant_id');
    }
}
