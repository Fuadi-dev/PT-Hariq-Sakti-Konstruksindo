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
        Schema::table('sliders', function (Blueprint $table) {
            $table->dropColumn(['subtitle', 'button_text', 'button_url']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('sliders', function (Blueprint $table) {
            $table->text('subtitle')->nullable()->after('title');
            $table->string('button_text', 100)->nullable()->after('image_path');
            $table->string('button_url')->nullable()->after('button_text');
        });
    }
};
