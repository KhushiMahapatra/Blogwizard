<?php

// database/seeders/TagSeeder.php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Tag; // Make sure this line is present

class TagSeeder extends Seeder
{
    public function run()
    {
        $tags = [
            ['name' => 'php', 'description' => 'A popular general-purpose scripting language.'],
            ['name' => 'laravel php', 'description' => 'A web application framework with expressive syntax.'],
            ['name' => 'backend development', 'description' => 'Server-side development that focuses on databases and server logic.'],
            ['name' => 'frontend dev', 'description' => 'Client-side development that focuses on user interface and experience.'],
        ];
        foreach ($tags as $tag) {
            Tag::create([
                'name' => $tag
            ]);
        }
    }
}

