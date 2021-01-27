<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use TimoKoerber\LaravelJsonSeeder\JsonDatabaseSeeder as Seed;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        $this->call(Seed::class);
    }
}
