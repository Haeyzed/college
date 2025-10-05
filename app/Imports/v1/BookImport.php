<?php

namespace App\Imports\v1;

use App\Models\v1\Book;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

/**
 * BookImport - Version 1
 *
 * Handles importing books from Excel files.
 * Follows the same pattern as UniversitySystem BooksImport.
 *
 * @version 1.0.0
 *
 * @author Softmax Technologies
 */
class BookImport implements ToCollection, WithHeadingRow
{
    protected $data;

    protected int $rowCount = 0;

    /**
     * @return void
     */
    public function __construct($data)
    {
        $this->data = $data;
    }

    /**
     * @return void
     */
    public function collection(Collection $rows): void
    {
        $this->rowCount = $rows->count();

        Validator::make($rows->toArray(), [
            '*.title' => 'required|max:255',
            '*.isbn' => 'nullable|max:30|unique:books,isbn',
            '*.accession_number' => 'nullable|max:50|unique:books,accession_number',
            '*.author' => 'required|max:255',
            '*.publication_year' => 'nullable|integer|max:' . date('Y'),
            '*.price' => 'nullable|numeric|min:0',
            '*.quantity' => 'required|integer|min:0',
        ])->validate();

        foreach ($rows as $row) {
            Book::query()->updateOrCreate(
                [
                    'isbn' => $row['isbn'],
                    'accession_number' => $row['accession_number'] ?? null,
                ],
                [
                    'book_category_id' => $this->data['category'],
                    'title' => $row['title'],
                    'isbn' => $row['isbn'] ?? null,
                    'accession_number' => $row['accession_number'] ?? null,
                    'author' => $row['author'],
                    'publisher' => $row['publisher'] ?? null,
                    'edition' => $row['edition'] ?? null,
                    'publication_year' => $row['publication_year'] ?? null,
                    'language' => $row['language'] ?? null,
                    'price' => $row['price'] ?? null,
                    'quantity' => $row['quantity'],
                    'shelf_location' => $row['shelf_location'] ?? null,
                    'shelf_column' => $row['shelf_column'] ?? null,
                    'shelf_row' => $row['shelf_row'] ?? null,
                    'description' => $row['description'] ?? null,
                    'note' => $row['note'] ?? null,
                ]
            );
        }
    }

    /**
     * Get the number of rows processed.
     */
    public function getRowCount(): int
    {
        return $this->rowCount;
    }
}
