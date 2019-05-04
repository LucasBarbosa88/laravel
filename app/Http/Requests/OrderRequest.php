<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class OrderRequest extends FormRequest
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
	            'client_name' => 'required|max:255',
	            'barcode' => 'required',
                'product_price' => 'required',
                'product_count' => 'required',
                'products_list'	=> 'required',
                'total_price' => 'required',
          ];

          return $rules;
    }
}
