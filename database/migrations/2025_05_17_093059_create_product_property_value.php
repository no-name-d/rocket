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
        Schema::create('product_property_value', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('property_value_id');
            $table->foreign('property_value_id')
                ->references('id')
                ->on('property_value');
            $table->unsignedBigInteger('product_id');
            $table->foreign('product_id')
                ->references('id')
                ->on('product');
            $table->timestamps();

            $table->index('property_value_id');
            $table->index('product_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_property_value');
    }
};
