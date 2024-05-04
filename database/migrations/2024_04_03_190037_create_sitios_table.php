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
        Schema::create('sitios', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->binary('imagen');
            $table->text('descripcion');
            $table->string('ubicacion');
            $table->double('latitude', 10, 6); // Campo de latitud con precisión de 10 y escala de 6
            $table->double('longitude', 10, 6); // Campo de longitud con precisión de 10 y escala de 6
            $table->boolean('favorito')->default(false);
            $table->unsignedBigInteger('id_categoria');
            $table->foreign('id_categoria')->references('id')->on('categorias')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sitios');
    }
};
