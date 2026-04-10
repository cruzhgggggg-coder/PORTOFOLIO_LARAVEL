<?php

namespace App\Services;

use Illuminate\Support\Facades\Storage;

class ImageOptimizer
{
    /**
     * Optimize profile photo: resize, compress, and convert to WebP
     * 
     * @param string $filePath The stored file path (e.g., 'profile/image.jpg')
     * @param int $maxWidth Maximum width (maintains aspect ratio)
     * @param int $quality Quality level (1-100)
     * @return string Optimized file path with .webp extension
     */
    public function optimizeProfilePhoto(string $filePath, int $maxWidth = 800, int $quality = 85): string
    {
        return $this->optimizeImage($filePath, $maxWidth, $quality, 'profile');
    }

    /**
     * Optimize project image: resize, compress, and convert to WebP
     * 
     * @param string $filePath The stored file path (e.g., 'projects/image.jpg')
     * @param int $maxWidth Maximum width (maintains aspect ratio)
     * @param int $quality Quality level (1-100)
     * @return string Optimized file path with .webp extension
     */
    public function optimizeProjectImage(string $filePath, int $maxWidth = 1200, int $quality = 80): string
    {
        return $this->optimizeImage($filePath, $maxWidth, $quality, 'projects');
    }

    /**
     * Core image optimization logic using native PHP GD
     */
    protected function optimizeImage(string $filePath, int $maxWidth, int $quality, string $folder): string
    {
        // Read the image from storage
        $imageData = Storage::disk('public')->get($filePath);

        if (!$imageData) {
            return $filePath; // Return original if can't read
        }

        // Create temporary file for processing
        $tempInput = tempnam(sys_get_temp_dir(), 'img_opt_');
        file_put_contents($tempInput, $imageData);

        // Get image info
        $imageInfo = getimagesize($tempInput);
        if (!$imageInfo) {
            unlink($tempInput);
            return $filePath;
        }

        $mime = $imageInfo['mime'];
        $width = $imageInfo[0];
        $height = $imageInfo[1];

        // Create image resource based on type
        $source = null;
        switch ($mime) {
            case 'image/jpeg':
                $source = imagecreatefromjpeg($tempInput);
                break;
            case 'image/png':
                $source = imagecreatefrompng($tempInput);
                break;
            case 'image/gif':
                $source = imagecreatefromgif($tempInput);
                break;
            case 'image/webp':
                $source = imagecreatefromwebp($tempInput);
                break;
        }

        if (!$source) {
            unlink($tempInput);
            return $filePath;
        }

        // Calculate new dimensions
        $newWidth = $width;
        $newHeight = $height;
        if ($width > $maxWidth) {
            $newWidth = $maxWidth;
            $newHeight = intval($height * ($maxWidth / $width));
        }

        // Create new image with new dimensions
        $dest = imagecreatetruecolor($newWidth, $newHeight);

        // Preserve transparency for PNG
        if ($mime === 'image/png') {
            imagealphablending($dest, false);
            imagesavealpha($dest, true);
        }

        // Resize
        imagecopyresampled($dest, $source, 0, 0, 0, 0, $newWidth, $newHeight, $width, $height);

        // Generate new filename with .webp extension
        $pathInfo = pathinfo($filePath);
        $newFileName = $pathInfo['filename'] . '.webp';
        $newFilePath = $folder . '/' . $newFileName;

        // Save as WebP
        $tempOutput = tempnam(sys_get_temp_dir(), 'img_opt_out_') . '.webp';
        imagewebp($dest, $tempOutput, $quality);

        // Read the WebP data
        $webpData = file_get_contents($tempOutput);

        // Clean up
        unlink($tempInput);
        unlink($tempOutput);

        // Delete original file
        Storage::disk('public')->delete($filePath);

        // Save optimized WebP
        Storage::disk('public')->put($newFilePath, $webpData);

        return $newFilePath;
    }

    /**
     * Optimize existing images in storage (for migration/cleanup)
     */
    public function optimizeAllExisting(): array
    {
        $results = [
            'profile' => 0,
            'projects' => 0,
            'errors' => [],
        ];

        // Optimize profile photos
        $profileFiles = Storage::disk('public')->files('profile');
        foreach ($profileFiles as $file) {
            try {
                // Skip if already WebP
                if (str_ends_with($file, '.webp')) {
                    continue;
                }
                $this->optimizeProfilePhoto($file);
                $results['profile']++;
            } catch (\Exception $e) {
                $results['errors'][] = "Profile $file: " . $e->getMessage();
            }
        }

        // Optimize project images
        $projectFiles = Storage::disk('public')->files('projects');
        foreach ($projectFiles as $file) {
            try {
                // Skip if already WebP
                if (str_ends_with($file, '.webp')) {
                    continue;
                }
                $this->optimizeProjectImage($file);
                $results['projects']++;
            } catch (\Exception $e) {
                $results['errors'][] = "Project $file: " . $e->getMessage();
            }
        }

        return $results;
    }
}
