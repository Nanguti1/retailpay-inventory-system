<?php

namespace Database\Seeders;

use App\Models\Branch;
use App\Models\Store;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $branchA = Branch::where('name', 'Branch A')->first();
        $branchB = Branch::where('name', 'Branch B')->first();
        $storeA1 = Store::where('name', 'Store A1')->first();
        $storeB1 = Store::where('name', 'Store B1')->first();
        $storeB2 = Store::where('name', 'Store B2')->first();

        User::create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'password' => Hash::make('password'),
            'role' => User::ROLE_ADMINISTRATOR,
            'branch_id' => null,
            'store_id' => null,
        ]);

        User::create([
            'name' => 'Branch Manager A',
            'email' => 'branch-a@example.com',
            'password' => Hash::make('password'),
            'role' => User::ROLE_BRANCH_MANAGER,
            'branch_id' => $branchA->id,
            'store_id' => null,
        ]);

        User::create([
            'name' => 'Branch Manager B',
            'email' => 'branch-b@example.com',
            'password' => Hash::make('password'),
            'role' => User::ROLE_BRANCH_MANAGER,
            'branch_id' => $branchB->id,
            'store_id' => null,
        ]);

        User::create([
            'name' => 'Store Manager A1',
            'email' => 'store-a1@example.com',
            'password' => Hash::make('password'),
            'role' => User::ROLE_STORE_MANAGER,
            'branch_id' => null,
            'store_id' => $storeA1->id,
        ]);

        User::create([
            'name' => 'Store Manager B1',
            'email' => 'store-b1@example.com',
            'password' => Hash::make('password'),
            'role' => User::ROLE_STORE_MANAGER,
            'branch_id' => null,
            'store_id' => $storeB1->id,
        ]);

        User::create([
            'name' => 'Store Manager B2',
            'email' => 'store-b2@example.com',
            'password' => Hash::make('password'),
            'role' => User::ROLE_STORE_MANAGER,
            'branch_id' => null,
            'store_id' => $storeB2->id,
        ]);
    }
}
