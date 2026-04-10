<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('modulos', function (Blueprint $table) {
            // 'contenido' = módulo con PDF/material
            // 'examen'    = evaluación con preguntas de opción múltiple
            $table->enum('tipo', ['contenido', 'examen'])
                  ->default('contenido')
                  ->after('descripcion');
        });
    }

    public function down(): void
    {
        Schema::table('modulos', function (Blueprint $table) {
            $table->dropColumn('tipo');
        });
    }
};
