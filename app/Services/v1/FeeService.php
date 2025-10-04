<?php

namespace App\Services\v1;

use App\Models\v1\Fee;
use App\Models\v1\StudentEnroll;
use App\Http\Resources\v1\FeeResource;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

/**
 * FeeService - Version 1
 *
 * Service for managing fees in the College Management System.
 * This service handles fee business logic and data operations.
 *
 * @package App\Services\v1
 * @version 1.0.0
 * @author Softmax Technologies
 */
class FeeService
{

    /**
     * Get a paginated list of fees.
     *
     * @param Request $request
     * @return array
     */
    public function index(Request $request): array
    {
        $perPage = $request->query('per_page', config('app.pagination.per_page', 15));
        $page = $request->query('page', 1);
        $studentEnrollId = $request->query('student_enroll_id');
        $categoryId = $request->query('category_id');
        $status = $request->query('status');
        $paymentMethod = $request->query('payment_method');
        $assignDateFrom = $request->query('assign_date_from');
        $assignDateTo = $request->query('assign_date_to');
        $dueDateFrom = $request->query('due_date_from');
        $dueDateTo = $request->query('due_date_to');
        $feeAmountMin = $request->query('fee_amount_min');
        $feeAmountMax = $request->query('fee_amount_max');
        $search = $request->query('search');
        $sortBy = $request->query('sort_by', 'created_at');
        $sortOrder = $request->query('sort_order', 'desc');

        $query = Fee::with(['studentEnroll.student', 'category'])
            ->when($studentEnrollId, fn($q) => $q->where('student_enroll_id', $studentEnrollId))
            ->when($categoryId, fn($q) => $q->where('category_id', $categoryId))
            ->when($status, fn($q) => $q->where('status', $status))
            ->when($paymentMethod, fn($q) => $q->where('payment_method', $paymentMethod))
            ->when($assignDateFrom, fn($q) => $q->whereDate('assign_date', '>=', $assignDateFrom))
            ->when($assignDateTo, fn($q) => $q->whereDate('assign_date', '<=', $assignDateTo))
            ->when($dueDateFrom, fn($q) => $q->whereDate('due_date', '>=', $dueDateFrom))
            ->when($dueDateTo, fn($q) => $q->whereDate('due_date', '<=', $dueDateTo))
            ->when($feeAmountMin, fn($q) => $q->where('fee_amount', '>=', $feeAmountMin))
            ->when($feeAmountMax, fn($q) => $q->where('fee_amount', '<=', $feeAmountMax))
            ->when($search, fn($q) => $q->whereHas('studentEnroll.student', function ($subQuery) use ($search) {
                $subQuery->where('first_name', 'like', "%{$search}%")
                    ->orWhere('last_name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%")
                    ->orWhere('phone', 'like', "%{$search}%");
            }));

        $fees = $query->orderBy($sortBy, $sortOrder)->paginate($perPage, $page);

        return $fees;
    }

    /**
     * Create a new fee.
     *
     * @param array $data
     * @return Fee
     */
    public function store(array $data): Fee
    {
        return DB::transaction(function () use ($data) {
            $fee = Fee::create($data);

            Log::info('Fee created successfully', [
                'fee_id' => $fee->id,
                'student_enroll_id' => $fee->student_enroll_id
            ]);

            return $fee->load(['studentEnroll.student', 'category']);
        }, 5);
    }

    /**
     * Get a specific fee.
     *
     * @param int $id
     * @return Fee
     */
    public function show(int $id): Fee
    {
        return Fee::with(['studentEnroll.student', 'category'])->findOrFail($id);
    }

    /**
     * Update a fee.
     *
     * @param array $data
     * @param int $id
     * @return Fee
     */
    public function update(array $data, int $id): Fee
    {
        return DB::transaction(function () use ($data, $id) {
            $fee = Fee::findOrFail($id);
            $fee->update($data);

            Log::info('Fee updated successfully', [
                'fee_id' => $fee->id,
                'student_enroll_id' => $fee->student_enroll_id
            ]);

            return $fee->load(['studentEnroll.student', 'category']);
        }, 5);
    }

    /**
     * Delete a fee.
     *
     * @param int $id
     * @return bool
     */
    public function destroy(int $id): bool
    {
        return DB::transaction(function () use ($id) {
            $fee = Fee::findOrFail($id);
            $fee->delete();

            Log::info('Fee deleted successfully', [
                'fee_id' => $id
            ]);

            return true;
        }, 5);
    }

    /**
     * Get fees for a specific student.
     *
     * @param Request $request
     * @param int $studentId
     * @return array
     */
    public function getStudentFees(Request $request, int $studentId): array
    {
        $perPage = $request->query('per_page', config('app.pagination.per_page', 15));
        $page = $request->query('page', 1);
        $status = $request->query('status');
        $categoryId = $request->query('category_id');

        $query = Fee::with(['studentEnroll.student', 'category'])
            ->whereHas('studentEnroll', function ($q) use ($studentId) {
                $q->where('student_id', $studentId);
            })
            ->when($status, fn($q) => $q->where('status', $status))
            ->when($categoryId, fn($q) => $q->where('category_id', $categoryId));

        return $query->orderBy('created_at', 'desc')->paginate($perPage, $page);
    }

    /**
     * Pay a fee.
     *
     * @param Request $request
     * @param int $id
     * @return JsonResponse
     */
    public function payFee(Request $request, int $id): JsonResponse
    {
        try {
            DB::beginTransaction();

            $request->validate([
                'paid_amount' => 'required|numeric|min:0',
                'payment_method' => 'required|string',
                'note' => 'nullable|string',
            ]);

            $fee = Fee::findOrFail($id);

            if ($fee->status === 'paid') {
                return $this->error('Fee is already paid', 400);
            }

            $fee->update([
                'paid_amount' => $request->paid_amount,
                'payment_method' => $request->payment_method,
                'pay_date' => now(),
                'status' => $request->paid_amount >= $fee->fee_amount ? 'paid' : 'partial',
                'note' => $request->note,
            ]);

            DB::commit();

            Log::info('Fee payment processed', [
                'fee_id' => $fee->id,
                'paid_amount' => $request->paid_amount,
                'payment_method' => $request->payment_method
            ]);

            return $this->success(
                new FeeResource($fee->load(['studentEnroll.student', 'category'])),
                'Fee payment processed successfully'
            );
        } catch (Exception $e) {
            DB::rollBack();

            Log::error('Error processing fee payment', [
                'fee_id' => $id,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return $this->error('Failed to process fee payment', 500);
        }
    }

    /**
     * Get overdue fees.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function getOverdueFees(Request $request): JsonResponse
    {
        try {
            $query = Fee::with(['studentEnroll.student', 'category'])
                ->where('due_date', '<', now())
                ->where('status', 'unpaid');

            // Apply additional filters
            $query->when($request->filled('days_overdue'), function ($q) use ($request) {
                $daysOverdue = $request->days_overdue;
                $cutoffDate = now()->subDays($daysOverdue);
                $q->where('due_date', '<=', $cutoffDate);
            });

            $fees = $query->orderBy('due_date', 'asc')->paginate($request->get('per_page', 15));

            return $this->paginated(
                FeeResource::collection($fees),
                $fees,
                'Overdue fees retrieved successfully'
            );
        } catch (Exception $e) {
            Log::error('Error retrieving overdue fees', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return $this->error('Failed to retrieve overdue fees', 500);
        }
    }
}
