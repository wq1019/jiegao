<?php

namespace App\Http\Requests;

use App\Models\Setting;
use Illuminate\Validation\Rule;

class SettingCreateRequest extends Request
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
            'name'        => ['bail', 'required', 'alpha_dash', 'between:1,30', 'unique:settings'],
            'value'       => ['nullable', 'string'],
            'description' => ['nullable', 'string', 'between:2,190'],
            'type_name'   => ['bail', 'required', 'string', 'between:1,30', Rule::exists('types', 'name')->where('model_name', Setting::class)],
        ];
    }
}
