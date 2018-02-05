<?php

namespace App\Http\Requests\Backend;

use App\Http\Requests\Request;
use App\Rules\ImageName;
use App\Rules\ImageNameExist;
use Illuminate\Validation\Rule;

class UserUpdateRequest extends Request
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
        $user = $this->route('user');

        return [
            'user_name'   => ['bail', 'nullable', 'alpha_num', 'between:2,30', Rule::unique('users')->ignore($user->id)],
            'nick_name'   => ['nullable', 'string', 'between:2,30'],
            'password'    => ['nullable', 'string', 'between:5,20'],
            'email'       => ['bail', 'nullable', 'email', Rule::unique('users')->ignore($user->id)],
            'avatar'      => ['bail', 'nullable', 'string', new ImageName(), new ImageNameExist()],
            'roles'       => ['nullable', 'array'],
            'permissions' => ['nullable', 'array'],
        ];
    }
}
