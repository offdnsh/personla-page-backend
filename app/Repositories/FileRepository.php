<?php


namespace App\Repositories;


use App\Models\File;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class FileRepository
{

    public function getAllByUser(Request $request)
    {
        $user = auth()->user();
        $categories = ['Остальное', 'Награды', 'Методички'];
        $query = $user->files();

        if ($request->has('category')) {
            if (in_array($request->query('category'), $categories)) {
                $query->where('category', $request->query('category'));
            }
        }

        return $query->get();
    }

    public function getAll($id)
    {
        $user = User::findOrFail($id);
        return $user->files;
    }

    public function show(string $name)
    {

    }

    public function find(string $name)
    {
        $files = collect(Storage::cloud()->listContents());
        return $files->where('name', '=', $name)->first();
    }

    public function delete(string $name)
    {
        $files = collect(Storage::cloud()->listContents());
        $file = $files->where('name', '=', $name)->first();
        File::where('filename', $name)->delete();
        Storage::cloud()->delete($file['path']);
    }

    public function getLink(string $name)
    {
        $files = collect(Storage::cloud()->listContents());
        $file = $files->where('name', '=', $name)->first();
    }
}
