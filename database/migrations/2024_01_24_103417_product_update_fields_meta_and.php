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
        Schema::table('products', function (Blueprint $table) {
            $table->longtext('description')->nullable();
            $table->mediumText("meta_title")->nullable();
            $table->mediumText("meta_desc")->nullable();
            $table->mediumText("meta_key")->nullable();
            $table->string("image", 200)->nullable();
            $table->string("sku", 150)->nullable();
            $table->unsignedBigInteger("quantity")->nullable();
            $table->tinyInteger("status")->default(0);
            $table->unsignedBigInteger('product_id')->nullable();
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
