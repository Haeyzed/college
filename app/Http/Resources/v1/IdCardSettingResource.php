<?php

namespace App\Http\Resources\v1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * IdCardSettingResource - Version 1
 *
 * Resource for transforming IdCardSetting model data into API responses.
 * This resource handles ID card setting data formatting for API endpoints.
 *
 * @package App\Http\Resources\v1
 * @version 1.0.0
 * @author Softmax Technologies
 */
class IdCardSettingResource extends JsonResource
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
             * The unique identifier of the ID card setting.
             * @var int $id
             * @example 1
             */
            'id' => $this->id,

            /**
             * The title of the ID card setting.
             * @var string $title
             * @example "Student ID Card Template"
             */
            'title' => $this->title,

            /**
             * The subtitle of the ID card.
             * @var string $subtitle
             * @example "College Management System"
             */
            'subtitle' => $this->subtitle,
            /**
             * The website URL for the ID card.
             * @var string|null $website_url
             * @example "https://college.edu"
             */
            'website_url' => $this->website_url,

            /**
             * The validity period of the ID card.
             * @var string|null $validity
             * @example "2024-2025"
             */
            'validity' => $this->validity,

            /**
             * The address for the ID card.
             * @var string|null $address
             * @example "123 College Street, City, State 12345"
             */
            'address' => $this->address,

            /**
             * The prefix for ID card numbers.
             * @var string|null $prefix
             * @example "STU"
             */
            'prefix' => $this->prefix,

            /**
             * Whether to include student photo on the ID card.
             * @var bool $student_photo
             * @example true
             */
            'student_photo' => $this->student_photo,

            /**
             * Whether to include signature on the ID card.
             * @var bool $signature
             * @example true
             */
            'signature' => $this->signature,

            /**
             * Whether to include barcode on the ID card.
             * @var bool $barcode
             * @example true
             */
            'barcode' => $this->barcode,

            /**
             * The status of the ID card setting.
             * @var string $status
             * @example "active"
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
        ];
    }
}
