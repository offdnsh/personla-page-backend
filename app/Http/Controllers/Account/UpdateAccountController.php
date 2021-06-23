<?php

namespace App\Http\Controllers\Account;

use App\Http\Controllers\Controller;
use App\Http\Requests\Account\UpdateAccountRequest;
use Illuminate\Http\Request;

class UpdateAccountController extends Controller
{
    public function __invoke(UpdateAccountRequest $request)
    {
        $user = auth()->user();

        $user->update($request->validated());

        return response()->json(null, 200);
    }
}
