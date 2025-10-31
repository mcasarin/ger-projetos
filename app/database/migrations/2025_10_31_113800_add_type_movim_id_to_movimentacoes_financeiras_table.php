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
        Schema::table('movimentacoes_financeiras', function (Blueprint $table) {
            $table->foreignId('tipo')
            ->after('descricao')
            ->default(2) // Saída
            ->constrained('type_movim')
            ->onUpdate('cascade')
            ->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('movimentacoes_financeiras', function (Blueprint $table) {
            $table->dropForeign(['tipo']);
            $table->dropColumn('tipo');
        });
    }
};
