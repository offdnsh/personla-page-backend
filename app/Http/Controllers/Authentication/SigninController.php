<?php

namespace App\Http\Controllers\Authentication;

use App\Http\Controllers\Controller;
use App\Http\Requests\Authentication\SigninRequest;

/**
 *
 *
 * @OA\Post (
 *     path="/auth/signin",
 *     summary="Авторизация пользователя",
 *     tags={"Аутентификация"},
 *     @OA\RequestBody (
 *          required=true,
 *          @OA\MediaType (
 *              mediaType="application/json",
 *              @OA\Schema (
 *                  type="object",
 *                   @OA\Property (
 *                      property="email",
 *                      description="Электронная почта",
 *                      type="string"
 *                  ),
 *                   @OA\Property (
 *                      property="password",
 *                      description="Пароль",
 *                      type="string"
 *                  ),
 *              )
 *          )
 *     ),
 *      @OA\Response(response="422", description="Невалидные данные"),
 *      @OA\Response(response="200", description="Пользователь авторизовался"),
 *      @OA\Response(response="401", description="Неверные данные")
 *     )
 *
 */
class SigninController extends Controller
{

    public function __invoke(SigninRequest $request)
    {
        $credentials = $request->validated();

        if (!$token = auth()->attempt($credentials)) {
            return response()->json(null, 401);
        }

        return $this->respondWithToken($token);
    }
}
