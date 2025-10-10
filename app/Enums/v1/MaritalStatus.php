<?php

namespace App\Enums\v1;

/**
 * MaritalStatus Enum - Version 1
 *
 * Defines marital status options for the College Management System.
 *
 * @package App\Enums\v1
 * @version 1.0.0
 * @author Softmax Technologies
 */
enum MaritalStatus: string
{
    case SINGLE = 'single';
    case MARRIED = 'married';
    case DIVORCED = 'divorced';
    case WIDOWED = 'widowed';
    case SEPARATED = 'separated';

    /**
     * Get all marital status options with labels.
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
     * Get the label for the marital status.
     *
     * @return string
     */
    public function label(): string
    {
        return match ($this) {
            self::SINGLE => 'Single',
            self::MARRIED => 'Married',
            self::DIVORCED => 'Divorced',
            self::WIDOWED => 'Widowed',
            self::SEPARATED => 'Separated',
        };
    }
}
