<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\DB;

class UserQuestionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();

        // Get all user IDs
        $userIds = User::pluck('id')->all();

        // Insert 20 random questions
        foreach (range(1, 10) as $index) {
            DB::table('user_questions')->insert([
                'user_id' => DB::table('users')->select('id')->inRandomOrder()->first()->id,
                'question' => $faker->sentence,
                'answered' => false,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
