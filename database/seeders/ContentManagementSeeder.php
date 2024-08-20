<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class ContentManagementSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();

        $titles = [
            'paragraph1',
            'paragraph2',
            'clenovi i posetiteli',
            'upravuvanje so licni podatoci',
            'trgovci, proizvoditeli i oglasuvaci',
        ];

        foreach ($titles as $title) {
            DB::table('content_management')->insert([
                'title' => $title,
                'content' => $faker->paragraph,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
