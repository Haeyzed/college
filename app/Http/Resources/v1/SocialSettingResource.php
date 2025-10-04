<?php

namespace App\Http\Resources\v1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * SocialSettingResource - Version 1
 *
 * Resource for transforming SocialSetting model data into API responses.
 * This resource handles social setting data formatting for API endpoints.
 *
 * @package App\Http\Resources\v1
 * @version 1.0.0
 * @author Softmax Technologies
 */
class SocialSettingResource extends JsonResource
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
             * The unique identifier of the social setting.
             * @var int $id
             * @example 1
             */
            'id' => $this->id,

            /**
             * The Facebook page URL.
             * @var string|null $facebook_url
             * @example "https://facebook.com/college"
             */
            'facebook_url' => $this->facebook_url,

            /**
             * The Twitter profile URL.
             * @var string|null $twitter_url
             * @example "https://twitter.com/college"
             */
            'twitter_url' => $this->twitter_url,

            /**
             * The Instagram profile URL.
             * @var string|null $instagram_url
             * @example "https://instagram.com/college"
             */
            'instagram_url' => $this->instagram_url,

            /**
             * The LinkedIn page URL.
             * @var string|null $linkedin_url
             * @example "https://linkedin.com/company/college"
             */
            'linkedin_url' => $this->linkedin_url,

            /**
             * The YouTube channel URL.
             * @var string|null $youtube_url
             * @example "https://youtube.com/c/college"
             */
            'youtube_url' => $this->youtube_url,

            /**
             * The status of the social setting.
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
             * Whether the social setting is active.
             * @var bool $is_active
             * @example true
             */
            'is_active' => $this->status,

            /**
             * The number of active social platforms.
             * @var int $active_platforms_count
             * @example 3
             */
            'active_platforms_count' => collect([
                $this->facebook_url,
                $this->twitter_url,
                $this->instagram_url,
                $this->linkedin_url,
                $this->youtube_url
            ])->filter()->count(),

            /**
             * List of active social platforms.
             * @var array $active_platforms
             * @example ["facebook", "twitter", "instagram"]
             */
            'active_platforms' => collect([
                'facebook' => $this->facebook_url,
                'twitter' => $this->twitter_url,
                'instagram' => $this->instagram_url,
                'linkedin' => $this->linkedin_url,
                'youtube' => $this->youtube_url
            ])->filter()->keys()->toArray(),
        ];
    }
}