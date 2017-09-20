<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class KaryawanRequest extends FormRequest
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
            'nama_lengkap'=>'required',
            'jenis_kelamin'=>'required',
            'tempat_lahir'=>'required',
            'tanggal_lahir'=>'required',            

        ];
    }

    public function messages(){
        return $messages = [
            'nama_lengkap.required' => 'Nama Lengkap Tidak Boleh Kosong!',
            'jenis_kelamin.required' => 'Jenis Kelamin Harus ditentukan!',
            'tempat_lahir.required' => 'Tempat Lahir Tidak Boleh Kosong!',
            'tanggal_lahir.required' => 'Tanggal Lahir Harus ditentukan!',
        ];
    }
}
