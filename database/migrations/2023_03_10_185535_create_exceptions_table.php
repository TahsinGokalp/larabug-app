<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('exceptions', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('host')->nullable();
            $table->string('method')->nullable();
            $table->text('fullUrl')->nullable();
            $table->text('exception')->nullable();
            $table->string('environment')->nullable();
            $table->text('error')->nullable();
            $table->string('line')->nullable();
            $table->string('file')->nullable();
            $table->json('storage')->nullable();
            $table->string('file_type')->default('php');
            $table->string('class')->nullable();
            $table->string('status')->nullable();
            $table->boolean('mailed')->default(false);
            $table->text('additional')->nullable();
            $table->timestamp('published_at')->nullable();
            $table->string('publish_hash', 15)->index()->nullable();
            $table->string('previousUrl')->nullable();
            $table->string('publish_password')->nullable();
            $table->longText('executor')->nullable();
            $table->timestamp('snooze_until')->nullable();
            $table->string('project_version')->nullable();
            $table->uuid('issue_id')->nullable();
            $table->foreignUuid('project_id')->references('id')->on('projects');
            $table->timestamps();

            $table->index([
                'created_at',
                'project_id',
            ]);
            $table->index(['issue_id']);
            $table->index(['project_id', 'id']);
            $table->index('status');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('exceptions');
    }
};
