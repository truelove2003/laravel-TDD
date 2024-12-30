<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Task; // Import model Task

class TaskSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Task::factory(10)->create(); // Tạo 10 Task mẫu
    }
}
