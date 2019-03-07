<?php

namespace App\Http\Requests\Vadmin\Core\Advertisement;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;
use Illuminate\Routing\Route;

class AcapIndexRequest extends FormRequest
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
            'aname' => 'required|max:250',
            'position_id' => 'required|integer|min:1',
            'begin_at' => 'date',
            'end_at' => 'date|after_or_equal:begin_at'
        ];
    }
    public function messages()
    {
        return [
            'aname.required'   => 'Tên quảng cáo không được trống',
            'position_id.min'  => 'Bạn chưa chọn vị trí quảng cáo',
            'begin_at.date' => 'Ngày bắt đầu phải được chọn là ngày',
            'end_at.date' => 'Ngày kết thúc phải là ngày',
            'end_at.after_or_equal' => 'Ngày kết thúc phải lớn hơn ngày bắt đầu'
        ];
    }
}
