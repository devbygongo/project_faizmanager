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
            $table->string('name', 256);
            $table->string('mobile', 20);
            $table->string('email', 256)->nullable();
            $table->string('package_details', 256)->nullable();
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
