<?php

namespace App\Http\Resources\v1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Helpers\StorageHelper;

/**
 * PrintSettingResource - Version 1
 *
 * Resource for transforming PrintSetting model data into API responses.
 * This resource handles print setting data formatting for API endpoints.
 *
 * @package App\Http\Resources\v1
 * @version 1.0.0
 * @author Softmax Technologies
 */
class PrintSettingResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param Request $request
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            /**
             * The unique identifier of the print setting.
             * @var int $id
             * @example 1
             */
            'id' => $this->id,

            /**
             * The title of the print setting.
             * @var string $title
             * @example "Certificate Template"
             */
            'title' => $this->title,

            /**
             * The left header content.
             * @var string|null $header_left
             * @example "College Name"
             */
            'header_left' => $this->header_left,

            /**
             * The center header content.
             * @var string|null $header_center
             * @example "Certificate of Achievement"
             */
            'header_center' => $this->header_center,

            /**
             * The right header content.
             * @var string|null $header_right
             * @example "Academic Year 2024"
             */
            'header_right' => $this->header_right,

            /**
             * The main body content.
             * @var string|null $body
             * @example "Certificate body content"
             */
            'body' => $this->body,

            /**
             * The left footer content.
             * @var string|null $footer_left
             * @example "Page 1 of 1"
             */
            'footer_left' => $this->footer_left,

            /**
             * The center footer content.
             * @var string|null $footer_center
             * @example "Confidential"
             */
            'footer_center' => $this->footer_center,

            /**
             * The right footer content.
             * @var string|null $footer_right
             * @example "Date: 2024-01-01"
             */
            'footer_right' => $this->footer_right,

            /**
             * The left logo path.
             * @var string|null $logo_left
             * @example "logos/college_logo.png"
             */
            'logo_left' => $this->logo_left,

            /**
             * The left logo URL.
             * @var string|null $logo_left_url
             * @example "http://localhost/storage/print-settings/logos/college_logo.png"
             */
            'logo_left_url' => StorageHelper::getConfigurableStorageUrl($this->logo_left, 'filesystems.print_settings_disk'),

            /**
             * The right logo path.
             * @var string|null $logo_right
             * @example "logos/university_logo.png"
             */
            'logo_right' => $this->logo_right,

            /**
             * The right logo URL.
             * @var string|null $logo_right_url
             * @example "http://localhost/storage/print-settings/logos/university_logo.png"
             */
            'logo_right_url' => StorageHelper::getConfigurableStorageUrl($this->logo_right, 'filesystems.print_settings_disk'),

            /**
             * The background image path.
             * @var string|null $background
             * @example "backgrounds/certificate_bg.jpg"
             */
            'background' => $this->background,

            /**
             * The background image URL.
             * @var string|null $background_url
             * @example "http://localhost/storage/print-settings/backgrounds/certificate_bg.jpg"
             */
            'background_url' => StorageHelper::getConfigurableStorageUrl($this->background, 'filesystems.print_settings_disk'),

            /**
             * The width of the print template.
             * @var int $width
             * @example 800
             */
            'width' => $this->width,

            /**
             * The height of the print template.
             * @var int $height
             * @example 600
             */
            'height' => $this->height,

            /**
             * The prefix for print document numbers.
             * @var string|null $prefix
             * @example "CERT"
             */
            'prefix' => $this->prefix,

            /**
             * Whether to include student photo on the print template.
             * @var bool $student_photo
             * @example true
             */
            'student_photo' => $this->student_photo,

            /**
             * Whether to include barcode on the print template.
             * @var bool $barcode
             * @example true
             */
            'barcode' => $this->barcode,

            /**
             * The status of the print setting.
             * @var string $status
             * @example active
             */
            'status' => $this->status,

            /**
             * The creation timestamp.
             * @var string|null $created_at
             * @example "2023-12-01 10:30:00"
             */
            'created_at' => $this->created_at?->format('Y-m-d H:i:s'),

            /**
             * The last update timestamp.
             * @var string|null $updated_at
             * @example "2023-12-01 15:45:00"
             */
            'updated_at' => $this->updated_at?->format('Y-m-d H:i:s'),

            // Computed fields
            /**
             * Whether the print setting has a left logo.
             * @var bool $has_logo_left
             * @example true
             */
            'has_logo_left' => !empty($this->logo_left),

            /**
             * Whether the print setting has a right logo.
             * @var bool $has_logo_right
             * @example true
             */
            'has_logo_right' => !empty($this->logo_right),

            /**
             * Whether the print setting has a background image.
             * @var bool $has_background
             * @example true
             */
            'has_background' => !empty($this->background),

            /**
             * The print template dimensions.
             * @var array $dimensions
             * @example {"width": 800, "height": 600}
             */
            'dimensions' => [
                'width' => $this->width,
                'height' => $this->height,
            ],

            /**
             * The print template configuration summary.
             * @var string $configuration_summary
             * @example "Certificate Template (800x600) - College Name"
             */
            'configuration_summary' => $this->title . 
                ($this->width && $this->height ? ' (' . $this->width . 'x' . $this->height . ')' : '') . 
                ($this->header_left ? ' - ' . $this->header_left : ''),

            /**
             * The image assets information.
             * @var array $image_assets
             * @example {"logos": 2, "background": true}
             */
            'image_assets' => [
                'logos_count' => (int)!empty($this->logo_left) + (int)!empty($this->logo_right),
                'has_background' => !empty($this->background),
                'total_images' => (int)!empty($this->logo_left) + (int)!empty($this->logo_right) + (int)!empty($this->background),
            ],
        ];
    }

}
