<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\App;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            CategoriesTableSeeder::class,
            ConditionsTableSeeder::class,
            UsersTableSeeder::class,
            ItemsTableSeeder::class,
        ]);

        if (App::environment('local')) {
            $this->call([
                //
            ]);
        }
    }
}
