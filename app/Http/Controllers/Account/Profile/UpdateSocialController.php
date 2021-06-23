<?php

namespace App\Http\Controllers\Account\Profile;

use App\Http\Controllers\Controller;
use App\Http\Requests\Account\Profile\UpdateSocialRequest;

class UpdateSocialController extends Controller
{
    public function __invoke(UpdateSocialRequest $request)
    {
        $user = auth()->user();

        $user->profile()->update($request->validated());

        return response()->json(null, 200);
    }
}
