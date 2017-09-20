<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SupplierRequest extends FormRequest
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
        return [
            'kode'=>'required',
            'nama'=>'required',
            'no_telp'=>'required',         

        ];
    }

    public function messages(){
        return $messages = [
            'kode.required' => 'Kode Supplier Tidak Boleh Kosong!',
            'nama.required' => 'Nama Supplier Tidak Boleh Kosong!',
            'no_telp.required' => 'No Telp Supplier Tidak Boleh Kosong!',
        ];
    }
}
