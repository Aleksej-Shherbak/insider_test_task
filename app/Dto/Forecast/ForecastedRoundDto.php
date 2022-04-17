<?php

namespace App\Dto\Forecast;

class ForecastedRoundDto
{
    public function __construct(
        /**
         * @var ForecastedFixtureDto[]
         */
        public array $fixtures
    )
    {
    }
}
