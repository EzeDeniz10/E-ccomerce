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
    Schema::create('suppliers', function (Blueprint $table) {
        $table->id();
        $table->string('name'); // Nombre del proveedor o empresa (ej: Wander, Mayorista XYZ)
        $table->string('email')->nullable();
        $table->string('phone')->nullable();
        $table->string('type')->default('mayorista'); // mayorista, artesano, consignacion, etc.
        $table->timestamps();
    });
}
    public function down(): void
    {
        Schema::dropIfExists('suppliers');
    }
};
