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

    protected $rowCount = 0;

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
    public function collection(Collection $rows)
    {
        $this->rowCount = $rows->count();

        Validator::make($rows->toArray(), [
            '*.title' => 'required|max:255',
            '*.isbn' => 'required|max:30|unique:books,isbn',
            '*.price' => 'nullable|numeric',
            '*.quantity' => 'required|numeric',
        ])->validate();

        foreach ($rows as $row) {
            Book::updateOrCreate(
                [
                    'isbn' => $row['isbn'],
                ],
                [
                    'category_id' => $this->data['category'],
                    'title' => $row['title'],
                    'isbn' => $row['isbn'],
                    'code' => $row['code'] ?? null,
                    'author' => $row['author'],
                    'publisher' => $row['publisher'] ?? null,
                    'edition' => $row['edition'] ?? null,
                    'publish_year' => $row['publish_year'] ?? null,
                    'language' => $row['language'] ?? null,
                    'price' => $row['price'] ?? null,
                    'quantity' => $row['quantity'],
                    'section' => $row['section'] ?? null,
                    'column' => $row['column'] ?? null,
                    'row' => $row['row'] ?? null,
                    'description' => $row['description'] ?? null,
                    'note' => $row['note'] ?? null,
                    // 'created_by' => Auth::guard('api')->id() ?? 1,
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
