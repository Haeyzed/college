<?php

namespace App\Services\v1;

use App\Traits\v1\FileUploader;
use Exception;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Log;

/**
 * FileUploadService - Version 1
 *
 * Service class for handling file uploads using the FileUploader trait.
 * This service provides high-level methods for common file upload scenarios.
 *
 * @package App\Services\v1
 * @version 1.0.0
 * @author Softmax Technologies
 */
class FileUploadService
{
    use FileUploader;

    /**
     * Upload a document file.
     *
     * @param UploadedFile $file
     * @param string $disk
     * @return array
     */
    public function uploadDocument(UploadedFile $file, string $disk = 'public'): array
    {
        try {
            $path = $this->uploadFile(
                file: $file,
                directory: 'documents',
                disk: $disk,
                allowedExtensions: $this->getAllowedExtensions('document'),
                maxSize: 10 * 1024 * 1024 // 10MB
            );

            if (!$path) {
                return [
                    'success' => false,
                    'message' => 'Document upload failed',
                    'data' => null
                ];
            }

            return [
                'success' => true,
                'message' => 'Document uploaded successfully',
                'data' => [
                    'file_path' => $path,
                    'file_url' => $this->getFileUrl($path, $disk),
                    'file_info' => $this->getFileInfo($path, $disk),
                    'original_name' => $file->getClientOriginalName(),
                    'size' => $file->getSize(),
                    'formatted_size' => $this->formatFileSize($file->getSize())
                ]
            ];

        } catch (Exception $e) {
            Log::error('Document upload failed', [
                'error' => $e->getMessage(),
                'file' => $file->getClientOriginalName()
            ]);

            return [
                'success' => false,
                'message' => 'Document upload failed: ' . $e->getMessage(),
                'data' => null
            ];
        }
    }

    /**
     * Get file information.
     *
     * @param string $filePath
     * @param string $disk
     * @return array
     */
    public function getFileInfo(string $filePath, string $disk = 'public'): array
    {
        try {
            $info = $this->getFileInfo($filePath, $disk);

            if (!$info) {
                return [
                    'success' => false,
                    'message' => 'File not found',
                    'data' => null
                ];
            }

            return [
                'success' => true,
                'message' => 'File information retrieved successfully',
                'data' => [
                    'file_info' => $info,
                    'formatted_size' => $this->formatFileSize($info['size']),
                    'file_url' => $info['url']
                ]
            ];

        } catch (Exception $e) {
            Log::error('Failed to get file info', [
                'error' => $e->getMessage(),
                'file_path' => $filePath
            ]);

            return [
                'success' => false,
                'message' => 'Failed to get file info: ' . $e->getMessage(),
                'data' => null
            ];
        }
    }

    /**
     * Upload an image file with processing.
     *
     * @param UploadedFile $file
     * @param string $disk
     * @param int $width
     * @param int $height
     * @param string $fit
     * @return array
     */
    public function uploadImage(
        UploadedFile $file,
        string       $disk = 'public',
        int          $width = 800,
        int          $height = 600,
        string       $fit = 'contain'
    ): array
    {
        try {
            $path = $this->uploadImage(
                file: $file,
                directory: 'images',
                disk: $disk,
                width: $width,
                height: $height,
                maintainAspectRatio: true,
                fit: $fit
            );

            if (!$path) {
                return [
                    'success' => false,
                    'message' => 'Image upload failed',
                    'data' => null
                ];
            }

            return [
                'success' => true,
                'message' => 'Image uploaded and processed successfully',
                'data' => [
                    'file_path' => $path,
                    'file_url' => $this->getFileUrl($path, $disk),
                    'file_info' => $this->getFileInfo($path, $disk),
                    'original_name' => $file->getClientOriginalName(),
                    'size' => $file->getSize(),
                    'formatted_size' => $this->formatFileSize($file->getSize()),
                    'dimensions' => "{$width}x{$height}",
                    'fit' => $fit
                ]
            ];

        } catch (Exception $e) {
            Log::error('Image upload failed', [
                'error' => $e->getMessage(),
                'file' => $file->getClientOriginalName()
            ]);

            return [
                'success' => false,
                'message' => 'Image upload failed: ' . $e->getMessage(),
                'data' => null
            ];
        }
    }

