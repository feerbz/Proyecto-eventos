<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Space;

class SpaceSeeder extends Seeder
{
    public function run(): void
    {
        $spaces = [
            'Auditorio A',
            'Lobby culturales',
            'Explanada gobierno',
        ];

        foreach ($spaces as $space) {
            Space::firstOrCreate([
                'name' => $space
            ]);
        }
    }
}
