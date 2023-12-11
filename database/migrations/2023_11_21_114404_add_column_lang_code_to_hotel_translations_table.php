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
        Schema::table('hotel_translations', function (Blueprint $table) {
            $table->string('lang_code', 4)->nullable()->after('hotel_id');
            $table->foreign('lang_code', 'hotel_lang_fk')->on('languages')->references('code');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('hotel_translations', function (Blueprint $table) {
            $table->dropForeign('hotel_lang_fk');
            $table->dropColumn('lang_code');
        });
    }
};
