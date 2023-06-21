<?php

namespace Database\Seeders;

use App\Models\User;
use Faker\Factory;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Factory::create(app()->getLocale());

        for ($i = 1; $i <= 300; $i++) {
            $users[] = [
                'name'     => $faker->name,
                'email'    => $faker->email,
                'password' => bcrypt('123123'),
                'role'     => ($i % 30 === 0) ? 1 : 0
            ];
        }

        foreach (array_chunk($users, 100) as $chunk) {
            User::insert($chunk);
        }
    }

}
