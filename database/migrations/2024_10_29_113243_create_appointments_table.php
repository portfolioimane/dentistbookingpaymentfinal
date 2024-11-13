<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
public function up()
{
    Schema::create('appointments', function (Blueprint $table) {
        $table->id();
        $table->string('name');
        $table->string('email');
        $table->string('phone');
        $table->foreignId('service_id')->constrained()->onDelete('cascade');
        $table->date('date');
        $table->time('start_time');
        $table->time('end_time');
        $table->enum('status', ['pending', 'confirmed', 'completed', 'canceled'])->default('pending');
        $table->enum('payment_method', ['cod', 'paypal', 'stripe'])->nullable();
        $table->enum('payment_status', ['unpaid', 'paid', 'pending'])->default('pending'); // Add 'pending' here
        $table->timestamps();
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('appointments');
    }
};
