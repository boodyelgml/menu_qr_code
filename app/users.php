<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class users extends Model
{
    protected $table = "users";

    // ============================================================
    // =========== user has many restaurant relation ==============
    // ============================================================

    public function restaurants()
    {
        return $this->hasMany('\App\restaurant', 'user_id');
    }

}
