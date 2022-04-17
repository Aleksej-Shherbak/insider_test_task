<?php

namespace App\Http\Requests;

use App\Dto\Fixture\FixtureDto;
use App\Dto\Fixture\RoundDto;
use Illuminate\Foundation\Http\FormRequest;

/**
 *
 * @property int matches_look_back_count
 */
class ForecastRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'matches_look_back_count' => 'required|numeric|min:1',
            'rounds' => 'required|array',
            'rounds.*.fixtures' => 'required|array',
            'rounds.fixtures.*.home_team_id' => 'required|numeric',
            'rounds.fixtures.*.away_team_id' => 'required|numeric',
        ];
    }

    public function mapToDto() {
        return collect($this->rounds)
            ->map(fn($x) => new RoundDto(
                fixtures: collect($x['fixtures'])
                    ->map(fn ($fixture) => new FixtureDto(homeTeamId: $fixture['homeTeamId'], guestTeamId: $fixture['guestTeamId']))->toArray()))->toArray();
    }
}
