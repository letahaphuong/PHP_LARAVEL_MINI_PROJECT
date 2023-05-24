<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BilliardTypeRequest extends FormRequest
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
            'name' => 'required|max:50| min:3',
            'price' => 'required| integer ',
        ];
    }

    public function messages()
    {
        return [
            'required' => ':attribute không được để trống.',
            'min' => ':attribute không được nhỏ hơn :min ký tự.',
            'max' => ':attribute không được nhiều hơn :max ký tự.',
            'integer' => ':attribute không được nhập chữ và.',
        ];
    }

    public function attributes()
    {
        return [
            'name' => 'Tên sản phẩm',
            'price' => 'Giá sản phẩm'
        ];
    }
}
