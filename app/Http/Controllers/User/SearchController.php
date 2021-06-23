<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Resources\User\UserResource;
use App\Models\User;
use Illuminate\Http\Request;

/**
 *
 *
 * @OA\Get (
 *     path="/search",
 *     tags={"Остальное"},
 *     summary="Поиск пользователя",
 *       @OA\Parameter(
 *         description="Запрос",
 *         in="query",
 *         name="query",
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
class SearchController extends Controller
{
    public function __invoke(Request $request)
    {
        $query = trim($request->query('query'));

       $users = User::where('first_name', 'LIKE', "%{$query}%")
           ->orWhere('last_name', 'LIKE', "%{$query}%")
           ->orWhere('patronymic', 'LIKE', "%{$query}%")
           ->orWhere('email', 'LIKE', "%{$query}%")
           ->get();

       if (!$users) {
           return response()->json([], 200);
       }

        return response()->json(
            UserResource::collection($users)
        );
    }
}
