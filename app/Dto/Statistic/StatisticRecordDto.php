<?php

namespace App\Dto\Statistic;

class StatisticRecordDto
{
    public function __construct(
        public int $teamId,
        public bool $isTeamGuest,
        public int $drawnCount,
        public int $lostCount,
        public int $wonCount,
    )
    {
    }
}
