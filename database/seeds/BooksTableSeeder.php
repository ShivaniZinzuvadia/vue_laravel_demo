<?php

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use App\Book;

class BooksTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();

        for ($i = 0; $i < 40; $i++) {
            Book::create([
                'name' => "Book ".$faker->word." ".($i+1),
                'price' => $faker->randomNumber(3),
                'published_on' => $faker->date(),
                'author_id' => $faker->numberBetween($min = 1, $max = 20)
            ]);
        }
    }
}
