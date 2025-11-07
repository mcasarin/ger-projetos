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
        Schema::table('projects', function (Blueprint $table) {
            // Cria a coluna BIGINT (unsigned) e a define como opcional (nullable)
            // constrained('projects') cria a FK que referencia a tabela 'projects' (ela mesma)
            $table->foreignId('parent_id')->nullable()->constrained('projects')->after('project_manager');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('projects', function (Blueprint $table) {
            // É importante remover primeiro a chave estrangeira (FK)
            $table->dropConstrainedForeignId('parent_id'); 
            $table->dropColumn('parent_id');
        });
    }
};
