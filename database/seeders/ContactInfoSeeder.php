<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ContactInfo;

class ContactInfoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Create a new contact info record
        ContactInfo::create([
            'address' => 'Surat, Gujarat, India',
            'email' => 'support@gmail.com',
            'phone' => '+23-456-6588',
        ]);
    }
}
