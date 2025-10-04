<?php

namespace App\Http\Resources\v1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * TaxSettingResource - Version 1
 *
 * Resource for transforming TaxSetting model data into API responses.
 * This resource handles tax setting data formatting for API endpoints.
 *
 * @package App\Http\Resources\v1
 * @version 1.0.0
 * @author Softmax Technologies
 */
class TaxSettingResource extends JsonResource
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
             * The unique identifier of the tax setting.
             * @var int $id
             * @example 1
             */
            'id' => $this->id,

            /**
             * The minimum amount for tax calculation.
             * @var float $min_amount
             * @example 1000.00
             */
            'min_amount' => $this->min_amount,

            /**
             * The maximum amount for tax calculation.
             * @var float $max_amount
             * @example 50000.00
             */
            'max_amount' => $this->max_amount,

            /**
             * The tax percentage.
             * @var float $percentange
             * @example 15.00
             */
            'percentange' => $this->percentange,

            /**
             * The maximum non-taxable amount.
             * @var float $max_no_taxable_amount
             * @example 5000.00
             */
            'max_no_taxable_amount' => $this->max_no_taxable_amount,

            /**
             * The status of the tax setting.
             * @var bool $status
             * @example true
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

            // Computed fields
            /**
             * Whether the tax setting is active.
             * @var bool $is_active
             * @example true
             */
            'is_active' => $this->status,

            /**
             * The formatted minimum amount with currency.
             * @var string $formatted_min_amount
             * @example "$1,000.00"
             */
            'formatted_min_amount' => '$' . number_format($this->min_amount, 2),

            /**
             * The formatted maximum amount with currency.
             * @var string $formatted_max_amount
             * @example "$50,000.00"
             */
            'formatted_max_amount' => '$' . number_format($this->max_amount, 2),

            /**
             * The formatted tax percentage.
             * @var string $formatted_percentage
             * @example "15.00%"
             */
            'formatted_percentage' => number_format($this->percentange, 2) . '%',

            /**
             * The formatted maximum non-taxable amount with currency.
             * @var string $formatted_max_no_taxable_amount
             * @example "$5,000.00"
             */
            'formatted_max_no_taxable_amount' => '$' . number_format($this->max_no_taxable_amount, 2),

            /**
             * The tax range description.
             * @var string $tax_range_description
             * @example "$1,000.00 - $50,000.00 at 15.00%"
             */
            'tax_range_description' => '$' . number_format($this->min_amount, 2) . ' - $' . number_format($this->max_amount, 2) . ' at ' . number_format($this->percentange, 2) . '%',

            /**
             * The amount range for tax calculation.
             * @var string $amount_range
             * @example "$1,000.00 - $50,000.00"
             */
            'amount_range' => '$' . number_format($this->min_amount, 2) . ' - $' . number_format($this->max_amount, 2),

            /**
             * Whether the tax setting has a valid range.
             * @var bool $has_valid_range
             * @example true
             */
            'has_valid_range' => $this->min_amount < $this->max_amount,

            /**
             * The tax rate as a decimal.
             * @var float $tax_rate_decimal
             * @example 0.15
             */
            'tax_rate_decimal' => $this->percentange / 100,

            /**
             * The range span in currency.
             * @var float $range_span
             * @example 49000.00
             */
            'range_span' => $this->max_amount - $this->min_amount,
        ];
    }
}
