<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class branch extends Model
{
    protected $table = 'branch';

      // ============================================================
    // =========== many branches belongs to one restaurant =================
    // ============================================================

    public function restaurant()
    {
        return $this->belongsTo('\App\restaurant', 'restaurant_id');
    }

    // ============================================================
    // =========== branches  belong to many menus ================
    // ============================================================
    public function menus(){
        return $this->belongsToMany('\App\menus' , 'branch_menu' , 'branch_id' , 'menu_id');
    }
}
