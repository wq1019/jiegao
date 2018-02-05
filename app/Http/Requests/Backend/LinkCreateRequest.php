<?php

namespace App\Http\Requests\Backend;

use App\Http\Requests\Request;
use App\Models\Link;
use App\Rules\ImageName;
use App\Rules\ImageNameExist;
use Illuminate\Validation\Rule;

class LinkCreateRequest extends Request
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
            'url'        => ['required', 'url'],
            'name'       => ['required', 'string', 'between:1,20'],
            'logo'       => ['bail', 'nullable', new ImageName(), new ImageNameExist()],
            'linkman'    => ['nullable', 'string', 'between:2,20'],
            'type_name'  => ['bail', 'required', 'string', 'between:1,30', Rule::exists('types', 'name')->where('model_name', Link::class)],
            'is_visible' => ['nullable', 'boolean'],
        ];
    }
}
