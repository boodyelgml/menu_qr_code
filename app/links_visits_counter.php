<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class links_visits_counter extends Model
{
    protected $table = 'links_visits_counter';

    public function link()
    {
        return $this->belongsTo('\App\links', 'link_id');
    }
}
