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
        Schema::create('t_hub', function (Blueprint $table) {
            $table->id();
            $table->string('name', 256);
            $table->string('year', 100);
            $table->string('event', 100);
            $table->float('hub');
            $table->float('prev_paid');
            $table->integer('added_by');
            $table->timestamp('last_modified');
            $table->enum('short_closed', ['0', '1']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('t_hub');
    }
};
