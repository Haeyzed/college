<?php

namespace App\Http\Requests\v1;

use App\Http\Requests\BaseRequest;

/**
 * System Setting Request - Version 1
 *
 * This request class handles validation for system settings
 * in the College Management System.
 *
 * @package App\Http\Requests\v1
 * @version 1.0.0
 * @author Softmax Technologies
 */
class SystemSettingRequest extends BaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        $isUpdate = $this->isMethod('PUT') || $this->isMethod('PATCH');

        return [
            /**
             * The system title.
             * @var string|null $title
             * @example "College Management System"
             */
            'title' => [
                'nullable',
                'string',
                'max:255'
            ],

            /**
             * The academy code.
             * @var string|null $academy_code
             * @example "CMS2024"
             */
            'academy_code' => [
                'nullable',
                'string',
                'max:50'
            ],

            /**
             * The meta title for SEO.
             * @var string|null $meta_title
             * @example "College Management System - CMS"
             */
            'meta_title' => [
                'nullable',
                'string',
                'max:255'
            ],

            /**
             * The meta description for SEO.
             * @var string|null $meta_description
             * @example "Comprehensive college management system"
             */
            'meta_description' => [
                'nullable',
                'string',
                'max:500'
            ],

            /**
             * The meta keywords for SEO.
             * @var string|null $meta_keywords
             * @example "college, management, system, education"
             */
            'meta_keywords' => [
                'nullable',
                'string',
                'max:500'
            ],

            /**
             * The logo path.
             * @var string|null $logo_path
             * @example "logos/college_logo.png"
             */
            'logo_path' => [
                'nullable',
                'string',
                'max:255'
            ],

            /**
             * The favicon path.
             * @var string|null $favicon_path
             * @example "favicons/favicon.ico"
             */
            'favicon_path' => [
                'nullable',
                'string',
                'max:255'
            ],

            /**
             * The contact phone number.
             * @var string|null $phone
             * @example "+1234567890"
             */
            'phone' => [
                'nullable',
                'string',
                'max:20'
            ],

            /**
             * The contact email address.
             * @var string|null $email
             * @example "info@college.edu"
             */
            'email' => [
                'nullable',
                'email',
                'max:255'
            ],

            /**
             * The fax number.
             * @var string|null $fax
             * @example "+1234567891"
             */
            'fax' => [
                'nullable',
                'string',
                'max:20'
            ],

            /**
             * The address.
             * @var string|null $address
             * @example "123 College Street, City, State"
             */
            'address' => [
                'nullable',
                'string',
                'max:500'
            ],

            /**
             * The system language.
             * @var string|null $language
             * @example "en"
             */
            'language' => [
                'nullable',
                'string',
                'max:10'
            ],

            /**
             * The date format.
             * @var string|null $date_format
             * @example "Y-m-d"
             */
            'date_format' => [
                'nullable',
                'string',
                'max:20'
            ],

            /**
             * The time format.
             * @var string|null $time_format
             * @example "H:i:s"
             */
            'time_format' => [
                'nullable',
                'string',
                'max:20'
            ],

            /**
             * The week start day.
             * @var string|null $week_start
             * @example "monday"
             */
            'week_start' => [
                'nullable',
                'string',
                'max:20'
            ],

            /**
             * The time zone.
             * @var string|null $time_zone
             * @example "UTC"
             */
            'time_zone' => [
                'nullable',
                'string',
                'max:50'
            ],

            /**
             * The currency code.
             * @var string|null $currency
             * @example "USD"
             */
            'currency' => [
                'nullable',
                'string',
                'max:10'
            ],

            /**
             * The currency symbol.
             * @var string|null $currency_symbol
             * @example "$"
             */
            'currency_symbol' => [
                'nullable',
                'string',
                'max:10'
            ],

            /**
             * The decimal places for currency.
             * @var int|null $decimal_place
             * @example 2
             */
            'decimal_place' => [
                'nullable',
                'integer',
                'min:0',
                'max:4'
            ],

            /**
             * The copyright text.
             * @var string|null $copyright_text
             * @example "© 2024 College Management System"
             */
            'copyright_text' => [
                'nullable',
                'string',
                'max:500'
            ],

            /**
             * The status of the system setting.
             * @var bool $status
             * @example true
             */
            'status' => [
                'nullable',
                'boolean'
            ],
        ];
    }

    /**
     * Get custom messages for validator errors.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'email.email' => 'The email must be a valid email address.',
            'decimal_place.integer' => 'The decimal place must be an integer.',
            'decimal_place.min' => 'The decimal place must be at least 0.',
            'decimal_place.max' => 'The decimal place must not exceed 4.',
        ];
    }

    /**
     * Get custom attributes for validator errors.
     *
     * @return array<string, string>
     */
    public function attributes(): array
    {
        return [
            'title' => 'Title',
            'academy_code' => 'Academy Code',
            'meta_title' => 'Meta Title',
            'meta_description' => 'Meta Description',
            'meta_keywords' => 'Meta Keywords',
            'logo_path' => 'Logo Path',
            'favicon_path' => 'Favicon Path',
            'phone' => 'Phone',
            'email' => 'Email',
            'fax' => 'Fax',
            'address' => 'Address',
            'language' => 'Language',
            'date_format' => 'Date Format',
            'time_format' => 'Time Format',
            'week_start' => 'Week Start',
            'time_zone' => 'Time Zone',
            'currency' => 'Currency',
            'currency_symbol' => 'Currency Symbol',
            'decimal_place' => 'Decimal Place',
            'copyright_text' => 'Copyright Text',
        ];
    }

    /**
     * Prepare the data for validation.
     *
     * @return void
     */
    protected function prepareForValidation(): void
    {
        $isUpdate = $this->isMethod('PUT') || $this->isMethod('PATCH');
        
        if ($isUpdate) {
            $this->merge(['updated_by' => auth()->id() ?? 1]);
        } else {
            $this->merge(['created_by' => auth()->id() ?? 1, 'status' => $this->status ?? true]);
        }
    }
}