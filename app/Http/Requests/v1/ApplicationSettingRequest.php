<?php

namespace App\Http\Requests\v1;

use App\Http\Requests\BaseRequest;
use Illuminate\Validation\Rule;

/**
 * Application Setting Request - Version 1
 *
 * This request class handles validation for application settings
 * in the College Management System.
 *
 * @package App\Http\Requests\v1
 * @version 1.0.0
 * @author Softmax Technologies
 */
class ApplicationSettingRequest extends BaseRequest
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
             * The setting slug.
             * @var string $slug
             * @example "application_form"
             */
            'slug' => [
                $isUpdate ? 'sometimes' : 'required',
                'string',
                'max:255',
                $isUpdate ? Rule::unique('application_settings', 'slug')->ignore($this->route('id')) : 'unique:application_settings,slug'
            ],

            /**
             * The setting title.
             * @var string|null $title
             * @example "Application Form Settings"
             */
            'title' => [
                'nullable',
                'string'
            ],

            /**
             * The header left content.
             * @var string|null $header_left
             * @example "College Logo"
             */
            'header_left' => [
                'nullable',
                'string'
            ],

            /**
             * The header center content.
             * @var string|null $header_center
             * @example "Application Form"
             */
            'header_center' => [
                'nullable',
                'string'
            ],

            /**
             * The header right content.
             * @var string|null $header_right
             * @example "Date: {{date}}"
             */
            'header_right' => [
                'nullable',
                'string'
            ],

            /**
             * The body content.
             * @var string|null $body
             * @example "Application form content..."
             */
            'body' => [
                'nullable',
                'string'
            ],

            /**
             * The footer left content.
             * @var string|null $footer_left
             * @example "Signature"
             */
            'footer_left' => [
                'nullable',
                'string'
            ],

            /**
             * The footer center content.
             * @var string|null $footer_center
             * @example "Page {{page}} of {{pages}}"
             */
            'footer_center' => [
                'nullable',
                'string'
            ],

            /**
             * The footer right content.
             * @var string|null $footer_right
             * @example "Generated on {{date}}"
             */
            'footer_right' => [
                'nullable',
                'string'
            ],

            /**
             * The left logo.
             * @var string|null $logo_left
             * @example "logo_left.png"
             */
            'logo_left' => [
                'nullable',
                'string',
                'max:255'
            ],

            /**
             * The right logo.
             * @var string|null $logo_right
             * @example "logo_right.png"
             */
            'logo_right' => [
                'nullable',
                'string',
                'max:255'
            ],

            /**
             * The background image.
             * @var string|null $background
             * @example "background.jpg"
             */
            'background' => [
                'nullable',
                'string',
                'max:255'
            ],

            /**
             * The fee amount.
             * @var float|null $fee_amount
             * @example 50.00
             */
            'fee_amount' => [
                'nullable',
                'numeric',
                'min:0'
            ],

            /**
             * Whether online payment is enabled.
             * @var bool|null $pay_online
             * @example true
             */
            'pay_online' => [
                'nullable',
                'boolean'
            ],

            /**
             * The setting status.
             * @var string|null $status
             * @example "active"
             */
            'status' => [
                'nullable',
                'string',
                Rule::in(['active', 'inactive'])
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
            'slug.required' => 'Setting slug is required.',
            'slug.string' => 'Setting slug must be a string.',
            'slug.max' => 'Setting slug cannot exceed 255 characters.',
            'slug.unique' => 'This setting slug is already taken.',
            'title.string' => 'Title must be a string.',
            'header_left.string' => 'Header left content must be a string.',
            'header_center.string' => 'Header center content must be a string.',
            'header_right.string' => 'Header right content must be a string.',
            'body.string' => 'Body content must be a string.',
            'footer_left.string' => 'Footer left content must be a string.',
            'footer_center.string' => 'Footer center content must be a string.',
            'footer_right.string' => 'Footer right content must be a string.',
            'logo_left.string' => 'Left logo must be a string.',
            'logo_left.max' => 'Left logo cannot exceed 255 characters.',
            'logo_right.string' => 'Right logo must be a string.',
            'logo_right.max' => 'Right logo cannot exceed 255 characters.',
            'background.string' => 'Background must be a string.',
            'background.max' => 'Background cannot exceed 255 characters.',
            'fee_amount.numeric' => 'Fee amount must be a number.',
            'fee_amount.min' => 'Fee amount must be at least 0.',
            'pay_online.boolean' => 'Pay online must be true or false.',
            'status.string' => 'Status must be a string.',
            'status.in' => 'Status must be one of: active, inactive.',
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
            'slug' => 'setting slug',
            'title' => 'setting title',
            'header_left' => 'header left content',
            'header_center' => 'header center content',
            'header_right' => 'header right content',
            'body' => 'body content',
            'footer_left' => 'footer left content',
            'footer_center' => 'footer center content',
            'footer_right' => 'footer right content',
            'logo_left' => 'left logo',
            'logo_right' => 'right logo',
            'background' => 'background image',
            'fee_amount' => 'fee amount',
            'pay_online' => 'online payment',
            'status' => 'setting status',
        ];
    }
}
