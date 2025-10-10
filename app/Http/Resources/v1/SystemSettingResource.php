<?php

namespace App\Http\Resources\v1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * SystemSettingResource - Version 1
 *
 * Resource for transforming Setting model data into API responses.
 * This resource handles system setting data formatting for API endpoints.
 *
 * @package App\Http\Resources\v1
 * @version 1.0.0
 * @author Softmax Technologies
 */
class SystemSettingResource extends JsonResource
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
             * The unique identifier of the system setting.
             * @var int $id
             * @example 1
             */
            'id' => $this->id,

            /**
             * The system title.
             * @var string|null $title
             * @example "College Management System"
             */
            'title' => $this->title,

            /**
             * The academy code.
             * @var string|null $academy_code
             * @example "CMS2024"
             */
            'academy_code' => $this->academy_code,

            /**
             * The meta title for SEO.
             * @var string|null $meta_title
             * @example "College Management System - CMS"
             */
            'meta_title' => $this->meta_title,

            /**
             * The meta description for SEO.
             * @var string|null $meta_description
             * @example "Comprehensive college management system"
             */
            'meta_description' => $this->meta_description,

            /**
             * The meta keywords for SEO.
             * @var string|null $meta_keywords
             * @example "college, management, system, education"
             */
            'meta_keywords' => $this->meta_keywords,

            /**
             * The logo path.
             * @var string|null $logo_path
             * @example "logos/college_logo.png"
             */
            'logo_path' => $this->logo_path,

            /**
             * The favicon path.
             * @var string|null $favicon_path
             * @example "favicons/favicon.ico"
             */
            'favicon_path' => $this->favicon_path,

            /**
             * The contact phone number.
             * @var string|null $phone
             * @example "+1234567890"
             */
            'phone' => $this->phone,

            /**
             * The contact email address.
             * @var string|null $email
             * @example "info@college.edu"
             */
            'email' => $this->email,

            /**
             * The fax number.
             * @var string|null $fax
             * @example "+1234567891"
             */
            'fax' => $this->fax,

            /**
             * The address.
             * @var string|null $address
             * @example "123 College Street, City, State"
             */
            'address' => $this->address,

            /**
             * The system language.
             * @var string|null $language
             * @example "en"
             */
            'language' => $this->language,

            /**
             * The date format.
             * @var string|null $date_format
             * @example "Y-m-d"
             */
            'date_format' => $this->date_format,

            /**
             * The time format.
             * @var string|null $time_format
             * @example "H:i:s"
             */
            'time_format' => $this->time_format,

            /**
             * The week start day.
             * @var string|null $week_start
             * @example "monday"
             */
            'week_start' => $this->week_start,

            /**
             * The time zone.
             * @var string|null $time_zone
             * @example "UTC"
             */
            'time_zone' => $this->time_zone,

            /**
             * The currency code.
             * @var string|null $currency
             * @example "USD"
             */
            'currency' => $this->currency,

            /**
             * The currency symbol.
             * @var string|null $currency_symbol
             * @example "$"
             */
            'currency_symbol' => $this->currency_symbol,

            /**
             * The decimal places for currency.
             * @var int|null $decimal_place
             * @example 2
             */
            'decimal_place' => $this->decimal_place,

            /**
             * The copyright text.
             * @var string|null $copyright_text
             * @example "© 2024 College Management System"
             */
            'copyright_text' => $this->copyright_text,

            /**
             * The status of the system setting.
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
             * Whether the system setting is active.
             * @var bool $is_active
             * @example true
             */
            'is_active' => $this->status,

            /**
             * The complete system configuration summary.
             * @var string $configuration_summary
             * @example "College Management System (CMS2024) - info@college.edu"
             */
            'configuration_summary' => ($this->title ?: 'System') .
                ($this->academy_code ? ' (' . $this->academy_code . ')' : '') .
                ($this->email ? ' - ' . $this->email : ''),

            /**
             * Whether the system has a logo.
             * @var bool $has_logo
             * @example true
             */
            'has_logo' => !empty($this->logo_path),

            /**
             * Whether the system has a favicon.
             * @var bool $has_favicon
             * @example true
             */
            'has_favicon' => !empty($this->favicon_path),

            /**
             * Whether the system has contact information.
             * @var bool $has_contact_info
             * @example true
             */
            'has_contact_info' => !empty($this->phone) || !empty($this->email) || !empty($this->address),

            /**
             * The currency formatting information.
             * @var array $currency_info
             * @example {"code": "USD", "symbol": "$", "decimal_places": 2}
             */
            'currency_info' => [
                'code' => $this->currency,
                'symbol' => $this->currency_symbol,
                'decimal_places' => $this->decimal_place,
            ],

            /**
             * The date and time formatting information.
             * @var array $datetime_info
             * @example {"date_format": "Y-m-d", "time_format": "H:i:s", "timezone": "UTC"}
             */
            'datetime_info' => [
                'date_format' => $this->date_format,
                'time_format' => $this->time_format,
                'timezone' => $this->time_zone,
                'week_start' => $this->week_start,
            ],
        ];
    }
}
