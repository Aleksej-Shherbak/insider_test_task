<?php

namespace App\Services;

use App\Dto\Fixture\RoundDto;
use App\Dto\Forecast\ForecastedFixtureDto;
use App\Dto\Forecast\ForecastedRoundDto;
use App\Dto\Statistic\GroupedWinProbabilityDto;
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
     * Let's make a calculation using the example of the RFPL game between Kazan Rubin and Zenit St. Petersburg.
     *
     * Rubin's statistics in home games: 4 wins, 2 draws and 4 losses.
     * Zenit statistics in away games: 6 wins, 4 draws and 0 losses.
     * We determine the probability of passing outcomes:
     *
     * Rubin's victory: 4 (Rubin's victories) + 0 (Zenit's defeats)=4, 4/20*100=20% ( probability of Ruby's victory)
     * Draw: 2(Rubin draws) + 4(Zenit draws)=6, 6/20*100=30% ( probability of a draw)
     * Zenit Victory: 6 (Zenit wins)+4 (Rubin defeats)=10, 10/20*100=50% ( the probability of Zenit's victory)
     *
     * source: https://bukmekerskie-kontory.bet/betting/wiki/probs/
     * @param RoundDto[] $rounds
     * @param StatisticRecordDto[] $statisticRecords
     * @param int $lookMatchesBack
     * @return ForecastedRoundDto[]
     */
    public function calculateProbabilityForEachFixture(array $rounds, array $statisticRecords, int $lookMatchesBack): array
    {
        $statisticRecords = collect($statisticRecords);
        $res = [];
        foreach ($rounds as $round) {
            $forecastedFixtures = [];

            foreach ($round->fixtures as $fixture) {
                /**
                 * @var StatisticRecordDto
                 */
                $homeTeamStatRecord = $statisticRecords->first(fn(StatisticRecordDto $x) => !$x->isTeamGuest && $x->teamId === $fixture->homeTeamId);
                $guestTeamStatRecord = $statisticRecords->first(fn(StatisticRecordDto $x) => $x->isTeamGuest && $x->teamId === $fixture->awayTeamId);
                if ($homeTeamStatRecord === null || $guestTeamStatRecord === null) {
                    continue;
                }

                $homeTeamWinProbability = ($homeTeamStatRecord->wonCount + $guestTeamStatRecord->lostCount) / ($lookMatchesBack * 2);
                $guestTeamWinProbability = ($guestTeamStatRecord->wonCount + $homeTeamStatRecord->lostCount) / ($lookMatchesBack * 2);
                $forecastDto = new ForecastedFixtureDto(
                    homeTeamWinProbability: $homeTeamWinProbability,
                    guestTeamWinProbability: $guestTeamWinProbability,
                    homeTeamId: $fixture->homeTeamId,
                    guestTeamId: $fixture->awayTeamId,
                );

                $forecastedFixtures[] = $forecastDto;
            }
            $res[] = new ForecastedRoundDto(
                fixtures: $forecastedFixtures
            );
        }

        return $res;
    }

    /**
     * @param RoundDto[] $rounds
     * @return GroupedWinProbabilityDto[]
     */
    public function probabilitiesMultiplication(array $rounds): array
    {
        $map = [];

        /**
         * $homeTeamWinProbability
         * $guestTeamWinProbability
         * $homeTeamId
         * $guestTeamId
         */
        foreach ($rounds as $round) {
            foreach ($round as $fixture) {

            }
        }
    }

}
