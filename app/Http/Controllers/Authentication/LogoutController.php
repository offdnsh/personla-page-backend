<?php

namespace App\Http\Controllers\Authentication;

use App\Http\Controllers\Controller;

/**
 *
 *
 * @OA\Post (
 *     path="/auth/logout",
 *     summary="Выход",
 *     tags={"Аутентификация"},
 *      security={
 *       {"apiAuth": {}}
 *     },
 *      @OA\Response(response="200", description="Успешно"),
 *      @OA\Response(response="401", description="Не авторизован")
 *     )
 *
 */
class LogoutController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth:api']);
    }

    public function __invoke()
    {
        auth()->logout();
    }
}
