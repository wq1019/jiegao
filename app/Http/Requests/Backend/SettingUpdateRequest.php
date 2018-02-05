<?php

namespace App\Http\Requests;

use App\Models\Setting;
use Illuminate\Validation\Rule;

class SettingUpdateRequest extends Request
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
        $setting = $this->route('setting');

        return [
            'name'        => ['bail', 'nullable', 'alpha_dash', 'between:1,30', Rule::unique('settings')->ignore($setting->id)],
            'value'       => ['nullable', 'string'],
            'description' => ['nullable', 'string', 'between:2,190'],
            'type_name'   => ['bail', 'nullable', 'string', 'between:1,30', Rule::exists('types', 'name')->where('model_name', Setting::class)],
        ];
    }
}
