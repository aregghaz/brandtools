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
        Schema::table('contacts', function (Blueprint $table) {
            $table->string('address')->after('id')->nullable();
            $table->string('phone_1')->after('address')->nullable();
            $table->string('phone_2')->after('phone_1')->nullable();
            $table->string('phone_3')->after('phone_2')->nullable();
            $table->string('whats_up')->after('phone_3')->nullable();
            $table->string('email_1')->after('whats_up')->nullable();
            $table->string('email_2')->after('email_1')->nullable();
            $table->string('contact_telegram')->after('email_2')->nullable();
            $table->string('contact_skype')->after('contact_telegram')->nullable();
            $table->string('contact_viber')->after('contact_skype')->nullable();
            $table->string('contact_whats_up')->after('contact_viber')->nullable();
            $table->string('sub_tiktok')->after('contact_viber')->nullable();
            $table->string('sub_youtube')->after('sub_tiktok')->nullable();
            $table->string('sub_vk')->after('sub_youtube')->nullable();
            $table->string('sub_od')->after('sub_vk')->nullable();
            $table->string('sub_x')->after('sub_od')->nullable();
            $table->string('lang')->after('sub_x')->nullable();
            $table->string('long')->after('lang')->nullable();
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
