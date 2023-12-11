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
        Schema::create('room_translations', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->double('price');
            $table->text('description')->nullable();
            $table->string('amenities')->nullable(); //(джакузі, балкон, wi-fi, телебачення ...)
            $table->integer('count_bed')->nullable();
            $table->string('count_seats_in_bed')->nullable();//
            $table->string('count_rooms');//загальна кількість (буде вираховуватися вільна кількість кімнат)

            $table->unsignedBigInteger('room_id')->nullable();
            $table->index('room_id', 'room_translation_room_idx');
            $table->foreign('room_id', 'room_translation_room_fk')->on('rooms')->references('id');
            $table->unsignedBigInteger('language_id')->nullable();
            $table->foreign('language_id', 'room_translation_language_fk')->on('languages')->references('id');

            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('room_translations');
    }
};
