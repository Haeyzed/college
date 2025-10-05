<?php

namespace App\Http\Controllers\v1;

use App\Http\Controllers\Controller;
use App\Services\v1\FeeService;
use App\Http\Requests\v1\StoreFeeRequest;
use App\Http\Requests\v1\UpdateFeeRequest;
use App\Http\Resources\v1\FeeResource;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

/**
 * FeeController - Version 1
 *
 * Controller for managing fees in the College Management System.
 * This controller handles fee-related API endpoints.
 *
 * @package App\Http\Controllers\v1
 * @version 1.0.0
 * @author Softmax Technologies
 */
class FeeController extends Controller
{

    /**
     * The fee service instance.
     *
     * @var FeeService
     */
    protected FeeService $feeService;

    /**
     * Create a new controller instance.
     *
     * @param FeeService $feeService
     */
    public function __construct(FeeService $feeService)
    {
        $this->feeService = $feeService;
    }

    /**
     * Display a listing of fees.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function index(Request $request): JsonResponse
    {
        try {
            $result = $this->feeService->index($request);
            return response()->paginated(
                FeeResource::collection($result),
                'Fees retrieved successfully'
            );
        } catch (Exception $e) {
            return response()->internalServerError('Failed to retrieve fees: ' . $e->getMessage(), $e->getMessage());
        }
    }

    /**
     * Store a newly created fee.
     *
     * @param StoreFeeRequest $request
     * @return JsonResponse
     */
    public function store(StoreFeeRequest $request): JsonResponse
    {
        try {
            $result = $this->feeService->store($request->validated());
            return response()->created(
                new FeeResource($result),
                'Fee created successfully'
            );
        } catch (Exception $e) {
            return response()->error('Failed to create fee: ' . $e->getMessage(), null, 400);
        }
    }

    /**
     * Display the specified fee.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function show(int $id): JsonResponse
    {
        try {
            $result = $this->feeService->show($id);
            return response()->success(
                new FeeResource($result),
                'Fee retrieved successfully'
            );
        } catch (Exception $e) {
            return response()->notFound('Fee not found');
        }
    }

    /**
     * Update the specified fee.
     *
     * @param UpdateFeeRequest $request
     * @param int $id
     * @return JsonResponse
     */
    public function update(UpdateFeeRequest $request, int $id): JsonResponse
    {
        try {
            $result = $this->feeService->update($request->validated(), $id);
            return response()->success(
                new FeeResource($result),
                'Fee updated successfully'
            );
        } catch (Exception $e) {
            return response()->error('Failed to update fee: ' . $e->getMessage(), null, 400);
        }
    }

    /**
     * Remove the specified fee.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function destroy(int $id): JsonResponse
    {
        try {
            $this->feeService->destroy($id);
            return response()->success([], 'Fee deleted successfully');
        } catch (Exception $e) {
            return response()->error('Failed to delete fee: ' . $e->getMessage(), null, 400);
        }
    }

    /**
     * Get fees for a specific student.
     *
     * @param Request $request
     * @param int $studentId
     * @return JsonResponse
     */
    public function getStudentFees(Request $request, int $studentId): JsonResponse
    {
        try {
            return $this->feeService->getStudentFees($request, $studentId);
        } catch (Exception $e) {
            return $this->error('Failed to retrieve student fees: ' . $e->getMessage(), 500);
        }
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
            return $this->feeService->payFee($request, $id);
        } catch (Exception $e) {
            return $this->error('Failed to pay fee: ' . $e->getMessage(), 400);
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
            return $this->feeService->getOverdueFees($request);
        } catch (Exception $e) {
            return $this->error('Failed to retrieve overdue fees: ' . $e->getMessage(), 500);
        }
    }
}
