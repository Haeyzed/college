# Filesystem Configuration Guide

## Overview

The print settings image upload system now supports multiple filesystem disks for flexible storage options. This guide explains how to configure different storage backends.

## Configuration

### Environment Variables

Add these to your `.env` file to configure different storage disks:

```env
# Default filesystem disk
FILESYSTEM_DISK=public

# Print settings specific disk
PRINT_SETTINGS_DISK=public

# Other settings disks
MAIL_SETTINGS_DISK=public
APPLICATION_SETTINGS_DISK=public
ID_CARD_SETTINGS_DISK=public
MARKSHEET_SETTINGS_DISK=public
```

### Storage Options

#### 1. Local Storage (Default)
```env
PRINT_SETTINGS_DISK=public
```
- Files stored in `storage/app/public/print-settings/`
- URLs: `http://localhost/storage/print-settings/logos/image.png`
- Requires: `php artisan storage:link`

#### 2. Amazon S3
```env
PRINT_SETTINGS_DISK=s3

# S3 Configuration
AWS_ACCESS_KEY_ID=your_access_key
AWS_SECRET_ACCESS_KEY=your_secret_key
AWS_DEFAULT_REGION=us-east-1
AWS_BUCKET=your-bucket-name
AWS_URL=https://your-bucket.s3.amazonaws.com
```
- Files stored in S3 bucket
- URLs: `https://your-bucket.s3.amazonaws.com/print-settings/logos/image.png`

#### 3. FTP Storage
```env
PRINT_SETTINGS_DISK=ftp

# FTP Configuration
FTP_HOST=ftp.example.com
FTP_USERNAME=your_username
FTP_PASSWORD=your_password
FTP_PORT=21
FTP_ROOT=/public_html/uploads
```
- Files stored on FTP server
- URLs: `https://example.com/uploads/print-settings/logos/image.png`

#### 4. SFTP Storage
```env
PRINT_SETTINGS_DISK=sftp

# SFTP Configuration
SFTP_HOST=sftp.example.com
SFTP_USERNAME=your_username
SFTP_PASSWORD=your_password
SFTP_PRIVATE_KEY=/path/to/private/key
SFTP_ROOT=/uploads
```
- Files stored on SFTP server
- URLs: `https://example.com/uploads/print-settings/logos/image.png`

## Usage Examples

### Local Storage Setup
```bash
# Set environment
echo "PRINT_SETTINGS_DISK=public" >> .env

# Create storage link
php artisan storage:link

# Test upload
curl -X PUT "http://localhost/api/v1/settings/print" \
  -F "title=Certificate Template" \
  -F "logo_left_file=@logo.png"
```

### S3 Storage Setup
```bash
# Install AWS SDK
composer require league/flysystem-aws-s3-v3

# Set environment
echo "PRINT_SETTINGS_DISK=s3" >> .env
echo "AWS_ACCESS_KEY_ID=your_key" >> .env
echo "AWS_SECRET_ACCESS_KEY=your_secret" >> .env
echo "AWS_DEFAULT_REGION=us-east-1" >> .env
echo "AWS_BUCKET=your-bucket" >> .env

# Test upload
curl -X PUT "http://localhost/api/v1/settings/print" \
  -F "title=Certificate Template" \
  -F "logo_left_file=@logo.png"
```

### FTP Storage Setup
```bash
# Install FTP driver
composer require league/flysystem-ftp

# Set environment
echo "PRINT_SETTINGS_DISK=ftp" >> .env
echo "FTP_HOST=ftp.example.com" >> .env
echo "FTP_USERNAME=your_username" >> .env
echo "FTP_PASSWORD=your_password" >> .env

# Test upload
curl -X PUT "http://localhost/api/v1/settings/print" \
  -F "title=Certificate Template" \
  -F "logo_left_file=@logo.png"
```

## Response Examples

### Local Storage Response
```json
{
  "success": true,
  "data": {
    "logo_left": "print-settings/logos/college_logo_1234567890_abc123.png",
    "logo_left_url": "http://localhost/storage/print-settings/logos/college_logo_1234567890_abc123.png",
    "logo_right": "print-settings/logos/university_logo_1234567890_def456.png",
    "logo_right_url": "http://localhost/storage/print-settings/logos/university_logo_1234567890_def456.png",
    "background": "print-settings/backgrounds/certificate_bg_1234567890_ghi789.jpg",
    "background_url": "http://localhost/storage/print-settings/backgrounds/certificate_bg_1234567890_ghi789.jpg"
  }
}
```

