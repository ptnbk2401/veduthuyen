<?php

namespace App\Http\Requests\Vadmin\Core\Comment;

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
            'name' => 'required',
            'detail_text' => 'required',
            'begin_at' => 'required|date',
            'end_at' => 'required|date|after_or_equal:begin_at'
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Tên không được để trống',
            'detail_text.required' => 'Chi tiết không được để trống',
            'begin_at' => 'Ngày bắt đầu không được để trống',
            'begin_at.date' => 'Ngày bắt đầu phải được chọn là ngày',
            'end_at' => 'Ngày kết thúc không được để trống',
            'end_at.date' => 'Ngày kết thúc phải là ngày',
            'end_at.after_or_equal' => 'Ngày kết thúc phải lớn hơn ngày bắt đầu'
        ];
    }
}
