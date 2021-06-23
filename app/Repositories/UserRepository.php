<?php


namespace App\Repositories;


use App\Models\User;
use Illuminate\Http\Request;

class UserRepository implements Interfaces\UserRepositoryInterface
{

    public function create(Request $request): User
    {
        $user = User::create($request->validated());
        $user->profile()->create();
        return $user;
    }

    public function show(string $username)
    {
        $user = User::where('username', $username)->first();
        if (!$user) return null;
        return $user;
    }
}
