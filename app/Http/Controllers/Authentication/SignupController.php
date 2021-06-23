<?php

namespace App\Http\Controllers\Authentication;

use App\Http\Controllers\Controller;
use App\Http\Requests\Authentication\SignupRequest;
use App\Repositories\UserRepository;
use Illuminate\Http\JsonResponse;


/**
 *
 *
 * @OA\Post (
 *     path="/auth/signup",
 *     summary="Создание пользователя",
 *     tags={"Аутентификация"},
 *     @OA\RequestBody (
 *          required=true,
 *          @OA\MediaType (
 *              mediaType="application/json",
 *              @OA\Schema (
 *                  type="object",
 *                  @OA\Property (
 *                      property="first_name",
 *                      description="Имя",
 *                      type="string"
 *                  ),
 *                  @OA\Property (
 *                      property="last_name",
 *                      description="Фамилия",
 *                      type="string"
 *                  ),
 *                   @OA\Property (
 *                      property="username",
 *                      description="Имя пользователя",
 *                      type="string"
 *                  ),
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
 *      @OA\Response(response="201", description="Пользователь создан")
 *     )
 *
 */
class SignupController extends Controller
{

    private $userRepository;

    public function __construct()
    {
        $this->userRepository = new UserRepository();
    }

    public function __invoke(SignupRequest $request) : JsonResponse
    {
        $user = $this->userRepository->create($request);

        $token = auth()->login($user);

        return $this->respondWithToken($token, 201);
    }
}
