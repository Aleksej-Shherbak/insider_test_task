<?php

namespace Database\Seeders;

use App\Models\StatisticRecord;
use App\Models\Team;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class StatisticSeeder extends Seeder
{
    /**
     * Seed fake statistic data. This is only for demonstration purposes.
     * @return void
     */
    public function run()
    {
        $teams = Team::all();

        foreach ($teams as $team) {
            // make 10 home matches
            $this->generateTeamStatisticRecord(false, $team->id);

            // make 10 guest matches
            $this->generateTeamStatisticRecord(true, $team->id);
        }
    }

    private function setGameResult(StatisticRecord $game): void {
        $number = mt_rand(1, 3);

        switch ($number) {
            case 1:
                $game->won = true;
                break;
            case 2:
                $game->drawn = true;
                break;
            case 3:
                $game->lost = true;
                break;
        }
    }

    private function generateTeamStatisticRecord(bool $isGuestTeam, int $teamId): void {
        for ($month = 1; $month <= 12; $month++) {
            $game = new StatisticRecord();
            $game->team_id = $teamId;
            $game->is_team_guest = $isGuestTeam;
            $this->setGameResult($game);
            $game->match_date = Carbon::create(year: 2021, month: $month);
            $game->save();
        }
    }
}

