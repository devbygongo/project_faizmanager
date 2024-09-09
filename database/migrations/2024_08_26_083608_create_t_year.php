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
        Schema::create('t_year', function (Blueprint $table) {
            $table->id();
            $table->string('year', 100)->unique();
            $table->date('date_start');
            $table->date('date_end');
            $table->boolean('is_current');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('t_year');
    }
};
