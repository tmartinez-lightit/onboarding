<?php

declare(strict_types=1);

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Database\Factories\AirlineFactory;
use Database\Factories\CityFactory;
use Database\Factories\FlightFactory;
use Database\Factories\UserFactory;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        UserFactory::new()->count(10)->create();
        $cities = CityFactory::new()->count(10)->create();
        $airlines = AirlineFactory::new()->count(10)->create();

        FlightFactory::new()
            ->count(10)
            ->recycle($cities)
            ->recycle($airlines)
            ->create();
    }
}
