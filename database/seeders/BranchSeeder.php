<?php

namespace Database\Seeders;

use App\Models\Branch;
use Illuminate\Database\Seeder;

class BranchSeeder extends Seeder
{
    public function run(): void
    {
        Branch::create(['name' => 'Branch A']);
        Branch::create(['name' => 'Branch B']);
    }
}
