<?php

use Flasher\Laravel\Facade\Flasher;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Livewire\Livewire;

function deleteTempImages()
{
    File::cleanDirectory(storage_path('app/private/livewire-tmp'));
}

function uploadFile($file, string $folder, string $disk = 'public'): ?string
{
    $fileName = null;
    if ($file && $folder) {
        $fileName = Str::uuid() . '.' . $file->getClientOriginalExtension();
        $file->storeAs("uploads/{$folder}", $fileName, $disk);
    }

    return $fileName;
}

function deleteFile(?string $fileName, string $folder): bool
{
    if ($fileName && $folder) {
        $path = public_path("storage/uploads/{$folder}/{$fileName}");
        if (file_exists($path)) {
            unlink($path);
        }
    }

    return true;
}

function getFile(?string $fileName, string $folder)
{
    $imagePath = asset("no-image.jpg");
    if ($fileName && $folder) {
        $path = public_path("storage/uploads/{$folder}/{$fileName}");
        if (file_exists($path)) {
            $imagePath = asset("storage/uploads/{$folder}/$fileName");
        }
    }

    return $imagePath;
}

function success_msg($message){
    flash()->success($message);
}

function error_msg($message){
    flash()->error($message);
}

function warning_msg($message){
    flash()->warning($message);
}

function validateBdPhoneNo() {
    return 'regex:/^(?:\+?88)?01[3-9]\d{8}$/';
}
