<?php

namespace App\Http\Controllers\v1;

use App\Http\Controllers\Controller;
use App\Services\v1\FileUploadService;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

/**
 * FileUploadController - Version 1
 *
 * Controller for handling file upload operations using the FileUploadService.
 * This controller demonstrates best practices for file upload handling.
 *
 * @package App\Http\Controllers\v1
 * @version 1.0.0
 * @author Softmax Technologies
 */
class FileUploadController extends Controller
{
    /**
     * File upload service instance.
     *
     * @var FileUploadService
     */
    protected FileUploadService $fileUploadService;

    /**
     * Create a new controller instance.
     *
     * @param FileUploadService $fileUploadService
     */
    public function __construct(FileUploadService $fileUploadService)
    {
        $this->fileUploadService = $fileUploadService;
    }

    /**
     * Upload a single document.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function uploadDocument(Request $request): JsonResponse
    {
        try {
            $request->validate([
                'file' => 'required|file|max:10240', // 10MB max
                'disk' => 'sometimes|string|in:local,public,s3'
            ]);

            $disk = $request->input('disk', 'public');
            $result = $this->fileUploadService->uploadDocument($request->file('file'), $disk);

            if ($result['success']) {
                return response()->success($result['message'], $result['data']);
            }

            return response()->error($result['message'], 400);

        } catch (Exception $e) {
            return response()->error('Document upload failed: ' . $e->getMessage(), 500);
        }
    }

    /**
     * Upload an image with processing.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function uploadImage(Request $request): JsonResponse
    {
        try {
            $request->validate([
                'file' => 'required|image|max:5120', // 5MB max
                'width' => 'sometimes|integer|min:100|max:2000',
                'height' => 'sometimes|integer|min:100|max:2000',
                'fit' => 'sometimes|string|in:cover,contain,fill',
                'disk' => 'sometimes|string|in:local,public,s3'
            ]);

            $width = $request->input('width', 800);
            $height = $request->input('height', 600);
            $fit = $request->input('fit', 'contain');
            $disk = $request->input('disk', 'public');

            $result = $this->fileUploadService->uploadImage(
                $request->file('file'),
                $disk,
                $width,
                $height,
                $fit
            );

            if ($result['success']) {
                return response()->success($result['message'], $result['data']);
            }

            return response()->badRequest($result['message']);

        } catch (Exception $e) {
            return response()->error('Image upload failed: ' . $e->getMessage(), 500);
        }
    }

    /**
     * Upload multiple files.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function uploadMultipleFiles(Request $request): JsonResponse
    {
        try {
            $request->validate([
                'files.*' => 'required|file',
                'type' => 'required|string|in:image,document,spreadsheet,presentation,archive,video,audio,code',
                'disk' => 'sometimes|string|in:local,public,s3'
            ]);

            $type = $request->input('type');
            $disk = $request->input('disk', 'public');
            $files = $request->file('files');

            $result = $this->fileUploadService->uploadMultipleFiles($files, $type, $disk);

            if ($result['success']) {
                return response()->success($result['message'], $result['data']);
            }

            return response()->badRequest($result['message']);

        } catch (Exception $e) {
            return response()->error('Multiple files upload failed: ' . $e->getMessage(), 500);
        }
    }

    /**
     * Update an existing file.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function updateFile(Request $request): JsonResponse
    {
        try {
            $request->validate([
                'file' => 'required|file',
                'old_file_path' => 'required|string',
                'type' => 'required|string|in:image,document,spreadsheet,presentation,archive,video,audio,code',
                'disk' => 'sometimes|string|in:local,public,s3'
            ]);

            $type = $request->input('type');
            $disk = $request->input('disk', 'public');
            $oldFilePath = $request->input('old_file_path');

            $result = $this->fileUploadService->updateFile(
                $request->file('file'),
                $oldFilePath,
                $type,
                $disk
            );

            if ($result['success']) {
                return response()->success($result['message'], $result['data']);
            }

            return response()->badRequest($result['message']);

        } catch (Exception $e) {
            return response()->error('File update failed: ' . $e->getMessage(), 500);
        }
    }

    /**
     * Delete a file.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function deleteFile(Request $request): JsonResponse
    {
        try {
            $request->validate([
                'file_path' => 'required|string',
                'disk' => 'sometimes|string|in:local,public,s3'
            ]);

            $filePath = $request->input('file_path');
            $disk = $request->input('disk', 'public');

            $result = $this->fileUploadService->deleteFile($filePath, $disk);

            if ($result['success']) {
                return response()->success($result['message'], $result['data']);
            }

            return response()->badRequest($result['message']);

        } catch (Exception $e) {
            return response()->error('File deletion failed: ' . $e->getMessage(), 500);
        }
    }

    /**
     * Get file information.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function getFileInfo(Request $request): JsonResponse
    {
        try {
            $request->validate([
                'file_path' => 'required|string',
                'disk' => 'sometimes|string|in:local,public,s3'
            ]);

            $filePath = $request->input('file_path');
            $disk = $request->input('disk', 'public');

            $result = $this->fileUploadService->getFileInfo($filePath, $disk);

            if ($result['success']) {
                return response()->success($result['message'], $result['data']);
            }

            return response()->notFound($result['message']);

        } catch (Exception $e) {
            return response()->error('Failed to get file info: ' . $e->getMessage(), 500);
        }
    }

    /**
     * Get supported file types.
     *
     * @return JsonResponse
     */
    public function getSupportedFileTypes(): JsonResponse
    {
        try {
            $fileTypes = $this->fileUploadService->getSupportedFileTypes();

            return response()->success('Supported file types retrieved successfully', [
                'file_types' => $fileTypes,
                'count' => count($fileTypes)
            ]);

        } catch (Exception $e) {
            return response()->error('Failed to get supported file types: ' . $e->getMessage(), 500);
        }
    }

    /**
     * Get allowed extensions for a file type.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function getAllowedExtensions(Request $request): JsonResponse
    {
        try {
            $request->validate([
                'type' => 'required|string|in:image,document,spreadsheet,presentation,archive,video,audio,code'
            ]);

            $type = $request->input('type');
            $extensions = $this->fileUploadService->getAllowedExtensionsForType($type);

            return response()->success('Allowed extensions retrieved successfully', [
                'type' => $type,
                'extensions' => $extensions,
                'count' => count($extensions)
            ]);

        } catch (Exception $e) {
            return response()->error('Failed to get allowed extensions: ' . $e->getMessage(), 500);
        }
    }

    /**
     * Check if file type is supported.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function isFileTypeSupported(Request $request): JsonResponse
    {
        try {
            $request->validate([
                'type' => 'required|string'
            ]);

            $type = $request->input('type');
            $isSupported = $this->fileUploadService->isFileTypeSupported($type);

            return response()->success('File type support check completed', [
                'type' => $type,
                'is_supported' => $isSupported
            ]);

        } catch (Exception $e) {
            return response()->error('Failed to check file type support: ' . $e->getMessage(), 500);
        }
    }
}
