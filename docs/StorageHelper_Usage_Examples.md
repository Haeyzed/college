# StorageHelper Usage Examples

The `StorageHelper` class provides reusable methods for handling file storage URLs across different filesystem disks and configurations.

## Basic Usage

### 1. Simple File URL Generation

```php
use App\Helpers\StorageHelper;

// Get URL for a file using default disk
$url = StorageHelper::getStorageUrl('uploads/image.jpg');

// Get URL for a file using specific disk
$url = StorageHelper::getStorageUrl('uploads/image.jpg', 's3');
```

### 2. Configurable Storage URLs

```php
// For settings that have their own disk configuration
$url = StorageHelper::getConfigurableStorageUrl(
    $this->logo_path, 
    'filesystems.print_settings_disk'
);
```

### 3. Image URLs with Cache Busting

```php
// Get image URL with timestamp for cache busting
$url = StorageHelper::getImageUrl('uploads/logo.png', 'public', true);
```

### 4. Document URLs

```php
// Get document URL
$url = StorageHelper::getDocumentUrl('documents/contract.pdf', 's3');
```

## Usage in Resources

### PrintSettingResource Example

```php
use App\Helpers\StorageHelper;

class PrintSettingResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'logo_left_url' => StorageHelper::getConfigurableStorageUrl(
                $this->logo_left, 
                'filesystems.print_settings_disk'
            ),
            'logo_right_url' => StorageHelper::getConfigurableStorageUrl(
                $this->logo_right, 
                'filesystems.print_settings_disk'
            ),
            'background_url' => StorageHelper::getConfigurableStorageUrl(
                $this->background, 
                'filesystems.print_settings_disk'
            ),
        ];
    }
}
```

### UserResource Example

```php
use App\Helpers\StorageHelper;

class UserResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'avatar_url' => StorageHelper::getImageUrl($this->avatar, 'public'),
            'document_url' => StorageHelper::getDocumentUrl($this->resume, 's3'),
        ];
    }
}
```

## Advanced Usage

### File Information

```php
// Get detailed file information
$fileInfo = StorageHelper::getFileInfo('uploads/document.pdf', 's3');

// Returns:
// [
//     'path' => 'uploads/document.pdf',
//     'disk' => 's3',
//     'size' => 1024000,
//     'mime_type' => 'application/pdf',
//     'last_modified' => 1640995200,
//     'url' => 'https://bucket.s3.amazonaws.com/uploads/document.pdf'
// ]
```

### Check File Existence

```php
// Check if file exists on any configured disk
$exists = StorageHelper::fileExistsOnAnyDisk('uploads/image.jpg', ['public', 's3']);
```

## Configuration

### Environment Variables

```env
# Default disk
FILESYSTEM_DISK=public

# Print settings disk
PRINT_SETTINGS_DISK=s3

# S3 configuration
AWS_ACCESS_KEY_ID=your_key
AWS_SECRET_ACCESS_KEY=your_secret
AWS_DEFAULT_REGION=us-east-1
AWS_BUCKET=your_bucket
```

### Config Files

```php
// config/filesystems.php
return [
    'default' => env('FILESYSTEM_DISK', 'public'),
    
    'print_settings_disk' => env('PRINT_SETTINGS_DISK', 'public'),
    
    'disks' => [
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
        ],
    ],
];
```

## Benefits

1. **Reusable**: Can be used in any resource, controller, or service
2. **Flexible**: Supports multiple filesystem disks
3. **Robust**: Handles fallbacks and error cases
4. **Configurable**: Easy to customize for different use cases
5. **Type-safe**: Proper return types and null handling
6. **Cache-friendly**: Supports cache busting for images

## Best Practices

1. Use `getConfigurableStorageUrl()` for settings with specific disk configurations
2. Use `getImageUrl()` for images with cache busting
3. Use `getDocumentUrl()` for documents and files
4. Always handle null returns in your code
5. Use appropriate disk configurations for different file types
