<?php
// database/seeders/CategorySeeder.php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category; // Make sure this line is present

class CategorySeeder extends Seeder
{
    public function run()
    {
        $categories = [
            [
                'name' => 'Science',
                'description' => 'The study of the physical and natural world through observation and experimentation.'
            ],
            [
                'name' => 'Sports',
                'description' => 'Physical activities and games that involve competition and skill.'
            ],
            [
                'name' => 'Entertainment',
                'description' => 'Activities that provide amusement or enjoyment, such as movies, music, and games.'
            ],
        ];

        foreach ($categories as $category) {
            Category::create([
                'name' => $category
            ]);
        }
    }
}
