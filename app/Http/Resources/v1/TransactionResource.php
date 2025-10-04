<?php

namespace App\Http\Resources\v1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Transaction Resource - Version 1
 *
 * This resource transforms Transaction model data for API responses
 * in the College Management System.
 *
 * @package App\Http\Resources\v1
 * @version 1.0.0
 * @author Softmax Technologies
 */
class TransactionResource extends JsonResource
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
            'id' => $this->id,
            'transaction_no' => $this->transaction_no,
            'transaction_type' => $this->transaction_type,
            'transaction_type_text' => $this->getTransactionTypeText(),
            'amount' => $this->amount,
            'payment_method' => $this->payment_method,
            'payment_method_text' => $this->getPaymentMethodText(),
            'transaction_date' => $this->transaction_date?->format('Y-m-d H:i:s'),
            'due_date' => $this->due_date?->format('Y-m-d'),
            'paid_date' => $this->paid_date?->format('Y-m-d H:i:s'),
            'reference_no' => $this->reference_no,
            'description' => $this->description,
            'status' => $this->status,
            'status_text' => $this->getStatusText(),
            'is_paid' => $this->is_paid,
            'is_overdue' => $this->is_overdue,
            'late_fee' => $this->late_fee,
            'discount' => $this->discount,
            'tax' => $this->tax,
            'net_amount' => $this->net_amount,
            'receipt_no' => $this->receipt_no,
            'receipt_path' => $this->receipt_path,
            'notes' => $this->notes,
            'sort_order' => $this->sort_order,

            // Polymorphic Relationship Information
            'transactionable_info' => [
                'transactionable_type' => $this->transactionable_type,
                'transactionable_id' => $this->transactionable_id,
                'transactionable' => $this->when($this->transactionable, function () {
                    return match ($this->transactionable_type) {
                        'App\Models\v1\Student' => new StudentResource($this->transactionable),
                        'App\Models\v1\Fee' => new FeeResource($this->transactionable),
                        'App\Models\v1\Application' => new ApplicationResource($this->transactionable),
                        default => $this->transactionable,
                    };
                }),
            ],

            // Timestamps
            'timestamps' => [
                'created_at' => $this->created_at?->format('Y-m-d H:i:s'),
                'updated_at' => $this->updated_at?->format('Y-m-d H:i:s'),
            ],
        ];
    }
}
