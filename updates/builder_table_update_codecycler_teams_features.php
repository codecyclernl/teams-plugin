<?php namespace Codecycler\Teams\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateCodecyclerTeamsFeatures extends Migration
{
    public function up()
    {
        Schema::table('codecycler_teams_features', function($table)
        {
            $table->string('feature_key', 10)->nullable()->unsigned(false)->default(null)->change();
        });
    }
    
    public function down()
    {
        Schema::table('codecycler_teams_features', function($table)
        {
            $table->integer('feature_key')->nullable()->unsigned(false)->default(null)->change();
        });
    }
}
