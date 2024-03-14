<?php

namespace App\Services;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Exception;

class FileUploadService
{
    public function uploadFile($file)
    {
        try {
            // Generate a unique name for the file
            $fileName = Str::random(20). time() . '.' . $file->getClientOriginalExtension();

            // Store the file in the 'public' disk (you can configure other disks as needed)
            Storage::disk('public')->putFileAs('profiles', $file, $fileName);

            // Return the file path for future use (e.g., storing in the database)
            return $fileName;
        } catch (\Throwable $e) {
            throw new \Exception($e->getMessage());
        }
    }
}
