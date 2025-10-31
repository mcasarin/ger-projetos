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
            $table->string('name');
            $table->text('description')->nullable();
            $table->decimal('initial_budget', 15, 2);
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            //$table->integer('status')->default(0); -- foreign key moved in another migration
            $table->string('project_manager')->nullable();
            $table->decimal('total_revenues', 15, 2)->default(0);
            $table->decimal('total_expenses', 15, 2)->default(0);
            $table->integer('owner_id');
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent()->useCurrentOnUpdate();
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
