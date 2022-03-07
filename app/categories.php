<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class categories extends Model
{
    protected $table = 'categories';

    // ============================================================
    // =========== category belongto restaurant relation ==============
    // ============================================================
    public function restaurant(){
        return $this->belongsTo('\App\restaurant' , 'restaurant_id');
    }



    // ============================================================
    // =========== category has many items relation ==============
    // ============================================================

    public function items(){
        return $this->belongsToMany('\App\items' , 'item_category' , 'category_id' , 'item_id');
    }

    // ============================================================
    // =========== category has many menu relation ==============
    // ============================================================

    public function menus(){
        return $this->belongsToMany('\App\menus' , 'category_menu' , 'category_id' , 'menu_id');
    }
}
