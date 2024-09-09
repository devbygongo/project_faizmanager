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
        Schema::create('t_sub_sector', function (Blueprint $table) {
            $table->id();
            $table->string('name', 256);
            // $table->string('sector', 256)->after('name');
            $table->integer('sector');
            $table->string('its_of_incharge', 20)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('t_sub_sector');
    }
};
