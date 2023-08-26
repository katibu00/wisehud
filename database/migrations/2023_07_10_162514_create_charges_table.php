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
        Schema::create('charges', function (Blueprint $table) {
            $table->id();
            $table->double('charges_per_chat');
            $table->double('welcome_bonus')->default(0);
            $table->double('referral_bonus')->default(0);
            $table->double('whatsapp_group_link')->nullable();
            $table->string('funding_charges_description')->nullable();
            $table->double('funding_charges_amount')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('charges');
    }
};
