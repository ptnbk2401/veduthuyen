<?php

namespace App\Http\Requests\Vadmin\Core\Product;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;
use Illuminate\Routing\Route;

class AcpIndexRequest extends FormRequest
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
        $id =  $request->id;
        $required = (strpos($route->getName(),"add")) ? "required" : "";
        $unique = (strpos($route->getName(),"add")) ? "vne_product" : "vne_product,code,".$id.",product_id";

        return [
            'pname' => 'required',
            'code' => "$required|unique:{$unique}",
            'sort' => $required,
            'cat_id' => 'required|integer|min:1',
        ];
    }
    public function messages()
    {
        return [
            'pname.required'   => 'Tên sản phẩm không được trống',
            'code.required'    => 'Mã code không được để trống',
            'code.unique'      => 'Mã code đã tồn tại',
            'sort.required'    => 'Sắp xếp không được để trống',
            'sort.int'         => 'Sắp xếp phải là số',
            'cat_id.min'       => 'Danh mục phải chọn',
        ];
    }
}
