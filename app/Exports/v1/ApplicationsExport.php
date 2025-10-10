<?php

namespace App\Exports\v1;

use App\Models\v1\Application;
use Illuminate\Database\Eloquent\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

/**
 * ApplicationsExport - Version 1
 *
 * Export class for applications data to Excel format.
 * This class handles the export of application data with proper formatting.
 *
 * @package App\Exports\v1
 * @version 1.0.0
 * @author Softmax Technologies
 */
class ApplicationsExport implements FromCollection, WithHeadings, WithMapping, WithStyles, WithColumnWidths
{
    /**
     * The applications collection.
     *
     * @var Collection
     */
    protected $applications;

    /**
     * Create a new export instance.
     *
     * @param Collection $applications
     */
    public function __construct($applications = null)
    {
        $this->applications = $applications ?? Application::with(['batch', 'program'])->get();
    }

    /**
     * Get the collection to export.
     *
     * @return Collection
     */
    public function collection()
    {
        return $this->applications;
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
            'Registration No',
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
            'Apply Date',
            'Fee Amount',
            'Payment Status',
            'Status',
            'Created At'
        ];
    }

    /**
     * Map the data for each row.
     *
     * @param Application $application
     * @return array
     */
    public function map($application): array
    {
        return [
            $application->id,
            $application->registration_no,
            $application->batch->name ?? 'N/A',
            $application->program->name ?? 'N/A',
            $application->first_name,
            $application->last_name,
            $application->father_name,
            $application->mother_name,
            $application->email,
            $application->phone,
            $application->gender,
            $application->dob ? $application->dob->format('Y-m-d') : 'N/A',
            $application->country,
            $application->present_address,
            $application->permanent_address,
            $application->apply_date ? $application->apply_date->format('Y-m-d') : 'N/A',
            $application->fee_amount,
            $application->pay_status,
            $application->status,
            $application->created_at->format('Y-m-d H:i:s')
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
            'B' => 15,  // Registration No
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
            'P' => 12,  // Apply Date
            'Q' => 12,  // Fee Amount
            'R' => 15,  // Payment Status
            'S' => 12,  // Status
            'T' => 20,  // Created At
        ];
    }
}
