<?php

namespace App\Enums\v1;

/**
 * BloodGroup Enum - Version 1
 *
 * Defines blood group options for the College Management System.
 *
 * @package App\Enums\v1
 * @version 1.0.0
 * @author Softmax Technologies
 */
enum BloodGroup: string
{
    case A_POSITIVE = 'a_positive';
    case A_NEGATIVE = 'a_negative';
    case B_POSITIVE = 'b_positive';
    case B_NEGATIVE = 'b_negative';
    case AB_POSITIVE = 'ab_positive';
    case AB_NEGATIVE = 'ab_negative';
    case O_POSITIVE = 'o_positive';
    case O_NEGATIVE = 'o_negative';

    /**
     * Get all blood group options with labels.
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
     * Get the label for the blood group.
     *
     * @return string
     */
    public function label(): string
    {
        return match ($this) {
            self::A_POSITIVE => 'A+',
            self::A_NEGATIVE => 'A-',
            self::B_POSITIVE => 'B+',
            self::B_NEGATIVE => 'B-',
            self::AB_POSITIVE => 'AB+',
            self::AB_NEGATIVE => 'AB-',
            self::O_POSITIVE => 'O+',
            self::O_NEGATIVE => 'O-',
        };
    }
}
