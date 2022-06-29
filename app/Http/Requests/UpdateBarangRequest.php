<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateBarangRequest extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'supplier_id'       => 'required',
            'kategori_id'       => 'required',
            'nama'              => 'required',
            'harga_beli'        => 'required',
            'harga_jual'        => 'required',
            'stok'              => 'required'
        ];
    }
}
