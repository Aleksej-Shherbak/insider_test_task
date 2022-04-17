<?php

namespace App\Dto\Fixture;

class RoundDto
{
    public function __construct(
        /**
         * @var FixtureDto[]
         */
        public array $fixtures
    )
    {
    }
}
