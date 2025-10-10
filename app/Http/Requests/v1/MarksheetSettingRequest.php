<?php

namespace App\Http\Requests\v1;

use App\Http\Requests\BaseRequest;

/**
 * MarksheetSettingRequest - Version 1
 *
 * Form request for validating marksheet setting data.
 * This request handles validation for marksheet setting creation and updates.
 *
 * @package App\Http\Requests\v1
 * @version 1.0.0
 * @author Softmax Technologies
 */
class MarksheetSettingRequest extends BaseRequest
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
             * The title of the marksheet setting.
             * @var string $title
             * @example "Academic Marksheet Template"
             */
            'title' => [
                $isUpdate ? 'sometimes' : 'required',
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
             * @example "Academic Marksheet"
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
             * @example "Marksheet body content"
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
             * The left logo path.
             * @var string|null $logo_left
             * @example "logos/college_logo.png"
             */
            'logo_left' => [
                'nullable',
                'string',
                'max:255'
            ],

            /**
             * The right logo path.
             * @var string|null $logo_right
             * @example "logos/university_logo.png"
             */
            'logo_right' => [
                'nullable',
                'string',
                'max:255'
            ],

            /**
             * The background image path.
             * @var string|null $background
             * @example "backgrounds/marksheet_bg.jpg"
             */
            'background' => [
                'nullable',
                'string',
                'max:255'
            ],

            /**
             * The width of the marksheet.
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
             * The height of the marksheet.
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
             * Whether to include student photo on the marksheet.
             * @var bool|null $student_photo
             * @example true
             */
            'student_photo' => [
                'nullable',
                'boolean'
            ],

            /**
             * Whether to include barcode on the marksheet.
             * @var bool|null $barcode
             * @example true
             */
            'barcode' => [
                'nullable',
                'boolean'
            ],

            /**
             * The status of the marksheet setting.
             * @var bool|null $status
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
            'title.required' => 'Marksheet setting title is required.',
            'title.string' => 'Marksheet setting title must be a string.',
            'title.max' => 'Marksheet setting title cannot exceed 255 characters.',
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
            'logo_left.string' => 'Logo left path must be a string.',
            'logo_left.max' => 'Logo left path cannot exceed 255 characters.',
            'logo_right.string' => 'Logo right path must be a string.',
            'logo_right.max' => 'Logo right path cannot exceed 255 characters.',
            'background.string' => 'Background path must be a string.',
            'background.max' => 'Background path cannot exceed 255 characters.',
            'width.integer' => 'Width must be an integer.',
            'width.min' => 'Width must be at least 100 pixels.',
            'width.max' => 'Width cannot exceed 2000 pixels.',
            'height.integer' => 'Height must be an integer.',
            'height.min' => 'Height must be at least 100 pixels.',
            'height.max' => 'Height cannot exceed 2000 pixels.',
            'student_photo.boolean' => 'Student photo field must be true or false.',
            'barcode.boolean' => 'Barcode field must be true or false.',
            'status.boolean' => 'Status field must be true or false.',
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
            'title' => 'marksheet setting title',
            'header_left' => 'header left',
            'header_center' => 'header center',
            'header_right' => 'header right',
            'body' => 'body content',
            'footer_left' => 'footer left',
            'footer_center' => 'footer center',
            'footer_right' => 'footer right',
            'logo_left' => 'logo left',
            'logo_right' => 'logo right',
            'background' => 'background image',
            'width' => 'width',
            'height' => 'height',
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

        if ($isUpdate) {
            $this->merge([
                'updated_by' => auth()->id() ?? 1,
            ]);
        } else {
            $this->merge([
                'created_by' => auth()->id() ?? 1,
                'status' => $this->status ?? true, // Default to active
            ]);
        }
    }
}
