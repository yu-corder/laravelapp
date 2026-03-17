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
        Schema::table('t_totonoi_histories', function (Blueprint $table) {
            $table->integer('price')->nullable()->after('sauna_id')->comment('利用料金');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('t_totonoi_histories', function (Blueprint $table) {
            $table->dropColumn('price');
        });
    }
};
