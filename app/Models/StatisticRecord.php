<?php

namespace App\Models;

use App\Dto\Statistic\StatisticRecordDto;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\DB;

/**
 * @property integer $team_id
 * @property Carbon $match_date
 * @property bool $won
 * @property bool $lost
 * @property bool $drawn
 * @property bool $is_team_guest

 */
class StatisticRecord extends Model
{
    use HasFactory;

    public $timestamps = false;

    public function team(): BelongsTo
    {
        return $this->belongsTo(Team::class);
    }

    /**
     * Returns statistic about result of N last matches.
     * @param int $forMatchesQuantity
     * @return StatisticRecordDto[]
     */
    public static function getStatistic(int $forMatchesQuantity): array
    {
        // TODO works for all commands. Should be limited with a particular IDs list

         $res = DB::select( DB::raw(
        'select team_id,
                   is_team_guest,
                   count(drawn) drawn_count,
                   count(lost)  lost_count,
                   count(won)   won_count,
                   count(*)     total
            from (
                     SELECT *, ROW_NUMBER() OVER (PARTITION BY team_id, is_team_guest ORDER BY match_date) rn
                     FROM statistic_records) as sub
            WHERE rn <= :matchesQuantity
            group by team_id, is_team_guest'
        ), [
            'matchesQuantity' => $forMatchesQuantity
         ]);

        return collect($res)->map(fn ($x) => new StatisticRecordDto(
            teamId: $x->team_id,
            isTeamGuest: $x->is_team_guest,
            drawnCount: $x->drawn_count,
            lostCount: $x->lost_count,
            wonCount: $x->won_count,
        ))->toArray();
    }
}
