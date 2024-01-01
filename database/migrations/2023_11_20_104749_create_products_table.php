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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->String("title");
            $table->String("imageUrl1");
            $table->String("imageUrl2")->nullable();
            $table->String("imageUrl3")->nullable();
            $table->String("imageUrl4")->nullable();
            $table->String("imageUrl5")->nullable();
            $table->text("description");
            $table->double("price",10,2);
            $table->integer("quantityInStock")->default(0);
            $table->integer("categoryId");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
