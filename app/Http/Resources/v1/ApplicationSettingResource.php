<?php

namespace App\Http\Resources\v1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * ApplicationSettingResource - Version 1
 *
 * Resource for transforming ApplicationSetting model data into API responses.
 * This resource handles application setting data formatting for API endpoints.
 *
 * @package App\Http\Resources\v1
 * @version 1.0.0
 * @author Softmax Technologies
 */
class ApplicationSettingResource extends JsonResource
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
             * The unique identifier of the application setting.
             * @var int $id
             * @example 1
             */
            'id' => $this->id,

            /**
             * The unique slug identifier for the application setting.
             * @var string $slug
             * @example "application_form"
             */
            'slug' => $this->slug,

            /**
             * The title of the application setting.
             * @var string $title
             * @example "Application Form Settings"
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
             * @example "Application Form"
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
             * @example "Application form body content"
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
             * @example "backgrounds/form_bg.jpg"
             */
            'background' => $this->background,

            /**
             * The application fee amount.
             * @var float|null $fee_amount
             * @example 500.00
             */
            'fee_amount' => $this->fee_amount,

            /**
             * Whether online payment is enabled.
             * @var bool $pay_online
             * @example true
             */
            'pay_online' => $this->pay_online,

            /**
             * The status of the application setting.
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
             * Whether the application setting is active.
             * @var bool $is_active
             * @example true
             */
            'is_active' => $this->status,

            /**
             * Whether online payment is available.
             * @var bool $has_online_payment
             * @example true
             */
            'has_online_payment' => $this->pay_online,

            /**
             * The formatted fee amount with currency.
             * @var string|null $formatted_fee
             * @example "$500.00"
             */
            'formatted_fee' => $this->fee_amount ? '$' . number_format($this->fee_amount, 2) : null,
        ];
    }
}
