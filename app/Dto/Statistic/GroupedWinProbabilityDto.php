<?php

namespace App\Dto\Statistic;

class GroupedWinProbabilityDto
{
    public function __construct(
        public int $teamId,
        public int $winProbabilityPercent,
    )
    {
    }
}
