<?php

namespace App\Http\Controllers;

use App\Models\StatisticRecord;

class StatisticController extends Controller
{
    public function getAllTeamsStatistic(int $matches): array
    {
        $res = StatisticRecord::getStatistic($matches);
        response()->json($res);
    }
}
