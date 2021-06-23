<?php

namespace App\Http\Controllers\Account;

use App\Http\Controllers\Controller;
use App\Http\Requests\Account\UploadPhotoRequest;
use App\Repositories\FileRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class UploadPhotoController extends Controller
{

    public function __construct()
    {
        $this->fileRepository = new FileRepository();
    }

    public function __invoke(UploadPhotoRequest $request)
    {
        $user = auth()->user();

        if ($request->file('photo')) {
            if ($user->photo != null) {
                Storage::disk('s3')->delete('photos/' . $user->photo);
            }

            $path = $request->file('photo')->store('photos', 's3');
            $url = Storage::disk('s3')->url($path);
            $filename = explode('/', $path)[1];

            $user->update([
                'photo' => $filename
            ]);

            return response()->json([
                'url' => $url
            ]);
        }
    }
}
