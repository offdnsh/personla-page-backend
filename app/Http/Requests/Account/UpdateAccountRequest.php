<?php

namespace App\Http\Requests\Account;

use Illuminate\Foundation\Http\FormRequest;

class UpdateAccountRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'first_name' => 'required|string|max:50',
            'last_name' => 'required|string|max:50',
            'patronymic' => 'nullable|string|max:50',
            'username' => 'required|string|max:120|regex:/^[A-Za-z0-9_.]+$/|unique:users,id,' . auth()->user()->id,
        ];
    }
}
