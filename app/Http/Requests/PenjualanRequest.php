<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PenjualanRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     *   ========================
     *   Penjualan
     *   ========================
     *   -   id
     *   -   nota
     *   -   tanggal_jual
     *   -   kode_pelanggan
     *   -   total_sp
     *   -   total_harga
     *   -   bayar
     *   -   kembali
     *   -   keterangan
     */

    public function rules()
    {
        $penjualan = [
            'nota'=> 'required',
            'tanggal_jual'=> 'required',
            'kode_pelanggan'=> 'required',
            'total_sp'=> 'required',
            'total_harga'=> 'required',
            'bayar'=> 'required',
            'kembali'=> 'required',
        ];

        if($this->request->get('detile_penjualan')){
            
        }

        $data = [
            $penjualan,

        ];

        return [
            //
        ];
    }
}
