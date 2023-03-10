<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('issues', function (Blueprint $table) {
            $table->id();
            $table->string('exception');
            $table->string('line');
            $table->uuid('project_id');
            $table->uuid('exception_id');
            $table->string('status')->nullable();
            $table->json('tags')->nullable();
            $table->timestamp('last_occurred_at')->nullable();
            $table->timestamps();

            $table->index(['project_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('issues');
    }
};
