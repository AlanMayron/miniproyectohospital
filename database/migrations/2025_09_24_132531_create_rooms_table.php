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
        Schema::create('rooms', function (Blueprint $table) {
    $table->id();                        // BIGINT autoincremental (PK)
    $table->string('name', 120)->unique(); // VARCHAR(120) + índice único
    $table->integer('capacity');         // INTEGER (en PG no existe “unsigned”)
    $table->string('status', 20);        // VARCHAR(20)
    $table->timestamps();                // created_at y updated_at (TIMESTAMP)

    // Reglas a nivel BD (PG): protegen los datos aunque la app falle
    #$table->check("capacity > 0"); 
    #$table->check("status IN ('disponible','ocupada','mantenimiento')");
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rooms');
    }
};
