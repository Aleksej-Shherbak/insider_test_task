<?php

namespace Tests\Unit;

use App\Dto\Fixture\FixtureDto;
use App\Dto\Fixture\RoundDto;
use App\Dto\Statistic\StatisticRecordDto;
use App\Services\ForecastService;
use PHPUnit\Framework\TestCase;

class ForecastServiceTest extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function test_calculate_probability_for_each_fixture()
    {
        $rounds = [
            new RoundDto(
                fixtures: [
                    new FixtureDto(
                        homeTeamId: 1,
                        guestTeamId: 2,
                    )
                ]
            ),
            new RoundDto(
                fixtures: [
                    new FixtureDto(
                        homeTeamId: 2,
                        guestTeamId: 1,
                    )
                ]
            )
        ];
        // supposed to be last 10 games statistic for each team.
        $statistic = [
            new StatisticRecordDto(
                teamId: 1,
                isTeamGuest: false,
                drawnCount: 0,
                lostCount: 6,
                wonCount: 4,
            ),
            new StatisticRecordDto(
                teamId: 1,
                isTeamGuest: true,
                drawnCount: 0,
                lostCount: 5,
                wonCount: 5,
            ),
            new StatisticRecordDto(
                teamId: 2,
                isTeamGuest: false,
                drawnCount: 3,
                lostCount: 3,
                wonCount: 4,
            ),
            new StatisticRecordDto(
                teamId: 2,
                isTeamGuest: true,
                drawnCount: 6,
                lostCount: 3,
                wonCount: 3,
            ),
        ];

        $firstFixtureHomeTeamWinProbability = 0.35;
        $firstFixtureGuestTeamWinProbability = 0.45;

        $secondFixtureHomeTeamWinProbability = 0.45;
        $secondFixtureGuestTeamWinProbability = 0.4;

        $forecastService = new ForecastService();
        $res = $forecastService->calculateProbabilityForEachFixture($rounds, $statistic, 10);
        // check if all fixtures have been processed
        $this->assertEquals(count($rounds), count($res));

        // check if result is correct (look alg description bellow)
        // home team win probability (4 + 3) / 20 = 0.35
        // guest team win probability (3 + 6) / 20 = 0.45
        $this->assertEquals($firstFixtureHomeTeamWinProbability, $res[0]->fixtures[0]->homeTeamWinProbability);
        $this->assertEquals($firstFixtureGuestTeamWinProbability, $res[0]->fixtures[0]->guestTeamWinProbability);
        // and the second fixture
        // home team win probability (4 + 5) / 20
        // guest team win probability (5 + 3) / 20
        $this->assertEquals($secondFixtureHomeTeamWinProbability, $res[1]->fixtures[0]->homeTeamWinProbability);
        $this->assertEquals($secondFixtureGuestTeamWinProbability, $res[1]->fixtures[0]->guestTeamWinProbability);
    }
}
