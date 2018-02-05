<?php

namespace App\Http\Requests\Backend;

use App\Http\Requests\Request;
use Illuminate\Validation\Rule;

class TagUpdateRequest extends Request
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
        $tag = $this->route('tag');

        return [
            'name' => ['bail', 'nullable', 'string', 'between:1,30', Rule::unique('tags')->ignore($tag->id)],
        ];
    }
}
