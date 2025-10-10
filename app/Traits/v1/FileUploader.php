<?php

namespace App\Traits\v1;

use Exception;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\Laravel\Facades\Image;

/**
 * FileUploader Trait - Version 1
 *
 * Modern file uploader trait that supports all Laravel filesystem disks
 * with best practices for file handling, validation, and storage.
 *
 * @package App\Traits\v1
 * @version 1.0.0
 * @author Softmax Technologies
 */
trait FileUploader
{
    /**
     * Default file extensions for different file types
     */
    protected array $fileExtensions = [
        'image' => ['jpg', 'jpeg', 'png', 'gif', 'ico', 'svg', 'webp', 'bmp', 'tiff'],
        'document' => ['pdf', 'doc', 'docx', 'txt', 'rtf', 'odt'],
        'spreadsheet' => ['xls', 'xlsx', 'csv', 'ods'],
        'presentation' => ['ppt', 'pptx', 'odp'],
        'archive' => ['zip', 'rar', '7z', 'tar', 'gz'],
        'video' => ['mp4', 'avi', 'mpeg', '3gp', 'mov', 'ogg', 'mkv', 'webm'],
        'audio' => ['mp3', 'wav', 'ogg', 'aac', 'flac'],
        'code' => ['php', 'js', 'css', 'html', 'json', 'xml', 'sql'],
    ];

    /**
     * Update an existing file.
     *
     * @param UploadedFile $file
     * @param string $directory
     * @param string $disk
     * @param string|null $oldFilePath
     * @param array $allowedExtensions
     * @param int|null $maxSize
     * @return string|null
     */
    public function updateFile(
        UploadedFile $file,
        string       $directory = 'uploads',
        string       $disk = 'public',
        ?string      $oldFilePath = null,
        array        $allowedExtensions = [],
        ?int         $maxSize = null
    ): ?string
    {
        try {
            // Delete old file if exists
            if ($oldFilePath && Storage::disk($disk)->exists($oldFilePath)) {
                Storage::disk($disk)->delete($oldFilePath);
            }

            // Upload new file
            return $this->uploadFile($file, $directory, $disk, $allowedExtensions, $maxSize);

        } catch (Exception $e) {
            Log::error("File update failed", [
                'error' => $e->getMessage(),
                'file' => $file->getClientOriginalName(),
                'old_path' => $oldFilePath
            ]);
            return null;
        }
    }

    /**
     * Upload a single file to the specified disk and directory.
     *
     * @param UploadedFile $file
     * @param string $directory
     * @param string $disk
     * @param array $allowedExtensions
     * @param int|null $maxSize Size in bytes
     * @return string|null
     */
    public function uploadFile(
        UploadedFile $file,
        string       $directory = 'uploads',
        string       $disk = 'public',
        array        $allowedExtensions = [],
        ?int         $maxSize = null
    ): ?string
    {
        try {
            // Validate file
            if (!$this->validateFile($file, $allowedExtensions, $maxSize)) {
                return null;
            }

            // Generate unique filename
            $filename = $this->generateUniqueFilename($file);

            // Store file
            $path = $file->storeAs($directory, $filename, $disk);

            Log::info("File uploaded successfully", [
                'original_name' => $file->getClientOriginalName(),
                'stored_path' => $path,
                'disk' => $disk,
                'size' => $file->getSize()
            ]);

            return $path;

        } catch (Exception $e) {
            Log::error("File upload failed", [
                'error' => $e->getMessage(),
                'file' => $file->getClientOriginalName()
            ]);
            return null;
        }
    }

    /**
     * Validate file before upload.
     *
     * @param UploadedFile $file
     * @param array $allowedExtensions
     * @param int|null $maxSize
     * @return bool
     */
    protected function validateFile(UploadedFile $file, array $allowedExtensions = [], ?int $maxSize = null): bool
    {
        // Check if file is valid
        if (!$file->isValid()) {
            Log::warning("Invalid file uploaded", [
                'file' => $file->getClientOriginalName(),
                'error' => $file->getError()
            ]);
            return false;
        }

        // Check file size
        if ($maxSize && $file->getSize() > $maxSize) {
            Log::warning("File too large", [
                'file' => $file->getClientOriginalName(),
                'size' => $file->getSize(),
                'max_size' => $maxSize
            ]);
            return false;
        }

        // Check file extension
        if (!empty($allowedExtensions)) {
            $extension = strtolower($file->getClientOriginalExtension());
            if (!in_array($extension, $allowedExtensions)) {
                Log::warning("File extension not allowed", [
                    'file' => $file->getClientOriginalName(),
                    'extension' => $extension,
                    'allowed' => $allowedExtensions
                ]);
                return false;
            }
        }

        return true;
    }

