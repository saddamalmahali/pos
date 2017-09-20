<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DetileService extends Model
{
    protected $table = 'detile_service';
    public function service()
    {
        return $this->hasOne('App\Service', 'id', 'id_service');
    }
}
