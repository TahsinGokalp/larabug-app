<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('audits', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('type');
            $table->string('auditable_type')->index();
            $table->string('auditable_id')->index();
            $table->text('old')->nullable();
            $table->text('new')->nullable();
            $table->string('user_id')->nullable();
            $table->string('route')->nullable();
            $table->ipAddress('ip_address', 45)->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('audits');
    }
};
