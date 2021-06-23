<?php

namespace App\Http\Requests\Account\Profile;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateMainRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'phone' => 'nullable|integer|digits:11|unique:user_profiles,phone,' . auth()->user()->id,
            'birthday' => 'nullable|date_format:Y-m-d',
            'bio' => 'nullable|string|max:1024',
            'work_experience_at' => 'nullable|integer|min:1|max:80|digits:2',
            'category' => ['nullable', Rule::in('0', 'Первая  квалификационная  категория', 'Высшая  квалификационная  категория')],
            'academic_degree' => ['nullable', Rule::in('0', 'Кандидат наук', 'Доктор наук')],
            'academic_title' => ['nullable', Rule::in('0', 'Доцент', 'Профессор')],
            'place_of_work' => 'nullable|string|max:150',
            'position' => 'nullable|string|max:150'
        ];
    }
}
