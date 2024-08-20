<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SocialsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $socials = [
            [
                'email' => 'info@datahub.com',
                'facebook' => 'https://www.facebook.com/',
                'instagram' => 'https://www.instagram.com/',
                'twitter' => 'https://x.com/home?lang=en',
            ],
        ];

        foreach ($socials as $social) {
            DB::table('socials')->insert([
                'email' => $social['email'],
                'facebook' => $social['facebook'],
                'instagram' => $social['instagram'],
                'twitter' => $social['twitter'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
