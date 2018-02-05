<?php

namespace App\Http\Requests\Backend;

use App\Http\Requests\Request;
use App\Models\Banner;
use App\Rules\ImageName;
use App\Rules\ImageNameExist;
use Illuminate\Validation\Rule;

class BannerUpdateRequest extends Request
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
            'url'        => ['nullable', 'url'],
            'title'      => ['nullable', 'string', 'between:1,30'],
            'image'      => ['bail', 'nullable', new ImageName(), new ImageNameExist()],
            'type_name'  => ['bail', 'nullable', 'string', 'between:1,30', Rule::exists('types', 'name')->where('model_name', Banner::class)],
            'is_visible' => ['nullable', 'boolean'],
        ];
    }
}
