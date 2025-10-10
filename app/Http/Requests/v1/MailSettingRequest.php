<?php

namespace App\Http\Requests\v1;

use App\Enums\v1\Status;
use App\Http\Requests\BaseRequest;
use Illuminate\Validation\Rule;

/**
 * Mail Setting Request - Version 1
 *
 * This request class handles validation for mail settings
 * in the College Management System.
 *
 * @package App\Http\Requests\v1
 * @version 1.0.0
 * @author Softmax Technologies
 */
class MailSettingRequest extends BaseRequest
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
             * The mail driver.
             * @var string $driver
             * @example "smtp"
             */
            'driver' => [
                $isUpdate ? 'sometimes' : 'required',
                'string',
                Rule::in(['smtp', 'mailgun', 'ses', 'postmark', 'sendmail', 'log'])
            ],

            /**
             * The mail host.
             * @var string $host
             * @example "smtp.gmail.com"
             */
            'host' => [
                $isUpdate ? 'sometimes' : 'required',
                'string',
                'max:255'
            ],

            /**
             * The mail port.
             * @var string $port
             * @example "587"
             */
            'port' => [
                $isUpdate ? 'sometimes' : 'required',
                'string',
                'max:10'
            ],

            /**
             * The mail username.
             * @var string $username
             * @example "noreply@college.edu"
             */
            'username' => [
                $isUpdate ? 'sometimes' : 'required',
                'string',
                'max:255'
            ],

            /**
             * The mail password.
             * @var string $password
             * @example "your_password"
             */
            'password' => [
                $isUpdate ? 'sometimes' : 'required',
                'string',
                'max:255'
            ],

            /**
             * The mail encryption.
             * @var string $encryption
             * @example "tls"
             */
            'encryption' => [
                $isUpdate ? 'sometimes' : 'required',
                'string',
                Rule::in(['tls', 'ssl', 'null'])
            ],

            /**
             * The sender email.
             * @var string|null $sender_email
             * @example "noreply@college.edu"
             */
            'sender_email' => [
                'nullable',
                'email',
                'max:255'
            ],

            /**
             * The sender name.
             * @var string|null $sender_name
             * @example "College Management System"
             */
            'sender_name' => [
                'nullable',
                'string',
                'max:255'
            ],

            /**
             * The reply email.
             * @var string|null $reply_email
             * @example "support@college.edu"
             */
            'reply_email' => [
                'nullable',
                'email',
                'max:255'
            ],

            /**
             * The mail status.
             * @var string|null $status
             * @example "active"
             */
            'status' => [
                'nullable',
                'string',
                Rule::in(Status::values())
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
            'driver.required' => 'Mail driver is required.',
            'driver.string' => 'Mail driver must be a string.',
            'driver.in' => 'Mail driver must be one of: smtp, mailgun, ses, postmark, sendmail, log.',
            'host.required' => 'Mail host is required.',
            'host.string' => 'Mail host must be a string.',
            'host.max' => 'Mail host cannot exceed 255 characters.',
            'port.required' => 'Mail port is required.',
            'port.string' => 'Mail port must be a string.',
            'port.max' => 'Mail port cannot exceed 10 characters.',
            'username.required' => 'Mail username is required.',
            'username.string' => 'Mail username must be a string.',
            'username.max' => 'Mail username cannot exceed 255 characters.',
            'password.required' => 'Mail password is required.',
            'password.string' => 'Mail password must be a string.',
            'password.max' => 'Mail password cannot exceed 255 characters.',
            'encryption.required' => 'Mail encryption is required.',
            'encryption.string' => 'Mail encryption must be a string.',
            'encryption.in' => 'Mail encryption must be one of: tls, ssl, null.',
            'sender_email.email' => 'Sender email must be a valid email address.',
            'sender_email.max' => 'Sender email cannot exceed 255 characters.',
            'sender_name.string' => 'Sender name must be a string.',
            'sender_name.max' => 'Sender name cannot exceed 255 characters.',
            'reply_email.email' => 'Reply email must be a valid email address.',
            'reply_email.max' => 'Reply email cannot exceed 255 characters.',
            'status.string' => 'Status must be a string.',
            'status.in' => 'Status must be one of: ' . implode(', ', Status::labels()),
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
            'driver' => 'mail driver',
            'host' => 'mail host',
            'port' => 'mail port',
            'username' => 'mail username',
            'password' => 'mail password',
            'encryption' => 'mail encryption',
            'sender_email' => 'sender email',
            'sender_name' => 'sender name',
            'reply_email' => 'reply email',
            'status' => 'mail status',
        ];
    }
}
