<?php

namespace App\Http\Controllers\Authentication;

use App\Http\Controllers\Controller;
use App\Http\Resources\User\UserResource;

/**
 *
 *
 * @OA\Get (
 *     path="/auth/me",
 *     summary="Данные пользователя",
 *     tags={"Аутентификация"},
 *     security={
 *       {"apiAuth": {}}
 *     },
 *      @OA\Response(response="200", description="Данные пользователя"),
 *      @OA\Response(response="401", description="Не авторизован")
 *     )
 *
 *
 */
class MeController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth:api']);
    }

    public function __invoke()
    {
        return response()->json(
            new UserResource(
                auth()->user()
            )
        );
    }
}

