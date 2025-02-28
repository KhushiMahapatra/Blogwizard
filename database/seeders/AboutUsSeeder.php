<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\AboutUs;


class AboutUsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
{
    AboutUs::create([
        'mission' => 'Our mission is to empower individuals and communities through insightful content.',
        'vision' => 'Our vision is to be a leading source of knowledge and inspiration.',
        'approach' => 'Our approach is to curate engaging content that fosters curiosity and growth.',
        'description' => 'We are a dynamic team of creative people dedicated to sharing knowledge, inspiration, and resources that empower individuals and communities. Our diverse team of writers, creators, and thought leaders curates engaging content across various topics, fostering a vibrant community where curiosity thrives and ideas flourish.',
        'extra_content' => 'We also offer workshops and webinars to further engage our audience and provide hands-on learning experiences.',
    ]);
}
}
