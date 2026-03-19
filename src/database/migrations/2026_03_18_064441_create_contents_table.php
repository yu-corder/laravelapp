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
        Schema::create('contents', function (Blueprint $table) {
            $table->id();
            $table->foreignId('sauna_id')
                ->nullable()
                ->constrained('saunas')
                ->onDelete('cascade');

            $table->string('type')->nullable()->comment('記事種別: facility, column, newsなど');
            $table->string('title')->comment('記事タイトル');
            $table->longText('body')->comment('記事本文');
            $table->string('image_path')->nullable()->comment('サムネイル画像パス');
            $table->boolean('is_public')->default(false)->comment('公開フラグ');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contents');
    }
};
