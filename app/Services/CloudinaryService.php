<?php

namespace App\Services;

use Cloudinary\Cloudinary;
use Illuminate\Support\Facades\Log;
use Exception;

class CloudinaryService
{
    protected $cloudinary;

    public function __construct()
    {
        $this->cloudinary = new Cloudinary([
            'cloud' => [
                'cloud_name' => config('services.cloudinary.cloud_name'),
                'api_key'    => config('services.cloudinary.api_key'),
                'api_secret' => config('services.cloudinary.api_secret'),
            ],
        ]);
    }

    /**
     * Upload an image to Cloudinary
     */
    public function upload($file, $folder = 'portfolio')
    {
        try {
            $result = $this->cloudinary->uploadApi()->upload(
                is_string($file) ? $file : $file->getRealPath(),
                [
                    'folder' => $folder,
                    'resource_type' => 'auto',
                ]
            );

            return $result['secure_url'];
        } catch (Exception $e) {
            \Log::error('Cloudinary Upload Error: ' . $e->getMessage());
            return null;
        }
    }

    /**
     * Delete an image from Cloudinary
     */
    public function delete($url)
    {
        if (!$url) return false;

        try {
            // Extract public_id from URL
            $path = parse_url($url, PHP_URL_PATH);
            $filename = basename($path);
            $publicId = explode('.', $filename)[0];
            
            // If in folder, public_id includes folder name
            $segments = explode('/', $path);
            if (count($segments) > 2) {
                $folder = $segments[count($segments)-2];
                $publicId = $folder . '/' . $publicId;
            }

            $this->cloudinary->uploadApi()->destroy($publicId);
            return true;
        } catch (Exception $e) {
            \Log::error('Cloudinary Delete Error: ' . $e->getMessage());
            return false;
        }
    }
}
