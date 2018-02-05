<?php

namespace App\Http\Requests\Backend;

use App\Http\Requests\Request;
use App\Models\Category;
use App\Rules\ImageName;
use App\Rules\ImageNameExist;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Validation\Rule;

class CategoryUpdateRequest extends Request
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
        $category = $this->route('category');

        return [
            'type'             => ['nullable', Rule::in([Category::TYPE_POST, Category::TYPE_PAGE, Category::TYPE_LINK])],
            'image'            => ['bail', 'nullable', new ImageName(), new ImageNameExist()],
            'parent_id'        => ['bail', 'nullable', 'integer', 'min:0'],
            'cate_name'        => ['bail', 'nullable', 'string', 'between:2,30', Rule::unique('categories')->ignore($category->id)],
            'description'      => ['nullable', 'string', 'between:2,500'],
            'is_nav'           => ['nullable', 'boolean'],
            'order'            => ['nullable', 'integer'],
            'url'              => ['nullable', 'url'],
            'is_target_blank'  => ['nullable', 'boolean'],
            'page_template'    => ['nullable', 'string', 'between:1,30'],
            'list_template'    => ['nullable', 'string', 'between:1,30'],
            'content_template' => ['nullable', 'string', 'between:1,30'],
        ];
    }

    public function withValidator(Validator $validator)
    {
        $category = $this->route('category');

        // 验证 parent_id 必须存在
        $validator->sometimes('parent_id', Rule::exists('categories', 'id')->where('id', '!=', $category->id), function ($input) use ($category) {
            return $category->parent_id != $input->parent_id && $input->parent_id > 0;
        });

        return $validator;
    }
}
