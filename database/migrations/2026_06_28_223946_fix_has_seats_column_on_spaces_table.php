<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasColumn('spaces', 'has_seats')) {

            Schema::table('spaces', function (Blueprint $table) {

                $table->boolean('has_seats')
                      ->default(false);

            });

        }
    }

    public function down(): void
    {
        if (Schema::hasColumn('spaces', 'has_seats')) {

            Schema::table('spaces', function (Blueprint $table) {

                $table->dropColumn('has_seats');

            });

        }
    }
};
