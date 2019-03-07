<?php

namespace App\Http\Requests\Vadmin\Core\Sim;

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
        $unique = (strpos($route->getName(),"add")) ? "|unique:vne_sim" : '';
        $required = (strpos($route->getName(),"add")) ? "required" : "";

        return [
            'pnumber' => $required."".$unique,
            'nha_mang' => $required,
        ];
    }
    public function messages()
    {
        return [
            'pnumber.required' => 'Số thuê bao không được trống',
            'nha_mang.required'    => 'Chọn nhà Mạng',
            'pnumber.unique'   => 'Số thuê bao  đã tồn tại',
        ];
    }
}