### S3 Storage Response
```json
{
  "success": true,
  "data": {
    "logo_left": "print-settings/logos/college_logo_1234567890_abc123.png",
    "logo_left_url": "https://your-bucket.s3.amazonaws.com/print-settings/logos/college_logo_1234567890_abc123.png",
    "logo_right": "print-settings/logos/university_logo_1234567890_def456.png",
    "logo_right_url": "https://your-bucket.s3.amazonaws.com/print-settings/logos/university_logo_1234567890_def456.png",
    "background": "print-settings/backgrounds/certificate_bg_1234567890_ghi789.jpg",
    "background_url": "https://your-bucket.s3.amazonaws.com/print-settings/backgrounds/certificate_bg_1234567890_ghi789.jpg"
  }
}
```

### FTP Storage Response
```json
{
  "success": true,
  "data": {
    "logo_left": "print-settings/logos/college_logo_1234567890_abc123.png",
    "logo_left_url": "https://example.com/uploads/print-settings/logos/college_logo_1234567890_abc123.png",
    "logo_right": "print-settings/logos/university_logo_1234567890_def456.png",
    "logo_right_url": "https://example.com/uploads/print-settings/logos/university_logo_1234567890_def456.png",
    "background": "print-settings/backgrounds/certificate_bg_1234567890_ghi789.jpg",
    "background_url": "https://example.com/uploads/print-settings/backgrounds/certificate_bg_1234567890_ghi789.jpg"
  }
}
```

## Advanced Configuration

### Custom Disk Configuration

You can add custom disks in `config/filesystems.php`:

```php
'disks' => [
    // ... existing disks ...

    'custom_s3' => [
        'driver' => 's3',
        'key' => env('CUSTOM_S3_ACCESS_KEY_ID'),
        'secret' => env('CUSTOM_S3_SECRET_ACCESS_KEY'),
        'region' => env('CUSTOM_S3_DEFAULT_REGION'),
        'bucket' => env('CUSTOM_S3_BUCKET'),
        'url' => env('CUSTOM_S3_URL'),
    ],

    'custom_ftp' => [
        'driver' => 'ftp',
        'host' => env('CUSTOM_FTP_HOST'),
        'username' => env('CUSTOM_FTP_USERNAME'),
        'password' => env('CUSTOM_FTP_PASSWORD'),
        'port' => env('CUSTOM_FTP_PORT', 21),
        'root' => env('CUSTOM_FTP_ROOT', '/'),
    ],
],
```

Then use it:
```env
PRINT_SETTINGS_DISK=custom_s3
```

### Multiple Environment Setup

#### Development
```env
PRINT_SETTINGS_DISK=public
```

#### Staging
```env
PRINT_SETTINGS_DISK=s3
AWS_BUCKET=staging-bucket
```

#### Production
```env
PRINT_SETTINGS_DISK=s3
AWS_BUCKET=production-bucket
```

## Troubleshooting

### Common Issues

1. **Storage Link Not Created**
   ```bash
   php artisan storage:link
   ```

2. **S3 Permissions**
   - Ensure AWS credentials are correct
   - Check bucket permissions
   - Verify region configuration

3. **FTP Connection Issues**
   - Check FTP credentials
   - Verify server accessibility
   - Test connection manually

4. **URL Generation Issues**
   - Check disk configuration
   - Verify file existence
   - Check URL format

### Debug Commands

```bash
# Test storage configuration
php artisan tinker
>>> Storage::disk('public')->put('test.txt', 'Hello World');
>>> Storage::disk('public')->url('test.txt');

# Test S3 configuration
>>> Storage::disk('s3')->put('test.txt', 'Hello World');
>>> Storage::disk('s3')->url('test.txt');

# Test FTP configuration
>>> Storage::disk('ftp')->put('test.txt', 'Hello World');
>>> Storage::disk('ftp')->url('test.txt');
```

## Best Practices

1. **Environment Separation**: Use different disks for different environments
2. **Backup Strategy**: Implement backup for important files
3. **CDN Integration**: Use CDN for better performance
4. **Security**: Secure your storage credentials
5. **Monitoring**: Monitor storage usage and costs
6. **Testing**: Test storage configuration in all environments

## Migration

### Switching Storage Disks

1. **Backup existing files**
2. **Update environment variables**
3. **Migrate files to new storage**
4. **Update database paths if needed**
5. **Test functionality**

### File Migration Script

```php
// Example migration script
$oldDisk = Storage::disk('public');
$newDisk = Storage::disk('s3');

$files = $oldDisk->allFiles('print-settings');

foreach ($files as $file) {
    $content = $oldDisk->get($file);
    $newDisk->put($file, $content);
    
    // Update database if needed
    PrintSetting::where('logo_left', $file)
        ->update(['logo_left' => $file]);
}
```

This configuration system provides maximum flexibility for different storage requirements while maintaining a consistent API interface.
