<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Storage;
use Tymon\JWTAuth\Contracts\JWTSubject;


class User extends Authenticatable implements JWTSubject
{
    use HasFactory;

    protected $table = 'users';

    protected $fillable = [
        'first_name', 'last_name', 'patronymic', 'username', 'email', 'password', 'photo'
    ];

    public function getLinkOnPhoto()
    {
        if (is_null($this->photo)) {
            return Storage::disk('s3')->url('photos/default.png');
        }
        return Storage::disk('s3')->url('photos/' . $this->photo);
    }


    public function setPasswordAttribute(string $value)
    {
        if (trim($value)) $this->attributes['password'] = bcrypt($value);
    }

    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    public function profile()
    {
        return $this->hasMany(UserProfile::class);
    }

    public function files()
    {
        return $this->hasMany(File::class);
    }

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [];
    }
}
