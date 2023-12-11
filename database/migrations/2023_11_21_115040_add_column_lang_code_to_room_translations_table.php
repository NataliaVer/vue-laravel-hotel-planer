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
        Schema::table('room_translations', function (Blueprint $table) {
            $table->string('lang_code', 4)->nullable()->after('room_id');
            $table->foreign('lang_code', 'room_lang_fk')->on('languages')->references('code');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('room_translations', function (Blueprint $table) {
            $table->dropForeign('room_lang_fk');
            $table->dropColumn('lang_code');
        });
    }
};
