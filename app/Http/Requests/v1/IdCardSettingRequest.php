<?php

namespace App\Http\Requests\v1;

use App\Http\Requests\BaseRequest;
use App\Enums\v1\Status;
use Illuminate\Validation\Rule;

/**
 * IdCardSettingRequest - Version 1
 *
 * Form request for validating ID card setting data.
 * This request handles validation for ID card setting creation and updates.
 *
 * @package App\Http\Requests\v1
 * @version 1.0.0
 * @author Softmax Technologies
 */
class IdCardSettingRequest extends BaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        $idCardSettingId = $this->route('id');
        $isUpdate = $this->isMethod('PUT') || $this->isMethod('PATCH');

        return [
            /**
             * The title of the ID card setting.
             * @var string $title
             * @example "Student ID Card Template"
             */
            'title' => [
                $isUpdate ? 'sometimes' : 'required',
                'string',
                'max:255'
            ],

            /**
             * The subtitle of the ID card.
             * @var string|null $subtitle
             * @example "College Management System"
             */
            'subtitle' => [
                'nullable',
                'string',
                'max:255'
            ],

            /**
             * The website URL for the ID card.
             * @var string|null $website_url
             * @example "https://college.edu"
             */
            'website_url' => [
                'nullable',
                'url',
                'max:255'
            ],

            /**
             * The validity period of the ID card.
             * @var string|null $validity
             * @example "2024-2025"
             */
            'validity' => [
                'nullable',
                'string',
                'max:255'
            ],

            /**
             * The address for the ID card.
             * @var string|null $address
             * @example "123 College Street, City, State 12345"
             */
            'address' => [
                'nullable',
                'string',
                'max:500'
            ],

            /**
             * The prefix for ID card numbers.
             * @var string|null $prefix
             * @example "STU"
             */
            'prefix' => [
                'nullable',
                'string',
                'max:10'
            ],

            /**
             * Whether to include student photo on the ID card.
             * @var bool|null $student_photo
             * @example true
             */
            'student_photo' => [
                'nullable',
                'boolean'
            ],

            /**
             * Whether to include signature on the ID card.
             * @var bool|null $signature
             * @example true
             */
            'signature' => [
                'nullable',
                'boolean'
            ],

            /**
             * Whether to include barcode on the ID card.
             * @var bool|null $barcode
             * @example true
             */
            'barcode' => [
                'nullable',
                'boolean'
            ],

            /**
             * The status of the ID card setting.
             * @var string $status
             * @example "active"
             */
            'status' => [
                'required',
                'string',
                Rule::enum(Status::class),
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
            'title.required' => 'ID card setting title is required.',
            'title.string' => 'ID card setting title must be a string.',
            'title.max' => 'ID card setting title cannot exceed 255 characters.',
            'subtitle.string' => 'ID card subtitle must be a string.',
            'subtitle.max' => 'ID card subtitle cannot exceed 255 characters.',
            'website_url.url' => 'Website URL must be a valid URL.',
            'website_url.max' => 'Website URL cannot exceed 255 characters.',
            'validity.string' => 'Validity must be a string.',
            'validity.max' => 'Validity cannot exceed 255 characters.',
            'address.string' => 'Address must be a string.',
            'address.max' => 'Address cannot exceed 500 characters.',
            'prefix.string' => 'Prefix must be a string.',
            'prefix.max' => 'Prefix cannot exceed 10 characters.',
            'student_photo.boolean' => 'Student photo field must be true or false.',
            'signature.boolean' => 'Signature field must be true or false.',
            'barcode.boolean' => 'Barcode field must be true or false.',
            'status.required' => 'Status field is required.',
            'status.string' => 'Status field must be a string.',
            'status.enum' => 'Status field must be a valid status.',
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
            'title' => 'ID card setting title',
            'subtitle' => 'ID card subtitle',
            'website_url' => 'website URL',
            'validity' => 'validity period',
            'address' => 'address',
            'prefix' => 'prefix',
            'student_photo' => 'student photo',
            'signature' => 'signature',
            'barcode' => 'barcode',
            'status' => 'status',
        ];
    }
}
