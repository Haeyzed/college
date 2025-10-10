<?php

namespace App\Http\Requests\v1;

use App\Http\Requests\BaseRequest;
use Illuminate\Http\UploadedFile;
use Illuminate\Validation\Rule;

/**
 * Library Setting Request - Version 1
 *
 * This request class handles validation for library settings
 * in the College Management System.
 *
 * @package App\Http\Requests\v1
 * @version 1.0.0
 * @author Softmax Technologies
 */
class LibrarySettingRequest extends BaseRequest
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
             * @example "library_main"
             */
            'slug' => [
                $isUpdate ? 'sometimes' : 'required',
                'string',
                'max:255',
                $isUpdate ? Rule::unique('library_settings', 'slug')->ignore($this->route('id')) : 'unique:library_settings,slug'
            ],

            /**
             * The setting title.
             * @var string|null $title
             * @example "Main Library Settings"
             */
            'title' => [
                'nullable',
                'string',
                'max:255'
            ],

            /**
             * The library name.
             * @var string|null $library_name
             * @example "Central Library"
             */
            'library_name' => [
                'nullable',
                'string',
                'max:255'
            ],

            /**
             * The library code.
             * @var string|null $library_code
             * @example "LIB001"
             */
            'library_code' => [
                'nullable',
                'string',
                'max:50'
            ],

            /**
             * The library address.
             * @var string|null $address
             * @example "123 College Street, City, State"
             */
            'address' => [
                'nullable',
                'string',
                'max:500'
            ],

            /**
             * The library phone number.
             * @var string|null $phone
             * @example "+1-234-567-8900"
             */
            'phone' => [
                'nullable',
                'string',
                'max:20'
            ],

            /**
             * The library email.
             * @var string|null $email
             * @example "library@college.edu"
             */
            'email' => [
                'nullable',
                'email',
                'max:255'
            ],

            /**
             * The library website.
             * @var string|null $website
             * @example "https://library.college.edu"
             */
            'website' => [
                'nullable',
                'url',
                'max:255'
            ],

            /**
             * The library logo file.
             * @var UploadedFile|null $logo_file
             */
            'logo_file' => [
                'nullable',
                'image',
                'mimes:jpeg,png,jpg,gif,svg',
                'max:2048'
            ],

            /**
             * The background image file.
             * @var UploadedFile|null $background_file
             */
            'background_file' => [
                'nullable',
                'image',
                'mimes:jpeg,png,jpg,gif,svg',
                'max:5120'
            ],

            /**
             * The fine amount per day for overdue books.
             * @var float|null $fine_per_day
             * @example 1.50
             */
            'fine_per_day' => [
                'nullable',
                'numeric',
                'min:0',
                'max:999.99'
            ],

            /**
             * The maximum number of books a student can borrow.
             * @var int|null $max_books_per_student
             * @example 5
             */
            'max_books_per_student' => [
                'nullable',
                'integer',
                'min:1',
                'max:50'
            ],

            /**
             * The maximum number of days a book can be borrowed.
             * @var int|null $max_borrow_days
             * @example 14
             */
            'max_borrow_days' => [
                'nullable',
                'integer',
                'min:1',
                'max:365'
            ],

            /**
             * Whether to automatically approve book requests.
             * @var bool|null $auto_approve_requests
             * @example false
             */
            'auto_approve_requests' => [
                'nullable',
                'boolean'
            ],

            /**
             * Whether book requests require approval.
             * @var bool|null $require_approval
             * @example true
             */
            'require_approval' => [
                'nullable',
                'boolean'
            ],

            /**
             * Whether to send notifications for library activities.
             * @var bool|null $send_notifications
             * @example true
             */
            'send_notifications' => [
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
            'title.max' => 'Title cannot exceed 255 characters.',
            'library_name.string' => 'Library name must be a string.',
            'library_name.max' => 'Library name cannot exceed 255 characters.',
            'library_code.string' => 'Library code must be a string.',
            'library_code.max' => 'Library code cannot exceed 50 characters.',
            'address.string' => 'Address must be a string.',
            'address.max' => 'Address cannot exceed 500 characters.',
            'phone.string' => 'Phone must be a string.',
            'phone.max' => 'Phone cannot exceed 20 characters.',
            'email.email' => 'Email must be a valid email address.',
            'email.max' => 'Email cannot exceed 255 characters.',
            'website.url' => 'Website must be a valid URL.',
            'website.max' => 'Website cannot exceed 255 characters.',
            'logo_file.image' => 'Logo must be an image file.',
            'logo_file.mimes' => 'Logo must be a file of type: jpeg, png, jpg, gif, svg.',
            'logo_file.max' => 'Logo file size cannot exceed 2MB.',
            'background_file.image' => 'Background must be an image file.',
            'background_file.mimes' => 'Background must be a file of type: jpeg, png, jpg, gif, svg.',
            'background_file.max' => 'Background file size cannot exceed 5MB.',
            'fine_per_day.numeric' => 'Fine per day must be a number.',
            'fine_per_day.min' => 'Fine per day must be at least 0.',
            'fine_per_day.max' => 'Fine per day cannot exceed 999.99.',
            'max_books_per_student.integer' => 'Max books per student must be an integer.',
            'max_books_per_student.min' => 'Max books per student must be at least 1.',
            'max_books_per_student.max' => 'Max books per student cannot exceed 50.',
            'max_borrow_days.integer' => 'Max borrow days must be an integer.',
            'max_borrow_days.min' => 'Max borrow days must be at least 1.',
            'max_borrow_days.max' => 'Max borrow days cannot exceed 365.',
            'auto_approve_requests.boolean' => 'Auto approve requests must be true or false.',
            'require_approval.boolean' => 'Require approval must be true or false.',
            'send_notifications.boolean' => 'Send notifications must be true or false.',
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
            'library_name' => 'library name',
            'library_code' => 'library code',
            'address' => 'library address',
            'phone' => 'phone number',
            'email' => 'email address',
            'website' => 'website URL',
            'logo_file' => 'library logo',
            'background_file' => 'background image',
            'fine_per_day' => 'fine per day',
            'max_books_per_student' => 'maximum books per student',
            'max_borrow_days' => 'maximum borrow days',
            'auto_approve_requests' => 'auto approve requests',
            'require_approval' => 'require approval',
            'send_notifications' => 'send notifications',
            'status' => 'setting status',
        ];
    }

    /**
     * Prepare the data for validation.
     *
     * @return void
     */
    protected function prepareForValidation(): void
    {
        // Convert string representations of booleans to actual booleans
        $this->merge([
            'auto_approve_requests' => $this->convertToBoolean($this->auto_approve_requests),
            'require_approval' => $this->convertToBoolean($this->require_approval),
            'send_notifications' => $this->convertToBoolean($this->send_notifications),
        ]);
    }

    /**
     * Convert string representations to boolean.
     *
     * @param mixed $value
     * @return bool|null
     */
    private function convertToBoolean($value): ?bool
    {
        if (is_null($value)) {
            return null;
        }

        if (is_bool($value)) {
            return $value;
        }

        return filter_var($value, FILTER_VALIDATE_BOOLEAN, FILTER_NULL_ON_FAILURE) ?? false;
    }
}
