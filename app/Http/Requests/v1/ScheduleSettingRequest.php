<?php

namespace App\Http\Requests\v1;

use App\Http\Requests\BaseRequest;
use Illuminate\Validation\Rule;

/**
 * ScheduleSettingRequest - Version 1
 *
 * Form request for validating schedule setting data.
 * This request handles validation for schedule setting creation and updates.
 *
 * @package App\Http\Requests\v1
 * @version 1.0.0
 * @author Softmax Technologies
 */
class ScheduleSettingRequest extends BaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        $scheduleSettingId = $this->route('id');
        $isUpdate = $this->isMethod('PUT') || $this->isMethod('PATCH');

        return [
            /**
             * The unique slug identifier for the schedule setting.
             * @var string $slug
             * @example "daily_reminder"
             */
            'slug' => [
                $isUpdate ? 'sometimes' : 'required',
                'string',
                'max:255',
                'regex:/^[a-z0-9\-_]+$/',
                Rule::unique('schedule_settings', 'slug')->ignore($scheduleSettingId),
            ],

            /**
             * The day of the week for the schedule.
             * @var string $day
             * @example "Monday"
             */
            'day' => [
                $isUpdate ? 'sometimes' : 'required',
                'string',
                Rule::in(['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'])
            ],

            /**
             * The time for the schedule.
             * @var string $time
             * @example "09:00"
             */
            'time' => [
                $isUpdate ? 'sometimes' : 'required',
                'string',
                'regex:/^([0-1]?[0-9]|2[0-3]):[0-5][0-9]$/'
            ],

            /**
             * Whether email notifications are enabled.
             * @var bool|null $email
             * @example true
             */
            'email' => [
                'nullable',
                'boolean'
            ],

            /**
             * Whether SMS notifications are enabled.
             * @var bool|null $sms
             * @example true
             */
            'sms' => [
                'nullable',
                'boolean'
            ],

            /**
             * The status of the schedule setting.
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
            'slug.required' => 'Schedule setting slug is required.',
            'slug.string' => 'Schedule setting slug must be a string.',
            'slug.max' => 'Schedule setting slug cannot exceed 255 characters.',
            'slug.regex' => 'Schedule setting slug may only contain lowercase letters, numbers, hyphens, and underscores.',
            'slug.unique' => 'This schedule setting slug is already taken.',
            'day.required' => 'Schedule day is required.',
            'day.string' => 'Schedule day must be a string.',
            'day.in' => 'Schedule day must be a valid day of the week.',
            'time.required' => 'Schedule time is required.',
            'time.string' => 'Schedule time must be a string.',
            'time.regex' => 'Schedule time must be in HH:MM format (24-hour).',
            'email.boolean' => 'Email notification field must be true or false.',
            'sms.boolean' => 'SMS notification field must be true or false.',
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
            'slug' => 'schedule setting slug',
            'day' => 'schedule day',
            'time' => 'schedule time',
            'email' => 'email notification',
            'sms' => 'SMS notification',
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
