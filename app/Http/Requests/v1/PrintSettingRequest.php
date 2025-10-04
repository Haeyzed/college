<?php

namespace App\Http\Requests\v1;

use App\Http\Requests\BaseRequest;
use Illuminate\Validation\Rule;
use App\Enums\v1\Status;

/**
 * PrintSettingRequest - Version 1
 *
 * Form request for validating print setting data.
 * This request handles validation for print setting creation and updates.
 *
 * @package App\Http\Requests\v1
 * @version 1.0.0
 * @author Softmax Technologies
 */
class PrintSettingRequest extends BaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        $printSettingId = $this->route('id');
        $isUpdate = $this->isMethod('PUT') || $this->isMethod('PATCH');

        return [
            /**
             * The title of the print setting.
             * @var string $title
             * @example "Certificate Template"
             */
            'title' => [
                'nullable',
                'string',
                'max:255'
            ],
            /**
             * The left header content.
             * @var string|null $header_left
             * @example "College Name"
             */
            'header_left' => [
                'nullable',
                'string',
                'max:500'
            ],

            /**
             * The center header content.
             * @var string|null $header_center
             * @example "Certificate of Achievement"
             */
            'header_center' => [
                'nullable',
                'string',
                'max:500'
            ],

            /**
             * The right header content.
             * @var string|null $header_right
             * @example "Academic Year 2024"
             */
            'header_right' => [
                'nullable',
                'string',
                'max:500'
            ],

            /**
             * The main body content.
             * @var string|null $body
             * @example "Certificate body content"
             */
            'body' => [
                'nullable',
                'string'
            ],

            /**
             * The left footer content.
             * @var string|null $footer_left
             * @example "Page 1 of 1"
             */
            'footer_left' => [
                'nullable',
                'string',
                'max:500'
            ],

            /**
             * The center footer content.
             * @var string|null $footer_center
             * @example "Confidential"
             */
            'footer_center' => [
                'nullable',
                'string',
                'max:500'
            ],

            /**
             * The right footer content.
             * @var string|null $footer_right
             * @example "Date: 2024-01-01"
             */
            'footer_right' => [
                'nullable',
                'string',
                'max:500'
            ],

            /**
             * The left logo file upload.
             * @var \Illuminate\Http\UploadedFile|null $logo_left_file
             * @example "college_logo.png"
             */
            'logo_left_file' => [
                'nullable',
                'image',
                'mimes:jpeg,png,jpg,gif,svg,webp',
                'max:2048' // 2MB max
            ],

            /**
             * The right logo file upload.
             * @var \Illuminate\Http\UploadedFile|null $logo_right_file
             * @example "university_logo.png"
             */
            'logo_right_file' => [
                'nullable',
                'image',
                'mimes:jpeg,png,jpg,gif,svg,webp',
                'max:2048' // 2MB max
            ],

            /**
             * The background image file upload.
             * @var \Illuminate\Http\UploadedFile|null $background_file
             * @example "certificate_bg.jpg"
             */
            'background_file' => [
                'nullable',
                'image',
                'mimes:jpeg,png,jpg,gif,svg,webp',
                'max:5120' // 5MB max for background
            ],


            /**
             * The width of the print template.
             * @var int|null $width
             * @example 800
             */
            'width' => [
                'nullable',
                'integer',
                'min:100',
                'max:2000'
            ],

            /**
             * The height of the print template.
             * @var int|null $height
             * @example 600
             */
            'height' => [
                'nullable',
                'integer',
                'min:100',
                'max:2000'
            ],

            /**
             * The prefix for print document numbers.
             * @var string|null $prefix
             * @example "CERT"
             */
            'prefix' => [
                'nullable',
                'string',
                'max:10'
            ],

            /**
             * Whether to include student photo on the print template.
             * @var bool|null $student_photo
             * @example true
             */
            'student_photo' => [
                'nullable',
                'boolean'
            ],

            /**
             * Whether to include barcode on the print template.
             * @var bool|null $barcode
             * @example true
             */
            'barcode' => [
                'nullable',
                'boolean'
            ],

            /**
             * The status of the print setting.
             * @var string|null $status
             * @example "active"
             */
            'status' => [
                'nullable',
                'string',
                Rule::in(Status::values())
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
            'title.required' => 'Print setting title is required.',
            'title.string' => 'Print setting title must be a string.',
            'title.max' => 'Print setting title cannot exceed 255 characters.',
            'header_left.string' => 'Header left must be a string.',
            'header_left.max' => 'Header left cannot exceed 500 characters.',
            'header_center.string' => 'Header center must be a string.',
            'header_center.max' => 'Header center cannot exceed 500 characters.',
            'header_right.string' => 'Header right must be a string.',
            'header_right.max' => 'Header right cannot exceed 500 characters.',
            'body.string' => 'Body must be a string.',
            'footer_left.string' => 'Footer left must be a string.',
            'footer_left.max' => 'Footer left cannot exceed 500 characters.',
            'footer_center.string' => 'Footer center must be a string.',
            'footer_center.max' => 'Footer center cannot exceed 500 characters.',
            'footer_right.string' => 'Footer right must be a string.',
            'footer_right.max' => 'Footer right cannot exceed 500 characters.',
            'logo_left_file.image' => 'Logo left must be an image file.',
            'logo_left_file.mimes' => 'Logo left must be a file of type: jpeg, png, jpg, gif, svg, webp.',
            'logo_left_file.max' => 'Logo left file cannot exceed 2MB.',
            'logo_right_file.image' => 'Logo right must be an image file.',
            'logo_right_file.mimes' => 'Logo right must be a file of type: jpeg, png, jpg, gif, svg, webp.',
            'logo_right_file.max' => 'Logo right file cannot exceed 2MB.',
            'background_file.image' => 'Background must be an image file.',
            'background_file.mimes' => 'Background must be a file of type: jpeg, png, jpg, gif, svg, webp.',
            'background_file.max' => 'Background file cannot exceed 5MB.',
            'width.integer' => 'Width must be an integer.',
            'width.min' => 'Width must be at least 100 pixels.',
            'width.max' => 'Width cannot exceed 2000 pixels.',
            'height.integer' => 'Height must be an integer.',
            'height.min' => 'Height must be at least 100 pixels.',
            'height.max' => 'Height cannot exceed 2000 pixels.',
            'prefix.string' => 'Prefix must be a string.',
            'prefix.max' => 'Prefix cannot exceed 10 characters.',
            'student_photo.boolean' => 'Student photo field must be true or false.',
            'barcode.boolean' => 'Barcode field must be true or false.',
            'status.string' => 'Status must be a string.',
            'status.in' => 'Status must be one of: ' . implode(', ', Status::labels()),
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
            'title' => 'print setting title',
            'header_left' => 'header left',
            'header_center' => 'header center',
            'header_right' => 'header right',
            'body' => 'body content',
            'footer_left' => 'footer left',
            'footer_center' => 'footer center',
            'footer_right' => 'footer right',
            'logo_left_file' => 'logo left file',
            'logo_right_file' => 'logo right file',
            'background_file' => 'background file',
            'width' => 'width',
            'height' => 'height',
            'prefix' => 'prefix',
            'student_photo' => 'student photo',
            'barcode' => 'barcode',
            'status' => 'status',
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
        
        // Convert string boolean values to actual booleans
        $dataToMerge = [];
        
        if ($this->has('student_photo')) {
            $dataToMerge['student_photo'] = $this->convertToBoolean($this->student_photo);
        }
        
        if ($this->has('barcode')) {
            $dataToMerge['barcode'] = $this->convertToBoolean($this->barcode);
        }
        
        if ($isUpdate) {
            $dataToMerge['updated_by'] = auth()->id() ?? 1;
        } else {
            $dataToMerge['created_by'] = auth()->id() ?? 1;
            $dataToMerge['status'] = $this->status ?? Status::ACTIVE->value; // Default to active
        }
        
        if (!empty($dataToMerge)) {
            $this->merge($dataToMerge);
        }
    }

    /**
     * Convert string values to boolean using FILTER_VALIDATE_BOOLEAN.
     *
     * @param mixed $value
     * @return bool
     */
    private function convertToBoolean($value): bool
    {
        if (is_bool($value)) {
            return $value;
        }
        
        // Use PHP's built-in filter for boolean validation
        return filter_var($value, FILTER_VALIDATE_BOOLEAN, FILTER_NULL_ON_FAILURE) ?? false;
    }

}
