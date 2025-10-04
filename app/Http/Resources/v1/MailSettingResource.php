<?php

namespace App\Http\Resources\v1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * MailSettingResource - Version 1
 *
 * Resource for transforming MailSetting model data into API responses.
 * This resource handles mail setting data formatting for API endpoints.
 *
 * @package App\Http\Resources\v1
 * @version 1.0.0
 * @author Softmax Technologies
 */
class MailSettingResource extends JsonResource
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
             * The unique identifier of the mail setting.
             * @var int $id
             * @example 1
             */
            'id' => $this->id,

            /**
             * The mail driver (smtp, mailgun, etc.).
             * @var string $driver
             * @example "smtp"
             */
            'driver' => $this->driver,

            /**
             * The mail server host.
             * @var string $host
             * @example "smtp.gmail.com"
             */
            'host' => $this->host,

            /**
             * The mail server port.
             * @var int $port
             * @example 587
             */
            'port' => $this->port,

            /**
             * The mail server username.
             * @var string $username
             * @example "noreply@college.edu"
             */
            'username' => $this->username,

            /**
             * The mail server password (masked for security).
             * @var string $password
             * @example "****"
             */
            'password' => $this->password ? '****' : null,

            /**
             * The encryption type (tls, ssl, etc.).
             * @var string $encryption
             * @example "tls"
             */
            'encryption' => $this->encryption,

            /**
             * The sender email address.
             * @var string $sender_email
             * @example "noreply@college.edu"
             */
            'sender_email' => $this->sender_email,

            /**
             * The sender name.
             * @var string $sender_name
             * @example "College Management System"
             */
            'sender_name' => $this->sender_name,

            /**
             * The reply-to email address.
             * @var string $reply_email
             * @example "support@college.edu"
             */
            'reply_email' => $this->reply_email,

            /**
             * The status of the mail setting.
             * @var string $status
             * @example active
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
        ];
    }
}
