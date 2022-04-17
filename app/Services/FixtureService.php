<?php

namespace App\Services;

use App\Dto\Fixture\FixtureDto;
use App\Dto\Fixture\RoundDto;
use ScheduleBuilder;

/**
 * Uses https://packagist.org/packages/mnito/round-robin,
 * https://en.wikipedia.org/wiki/Round-robin_tournament
 */
class FixtureService
{
    /**
     * @return RoundDto[]
     */
    public function generateFixtures($teamIds): array
    {
        $rounds = (($count = count($teamIds)) % 2 === 0 ? $count - 1 : $count) * 2;
        $scheduleBuilder = new ScheduleBuilder($teamIds, $rounds);
        $schedule = $scheduleBuilder->build()->full();
        return $this->mapToDto($schedule);
    }

    /**
     * @param array $schedule
     * @return RoundDto[]
     */
    private function mapToDto(array $schedule): array {
        $res = [];
        foreach ($schedule as $scheduleItem) {
            $fixturesList = [];
            foreach ($scheduleItem as $fixture) {
                $fixturesList[] = new FixtureDto(homeTeamId: $fixture[0], guestTeamId: $fixture[1]);
            }

            $res[] = new RoundDto(fixtures: $fixturesList);
        }

        return $res;
    }
}
