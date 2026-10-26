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
        Schema::table('teams', function (Blueprint $table) {
            $drops = [];
            if (Schema::hasColumn('teams', 'position')) {
                $drops[] = 'position';
            }
            if (Schema::hasColumn('teams', 'linkedin_url')) {
                $drops[] = 'linkedin_url';
            }
            if (! empty($drops)) {
                $table->dropColumn($drops);
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('teams', function (Blueprint $table) {
            $table->string('position')->nullable();
            $table->string('linkedin_url')->nullable();
        });
    }
};
