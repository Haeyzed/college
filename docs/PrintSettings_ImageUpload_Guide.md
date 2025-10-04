# Print Settings Image Upload Guide

## Overview

The Print Settings now support image uploads for logos and background images. This guide explains how to use the image upload functionality for print templates.

## Features

- ✅ **Logo Uploads** - Left and right logo support
- ✅ **Background Image Upload** - Full background image support
- ✅ **Image Processing** - Automatic resizing and optimization
- ✅ **File Validation** - Secure file type and size validation
- ✅ **URL Generation** - Automatic URL generation for frontend use
- ✅ **Update Support** - Replace existing images with new ones

## API Endpoints

### Get Print Settings
```
GET /api/v1/settings/print
```

### Update Print Settings with Images
```
PUT /api/v1/settings/print
Content-Type: multipart/form-data
```

## Request Format

### Form Data Fields

#### Text Fields
- `title` - Print template title
- `slug` - Unique identifier
- `header_left` - Left header content
- `header_center` - Center header content
- `header_right` - Right header content
- `body` - Main body content
- `footer_left` - Left footer content
- `footer_center` - Center footer content
- `footer_right` - Right footer content
- `width` - Template width (100-2000)
- `height` - Template height (100-2000)
- `prefix` - Document prefix
- `student_photo` - Include student photo (boolean)
- `barcode` - Include barcode (boolean)
- `status` - Active status (boolean)

#### File Upload Fields
- `logo_left_file` - Left logo image file
- `logo_right_file` - Right logo image file
- `background_file` - Background image file

### File Upload Requirements

#### Logo Files (`logo_left_file`, `logo_right_file`)
- **File Types**: JPEG, PNG, JPG, GIF, SVG, WEBP
- **Max Size**: 2MB
- **Processing**: Resized to 200x200px with aspect ratio maintained
- **Storage**: `storage/app/public/print-settings/logos/`

#### Background File (`background_file`)
- **File Types**: JPEG, PNG, JPG, GIF, SVG, WEBP
- **Max Size**: 5MB
- **Processing**: Resized to 800x600px with aspect ratio maintained
- **Storage**: `storage/app/public/print-settings/backgrounds/`

## Usage Examples

### 1. Update Print Settings with Logo Upload

```bash
curl -X PUT "http://localhost/api/v1/settings/print" \
  -H "Content-Type: multipart/form-data" \
  -F "title=Certificate Template" \
  -F "header_center=Certificate of Achievement" \
  -F "logo_left_file=@college_logo.png" \
  -F "logo_right_file=@university_logo.png" \
  -F "width=800" \
  -F "height=600"
```

### 2. Update Print Settings with Background

```bash
curl -X PUT "http://localhost/api/v1/settings/print" \
  -H "Content-Type: multipart/form-data" \
  -F "title=Diploma Template" \
  -F "background_file=@diploma_background.jpg" \
  -F "width=1200" \
  -F "height=800"
```

### 3. Update All Images

```bash
curl -X PUT "http://localhost/api/v1/settings/print" \
  -H "Content-Type: multipart/form-data" \
  -F "title=Complete Template" \
  -F "logo_left_file=@left_logo.png" \
  -F "logo_right_file=@right_logo.png" \
  -F "background_file=@background.jpg" \
  -F "header_left=College Name" \
  -F "header_center=Certificate" \
  -F "header_right=2024" \
  -F "width=800" \
  -F "height=600"
```

## Response Format

### Success Response
```json
{
  "success": true,
  "message": "Print setting updated successfully",
  "data": {
    "id": 1,
    "title": "Certificate Template",
    "slug": "certificate_template",
    "header_left": "College Name",
    "header_center": "Certificate of Achievement",
    "header_right": "2024",
    "logo_left": "print-settings/logos/college_logo_1234567890_abc123.png",
    "logo_left_url": "http://localhost/storage/print-settings/logos/college_logo_1234567890_abc123.png",
    "logo_right": "print-settings/logos/university_logo_1234567890_def456.png",
    "logo_right_url": "http://localhost/storage/print-settings/logos/university_logo_1234567890_def456.png",
    "background": "print-settings/backgrounds/certificate_bg_1234567890_ghi789.jpg",
    "background_url": "http://localhost/storage/print-settings/backgrounds/certificate_bg_1234567890_ghi789.jpg",
    "width": 800,
    "height": 600,
    "has_logo_left": true,
    "has_logo_right": true,
    "has_background": true,
    "dimensions": {
      "width": 800,
      "height": 600
    },
    "configuration_summary": "Certificate Template (800x600) - College Name",
    "image_assets": {
      "logos_count": 2,
      "has_background": true,
      "total_images": 3
    },
    "created_at": "2023-12-01 10:30:00",
    "updated_at": "2023-12-01 15:45:00"
  }
}
```

### Error Response
```json
{
  "success": false,
  "message": "Validation failed",
  "errors": {
    "logo_left_file": [
      "Logo left must be an image file."
    ],
    "background_file": [
      "Background file cannot exceed 5MB."
    ]
  }
}
```

## Frontend Integration

