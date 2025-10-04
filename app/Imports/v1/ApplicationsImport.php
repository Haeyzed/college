<?php

namespace App\Imports\v1;

use Exception;
use Illuminate\Database\Eloquent\Model;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Illuminate\Support\Facades\Log;
use App\Models\v1\Application;
use App\Models\v1\Batch;
use App\Models\v1\Program;

/**
 * ApplicationsImport - Version 1
 *
 * Import class for applications data from Excel format.
 * This class handles the import of application data with validation.
 *
 * @package App\Imports\v1
 * @version 1.0.0
 * @author Softmax Technologies
 */
class ApplicationsImport implements ToModel, WithHeadingRow, WithValidation, WithBatchInserts, WithChunkReading
{
    /**
     * The batch size for processing.
     *
     * @var int
     */
    public function batchSize(): int
    {
        return 100;
    }

    /**
     * The chunk size for reading.
     *
     * @var int
     */
    public function chunkSize(): int
    {
        return 100;
    }

    /**
     * Create a model instance for each row.
     *
     * @param array $row
     * @return Model|null
     */
    public function model(array $row)
    {
        try {
            // Find batch by name
            $batch = Batch::where('name', $row['batch'])->first();
            if (!$batch) {
                Log::warning("Batch not found: {$row['batch']}");
                return null;
            }

            // Find program by name
            $program = Program::where('name', $row['program'])->first();
            if (!$program) {
                Log::warning("Program not found: {$row['program']}");
                return null;
            }

            return new Application([
                'registration_no' => $row['registration_no'] ?? $this->generateRegistrationNo(),
                'batch_id' => $batch->id,
                'program_id' => $program->id,
                'first_name' => $row['first_name'],
                'last_name' => $row['last_name'],
                'father_name' => $row['father_name'] ?? null,
                'mother_name' => $row['mother_name'] ?? null,
                'email' => $row['email'],
                'phone' => $row['phone'],
                'gender' => $row['gender'] ?? 'male',
                'dob' => $row['date_of_birth'] ?? null,
                'country' => $row['country'] ?? 'Bangladesh',
                'present_address' => $row['present_address'] ?? null,
                'permanent_address' => $row['permanent_address'] ?? null,
                'apply_date' => $row['apply_date'] ?? now(),
                'fee_amount' => $row['fee_amount'] ?? 0,
                'pay_status' => $row['payment_status'] ?? 'unpaid',
                'status' => $row['status'] ?? 'pending',
                'created_by' => auth()->id() ?? 1,
                'updated_by' => auth()->id() ?? 1,
            ]);
        } catch (Exception $e) {
            Log::error('Error importing application row', [
                'row' => $row,
                'error' => $e->getMessage()
            ]);
            return null;
        }
    }

    /**
     * Get the validation rules.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'registration_no' => 'nullable|string|max:255',
            'batch' => 'required|string|exists:batches,name',
            'program' => 'required|string|exists:programs,name',
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'father_name' => 'nullable|string|max:255',
            'mother_name' => 'nullable|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:20',
            'gender' => 'nullable|in:male,female,other',
            'date_of_birth' => 'nullable|date',
            'country' => 'nullable|string|max:255',
            'present_address' => 'nullable|string',
            'permanent_address' => 'nullable|string',
            'apply_date' => 'nullable|date',
            'fee_amount' => 'nullable|numeric|min:0',
            'payment_status' => 'nullable|in:paid,unpaid,partial',
            'status' => 'nullable|in:pending,approved,rejected',
        ];
    }

    /**
     * Generate a unique registration number.
     *
     * @return string
     */
    protected function generateRegistrationNo(): string
    {
        $year = now()->year;
        $count = Application::whereYear('created_at', $year)->count() + 1;
        return 'APP' . $year . str_pad($count, 4, '0', STR_PAD_LEFT);
    }
}
