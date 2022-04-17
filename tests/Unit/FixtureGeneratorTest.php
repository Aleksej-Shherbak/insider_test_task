<?php

namespace Tests\Unit;

use App\Dto\Fixture\FixtureDto;
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
        $fixtures = collect($fixtureGenerator->generateFixtures($teamsIds));

        $this->assertEquals($expectedNumberOfWeeks, $fixtures->count());
        $this->assertEquals(2, count($fixtures->first()));

        // check if there are no doubles (team does not play with itself)
        $this->assertEquals(0, $fixtures->reduce(function (int $carry, $teams) {
            return $carry + collect($teams)->filter(fn(FixtureDto $x) => $x->awayTeamId === $x->homeTeamId)->count();
        }, 0));
    }
}
