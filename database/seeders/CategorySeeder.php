<?php

namespace Database\Seeders;

use App\Models\Catalogs\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Category::create([
            Category::NAME => 'Lácteo',
            Category::DESC => '',
        ]);

        Category::create([
            Category::NAME => 'Carnes',
            Category::DESC => '',
        ]);
    }
}
