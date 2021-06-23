<?php

namespace App\Http\Resources\File;

use Illuminate\Http\Resources\Json\JsonResource;

class FileResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'filename' => $this->filename,
            'name' => $this->name,
            'category' => $this->category,
            'created_at' => (int) $this->created_at->format('U'),
            'updated_at' => $this->updated_at->format('d.m.Y H:m:s')
        ];
    }
}
