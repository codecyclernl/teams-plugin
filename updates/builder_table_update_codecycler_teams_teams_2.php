<?php namespace Codecycler\Teams\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateCodecyclerTeamsTeams2 extends Migration
{
    public function up()
    {
        Schema::table('codecycler_teams_teams', function($table)
        {
            $table->text('extra_data')->nullable();
        });
    }
    
    public function down()
    {
        Schema::table('codecycler_teams_teams', function($table)
        {
            $table->dropColumn('extra_data');
        });
    }
}
