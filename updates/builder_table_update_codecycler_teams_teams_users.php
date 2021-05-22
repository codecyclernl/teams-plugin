<?php namespace Codecycler\Teams\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateCodecyclerTeamsTeamsUsers extends Migration
{
    public function up()
    {
        Schema::table('codecycler_teams_teams_users', function($table)
        {
            $table->renameColumn('user_class', 'teamable_type');
            $table->renameColumn('user_id', 'teamable_id');
        });
    }
    
    public function down()
    {
        Schema::table('codecycler_teams_teams_users', function($table)
        {
            $table->renameColumn('teamable_type', 'user_class');
            $table->renameColumn('teamable_id', 'user_id');
        });
    }
}
