# FileUploader Trait - Usage Examples

## Overview

The `FileUploader` trait is a modern, best-practice file uploader that supports all Laravel filesystem disks with comprehensive file handling, validation, and storage capabilities.

## Features

- ✅ Support for all Laravel filesystem disks (local, public, s3, etc.)
- ✅ Image processing with Intervention Image
- ✅ File validation and security
- ✅ Multiple file uploads
- ✅ File deletion and management
- ✅ Comprehensive logging
- ✅ Error handling
- ✅ File information retrieval
- ✅ URL generation for public access

## Basic Usage

### 1. Upload a Single File

```php
use App\Traits\v1\FileUploader;

class DocumentController extends Controller
{
    use FileUploader;

    public function uploadDocument(Request $request)
    {
        $request->validate([
            'document' => 'required|file|max:10240' // 10MB max
        ]);

        $file = $request->file('document');
        
        // Upload to public disk
        $path = $this->uploadFile(
            file: $file,
            directory: 'documents',
            disk: 'public',
            allowedExtensions: ['pdf', 'doc', 'docx'],
            maxSize: 10 * 1024 * 1024 // 10MB
        );

        if ($path) {
            return response()->success([
                'message' => 'File uploaded successfully',
                'file_path' => $path,
                'file_url' => $this->getFileUrl($path, 'public')
            ]);
        }

        return response()->error('File upload failed');
    }
}
```

### 2. Upload and Resize Image

```php
public function uploadProfileImage(Request $request)
{
    $request->validate([
        'image' => 'required|image|max:5120' // 5MB max
    ]);

    $file = $request->file('image');
    
    // Upload and resize image
    $path = $this->uploadImage(
        file: $file,
        directory: 'profiles',
        disk: 'public',
        width: 300,
        height: 300,
        maintainAspectRatio: true,
        fit: 'cover' // cover, contain, fill
    );

    if ($path) {
        return response()->success([
            'message' => 'Image uploaded and processed',
            'image_path' => $path,
            'image_url' => $this->getFileUrl($path, 'public')
        ]);
    }

    return response()->error('Image upload failed');
}
```

### 3. Update Existing File

```php
public function updateDocument(Request $request, Document $document)
{
    $request->validate([
        'document' => 'required|file|max:10240'
    ]);

    $file = $request->file('document');
    
    // Update existing file
    $newPath = $this->updateFile(
        file: $file,
        directory: 'documents',
        disk: 'public',
        oldFilePath: $document->file_path,
        allowedExtensions: ['pdf', 'doc', 'docx'],
        maxSize: 10 * 1024 * 1024
    );

    if ($newPath) {
        $document->update(['file_path' => $newPath]);
        return response()->success([
            'message' => 'Document updated successfully',
            'file_path' => $newPath
        ]);
    }

    return response()->error('Document update failed');
}
```

### 4. Upload Multiple Files

```php
public function uploadMultipleDocuments(Request $request)
{
    $request->validate([
        'documents.*' => 'required|file|max:10240'
    ]);

    $files = $request->file('documents');
    
    $uploadedFiles = $this->uploadMultipleFiles(
        files: $files,
        directory: 'documents',
        disk: 'public',
        allowedExtensions: ['pdf', 'doc', 'docx', 'txt'],
        maxSize: 10 * 1024 * 1024
    );

    return response()->success([
        'message' => 'Files uploaded successfully',
        'uploaded_files' => $uploadedFiles,
        'count' => count($uploadedFiles)
    ]);
}
```

### 5. Delete File

```php
public function deleteDocument(Document $document)
{
    $deleted = $this->deleteFile(
        filePath: $document->file_path,
        disk: 'public'
    );

    if ($deleted) {
        $document->delete();
        return response()->success(['message' => 'Document deleted successfully']);
    }

    return response()->error('Document deletion failed');
}
```

## Advanced Usage

### 1. Using Different Disks

```php
// Upload to S3
$path = $this->uploadFile(
    file: $file,
    directory: 'documents',
    disk: 's3',
    allowedExtensions: ['pdf', 'doc', 'docx']
);

// Upload to local storage
$path = $this->uploadFile(
    file: $file,
    directory: 'uploads',
    disk: 'local',
    allowedExtensions: ['pdf', 'doc', 'docx']
);
```

### 2. Image Processing with Different Fits

