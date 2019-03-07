<?php

namespace App\Http\Requests\Vadmin\Core\Contact;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;
use Illuminate\Routing\Route;

class AccIndexRequest extends FormRequest
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
    public function rules(Route $route, Request $request)
    {
        return [
            'fullname' => 'required',
            'email' => 'required',
            'phone' => 'required',
            // 'subject' => 'required',
            'content' => 'required'
        ];
    }

    public function messages()
    {
        return [
            'fullname' => 'Họ và tên không được để trống',
            'email' => 'Email không được để trống',
            'phone' => 'Số điện thoại không được để trống',
            'subject' => 'Bạn cần nhập tiêu đề',
            'content' => 'Bạn muốn gửi đến nội dung gì cho chúng tôi?'
        ];
    }
}
