<?php namespace Codecycler\Teams\Concerns;

use System\Classes\ModelBehavior;
use Codecycler\Teams\Models\Team;
use Codecycler\Teams\Scopes\ActiveTeam;
use Codecycler\Teams\Classes\TeamManager;

class BelongsToTeams extends ModelBehavior
{
    private $skipScope = false;

    public function __construct($model)
    {
        parent::__construct($model);

        // Add the global scope
        if (method_exists(auth()->user(), 'isSuperUser') && auth()->user()->isSuperUser()) {
            $this->skipScope = true;
        }

        //
        if (!$this->skipScope) {
            $this->model::addGlobalScope(new ActiveTeam);
        }

        //
        $this->bindEvents();

        //
        $this->addInverseRelation();
    }

    private function bindEvents()
    {
        //
        $model = $this->model;

        $this->model->bindEvent('model.beforeSave', function () use ($model) {
            // Bind model to active team
            if (! $model->team_id) {
                $model->team_id = TeamManager::instance()->active()->id;
            }
        });
    }

    private function addInverseRelation()
    {
        $this->model->belongsTo['team'] = [
            Team::class,
        ];
    }
}
