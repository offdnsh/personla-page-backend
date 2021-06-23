<?php

namespace App\Http\Requests\Account\Profile;

use Illuminate\Foundation\Http\FormRequest;

class UpdateSocialRequest extends FormRequest
{

    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'inst_url' => 'nullable|regex:/^(http(s)?:\/\/)?(www\.)?instagram\.com\/\w+\/?$/',
            'vk_url' => 'nullable|regex:/^(http(s)?:\/\/)?(www\.)?vk\.com\/\w+\/?$/',
            'ok_url' => 'nullable|regex:/^(http(s)?:\/\/)?(www\.)?ok\.ru\/\w+\/?$/',
        ];
    }
}
