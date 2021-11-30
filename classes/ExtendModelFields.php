<?php namespace Codecycler\Teams\Classes;

use Event;

class ExtendModelFields
{
    public function subscribe()
    {
        Event::listen('backend.form.extendFields', function ($formWidget) {
            if ($formWidget->isNested) {
                return;
            }

            if (!isset($formWidget->model->implement)) {
                $formWidget->model->implement = [];
            }

            if (! $formWidget->model->implement) {
                return;
            }

            if (! in_array('@Codecycler\Teams\Concerns\BelongsToTeams', $formWidget->model->implement, true)) {
                return;
            }

            if (! auth()->user()->isSuperUser()) {
                return;
            }

            // Add form field to the form
            $formWidget->addFields([
                'team' => [
                    'label' => 'codecycler.teams::lang.fields.team_id',
                    'type' => 'recordfinder',
                    'span' => 'left',
                    'list' => '$/codecycler/teams/models/team/columns.yaml',
                    'required' => true,
                ],
            ]);
        });
    }
}
