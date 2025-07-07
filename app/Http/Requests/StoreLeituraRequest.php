<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreLeituraRequest extends FormRequest
{
    public function rules()
    {
        return [
            'freezer_id'    => 'required|exists:freezer,id',
            'temperatura' => 'required|numeric',
            'umidade'   => 'required|numeric'
        ];
    }

    public function authorize() { return true; }
}
