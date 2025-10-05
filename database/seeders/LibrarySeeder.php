<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

/**
 * LibrarySeeder - Version 1
 *
 * Master seeder that runs all library-related seeders in the correct order.
 * This seeder ensures proper foreign key relationships are maintained.
 *
 * @package Database\Seeders
 * @version 1.0.0
 * @author Softmax Technologies
 */
class LibrarySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->command->info('Starting Library System Seeding...');

        // Seed book categories first (required for foreign keys)
        $this->command->info('Seeding Book Categories...');
        $this->call(BookCategorySeeder::class);

        // Seed books (depends on book categories)
        $this->command->info('Seeding Books...');
        $this->call(BookSeeder::class);

        // Seed book requests (depends on book categories)
        $this->command->info('Seeding Book Requests...');
        $this->call(BookRequestSeeder::class);

        $this->command->info('Library System Seeding Completed Successfully!');
    }
}
