<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddNotificationsEnabledToProjectsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('projects', function (Blueprint $table) {
            $table->boolean('notifications_enabled')->default(true)->after('receive_email');
            $table->boolean('custom_webhook_enabled')->default(false)->after('notifications_enabled');
            $table->boolean('discord_webhook_enabled')->default(false)->after('notifications_enabled');
            $table->boolean('slack_webhook_enabled')->default(false)->after('notifications_enabled');
            $table->boolean('mobile_notifications_enabled')->default(true)->after('notifications_enabled');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('projects', function (Blueprint $table) {
            $table->dropColumn('notifications_enabled');
            $table->dropColumn('custom_webhook_enabled');
            $table->dropColumn('discord_webhook_enabled');
            $table->dropColumn('slack_webhook_enabled');
            $table->dropColumn('mobile_notifications_enabled');
        });
    }
}
