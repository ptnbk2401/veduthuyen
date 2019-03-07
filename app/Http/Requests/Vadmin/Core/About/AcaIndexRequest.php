<?php

namespace App\Http\Requests\Vadmin\Core\About;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;
use Illuminate\Routing\Route;

class AcaIndexRequest extends FormRequest
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
            'name'    => 'required',
            'content' => 'required'
        ];
    }
    public function messages()
    {
        return [
            'name.required'     => 'Tên giới thiệu không được trống',
            'content.required'   => 'Nội dung bài viết không được trống',
        ];
    }
}
