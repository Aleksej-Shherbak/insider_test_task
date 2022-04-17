<?php

namespace App\Services;

use App\Dto\Fixture\FixtureDto;
use ScheduleBuilder;

/**
 * Uses https://packagist.org/packages/mnito/round-robin,
 * https://en.wikipedia.org/wiki/Round-robin_tournament
 */
class FixtureService
{
    /**
     * @return FixtureDto[]
     */
    public function generateFixtures($teamIds): array
    {
        $rounds = (($count = count($teamIds)) % 2 === 0 ? $count - 1 : $count) * 2;
        $scheduleBuilder = new ScheduleBuilder($teamIds, $rounds);
        $schedule = $scheduleBuilder->build()->full();
        return $this->mapToDto($schedule);
    }

    private function mapToDto(array $schedule): array {
        $res = [];
        foreach ($schedule as $scheduleItem) {
            $fixturesList = [];
            foreach ($scheduleItem as $fixture) {
                $fixturesList[] = new FixtureDto(homeTeamId: $fixture[0], awayTeamId: $fixture[1]);
            }

            $res[] = $fixturesList;
        }

        return $res;
    }
}
