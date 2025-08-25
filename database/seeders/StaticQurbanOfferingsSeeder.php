<?php

namespace Database\Seeders;

use App\Models\QurbanEvent;
use App\Models\QurbanOffering;
use Illuminate\Database\Seeder;

class StaticQurbanOfferingsSeeder extends Seeder
{
    public function run()
    {
        // Check if a QurbanEvent with ID 1 exists, if not create it
        $qurbanEvent = QurbanEvent::firstOrCreate(
            ['id' => 1],
            [
                'name' => 'Qurban 1446 H',
                'year_hijri' => '1446',
                'registration_deadline' => '2025-06-26',
            ]
        );

        // Clear existing offerings for this event to avoid duplicates
        $qurbanEvent->offerings()->delete();

        $qurbanEvent->offerings()->createMany([
            [
                'type' => 'cow_share',
                'name' => 'Sapi',
                'price' => 20000000,
                'participant_limit' => 7,
            ],
            [
                'type' => 'goat',
                'name' => 'Kambing',
                'price' => 3000000,
                'participant_limit' => 1,
            ],
            [
                'type' => 'camel',
                'name' => 'Unta',
                'price' => 30000000,
                'participant_limit' => null,
            ],
        ]);
    }
}
