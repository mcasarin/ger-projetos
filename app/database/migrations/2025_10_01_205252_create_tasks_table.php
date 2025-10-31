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
        Schema::create('tasks', function (Blueprint $table) {
            $table->id();
            $table->string('titutititleltelo');
            $table->text('description');
            $table->integer('owner_id');
            $table->dateTime('start_date');
            $table->dateTime('due_date');
            // $table->integer('status'); -- foreign key moved to another migration
            // $table->unsignedBigInteger('project_id'); -- foreign key moved to another migration
            // $table->foreign('project_id')->references('id')->on('projects')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tasks');
    }
};
