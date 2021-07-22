<?php namespace Codecycler\Teams\Models;

use Model;

class Settings extends Model
{
    public $implement = ['System.Behaviors.SettingsModel'];

    // A unique code
    public $settingsCode = 'codecycler_teams_settings';

    // Reference to field configuration
    public $settingsFields = 'fields.yaml';

    public function getDefaultTeamOptions()
    {
        return Team::all()->pluck('name', 'id');
    }
}