    /**
     * Upload multiple files.
     *
     * @param array $files
     * @param string $type
     * @param string $disk
     * @return array
     */
    public function uploadMultipleFiles(array $files, string $type = 'document', string $disk = 'public'): array
    {
        try {
            $allowedExtensions = $this->getAllowedExtensions($type);
            $maxSize = $this->getMaxSizeForType($type);

            $uploadedFiles = $this->uploadMultipleFiles(
                files: $files,
                directory: $type . 's',
                disk: $disk,
                allowedExtensions: $allowedExtensions,
                maxSize: $maxSize
            );

            return [
                'success' => true,
                'message' => 'Files uploaded successfully',
                'data' => [
                    'uploaded_files' => $uploadedFiles,
                    'count' => count($uploadedFiles),
                    'total_size' => array_sum(array_column($uploadedFiles, 'size')),
                    'formatted_total_size' => $this->formatFileSize(
                        array_sum(array_column($uploadedFiles, 'size'))
                    )
                ]
            ];

        } catch (Exception $e) {
            Log::error('Multiple files upload failed', [
                'error' => $e->getMessage(),
                'file_count' => count($files)
            ]);

            return [
                'success' => false,
                'message' => 'Multiple files upload failed: ' . $e->getMessage(),
                'data' => null
            ];
        }
    }

    /**
     * Get maximum file size for file type.
     *
     * @param string $type
     * @return int
     */
    protected function getMaxSizeForType(string $type): int
    {
        return match ($type) {
            'image' => 5 * 1024 * 1024, // 5MB
            'document' => 10 * 1024 * 1024, // 10MB
            'video' => 100 * 1024 * 1024, // 100MB
            'audio' => 20 * 1024 * 1024, // 20MB
            'archive' => 50 * 1024 * 1024, // 50MB
            default => 10 * 1024 * 1024, // 10MB default
        };
    }

    /**
     * Update an existing file.
     *
     * @param UploadedFile $file
     * @param string $oldFilePath
     * @param string $type
     * @param string $disk
     * @return array
     */
    public function updateFile(
        UploadedFile $file,
        string       $oldFilePath,
        string       $type = 'document',
        string       $disk = 'public'
    ): array
    {
        try {
            $allowedExtensions = $this->getAllowedExtensions($type);
            $maxSize = $this->getMaxSizeForType($type);

            $newPath = $this->updateFile(
                file: $file,
                directory: $type . 's',
                disk: $disk,
                oldFilePath: $oldFilePath,
                allowedExtensions: $allowedExtensions,
                maxSize: $maxSize
            );

            if (!$newPath) {
                return [
                    'success' => false,
                    'message' => 'File update failed',
                    'data' => null
                ];
            }

            return [
                'success' => true,
                'message' => 'File updated successfully',
                'data' => [
                    'old_file_path' => $oldFilePath,
                    'new_file_path' => $newPath,
                    'file_url' => $this->getFileUrl($newPath, $disk),
                    'file_info' => $this->getFileInfo($newPath, $disk),
                    'original_name' => $file->getClientOriginalName(),
                    'size' => $file->getSize(),
                    'formatted_size' => $this->formatFileSize($file->getSize())
                ]
            ];

        } catch (Exception $e) {
            Log::error('File update failed', [
                'error' => $e->getMessage(),
                'file' => $file->getClientOriginalName(),
                'old_path' => $oldFilePath
            ]);

            return [
                'success' => false,
                'message' => 'File update failed: ' . $e->getMessage(),
                'data' => null
            ];
        }
    }

    /**
     * Delete a file.
     *
     * @param string $filePath
     * @param string $disk
     * @return array
     */
    public function deleteFile(string $filePath, string $disk = 'public'): array
    {
        try {
            $deleted = $this->deleteFile($filePath, $disk);

            if ($deleted) {
                return [
                    'success' => true,
                    'message' => 'File deleted successfully',
                    'data' => ['file_path' => $filePath]
                ];
            }

            return [
                'success' => false,
                'message' => 'File deletion failed or file not found',
                'data' => null
            ];

        } catch (Exception $e) {
            Log::error('File deletion failed', [
                'error' => $e->getMessage(),
                'file_path' => $filePath
            ]);

            return [
                'success' => false,
                'message' => 'File deletion failed: ' . $e->getMessage(),
                'data' => null
            ];
        }
    }

    /**
     * Get supported file types.
     *
     * @return array
     */
    public function getSupportedFileTypes(): array
    {
        return $this->getSupportedFileTypes();
    }

    /**
     * Get allowed extensions for file type.
     *
     * @param string $type
     * @return array
     */
    public function getAllowedExtensionsForType(string $type): array
    {
        return $this->getAllowedExtensions($type);
    }

    /**
     * Check if file type is supported.
     *
     * @param string $type
     * @return bool
     */
    public function isFileTypeSupported(string $type): bool
    {
        return $this->isFileTypeSupported($type);
    }
}
