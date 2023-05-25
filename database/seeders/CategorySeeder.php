<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    /**
     * The categories to be created.
     */
    public $categories = [
        'Remessa Parcial',
        'Remessa',
    ];

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        foreach ($this->categories as $category) {
            Category::firstOrCreate([
                'name' => $category
            ]);
        }
    }
}
