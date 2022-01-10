<?php namespace Codecycler\Teams\Controllers;

use BackendMenu;
use Backend\Classes\Controller;
use Codecycler\Teams\Models\Settings;

/**
 * Teams Back-end Controller
 */
class Teams extends Controller
{
    public $implement = [
        'Backend.Behaviors.FormController',
        'Backend.Behaviors.ListController',
        'Backend.Behaviors.RelationController',
    ];

    public $formConfig = 'config_form.yaml';
    public $listConfig = 'config_list.yaml';
    public $relationConfig = 'config_relations.yaml';

    public function __construct()
    {
        parent::__construct();

        BackendMenu::setContext('Codecycler.Teams', 'teams', 'teams');
    }

    public function formExtendFields($formController)
    {
        // Add theme option fields
        $themeOptions = Settings::get('theme_options', []);

        if (!$themeOptions) {
            $themeOptions = [];
        }

        foreach ($themeOptions as $option) {
            $formController->addTabFields([
                'theme_options[' . $option['key'] . ']' => [
                    'label' => $option['key'],
                    'tab' => 'codecycler.teams::lang.tabs.theme_options',
                    'type' => $option['type'],
                    'span' => 'left',
                ],
            ]);
        }

        // Add extra option fields
        $themeOptions = Settings::get('extra_options', []);

        if (!$themeOptions) {
            $themeOptions = [];
        }

        foreach ($themeOptions as $option) {
            $formController->addTabFields([
                'extra_data[' . $option['key'] . ']' => [
                    'label' => $option['key'],
                    'tab' => 'codecycler.teams::lang.tabs.extra_options',
                    'type' => $option['type'],
                    'span' => 'left',
                ],
            ]);
        }
    }
}
