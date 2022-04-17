<?php

namespace Tests\Unit;

use App\Dto\Fixture\FixtureDto;
use App\Dto\Fixture\RoundDto;
use App\Services\FixtureService;
use PHPUnit\Framework\TestCase;

class FixtureGeneratorTest extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function test_fixture_service_can_generate_fixtures()
    {
        $teamsIds = [1, 2, 3, 4];
        $expectedNumberOfWeeks = 6;

        $fixtureGenerator = new FixtureService();
        $rounds = collect($fixtureGenerator->generateFixtures($teamsIds));

        $this->assertEquals($expectedNumberOfWeeks, $rounds->count());
        $this->assertEquals(2, count($rounds->first()->fixtures));

        // check if there are no doubles (team does not play with itself)
        foreach ($rounds as $round) {
            foreach ($round->fixtures as $fixture) {
                $this->assertTrue($fixture->homeTeamId !== $fixture->guestTeamId);
            }
        }
    }
}
