<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('projects', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('title')->nullable();
            $table->string('url')->nullable();
            $table->string('key')->nullable();
            $table->text('description')->nullable();
            $table->timestamp('last_error_at')->nullable();
            $table->boolean('notifications_enabled')->default(true);
            $table->boolean('receive_email')->default(false);
            $table->boolean('telegram_notification_enabled')->default(false);
            //TODO : Check and delete
            $table->string('total_exceptions')->default(0);
            $table->timestamps();
            $table->softDeletes();

            $table->index([
                'created_at',
                'key',
            ]);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('projects');
    }
};
