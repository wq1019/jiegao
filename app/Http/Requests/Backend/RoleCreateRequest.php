<?php

namespace App\Http\Requests\Backend;

use App\Http\Requests\Request;

class RoleCreateRequest extends Request
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
            'name'         => ['bail', 'required', 'alpha_num', 'between:2,30', 'unique:roles'],
            'display_name' => ['nullable', 'string', 'between:2,30'],
            'description'  => ['nullable', 'string', 'between:2,190'],
            'order'        => ['nullable', 'integer'],
            'permissions'  => ['nullable', 'array'],
        ];
    }
}
