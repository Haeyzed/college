<?php

namespace App\Http\Requests\v1;

use App\Http\Requests\BaseRequest;

/**
 * Social Setting Request - Version 1
 *
 * This request class handles validation for social settings
 * in the College Management System.
 *
 * @package App\Http\Requests\v1
 * @version 1.0.0
 * @author Softmax Technologies
 */
class SocialSettingRequest extends BaseRequest
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
             * The Facebook page URL.
             * @var string|null $facebook_url
             * @example "https://facebook.com/college"
             */
            'facebook_url' => [
                'nullable',
                'url',
                'max:255'
            ],

            /**
             * The Twitter profile URL.
             * @var string|null $twitter_url
             * @example "https://twitter.com/college"
             */
            'twitter_url' => [
                'nullable',
                'url',
                'max:255'
            ],

            /**
             * The Instagram profile URL.
             * @var string|null $instagram_url
             * @example "https://instagram.com/college"
             */
            'instagram_url' => [
                'nullable',
                'url',
                'max:255'
            ],

            /**
             * The LinkedIn page URL.
             * @var string|null $linkedin_url
             * @example "https://linkedin.com/company/college"
             */
            'linkedin_url' => [
                'nullable',
                'url',
                'max:255'
            ],

            /**
             * The YouTube channel URL.
             * @var string|null $youtube_url
             * @example "https://youtube.com/c/college"
             */
            'youtube_url' => [
                'nullable',
                'url',
                'max:255'
            ],

            /**
             * The status of the social setting.
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
            'facebook_url.url' => 'The Facebook URL must be a valid URL.',
            'twitter_url.url' => 'The Twitter URL must be a valid URL.',
            'instagram_url.url' => 'The Instagram URL must be a valid URL.',
            'linkedin_url.url' => 'The LinkedIn URL must be a valid URL.',
            'youtube_url.url' => 'The YouTube URL must be a valid URL.',
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
            'facebook_url' => 'Facebook URL',
            'twitter_url' => 'Twitter URL',
            'instagram_url' => 'Instagram URL',
            'linkedin_url' => 'LinkedIn URL',
            'youtube_url' => 'YouTube URL',
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