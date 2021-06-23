<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

/**
 * @OA\Info(
 *      title="API",
 *      version="1.0"
 * )
 *
 * @OA\PathItem (
 *     path="/"
 * )
 *
 * @OA\Server (
 *      url="https://personal-page-teacher-api.herokuapp.com/api/"
 * )
 *
 * @OA\SecurityScheme(
 *     type="http",
 *     description="Введите токен",
 *     name="Token based Based",
 *     in="header",
 *     scheme="bearer",
 *     bearerFormat="JWT",
 *     securityScheme="apiAuth",
 * )
 *
 */
class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    protected function respondWithToken($token, $status = 200)
    {
        return response()->json([
            'token' => [
                'type' => 'Bearer',
                'value' => $token,
                'expires_in' => auth()->factory()->getTTL()
            ]
        ], $status);
    }

}
