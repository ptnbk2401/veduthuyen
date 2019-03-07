<?php

namespace App\Http\Requests\Vadmin\Core\AdsPosition;

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
        $id = $request->id;
        $required = (strpos($route->getName(), "add")) ? "required" : "";
        $unique = (strpos($route->getName(), "add")) ? "vne_ads_position" : "vne_ads_position,code," . $id . ",position_id";

        return [
            'name' => 'required',
            'code' => "$required|unique:{$unique}",
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Tên quảng cáo không được trống',
            'code.required' => 'Mã code không được để trống',
            'code.unique' => 'Mã code đã tồn tại',
        ];
    }
}
