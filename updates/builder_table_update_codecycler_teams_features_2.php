<?php namespace Codecycler\Teams\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateCodecyclerTeamsFeatures2 extends Migration
{
    public function up()
    {
        Schema::table('codecycler_teams_features', function($table)
        {
            $table->string('feature_key', 255)->change();
        });
    }
    
    public function down()
    {
        Schema::table('codecycler_teams_features', function($table)
        {
            $table->string('feature_key', 10)->change();
        });
    }
}
