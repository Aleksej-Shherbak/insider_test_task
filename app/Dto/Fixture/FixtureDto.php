<?php

namespace App\Dto\Fixture;

class FixtureDto
{
    public function __construct(
        public int $homeTeamId,
        public int $guestTeamId,
    )
    {
    }
}
