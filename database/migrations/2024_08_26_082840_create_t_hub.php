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
            $table->string('name', 256)->after('id');
            $table->string('year', 100)->after('name');
            $table->string('event', 100)->after('year');
            $table->float('hub')->after('event');
            $table->float('prev_paid')->after('hub');
            $table->integer('added_by')->after('prev_paid');
            $table->timestamp('last_modified')->after('added_by');
            $table->enum('short_closed', ['0', '1'])->after('last_modified');
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
