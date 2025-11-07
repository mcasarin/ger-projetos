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
            $table->foreignId('type')
            ->after('description')
            ->default(2) // Saída
            ->constrained('type_moviment')
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
            $table->dropForeign(['type']);
            $table->dropColumn('type');
        });
    }
};
