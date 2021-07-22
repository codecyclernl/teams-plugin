<?php namespace Codecycler\Teams\Classes;

use Event;
use Codecycler\Teams\Models\Team;
use Codecycler\Teams\Models\Settings;

class ExtendFrontendUserLogin
{
    public function subscribe()
    {
        Event::listen('rainlab.user.login', function ($user) {
            $useDefaultTeam = Settings::get('is_default_team', false);
            $defaultTeamId = Settings::get('default_team', null);
            $firstTeam = $user->teams->first();

            if ($user && $useDefaultTeam && !$firstTeam) {
                //
                $team = Team::find($defaultTeamId);

                //
                $user->teams()->add($team);
            }
        });
    }
}