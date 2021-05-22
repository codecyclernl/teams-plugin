<?php namespace Codecycler\Teams\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableCreateCodecyclerTeamsTeams extends Migration
{
    public function up()
    {
        Schema::create('codecycler_teams_teams', function($table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id')->unsigned();
            $table->timestamp('created_at')->nullable();
            $table->timestamp('updated_at')->nullable();
            $table->timestamp('deleted_at')->nullable();
            $table->string('code')->nullable();
            $table->string('name')->nullable();
            $table->integer('owner_id')->nullable();
            $table->text('theme_options')->nullable();
            $table->text('properties')->nullable();
            $table->smallInteger('is_active')->nullable();
            $table->text('notes')->nullable();
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('codecycler_teams_teams');
    }
}
