<?php

namespace App\Http\Requests;

use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class ProductRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'product_name' => 'required | min:6 | regex:/(^([a-zA-z]+)(\d+)?$)/u',
            'product_price' => 'required | integer'
        ];
    }

    public function messages()
    {
        return [
            'required' => ':attribute bat buoc nhap.',
            'min' => ':attribute khong duoc nho hon :min',
            'integer' => ':attribute phai la so.',
            'regex' => ':attribute khong dung dinh dang'
        ];
    }

    public function attributes() // Thay đổi attributes thành tên trường tương ứng
    {
        return [
            'product_name' => 'Ten san pham',
            'product_price' => 'Gia san pham'
        ];
    }

    protected function withValidator($validator) // Trước khi validate sẽ xử lý công việc VD: lọc dữ liệu...
    {
        $validator->after(function ($validator) {
            $checkValidate = $validator->errors()->count();
            if ($checkValidate > 0) {
                $validator->errors()->add('msg', 'Da co loi, Vui long kiem tra lai.');
            }
        });
    }


    protected function prepareForValidation()
    {
        $this->merge([
            'create_at' => date('Y-m-d H:i:s')
        ]);
    }

    protected function failedAuthorization()
    {
//        throw new AuthorizationException('Ban dang tuy cap vao khu vuc cam'); show mess ở trang error 403

        throw new HttpResponseException(abort(404)); // chuyen request den trang bat ky VD:404

//        throw new HttpResponseException(redirect('/')->with([
//            'msg' => 'Ban khong co quyen truy cap.',
//            'type' => 'danger'
//        ])); // chuyển trang khi không đủ quyền truy cập

    }

}
