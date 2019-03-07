<?php

namespace App\Http\Requests\Vadmin\Core\Thuonghieu;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;
use Illuminate\Routing\Route;

class ActhIndexRequest extends FormRequest
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
        $required = (strpos($route->getName(),"add")) ? "required" : "";

        return [
            'name' => 'required',
            'picture' => $required,
            'sort' => 'required',
            'domain' => 'required',
        ];
    }
    public function messages()
    {
        return [
            'name.required'    => 'Tên thương hiêu không được trống',
            'sort.required'    => 'Sắp xếp không được để trống',
            'domain.required'    => 'Domain không được để trống',
            'picture.required'   => 'Upload thêm hình ảnh',
        ];
    }
}
