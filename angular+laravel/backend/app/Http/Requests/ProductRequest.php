<?php

namespace App\Http\Requests;

use http\Env\Request;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Validator;

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
        return [
            'name' => 'required|max:50| min:3',
            'price' => 'required| integer ',
            'category_id' => 'required | regex:/(^([123])$)/u',
        ];
    }


    public function messages()
    {

        return [
            'required' => ':attribute không được để trống.',
            'min' => ':attribute không được nhỏ hơn :min ký tự.',
            'max' => ':attribute không được nhiều hơn :max ký tự.',
            'integer' => ':attribute không được nhập chữ và.',
            'regex' => 'Không tìm :attribute.',
        ];
    }

    public function attributes() // Thay đổi attributes thành tên trường tương ứng
    {
        return [
            'name' => 'Tên sản phẩm',
            'price' => 'Giá sản phẩm',
            'category_id' => 'loại sản phẩm',
        ];
    }
}
