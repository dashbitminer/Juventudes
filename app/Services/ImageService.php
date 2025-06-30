<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

class ImageService
{
    protected ImageManager $imageManager;

    public function __construct()
    {
        $this->imageManager = new ImageManager(new Driver());
    }

    /**
     * Compress and upload image to S3
     *
     * @param UploadedFile $file
     * @param string $path
     * @param int $quality
     * @return string
     */
    public function compressAndUpload(UploadedFile $file, string $path = 'images', int $quality = 70): string
    {
        // Create image instance
        $image = $this->imageManager->read($file);

        // Resize if image is too large (optional)
        if ($image->width() > 2000) {
            $image->scale(2000);
        }

        // Convert to WebP format for better compression
        $stream = $image->toWebp($quality)->toFilePointer();

        // Generate unique filename
        $filename = uniqid() . '.webp';
        $fullPath = $path . '/' . $filename;

        // Get compressed image stream
        //$stream = $image->toFilePointer();
        rewind($stream);

        // Upload to S3
        Storage::disk('s3')->put($fullPath, $stream);

        // Close the stream
        fclose($stream);

        // Return the full path
        return $fullPath;
    }
}
