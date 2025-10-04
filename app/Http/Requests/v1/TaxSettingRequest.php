<?php

namespace App\Http\Requests\v1;

use App\Http\Requests\BaseRequest;

/**
 * TaxSettingRequest - Version 1
 *
 * Form request for validating tax setting data.
 * This request handles validation for tax setting creation and updates.
 *
 * @package App\Http\Requests\v1
 * @version 1.0.0
 * @author Softmax Technologies
 */
class TaxSettingRequest extends BaseRequest
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
             * The minimum amount for tax calculation.
             * @var float $min_amount
             * @example 1000.00
             */
            'min_amount' => [
                $isUpdate ? 'sometimes' : 'required',
                'numeric',
                'min:0',
                'max:999999.99'
            ],

            /**
             * The maximum amount for tax calculation.
             * @var float $max_amount
             * @example 50000.00
             */
            'max_amount' => [
                $isUpdate ? 'sometimes' : 'required',
                'numeric',
                'min:0',
                'max:999999.99',
                'gte:min_amount'
            ],

            /**
             * The tax percentage.
             * @var float $percentange
             * @example 15.00
             */
            'percentange' => [
                $isUpdate ? 'sometimes' : 'required',
                'numeric',
                'min:0',
                'max:100'
            ],

            /**
             * The maximum non-taxable amount.
             * @var float $max_no_taxable_amount
             * @example 5000.00
             */
            'max_no_taxable_amount' => [
                $isUpdate ? 'sometimes' : 'required',
                'numeric',
                'min:0',
                'max:999999.99'
            ],

            /**
             * The status of the tax setting.
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
            'min_amount.required' => 'Minimum amount is required.',
            'min_amount.numeric' => 'Minimum amount must be a valid number.',
            'min_amount.min' => 'Minimum amount must be at least 0.',
            'min_amount.max' => 'Minimum amount cannot exceed 999,999.99.',
            'max_amount.required' => 'Maximum amount is required.',
            'max_amount.numeric' => 'Maximum amount must be a valid number.',
            'max_amount.min' => 'Maximum amount must be at least 0.',
            'max_amount.max' => 'Maximum amount cannot exceed 999,999.99.',
            'max_amount.gte' => 'Maximum amount must be greater than or equal to the minimum amount.',
            'percentange.required' => 'Tax percentage is required.',
            'percentange.numeric' => 'Tax percentage must be a valid number.',
            'percentange.min' => 'Tax percentage must be at least 0.',
            'percentange.max' => 'Tax percentage cannot exceed 100.',
            'max_no_taxable_amount.required' => 'Maximum non-taxable amount is required.',
            'max_no_taxable_amount.numeric' => 'Maximum non-taxable amount must be a valid number.',
            'max_no_taxable_amount.min' => 'Maximum non-taxable amount must be at least 0.',
            'max_no_taxable_amount.max' => 'Maximum non-taxable amount cannot exceed 999,999.99.',
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
            'min_amount' => 'minimum amount',
            'max_amount' => 'maximum amount',
            'percentange' => 'tax percentage',
            'max_no_taxable_amount' => 'maximum non-taxable amount',
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
