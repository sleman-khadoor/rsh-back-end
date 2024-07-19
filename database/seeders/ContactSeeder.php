<?php

namespace Database\Seeders;

use App\Models\Contact;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ContactSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $contactTypes = config('core-config.contacts');

        foreach($contactTypes as $type => $contact) {
            Contact::create([
                'type' => $type,
                'value' => $contact,
            ]);
        }
    }
}
