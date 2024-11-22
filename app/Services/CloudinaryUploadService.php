<?php
namespace App\Services;

use App\Services\Interfaces\FileUploadServiceInterface;
use Google\Cloud\Storage\StorageClient;
use Illuminate\Http\UploadedFile;
use Cloudinary\Configuration\Configuration;
use Cloudinary\Api\Upload\UploadApi;
use Cloudinary\Api\Exception\ApiError;
use Cloudinary\Cloudinary;

class CloudinaryUploadService implements FileUploadServiceInterface
{
    private Cloudinary $cloudinary;

    public function __construct()
    {
        $this->cloudinary = new Cloudinary([
            'cloud' => [
                'cloud_name' => env("CLOUDINARY_CLOUD_NAME"),
                'api_key' => env("CLOUDINARY_API_KEY"),
                'api_secret' => env("CLOUDINARY_API_SECRET"),
            ],
        ]);
    }


    public function uploadFile(UploadedFile $file): string
    {
        try {
            $result = $this->cloudinary->uploadApi()->upload($file->getRealPath(), [
                'folder' => 'photos',
            ]);
            return $result['secure_url'];
        } catch (ApiError $e) {
            throw new \RuntimeException('File upload failed: ' . $e->getMessage());
        }
    }


    public function deleteFile(string $url): bool
    {
        try {
            $publicId = $this->getPublicIdFromUrl($url);
            $result = $this->cloudinary->uploadApi()->destroy($publicId);
            return $result['result'] === 'ok';
        } catch (ApiError $e) {
            throw new \RuntimeException('File deletion failed: ' . $e->getMessage());
        }
    }

    private function getPublicIdFromUrl(string $url): string
    {
        $path = parse_url($url, PHP_URL_PATH);
        $parts = explode('/', $path);
        $filename = end($parts);
        return pathinfo($filename, PATHINFO_FILENAME);
    }
}
