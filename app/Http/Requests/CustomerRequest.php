<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CustomerRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'reference' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'start_date' => 'required|date',
            'description' => 'nullable|string',
        ];
    }
}
