<?php

Route::get('/plugin-support/codecycler/teams/h5p_css.css', function () {
    $team = \Codecycler\Teams\Classes\TeamManager::instance()->active();

    $data = $team->theme_options['h5p_css'];

    return response($data)->header('Content-Type', 'text/css');
})->middleware('web');