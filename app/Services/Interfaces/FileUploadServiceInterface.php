<?php
namespace App\Services\Interfaces;

use Illuminate\Http\UploadedFile;

interface FileUploadServiceInterface
{
    public function uploadFile(UploadedFile $file): string;
    public function deleteFile(string $url): bool;
}
