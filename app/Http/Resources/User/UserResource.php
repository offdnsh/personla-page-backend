<?php

namespace App\Http\Resources\User;

use App\Http\Resources\Role\RoleResource;
use App\Http\Resources\UserProfile\UserProfileResource;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'patronymic' => $this->patronymic,
            'formatted_name' => "{$this->last_name} {$this->first_name} {$this->patronymic}",
            'username' => $this->username,
            'email' => $this->email,
            'role' => new RoleResource($this->role),
            'photo' => $this->getLinkOnPhoto(),
            'profile' => new UserProfileResource($this->profile[0]),
            'created_at' => (int) $this->created_at->format('U'),
            'updated_at' => $this->updated_at->format('d.m.Y H:m:s')
        ];
    }
}
