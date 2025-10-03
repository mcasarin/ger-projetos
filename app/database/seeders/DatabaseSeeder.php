<?php

namespace Database\Seeders;


use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\JsonSchema\Types\Type;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            UserSeeder::class,
            StatusProjSeeder::class,
            StatusTaskSeeder::class,
            TypeMovimSeeder::class,
        ]);

    }
}
