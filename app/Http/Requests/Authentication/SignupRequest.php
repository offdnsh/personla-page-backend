<?php

namespace App\Http\Requests\Authentication;

use Illuminate\Foundation\Http\FormRequest;

class SignupRequest extends FormRequest
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
            'username' => 'required|string|max:120|regex:/^[A-Za-z0-9_.]+$/|unique:users',
            'email' => 'required|string|email|unique:users',
            'password' => 'required|string|min:6|max:32'
        ];
    }
}


