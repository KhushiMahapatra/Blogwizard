<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Service;

class ServicesSeeder extends Seeder {
    public function run() {
        $services = [
            ['description' => 'Building modern and responsive websites.', ],
        ];

        foreach ($services as $service) {
            Service::create($service);
        }
    }
}
