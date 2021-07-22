<?php namespace Codecycler\Teams\Classes;

use RainLab\User\Models\User;
use Codecycler\Teams\Models\Team;
use Codecycler\Teams\Models\Settings;

class ExtendFrontendUser
{
    public function subscribe()
    {
        User::extend(function ($model) {
            $model->morphToMany['teams'] = [
                Team::class,
                'table' => 'codecycler_teams_teams_users',
                'name' => 'teamable',
                'timestamps' => true,
            ];
        });
    }
}
