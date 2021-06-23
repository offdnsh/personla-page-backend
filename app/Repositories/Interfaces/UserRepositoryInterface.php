<?php


namespace App\Repositories\Interfaces;


use App\Models\User;
use Illuminate\Http\Request;

interface UserRepositoryInterface
{
    public function create(Request $request): User;

    public function show(string $username);
}
