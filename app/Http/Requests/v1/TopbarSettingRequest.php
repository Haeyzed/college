<?php

namespace App\Http\Requests\v1;

use App\Http\Requests\BaseRequest;

/**
 * Topbar Setting Request - Version 1
 *
 * This request class handles validation for topbar settings
 * in the College Management System.
 *
 * @package App\Http\Requests\v1
 * @version 1.0.0
 * @author Softmax Technologies
 */
class TopbarSettingRequest extends BaseRequest
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
             * The topbar logo path.
             * @var string|null $logo
             * @example "logos/topbar_logo.png"
             */
            'logo' => [
                'nullable',
                'string',
                'max:255'
            ],

            /**
             * The topbar title.
             * @var string|null $title
             * @example "College Management System"
             */
            'title' => [
                'nullable',
                'string',
                'max:255'
            ],

            /**
             * The topbar subtitle.
             * @var string|null $subtitle
             * @example "Welcome to our platform"
             */
            'subtitle' => [
                'nullable',
                'string',
                'max:255'
            ],

            /**
             * The background color for the topbar.
             * @var string|null $background_color
             * @example "#ffffff"
             */
            'background_color' => [
                'nullable',
                'string',
                'regex:/^#[0-9A-Fa-f]{6}$/'
            ],

            /**
             * The text color for the topbar.
             * @var string|null $text_color
             * @example "#000000"
             */
            'text_color' => [
                'nullable',
                'string',
                'regex:/^#[0-9A-Fa-f]{6}$/'
            ],

            /**
             * The link color for the topbar.
             * @var string|null $link_color
             * @example "#007bff"
             */
            'link_color' => [
                'nullable',
                'string',
                'regex:/^#[0-9A-Fa-f]{6}$/'
            ],

            /**
             * The status of the topbar setting.
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
            'background_color.regex' => 'The background color must be a valid hex color code.',
            'text_color.regex' => 'The text color must be a valid hex color code.',
            'link_color.regex' => 'The link color must be a valid hex color code.',
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
            'logo' => 'Logo',
            'title' => 'Title',
            'subtitle' => 'Subtitle',
            'background_color' => 'Background Color',
            'text_color' => 'Text Color',
            'link_color' => 'Link Color',
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
