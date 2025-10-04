<?php

namespace App\Http\Controllers\v1;

use App\Http\Controllers\Controller;
use App\Services\v1\UtilityService;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

/**
 * UtilityController - Version 1
 *
 * Controller for providing utility endpoints in the College Management System.
 * This controller handles enum fetching and other utility operations.
 *
 * @package App\Http\Controllers\v1
 * @version 1.0.0
 * @author Softmax Technologies
 */
class UtilityController extends Controller
{
    /**
     * The utility service instance.
     *
     * @var UtilityService
     */
    protected UtilityService $utilityService;

    /**
     * Create a new controller instance.
     *
     * @param UtilityService $utilityService
     */
    public function __construct(UtilityService $utilityService)
    {
        $this->utilityService = $utilityService;
    }

    /**
     * Get book status enum.
     *
     * @return JsonResponse
     * @response array{success: bool, message: string, data: array}
     */
    public function getBookStatusEnum(): JsonResponse
    {
        try {
            $enum = $this->utilityService->getBookStatusEnum();

            return response()->success(
                $enum,
                'Book status enum retrieved successfully'
            );
        } catch (Exception $e) {
            return response()->internalServerError(
                'Failed to retrieve book status enum: ' . $e->getMessage()
            );
        }
    }

    /**
     * Get book category status enum.
     *
     * @return JsonResponse
     * @response array{success: bool, message: string, data: array}
     */
    public function getBookCategoryStatusEnum(): JsonResponse
    {
        try {
            $enum = $this->utilityService->getBookCategoryStatusEnum();

            return response()->success(
                $enum,
                'Book category status enum retrieved successfully'
            );
        } catch (Exception $e) {
            return response()->internalServerError(
                'Failed to retrieve book category status enum: ' . $e->getMessage()
            );
        }
    }

    /**
     * Get book request status enum.
     *
     * @return JsonResponse
     * @response array{success: bool, message: string, data: array}
     */
    public function getBookRequestStatusEnum(): JsonResponse
    {
        try {
            $enum = $this->utilityService->getBookRequestStatusEnum();

            return response()->success(
                $enum,
                'Book request status enum retrieved successfully'
            );
        } catch (Exception $e) {
            return response()->internalServerError(
                'Failed to retrieve book request status enum: ' . $e->getMessage()
            );
        }
    }

    /**
     * Get member type enum.
     *
     * @return JsonResponse
     * @response array{success: bool, message: string, data: array}
     */
    public function getMemberTypeEnum(): JsonResponse
    {
        try {
            $enum = $this->utilityService->getMemberTypeEnum();

            return response()->success(
                $enum,
                'Member type enum retrieved successfully'
            );
        } catch (Exception $e) {
            return response()->internalServerError(
                'Failed to retrieve member type enum: ' . $e->getMessage()
            );
        }
    }

    /**
     * Get issue status enum.
     *
     * @return JsonResponse
     * @response array{success: bool, message: string, data: array}
     */
    public function getIssueStatusEnum(): JsonResponse
    {
        try {
            $enum = $this->utilityService->getIssueStatusEnum();

            return response()->success(
                $enum,
                'Issue status enum retrieved successfully'
            );
        } catch (Exception $e) {
            return response()->internalServerError(
                'Failed to retrieve issue status enum: ' . $e->getMessage()
            );
        }
    }

    /**
     * Get status enum.
     *
     * @return JsonResponse
     * @response array{success: bool, message: string, data: array}
     */
    public function getStatusEnum(): JsonResponse
    {
        try {
            $enum = $this->utilityService->getStatusEnum();

            return response()->success(
                $enum,
                'Status enum retrieved successfully'
            );
        } catch (Exception $e) {
            return response()->internalServerError(
                'Failed to retrieve status enum: ' . $e->getMessage()
            );
        }
    }

    /**
     * Get database statistics.
     *
     * @return JsonResponse
     * @response array{success: bool, message: string, data: array}
     */
    public function getDatabaseStats(): JsonResponse
    {
        try {
            $stats = $this->utilityService->getDatabaseStats();

            return response()->success(
                $stats,
                'Database statistics retrieved successfully'
            );
        } catch (Exception $e) {
            return response()->internalServerError(
                'Failed to retrieve database statistics: ' . $e->getMessage()
            );
        }
    }

    /**
     * Get system information.
     *
     * @return JsonResponse
     * @response array{success: bool, message: string, data: array}
     */
    public function getSystemInfo(): JsonResponse
    {
        try {
            $info = $this->utilityService->getSystemInfo();

            return response()->success(
                $info,
                'System information retrieved successfully'
            );
        } catch (Exception $e) {
            return response()->internalServerError(
                'Failed to retrieve system information: ' . $e->getMessage()
            );
        }
    }

    /**
     * Get gender enum.
     *
     * @return JsonResponse
     * @response array{success: bool, message: string, data: array}
     */
    public function getGenderEnum(): JsonResponse
    {
        try {
            $enum = $this->utilityService->getGenderEnum();

            return response()->success(
                $enum,
                'Gender enum retrieved successfully'
            );
        } catch (Exception $e) {
            return response()->internalServerError(
                'Failed to retrieve gender enum: ' . $e->getMessage()
            );
        }
    }

    /**
     * Get marital status enum.
     *
     * @return JsonResponse
     * @response array{success: bool, message: string, data: array}
     */
    public function getMaritalStatusEnum(): JsonResponse
    {
        try {
            $enum = $this->utilityService->getMaritalStatusEnum();

            return response()->success(
                $enum,
                'Marital status enum retrieved successfully'
            );
        } catch (Exception $e) {
            return response()->internalServerError(
                'Failed to retrieve marital status enum: ' . $e->getMessage()
            );
        }
    }

    /**
     * Get blood group enum.
     *
     * @return JsonResponse
     * @response array{success: bool, message: string, data: array}
     */
    public function getBloodGroupEnum(): JsonResponse
    {
        try {
            $enum = $this->utilityService->getBloodGroupEnum();

            return response()->success(
                $enum,
                'Blood group enum retrieved successfully'
            );
        } catch (Exception $e) {
            return response()->internalServerError(
                'Failed to retrieve blood group enum: ' . $e->getMessage()
            );
        }
    }
}
