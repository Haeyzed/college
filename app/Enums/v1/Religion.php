<?php

namespace App\Enums\v1;

/**
 * Religion Enum - Version 1
 *
 * Defines religion options for the College Management System.
 *
 * @package App\Enums\v1
 * @version 1.0.1
 * @author Softmax Technologies
 */
enum Religion: string
{
    case CHRISTIANITY = 'christianity';
    case ISLAM = 'islam';
    case TRADITIONAL = 'traditional';
    case OTHER = 'other';
    case NONE = 'none';

    /**
     * Get all religion options with labels.
     *
     * @return array
     */
    public static function options(): array
    {
        return collect(self::cases())->map(function ($case) {
            return [
                'value' => $case->value,
                'label' => $case->label(),
            ];
        })->toArray();
    }

    /**
     * Get the label for the religion.
     *
     * @return string
     */
    public function label(): string
    {
        return match ($this) {
            self::CHRISTIANITY => 'Christianity',
            self::ISLAM => 'Islam',
            self::TRADITIONAL => 'Traditional Religion',
            self::OTHER => 'Other',
            self::NONE => 'None',
        };
    }
}
