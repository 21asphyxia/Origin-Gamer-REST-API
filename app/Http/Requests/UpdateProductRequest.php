<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProductRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        // check if the user has the permission
        return auth()->user()->can('update all products') || (auth()->user()->can('update own products') && $this->product->user()->is(auth()->user()));
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'name' => 'string|max:255',
            'description' => 'string',
            'price' => 'numeric',
            'category' => 'string|exists:categories,name',
        ];
    }
}
