<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('issues', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('exception');
            $table->string('line');
            $table->foreignUuid('project_id')->references('id')->on('projects');
            $table->foreignUuid('exception_id')->references('id')->on('exceptions');
            $table->string('status')->nullable();
            $table->json('tags')->nullable();
            $table->timestamp('last_occurred_at')->nullable();
            $table->timestamps();

            $table->index(['project_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('issues');
    }
};
