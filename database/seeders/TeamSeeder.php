<?php

namespace Database\Seeders;

use App\Models\Team;
use Illuminate\Database\Seeder;

class TeamSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $teams = [
            'Liverpool',
            'Manchester City',
            'Chelsea',
            'Arsenal',
        ];

        foreach ($teams as $team) {
            (new Team())->fill(['name' => $team])->save();
        }
    }
}
