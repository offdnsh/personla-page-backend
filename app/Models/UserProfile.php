<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserProfile extends Model
{

    protected $table = 'user_profiles';

    protected $fillable = [
        'phone',
        'birthday',
        'bio',
        'work_experience_at', // Стаж
        'category', // Категория: 1 или Высшая
        'academic_degree', // Ученая степень
        'academic_title', // Ученое звание
        'place_of_work', // Место работы
        'position', // Должность,
        'inst_url',
        'vk_url',
        'ok_url'
    ];

    public function getWorkExperience()
    {
        if (!is_null($this->work_experience_at)) {
            return (int) Carbon::now()->year - $this->work_experience_at;
        }
        return null;
    }

}
