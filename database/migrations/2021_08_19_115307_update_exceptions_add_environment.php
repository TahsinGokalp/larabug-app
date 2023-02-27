<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateExceptionsAddEnvironment extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('exceptions', function (Blueprint $table) {
            $table->string('environment')->nullable()->after('exception');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('exceptions', function (Blueprint $table) {
            $table->dropColumn('environment');
        });
    }
}
