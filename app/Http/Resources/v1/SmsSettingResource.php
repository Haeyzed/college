<?php

namespace App\Http\Resources\v1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * SmsSettingResource - Version 1
 *
 * Resource for transforming SmsSetting model data into API responses.
 * This resource handles SMS setting data formatting for API endpoints.
 *
 * @package App\Http\Resources\v1
 * @version 1.0.0
 * @author Softmax Technologies
 */
class SmsSettingResource extends JsonResource
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
             * The unique identifier of the SMS setting.
             * @var int $id
             * @example 1
             */
            'id' => $this->id,

            /**
             * The Nexmo API key.
             * @var string|null $nexmo_key
             * @example "your_nexmo_key"
             */
            'nexmo_key' => $this->nexmo_key,

            /**
             * The Nexmo API secret.
             * @var string|null $nexmo_secret
             * @example "****"
             */
            'nexmo_secret' => $this->nexmo_secret ? '****' : null,

            /**
             * The Nexmo sender name.
             * @var string|null $nexmo_sender_name
             * @example "College SMS"
             */
            'nexmo_sender_name' => $this->nexmo_sender_name,

            /**
             * The Twilio SID.
             * @var string|null $twilio_sid
             * @example "your_twilio_sid"
             */
            'twilio_sid' => $this->twilio_sid,

            /**
             * The Twilio auth token.
             * @var string|null $twilio_auth_token
             * @example "****"
             */
            'twilio_auth_token' => $this->twilio_auth_token ? '****' : null,

            /**
             * The Twilio number.
             * @var string|null $twilio_number
             * @example "+1234567890"
             */
            'twilio_number' => $this->twilio_number,

            /**
             * The status of the SMS setting.
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
             * Whether the SMS setting is active.
             * @var bool $is_active
             * @example true
             */
            'is_active' => $this->status,

            /**
             * The SMS configuration summary.
             * @var string $configuration_summary
             * @example "Nexmo - College SMS"
             */
            'configuration_summary' => $this->nexmo_key ? 'Nexmo - ' . $this->nexmo_sender_name : 'Twilio - ' . $this->twilio_number,

            /**
             * Whether the SMS setting has API credentials.
             * @var bool $has_credentials
             * @example true
             */
            'has_credentials' => (!empty($this->nexmo_key) && !empty($this->nexmo_secret)) || 
                                (!empty($this->twilio_sid) && !empty($this->twilio_auth_token)),

            /**
             * The masked API key for display.
             * @var string|null $masked_api_key
             * @example "nex***key"
             */
            'masked_api_key' => $this->nexmo_key 
                ? substr($this->nexmo_key, 0, 3) . '***' . substr($this->nexmo_key, -3)
                : ($this->twilio_sid ? substr($this->twilio_sid, 0, 3) . '***' . substr($this->twilio_sid, -3) : null),
        ];
    }
}
