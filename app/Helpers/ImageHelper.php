<?php

namespace App\Helpers;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

class ImageHelper
{
    // public static function convertToWebp(
    //     $imgFile,
    //     string $destinationPath,
    //     int $targetWidth = 1920,
    //     int $targetHeight = 1080,
    //     int $quality = 96
    // ): ?string {
    //     try {
    //         $manager = new ImageManager(new Driver());

    //         $image = $manager->read($imgFile)->orient();

    //         $srcW = $image->width();
    //         $srcH = $image->height();

    //         $srcRatio    = $srcW / $srcH;
    //         $targetRatio = $targetWidth / $targetHeight;

    //         if ($srcRatio > $targetRatio) {
    //             $image->scale(height: $targetHeight);
    //         } else {
    //             $image->scale(width: $targetWidth);
    //         }

    //         $canvas = $manager
    //             ->create($targetWidth, $targetHeight)
    //             ->fill('#000000');

    //         $canvas->place($image, 'center');
    //         $canvas->sharpen(10);

    //         if (!is_dir($destinationPath)) {
    //             mkdir($destinationPath, 0777, true);
    //         }

    //         $filename = Str::uuid()->toString() . '.webp';

    //         $canvas
    //             ->encodeByExtension('webp', quality: $quality)
    //             ->save($destinationPath . '/' . $filename);

    //         return $filename;
    //     } catch (\Throwable $e) {
    //         Log::error('Image conversion failed', [
    //             'error' => $e->getMessage()
    //         ]);

    //         return null;
    //     }
    // }


    public static function convertToWebp(
    $imgFile,
    string $destinationPath,
    int $quality = 96
): ?string {
    try {
        $manager = new ImageManager(new Driver());

        // Read and auto rotate image
        $image = $manager->read($imgFile)->orient();

        // Create folder if not exists
        if (!is_dir($destinationPath)) {
            mkdir($destinationPath, 0777, true);
        }

        // Generate unique name
        $filename = Str::uuid()->toString() . '.webp';

        // Encode directly to webp (no resize)
        $image
            ->encodeByExtension('webp', quality: $quality)
            ->save($destinationPath . '/' . $filename);

        return $filename;

    } catch (\Throwable $e) {
        Log::error('Image conversion failed', [
            'error' => $e->getMessage()
        ]);

        return null;
    }
}

}
