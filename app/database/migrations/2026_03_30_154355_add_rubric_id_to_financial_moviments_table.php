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
        Schema::table('financial_moviments', function (Blueprint $table) {
            $table->foreignId('rubric')
            ->after('type')
            ->default(1) // Ajuda de Curto
            ->constrained('rubrics')
            ->onUpdate('cascade')
            ->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('financial_moviments', function (Blueprint $table) {
            $table->dropForeign(['rubric']);
            $table->dropColumn('rubric');
        });
    }
};