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
        Schema::table('phones', function (Blueprint $table) {
            // FK a categories: nullable para no romper datos existentes
            $table->foreignId('category_id')
                  ->nullable()
                  ->constrained('categories')   
                  ->cascadeOnUpdate()
                  ->nullOnDelete();    
            $table->string('barcode')->nullable(); 
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
         Schema::table('phones', function (Blueprint $table) {
            // Primero soltar la FK y luego las columnas
            $table->dropConstrainedForeignId('category_id'); 
            $table->dropColumn('barcode');
        });
    }
};
