<?php namespace Codecycler\Teams\Classes;

use Codecycler\Teams\Models\Team;
use Codecycler\Teams\Models\Settings;
use October\Rain\Support\Traits\Singleton;

class TeamManager
{
    use Singleton;

    public function active(): ?Team
    {
        if (auth()->user()) {
            // First check the session
            if (! auth()->user()->teams->first() && Settings::get('auto_create_teams', false)) {
                // Create a new team
                $this->createPersonalTeam();
            }

            if (! auth()->user()->teams->first() && Settings::get('is_default_team', false)) {
                $this->attachToDefaultTeam();
            }

            if (! auth()->user()->teams->first() && !Settings::get('auto_create_teams', false)) {
                // Create a new team
                return null;
            }
        }

        $activeTeamId = session('active_team_id');

        if (!$activeTeamId && auth()->user()) {
            $activeTeamId = auth()->user()->teams->first()->id;
        } else {
            return null;
        }

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

    public function createPersonalTeam($user = null): void
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

    public function attachToDefaultTeam($user = null): void
    {
        if (! $user) {
            $user = auth()->user();
        }

        //
        $team = Team::find(Settings::get('default_team'));

        //
        $user->teams()->add($team);
    }

    public function resolveByDomain()
    {
        $domain = request()->server('HTTP_HOST');

        // Get team for domain
        $team = Team::where('domain', $domain)->first();

        //
        if ($team) {
            $this->makeActive($team->code);
        }
    }
}
