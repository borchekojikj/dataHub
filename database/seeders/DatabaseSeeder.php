<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            ContentManagementSeeder::class,
            SocialsSeeder::class,
            AdminSeeder::class,
            UserSeeder::class,
            UserQuestionSeeder::class,
            CatalogueSeeder::class,
            BlogsSeeder::class,
        ]);
    }
}
