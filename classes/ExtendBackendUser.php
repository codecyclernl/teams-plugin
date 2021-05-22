<?php namespace Codecycler\Teams\Classes;

use Backend\Models\User;
use Codecycler\Teams\Models\Team;

class ExtendBackendUser
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

            $model->addDynamicMethod('getNameAttribute', function () use ($model) {
                return $model->first_name . '\'s team';
            });
        });
    }
}
