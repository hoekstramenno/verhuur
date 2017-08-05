<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreDate extends FormRequest
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
            'date_from' => 'required|date|date_format:Y-m-d H:i:s|after:tomorrow',
            'date_to' => 'required|date|date_format:Y-m-d H:i:s|after:date_from',
            'published_at' => 'sometimes|date|date_format:Y-m-d H:i:s',
            'price' => 'required|numeric',
            'status' => 'required|numeric'
        ];
    }
}