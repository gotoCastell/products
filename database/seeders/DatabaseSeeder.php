<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use Illuminate\Database\Seeder;
use Database\Seeders\UserSeeder;
use Database\Seeders\ProductSeeder;
use Database\Seeders\CategorySeeder;
use Database\Seeders\ResourceSeeder;
use App\Models\Catalogs\CatResourceType;
use Database\Seeders\ResourceProductSeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(CategorySeeder::class);
        $this->call(CatResourceTypeSeeder::class);
        $this->call(ResourceSeeder::class);
        $this->call(ProductSeeder::class);
        $this->call(ResourceProductSeeder::class);
        $this->call(UserSeeder::class);
    }
}
