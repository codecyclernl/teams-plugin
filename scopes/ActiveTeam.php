<?php namespace Codecycler\Teams\Scopes;

use Illuminate\Database\Eloquent\Scope;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Codecycler\Teams\Classes\TeamManager;

class ActiveTeam implements Scope
{
    public function apply(Builder $builder, Model $model)
    {
        $activeTeam = TeamManager::instance()->active();

        if ($activeTeam) {
            $builder->where('team_id', $activeTeam->id);
        }
    }
}
