<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Member extends Model
{
    protected $table = "member";
    static function createNoMember()
    {
        $member_last = self::orderBy('created_at', 'desc')->first();
        
        if($member_last != ''){
            $id_member = $member_last->kode;
            $kode_awal = substr($id_member, 0, 2);
            $id_member = (int) substr($id_member, 8, 3);
            $kode_baru = $id_member+1;
            $date = date('dmy');

            $kode_member = 'M-'.$date.sprintf("%'.03d", $kode_baru);
            return $kode_member;
        }else{
            $date = date('dmy');
            return 'M-'.$date.'001';
        }
    }

    public function transaksi()
    {
        return $this->hasMany('App\TransaksiMember', 'id_member', 'id');
    }
}
