<?php

namespace App\Enums\v1;

/**
 * Gender Enum - Version 1
 *
 * Defines gender options for the College Management System.
 *
 * @package App\Enums\v1
 * @version 1.0.0
 * @author Softmax Technologies
 */
enum Gender: string
{
    case MALE = 'male';
    case FEMALE = 'female';
    case OTHER = 'other';

    /**
     * Get all gender options with labels.
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
     * Get the label for the gender.
     *
     * @return string
     */
    public function label(): string
    {
        return match ($this) {
            self::MALE => 'Male',
            self::FEMALE => 'Female',
            self::OTHER => 'Other',
        };
    }
}
