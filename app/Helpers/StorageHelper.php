<?php

namespace App\Helpers;

use Exception;
use Illuminate\Support\Facades\Storage;

/**
 * StorageHelper - Global Helper for File Storage Operations
 *
 * Provides reusable methods for handling file storage URLs across different
 * filesystem disks and configurations.
 *
 * @package App\Helpers
 * @version 1.0.0
 * @author Softmax Technologies
 */
class StorageHelper
{
    /**
     * Get the URL for a file with specific disk configuration.
     * Useful for settings that have their own disk configuration.
     *
     * @param string|null $filePath
     * @param string $configKey The config key for the disk (e.g., 'filesystems.print_settings_disk')
     * @param string $defaultDisk Default disk if config not found
     * @return string|null
     */
    public static function getConfigurableStorageUrl(?string $filePath, string $configKey, string $defaultDisk = 'public'): ?string
    {
        $disk = config($configKey, $defaultDisk);
        return self::getStorageUrl($filePath, $disk);
    }

    /**
     * Get the URL for a file path, handling different filesystem disks.
     * This is a reusable method that can work with any file type and disk configuration.
     *
     * @param string|null $filePath
     * @param string|null $disk The specific disk to use (optional, will auto-detect)
     * @param string|null $fallbackDisk Fallback disk if primary fails
     * @return string|null
     */
    public static function getStorageUrl(?string $filePath, ?string $disk = null, ?string $fallbackDisk = null): ?string
    {
        if (!$filePath) {
            return null;
        }

        // Check if it's already a full URL (for S3, etc.)
        if (filter_var($filePath, FILTER_VALIDATE_URL)) {
            return $filePath;
        }

        // Use provided disk or try to detect from config
        if (!$disk) {
            $disk = config('filesystems.default', 'public');
        }

        // Check if it's a storage path (starts with storage/)
        if (str_starts_with($filePath, 'storage/')) {
            return asset($filePath);
        }

        // Try to get the URL from the specified disk
        try {
            if (Storage::disk($disk)->exists($filePath)) {
                return Storage::disk($disk)->url($filePath);
            }
        } catch (Exception $e) {
            // If the specified disk fails, try fallback disks
            $fallbackDisks = $fallbackDisk ? [$fallbackDisk] : ['public', 's3', 'local', 'ftp'];

            foreach ($fallbackDisks as $fallbackDiskName) {
                if ($fallbackDiskName !== $disk && config("filesystems.disks.{$fallbackDiskName}")) {
                    try {
                        if (Storage::disk($fallbackDiskName)->exists($filePath)) {
                            return Storage::disk($fallbackDiskName)->url($filePath);
                        }
                    } catch (Exception $e2) {
                        // Continue to next fallback
                        continue;
                    }
                }
            }
        }

        // Final fallback - try to construct URL based on disk type
        if ($disk === 'public') {
            return asset('storage/' . $filePath);
        }

        // For other disks, return the path as-is (might be a full URL from S3, etc.)
        return $filePath;
    }

    /**
     * Get the URL for an image file with common image processing options.
     *
     * @param string|null $imagePath
     * @param string|null $disk
     * @param bool $addTimestamp Add timestamp for cache busting
     * @return string|null
     */
    public static function getImageUrl(?string $imagePath, ?string $disk = null, bool $addTimestamp = false): ?string
    {
        $url = self::getStorageUrl($imagePath, $disk);

        if ($url && $addTimestamp && file_exists(public_path('storage/' . $imagePath))) {
            $timestamp = filemtime(public_path('storage/' . $imagePath));
            $url .= '?v=' . $timestamp;
        }

        return $url;
    }

    /**
     * Get the URL for a document file.
     *
     * @param string|null $filePath
     * @param string|null $disk
     * @return string|null
     */
    public static function getDocumentUrl(?string $filePath, ?string $disk = null): ?string
    {
        return self::getStorageUrl($filePath, $disk);
    }

    /**
     * Check if a file exists on any of the configured disks.
     *
     * @param string $filePath
     * @param array $disks Array of disk names to check
     * @return bool
     */
    public static function fileExistsOnAnyDisk(string $filePath, array $disks = ['public', 's3', 'local']): bool
    {
        foreach ($disks as $disk) {
            try {
                if (Storage::disk($disk)->exists($filePath)) {
                    return true;
                }
            } catch (Exception $e) {
                continue;
            }
        }

        return false;
    }

    /**
     * Get file information including size, mime type, and last modified.
     *
     * @param string $filePath
     * @param string|null $disk
     * @return array|null
     */
    public static function getFileInfo(string $filePath, ?string $disk = null): ?array
    {
        if (!$disk) {
            $disk = config('filesystems.default', 'public');
        }

        try {
            if (!Storage::disk($disk)->exists($filePath)) {
                return null;
            }

            return [
                'path' => $filePath,
                'disk' => $disk,
                'size' => Storage::disk($disk)->size($filePath),
                'mime_type' => Storage::disk($disk)->mimeType($filePath),
                'last_modified' => Storage::disk($disk)->lastModified($filePath),
                'url' => self::getStorageUrl($filePath, $disk),
            ];
        } catch (Exception $e) {
            return null;
        }
    }
}
