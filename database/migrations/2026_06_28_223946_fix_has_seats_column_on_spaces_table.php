<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasColumn('spaces', 'has_seats')) {

            Schema::table('spaces', function (Blueprint $table) {
                $table->boolean('has_seats')->default(false);
            });

        }

        DB::table('spaces')
            ->whereIn('name', ['Auditorio A', 'Auditorio B'])
            ->update([
                'has_seats' => true,
            ]);
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
