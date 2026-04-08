<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class CloudinaryService
{
    /**
     * Upload an image to Cloudinary
     * 
     * @param string|\Illuminate\Http\UploadedFile $file Path to file or UploadedFile object
     * @param string $folder Folder name in Cloudinary
     * @return string|null The secure URL of the uploaded image
     */
    public function upload($file, string $folder = 'portfolio')
    {
        $cloudName = config('services.cloudinary.cloud_name');
        $uploadPreset = config('services.cloudinary.upload_preset');

        if (!$cloudName || !$uploadPreset) {
            Log::warning('Cloudinary credentials not set. Falling back to local storage.');
            return null;
        }

        try {
            $response = Http::attach(
                'file', 
                is_string($file) ? fopen($file, 'r') : fopen($file->getRealPath(), 'r'),
                is_string($file) ? basename($file) : $file->getClientOriginalName()
            )->post("https://api.cloudinary.com/v1_1/{$cloudName}/image/upload", [
                'upload_preset' => $uploadPreset,
                'folder' => $folder,
            ]);

            if ($response->successful()) {
                return $response->json('secure_url');
            }

            Log::error('Cloudinary upload failed: ' . $response->body());
            return null;
        } catch (\Exception $e) {
            Log::error('Cloudinary error: ' . $e->getMessage());
            return null;
        }
    }
}
