<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i = 1; $i <= 30; $i++) {
            Category::create([
                'name' => 'Category ' . $i,               
                'user_id' => 7, // Assign to user_id 7
            ]);
        }
    }
}
