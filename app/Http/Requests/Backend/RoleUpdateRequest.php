<?php

namespace App\Http\Requests\Backend;

use App\Http\Requests\Request;
use Illuminate\Validation\Rule;

class RoleUpdateRequest extends Request
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
        $role = $this->route()->parameter('role');

        return [
            'name'         => ['bail', 'nullable', 'alpha_num', 'between:2,30', Rule::unique('roles')->ignore($role->id)],
            'display_name' => ['nullable', 'string', 'between:2,30'],
            'description'  => ['nullable', 'string', 'between:2,190'],
            'order'        => ['nullable', 'integer'],
            'permissions'  => ['nullable', 'array'],
        ];
    }
}
