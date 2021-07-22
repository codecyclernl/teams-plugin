<?php namespace Codecycler\Teams;

use App;
use Event;
use Flash;
use Backend;
use System\Classes\PluginBase;
use RainLab\User\Classes\AuthManager;
use Codecycler\Teams\Classes\TeamManager;
use Codecycler\Teams\Classes\ExtendBackendUser;
use Codecycler\Teams\Classes\ExtendModelFields;
use Codecycler\Teams\Classes\ExtendFrontendUser;
use Codecycler\Teams\Classes\ExtendFrontendUserLogin;

/**
 * Teams Plugin Information File
 */
class Plugin extends PluginBase
{
    /**
     * Returns information about this plugin.
     *
     * @return array
     */
    public function pluginDetails()
    {
        return [
            'name'        => 'Teams',
            'description' => 'No description provided yet...',
            'author'      => 'Codecycler',
            'icon'        => 'icon-leaf'
        ];
    }

    /**
     * Boot method, called right before the request route.
     *
     * @return array
     */
    public function boot()
    {
        //
        Event::subscribe(ExtendModelFields::class);
        Event::subscribe(ExtendBackendUser::class);
        Event::subscribe(ExtendFrontendUser::class);
        Event::subscribe(ExtendFrontendUserLogin::class);

        //
        if(App::runningInBackend()) {
            // Register backend auth if not already
            $authManager = Backend\Classes\AuthManager::instance();
        } else {
            // Register frontend auth
            $authManager = AuthManager::instance();
        }

        $this->app->bind('Illuminate\Contracts\Auth\Factory', function () use ($authManager) {
            return $authManager;
        });

        //
        Event::listen('backend.page.beforeDisplay', function ($controller) {
            $controller->addJs('/plugins/codecycler/teams/assets/js/team-switcher.js');

            $controller->addDynamicMethod('onLoadTeamOptions', function () {
                return auth()->user()->teams;
            });

            $controller->addDynamicMethod('onSwitchTeam', function () {
                TeamManager::instance()->makeActive(input('team_id'));

                $active = TeamManager::instance()->active();

                Flash::success(e(trans('codecycler.teams::lang.messages.switched_team', ['name' => $active->name])));

                return redirect()->refresh();
            });
        });
    }

    /**
     * Registers back-end navigation items for this plugin.
     *
     * @return array
     */
    public function registerNavigation()
    {
        return [
            'teams' => [
                'label'       => 'Teams',
                'url'         => Backend::url('codecycler/teams/teams'),
                'icon'        => 'icon-users',
                'permissions' => ['codecycler.teams.*'],
                'order'       => 500,
                'sideMenu' => [
                    'teams' => [
                        'label' => 'Teams',
                        'url' => Backend::url('codecycler/teams/teams'),
                        'icon' => 'icon-users',
                    ],
                    'features' => [
                        'label' => 'Features',
                        'url' => Backend::url('codecycler/teams/features'),
                        'icon' => 'icon-certificate',
                    ],
                ],
            ],
        ];
    }

    public function registerSettings()
    {
        return [
            'settings' => [
                'label'       => 'Teams settings',
                'description' => 'Manage teams settings',
                'category'    => 'system::lang.system.categories.users',
                'icon'        => 'icon-users',
                'class'       => 'Codecycler\Teams\Models\Settings',
                'order'       => 500,
                'keywords'    => 'teams',
                'permissions' => ['codecycler.teams.access_settings'],
            ]
        ];
    }

    public function registerMarkupTags()
    {
        return [
            'functions' => [
                'teams' => [$this, 'getTeams'],
                'team' => [$this, 'getActiveTeam'],
            ],
        ];
    }

    public function getTeams()
    {
        return auth()->user()->teams;
    }

    public function getActiveTeam()
    {
        return TeamManager::instance()->active();
    }
}
