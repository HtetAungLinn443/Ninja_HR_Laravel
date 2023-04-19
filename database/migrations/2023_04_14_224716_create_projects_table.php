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
        Schema::create('projects', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->longText('description')->nullable();
            $table->text('image')->nullable();
            $table->text('files')->nullable();
            $table->date('start_of_date')->nullable();
            $table->date('deatline')->nullable();
            $table->enum('priority', ['height', 'middel', 'low']);
            $table->enum('status', ['pending', 'in_progress', 'complete']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('projects');
    }
};
