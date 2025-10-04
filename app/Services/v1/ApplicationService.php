<?php

namespace App\Services\v1;

use App\Models\v1\Application;
use App\Models\v1\Batch;
use App\Models\v1\Program;
use App\Models\v1\Province;
use App\Models\v1\District;
use App\Http\Resources\v1\ApplicationResource;
use Exception;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Throwable;

/**
 * Application Service - Version 1
 *
 * This service handles all application-related operations including creation,
 * management, and processing in the College Management System.
 *
 * @package App\Services\v1
 * @version 1.0.0
 * @author Softmax Technologies
 */
class ApplicationService
{

    /**
     * Get a paginated list of applications.
     *
     * @param Request $request
     * @return array
     */
    public function index(Request $request): array
    {
        $perPage = $request->query('per_page', config('app.pagination.per_page', 15));
        $page = $request->query('page', 1);
        $status = $request->query('status');
        $batchId = $request->query('batch_id');
        $programId = $request->query('program_id');
        $payStatus = $request->query('pay_status');
        $gender = $request->query('gender');
        $country = $request->query('country');
        $dateFrom = $request->query('apply_date_from');
        $dateTo = $request->query('apply_date_to');
        $search = $request->query('search');
        $sortBy = $request->query('sort_by', 'created_at');
        $sortOrder = $request->query('sort_order', 'desc');

        $query = Application::with([
            'batch', 'program.faculty', 'presentProvince', 'presentDistrict', 'permanentProvince', 'permanentDistrict'
        ])
            ->when($status, fn($q) => $q->where('status', $status))
            ->when($batchId, fn($q) => $q->where('batch_id', $batchId))
            ->when($programId, fn($q) => $q->where('program_id', $programId))
            ->when($payStatus, fn($q) => $q->where('pay_status', $payStatus))
            ->when($gender, fn($q) => $q->where('gender', $gender))
            ->when($country, fn($q) => $q->where('country', $country))
            ->when($dateFrom, fn($q) => $q->whereDate('apply_date', '>=', $dateFrom))
            ->when($dateTo, fn($q) => $q->whereDate('apply_date', '<=', $dateTo))
            ->when($search, fn($q) => $q->where(function ($subQuery) use ($search) {
                $subQuery->where('first_name', 'like', "%{$search}%")
                    ->orWhere('last_name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%")
                    ->orWhere('phone', 'like', "%{$search}%")
                    ->orWhere('registration_no', 'like', "%{$search}%");
            }));

        $applications = $query->orderBy($sortBy, $sortOrder)->paginate($perPage, $page);

        return $applications;
    }

    /**
     * Store a newly created application.
     *
     * @param array $data
     * @return Application
     */
    public function store(array $data): Application
    {
        return DB::transaction(function () use ($data) {
            // Generate registration number if not provided
            if (empty($data['registration_no'])) {
                $data['registration_no'] = $this->generateRegistrationNumber();
            }

            // Validate foreign key relationships
            $this->validateRelationships($data);

            // Create the application
            $application = Application::create($data);

            return $application->load([
                'batch', 'program.faculty', 'presentProvince', 'presentDistrict', 'permanentProvince', 'permanentDistrict'
            ]);
        }, 5);
    }

    /**
     * Get a specific application.
     *
     * @param int $id
     * @return Application
     */
    public function show(int $id): Application
    {
        return Application::with([
            'batch', 'program.faculty', 'presentProvince', 'presentDistrict', 'permanentProvince', 'permanentDistrict'
        ])->findOrFail($id);
    }

    /**
     * Update an application.
     *
     * @param array $data
     * @param int $id
     * @return Application
     */
    public function update(array $data, int $id): Application
    {
        return DB::transaction(function () use ($data, $id) {
            $application = Application::findOrFail($id);

            // Validate foreign key relationships if they are being updated
            if (isset($data['batch_id']) || isset($data['program_id'])) {
                $this->validateRelationships($data);
            }

            $application->update($data);

            return $application->load([
                'batch', 'program.faculty', 'presentProvince', 'presentDistrict', 'permanentProvince', 'permanentDistrict'
            ]);
        }, 5);
    }

    /**
     * Delete an application.
     *
     * @param int $id
     * @return bool
     */
    public function destroy(int $id): bool
    {
        return DB::transaction(function () use ($id) {
            $application = Application::findOrFail($id);
            $application->delete();
            return true;
        }, 5);
    }


    /**
     * Update an existing application.
     *
     * @param int $id
     * @param array $data
     * @return Application
     * @throws Exception
     */
    public function updateApplication(int $id, array $data): Application
    {
        try {
            return DB::transaction(function () use ($id, $data) {
                $application = Application::findOrFail($id);

                // Validate foreign key relationships if provided
                if (isset($data['batch_id']) || isset($data['program_id']) ||
                    isset($data['present_province']) || isset($data['present_district']) ||
                    isset($data['permanent_province']) || isset($data['permanent_district'])) {
                    $this->validateRelationships($data);
                }

                // Update the application
                $application->update($data);

                return $application->fresh();
            });
        } catch (Throwable $th) {
            throw new Exception('Failed to update application: ' . $th->getMessage());
        }
    }

    /**
     * Get application by ID with relationships.
     *
     * @param int $id
     * @return Application
     * @throws Exception
     */
    public function getApplication(int $id): Application
    {
        try {
            return Application::with([
                'batch',
                'program.faculty',
                'presentProvince',
                'presentDistrict',
                'permanentProvince',
                'permanentDistrict'
            ])->findOrFail($id);
        } catch (Throwable $th) {
            throw new Exception('Application not found');
        }
    }

    /**
     * Get paginated applications with filters.
     *
     * @param Request $request
     * @return LengthAwarePaginator
     */
    public function getApplications(Request $request)
    {
        $query = Application::with([
            'batch',
            'program.faculty',
            'presentProvince',
            'presentDistrict'
        ]);

        // Apply filters
        if ($request->filled('status')) {
            $query->filterByStatus($request->status);
        }

        if ($request->filled('pay_status')) {
            $query->filterByPaymentStatus($request->pay_status);
        }

        if ($request->filled('program_id')) {
            $query->filterByProgram($request->program_id);
        }

        if ($request->filled('batch_id')) {
            $query->filterByBatch($request->batch_id);
        }

        if ($request->filled('search')) {
            $query->search($request->search);
        }

        // Apply date filters
        if ($request->filled('from_date')) {
            $query->where('apply_date', '>=', $request->from_date);
        }

        if ($request->filled('to_date')) {
            $query->where('apply_date', '<=', $request->to_date);
        }

        // Apply sorting
        $sortBy = $request->get('sort_by', 'created_at');
        $sortOrder = $request->get('sort_order', 'desc');
        $query->orderBy($sortBy, $sortOrder);

        // Paginate results
        $perPage = $request->get('per_page', 15);
        return $query->paginate($perPage);
    }

    /**
     * Delete an application.
     *
     * @param int $id
     * @return bool
     * @throws Exception
     */
    public function deleteApplication(int $id): bool
    {
        try {
            return DB::transaction(function () use ($id) {
                $application = Application::findOrFail($id);

                // Check if application can be deleted
                if ($application->status == 2) { // Approved
                    throw new Exception('Cannot delete approved application');
                }

                return $application->delete();
            });
        } catch (Throwable $th) {
            throw new Exception('Failed to delete application: ' . $th->getMessage());
        }
    }

    /**
     * Approve an application.
     *
     * @param int $id
     * @param array $data
     * @return Application
     * @throws Exception
     */
    public function approveApplication(int $id, array $data = []): Application
    {
        try {
            return DB::transaction(function () use ($id, $data) {
                $application = Application::findOrFail($id);

                if ($application->status == 2) {
                    throw new Exception('Application is already approved');
                }

                // Update application status
                $updateData = array_merge($data, [
                    'status' => 2, // Approved
                    'updated_by' => auth()->id() ?? 1,
                ]);

                $application->update($updateData);

                return $application->fresh();
            });
        } catch (Throwable $th) {
            throw new Exception('Failed to approve application: ' . $th->getMessage());
        }
    }

    /**
     * Reject an application.
     *
     * @param int $id
     * @param string $reason
     * @return Application
     * @throws Exception
     */
    public function rejectApplication(int $id, string $reason = ''): Application
    {
        try {
            return DB::transaction(function () use ($id, $reason) {
                $application = Application::findOrFail($id);

                if ($application->status == 0) {
                    throw new Exception('Application is already rejected');
                }

                // Update application status
                $application->update([
                    'status' => 0, // Rejected
                    'updated_by' => auth()->id() ?? 1,
                ]);

                return $application->fresh();
            });
        } catch (Throwable $th) {
            throw new Exception('Failed to reject application: ' . $th->getMessage());
        }
    }

    /**
     * Get application statistics.
     *
     * @return array
     */
    public function getApplicationStatistics(): array
    {
        try {
            $total = Application::count();
            $pending = Application::filterByStatus(1)->count();
            $approved = Application::filterByStatus(2)->count();
            $rejected = Application::filterByStatus(0)->count();

            $paid = Application::filterByPaymentStatus(1)->count();
            $unpaid = Application::filterByPaymentStatus(0)->count();

            $thisMonth = Application::whereMonth('created_at', now()->month)
                ->whereYear('created_at', now()->year)
                ->count();

            return [
                'total' => $total,
                'pending' => $pending,
                'approved' => $approved,
                'rejected' => $rejected,
                'paid' => $paid,
                'unpaid' => $unpaid,
                'this_month' => $thisMonth,
                'approval_rate' => $total > 0 ? round(($approved / $total) * 100, 2) : 0,
                'payment_rate' => $total > 0 ? round(($paid / $total) * 100, 2) : 0,
            ];
        } catch (Throwable $th) {
            throw new Exception('Failed to get application statistics: ' . $th->getMessage());
        }
    }

    /**
     * Generate a unique registration number.
     *
     * @return string
     */
    private function generateRegistrationNumber(): string
    {
        $year = now()->year;
        $prefix = 'APP' . $year;

        // Get the last registration number for this year
        $lastApplication = Application::where('registration_no', 'like', $prefix . '%')
            ->orderBy('registration_no', 'desc')
            ->first();

        if ($lastApplication) {
            // Extract the numeric part and increment
            $lastNumber = (int)substr($lastApplication->registration_no, -4);
            $newNumber = str_pad($lastNumber + 1, 4, '0', STR_PAD_LEFT);
        } else {
            $newNumber = '0001';
        }

        return $prefix . $newNumber;
    }

    /**
     * Validate foreign key relationships.
     *
     * @param array $data
     * @throws Exception
     */
    private function validateRelationships(array $data): void
    {
        // Validate batch
        if (isset($data['batch_id']) && $data['batch_id']) {
            if (!Batch::where('id', $data['batch_id'])->where('status', true)->exists()) {
                throw new Exception('Invalid or inactive batch selected');
            }
        }

        // Validate program
        if (isset($data['program_id']) && $data['program_id']) {
            if (!Program::where('id', $data['program_id'])->where('status', true)->exists()) {
                throw new Exception('Invalid or inactive program selected');
            }
        }

        // Validate present province
        if (isset($data['present_province']) && $data['present_province']) {
            if (!Province::where('id', $data['present_province'])->where('status', true)->exists()) {
                throw new Exception('Invalid present province selected');
            }
        }

        // Validate present district
        if (isset($data['present_district']) && $data['present_district']) {
            if (!District::where('id', $data['present_district'])->where('status', true)->exists()) {
                throw new Exception('Invalid present district selected');
            }
        }

        // Validate permanent province
        if (isset($data['permanent_province']) && $data['permanent_province']) {
            if (!Province::where('id', $data['permanent_province'])->where('status', true)->exists()) {
                throw new Exception('Invalid permanent province selected');
            }
        }

        // Validate permanent district
        if (isset($data['permanent_district']) && $data['permanent_district']) {
            if (!District::where('id', $data['permanent_district'])->where('status', true)->exists()) {
                throw new Exception('Invalid permanent district selected');
            }
        }
    }
}
