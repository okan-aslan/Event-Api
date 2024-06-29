<?php

namespace Database\Seeders;

use App\Models\Event;
use App\Models\User;
use App\Models\Venue;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory(3)->create();
        Venue::factory(15)->create();

        Event::factory(5)->create([
            'user_id' => function () {
                return User::all()->random()->id;
            },
            'venue_id' => function () {
                return Venue::all()->random()->id;
            },
        ]);
    }
}
