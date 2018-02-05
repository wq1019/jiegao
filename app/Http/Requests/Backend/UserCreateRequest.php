<?php

namespace App\Http\Requests\Backend;

use App\Http\Requests\Request;
use App\Rules\ImageName;
use App\Rules\ImageNameExist;

class UserCreateRequest extends Request
{
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
            'user_name'   => ['bail', 'required', 'alpha_num', 'between:2,30', 'unique:users'],
            'nick_name'   => ['required', 'string', 'between:2,30'],
            'password'    => ['required', 'string', 'between:5,20'],
            'email'       => ['bail', 'required', 'email', 'unique:users'],
            'avatar'      => ['bail', 'nullable', new ImageName(), new ImageNameExist()],
            'roles'       => ['nullable', 'array'],
            'permissions' => ['nullable', 'array'],
        ];
    }
}
