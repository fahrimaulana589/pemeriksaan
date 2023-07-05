<?php

namespace App\Traits;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

trait UploadFile
{
    private function getPhoto()
    {
        return request()->get('file')->store('files');
    }

    private function updatePhoto($source)
    {
        if (request()->get('file') != null) {
            Storage::delete($source);

            $file = request()->get('file')->store('files');

            return $file;
        }
        return $source;
    }

    private function deletePhoto($sosialMediaFile)
    {
        return Storage::delete($sosialMediaFile);
    }
}
