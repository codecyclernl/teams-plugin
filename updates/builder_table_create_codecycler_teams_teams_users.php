<?php namespace Codecycler\Teams\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableCreateCodecyclerTeamsTeamsUsers extends Migration
{
    public function up()
    {
        Schema::create('codecycler_teams_teams_users', function($table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id')->unsigned();
            $table->timestamp('created_at')->nullable();
            $table->timestamp('updated_at')->nullable();
            $table->timestamp('deleted_at')->nullable();
            $table->integer('team_id')->nullable();
            $table->string('user_class')->nullable();
            $table->integer('user_id')->nullable();
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('codecycler_teams_teams_users');
    }
}
