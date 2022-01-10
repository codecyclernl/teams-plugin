<?php namespace Codecycler\Teams\Classes;

use RainLab\User\Models\User;
use Codecycler\Teams\Models\Team;

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

            $model->addDynamicMethod('inGroup', function ($groupCode) use ($model) {
                return $model->groups->pluck('code')->contains($groupCode);
            });
        });
    }
}
