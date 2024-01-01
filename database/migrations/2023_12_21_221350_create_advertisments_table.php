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
        Schema::create('advertisments', function (Blueprint $table) {
            $table->id();
            $table->string("title");
            $table->text("descreption");
            $table->string("imgUrl");
            $table->double("discount")->nullable();
            $table->double("previousPrice")->nullable();
            $table->double("priceNow")->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('advertisments');
    }
};
