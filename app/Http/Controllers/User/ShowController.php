<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Resources\User\UserResource;
use App\Repositories\UserRepository;

/**
 *
 *
 * @OA\Get (
 *     path="/u/{username}",
 *     tags={"Остальное"},
 *     summary="Данные пользователя по его имени",
 *       @OA\Parameter(
 *         description="Имя пользователя",
 *         in="path",
 *         name="username",
 *         required=true,
 *         @OA\Schema(
 *           type="string"
 *         )
 *     ),
 *      @OA\Response(response="200", description="Успешно"),
 *      @OA\Response(response="404", description="Не найдено")
 *     )
 *
 *
 */
class ShowController extends Controller
{

    private $userRepository;

    public function __construct()
    {
        $this->userRepository = new UserRepository();
    }

    public function __invoke(string $username)
    {
        $user = $this->userRepository->show($username);

        if (!$user) {
            return response()->json(null, 404);
        }

        return response()->json(
            new UserResource($user)
        );
    }
}
