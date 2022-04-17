<?php

namespace App\Services;

use App\Dto\Fixture\FixtureDto;
use App\Dto\Forecast\ForecastDto;
use App\Dto\Statistic\StatisticRecordDto;

class ForecastService
{
    /**
     * Algorithm that I've used:
     *
     * To calculate the probability of a home team winning, find the sum of its wins in the last 10 home games and its
     * opponent's losses in the last 10 away games. Next, divide the resulting number by 20 (the total number of games)
     * and multiply by 100. Thus, you have found the percentage probability of the home team winning.
     *
     * To find out the probability of a draw, add up the draws of the teams in the last 10 games and divide the total
     * by 20, and then also multiply the resulting number by 100.
     *
     * According to the same principle, the probability of the guest team winning is determined.
     * It is necessary to add up the team's away wins in the last 10 away games and add to them the opponent's home
     * defeats in the last 10 home matches. Next, the resulting number must be divided by 20 and multiplied by 100.
     *
     * @param FixtureDto[] $fixtures
     * @param StatisticRecordDto[] $statisticRecords
     * @param int $lookMatchesBack
     * @return ForecastDto[]
     */
    public function calculateProbabilityForEachFixture(array $fixtures, array $statisticRecords, int $lookMatchesBack): array
    {
        $res = [];
        $statisticRecords = collect($statisticRecords);

        foreach ($fixtures as $fixture) {
            /**
             * @var StatisticRecordDto
             */
            $homeTeamStatRecord = $statisticRecords->first(fn (StatisticRecordDto $x) => !$x->isTeamGuest && $x->teamId === $fixture->homeTeamId);
            $guestTeamStatRecord = $statisticRecords->first(fn (StatisticRecordDto $x) => $x->isTeamGuest && $x->teamId === $fixture->awayTeamId);
            if ($homeTeamStatRecord === null || $guestTeamStatRecord === null) {
                continue;
            }

            $homeTeamWinProbability = ($homeTeamStatRecord->wonCount + $guestTeamStatRecord->lostCount) / ($lookMatchesBack * 2);
            $guestTeamWinProbability = ($guestTeamStatRecord->wonCount + $homeTeamStatRecord->lostCount) / ($lookMatchesBack * 2);
            $forecastDto = new ForecastDto(
                homeTeamWinProbability: $homeTeamWinProbability,
                guestTeamWinProbability: $guestTeamWinProbability,
                homeTeamId: $fixture->homeTeamId,
                guestTeamId: $fixture->awayTeamId,
            );

            $res[] = $forecastDto;
        }

        return $res;
    }

}
