<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Space;

class SpaceSeeder extends Seeder
{
    public function run(): void
    {
        $spaces = [
            [
                'name' => 'Auditorio A',
                'capacity' => 50,
                'is_unlimited' => false,
            ],
            [
                'name' => 'Lobby culturales',
                'capacity' => 100,
                'is_unlimited' => false,
            ],
            [
                'name' => 'Explanada gobierno',
                'capacity' => 300,
                'is_unlimited' => false,
            ],
        ];

        foreach ($spaces as $space) {
            Space::updateOrCreate(
                ['name' => $space['name']],
                [
                    'capacity' => $space['capacity'],
                    'is_unlimited' => $space['is_unlimited'],
                ]
            );
        }
    }
}
