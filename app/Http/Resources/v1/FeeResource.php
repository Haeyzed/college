<?php

namespace App\Http\Resources\v1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * FeeResource - Version 1
 *
 * Resource for transforming Fee model data into API responses.
 * This resource handles fee data formatting for API endpoints.
 *
 * @package App\Http\Resources\v1
 * @version 1.0.0
 * @author Softmax Technologies
 */
class FeeResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param Request $request
     * @return array
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'student_enroll_id' => $this->student_enroll_id,
            'category_id' => $this->category_id,
            'fee_amount' => $this->fee_amount,
            'fine_amount' => $this->fine_amount,
            'discount_amount' => $this->discount_amount,
            'paid_amount' => $this->paid_amount,
            'assign_date' => $this->assign_date?->format('Y-m-d H:i:s'),
            'due_date' => $this->due_date?->format('Y-m-d H:i:s'),
            'pay_date' => $this->pay_date?->format('Y-m-d H:i:s'),
            'payment_method' => $this->payment_method,
            'note' => $this->note,
            'status' => $this->status,
            'created_by' => $this->created_by,
            'updated_by' => $this->updated_by,
            'created_at' => $this->created_at?->format('Y-m-d H:i:s'),
            'updated_at' => $this->updated_at?->format('Y-m-d H:i:s'),

            // Relationships
            'student_enroll' => new StudentEnrollResource($this->whenLoaded('studentEnroll')),
            'category' => new FeesCategoryResource($this->whenLoaded('category')),

            // Computed fields
            'remaining_amount' => $this->fee_amount - $this->paid_amount,
            'is_overdue' => $this->due_date && $this->due_date < now() && $this->status !== 'paid',
            'days_overdue' => $this->due_date && $this->due_date < now() ? now()->diffInDays($this->due_date) : 0,
            'payment_percentage' => $this->fee_amount > 0 ? round(($this->paid_amount / $this->fee_amount) * 100, 2) : 0,
        ];
    }
}
