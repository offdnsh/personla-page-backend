<?php

namespace App\Http\Controllers\Account\Profile;

use App\Http\Controllers\Controller;
use App\Http\Requests\Account\Profile\UpdateMainRequest;

class UpdateMainController extends Controller
{
    public function __invoke(UpdateMainRequest $request)
    {
        $user = auth()->user();

        $data = $request->validated();

        $user->profile()->update($data);

        return response()->json(null, 200);
    }
}
