<?php

use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

function deleteTempImages()
{
    File::cleanDirectory(storage_path('app/private/livewire-tmp'));
}

function uploadFile($file, string $folder, string $disk = 'public'): ?string
{
    if (!$file) {
        return null;
    }

    $fileName = Str::uuid() . '.' . $file->getClientOriginalExtension();

    $path = $file->storeAs("uploads/" . $folder, $fileName, $disk);

    return $fileName;
}

function deleteFile(?string $fileName, string $folder): bool
{
    if (empty($fileName) || empty($folder)) {
        return false;
    }

    $filePath = public_path("uploads/{$folder}/{$fileName}");

    if (file_exists($filePath)) {
        return unlink($filePath);
    }

    return false;
}

function getFile(?string $fileName, string $folder): bool
{
    if (empty($fileName) || empty($folder)) {
        return ""; //avatar image
    }

    $filePath = public_path("uploads/{$folder}/{$fileName}");


    return $filePath;
}
