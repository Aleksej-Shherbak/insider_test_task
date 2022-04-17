<?php

namespace App\Http\Controllers;

use App\Models\Team;
use Illuminate\Database\Eloquent\Collection;

class TeamController extends Controller
{
    /**
     * @return Collection<Team>
     */
    public function all(): Collection
    {
        return Team::all();
    }
}
