<?php

namespace App\Http\Requests\v1;

use App\Http\Requests\BaseRequest;
use Illuminate\Contracts\Validation\ValidationRule;

/**
 * StoreFeeRequest - Version 1
 *
 * Request validation for creating fees.
 * This request handles validation rules for fee creation.
 *
 * @package App\Http\Requests\v1
 * @version 1.0.0
 * @author Softmax Technologies
 */
class StoreFeeRequest extends BaseRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'student_enroll_id' => 'required|exists:student_enrolls,id',
            'category_id' => 'required|exists:fees_categories,id',
            'fee_amount' => 'required|numeric|min:0',
            'fine_amount' => 'nullable|numeric|min:0',
            'discount_amount' => 'nullable|numeric|min:0',
            'paid_amount' => 'nullable|numeric|min:0',
            'assign_date' => 'required|date',
            'due_date' => 'required|date|after:assign_date',
            'pay_date' => 'nullable|date',
            'payment_method' => 'nullable|string|max:255',
            'note' => 'nullable|string',
            'status' => 'nullable|in:unpaid,paid,partial',
            'created_by' => 'nullable|exists:users,id',
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
            'student_enroll_id.required' => 'Student enrollment is required',
            'student_enroll_id.exists' => 'Selected student enrollment does not exist',
            'category_id.required' => 'Fee category is required',
            'category_id.exists' => 'Selected fee category does not exist',
            'fee_amount.required' => 'Fee amount is required',
            'fee_amount.numeric' => 'Fee amount must be a number',
            'fee_amount.min' => 'Fee amount must be at least 0',
            'fine_amount.numeric' => 'Fine amount must be a number',
            'fine_amount.min' => 'Fine amount must be at least 0',
            'discount_amount.numeric' => 'Discount amount must be a number',
            'discount_amount.min' => 'Discount amount must be at least 0',
            'paid_amount.numeric' => 'Paid amount must be a number',
            'paid_amount.min' => 'Paid amount must be at least 0',
            'assign_date.required' => 'Assign date is required',
            'assign_date.date' => 'Assign date must be a valid date',
            'due_date.required' => 'Due date is required',
            'due_date.date' => 'Due date must be a valid date',
            'due_date.after' => 'Due date must be after assign date',
            'pay_date.date' => 'Pay date must be a valid date',
            'payment_method.string' => 'Payment method must be a string',
            'payment_method.max' => 'Payment method cannot exceed 255 characters',
            'note.string' => 'Note must be a string',
            'status.in' => 'Status must be unpaid, paid, or partial',
            'created_by.exists' => 'Selected creator does not exist',
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
            'created_by' => 'created by',
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
            'created_by' => auth()->id() ?? 1,
            'updated_by' => auth()->id() ?? 1,
            'status' => $this->status ?? 'unpaid',
        ]);
    }
}
