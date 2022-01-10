<?php namespace Codecycler\Teams\Classes;

use Event;
use System\Classes\PluginManager;
use Codecycler\Teams\Models\Settings;

class ExtendH5p
{
    public function subscribe()
    {
        Event::listen('learnkit.h5p.extendStyles', function () {
            if (!PluginManager::instance()->exists('LearnKit.H5p')) {
                return;
            }

            $themeOptions = collect(Settings::get('theme_options'));
            $h5pConfig = $themeOptions->where('key', 'h5p_css');

            if($h5pConfig->count() < 1) {
                return;
            }

            return '/plugin-support/codecycler/teams/h5p_css.css';
        });
    }
}