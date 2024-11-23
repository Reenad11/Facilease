<?php

namespace App\Traits;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;

trait UploadFile
{
    public function upload(UploadedFile $file, string $path = 'uploads', string $slug = 'dummy slug'): string
    {
        $slug = Str::slug($slug);
        $currentDate = Carbon::now()->toDateString();
        $imageName = $slug . '-' . $currentDate . '-' . uniqid() . '.' . $file->getClientOriginalExtension();
        if (!file_exists($path)) {
            mkdir($path);
        }
        $file->move($path, $imageName);
        return $path.'/'.$imageName;
    }

    public function removeOldImage(string $path): bool
    {
        if (File::exists($path)) {
           return File::delete($path);
        }
        return false;
    }
}
