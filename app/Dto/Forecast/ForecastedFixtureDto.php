<?php

namespace App\Dto\Forecast;

class ForecastedFixtureDto
{
    public function __construct(
        public float $homeTeamWinProbability,
        public float $guestTeamWinProbability,
        // TODO we should not use float because of accuracy of calculations. I use it only for saving my time and demonstration purposes
        public int   $homeTeamId,
        public int   $guestTeamId,
    )
    {
    }
}
