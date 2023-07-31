<?php

namespace App\Traits;

use Faker\Provider\Uuid;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

trait UploadFile
{
    private function getPhoto()
    {
        return Uuid::uuid();
    }

    private function updatePhoto($source)
    {
        return Uuid::uuid();
    }

    private function deletePhoto($sosialMediaFile)
    {
        return Uuid::uuid();
    }
}
