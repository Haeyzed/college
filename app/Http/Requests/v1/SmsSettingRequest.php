<?php

namespace App\Http\Requests\v1;

use App\Http\Requests\BaseRequest;
use Illuminate\Validation\Rule;

/**
 * SMS Setting Request - Version 1
 *
 * This request class handles validation for SMS settings
 * in the College Management System.
 *
 * @package App\Http\Requests\v1
 * @version 1.0.0
 * @author Softmax Technologies
 */
class SmsSettingRequest extends BaseRequest
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
             * The Nexmo API key.
             * @var string|null $nexmo_key
             * @example "your_nexmo_key"
             */
            'nexmo_key' => [
                'nullable',
                'string',
                'max:255'
            ],

            /**
             * The Nexmo API secret.
             * @var string|null $nexmo_secret
             * @example "your_nexmo_secret"
             */
            'nexmo_secret' => [
                'nullable',
                'string',
                'max:255'
            ],

            /**
             * The Nexmo sender name.
             * @var string|null $nexmo_sender_name
             * @example "College"
             */
            'nexmo_sender_name' => [
                'nullable',
                'string',
                'max:255'
            ],

            /**
             * The Twilio SID.
             * @var string|null $twilio_sid
             * @example "your_twilio_sid"
             */
            'twilio_sid' => [
                'nullable',
                'string',
                'max:255'
            ],

            /**
             * The Twilio auth token.
             * @var string|null $twilio_auth_token
             * @example "your_twilio_auth_token"
             */
            'twilio_auth_token' => [
                'nullable',
                'string',
                'max:255'
            ],

            /**
             * The Twilio phone number.
             * @var string|null $twilio_number
             * @example "+1234567890"
             */
            'twilio_number' => [
                'nullable',
                'string',
                'max:20'
            ],

            /**
             * The SMS provider status.
             * @var string|null $status
             * @example "twilio"
             */
            'status' => [
                'nullable',
                'string',
                Rule::in(['nexmo', 'twilio', 'inactive'])
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
            'nexmo_key.string' => 'Nexmo key must be a string.',
            'nexmo_key.max' => 'Nexmo key cannot exceed 255 characters.',
            'nexmo_secret.string' => 'Nexmo secret must be a string.',
            'nexmo_secret.max' => 'Nexmo secret cannot exceed 255 characters.',
            'nexmo_sender_name.string' => 'Nexmo sender name must be a string.',
            'nexmo_sender_name.max' => 'Nexmo sender name cannot exceed 255 characters.',
            'twilio_sid.string' => 'Twilio SID must be a string.',
            'twilio_sid.max' => 'Twilio SID cannot exceed 255 characters.',
            'twilio_auth_token.string' => 'Twilio auth token must be a string.',
            'twilio_auth_token.max' => 'Twilio auth token cannot exceed 255 characters.',
            'twilio_number.string' => 'Twilio number must be a string.',
            'twilio_number.max' => 'Twilio number cannot exceed 20 characters.',
            'status.string' => 'Status must be a string.',
            'status.in' => 'Status must be one of: nexmo, twilio, inactive.',
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
            'nexmo_key' => 'Nexmo API key',
            'nexmo_secret' => 'Nexmo API secret',
            'nexmo_sender_name' => 'Nexmo sender name',
            'twilio_sid' => 'Twilio SID',
            'twilio_auth_token' => 'Twilio auth token',
            'twilio_number' => 'Twilio phone number',
            'status' => 'SMS provider status',
        ];
    }
}