    /**
     * Generate unique filename.
     *
     * @param UploadedFile $file
     * @return string
     */
    protected function generateUniqueFilename(UploadedFile $file): string
    {
        $extension = $file->getClientOriginalExtension();
        $filename = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);

        // Clean filename
        $cleanFilename = Str::slug($filename);

        // Generate unique filename
        return $cleanFilename . '_' . time() . '_' . Str::random(8) . '.' . $extension;
    }

    /**
     * Update an existing image with resizing.
     *
     * @param UploadedFile $file
     * @param string $directory
     * @param string $disk
     * @param int $width
     * @param int $height
     * @param bool $maintainAspectRatio
     * @param string $fit
     * @param mixed $model
     * @param string $field
     * @return string|null
     */
    public function updateImage(
        UploadedFile $file,
        string       $directory = 'uploads/images',
        string       $disk = 'public',
        int          $width = 800,
        int          $height = 600,
        bool         $maintainAspectRatio = true,
        string       $fit = 'contain',
                     $model = null,
        string       $field = null
    ): ?string
    {
        try {
            // Get old file path from model if provided
            $oldFilePath = null;
            if ($model && $field && isset($model->$field)) {
                $oldFilePath = $model->$field;
            }

            // Delete old image if exists
            if ($oldFilePath && Storage::disk($disk)->exists($oldFilePath)) {
                Storage::disk($disk)->delete($oldFilePath);
            }

            // Upload new image
            return $this->uploadImage($file, $directory, $disk, $width, $height, $maintainAspectRatio, $fit);

        } catch (Exception $e) {
            Log::error("Image update failed", [
                'error' => $e->getMessage(),
                'file' => $file->getClientOriginalName(),
                'old_path' => $oldFilePath
            ]);
            return null;
        }
    }

    /**
     * Upload and resize an image file.
     *
     * @param UploadedFile $file
     * @param string $directory
     * @param string $disk
     * @param int $width
     * @param int $height
     * @param bool $maintainAspectRatio
     * @param string $fit
     * @return string|null
     */
    public function uploadImage(
        UploadedFile $file,
        string       $directory = 'uploads/images',
        string       $disk = 'public',
        int          $width = 800,
        int          $height = 600,
        bool         $maintainAspectRatio = true,
        string       $fit = 'contain'
    ): ?string
    {
        try {
            // Validate image file
            if (!$this->validateImageFile($file)) {
                return null;
            }

            // Generate unique filename
            $filename = $this->generateUniqueFilename($file);
            $tempPath = $file->getRealPath();

            // Process image with Intervention Image
            $image = Image::read($tempPath);

            // Apply resize based on fit type
            switch ($fit) {
                case 'cover':
                    $image->cover($width, $height);
                    break;
                case 'contain':
                    if ($maintainAspectRatio) {
                        $image->scaleDown($width, $height);
                    } else {
                        $image->resize($width, $height);
                    }
                    break;
                case 'fill':
                    $image->resize($width, $height)->crop($width, $height);
                    break;
                default:
                    $image->scaleDown($width, $height);
            }

            // Save processed image
            $fullPath = $directory . '/' . $filename;
            Storage::disk($disk)->put($fullPath, $image->toJpeg());

            Log::info("Image uploaded and processed", [
                'original_name' => $file->getClientOriginalName(),
                'stored_path' => $fullPath,
                'disk' => $disk,
                'dimensions' => "{$width}x{$height}",
                'fit' => $fit
            ]);

            return $fullPath;

        } catch (Exception $e) {
            Log::error("Image upload failed", [
                'error' => $e->getMessage(),
                'file' => $file->getClientOriginalName()
            ]);
            return null;
        }
    }

    /**
     * Validate image file.
     *
     * @param UploadedFile $file
     * @return bool
     */
    protected function validateImageFile(UploadedFile $file): bool
    {
        return $this->validateFile($file, $this->fileExtensions['image']);
    }

    /**
     * Upload multiple files.
     *
     * @param array $files
     * @param string $directory
     * @param string $disk
     * @param array $allowedExtensions
     * @param int|null $maxSize
     * @return array
     */
    public function uploadMultipleFiles(
        array  $files,
        string $directory = 'uploads',
        string $disk = 'public',
        array  $allowedExtensions = [],
        ?int   $maxSize = null
    ): array
    {
        $uploadedFiles = [];

        foreach ($files as $file) {
            if ($file instanceof UploadedFile) {
                $path = $this->uploadFile($file, $directory, $disk, $allowedExtensions, $maxSize);
                if ($path) {
                    $uploadedFiles[] = [
                        'original_name' => $file->getClientOriginalName(),
                        'stored_path' => $path,
                        'size' => $file->getSize(),
                        'mime_type' => $file->getMimeType()
                    ];
                }
            }
        }

        return $uploadedFiles;
    }

    /**
     * Delete a file from storage.
     *
     * @param string $filePath
     * @param string $disk
     * @return bool
     */
    public function deleteFile(string $filePath, string $disk = 'public'): bool
    {
        try {
            if (Storage::disk($disk)->exists($filePath)) {
                Storage::disk($disk)->delete($filePath);

                Log::info("File deleted successfully", [
                    'file_path' => $filePath,
                    'disk' => $disk
                ]);

                return true;
            }

            return false;

        } catch (Exception $e) {
            Log::error("File deletion failed", [
                'error' => $e->getMessage(),
                'file_path' => $filePath,
                'disk' => $disk
            ]);
            return false;
        }
    }

    /**
     * Get file URL for public access.
     *
     * @param string $filePath
     * @param string $disk
     * @return string|null
     */
    public function getFileUrl(string $filePath, string $disk = 'public'): ?string
    {
        try {
            if (Storage::disk($disk)->exists($filePath)) {
                return Storage::disk($disk)->url($filePath);
            }
            return null;

        } catch (Exception $e) {
            Log::error("Failed to get file URL", [
                'error' => $e->getMessage(),
                'file_path' => $filePath,
                'disk' => $disk
            ]);
            return null;
        }
    }

    /**
     * Get file information.
     *
     * @param string $filePath
     * @param string $disk
     * @return array|null
     */
    public function getFileInfo(string $filePath, string $disk = 'public'): ?array
    {
        try {
            if (!Storage::disk($disk)->exists($filePath)) {
                return null;
            }

            return [
                'path' => $filePath,
                'url' => Storage::disk($disk)->url($filePath),
                'size' => Storage::disk($disk)->size($filePath),
                'last_modified' => Storage::disk($disk)->lastModified($filePath),
                'mime_type' => Storage::disk($disk)->mimeType($filePath),
                'exists' => true
            ];

        } catch (Exception $e) {
            Log::error("Failed to get file info", [
                'error' => $e->getMessage(),
                'file_path' => $filePath,
                'disk' => $disk
            ]);
            return null;
        }
    }

    /**
     * Get allowed extensions for file type.
     *
     * @param string $type
     * @return array
     */
    public function getAllowedExtensions(string $type): array
    {
        return $this->fileExtensions[$type] ?? [];
    }

    /**
     * Get all supported file types.
     *
     * @return array
     */
    public function getSupportedFileTypes(): array
    {
        return array_keys($this->fileExtensions);
    }

    /**
     * Check if file type is supported.
     *
     * @param string $type
     * @return bool
     */
    public function isFileTypeSupported(string $type): bool
    {
        return array_key_exists($type, $this->fileExtensions);
    }

    /**
     * Get file size in human readable format.
     *
     * @param int $bytes
     * @return string
     */
    public function formatFileSize(int $bytes): string
    {
        $units = ['B', 'KB', 'MB', 'GB', 'TB'];

        for ($i = 0; $bytes > 1024 && $i < count($units) - 1; $i++) {
            $bytes /= 1024;
        }

        return round($bytes, 2) . ' ' . $units[$i];
    }

    /**
     * Upload media file to the specified directory.
     *
     * @param UploadedFile $file
     * @param string $directory
     * @param string $disk
     * @param array $allowedExtensions
     * @param int|null $maxSize
     * @return string|null
     */
    public function uploadMedia(
        UploadedFile $file,
        string $directory = 'uploads',
        string $disk = 'public',
        array $allowedExtensions = [],
        ?int $maxSize = null
    ): ?string
    {
        try {
            // Use default allowed extensions if none provided
            if (empty($allowedExtensions)) {
                $allowedExtensions = array_merge(
                    $this->fileExtensions['image'],
                    $this->fileExtensions['document'],
                    $this->fileExtensions['spreadsheet'],
                    $this->fileExtensions['presentation'],
                    $this->fileExtensions['archive'],
                    $this->fileExtensions['video'],
                    $this->fileExtensions['audio']
                );
            }

            // Validate file
            if (!$this->validateFile($file, $allowedExtensions, $maxSize)) {
                return null;
            }

            // Generate unique filename
            $filename = $this->generateUniqueFilename($file);

            // Store file
            $path = $file->storeAs($directory, $filename, $disk);

            Log::info("Media file uploaded successfully", [
                'original_name' => $file->getClientOriginalName(),
                'stored_path' => $path,
                'disk' => $disk,
                'size' => $file->getSize()
            ]);

            return $path;

        } catch (Exception $e) {
            Log::error("Media upload failed", [
                'error' => $e->getMessage(),
                'file' => $file->getClientOriginalName()
            ]);
            return null;
        }
    }

    /**
     * Update media file in the specified directory.
     *
     * @param UploadedFile $file
     * @param string $directory
     * @param string $disk
     * @param string|null $oldFilePath
     * @param array $allowedExtensions
     * @param int|null $maxSize
     * @return string|null
     */
    public function updateMedia(
        UploadedFile $file,
        string $directory = 'uploads',
        string $disk = 'public',
        ?string $oldFilePath = null,
        array $allowedExtensions = [],
        ?int $maxSize = null
    ): ?string
    {
        try {
            // Delete old file if exists
            if ($oldFilePath && Storage::disk($disk)->exists($oldFilePath)) {
                Storage::disk($disk)->delete($oldFilePath);
            }

            // Upload new file
            return $this->uploadMedia($file, $directory, $disk, $allowedExtensions, $maxSize);

        } catch (Exception $e) {
            Log::error("Media update failed", [
                'error' => $e->getMessage(),
                'file' => $file->getClientOriginalName(),
                'old_path' => $oldFilePath
            ]);
            return null;
        }
    }

    /**
     * Delete media file from the specified directory.
     *
     * @param string $filePath
     * @param string $disk
     * @return bool
     */
    public function deleteMedia(string $filePath, string $disk = 'public'): bool
    {
        try {
            if (Storage::disk($disk)->exists($filePath)) {
                Storage::disk($disk)->delete($filePath);

                Log::info("Media file deleted successfully", [
                    'file_path' => $filePath,
                    'disk' => $disk
                ]);

                return true;
            }

            return false;

        } catch (Exception $e) {
            Log::error("Media deletion failed", [
                'error' => $e->getMessage(),
                'file_path' => $filePath,
                'disk' => $disk
            ]);
            return false;
        }
    }

    /**
     * Upload multiple media files to the specified directory.
     *
     * @param array $files
     * @param string $directory
     * @param string $disk
     * @param array $allowedExtensions
     * @param int|null $maxSize
     * @return array
     */
    public function uploadMultiMedia(
        array $files,
        string $directory = 'uploads',
        string $disk = 'public',
        array $allowedExtensions = [],
        ?int $maxSize = null
    ): array
    {
        $uploadedFiles = [];

        try {
            foreach ($files as $file) {
                if ($file instanceof UploadedFile) {
                    $path = $this->uploadMedia($file, $directory, $disk, $allowedExtensions, $maxSize);
                    if ($path) {
                        $uploadedFiles[] = [
                            'original_name' => $file->getClientOriginalName(),
                            'stored_path' => $path,
                            'size' => $file->getSize(),
                            'mime_type' => $file->getMimeType()
                        ];
                    }
                }
            }

            Log::info("Multiple media files uploaded successfully", [
                'uploaded_count' => count($uploadedFiles),
                'total_files' => count($files),
                'directory' => $directory,
                'disk' => $disk
            ]);

            return $uploadedFiles;

        } catch (Exception $e) {
            Log::error("Multiple media upload failed", [
                'error' => $e->getMessage(),
                'directory' => $directory,
                'disk' => $disk
            ]);
            return [];
        }
    }

    /**
     * Delete multiple media files from the specified directory.
     *
     * @param array $filePaths
     * @param string $disk
     * @return array
     */
    public function deleteMultiMedia(array $filePaths, string $disk = 'public'): array
    {
        $deletedFiles = [];
        $failedFiles = [];

        try {
            foreach ($filePaths as $filePath) {
                if ($this->deleteMedia($filePath, $disk)) {
                    $deletedFiles[] = $filePath;
                } else {
                    $failedFiles[] = $filePath;
                }
            }

            Log::info("Multiple media files deletion completed", [
                'deleted_count' => count($deletedFiles),
                'failed_count' => count($failedFiles),
                'total_files' => count($filePaths),
                'disk' => $disk
            ]);

            return [
                'deleted' => $deletedFiles,
                'failed' => $failedFiles,
                'success_count' => count($deletedFiles),
                'failed_count' => count($failedFiles)
            ];

        } catch (Exception $e) {
            Log::error("Multiple media deletion failed", [
                'error' => $e->getMessage(),
                'file_paths' => $filePaths,
                'disk' => $disk
            ]);
            return [
                'deleted' => [],
                'failed' => $filePaths,
                'success_count' => 0,
                'failed_count' => count($filePaths)
            ];
        }
    }
}
