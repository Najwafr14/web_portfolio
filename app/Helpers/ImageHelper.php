<?php

namespace App\Helpers;

use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class ImageHelper
{
    /**
     * Upload dan compress image
     * 
     * @param \Illuminate\Http\UploadedFile $file
     * @param string $folder (skills, portfolio, person, dll)
     * @param int $maxWidth
     * @param int $quality
     * @return array ['original' => 'filename.jpg', 'compressed' => 'filename.jpg']
     */
    public static function uploadAndCompress($file, $folder, $maxWidth = 1200, $quality = 80)
    {
        // Generate unique filename
        $filename = time() . '_' . Str::random(10) . '.' . $file->getClientOriginalExtension();
        
        // Path folders
        $originalPath = public_path('assets/img/' . $folder . '/original');
        $compressedPath = public_path('assets/img/' . $folder);
        
        // Buat folder kalau belum ada
        if (!File::exists($originalPath)) {
            File::makeDirectory($originalPath, 0755, true);
        }
        if (!File::exists($compressedPath)) {
            File::makeDirectory($compressedPath, 0755, true);
        }
        
        // Simpan original
        $file->move($originalPath, $filename);
        
        // Initialize ImageManager with GD Driver for v3
        $manager = new ImageManager(new Driver());
        
        // Read and compress image
        $image = $manager->read($originalPath . '/' . $filename);
        
        // Resize jika lebih besar dari maxWidth
        if ($image->width() > $maxWidth) {
            $image->scale(width: $maxWidth, height: null);
        }
        
        // Compress dan simpan
        $image->save($compressedPath . '/' . $filename, quality: $quality, format: 'jpeg');
        
        return [
            'original' => $filename,
            'compressed' => $filename,
            'path' => 'assets/img/' . $folder . '/' . $filename,
            'full_path' => $compressedPath . '/' . $filename
        ];
    }
    
    /**
     * Delete image (original & compressed)
     * 
     * @param string $filename
     * @param string $folder
     * @return bool
     */
    public static function deleteImage($filename, $folder)
    {
        if (!$filename) {
            return false;
        }
        
        $originalPath = public_path('assets/img/' . $folder . '/original/' . $filename);
        $compressedPath = public_path('assets/img/' . $folder . '/' . $filename);
        
        $deleted = false;
        
        if (File::exists($originalPath)) {
            File::delete($originalPath);
            $deleted = true;
        }
        
        if (File::exists($compressedPath)) {
            File::delete($compressedPath);
            $deleted = true;
        }
        
        return $deleted;
    }
    
    /**
     * Compress existing image
     * 
     * @param string $path
     * @param int $quality
     * @return bool
     */
    public static function compressExisting($path, $quality = 80)
    {
        if (!File::exists($path)) {
            return false;
        }
        
        $manager = new ImageManager(new Driver());
        $image = $manager->read($path);
        $image->save($path, quality: $quality, format: 'jpeg');
        
        return true;
    }
    
    /**
     * Resize image to specific dimensions
     * 
     * @param string $path
     * @param int $width
     * @param int $height
     * @param bool $aspectRatio
     * @return bool
     */
    public static function resizeImage($path, $width, $height = null, $aspectRatio = true)
    {
        if (!File::exists($path)) {
            return false;
        }
        
        $manager = new ImageManager(new Driver());
        $image = $manager->read($path);
        
        if ($aspectRatio) {
            $image->scale(width: $width, height: $height);
        } else {
            $image->resize($width, $height);
        }
        
        $image->save($path);
        
        return true;
    }
    
    /**
     * Create thumbnail
     * 
     * @param string $sourcePath
     * @param string $folder
     * @param int $width
     * @param int $height
     * @return string|null
     */
    public static function createThumbnail($sourcePath, $folder, $width = 300, $height = 300)
    {
        if (!File::exists($sourcePath)) {
            return null;
        }
        
        $filename = basename($sourcePath);
        $thumbnailPath = public_path('assets/img/' . $folder . '/thumbnails');
        
        if (!File::exists($thumbnailPath)) {
            File::makeDirectory($thumbnailPath, 0755, true);
        }
        
        $manager = new ImageManager(new Driver());
        $image = $manager->read($sourcePath);
        $image->cover($width, $height);
        $image->save($thumbnailPath . '/' . $filename, quality: 80, format: 'jpeg');
        
        return 'assets/img/' . $folder . '/thumbnails/' . $filename;
    }
    
    /**
     * Validate image
     * 
     * @param \Illuminate\Http\UploadedFile $file
     * @param int $maxSizeMB
     * @return array ['valid' => bool, 'error' => string|null]
     */
    public static function validateImage($file, $maxSizeMB = 5)
    {
        // Check if file exists
        if (!$file) {
            return ['valid' => false, 'error' => 'No file uploaded'];
        }
        
        // Check mime type
        $allowedMimes = ['image/jpeg', 'image/jpg', 'image/png', 'image/gif', 'image/webp'];
        if (!in_array($file->getMimeType(), $allowedMimes)) {
            return ['valid' => false, 'error' => 'Invalid file type. Only JPG, PNG, GIF, and WEBP are allowed.'];
        }
        
        // Check file size
        $maxSizeBytes = $maxSizeMB * 1024 * 1024;
        if ($file->getSize() > $maxSizeBytes) {
            return ['valid' => false, 'error' => 'File size exceeds ' . $maxSizeMB . 'MB limit.'];
        }
        
        return ['valid' => true, 'error' => null];
    }
    
    /**
     * Get image info
     * 
     * @param string $path
     * @return array|null
     */
    public static function getImageInfo($path)
    {
        if (!File::exists($path)) {
            return null;
        }
        
        $manager = new ImageManager(new Driver());
        $image = $manager->read($path);
        
        return [
            'width' => $image->width(),
            'height' => $image->height(),
            'mime' => $image->mime(),
            'size' => File::size($path),
            'size_kb' => round(File::size($path) / 1024, 2),
            'size_mb' => round(File::size($path) / 1024 / 1024, 2),
        ];
    }
}