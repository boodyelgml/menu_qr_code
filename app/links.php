<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class links extends Model
{
    protected $table = 'links';


    public function counts()
    {
        return $this->hasMany('\App\links_visits_counter', 'link_id');
    }
}
