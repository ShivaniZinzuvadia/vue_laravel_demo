<?php

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use App\Author as Author;

class AuthorsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();

        for ($i = 0; $i < 20; $i++) {
            Author::create([
                'name' => $faker->name,
                'email' => $faker->email,
                'mobile' => $faker->phoneNumber
            ]);
        }
    }
}
