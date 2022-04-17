<?php

namespace App\Http\Controllers;

use App\Http\Requests\ForecastRequest;
use App\Models\StatisticRecord;
use App\Services\ForecastService;
use Illuminate\Http\JsonResponse;

class ForecastController extends Controller
{
    public function getForecast(ForecastRequest $request, ForecastService $forecastService): JsonResponse
    {
        // TODO matches_look_back_count is not limmited now . But we should to limit users in advance with the smallest quantity of match statistic records.
        $rounds = $request->mapToDto();
        $statisticRecordDtos = StatisticRecord::getStatistic($request->matches_look_back_count);
        $forecastedRounds = $forecastService->calculateProbabilityForEachFixture(
            rounds: $rounds,
            statisticRecords: $statisticRecordDtos,
            lookMatchesBack: $request->matches_look_back_count);
        $forecastedRoundsMultiplicationProbabilities = $forecastService->probabilitiesMultiplication($forecastedRounds);
        return response()->json($forecastedRoundsMultiplicationProbabilities);
    }
}
