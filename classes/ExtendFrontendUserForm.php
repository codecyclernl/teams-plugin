<?php

namespace Codecycler\Teams\Classes;

use RainLab\User\Models\User;
use RainLab\User\Controllers\Users;
use Codecycler\Extend\Classes\PluginExtender;

class ExtendFrontendUserForm extends PluginExtender
{
    public function controller()
    {
        return new Users;
    }

    public function model()
    {
        return new User;
    }

    public function addTabFields()
    {
        return [
            'teams' => [
                'tab' => 'Teams',
                'type' => 'partial',
                'path' => '$/codecycler/teams/partials/_field_teams.htm',
            ],
        ];
    }

    public function addRelationConfig()
    {
        return [
            'teams' => [
                'label' => 'team',
                'manage' => [
                    'form' => '$/codecycler/teams/models/team/fields.yaml',
                ],
                'view' => [
                    'toolbarButtons' => 'link|unlink',
                    'list' => '$/codecycler/teams/models/team/columns.yaml',
                    'recordUrl' => 'codecycler/teams/teams/update/:id',
                ],
            ],
        ];
    }
}