<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

class AddPreviousUrlToExceptionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('exceptions', function ($table) {
            $table->string('previousUrl')->after('fullUrl')->nullable();
            $table->string('publish_password')->after('project_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('exceptions', function ($table) {
            $table->dropColumn('previousUrl');
            $table->dropColumn('publish_password');
        });
    }
}