### HTML Form Example
```html
<form action="/api/v1/settings/print" method="POST" enctype="multipart/form-data">
    <input type="hidden" name="_method" value="PUT">
    
    <div>
        <label for="title">Title:</label>
        <input type="text" name="title" id="title" required>
    </div>
    
    <div>
        <label for="logo_left_file">Left Logo:</label>
        <input type="file" name="logo_left_file" id="logo_left_file" accept="image/*">
    </div>
    
    <div>
        <label for="logo_right_file">Right Logo:</label>
        <input type="file" name="logo_right_file" id="logo_right_file" accept="image/*">
    </div>
    
    <div>
        <label for="background_file">Background:</label>
        <input type="file" name="background_file" id="background_file" accept="image/*">
    </div>
    
    <div>
        <label for="width">Width:</label>
        <input type="number" name="width" id="width" min="100" max="2000" value="800">
    </div>
    
    <div>
        <label for="height">Height:</label>
        <input type="number" name="height" id="height" min="100" max="2000" value="600">
    </div>
    
    <button type="submit">Update Print Settings</button>
</form>
```

### JavaScript Example
```javascript
const formData = new FormData();
formData.append('title', 'Certificate Template');
formData.append('header_center', 'Certificate of Achievement');

// Add logo files
const leftLogoFile = document.getElementById('logo_left_file').files[0];
if (leftLogoFile) {
    formData.append('logo_left_file', leftLogoFile);
}

const rightLogoFile = document.getElementById('logo_right_file').files[0];
if (rightLogoFile) {
    formData.append('logo_right_file', rightLogoFile);
}

// Add background file
const backgroundFile = document.getElementById('background_file').files[0];
if (backgroundFile) {
    formData.append('background_file', backgroundFile);
}

formData.append('width', '800');
formData.append('height', '600');

fetch('/api/v1/settings/print', {
    method: 'PUT',
    body: formData,
    headers: {
        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
    }
})
.then(response => response.json())
.then(data => {
    if (data.success) {
        console.log('Print settings updated successfully');
        console.log('Logo URLs:', {
            left: data.data.logo_left_url,
            right: data.data.logo_right_url,
            background: data.data.background_url
        });
    } else {
        console.error('Error:', data.message);
    }
});
```

## Image Processing Details

### Logo Processing
- **Input**: Any image file (JPEG, PNG, GIF, SVG, WEBP)
- **Output**: 200x200px with aspect ratio maintained
- **Fit**: Contain (image fits within dimensions)
- **Quality**: Optimized for web use

### Background Processing
- **Input**: Any image file (JPEG, PNG, GIF, SVG, WEBP)
- **Output**: 800x600px with aspect ratio maintained
- **Fit**: Contain (image fits within dimensions)
- **Quality**: Optimized for print use

### File Naming
- **Format**: `{original_name}_{timestamp}_{random_string}.{extension}`
- **Example**: `college_logo_1234567890_abc123.png`
- **Sanitization**: Special characters replaced with underscores

## Storage Structure

```
storage/app/public/
├── print-settings/
│   ├── logos/
│   │   ├── college_logo_1234567890_abc123.png
│   │   └── university_logo_1234567890_def456.png
│   └── backgrounds/
│       └── certificate_bg_1234567890_ghi789.jpg
```

## Security Features

- **File Type Validation**: Only image files allowed
- **File Size Limits**: 2MB for logos, 5MB for backgrounds
- **MIME Type Checking**: Server-side validation
- **Secure Filename Generation**: Prevents directory traversal
- **Image Processing**: Automatic resizing prevents oversized uploads

## Error Handling

### Common Errors

1. **File Too Large**
   ```json
   {
     "message": "Background file cannot exceed 5MB."
   }
   ```

2. **Invalid File Type**
   ```json
   {
     "message": "Logo left must be a file of type: jpeg, png, jpg, gif, svg, webp."
   }
   ```

3. **Upload Failed**
   ```json
   {
     "message": "Failed to update print setting: File upload failed"
   }
   ```

## Best Practices

1. **Image Optimization**: Compress images before upload
2. **File Naming**: Use descriptive filenames
3. **Size Limits**: Respect the 2MB/5MB limits
4. **Format Selection**: Use PNG for logos, JPEG for backgrounds
5. **Error Handling**: Always handle upload errors gracefully
6. **Progress Indicators**: Show upload progress for large files
7. **Preview**: Show image previews before upload

## Troubleshooting

### Common Issues

1. **File Not Uploading**
   - Check file size limits
   - Verify file type is supported
   - Ensure form has `enctype="multipart/form-data"`

2. **Images Not Displaying**
   - Check storage link is created: `php artisan storage:link`
   - Verify file permissions
   - Check URL generation

3. **Processing Errors**
   - Ensure Intervention Image is installed
   - Check server memory limits
   - Verify image file is not corrupted

### Debug Steps

1. Check Laravel logs: `storage/logs/laravel.log`
2. Verify file uploads in `storage/app/public/print-settings/`
3. Test with smaller image files
4. Check server error logs
5. Verify database updates

## Migration Notes

- Existing print settings will continue to work
- New image upload fields are optional
- Old image paths are preserved
- New URLs are generated automatically
- No data migration required
