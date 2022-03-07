<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class menus extends Model
{
    protected $table = 'menus';

    // ============================================================
    // =========== menu belong to one restaurant ================
    // ============================================================

    public function restaurant()
    {
        return $this->belongsTo('\App\restaurant', 'restaurant_id');
    }
    // ============================================================
    // =========== menu belong to many categories ================
    // ============================================================

    public function categories()
    {
        return $this->belongsToMany('\App\categories', 'category_menu', 'menu_id', 'category_id');
    }

    // ============================================================
    // =========== menu belong to many branches ================
    // ============================================================

    public function branches()
    {
        return $this->belongsToMany('\App\branch', 'branch_menu', 'menu_id', 'branch_id');
    }
}
