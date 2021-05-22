<?php namespace Codecycler\Teams;

use App;
use Event;
use Backend;
use System\Classes\PluginBase;
use RainLab\User\Classes\AuthManager;
use Codecycler\Teams\Classes\ExtendBackendUser;
use Codecycler\Teams\Classes\ExtendModelFields;
use Codecycler\Teams\Classes\ExtendFrontendUser;

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
     * Register method, called when the plugin is first registered.
     *
     * @return void
     */
    public function register()
    {

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
    }

    /**
     * Registers any front-end components implemented in this plugin.
     *
     * @return array
     */
    public function registerComponents()
    {
        return []; // Remove this line to activate

        return [
            'Codecycler\Teams\Components\MyComponent' => 'myComponent',
        ];
    }

    /**
     * Registers any back-end permissions used by this plugin.
     *
     * @return array
     */
    public function registerPermissions()
    {
        return []; // Remove this line to activate

        return [
            'codecycler.teams.some_permission' => [
                'tab' => 'Teams',
                'label' => 'Some permission'
            ],
        ];
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
}
