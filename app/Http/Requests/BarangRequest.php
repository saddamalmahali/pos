<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BarangRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return $messages = [
            'kode'=>'required',
            'nama_barang'=>'required',
        ];
    }

    public function messages(){
        return $messages = [
            'kode.required' => 'Kode Tidak Boleh Kosong!',
            'nama_barang.required' => 'Nama Barang Tidak Boleh Kosong!',
        ];
    }
}
