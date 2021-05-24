<?php namespace Codecycler\Teams\Classes;

use Codecycler\Teams\Models\Team;
use Codecycler\Teams\Models\Settings;
use October\Rain\Support\Traits\Singleton;

class TeamManager
{
    use Singleton;

    public function active(): ?Team
    {
        if (!auth()->user()) {
            return null;
        }

        // First check the session
        if (! auth()->user()->teams->first() && Settings::get('auto_create_teams', false)) {
            // Create a new team
            $this->createPersonalTeam();
        }

        if (! auth()->user()->teams->first() && !Settings::get('auto_create_teams', false)) {
            // Create a new team
            return null;
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
        $team->name = $user->name . '\'s team';

        //
        $team->save();

        //
        $user->teams()->add($team);
    }
}
