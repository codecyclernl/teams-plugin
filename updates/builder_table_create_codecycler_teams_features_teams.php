<?php namespace Codecycler\Teams\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableCreateCodecyclerTeamsFeaturesTeams extends Migration
{
    public function up()
    {
        Schema::create('codecycler_teams_features_teams', function($table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id')->unsigned();
            $table->integer('feature_id')->nullable()->unsigned();
            $table->integer('team_id')->nullable()->unsigned();
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('codecycler_teams_features_teams');
    }
}
