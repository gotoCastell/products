<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Catalogs\CatResourceType;

class CatResourceTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        CatResourceType::create([
            CatResourceType::NAME => 'Video',
            CatResourceType::DESC => '',
        ]);

        CatResourceType::create([
            CatResourceType::NAME => 'Foto',
            CatResourceType::DESC => '',
        ]);
    }
}
