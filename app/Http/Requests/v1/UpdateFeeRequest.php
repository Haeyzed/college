<?php

namespace App\Http\Requests\v1;

use App\Http\Requests\BaseRequest;
use Illuminate\Contracts\Validation\ValidationRule;

/**
 * UpdateFeeRequest - Version 1
 *
 * Request validation for updating fees.
 * This request handles validation rules for fee updates.
 *
 * @package App\Http\Requests\v1
 * @version 1.0.0
 * @author Softmax Technologies
 */
class UpdateFeeRequest extends BaseRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'student_enroll_id' => 'sometimes|exists:student_enrolls,id',
            'category_id' => 'sometimes|exists:fees_categories,id',
            'fee_amount' => 'sometimes|numeric|min:0',
            'fine_amount' => 'nullable|numeric|min:0',
            'discount_amount' => 'nullable|numeric|min:0',
            'paid_amount' => 'nullable|numeric|min:0',
            'assign_date' => 'sometimes|date',
            'due_date' => 'sometimes|date',
            'pay_date' => 'nullable|date',
            'payment_method' => 'nullable|string|max:255',
            'note' => 'nullable|string',
            'status' => 'sometimes|in:unpaid,paid,partial',
            'updated_by' => 'nullable|exists:users,id',
        ];
    }

    /**
     * Get custom messages for validator errors.
     *
     * @return array
     */
    public function messages(): array
    {
        return [
            'student_enroll_id.exists' => 'Selected student enrollment does not exist',
            'category_id.exists' => 'Selected fee category does not exist',
            'fee_amount.numeric' => 'Fee amount must be a number',
            'fee_amount.min' => 'Fee amount must be at least 0',
            'fine_amount.numeric' => 'Fine amount must be a number',
            'fine_amount.min' => 'Fine amount must be at least 0',
            'discount_amount.numeric' => 'Discount amount must be a number',
            'discount_amount.min' => 'Discount amount must be at least 0',
            'paid_amount.numeric' => 'Paid amount must be a number',
            'paid_amount.min' => 'Paid amount must be at least 0',
            'assign_date.date' => 'Assign date must be a valid date',
            'due_date.date' => 'Due date must be a valid date',
            'pay_date.date' => 'Pay date must be a valid date',
            'payment_method.string' => 'Payment method must be a string',
            'payment_method.max' => 'Payment method cannot exceed 255 characters',
            'note.string' => 'Note must be a string',
            'status.in' => 'Status must be unpaid, paid, or partial',
            'updated_by.exists' => 'Selected updater does not exist',
        ];
    }

    /**
     * Get custom attributes for validator errors.
     *
     * @return array
     */
    public function attributes(): array
    {
        return [
            'student_enroll_id' => 'student enrollment',
            'category_id' => 'fee category',
            'fee_amount' => 'fee amount',
            'fine_amount' => 'fine amount',
            'discount_amount' => 'discount amount',
            'paid_amount' => 'paid amount',
            'assign_date' => 'assign date',
            'due_date' => 'due date',
            'pay_date' => 'pay date',
            'payment_method' => 'payment method',
            'updated_by' => 'updated by',
        ];
    }

    /**
     * Prepare the data for validation.
     *
     * @return void
     */
    protected function prepareForValidation(): void
    {
        $this->merge([
            'updated_by' => auth()->id() ?? 1,
        ]);
    }
}
