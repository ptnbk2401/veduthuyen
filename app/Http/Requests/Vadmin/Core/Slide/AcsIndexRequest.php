<?php

namespace App\Http\Requests\Vadmin\Core\Slide;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;
use Illuminate\Routing\Route;

class AcsIndexRequest extends FormRequest
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
        $required = (strpos($route->getName(), "add")) ? "required" : "";
        return [
            'product_id' => 'required',
            'sort' => 'required|int',
        ];
    }
    public function messages()
    {
        return [
            'product_id.required'    => 'ID bài viết không được trống',
            'sort.required'    => 'Sắp xếp không được để trống',
            'sort.int'         => 'Sắp xếp phải là số',
            'picture.required'  => 'Hình ảnh phải chọn',
        ];
    }
}
