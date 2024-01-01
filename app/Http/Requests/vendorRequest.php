<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class vendorRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
               'title'=>'required',
                'description'=>'nullable',
                'imageUrl1'=>'required',
                'imageUrl2'=>'nullable',
                'imageUrl3'=>'nullable',
                'imageUrl4'=>'nullable',
                'imageUrl5'=>'nullable',
                'price'=>'required',
                'quantityInStock'=>'required',
                'categoryId'=>'required',
             ];
    }
}
