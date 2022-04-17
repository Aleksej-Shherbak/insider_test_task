<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateFixtureRequest;
use App\Services\FixtureService;
use Illuminate\Http\JsonResponse;

class FixtureController extends Controller
{
    public function calculateFixtures(CreateFixtureRequest $request, FixtureService $fixtureService): JsonResponse
    {
        if (count($request->teams_ids) % 2 !== 0) {
            return abort(400);
        }
        $fixtures = $fixtureService->generateFixtures($request->teams_ids);
        return response()->json($fixtures);
    }
}
