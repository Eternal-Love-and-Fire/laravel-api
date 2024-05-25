<?php

namespace Database\Seeders;

use App\Models\Position;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $positions = ['Security', 'Designer', 'Content Manager', 'Lawyer'];

        foreach ($positions as $position) {
            Position::factory(['name' => $position])->create();
        }

        \App\Models\User::factory(20)->create();
    }
}
