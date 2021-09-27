<?php namespace Codecycler\Teams\Classes;

use Event;
use Codecycler\Teams\Models\Team;
use Codecycler\Onboard\Models\UserImport;
use Codecycler\Onboard\Controllers\Import;

class ExtendOnboard
{
    public function subscribe()
    {
        Event::listen('backend.form.extendFields', function ($formWidget, $a) {
            if (! $formWidget->getController() instanceof Import) {
                return;
            }

            if (! $formWidget->model instanceof UserImport) {
                return;
            }

            if ($formWidget->isNested) {
                return;
            }

            // Only add the field in extension form
            if (isset($a['step3_section'])) {
                return;
            }

            $teamOptions = Team::all()
                ->pluck('name', 'id')
                ->toArray();

            $formWidget->addFields([
                'team' => [
                    'label' => 'codecycler.teams::lang.fields.team_id',
                    'type' => 'dropdown',
                    'options' => $teamOptions,
                    'placeholder' => 'codecycler.teams::lang.fields.import_select_team',
                    'span' => 'left',
                ],
            ]);
        });

        Event::listen('codecycler.onboard.after_import', function ($user, $importModel) {
            $team = Team::find($importModel->team);

            if (!$team) {
                return;
            }

            if ($team->users->contains($user)) {
                return;
            }

            $team->users()->attach($user);
        });
    }
}