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
        Schema::table('categories', function (Blueprint $table) {
            $table->string('description')->nullable();
            $table->string("meta_title", 150)->nullable();
            $table->string("meta_desc", 150)->nullable();
            $table->string("meta_key", 150)->nullable();
            $table->string("image", 150)->nullable();
            $table->tinyInteger("status")->default(0);
            $table->unsignedBigInteger('category_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
