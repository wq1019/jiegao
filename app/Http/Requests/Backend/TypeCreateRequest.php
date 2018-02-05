<?php

namespace App\Http\Requests\Backend;

use App\Http\Requests\Request;
use App\Models\Type;

class TypeCreateRequest extends Request
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
    public function rules()
    {
        return [
            // todo name 和 model_name 的组合索引
            'name'         => ['required', 'alpha_dash', 'between:1,30'],
            'display_name' => ['required', 'string', 'between:1,30'],
            'description'  => ['nullable', 'string', 'between:2,190'],
            // model_name 指定 Model 类名 表示是该 Model 的类别, 这里只需要传入对应的别名，别名参考 Type::$modelMapWithType
            'model_name' => ['required', 'in:'.implode(',', array_keys(Type::$modelMapWithType))],
        ];
    }
}
