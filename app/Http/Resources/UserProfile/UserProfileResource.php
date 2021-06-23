<?php

namespace App\Http\Resources\UserProfile;

use Illuminate\Http\Resources\Json\JsonResource;

class UserProfileResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'phone' => $this->phone,
            'birthday' => $this->birthday,
            'bio' => $this->bio,
            'work_experience_at' => $this->work_experience_at,
            'formatted_work_experience_at' => $this->getWorkExperience(),
            'category' => $this->category,
            'academic_degree' => $this->academic_degree,
            'academic_title' => $this->academic_title,
            'place_of_work' => $this->place_of_work,
            'position' => $this->position,
            'social' => [
                'inst' => $this->inst_url,
                'vk' => $this->vk_url,
                'ok' => $this->ok_url
            ]
        ];
    }
}
