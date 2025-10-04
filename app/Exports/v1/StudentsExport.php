<?php

namespace App\Exports\v1;

use Illuminate\Database\Eloquent\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use App\Models\v1\Student;

/**
 * StudentsExport - Version 1
 *
 * Export class for students data to Excel format.
 * This class handles the export of student data with proper formatting.
 *
 * @package App\Exports\v1
 * @version 1.0.0
 * @author Softmax Technologies
 */
class StudentsExport implements FromCollection, WithHeadings, WithMapping, WithStyles, WithColumnWidths
{
    /**
     * The students collection.
     *
     * @var Collection
     */
    protected $students;

    /**
     * Create a new export instance.
     *
     * @param Collection $students
     */
    public function __construct($students = null)
    {
        $this->students = $students ?? Student::with(['batch', 'program'])->get();
    }

    /**
     * Get the collection to export.
     *
     * @return Collection
     */
    public function collection()
    {
        return $this->students;
    }

    /**
     * Get the headings for the export.
     *
     * @return array
     */
    public function headings(): array
    {
        return [
            'ID',
            'Student ID',
            'Batch',
            'Program',
            'First Name',
            'Last Name',
            'Father Name',
            'Mother Name',
            'Email',
            'Phone',
            'Gender',
            'Date of Birth',
            'Country',
            'Present Address',
            'Permanent Address',
            'Admission Date',
            'Status',
            'Created At'
        ];
    }

    /**
     * Map the data for each row.
     *
     * @param Student $student
     * @return array
     */
    public function map($student): array
    {
        return [
            $student->id,
            $student->student_id,
            $student->batch->name ?? 'N/A',
            $student->program->name ?? 'N/A',
            $student->first_name,
            $student->last_name,
            $student->father_name,
            $student->mother_name,
            $student->email,
            $student->phone,
            $student->gender,
            $student->dob ? $student->dob->format('Y-m-d') : 'N/A',
            $student->country,
            $student->present_address,
            $student->permanent_address,
            $student->admission_date ? $student->admission_date->format('Y-m-d') : 'N/A',
            $student->status,
            $student->created_at->format('Y-m-d H:i:s')
        ];
    }

    /**
     * Apply styles to the worksheet.
     *
     * @param Worksheet $sheet
     * @return array
     */
    public function styles(Worksheet $sheet)
    {
        return [
            1 => [
                'font' => [
                    'bold' => true,
                    'color' => ['rgb' => 'FFFFFF']
                ],
                'fill' => [
                    'fillType' => Fill::FILL_SOLID,
                    'startColor' => ['rgb' => '366092']
                ]
            ]
        ];
    }

    /**
     * Set column widths.
     *
     * @return array
     */
    public function columnWidths(): array
    {
        return [
            'A' => 8,   // ID
            'B' => 15,  // Student ID
            'C' => 15,  // Batch
            'D' => 20,  // Program
            'E' => 15,  // First Name
            'F' => 15,  // Last Name
            'G' => 15,  // Father Name
            'H' => 15,  // Mother Name
            'I' => 25,  // Email
            'J' => 15,  // Phone
            'K' => 10,  // Gender
            'L' => 12,  // Date of Birth
            'M' => 15,  // Country
            'N' => 30,  // Present Address
            'O' => 30,  // Permanent Address
            'P' => 15,  // Admission Date
            'Q' => 12,  // Status
            'R' => 20,  // Created At
        ];
    }
}
