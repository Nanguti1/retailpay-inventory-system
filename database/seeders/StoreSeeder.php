<?php

namespace Database\Seeders;

use App\Models\Branch;
use App\Models\Store;
use Illuminate\Database\Seeder;

class StoreSeeder extends Seeder
{
    public function run(): void
    {
        $branchA = Branch::where('name', 'Branch A')->first();
        $branchB = Branch::where('name', 'Branch B')->first();

        Store::create(['branch_id' => $branchA->id, 'name' => 'Store A1']);
        Store::create(['branch_id' => $branchB->id, 'name' => 'Store B1']);
        Store::create(['branch_id' => $branchB->id, 'name' => 'Store B2']);
    }
}
