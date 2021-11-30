<?php namespace Codecycler\Teams\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateCodecyclerTeamsTeams extends Migration
{
    public function up()
    {
        Schema::table('codecycler_teams_teams', function($table)
        {
            $table->string('domain')->nullable();
        });
    }
    
    public function down()
    {
        Schema::table('codecycler_teams_teams', function($table)
        {
            $table->dropColumn('domain');
        });
    }
}
