<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class ImageHelper
{
    public static function saveImageFromUrl(string $url): ?string
    {
        try {
            // Validate URL
            if (empty($url) || !filter_var($url, FILTER_VALIDATE_URL)) {
                return null;
            }

            // Generate unique filename
            $extension = pathinfo(parse_url($url, PHP_URL_PATH), PATHINFO_EXTENSION);
            if (empty($extension)) {
                $extension = 'png'; // default extension
            }
            $filename = 'img_' . Str::random(10) . '.' . $extension;

            // Download image with timeout
            $response = Http::timeout(30)->get($url);
            
            if (!$response->successful()) {
                Log::warning("Failed to download image: HTTP " . $response->status() . " - " . $url);
                return null;
            }

            $imageData = $response->body();

            // Create temp directory if it doesn't exist
            $tempDir = public_path('temp');
            if (!file_exists($tempDir)) {
                mkdir($tempDir, 0755, true);
            }

            // Save directly to public/temp directory
            $fullPath = $tempDir . '/' . $filename;
            file_put_contents($fullPath, $imageData);

            // Return absolute path for DomPDF
            return $fullPath;
        } catch (\Exception $e) {
            Log::error("Error downloading image from {$url}: " . $e->getMessage());
            return null;
        }
    }
    
    /**
     * Clean old temporary images (optional, call this periodically)
     */
    public static function cleanTempImages(): void
    {
        try {
            $tempDir = public_path('temp');
            if (file_exists($tempDir)) {
                $files = glob($tempDir . '/img_*.{png,jpg,jpeg,gif,webp}', GLOB_BRACE);
                $now = time();
                foreach ($files as $file) {
                    // Delete files older than 1 hour
                    if (is_file($file) && ($now - filemtime($file)) > 3600) {
                        unlink($file);
                    }
                }
            }
        } catch (\Exception $e) {
            Log::error("Error cleaning temp images: " . $e->getMessage());
        }
    }
}
