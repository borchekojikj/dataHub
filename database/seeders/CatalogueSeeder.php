<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;
use Carbon\Carbon;

class CatalogueSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();

        // Get all store IDs
        $storeIds = DB::table('stores')->pluck('id')->all();

        // Check if there are any stores
        if (empty($storeIds)) {
            // If no stores, we cannot seed catalogues without valid foreign keys
            $this->command->info('No stores found, skipping catalogues seeding.');
            return;
        }

        // Insert 10 dummy catalogues

        foreach (range(1, 10) as $index) {
            $startingPeriod = $faker->dateTimeBetween('+1 day', '+1 month');
            $endingPeriod = (clone $startingPeriod)->modify('+1 month');

            DB::table('catalogues')->insert([
                'catalogue_name' => $faker->word,
                'catalogue_file_url' => 'storage/catalogues/' . $faker->uuid . '.pdf',
                'catalogue_pic_url' => 'image' . random_int(1, 5) . '.jpg',
                'store_id' => $faker->randomElement($storeIds),
                'is_public' => false,
                'starting_period' => $startingPeriod,
                'ending_period' => $endingPeriod,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
