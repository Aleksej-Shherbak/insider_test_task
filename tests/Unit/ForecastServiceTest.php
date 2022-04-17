<?php

namespace Tests\Unit;

use App\Dto\Fixture\FixtureDto;
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
        $fixtures = [
            new FixtureDto(
                homeTeamId: 1,
                awayTeamId: 2,
            ),
            new FixtureDto(
                homeTeamId: 2,
                awayTeamId: 1,
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
        $res = $forecastService->calculateProbabilityForEachFixture($fixtures, $statistic, 10);

        // check if all fixtures have been processed
        $this->assertEquals(count($fixtures), count($res));

        // check if result is correct (look alg description bellow)
        // home team win probability (4 + 3) / 20 = 0.35
        // guest team win probability (3 + 6) / 20 = 0.45
        $this->assertEquals($firstFixtureHomeTeamWinProbability, $res[0]->homeTeamWinProbability);
        $this->assertEquals($firstFixtureGuestTeamWinProbability, $res[0]->guestTeamWinProbability);
        // and the second fixture
        // home team win probability (4 + 5) / 20
        // guest team win probability (5 + 3) / 20
        $this->assertEquals($secondFixtureHomeTeamWinProbability, $res[1]->homeTeamWinProbability);
        $this->assertEquals($secondFixtureGuestTeamWinProbability, $res[1]->guestTeamWinProbability);
    }

    /**
    Let's make a calculation using the example of the RFPL game between Kazan Rubin and Zenit St. Petersburg.

    Rubin's statistics in home games: 4 wins, 2 draws and 4 losses.
    Zenit statistics in away games: 6 wins, 4 draws and 0 losses.
    We determine the probability of passing outcomes:

    Rubin's victory: 4 (Rubin's victories) + 0 (Zenit's defeats)=4, 4/20*100=20% ( probability of Ruby's victory)
    Draw: 2(Rubin draws) + 4(Zenit draws)=6, 6/20*100=30% ( probability of a draw)
    Zenit Victory: 6 (Zenit wins)+4 (Rubin defeats)=10, 10/20*100=50% ( the probability of Zenit's victory)
     */
}
