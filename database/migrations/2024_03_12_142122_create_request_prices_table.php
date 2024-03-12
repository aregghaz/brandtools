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
        Schema::create('request_prices', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('lastName');
            $table->string('phone');
            $table->string('email');
            $table->string('company');
            $table->string('ihh');
            $table->string('kpp');
            $table->string('bik');
            $table->string('pc');
            $table->string('address');
            $table->longText('notes')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('request_prices');
    }
};
