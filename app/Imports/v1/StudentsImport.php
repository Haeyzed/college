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
use App\Models\v1\Student;
use App\Models\v1\Batch;
use App\Models\v1\Program;

/**
 * StudentsImport - Version 1
 *
 * Import class for students data from Excel format.
 * This class handles the import of student data with validation.
 *
 * @package App\Imports\v1
 * @version 1.0.0
 * @author Softmax Technologies
 */
class StudentsImport implements ToModel, WithHeadingRow, WithValidation, WithBatchInserts, WithChunkReading
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

            return new Student([
                'student_id' => $row['student_id'] ?? $this->generateStudentId(),
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
                'admission_date' => $row['admission_date'] ?? now(),
                'status' => $row['status'] ?? 'active',
                'created_by' => auth()->id() ?? 1,
                'updated_by' => auth()->id() ?? 1,
            ]);
        } catch (Exception $e) {
            Log::error('Error importing student row', [
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
            'student_id' => 'nullable|string|max:255|unique:students,student_id',
            'batch' => 'required|string|exists:batches,name',
            'program' => 'required|string|exists:programs,name',
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'father_name' => 'nullable|string|max:255',
            'mother_name' => 'nullable|string|max:255',
            'email' => 'required|email|max:255|unique:students,email',
            'phone' => 'required|string|max:20|unique:students,phone',
            'gender' => 'nullable|in:male,female,other',
            'date_of_birth' => 'nullable|date',
            'country' => 'nullable|string|max:255',
            'present_address' => 'nullable|string',
            'permanent_address' => 'nullable|string',
            'admission_date' => 'nullable|date',
            'status' => 'nullable|in:active,inactive,graduated,suspended',
        ];
    }

    /**
     * Generate a unique student ID.
     *
     * @return string
     */
    protected function generateStudentId(): string
    {
        $year = now()->year;
        $count = Student::whereYear('created_at', $year)->count() + 1;
        return 'STU' . $year . str_pad($count, 4, '0', STR_PAD_LEFT);
    }
}
