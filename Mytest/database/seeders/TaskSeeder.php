<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Task;

class TaskSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Task::factory()->count(5)->completed()->create();
        Task::factory()->count(5)->pending()->create();
        Task::factory()->count(5)->inProgress()->create();
        Task::factory()->count(5)->missing()->create();
    }
}
