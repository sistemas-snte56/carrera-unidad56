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
        Schema::create('participantes', function (Blueprint $table) {
            $table->id();

            $table->string('folio')->unique();
            $table->string('acuse_token')->unique();
            $table->unsignedInteger('numero_corredor')->unique();

            $table->string('nombre');
            $table->string('apellido_paterno');
            $table->string('apellido_materno')->nullable();

            $table->date('fecha_nacimiento');

            $table->string('rama');
            $table->string('distancia');
            $table->string('tipo_corredor');

            $table->foreignId('delegacion_id')
                ->nullable()
                ->constrained('delegaciones')
                ->nullOnDelete();

            $table->string('correo');
            $table->string('telefono');

            $table->string('ine_path');
            $table->string('voucher_path');

            $table->string('estatus')->default('pendiente');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('participantes');
    }
};
