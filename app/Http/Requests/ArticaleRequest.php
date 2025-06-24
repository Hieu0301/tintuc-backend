<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ArticaleRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        // $id = $this->route('categories');
        $isUpdate = $this->isMethod('put') || $this->isMethod('patch');
        if ($isUpdate) {
            return [
                'title' => 'sometimes|string|max:255',
                'content' => 'sometimes|string',
                'thumbnail' => 'sometimes|image|max:2048',
                'category_id' => 'sometimes|exists:categories,id',
            ];
        } else {
            return [
                'title' => 'required|string|max:255',
                'content' => 'required|string',
                'thumbnail' => 'nullable|image|max:2048',
                'category_id' => 'required|exists:categories,id',
            ];
        }
    }

    public function messages(): array
    {
        return [
            'required' => ':attribute không được bỏ trống',
            'image' => ':attribute phải là định dạng ảnh (jpeg, png, ...)',
            'thumbnail.max' => ':attribute không được vượt quá 2MB',
            'exists' => ':attribute không hợp lệ',
        ];
    }


    public function attributes(): array
    {
        return [
            'title' => 'Tiêu đề',
            'content' => 'Nội dung',
            'thumbnail' => 'Ảnh',
            'category_id' => 'Danh mục',

        ];
    }
}
