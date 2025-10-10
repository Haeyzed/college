<?php

namespace App\Enums\v1;

/**
 * Class Type Enum - Version 1
 *
 * This enum defines the available class types for subjects
 * in the College Management System.
 *
 * @package App\Enums\v1
 * @version 1.0.0
 * @author Softmax Technologies
 */
enum ClassType: string
{
    case THEORY = 'theory';
    case PRACTICAL = 'practical';
    case BOTH = 'both';

    /**
     * Get all class type values as an array.
     *
     * @return array
     */
    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }

    /**
     * Get all class type labels as an array.
     *
     * @return array
     */
    public static function labels(): array
    {
        return array_map(fn($case) => $case->label(), self::cases());
    }

    /**
     * Get the string representation of the class type.
     *
     * @return string
     */
    public function label(): string
    {
        return match ($this) {
            self::THEORY => 'Theory',
            self::PRACTICAL => 'Practical',
            self::BOTH => 'Theory & Practical',
        };
    }

    /**
     * Get all class type options with labels.
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
     * Check if the class type includes theory.
     *
     * @return bool
     */
    public function includesTheory(): bool
    {
        return in_array($this, [self::THEORY, self::BOTH]);
    }

    /**
     * Check if the class type includes practical.
     *
     * @return bool
     */
    public function includesPractical(): bool
    {
        return in_array($this, [self::PRACTICAL, self::BOTH]);
    }
}
