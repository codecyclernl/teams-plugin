<?php namespace Codecycler\Teams\Classes;

use Codecycler\Teams\Models\Team;
use October\Rain\Support\Traits\Singleton;

class TeamManager
{
    use Singleton;

    public function active(): ?Team
    {
        // First check the session
        if (! auth()->user()->teams->first()) {
            // Create a new team
            $this->createPersonalTeam();
        }

        $activeTeamId = session('active_team_id') ?? auth()->user()->teams->first()->id;
        return Team::find($activeTeamId);
    }

    public function makeActive($id): self
    {
        if (!is_numeric($id)) {
            $team = Team::byCode($id)->first();
        } else {
            $team = Team::find($id);
        }

        session()->put('active_team_id', $team->id);

        return $this;
    }

    public function createPersonalTeam($user = null)
    {
        //
        if (! $user) {
            $user = auth()->user();
        }

        //
        $team = new Team();

        //
        $team->name = $user->name;

        //
        $team->save();

        //
        $user->teams()->add($team);
    }
}