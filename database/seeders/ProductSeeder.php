<?php

namespace Database\Seeders;

use App\Classes\Eloquent\Domain\Enum\Constants;
use App\Models\Product;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Product::create([
            Product::NAME => 'Leche',
            Product::MODEL_YEAR => '2024',
            Product::PRICE => '25',
            Product::STATUS => Constants::ACTIVE,
            Product::CATEGORIES_ID => 1,
        ]);
    }
}
