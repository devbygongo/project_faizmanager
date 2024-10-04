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
        Schema::create('t_jamiat', function (Blueprint $table) {
            $table->id();
            $table->string('name', 256)->unique();
            $table->string('mobile', 20)->unique();
            $table->string('email', 256)->unique();
            $table->integer('package');
            // as it don't support `length`, it can store upto `65,535 characters for TEXT type in MySQL`
            $table->text('billing_address')->nullable();
            $table->string('billing_contact', 150)->nullable();
            $table->string('billing_email', 150)->nullable();
            $table->string('billing_phone', 20)->nullable();
            $table->date('last_payment_date')->nullable();
            $table->float('last_payment_amount', 256)->nullable();
            $table->date('payment_due_date')->nullable();
            $table->date('validity');
            // as it don't support `length`, it can store upto `65,535 characters for TEXT type in MySQL`
            $table->text('notes')->nullable();
            $table->longText('logs')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('t_jamiat');
    }
};
