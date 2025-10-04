<?php

namespace App\Http\Resources\v1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * MarksheetSettingResource - Version 1
 *
 * Resource for transforming MarksheetSetting model data into API responses.
 * This resource handles marksheet setting data formatting for API endpoints.
 *
 * @package App\Http\Resources\v1
 * @version 1.0.0
 * @author Softmax Technologies
 */
class MarksheetSettingResource extends JsonResource
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
             * The unique identifier of the marksheet setting.
             * @var int $id
             * @example 1
             */
            'id' => $this->id,

            /**
             * The title of the marksheet setting.
             * @var string $title
             * @example "Academic Marksheet Template"
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
             * @example "Academic Marksheet"
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
             * @example "Marksheet body content"
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
             * The right logo path.
             * @var string|null $logo_right
             * @example "logos/university_logo.png"
             */
            'logo_right' => $this->logo_right,

            /**
             * The background image path.
             * @var string|null $background
             * @example "backgrounds/marksheet_bg.jpg"
             */
            'background' => $this->background,

            /**
             * The width of the marksheet.
             * @var int $width
             * @example 800
             */
            'width' => $this->width,

            /**
             * The height of the marksheet.
             * @var int $height
             * @example 600
             */
            'height' => $this->height,

            /**
             * Whether to include student photo on the marksheet.
             * @var bool $student_photo
             * @example true
             */
            'student_photo' => $this->student_photo,

            /**
             * Whether to include barcode on the marksheet.
             * @var bool $barcode
             * @example true
             */
            'barcode' => $this->barcode,

            /**
             * The status of the marksheet setting.
             * @var bool $status
             * @example true
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
             * Whether the marksheet setting is active.
             * @var bool $is_active
             * @example true
             */
            'is_active' => $this->status,

            /**
             * The aspect ratio of the marksheet.
             * @var float $aspect_ratio
             * @example 1.33
             */
            'aspect_ratio' => $this->width > 0 ? round($this->width / $this->height, 2) : 0,

            /**
             * The dimensions in a readable format.
             * @var string $dimensions
             * @example "800x600"
             */
            'dimensions' => $this->width . 'x' . $this->height,

            /**
             * Whether the marksheet has a background.
             * @var bool $has_background
             * @example true
             */
            'has_background' => !empty($this->background),

            /**
             * Whether the marksheet has logos.
             * @var bool $has_logos
             * @example true
             */
            'has_logos' => !empty($this->logo_left) || !empty($this->logo_right),

            /**
             * The number of features enabled on the marksheet.
             * @var int $features_count
             * @example 2
             */
            'features_count' => collect([
                $this->student_photo,
                $this->barcode
            ])->filter()->count(),

            /**
             * List of enabled features.
             * @var array $enabled_features
             * @example ["student_photo", "barcode"]
             */
            'enabled_features' => collect([
                'student_photo' => $this->student_photo,
                'barcode' => $this->barcode
            ])->filter()->keys()->toArray(),
        ];
    }
}
