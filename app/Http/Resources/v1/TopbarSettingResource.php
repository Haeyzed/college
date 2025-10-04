<?php

namespace App\Http\Resources\v1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * TopbarSettingResource - Version 1
 *
 * Resource for transforming TopbarSetting model data into API responses.
 * This resource handles topbar setting data formatting for API endpoints.
 *
 * @package App\Http\Resources\v1
 * @version 1.0.0
 * @author Softmax Technologies
 */
class TopbarSettingResource extends JsonResource
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
             * The unique identifier of the topbar setting.
             * @var int $id
             * @example 1
             */
            'id' => $this->id,

            /**
             * The topbar logo path.
             * @var string|null $logo
             * @example "logos/topbar_logo.png"
             */
            'logo' => $this->logo,

            /**
             * The topbar title.
             * @var string|null $title
             * @example "College Management System"
             */
            'title' => $this->title,

            /**
             * The topbar subtitle.
             * @var string|null $subtitle
             * @example "Welcome to our platform"
             */
            'subtitle' => $this->subtitle,

            /**
             * The background color for the topbar.
             * @var string|null $background_color
             * @example "#ffffff"
             */
            'background_color' => $this->background_color,

            /**
             * The text color for the topbar.
             * @var string|null $text_color
             * @example "#000000"
             */
            'text_color' => $this->text_color,

            /**
             * The link color for the topbar.
             * @var string|null $link_color
             * @example "#007bff"
             */
            'link_color' => $this->link_color,

            /**
             * The status of the topbar setting.
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
             * Whether the topbar setting is active.
             * @var bool $is_active
             * @example true
             */
            'is_active' => $this->status,

            /**
             * The complete topbar configuration summary.
             * @var string $configuration_summary
             * @example "College Management System - Welcome to our platform"
             */
            'configuration_summary' => ($this->title ?: 'Topbar') . ($this->subtitle ? ' - ' . $this->subtitle : ''),

            /**
             * Whether the topbar has a logo.
             * @var bool $has_logo
             * @example true
             */
            'has_logo' => !empty($this->logo),

            /**
             * Whether the topbar has custom colors.
             * @var bool $has_custom_colors
             * @example true
             */
            'has_custom_colors' => !empty($this->background_color) || !empty($this->text_color) || !empty($this->link_color),

            /**
             * The topbar color scheme.
             * @var array $color_scheme
             * @example {"background": "#ffffff", "text": "#000000", "link": "#007bff"}
             */
            'color_scheme' => [
                'background' => $this->background_color,
                'text' => $this->text_color,
                'link' => $this->link_color,
            ],
        ];
    }
}
