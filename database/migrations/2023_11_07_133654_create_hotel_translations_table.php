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
        Schema::create('hotel_translations', function (Blueprint $table) {
            $table->id();
            $table->string('hotel_name');
            $table->string('country');
            $table->string('city');
            $table->string('settlement');
            $table->string('street');
            $table->string('number_house');
            $table->string('phone');
            $table->string('aditional_services');
            $table->text('description');
            $table->string('time_of_settlement',15);
            $table->string('time_of_eviction',15);

            $table->unsignedBigInteger('hotel_id')->nullable();
            $table->index('hotel_id', 'hotel_translation_hotel_idx');
            $table->foreign('hotel_id', 'hotel_translation_hotel_fk')->on('hotels')->references('id');
            $table->unsignedBigInteger('language_id')->nullable();
            $table->foreign('language_id', 'hotel_translation_language_fk')->on('languages')->references('id');

            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hotel_translations');
    }
};