```php
// Cover fit (crop to exact dimensions)
$path = $this->uploadImage(
    file: $file,
    directory: 'thumbnails',
    disk: 'public',
    width: 200,
    height: 200,
    maintainAspectRatio: false,
    fit: 'cover'
);

// Contain fit (maintain aspect ratio)
$path = $this->uploadImage(
    file: $file,
    directory: 'gallery',
    disk: 'public',
    width: 800,
    height: 600,
    maintainAspectRatio: true,
    fit: 'contain'
);

// Fill fit (resize and crop)
$path = $this->uploadImage(
    file: $file,
    directory: 'banners',
    disk: 'public',
    width: 1200,
    height: 400,
    maintainAspectRatio: false,
    fit: 'fill'
);
```

### 3. File Information and URLs

```php
public function getFileInfo(string $filePath)
{
    $info = $this->getFileInfo($filePath, 'public');
    
    if ($info) {
        return response()->success([
            'file_info' => $info,
            'formatted_size' => $this->formatFileSize($info['size'])
        ]);
    }

    return response()->error('File not found');
}

public function getFileUrl(string $filePath)
{
    $url = $this->getFileUrl($filePath, 'public');
    
    if ($url) {
        return response()->success(['file_url' => $url]);
    }

    return response()->error('File URL not found');
}
```

### 4. File Type Validation

```php
public function uploadByType(Request $request)
{
    $fileType = $request->input('file_type'); // image, document, etc.
    
    if (!$this->isFileTypeSupported($fileType)) {
        return response()->error('Unsupported file type');
    }

    $allowedExtensions = $this->getAllowedExtensions($fileType);
    
    $path = $this->uploadFile(
        file: $request->file('file'),
        directory: $fileType . 's',
        disk: 'public',
        allowedExtensions: $allowedExtensions
    );

    return response()->success(['file_path' => $path]);
}
```

## Configuration

### 1. File Extensions

The trait supports these file types by default:

```php
$fileExtensions = [
    'image' => ['jpg', 'jpeg', 'png', 'gif', 'ico', 'svg', 'webp', 'bmp', 'tiff'],
    'document' => ['pdf', 'doc', 'docx', 'txt', 'rtf', 'odt'],
    'spreadsheet' => ['xls', 'xlsx', 'csv', 'ods'],
    'presentation' => ['ppt', 'pptx', 'odp'],
    'archive' => ['zip', 'rar', '7z', 'tar', 'gz'],
    'video' => ['mp4', 'avi', 'mpeg', '3gp', 'mov', 'ogg', 'mkv', 'webm'],
    'audio' => ['mp3', 'wav', 'ogg', 'aac', 'flac'],
    'code' => ['php', 'js', 'css', 'html', 'json', 'xml', 'sql'],
];
```

### 2. Laravel Filesystem Configuration

Make sure your `config/filesystems.php` is properly configured:

```php
'disks' => [
    'local' => [
        'driver' => 'local',
        'root' => storage_path('app'),
    ],
    'public' => [
        'driver' => 'local',
        'root' => storage_path('app/public'),
        'url' => env('APP_URL').'/storage',
        'visibility' => 'public',
    ],
    's3' => [
        'driver' => 's3',
        'key' => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION'),
        'bucket' => env('AWS_BUCKET'),
        'url' => env('AWS_URL'),
    ],
],
```

## Error Handling

The trait includes comprehensive error handling and logging:

```php
// Check logs for detailed error information
Log::channel('daily')->info('File upload successful', [
    'file' => 'document.pdf',
    'path' => 'documents/document_1234567890_abc123.pdf',
    'disk' => 'public'
]);

Log::channel('daily')->error('File upload failed', [
    'error' => 'File too large',
    'file' => 'large_document.pdf',
    'size' => 15728640,
    'max_size' => 10485760
]);
```

## Best Practices

1. **Always validate files** before uploading
2. **Use appropriate file extensions** for security
3. **Set reasonable file size limits**
4. **Use different disks** for different file types
5. **Clean up old files** when updating
6. **Monitor disk usage** and implement cleanup strategies
7. **Use CDN** for public files when possible
8. **Implement file compression** for large files
9. **Use proper error handling** and user feedback
10. **Log all file operations** for debugging

## Security Considerations

- File extension validation
- File size limits
- MIME type checking
- Secure filename generation
- Proper file permissions
- Access control for sensitive files
- Regular cleanup of orphaned files
