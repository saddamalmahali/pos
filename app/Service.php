<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    protected $table = 'service';
    static function createNoService()
    {
        $service_last = self::orderBy('created_at', 'desc')->first();
        
        if($service_last != ''){
            $id_service = $service_last->kode;
            $id_baru = (int) substr($id_service, 2, 3);
            $kode_baru = $id_baru+1;

            $kode_service = 'S-'.sprintf("%'.03d", $kode_baru);
            return $kode_service;
        }else{
            
            return 'S-001';
        }
    }
}
