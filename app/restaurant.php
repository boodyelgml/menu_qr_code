<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class restaurant extends Model
{
    // use SoftDeletes;
    protected $table = "restaurant";

    // ============================================================
    // =========== restaurant belongs to one user =================
    // ============================================================

    public function user()
    {
        return $this->belongsTo('\App\users', 'user_id');
    }

    // ============================================================
    // =========== restaurant has many menus relation==============
    // ============================================================

    public function menus()
    {
        return $this->hasMany('\App\menus', 'restaurant_id');
    }
    // ============================================================
    // =========== restaurant has many branches relation==============
    // ============================================================

    public function branches()
    {
        return $this->hasMany('\App\branch', 'restaurant_id');
    }

    // ============================================================
    // =========== restaurant has many categories relation==============
    // ============================================================

    public function categories()
    {
        return $this->hasMany('\App\categories', 'restaurant_id');
    }

    // ============================================================
    // =========== restaurant has many items relation==============
    // ============================================================

    public function items()
    {
        return $this->hasMany('\App\items', 'restaurant_id');
    }

    // ============================================================
    // =========== restaurant has many popup_ad relation==============
    // ============================================================

    public function popup_ad()
    {
        return $this->hasMany('\App\popup_ad', 'restaurant_id');
    }

    // ============================================================
    // =========== restaurant has many top_ad relation==============
    // ============================================================

    public function top_ad()
    {
        return $this->hasMany('\App\top_ad', 'restaurant_id');
    }
    // ============================================================
    // =========== restaurant has many feedback_text relation==============
    // ============================================================

    public function feedback_text()
    {
        return $this->hasMany('\App\feedback_text', 'restaurant_id');
    }

    // ============================================================
    // =========== restaurant has many feedback_text relation==============
    // ============================================================

    public function answers()
    {
        return $this->hasMany('\App\answers', 'restaurant_id');
    }

    // ============================================================
    // =========== questions has many menu relation ==============
    // ============================================================

    public function questions()
    {
        return $this->belongsToMany('\App\questions', 'restaurant_questions', 'restaurant_id' , 'question_id' );
    }
}
