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
        Schema::create('phones', function (Blueprint $table) {
            $table->bigIncrements('id');            
            $table->string('number', 20)->unique();           
            $table->string('country_code', 5)->default('57'); 
            $table->string('area_code', 10)->nullable();            
            $table->string('type', 10)->default('mobile'); 
            $table->boolean('is_primary')->default(false);
            $table->string('extension', 10)->nullable();
            $table->text('notes')->nullable();

            // Timestamps con zona horaria 
            $table->timestampsTz();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('phones');
    }
};
