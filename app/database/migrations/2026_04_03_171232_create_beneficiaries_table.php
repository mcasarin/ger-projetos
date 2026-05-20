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
        Schema::create('beneficiaries', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('document')->unique(); // CPF/CNPJ único
            $table->string('document_type')->default('cpf'); // 'cpf' ou 'cnpj'
            $table->timestamps();
        });

        // Adiciona foreign key na tabela moviments
        Schema::table('financial_moviments', function (Blueprint $table) {
            $table->foreignId('beneficiary_id')->nullable()->constrained()->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('moviments', function (Blueprint $table) {
            $table->dropForeign(['beneficiary_id']);
            $table->dropColumn('beneficiary_id');
        });
        Schema::dropIfExists('beneficiaries');
    }
};
