<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
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
        $rules = [
            'name' => 'required|max:255',
            'description' => 'required|max:255',
            'price' => 'required|number'
        ];

        // if (in_array($this->method(), ['PUT', 'PATCH'])) {
        //     $rules['email'] .= ",{$this->user}";
        // }

        return $rules;
    }
}
