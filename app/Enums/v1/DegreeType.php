<?php

namespace App\Enums\v1;

/**
 * Degree Type Enum - Version 1
 *
 * This enum defines the available degree types for programs
 * in the College Management System.
 *
 * @package App\Enums\v1
 * @version 1.0.0
 * @author Softmax Technologies
 */
enum DegreeType: string
{
    case BACHELOR = 'bachelor';
    case MASTER = 'master';
    case PHD = 'phd';
    case DIPLOMA = 'diploma';
    case CERTIFICATE = 'certificate';

    /**
     * Get all degree type values as an array.
     *
     * @return array
     */
    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }

    /**
     * Get all degree type labels as an array.
     *
     * @return array
     */
    public static function labels(): array
    {
        return array_map(fn($case) => $case->label(), self::cases());
    }

    /**
     * Get the string representation of the degree type.
     *
     * @return string
     */
    public function label(): string
    {
        return match ($this) {
            self::BACHELOR => 'Bachelor\'s Degree',
            self::MASTER => 'Master\'s Degree',
            self::PHD => 'Doctor of Philosophy',
            self::DIPLOMA => 'Diploma',
            self::CERTIFICATE => 'Certificate',
        };
    }

    /**
     * Get all degree type options with labels.
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
     * Check if the degree type is a graduate program.
     *
     * @return bool
     */
    public function isGraduateProgram(): bool
    {
        return in_array($this, [self::MASTER, self::PHD]);
    }

    /**
     * Check if the degree type is an undergraduate program.
     *
     * @return bool
     */
    public function isUndergraduateProgram(): bool
    {
        return in_array($this, [self::BACHELOR, self::DIPLOMA, self::CERTIFICATE]);
    }

    /**
     * Get the typical duration in years for the degree type.
     *
     * @return int
     */
    public function getTypicalDuration(): int
    {
        return match ($this) {
            self::BACHELOR => 4,
            self::MASTER => 2,
            self::PHD => 3,
            self::DIPLOMA => 2,
            self::CERTIFICATE => 1,
        };
    }
}
