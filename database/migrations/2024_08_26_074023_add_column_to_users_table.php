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
        Schema::table('users', function (Blueprint $table) {
            //
            $table->integer('family_id')->unique()->after('remember_token');
            $table->string('title', 100)->after('family_id')->nullable();
            $table->string('its', 10)->unique()->after('title')->nullable();
            $table->string('hof_its', 10)->after('its')->nullable();
            $table->string('family_its_id', 10)->after('hof_its')->nullable();
            $table->string('mobile', 13)->after('family_its_id ')->nullable();
            $table->string('address', 256)->after('mobile')->nullable();
            $table->string('building', 100)->after('address')->nullable();
            $table->string('flat_no', 10)->after('building')->nullable();
            $table->string('lattitude', 100)->after('flat_no')->nullable();
            $table->string('longitude ', 100)->after('lattitude')->nullable();
            $table->string('gender', 10)->after('longitude')->nullable();
            $table->date('date_of_birth')->after('gender')->nullable();
            $table->string('folio_no', 100)->after('date_of_birth')->nullable();
            $table->string('sector', 100)->after('folio_no')->nullable();
            $table->string('sub_sector', 100)->after('sector')->nullable();
            $table->enum('thali_status ', ['taking', 'not_taking', 'once_a_week', 'other_centre'])->after('sub_sector')->nullable();
            $table->enum('status', ['active', 'in_active'])->after('thali_status')->nullable();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            //
        });
    }
};
