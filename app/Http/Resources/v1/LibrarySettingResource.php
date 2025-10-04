<?php

namespace App\Http\Resources\v1;

use App\Helpers\StorageHelper;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * LibrarySettingResource - Version 1
 *
 * Resource for transforming LibrarySetting model data into API responses.
 * This resource handles library setting data formatting for API endpoints.
 *
 * @package App\Http\Resources\v1
 * @version 1.0.0
 * @author Softmax Technologies
 */
class LibrarySettingResource extends JsonResource
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
             * The unique identifier of the library setting.
             * @var int $id
             * @example 1
             */
            'id' => $this->id,

            /**
             * The unique slug identifier for the library setting.
             * @var string $slug
             * @example "library_main"
             */
            'slug' => $this->slug,

            /**
             * The title of the library setting.
             * @var string|null $title
             * @example "Main Library Settings"
             */
            'title' => $this->title,

            /**
             * The library name.
             * @var string|null $library_name
             * @example "Central Library"
             */
            'library_name' => $this->library_name,

            /**
             * The library code.
             * @var string|null $library_code
             * @example "LIB001"
             */
            'library_code' => $this->library_code,

            /**
             * The library address.
             * @var string|null $address
             * @example "123 College Street, City, State"
             */
            'address' => $this->address,

            /**
             * The library phone number.
             * @var string|null $phone
             * @example "+1-234-567-8900"
             */
            'phone' => $this->phone,

            /**
             * The library email.
             * @var string|null $email
             * @example "library@college.edu"
             */
            'email' => $this->email,

            /**
             * The library website.
             * @var string|null $website
             * @example "https://library.college.edu"
             */
            'website' => $this->website,

            /**
             * The library logo URL.
             * @var string|null $logo_url
             * @example "http://localhost/storage/library/logos/logo.png"
             */
            'logo_url' => StorageHelper::getConfigurableStorageUrl($this->logo, 'filesystems.default'),

            /**
             * The background image URL.
             * @var string|null $background_url
             * @example "http://localhost/storage/library/backgrounds/bg.jpg"
             */
            'background_url' => StorageHelper::getConfigurableStorageUrl($this->background, 'filesystems.default'),

            /**
             * The fine amount per day for overdue books.
             * @var float|null $fine_per_day
             * @example 1.50
             */
            'fine_per_day' => $this->fine_per_day,

            /**
             * The maximum number of books a student can borrow.
             * @var int|null $max_books_per_student
             * @example 5
             */
            'max_books_per_student' => $this->max_books_per_student,

            /**
             * The maximum number of days a book can be borrowed.
             * @var int|null $max_borrow_days
             * @example 14
             */
            'max_borrow_days' => $this->max_borrow_days,

            /**
             * Whether to automatically approve book requests.
             * @var bool $auto_approve_requests
             * @example false
             */
            'auto_approve_requests' => $this->auto_approve_requests,

            /**
             * Whether book requests require approval.
             * @var bool $require_approval
             * @example true
             */
            'require_approval' => $this->require_approval,

            /**
             * Whether to send notifications for library activities.
             * @var bool $send_notifications
             * @example true
             */
            'send_notifications' => $this->send_notifications,

            /**
             * The status of the library setting.
             * @var string $status
             * @example "active"
             */
            'status' => $this->status?->value ?? $this->status,

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
             * Whether the library setting is active.
             * @var bool $is_active
             * @example true
             */
            'is_active' => ($this->status?->value ?? $this->status) === 'active',

            /**
             * Whether the library has a logo.
             * @var bool $has_logo
             * @example true
             */
            'has_logo' => !empty($this->logo),

            /**
             * Whether the library has a background image.
             * @var bool $has_background
             * @example true
             */
            'has_background' => !empty($this->background),

            /**
             * The formatted fine amount with currency.
             * @var string|null $formatted_fine
             * @example "$1.50"
             */
            'formatted_fine' => $this->fine_per_day ? '$' . number_format($this->fine_per_day, 2) : null,

            /**
             * The library contact information.
             * @var array $contact_info
             * @example {"phone": "+1-234-567-8900", "email": "library@college.edu", "website": "https://library.college.edu"}
             */
            'contact_info' => [
                'phone' => $this->phone,
                'email' => $this->email,
                'website' => $this->website,
            ],

            /**
             * The library borrowing rules.
             * @var array $borrowing_rules
             * @example {"max_books": 5, "max_days": 14, "fine_per_day": 1.50}
             */
            'borrowing_rules' => [
                'max_books' => $this->max_books_per_student,
                'max_days' => $this->max_borrow_days,
                'fine_per_day' => $this->fine_per_day,
            ],

            /**
             * The library request settings.
             * @var array $request_settings
             * @example {"auto_approve": false, "require_approval": true, "send_notifications": true}
             */
            'request_settings' => [
                'auto_approve' => $this->auto_approve_requests,
                'require_approval' => $this->require_approval,
                'send_notifications' => $this->send_notifications,
            ],

            /**
             * The library image assets.
             * @var array $image_assets
             * @example {"logo": {"url": "http://localhost/storage/library/logos/logo.png", "has_image": true}, "background": {"url": "http://localhost/storage/library/backgrounds/bg.jpg", "has_image": true}}
             */
            'image_assets' => [
                'logo' => [
                    'url' => StorageHelper::getConfigurableStorageUrl($this->logo, 'filesystems.default'),
                    'has_image' => !empty($this->logo),
                ],
                'background' => [
                    'url' => StorageHelper::getConfigurableStorageUrl($this->background, 'filesystems.default'),
                    'has_image' => !empty($this->background),
                ],
            ],
        ];
    }
}
