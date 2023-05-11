<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
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
        $uniqueEmail = 'unique:user';
        if (session('id')) {
            $uniqueEmail = $uniqueEmail . ',email,' . session('id');
        }

        return [
            'fullname' => ['required', 'min:5'],
            'email' => ['required', 'email', $uniqueEmail],
            'group_id' => ['required', 'integer', 'between:1,2']
        ];
    }

    public function messages()
    {
        return [
            'required' => ':attribute không được để trống . ',
            'min' => ':attribute ít nhất có :min ký tự . ',
            'between' => ':attribute nhóm bạn chọn không tồn tại.',
            'integer' => ':attribute bạn chọn không tồn tại.',
            'email' => ':attribute không đúng định dạng.',
            'unique' => ':attribute đã tồn tại trên hệ thống . '
        ];
    }


    public function attributes()
    {
        return [
            'fullname' => 'Tên người dùng',
            'email' => 'Email',
            'group_id' => 'Email',
        ];
    }
}
