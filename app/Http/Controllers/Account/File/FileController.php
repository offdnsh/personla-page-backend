<?php

namespace App\Http\Controllers\Account\File;

use App\Http\Controllers\Controller;
use App\Http\Resources\File\FileResource;
use App\Models\File;
use App\Models\User;
use App\Repositories\FileRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class FileController extends Controller
{

    /**
     * @var FileRepository
     */
    private $fileRepository;

    public function __construct()
    {
        $this->fileRepository = new FileRepository();
        $this->middleware('auth:api')->except('download', 'show');
    }

    /**
     *
     *
     * @OA\Get (
     *     path="/files",
     *     tags={"Файлы"},
     *     summary="Файлы пользователя",
     *     security={
     *       {"apiAuth": {}}
     *     },
     *      @OA\Response(response="200", description="Успешно"),
     *      @OA\Response(response="401", description="Не авторизован")
     *     )
     *
     *
     */
    public function index(Request $request)
    {
        $files = $this->fileRepository->getAllByUser($request);

        return response()->json(
            FileResource::collection($files)
        );
    }


    public function download(string $filename)
    {
        $file = Storage::disk('s3')->url('files/' . $filename);

        return response()->json(['url' => $file]);
    }

    /**
     *
     *
     * @OA\Post (
     *     path="/files",
     *     tags={"Файлы"},
     *     summary="Загрузка файлов",
     *     security={
     *       {"apiAuth": {}}
     *     },
     *     @OA\RequestBody (
     *          required=true,
     *          @OA\MediaType (
     *              mediaType="multipart/form-data",
     *              @OA\Schema (
     *                  type="object",
     *                   @OA\Property (
     *                      property="files[]",
     *                      description="Файлы",
     *                      type="file"
     *                  )
     *              )
     *          ),
     *     ),
     *      @OA\Response(response="200", description="Успешно"),
     *      @OA\Response(response="401", description="Не авторизован"),
     *      @OA\Response(response="422", description="Неверные данные")
     *     )
     *
     *
     */
    public function store(Request $request)
    {
        $user = auth()->user();

        $request->validate([
            'files.*' => 'mimes:jpeg,png,jpg,doc,docx,xlsx|max:2048'
        ]);

        foreach($request->file('files') as $file) {
            $name = $file->getClientOriginalName();
            $path = explode('/', $file->store('files', 's3'))[1];
            $user->files()->create(['filename' => $path, 'name' => $name, 'category' => 'Остальное']);
        }

        return response()->json()->setStatusCode(200);
    }

    /**
     *
     *
     * @OA\Get (
     *     path="/files/{userId}",
     *     tags={"Файлы"},
     *     summary="Файлы пользователя для профиля",
     *       @OA\Parameter(
     *         description="ID пользователя",
     *         in="path",
     *         name="userId",
     *         required=true,
     *         @OA\Schema(
     *           type="integer"
     *         )
     *     ),
     *      @OA\Response(response="200", description="Успешно"),
     *      @OA\Response(response="404", description="Не найдено"),
     *     )
     *
     *
     */
    public function show($id)
    {
        $user = User::find((int) $id);

        if (!$user) return response()->json(null, 404);

        return response()->json(
            FileResource::collection($user->files)
        );
    }

    /**
     *
     *
     * @OA\Put (
     *     path="/files/{fileId}",
     *     security={
     *       {"apiAuth": {}}
     *     },
     *     tags={"Файлы"},
     *     summary="Изменения категории файла",
     *       @OA\Parameter(
     *         description="ID файла",
     *         in="path",
     *         name="fileId",
     *         required=true,
     *        ),
     *
     *       @OA\RequestBody(
     *          required=true,
     *          @OA\MediaType (
     *              mediaType="application/json",
     *              @OA\Schema (
     *                  @OA\Property (
     *                      property="category",
     *                      type="string",
     *                      enum={"Остальное", "Награды", "Методички"},
     *                      default="Остальное"
     *                  )
     *              )
     *          )
     *     ),
     *     @OA\Response(response="200", description="Успешно"),
     *      @OA\Response(response="401", description="Не авторизован"),
     *      @OA\Response(response="404", description="Не найдено")
     *     )
     *
     *
     */
    public function update(Request $request, File $file)
    {
        $request->validate([
            'category' => Rule::in('Остальное', 'Награды', 'Методички')
        ]);

        $file->update(['category' => $request->category]);

        return response()->json();
    }

    /**
     *
     *
     * @OA\Delete (
     *     path="/files/{fileId}",
     *     tags={"Файлы"},
     *     summary="Удаление файла",
     *     security={
     *       {"apiAuth": {}}
     *     },
     *       @OA\Parameter(
     *         description="ID файла",
     *         in="path",
     *         name="fileId",
     *         required=true,
     *         @OA\Schema(
     *           type="integer"
     *         )
     *     ),
     *      @OA\Response(response="200", description="Успешно"),
     *      @OA\Response(response="401", description="Не авторизован"),
     *      @OA\Response(response="404", description="Не найдено"),
     *     )
     *
     *
     */
    public function destroy(int $id)
    {
        $file = File::find($id);

        if (!$file) {
            return response()->json(null, 404);
        }

        $filename = $file->filename;

        $file->delete();

        Storage::disk('s3')->delete('files/' . $filename);

        return response()->json();
    }

}
